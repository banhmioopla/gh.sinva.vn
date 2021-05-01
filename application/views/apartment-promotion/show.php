<div class="wrapper">
<div class="sk-wandering-cubes" style="display:none" id="loader">
    <div class="sk-cube sk-cube1"></div>
    <div class="sk-cube sk-cube2"></div>
</div>
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
                    <h2 class="font-weight-bold text-danger">Danh Sach Chương Trình Ưu Đãi: <?= $apartment['address_street'] ?> </h2>
                </div>
            </div>
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
                    <table id="table-district" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Tiêu Đề</th>
                            <th>Mô Tả</th>
                            <th class="text-center">Ngày Bắt Đầu</th>
                            <th class="text-center">Ngày Kết Thúc</th>
                            <th class="text-center">Trạng Thái</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach($list_promotion as $row ): ?>
                            <tr>
                                <td>
                                    <div class="district-name" 
                                        data-pk="<?= $row['id'] ?>" 
                                        data-name="title">
                                            <?= $row['title'] ?>
                                    </div>
                                </td>
                                <td><?= $row['description'] ?></td>
                                <td><?= date('d/m/Y',$row['start_time']) ?></td>
                                <td><?= date('d/m/Y',$row['end_time']) ?></td>
                                <td><i>-</i></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end row -->

        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card-box">
                    <h4 class="font-weight-bold text-danger">Thêm Mới</h4>
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
                            <div class="col-8 offset-4">
                                <button type="submit" class="btn btn-custom waves-effect waves-light">
                                    Thêm mới
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div> <!-- end container -->
</div>
<!-- end wrapper -->
<script type="text/javascript">
    commands.push(function() {
        $(document).ready(function() {
            $('table').dataTable();
            $('.datepicker').datepicker({
                format: "dd-mm-yyyy"
            });
        });
    });
</script>