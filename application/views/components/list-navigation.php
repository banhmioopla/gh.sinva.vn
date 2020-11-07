<div class="row">
    <div class="col-md-8 offset-md-2">
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

            <?php if(isYourPermission('Contract', 'show',$this->permission_set)):?>
                <a href="<?= base_url() ?>admin/list-contract">
                    <button type="button" class="btn btn-secondary waves-effect waves-light"> <i
                                class="mdi mdi-file-chart mr-1"></i> <span>Hợp Đồng</span> </button>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>


