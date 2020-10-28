<?php 
$role_delete = ['product-manager'];

?>

<?php 
    include VIEWPATH.'functions.php';
?>

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
                    <h4 class="page-title text-primary"><?= $apartment_model['address_street'] ?></h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php $this->load->view('components/list-navigation'); ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box">
                    <blockquote class="blockquote">
                        <p>Có thể upload nhiều ảnh theo mã phòng. Ảnh có viền màu vàng sẽ là ảnh ở chế độ đợi duyệt. Hiện tại dù ảnh chưa duyệt hay đã duyệt thì cũng được hiển thị. <br> Bạn có quy ước nào về tính năng này ?... </p>
                        <footer class="blockquote-footer">vui lòng inbox <cite title="Source Title">Quốc Bình.</cite></footer>
                    </blockquote>

                    <h4 class=" font-weight-bold"></h4>
                    <div class="upload-section">
                    <form method="post" enctype="multipart/form-data" class='form-group row' action="/admin/upload-image?apartment-id=<?= $this->input->get('apartment-id') ?>">
                        <div class="col-md-4 col-12">
                            <select class="custom-select mt-3 form-control" name="room_id">
                                <?= $cb_room_code ?>
                            </select>
                        </div>
                        <div class="col-12 col-md-12 choose-img">
                            <div class="demo-box">
                                <div class="form-group">
                                    <p class="mb-2 mt-4 font-weight-bold text-muted">chọn ảnh tại đây</p>
                                    <input type="file"
                                    required
                                    class="filestyle" 
                                    name="files[]" multiple
                                    data-input="false" data-btnClass="btn-danger ">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-12 btn-upload">
                            <button type="submit" name="fileSubmit" value="UPLOAD" class="w-100 btn btn-custom waves-effect waves-light">
                                    Tải ảnh lên GH
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
                    <a href="#" data-filter="*" class="current bg-primary">Tất cả</a>
                    <?php
                        $i = 0;
                        foreach($list_room_code as $room):
                            $status = 'border ';
                            $status_text = ' - <i class="text-secondary">'. view_money_format($room['price'],1) . '</i>';
                            if($room['status'] == 'Available'){
                                $status .= ' text-success';
                            }
                                
                            if($room['time_available'] > 0){
                                $status_text .= ' <span class="text-warning"> '.date('d/m/Y', $room['time_available']) . '</span>';
                            }
                            
                    ?>
                        <a href="#" class="font-weight-bold <?= $status ?>" data-filter=".roomcode-<?= $room['id'] ?>">
                        <?= $room['code']. $status_text ?>
                        </a>
                    <?php endforeach;?>

                </div>
            </div>
        </div>
        <div class="port">
            <div class="col-md-12">
                <button class="btn m-1 btn-sm btn-outline-warning btn-rounded waves-light waves-effect download-img-all">
                    <i class="mdi mdi-cloud-download"></i> Tải tất cả [đang code]...
                </button>
            </div>
            <div class="portfolioContainer">
            <?php if($list_img): ?>
            <?php foreach($list_img as $img): ?>
                <div class="col-sm-6 col-md-3
                <?= !empty($img['room_id']) ? 'roomcode-'.$img['room_id']:'' ?> image-item">
                <?php 
                    $imgStatus = $img['status'] == 'Pending' ? 'warning' : '';
                    
                    if(!in_array($img['file_type'], ['mp4', 'mov'])):
                ?>
                    <div class="portfolio-masonry-box">
                        <a href="<?= base_url() ?>media/apartment/<?= $img['name']?>" class="image-popup" >
                            <div class="portfolio-masonry-img border border-<?= $imgStatus ?>" style="border-width:3px">
                                <img src="<?= base_url() ?>media/apartment/<?= $img['name']?>" class="thumb-img img-fluid"
                                    alt="work-thumbnail">
                            </div>
                        </a>
                        <div class="portfolio-masonry-detail">
                            <h4 class="font-18"><?= date('d-m-Y', $img['time_insert']) ?></h4>
                            <div class="d-flex justify-content-center">
                                <?php if(in_array($this->auth['role_code'], $role_delete)): ?>
                                <button data-img-id=<?= $img['id'] ?> class="btn m-1 btn-sm btn-outline-danger btn-rounded waves-light waves-effect delete-img">
                                    <i class="mdi mdi-delete"></i>
                                </button>
                                <?php endif; ?>

                                <a data-img-id=<?= $img['id'] ?> class="btn m-1 btn-sm btn-outline-warning btn-rounded waves-light waves-effect download-img" download="<?= $apartment_model['address_street'].'.'.$img['file_type']?>" href="<?= base_url() ?>media/apartment/<?= $img['name'] ?>">
                                    <i class="mdi mdi-cloud-download"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php else:?>
                    <div class="portfolio-masonry-box">
                        <video width="100%" height="80%" controls="controls">
                            <source src="<?php echo base_url().'media/apartment/'.$img['name']?>" type="video/mp4" />
                        </video>  
                    </div>
                    <?php endif; ?>
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
            $('.choose-img, .btn-upload').hide();
            $('select[name=room_id]').on('change', function(){
                console.log('change');
                if($(this).val() == '0') {
                    $('.choose-img, .btn-upload').hide();
                } else {
                    console.log('changexxx');
                    $('.choose-img, .btn-upload').show();
                }
            });
            $('.delete-img').click(function(){
                console.log($(this).data('img-id'));
                var img_id = $(this).data('img-id');
                var this_btn = $(this);
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>admin/update-image',
                    data: {img_id: img_id, field_name: 'active', field_value: 'NO'},
                    success: function(response) {
                        this_btn.parents('.portfolio-masonry-box').remove();
                    }
                });
            });
            $('.download-img-all').click(function(){
                $('.download-img').click();
            });
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