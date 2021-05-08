<?php
$role_delete = ['product-manager', 'customer-care', 'business-manager'];
$check_modify = false;
if (isYourPermission($this->current_controller, 'update', $this->permission_set)) {
    $check_modify = true;
}

$check_commission_rate = false;
if(isYourPermission('Apartment', 'showCommmissionRate', $this->permission_set)){
    $check_commission_rate = true;
}
$view_service = [
    'check_commission_rate' => $check_commission_rate,
    'apartment' => $apartment_model
];
?>


<?php
include VIEWPATH . 'functions.php';
?>
<style>
    .portfolioFilter a.current{
        background: #fccf51;
        border-bottom: solid red 4px;
    }
    .portfolioFilter a:hover {
        background-color: #fccf51;
    }
</style>


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
                    <h2 class="text-danger font-weight-bold">Kho Ảnh: <i><?= $apartment_model['address_street'] ?></i>
                        </h2>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card-box bg-danger widget-flat border-danger text-white">
                                <i class="mdi mdi-folder-multiple-image"></i>
                                <h3 class="m-b-10">250</h3>
                                <p class="text-uppercase m-b-5 font-13 font-600">
                                    Số Lượng Hình Ảnh
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-box bg-danger widget-flat border-danger text-white">
                                <i class="mdi mdi-folder-multiple-image"></i>
                                <h3 class="m-b-10">20/30</h3>
                                <p class="text-uppercase m-b-5 font-13 font-600">
                                    Tỉ Lệ Phòng Trống Có Hình
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <a href="/admin/apartment/upload-img?apartment_id=<?= $apartment_model['id'] ?>" class="col-md-4 offset-md-4 btn-danger btn text-center">Upload Ảnh Mới <i class="mdi mdi-cloud-upload"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <!-- SECTION FILTER
                ================================================== -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 ">
                <div class="portfolioFilter text-center gallery-second">
                    <a href="#" data-filter="*" class="current bg-light">Tất cả</a>
                    <?php
                    $i = 0;
                    foreach ($list_room_code as $room):
                        $status = '';
                        $status_text = ' - <i class="text-dark">' . view_money_format($room['price'], 1) . '</i>';
                        if ($room['status'] == 'Available') {
                            $status .= ' text-success';
                        } else {
                            $status .= ' text-dark';
                        }

                        if ($room['time_available'] > 0) {
                            $status_text .= ' <span class="text-warning"> ' . date('d/m/Y', $room['time_available']) . '</span>';
                        }

                        ?>
                        <a href="#" class="font-weight-bold <?= $status ?>"
                           id="roomcode-<?= $room['id'] ?>"
                           data-filter=".roomcode-<?= $room['id'] ?>"
                           data-room-id="<?= $room['id'] ?>">
                            <?= $room['code'] . $status_text ?>
                        </a>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>

        <form name="form-download" id="form-download" action="/admin/download-image-apartment" method="post">
            <div class="port">
                <div class="portfolioContainer">
                    <?php if ($list_img): ?>

                        <?php foreach ($list_img as $img): ?>
                            <div class="col-sm-6 col-md-2
                            <?= !empty($img['room_id']) ? 'roomcode-' . $img['room_id'] : '' ?> image-item">
                                <?php
                                $imgStatus = $img['status'] == 'Pending' ? 'warning' : '';

                                if (!in_array($img['file_type'], ['mp4', 'mov'])):
                                    ?>
                                    <input type="hidden" name="list_id[]"
                                           value="<?= $img['id'] ?>">
                                    <div class="portfolio-masonry-box"
                                         data-img-id="<?= $img['id'] ?>">
                                        <a href="<?= base_url() ?>media/apartment/<?= $img['name'] ?>"
                                           class="image-popup">
                                            <div class="portfolio-masonry-img border border-<?= $imgStatus ?>"
                                                 style="border-width:3px">
                                                <img src="<?= base_url() ?>media/apartment/<?= $img['name'] ?>"
                                                     class="thumb-img img-fluid"
                                                     alt="work-thumbnail">
                                            </div>
                                        </a>
                                        <div class="portfolio-masonry-detail">
                                            <h4 class="font-18"><?= date('d-m-Y', $img['time_insert']) ?></h4>
                                            <div class="d-flex justify-content-center">
                                                <?php if ($check_modify): ?>
                                                    <button type="button" data-img-id="<?= $img['id'] ?>"
                                                            class="btn m-1 btn-sm
                                                            btn-outline-danger btn-rounded
                                                            waves-light waves-effect
                                                            delete-img">
                                                        <i class="mdi mdi-delete"></i>
                                                    </button>
                                                <?php endif; ?>

                                                <a data-img-id="<?= $img['id'] ?>" class="btn m-1 btn-sm btn-outline-warning
                                                   btn-rounded waves-light waves-effect
                                                   download-img"
                                                   download="<?= $apartment_model['address_street'] . '.' . $img['file_type'] ?>"
                                                   href="<?= base_url() ?>media/apartment/<?= $img['name'] ?>">
                                                    <i class="mdi mdi-cloud-download"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 text-right border border-bottom">
                                                <div class="checkbox checkbox-success p-2">
                                                    <input id="checkbox-<?= $img['id'] ?>" value="<?= $img['id'] ?>" name="post_imgs" type="checkbox">
                                                    <label for="checkbox-<?= $img['id'] ?>">
                                                        Chọn Ảnh
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                <?php else: ?>
                                    <div class="card-box m-1 shadow"
                                         id="video-box-<?= $img['id'] ?>">
                                        <video width="100%" height="80%"
                                               controls="controls">
                                            <source src="<?php echo base_url() . 'media/apartment/' . $img['name'] ?>"
                                                    type="video/mp4"/>
                                        </video>
                                        <div class="d-flex justify-content-center">
                                            <?php if ($check_modify): ?>
                                                <button type="button" data-img-id=<?=
                                                $img['id']
                                                ?> class="btn m-1 btn-sm
                                                        btn-outline-danger btn-rounded
                                                        waves-light waves-effect
                                                        delete-img">
                                                <i class="mdi mdi-delete"></i>
                                                </button>
                                            <?php endif; ?>

                                            <a data-img-id=<?= $img['id'] ?> class="btn
                                               m-1 btn-sm btn-outline-warning btn-rounded
                                               waves-light waves-effect download-img"
                                            download="<?= $apartment_model['address_street'] . '.' . $img['file_type'] ?>
                                            " href="<?= base_url() ?>
                                            media/apartment/<?= $img['name'] ?>">
                                            <i class="mdi mdi-cloud-download"></i>
                                            </a>
                                        </div>
                                    </div>

                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>


            </div> <!-- End row -->
        </form>

    </div> <!-- end container -->
</div>