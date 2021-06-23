<?php
$check_consultant_booking = false;
if(isYourPermission('ConsultantBooking', 'show', $this->permission_set)){
    $check_consultant_booking = true;
}

$check_create_promotion = false;
if(isYourPermission('ApartmentPromotion', 'create', $this->permission_set)){
    $check_create_promotion = true;
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
                            <li class="breadcrumb-item"><a href="#">Highdmin</a></li>
                            <li class="breadcrumb-item"><a href="#">Extra Pages</a></li>
                            <li class="breadcrumb-item active">Gallery</li>
                        </ol>
                    </div>
                    <h2 class="text-success font-weight-bold">Upload Ảnh Dự Án: <i><?= $apartment['address_street'] ?></i>
                    </h2>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center"><?php $this->load->view('components/list-navigation'); ?></div>
        </div>

        <div class="row">
            <div class="col-12">
                <?php if($this->session->has_userdata('fast_notify')) {
                    $flash_mess = $this->session->flashdata('fast_notify')['message'];
                    $flash_status = $this->session->flashdata('fast_notify')['status'];
                    ?>
                    <div class="alert alert-<?= $flash_status ?> alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <?= $flash_mess ?>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="col-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center">
                                <?php if($check_create_promotion): ?>
                                    <a class="" href="/admin/list-apartment-promotion?apartment-id=290"><button class="btn btn-success"><i class="mdi mdi-gift"></i> <span class="d-none d-md-inline">Cập Nhật Ưu Đãi</span></button></a>
                                <?php endif; ?>
                                <?php if($check_consultant_booking): ?>
                                    <a href="/admin/create-new-consultant-booking?apartment-id=<?= $apartment['id'] ?>&district-code=<?= $apartment['district_code'] ?>&mode=create"><button class="btn btn-success"><i class="mdi mdi-car-hatchback"></i> <span class="d-none d-md-inline">Book Phòng</span></button></a>
                                <?php endif; ?>
                                <a href="/admin/room/show-create?apartment-id=<?= $apartment['id'] ?>"><button class="btn btn-danger">Cập Nhật T.Tin Phòng <i class="mdi mdi-cloud-upload"></i></button></a>
                                <a href="/admin/profile-apartment?id=<?= $apartment['id'] ?>"><button class="btn btn-danger mt-md-0 mt-1">Cập Nhật T.Tin Dịch Vụ</button></a>
                                <div class="text-center text-success"><small><?= $apartment['address_street'] ?></small></div>
                            </div>

                        </div>

                        <div class="form-group col-md-6 offset-md-3 mt-md-5 mt-2">
                            <strong class="col-form-strong text-primary">Đi Đến Dự Án Khác</strong>
                            <select id="apartment_update_ready" class="form-control">
                                <option value="">Cập Nhật Dự Án Khác</option>
                                <?php foreach ($list_apm as $apm): ?>
                                    <option value="<?= $apm['id'] ?>">Q.<?= $apm['district_code'] . ' ' . $apm['address_street'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <form action="" class="col-md-12" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6 offset-md-3">
                                    <p class="mb-2 mt-4 font-weight-bold text-danger">Vui lòng chọn mã phòng</p>
                                    <select name="room_id[]" required id="" class="form-control select2-multiple" multiple="multiple">
                                        <option value="">Vui lòng chọn mã phòng...</option>
                                        <?php foreach ($cb_room as $index => $room): ?>
                                            <option value="<?= $room['value'] ?>"> <?= $room['text'] ?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="form-group col-md-6 offset-md-3">
                                    <p class="mb-2 mt-4 font-weight-bold text-danger">Vui Lòng Chọn Ảnh Từ Máy</p>
                                    <input type="file" name="files[]" required multiple class="filestyle" data-buttontext="Select file"
                                           data-btnClass="btn-light">
                                    <p class="text-success p-2 bg-dark mt-2 text-center" id="upload-msg"> 0 ảnh được chọn</p>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-md-2 offset-md-5 text-center">
                                    <button type="submit" class="btn btn-success">Upload <i class="mdi mdi-cloud-upload"></i></button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->

    </div> <!-- end container -->
</div>

<script>
    commands.push(function() {
        $('select').select2();
        $('input[type=file]').change(function () {
            var files = $(this)[0].files;
            $('#upload-msg').text(files.length + ' ảnh được chọn.');
            console.log(files.length);
        });

        $('#apartment_update_ready').change(function () {
            window.location = '/admin/apartment/upload-img?apartment_id='+$(this).val();
        });
    });
</script>