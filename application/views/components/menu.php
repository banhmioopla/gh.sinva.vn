<?php 
    include VIEWPATH.'functions.php';
?>
<div class="navbar-custom">
    <div class="container-fluid">
        <div id="navigation">
            <!-- Navigation Menu-->
            

            <ul class="navigation-menu">
                <?php if(isYourPermission('Apartment', 'show',$this->permission_set)):?>
                <li class="has-submenu">
                    <a href="#"><i class="icon-layers"></i>Dự Án</a>
                    <ul class="submenu">
                        <li><a href="/admin/list-apartment">Danh Sách Dự Án</a></li>

                        <?php if(isYourPermission('Apartment', 'showLikeBase',$this->permission_set)):?>
                            <li><a href="/admin/list-apartment-like-base">Danh Sách Dự Án (Bảng)</a></li>
                        <?php endif;?>

                        <?php if(isYourPermission('District', 'show',$this->permission_set)):?>
                            <li><a href="/admin/list-district">Danh Sách Quận</a></li>
                        <?php endif;?>

                        <?php if(isYourPermission('Tag', 'show',$this->permission_set)):?>
                            <li><a href="/admin/list-tag">Danh Sách Tag</a></li>
                        <?php endif;?>
                    </ul>
                </li>
                <?php endif;?>

                <?php if(isYourPermission('TempGoogle', 'show',$this->permission_set)):?>
                <li class="has-submenu">
                    <a href="#"><i class="icon-layers"></i>Google Drive</a>
                    <ul class="submenu">
                        <li><a href="/admin/list-google">Google Drive</a></li>
                    </ul>
                </li>
                <?php endif;?>

                <?php if(isYourPermission('Dashboard', 'show',$this->permission_set)):?>
                    <li class="has-submenu">
                        <a href="/admin/list-dashboard"><i class="icon-layers"></i>Bảng điều khiển</a>
                    </li>
                <?php endif;?>

                <?php if(isYourPermission('User', 'show',$this->permission_set)):?>
                <li class="has-submenu">
                    <a href="#"><i class="icon-layers"></i>Thành Viên</a>
                    <ul class="submenu">
                        <li><a href="/admin/list-user">Danh Sách Thành Viên</a></li>
                        <?php if(isYourPermission('Role', 'show',$this->permission_set)):?>
                            <li><a href="/admin/list-role">Danh Sách Quyền</a></li>
                        <?php endif;?>
                    </ul>
                </li>
                <?php endif;?>

                <?php if(isYourPermission('Customer', 'show',$this->permission_set)):?>
                <li class="has-submenu">
                    <a href="#"><i class="icon-layers"></i>Khách Hàng</a>
                    <ul class="submenu">
                        <li><a href="/admin/list-customer">Danh Sách Khách Hàng</a></li>
                        <?php if(isYourPermission('Contract', 'show',$this->permission_set)):?>
                            <li><a href="/admin/list-contract">Danh Sách Hợp Đồng</a></li>
                        <?php endif;?>

                        <?php if(isYourPermission('Customer', 'care',$this->permission_set)):?>
                            <li><a href="/admin/list-care-customer">Thống Kê Chăm Sóc Khách Hàng</a></li>
                        <?php endif;?>
                    </ul>
                </li>
                <?php endif;?>


                <?php if(isYourPermission('ConsultantBooking', 'show',$this->permission_set)):?>
                <li class="has-submenu">
                    <a href="#"><i class="icon-layers"></i>Lượt Dẫn Khách</a>
                    <ul class="submenu">
                        <li><a href="/admin/list-consultant-booking">Danh Sách Lượt Dẫn Khách</a></li>
                    </ul>
                </li>
                <?php endif;?>
                  
            </ul>
            <!-- End navigation menu -->
        </div>
        <!-- end #navigation -->
    </div>
    <!-- end container -->
</div>