
<div class="navbar-custom">
    <div class="container-fluid">
        <div id="navigation">
            <!-- Navigation Menu-->
            

            <ul class="navigation-menu">
                <?php if(isYourPermission('Apartment', 'show',$this->permission_set)):?>
                <li class="has-submenu">
                    <a href="#"><i class="icon-layers"></i>Dự Án</a>
                    <ul class="submenu">

                        <li><a href="/admin/list-apartment"><i class="mdi
                        mdi-chevron-double-right text-warning"></i> Danh Sách Dự
                                Án</a></li>

                        <li><a href="/admin/apartment/create"><i class="mdi
                        mdi-chevron-double-right text-warning"></i> Tạo Dự Án Mới</a></li>

                        <?php if(isYourPermission('Apartment', 'showLikeBase',$this->permission_set)):?>
                            <li><a href="/admin/list-apartment-like-base"><i class="mdi
                             mdi-chevron-double-right text-warning"></i> Dự án đã đóng</a></li>
                        <?php endif;?>

                        <?php if(isYourPermission('District', 'show',$this->permission_set)):?>
                            <li><a href="/admin/list-district"><i class="mdi
                            mdi-chevron-double-right text-warning"></i> Danh Sách Quận</a></li>
                        <?php endif;?>


                        <?php if(isYourPermission('UserDistrict', 'show',
                            $this->permission_set)):?>
                            <li><a href="/admin/list-user-district?account-id=<?=
                                $this->auth['account_id'] ?>"><i
                                            class="mdi
                            mdi-chevron-double-right text-warning"></i> Chia Quận</a></li>
                        <?php endif;?>


                        <?php if(isYourPermission('Partner', 'show',$this->permission_set)
                        ):?>
                            <li><a href="/admin/list-partner"><i class="mdi
                            mdi-chevron-double-right text-warning"></i> Danh Sách Thương
                                    Hiệu Hợp Tác</a></li>
                        <?php endif;?>

                        <?php if(isYourPermission('BusinessPartner', 'show',
                            $this->permission_set)
                        ):?>
                            <li><a href="/admin/list-business-partner"><i class="mdi
                            mdi-chevron-double-right text-warning"></i> Danh Sách
                                    Đối Tác Kinh Doanh</a></li>
                        <?php endif;?>

                        <?php if(isYourPermission('Tag', 'show',$this->permission_set)):?>
                            <li><a href="/admin/list-tag"><i class="mdi
                            mdi-chevron-double-right text-warning"></i> Danh Sách Tag</a></li>
                        <?php endif;?>

                        <?php if(isYourPermission('BaseRoomType', 'show',$this->permission_set)):?>
                            <li><a href="/admin/list-room-type"><i class="mdi
                            mdi-chevron-double-right text-warning"></i> Danh Sách Loại Phòng</a></li>
                        <?php endif;?>
                    </ul>
                </li>
                <?php endif;?>



                <?php if(isYourPermission('User', 'show',$this->permission_set)):?>
                <li class="has-submenu">
                    <a href="#"><i class="icon-layers"></i>Thành Viên</a>
                    <ul class="submenu">
                        <li><a href="/admin/list-user"><i class="mdi
                            mdi-chevron-double-right text-warning"></i> Danh Sách Thành Viên</a></li>
                        <?php if(isYourPermission('Role', 'show',$this->permission_set)):?>
                            <li><a href="/admin/list-role"><i class="mdi
                            mdi-chevron-double-right text-warning"></i> Danh Sách Quyền</a></li>
                        <?php endif;?>

                        <?php if(isYourPermission('Team', 'show',$this->permission_set)):?>
                            <li><a href="/admin/list-team"><i class="mdi
                            mdi-chevron-double-right text-warning"></i> Danh Sách Đội Nhóm Chi Nhánh</a></li>
                        <?php endif;?>


                    </ul>
                </li>
                <?php endif;?>

                <?php if(isYourPermission('Customer', 'show',$this->permission_set)):?>
                <li class="has-submenu">
                    <a href="#"><i class="icon-layers"></i>Khách Hàng & Hợp Đồng</a>
                    <ul class="submenu">
                        <li><a href="/admin/list-customer"><i class="mdi
                            mdi-chevron-double-right text-warning"></i> Danh Sách Khách Hàng</a></li>

                        <?php if(isYourPermission('CustomerFeedback', 'show',$this->permission_set)):?>
                            <li><a href="/admin/list-customer-feedback"><i class="mdi
                            mdi-chevron-double-right text-warning"></i> Đánh Giá Từ Khách Hàng</a></li>

                        <?php endif;?><?php if(isYourPermission('Contract', 'show',$this->permission_set)):?>
                            <li><a href="/admin/list-contract"><i class="mdi
                            mdi-chevron-double-right text-warning"></i> Tất Cả Hợp Đồng</a></li>
                        <?php endif;?>

                        <?php if(isYourPermission('CommissionBilling', 'show',$this->permission_set)):?>
                            <li><a href="/admin/list-commission-billing"><i class="mdi
                            mdi-chevron-double-right text-warning"></i> Phiếu thu</a></li>
                        <?php endif;?>

                        <?php if(isYourPermission('Apartment', 'showCommmissionRate',
                            $this->permission_set)):?>
                            <li><a href="/admin/list-apartment-commission-rate"><i class="mdi
                            mdi-chevron-double-right text-warning"></i> Danh
                                    Sách Hoa Hồng Ký Gửi</a></li>
                        <?php endif;?>

                        <?php if(isYourPermission('Customer', 'care',$this->permission_set)):?>
                            <li><a href="/admin/list-care-customer"><i class="mdi
                            mdi-chevron-double-right text-warning"></i> Thống Kê Chăm
                                    Sóc Khách Hàng</a></li>
                        <?php endif;?>
                    </ul>
                </li>
                <?php endif;?>


                <?php if(isYourPermission('ConsultantBooking', 'show',$this->permission_set)):?>
                <li class="has-submenu">
                    <a href="#"><i class="icon-layers"></i>Lượt Dẫn Khách</a>
                    <ul class="submenu">
                        <li><a href="/admin/list-consultant-booking?tb1=1&filterTime=THIS_WEEK"><i class="mdi
                            mdi-chevron-double-right text-warning"></i> Danh Sách Lượt
                                Dẫn Khách</a></li>
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