<div class="row">
    <div class="col-12">
        <div class="m-md-2 m-1 button-list">
            <?php if(isYourPermission('Image', 'show',$this->permission_set)):?>
                <a href="<?= base_url() ?>admin/show-image-apartment">
                    <button type="button" class="btn btn-secondary waves-effect waves-light"> <i
                                class="mdi mdi-folder-multiple-image mr-1"></i> <span>Kho Hình
                Ảnh</span>
                    </button>
                </a>
            <?php endif; ?>

            <?php if(isYourPermission('ConsultantBooking', 'show',$this->permission_set)):?>
                <a href="<?= base_url() ?>admin/list-consultant-booking">
                    <button type="button" class="btn btn-secondary waves-effect waves-light"> <i
                                class="mdi mdi-car-hatchback mr-1"></i> <span>Dẫn Khách</span>
                    </button>
                </a>
            <?php endif; ?>

            <?php if(isYourPermission('Customer', 'show',$this->permission_set)):?>
                <a href="<?= base_url() ?>admin/list-customer">
                    <button type="button" class="btn btn-secondary waves-effect waves-light"> <i
                                class="mdi mdi-human-greeting mr-1"></i> <span>Khách Thuê</span>
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

            <?php if(isYourPermission('Contract', 'showYour',$this->permission_set)):?>
                <a href="<?= base_url() ?>admin/list-personal-contract">
                    <button type="button" class="btn btn-danger waves-effect waves-light"> <i
                                class="mdi mdi-file-chart mr-1"></i> <span>Hợp Đồng Của Tôi</span> </button>
                </a>
            <?php endif; ?>

            <?php if(isYourPermission('Mapbox', 'show',$this->permission_set)):?>
            <a href="<?= base_url() ?>admin/list-mapbox">
                <button type="button" class="btn btn-secondary waves-effect waves-light"> <i
                            class="mdi mdi-google-maps mr-1"></i> <span
                            class="text-">Bản Đồ</span>
                </button>
            </a>
            <?php endif; ?>

            <?php if(isYourPermission('Story', 'show',$this->permission_set)):?>
                <a href="<?= base_url() ?>admin/list-story">
                    <button type="button" class="btn btn-secondary waves-effect waves-light"> <i
                                class="mdi mdi-google-wallet
                                 mr-1"></i> <span
                                class="text-">Story</span>
                    </button>
                </a>
            <?php endif; ?>

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
</div>


