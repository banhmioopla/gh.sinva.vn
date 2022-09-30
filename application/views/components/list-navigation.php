<div class="row">
    <div class="col-12">
        <div class="m-1 button-list">
            <div class="btn-group">
                <button type="button" class="btn btn-danger"
                        data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"><i class="fa fa-wpexplorer"></i> Khám Phá</button>
                <button type="button"
                        class="btn btn-danger dropdown-toggle dropdown-toggle-split"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="/admin/apartment/dashboard/show">Bảng điều khiển</a>
                    <a class="dropdown-item" href="/admin/apartment/trending">Lượt xem</a>
                </div>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-secondary" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"><i class="fa fa-tasks"></i> Dự Án</button>
                <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu">


                    <a class="dropdown-item" href="/admin/list-apartment"> <i class="fa fa-tasks mr-1"></i> Danh Sách Dự Án</a>


                    <?php if(isYourPermission('Image', 'show',$this->permission_set)):?>
                        <a class="dropdown-item" href="/admin/show-image-apartment"> <i class="fa fa-tasks mr-1"></i> Kho Hình Ảnh</a>
                    <?php endif; ?>

                    <?php if(isYourPermission('Mapbox', 'show',$this->permission_set)):?>
                        <a class="dropdown-item" href="/admin/list-mapbox"> <i class="mdi mdi-google-maps mr-1"></i> Bản Đồ Dự Án</a>
                    <?php endif; ?>

                    <a class="dropdown-item" href="/admin/list-apartment-track"> <i class="mdi mdi-timetable mr-1"></i> Nhật Ký Dự Án</a>
                </div>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-secondary" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"><i class="fa fa-grav"></i> <?= $this->auth["name"] ?></button>
                <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="/admin/consultant-post/your-list"> <i class="mdi mdi-library-plus mr-1"></i> Bài Đăng Tư Vấn</a>
                    <a class="dropdown-item" href="/personal/customer-feedback/list"> <i class="mdi mdi-library-plus mr-1"></i> Feedback</a>
                    <a class="dropdown-item" href="/admin/customer/show-your"> <i class="mdi mdi-library-plus mr-1"></i> Khách Hàng</a>
                    <a class="dropdown-item" href="/admin/list-personal-contract"> <i class="mdi mdi-library-plus mr-1"></i> Hợp đồng</a>
                </div>
            </div>

            <?php /* if(isYourPermission('ShareCustomerUser', 'showCreate',$this->permission_set)
            ):?>
                <a href="<?= base_url() ?>admin/show-create-share-customer-user" class="btn-group">
                    <button type="button" class="btn btn-secondary waves-effect waves-light"> <i
                                class="mdi mdi-human-greeting"></i> <span>+ Chia Sẻ KH</span>
                    </button>
                </a>
            <?php endif; */?>

            <?php /* if(isYourPermission('Contract', 'showYour',$this->permission_set)):?>
                <a href="<?= base_url() ?>admin/list-personal-contract">
                    <button type="button" class="btn btn-danger waves-effect waves-light"> <i
                                class="mdi mdi-file-chart mr-1"></i> <span>Hợp Đồng Của Tôi</span> </button>
                </a>
            <?php endif; */ ?>

            <?php /* if(isYourPermission('Story', 'show',$this->permission_set)):?>
                <a href="<?= base_url() ?>admin/list-story">
                    <button type="button" class="btn btn-secondary waves-effect waves-light"> <i
                                class="mdi mdi-google-wallet
                                 mr-1"></i> <span
                                class="text-">Story</span>
                    </button>
                </a>
            <?php endif; */?>

            <?php  if($this->yourTeam): ?>
                <a href="/admin/team/detail?id=<?= $this->yourTeam['id'] ?>" class="btn-group">
                    <button type="button" class="btn btn-secondary waves-effect waves-light"> <i class="fa fa-group"></i> <span><?= $this->yourTeam['name'] ?></span>
                    </button>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>


