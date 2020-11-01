<div class="m-md-2 m-1 button-list">
<?php if(isYourPermission('Image', 'show',$this->permission_set)):?>
    <a href="<?= base_url() ?>admin/show-image-apartment">
        <button type="button" class="btn btn-info waves-effect waves-light"> <i class="fa fa-cloud"></i> <span>Kho Ảnh Dự Án</span> </button>
    </a>
<?php endif; ?>

<?php if(isYourPermission('ConsultantBooking', 'show',$this->permission_set)):?>
    <a href="<?= base_url() ?>admin/list-consultant-booking">
        <button type="button" class="btn btn-info waves-effect waves-light"> <i class="fa fa-cloud"></i> <span>Thống kê dẫn khách</span> </button>
    </a>
<?php endif; ?>

<?php if(isYourPermission('Customer', 'show',$this->permission_set)):?>
    <a href="<?= base_url() ?>admin/list-customer">
        <button type="button" class="btn btn-info waves-effect waves-light"> <i class="fa fa-cloud"></i> <span>Khách Hàng Của Tôi</span> </button>
    </a>
<?php endif; ?>

<?php if(isYourPermission('Contract', 'show',$this->permission_set)):?>
    <a href="<?= base_url() ?>admin/list-contract">
        <button type="button" class="btn btn-info waves-effect waves-light"> <i class="fa fa-cloud"></i> <span>Hợp Đồng Của Tôi</span> </button>
    </a>
</div>
<?php endif; ?>