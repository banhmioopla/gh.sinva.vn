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
                        <form action="" class="col-md-12" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6 offset-md-3">
                                    <p class="mb-2 mt-4 font-weight-bold text-danger">Vui lòng chọn mã phòng</p>
                                    <select name="room_id" required id="" class="form-control">
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
                                    <input type="file" name="files[]" multiple class="filestyle" data-buttontext="Select file"
                                           data-btnClass="btn-light">
                                    <p class="text-success p-2 bg-dark mt-2 text-center" id="upload-msg"> 0 ảnh được chọn</p>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <button type="submit" class="btn btn-success col-md-2 offset-md-5">Upload <i class="mdi mdi-cloud-upload"></i></button>
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
    });
</script>