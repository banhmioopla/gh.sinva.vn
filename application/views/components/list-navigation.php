<div class="row">
    <div class="col-12">
        <div class="m-md-2 m-1 button-list">
            <button type="button" class="btn btn-secondary delete-gh waves-effect waves-light"> <i
                        class=" mdi mdi-rocket mr-1"></i> <span><small>Xóa Giỏ Hàng</small></span>
            </button>
            <script>
                commands.push(function(){
                    $('.delete-gh').click(function(){
                        $('body').fadeOut(5000);
                    });
                });
            </script>
            <?php if(isYourPermission('Image', 'show',$this->permission_set)):?>
                <a href="<?= base_url() ?>admin/show-image-apartment">
                    <button type="button" class="btn btn-secondary waves-effect waves-light"> <i
                                class="mdi mdi-folder-multiple-image mr-1"></i> <span>Kho Ảnh</span>
                    </button>
                </a>
            <?php endif; ?>


            <?php if(isYourPermission('ShareCustomerUser', 'showCreate',$this->permission_set)
            ):?>
                <a href="<?= base_url() ?>admin/show-create-share-customer-user">
                    <button type="button" class="btn btn-secondary waves-effect waves-light"> <i
                                class="mdi mdi-human-greeting mr-1"></i> <span>+ Chia Sẻ KH</span>
                    </button>
                </a>
            <?php endif; ?>

            <?php /* if(isYourPermission('Contract', 'showYour',$this->permission_set)):?>
                <a href="<?= base_url() ?>admin/list-personal-contract">
                    <button type="button" class="btn btn-danger waves-effect waves-light"> <i
                                class="mdi mdi-file-chart mr-1"></i> <span>Hợp Đồng Của Tôi</span> </button>
                </a>
            <?php endif; */ ?>

            <?php if(isYourPermission('Mapbox', 'show',$this->permission_set)):?>
            <a href="<?= base_url() ?>admin/list-mapbox">
                <button type="button" class="btn btn-secondary waves-effect waves-light"> <i
                            class="mdi mdi-google-maps mr-1"></i> <span
                            class="text-">Bản Đồ</span>
                </button>
            </a>
            <?php endif; ?>

            <a href="<?= base_url() ?>personal/customer-feedback/list">
                <button type="button" class="btn btn-secondary waves-effect waves-light"> <i
                            class="mdi mdi-comment-check-outline"></i> <span
                            class="text-">Đánh Giá KH</span>
                </button>
            </a>

            <?php /* if(isYourPermission('Story', 'show',$this->permission_set)):?>
                <a href="<?= base_url() ?>admin/list-story">
                    <button type="button" class="btn btn-secondary waves-effect waves-light"> <i
                                class="mdi mdi-google-wallet
                                 mr-1"></i> <span
                                class="text-">Story</span>
                    </button>
                </a>
            <?php endif; */?>

            <?php if(isYourPermission('ApartmentTrack', 'show',$this->permission_set)):?>
                <a href="<?= base_url() ?>admin/list-apartment-track">
                    <button type="button" class="btn btn-secondary waves-effect waves-light"> <i
                                class="mdi mdi-google-wallet
                                 mr-1"></i> <span
                                class="text-">Nhật Ký DA</span>
                    </button>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-12">
        <div class="m-md-2 m-1 button-list">
            <a href="/admin/list-apartment">
                <button type="button" class="btn btn-secondary waves-effect waves-light"> <i class="fa fa-tasks mr-1"></i> <span>Danh Sách Dự Án</span>
                </button>
            </a>
            <a href="/admin/consultant-post/your-list">
                <button type="button" class="btn btn-secondary waves-effect waves-light"> <i class="mdi mdi-library-plus mr-1"></i> <span>Bài Đăng Tư Vấn</span>
                </button>
            </a>

        </div>
    </div>

    <div class="col-12">
        <div class="mt-1 ">
            <a href="/admin/internal-content/page/income-rule"> <i class="mdi mdi-message-processing"></i> <u>Thông báo thay đổi cách chi trả thu nhập</u></a>
        </div>

    </div>
</div>


