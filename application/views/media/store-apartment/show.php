<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Highdmin</a></li>
                            <li class="breadcrumb-item"><a href="#">Extra Pages</a></li>
                            <li class="breadcrumb-item active">Starter</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Starter</h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box">
                    <h4 class="m-t-0 header-title">Upload Ảnh dự Án</h4>
                    <h5 class="text-warning"><?= 'tại '.$apartment_model['address_street'] ?></h5>
                    <p class="text-muted mb-0 font-14">
                        Từ khi cúp họp, tôi quyết tâm mần chỗ upload ảnh này thiệt là đầu tư. 1 bức ảnh thuộc nhiều thể loại mà bạn muốn... let's kill this love
                    </p>

                    <div class="upload-section">
                    <form method="post" enctype="multipart/form-data" class='form-group row' action="/admin/upload-image?apartment-id=<?= $this->input->get('apartment-id') ?>">
                        <div class="col-3">
                            <select class="custom-select mt-3 form-control" name="room_type_id">
                                <?= $cb_room_type ?>
                            </select>
                        </div>
                        <div class="col-3">
                            <select class="custom-select mt-3 form-control" name="number_of_floor">
                                    <option value = 0 >Chọn lầu</option>
                                <?php for($i = 1; $i <= (int)$apartment_model['number_of_floor']; $i ++):?>
                                    <option value = <?= $i ?>>Lầu <?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-3">
                            <select class="custom-select mt-3 form-control" name="room_price_id">
                                <?= $cb_price ?>
                            </select>
                        </div>
                        <div class="col-3">
                            <select class="custom-select mt-3 form-control" name="room_id">
                                <?= $cb_room_code ?>
                            </select>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="demo-box">
                                <div class="form-group">
                                    <p class="mb-2 mt-4 font-weight-bold text-muted">chọn ảnh tại đây</p>
                                    <input type="file" 
                                    class="filestyle" 
                                    name="files[]" multiple
                                    data-input="false" data-btnClass="btn-danger ">
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <button type="submit" name="fileSubmit" value="UPLOAD" class="w-100 btn btn-custom waves-effect waves-light">
                                    Thêm mới
                            </button>
                        </div>
                    </form>
                    </div> <!-- end row -->
                </div> <!-- end card-box -->
            </div> <!-- end col -->
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 ">
                <div class="portfolioFilter text-center gallery-second">
                    <a href="#" data-filter="*" class="current">Tất cả</a>

                    <?php foreach($list_room_type as $type):?>
                        <a href="#" data-filter=".roomtype-<?= $type['id'] ?>"><?= $type['name'] ?></a>
                    <?php endforeach;?>

                    <?php foreach($list_price as $price):?>
                        <a href="#" data-filter=".roomprice-<?= $price['id'] ?>"><?= $price['name'] ?></a>
                    <?php endforeach;?>

                    <?php foreach($list_room_code as $room):?>
                        <a href="#" data-filter=".roomcode-<?= $room['id'] ?>"><?= $room['code'] ?></a>
                    <?php endforeach;?>

                </div>
            </div>
        </div>
        <div class="port">
            <div class="portfolioContainer">
            <?php if($list_img): ?>
            <?php foreach($list_img as $img): ?>
                <div class="col-sm-6 col-md-3
                <?= !empty($img['room_id']) ? 'roomcode-'.$img['room_id']:'' ?>
                <?= !empty($img['room_type_id']) ? 'roomtype-'.$img['room_type_id']:'' ?>
                <?= !empty($img['room_price_id']) ? 'roomtype-'.$img['room_type_id']:'' ?>
                image-item">
                    <a href="<?= base_url() ?>media/apartment/<?= $img['name'].'.jpg' ?>" class="image-popup">
                        <div class="portfolio-masonry-box">
                            <div class="portfolio-masonry-img">
                                <img src="<?= base_url() ?>media/apartment/<?= $img['name'].'.jpg'?>" class="thumb-img img-fluid"
                                    alt="work-thumbnail">
                            </div>
                            <div class="portfolio-masonry-detail">
                                <h4 class="font-18">giỏ hàng</h4>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
            <?php endif; ?>
            </div>
        </div> <!-- End row -->

        

    </div> <!-- end container -->
</div>
<!-- end wrapper -->
<script type="text/javascript">
    commands.push(function() {
        $(window).on('load', function () {
        var $container = $('.portfolioContainer');
        $container.isotope({
            filter: '*',
            animationOptions: {
                duration: 750,
                easing: 'linear',
                queue: false
            }
        });

        $('.portfolioFilter a').click(function () {
                $('.portfolioFilter .current').removeClass('current');
                $(this).addClass('current');

                var selector = $(this).attr('data-filter');
                $container.isotope({
                    filter: selector,
                    animationOptions: {
                        duration: 750,
                        easing: 'linear',
                        queue: false
                    }
                });
                return false;
            });
        });
        $(document).ready(function () {
            $('.image-popup').magnificPopup({
                type: 'image',
                closeOnContentClick: true,
                mainClass: 'mfp-fade',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
                }
            });
        });
    });
    
</script>