<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <h2 class="font-weight-bold text-danger"><?= $post['title'] ?></h2>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="port">
            <div class="portfolioContainer">
                <?php foreach ($list_img as $img): ?>
                    <div class="col-sm-6 col-md-4 webdesign illustrator">
                        <a href="<?= base_url().'media/apartment/'.$img['name'] ?>" class="image-popup">
                            <div class="portfolio-masonry-box">
                                <div class="portfolio-masonry-img">
                                    <img src="<?= base_url().'media/apartment/'.$img['name'] ?>" class="thumb-img img-fluid"
                                         alt="work-thumbnail">
                                </div>
                                <div class="portfolio-masonry-detail d-none">
                                    <h4 class="font-18">Street Photography</h4>
                                    <p>Graphic Design</p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach;?>

            </div>
        </div> <!-- End row -->

        <div class="row">
            <div class="col-md-6">
                <div class="card-box">
                    <h4 class="text-danger font-weight-bold">Mô Tả Chung</h4>
                    <p class="m-b-20" style="white-space: pre-line"><?= $post['content'] ?></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-box">
                    <a href="#">
                        <img src="https://blog.advids.co/wp-content/uploads//2017/06/Real-Estate11.gif"
                             class="w-100"
                             alt="realestatemanagementsoftware-CHOK" border="0" /></a>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card-box">

                    <a href="#">
                        <img src="https://uijar.com/uploads/post/image/244/airbnb-dribbble2-min-2.gif"
                             class="w-100"
                             alt="realestatemanagementsoftware-CHOK" border="0" /></a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card-box">
                    <h4 class="text-danger font-weight-bold">Dịch Vụ</h4>
                    <ul>
                        <?php if($apartment['electricity']): ?>
                            <li>
                                <div class="row border-bottom mt-2">
                                    <div class="col-6"><strong>Điện:</strong></div>
                                    <div class="col-6 text-right"><?= $apartment['electricity'] ?></div>
                                </div>
                            </li>
                        <?php endif; ?>

                        <?php if($apartment['water']): ?>
                            <li>
                                <div class="row border-bottom mt-2">
                                    <div class="col-6"><strong>Nước:</strong></div>
                                    <div class="col-6 text-right"><?= $apartment['water'] ?></div>
                                </div>
                            </li>
                        <?php endif; ?>

                        <?php if($apartment['internet']): ?>
                            <li>
                                <div class="row border-bottom mt-2">
                                    <div class="col-6"><strong>Internet:</strong></div>
                                    <div class="col-6 text-right"><?= $apartment['internet'] ?></div>
                                </div>
                            </li>
                        <?php endif; ?>

                        <?php if($apartment['elevator']): ?>
                            <li>
                                <div class="row border-bottom mt-2">
                                    <div class="col-6"><strong>Thang Máy:</strong></div>
                                    <div class="col-6 text-right"><?= $apartment['elevator'] ?></div>
                                </div>
                            </li>
                        <?php endif; ?>

                        <?php if($apartment['washing_machine']): ?>
                            <li>
                                <div class="row border-bottom mt-2">
                                    <div class="col-6"><strong>Máy Giặt:</strong></div>
                                    <div class="col-6 text-right"><?= $apartment['washing_machine'] ?></div>
                                </div>
                            </li>
                        <?php endif; ?>


                        <?php if($apartment['extra_fee']): ?>
                            <li>
                                <div class="row border-bottom mt-2">
                                    <div class="col-6"><strong>Phí Khác:</strong></div>
                                    <div class="col-6 text-right"><?= $apartment['extra_fee'] ?></div>
                                </div>
                            </li>
                        <?php endif; ?>


                        <?php if($apartment['elevator']): ?>
                            <li>
                                <div class="row border-bottom mt-2">
                                    <div class="col-6"><strong>Thang Máy:</strong></div>
                                    <div class="col-6 text-right"><?= $apartment['elevator'] ?></div>
                                </div>
                            </li>
                        <?php endif; ?>


                        <?php if($apartment['security']): ?>
                            <li>
                                <div class="row border-bottom mt-2">
                                    <div class="col-6"><strong>Bảo Vệ:</strong></div>
                                    <div class="col-6 text-right"><?= $apartment['security'] ?></div>
                                </div>
                            </li>
                        <?php endif; ?>


                        <?php if($apartment['pet']): ?>
                            <li>
                                <div class="row border-bottom mt-2">
                                    <div class="col-6"><strong>Thú Cưng:</strong></div>
                                    <div class="col-6 text-right"><?= $apartment['pet'] ?></div>
                                </div>
                            </li>
                        <?php endif; ?>

                        <?php if($apartment['deposit']): ?>
                            <li>
                                <div class="row border-bottom mt-2">
                                    <div class="col-6"><strong>Cọc:</strong></div>
                                    <div class="col-6 text-right"><?= $apartment['deposit'] ?></div>
                                </div>
                            </li>
                        <?php endif; ?>

                    </ul>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card-box">
                    <h4 class="text-danger font-weight-bold">Thông Tin Phòng</h4>
                    <ul>
                        <?php if($room['price']): ?>
                            <li>
                                <div class="row border-bottom mt-2">
                                    <div class="col-6"><strong>Giá:</strong></div>
                                    <div class="col-6 text-right font-weight-bold text-success"><?= number_format($room['price']) . ' VNĐ'  ?></div>
                                </div>
                            </li>
                        <?php endif; ?>

                        <?php if(!empty($room['room_type_id'])):
                            $room_type = "";
                            foreach (json_decode($room['room_type_id'], true) as $item) {
                                $room_type .= $libBaseRoomType->getNameById($item) . ', ';
                            }
                            $room_type = substr($room_type, 0, -2);
                            ?>
                            <li>
                                <div class="row border-bottom mt-2">
                                    <div class="col-6"><strong>Loại Phòng:</strong></div>
                                    <div class="col-6 text-right"><?= $room_type ?></div>
                                </div>
                            </li>
                        <?php endif; ?>

                    </ul>
                    <?php /* ?>
                    <h4 class="text-danger font-weight-bold">Liên Hệ Tư Vấn Miễn Phí <i class="mdi mdi-phone-in-talk mr-2"></i></h4>
                    <h3 class="text-right font-weight-bold text-success p-2 bg-dark"><?= $user['phone_number'] ?> - <?= $user['name'] ?></h3>
                    <?php */?>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card-box">

                    <a href="#">
                        <img src="https://data.whicdn.com/images/322940692/original.gif"
                             class="w-100"
                             alt="realestatemanagementsoftware-CHOK" border="0" /></a>
                </div>
            </div>
        </div>

    </div> <!-- end container -->
</div>
<!-- end wrapper -->