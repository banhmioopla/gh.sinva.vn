<?php
$check_create_promotion = false;
if(isYourPermission('ApartmentPromotion', 'create', $this->permission_set)){
    $check_create_promotion = true;
}
$check_consultant_booking = false;
if(isYourPermission('ConsultantBooking', 'show', $this->permission_set)){
    $check_consultant_booking = true;
}

?>

<div class="wrapper">
    <div class="container">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">test</a></li>
                            <li class="breadcrumb-item"><a href="#">Extra Pages</a></li>
                            <li class="breadcrumb-item active">Starter</li>
                        </ol>
                    </div>
                    <h2 class="font-weight-bold text-danger">Danh Sách Chương Trình Ưu Đãi: <?= $apartment['address_street'] ?> </h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center"><?php $this->load->view('components/list-navigation'); ?></div>
        </div>

        <!-- end page title end breadcrumb -->
        <?php if($this->session->has_userdata('fast_notify')) {
                $flash_mess = $this->session->flashdata('fast_notify')['message'];
                $flash_status = $this->session->flashdata('fast_notify')['status'];
                unset($_SESSION['fast_notify']);
            }  
        ?>
        <div class="district-alert"></div>
        <div class="row">
            <div class="col-12">
                <div class="card-box table-responsive">
                    <div class="text-center">
                        <?php if($check_consultant_booking): ?>
                            <a href="/admin/create-new-consultant-booking?apartment-id=<?= $apartment['id'] ?>&district-code=<?= $apartment['district_code'] ?>&mode=create"><button class="btn btn-success"><i class="mdi mdi-car-hatchback"></i> <span class="d-none d-md-inline">Book Phòng</span></button></a>
                        <?php endif; ?>

                        <a href="/admin/apartment/upload-img?apartment_id=<?= $apartment['id'] ?>">
                            <button type="button" class="btn btn-danger"><i class="mdi mdi-cloud-upload"></i> Upload Ảnh Mới</button></a>

                        <a href="/admin/room/show-create?apartment-id=<?= $apartment['id'] ?>"><button class="btn btn-danger">Cập Nhật T.Tin Phòng </button></a>
                        <a href="/admin/profile-apartment?id=<?= $apartment['id'] ?>"><button class="btn btn-danger mt-md-0 mt-1">Cập Nhật T.Tin Dịch Vụ</button></a>
                        <div class="text-center text-success"><small><?= $apartment['address_street'] ?></small></div>
                    </div>
                    <h4 class="font-weight-bold text-danger">Danh Sách Chương Trình Ưu Đãi</h4>
                    <table id="table-district" class="table table-bordered">
                        <thead class="table-dark">
                        <tr>
                            <th class="text-center">Mô Tả</th>
                            <th class="text-center">Bắt Đầu</th>
                            <th class="text-center">Kết Thúc</th>
                            <th class="text-center">Tùy Chọn</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach($list_promotion as $row ):
                                $edit = '-';
                                if(isYourPermission('ApartmentPromotion', 'showEdit', $this->permission_set)) {
                                    $edit = '<a href="/admin/apartment-promotion/show-edit?id='.$row['id'].'" class="font-weight-bold">Chỉnh Sửa</a>';
                                }
                                ?>
                            <tr>
                                <td style="width: 55%;">
                                    <h5><?= $row['title'] ?></h5>
                                    <?= $row['description'] ?>
                                </td>
                                <td >
                                    <div class="promotion-start_time"
                                         data-pk="<?= $row['id'] ?>"
                                         data-value="<?= date('d/m/Y',$row['start_time']) ?>"
                                         data-name="start_time">
                                        <?= date('d/m/Y',$row['start_time']) ?>
                                    </div>
                                    </td>
                                <td>
                                    <div class="promotion-end_time"
                                         data-pk="<?= $row['id'] ?>"
                                         data-value="<?= date('d/m/Y',$row['end_time']) ?>"
                                         data-name="end_time">
                                        <?= date('d/m/Y',$row['end_time']) ?>
                                    </div>
                                    </td>
                                <td><?= $edit ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end row -->

        <?php if($check_create_promotion): ?>
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card-box">
                    <h4 class="font-weight-bold text-danger">Tạo Ưu Đãi Mới</h4>
                    <form role="form" method="post" action="<?= base_url()?>admin/create-apartment-promotion">
                        <input type="hidden" name="apartment_id" value="<?= $apartment['id'] ?>">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-12 col-form-label">Tiêu Đề<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <input type="text" required class="form-control"
                                       id="title" name="title" placeholder="Tiêu Đề">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-12 col-form-label">Mô Tả<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <textarea required class="form-control"
                                          id="description" name="description" placeholder="Mô Tả"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="start_time" class="col-md-4 col-12 col-form-label">Ngày Bắt Đầu<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <input type="text" required class="form-control datepicker"
                                       id="start_time" name="start_time" placeholder="Ngày Bắt Đầu">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="end_time" class="col-md-4 col-12 col-form-label">Ngày Kết Thúc<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <input type="text" required class="form-control datepicker"
                                       id="end_time" name="end_time" placeholder="Ngày Kết Thúc">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col text-center">
                                <button type="submit" class="btn btn-danger waves-effect waves-light">
                                    Thêm mới
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div> <!-- end container -->
</div>
<!-- end wrapper -->
<script type="text/javascript">
    commands.push(function() {
        $(document).ready(function() {
            $('table').dataTable({
                "fnDrawCallback": function() {
                    $('.promotion-start_time, .promotion-end_time').editable({
                        type: 'combodate',
                        template:"D / MM / YYYY",
                        format:"DD-MM-YYYY",
                        viewformat:"DD-MM-YYYY",
                        combodate: {
                            firstItem: 'name',
                            maxYear: '2023',
                            minYear: '2021'
                        },
                        inputclass: 'form-control-sm',
                        url: '<?= base_url()."admin/update-apartment-promotion-editable" ?>'
                    });

                    $('.datepicker').datepicker({
                        format: "dd-mm-yyyy"
                    });
                }
            });

        });
    });
</script>