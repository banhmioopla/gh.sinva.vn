<?php
$check_delete = isYourPermission('Image', 'delete', $this->permission_set);
$check_approve = isYourPermission('Contract', 'approved', $this->permission_set);
$checkPartial = isYourPermission('Contract', 'approved', $this->permission_set);


?>


<div class="wrapper">
    <div class="sk-wandering-cubes" style="display:none" id="loader">
        <div class="sk-cube sk-cube1"></div>
        <div class="sk-cube sk-cube2"></div>
    </div>
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Giỏ Hàng</a></li>
                            <li class="breadcrumb-item"><a href="#">Dự Án</a></li>
                            <li class="breadcrumb-item active"># </li>
                        </ol>
                    </div>
                </div>
                <h2 class="font-weight-bold text-danger">Duyệt: <?= $apartment['address_street'] ?></h2>
            </div>

            <div class="col-12">
                <?php
                if($this->session->has_userdata('fast_notify')):
                    ?>
                    <div class="alert alert-<?= $this->session->flashdata('fast_notify')['status']?> alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('fast_notify')['message']?>
                    </div>
                    <?php unset($_SESSION['fast_notify']); endif; ?>
            </div>

            <div class="col-12">
                <div class="card-box shadow">
                    <h3 class="text-center">Chi tiết Yêu Cầu</h3>
                    <p class="text-center text-dark"><?= $apartment['address_street'] ?></p>
                    <p><a href="/sale/apartment-request/show" class="text-danger"><i class="mdi
                     mdi-arrow-left-bold-circle"></i> Quay Lại Danh Sách</a></p>
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                        <th width="250px">Thông Tin</th>
                        <th>Mới</th>
                        <th>Cũ</th>
                        </thead>
                        <tbody>
                        <?php if(isset($request_data->address_street) && $request_data->address_street != $apartment['address_street']): ?>
                        <tr>
                            <td>Địa Chỉ</td>
                            <td><?= $request_data->address_street ?></td>
                            <td><?= $apartment['address_street'] ?></td>
                        </tr>
                        <?php endif; ?>

                        <?php if(isset($request_data->address_ward) && $request_data->address_ward != $apartment['address_ward']): ?>
                            <tr>
                                <td>Phường</td>
                                <td><?= $request_data->address_ward ?></td>
                                <td><?= $apartment['address_ward'] ?></td>
                            </tr>
                        <?php endif; ?>


                        <?php if(isset($request_data->user_collected_id) && $request_data->user_collected_id > 0 && $request_data->user_collected_id != $apartment['user_collected_id']): ?>
                            <tr>
                                <td>Người Đàm Phán</td>
                                <td><?= $request_data->user_collected_id ?></td>
                                <td><?= $apartment['user_collected_id'] ?></td>
                            </tr>
                        <?php endif; ?>


                        <?php if(isset($request_data->partner_id) && $request_data->partner_id != $apartment['partner_id']):
                                $brand_old = $ghPartner->getFirstById($apartment['partner_id']);
                                $brand_old_name = $brand_old ? $brand_old['name'] : '';
                                $brand_new = $ghPartner->getFirstById($request_data->partner_id);
                                $brand_new_name = $brand_new ? $brand_new['name'] : '';

                            ?>
                            <tr>
                                <td>Thương Hiệu Hợp Tác</td>
                                <td><?= $brand_new_name ?></td>
                                <td><?= $brand_old_name ?></td>
                            </tr>
                        <?php endif; ?>

                        <?php if(isset($request_data->direction) && $request_data->direction != $apartment['direction']):


                            ?>
                            <tr>
                                <td>Hướng</td>
                                <td><?= $request_data->direction ?></td>
                                <td><?= $apartment['direction'] ?></td>
                            </tr>
                        <?php endif; ?>


                        <?php if(isset($request_data->time_insert) && $request_data->time_insert > 0 && $request_data->time_insert != $apartment['time_insert']): ?>
                            <tr>
                                <td>Ngày Lấy Về</td>
                                <td><?= date('d-m-Y',$request_data->time_insert) ?></td>
                                <td><?= date('d-m-Y',$apartment['time_insert']) ?></td>
                            </tr>
                        <?php endif; ?>

                        <?php if(isset($request_data->active) && $request_data->active != $apartment['active']): ?>
                            <tr>
                                <td>Mở / Đóng</td>
                                <td><?= $request_data->active ?></td>
                                <td><?= $apartment['active'] ?></td>
                            </tr>
                        <?php endif; ?>

                        <?php if(isset($request_data->description) && $request_data->description != $apartment['description']): ?>
                            <tr>
                                <td>Mô Tả</td>
                                <td><?= $request_data->description ?></td>
                                <td><?= $apartment['description'] ?></td>
                            </tr>
                        <?php endif; ?>


                        <?php if(isset($request_data->note) && $request_data->note != $apartment['note']): ?>
                            <tr>
                                <td>Ghi Chú</td>
                                <td><?= $request_data->note ?></td>
                                <td><?= $apartment['note'] ?></td>
                            </tr>
                        <?php endif; ?>


                        <?php if(isset($request_data->electricity) && $request_data->electricity != $apartment['electricity']): ?>
                            <tr>
                                <td>Điện</td>
                                <td><?= $request_data->electricity ?></td>
                                <td><?= $apartment['electricity'] ?></td>
                            </tr>
                        <?php endif; ?>


                        <?php if(isset($request_data->water) && $request_data->water != $apartment['water']): ?>
                            <tr>
                                <td>Nước</td>
                                <td><?= $request_data->water ?></td>
                                <td><?= $apartment['water'] ?></td>
                            </tr>
                        <?php endif; ?>


                        <?php if(isset($request_data->internet) && $request_data->internet != $apartment['internet']): ?>
                            <tr>
                                <td>Internet</td>
                                <td><?= $request_data->internet ?></td>
                                <td><?= $apartment['internet'] ?></td>
                            </tr>
                        <?php endif; ?>


                        <?php if(isset($request_data->room_cleaning) && $request_data->room_cleaning != $apartment['room_cleaning']): ?>
                            <tr>
                                <td>Dọn Phòng</td>
                                <td><?= $request_data->room_cleaning ?></td>
                                <td><?= $apartment['room_cleaning'] ?></td>
                            </tr>
                        <?php endif; ?>


                        <?php if(isset($request_data->parking) && $request_data->parking != $apartment['parking']): ?>
                            <tr>
                                <td>Giữ Xe</td>
                                <td><?= $request_data->parking ?></td>
                                <td><?= $apartment['parking'] ?></td>
                            </tr>
                        <?php endif; ?>


                        <?php if(isset($request_data->management_fee) && $request_data->management_fee != $apartment['management_fee']): ?>
                            <tr>
                                <td>Ra vào</td>
                                <td><?= $request_data->parking ?></td>
                                <td><?= $apartment['parking'] ?></td>
                            </tr>
                        <?php endif; ?>


                        <?php if(isset($request_data->extra_fee) && $request_data->extra_fee != $apartment['extra_fee']): ?>
                            <tr>
                                <td>Combo Phí</td>
                                <td><?= $request_data->extra_fee ?></td>
                                <td><?= $apartment['parking'] ?></td>
                            </tr>
                        <?php endif; ?>

                        <?php if(isset($request_data->deposit) && $request_data->deposit != $apartment['deposit']): ?>
                            <tr>
                                <td>Cọc Phòng</td>
                                <td><?= $request_data->extra_fee ?></td>
                                <td><?= $apartment['deposit'] ?></td>
                            </tr>
                        <?php endif; ?>


                        <?php if(isset($request_data->number_of_floor) && $request_data->number_of_floor != $apartment['number_of_floor']): ?>
                            <tr>
                                <td>Số Lầu</td>
                                <td><?= $request_data->number_of_floor ?></td>
                                <td><?= $apartment['number_of_floor'] ?></td>
                            </tr>
                        <?php endif; ?>


                        <?php if(isset($request_data->elevator) && $request_data->elevator != $apartment['elevator']): ?>
                            <tr>
                                <td>Thang Máy</td>
                                <td><?= $request_data->elevator ?></td>
                                <td><?= $apartment['elevator'] ?></td>
                            </tr>
                        <?php endif; ?>


                        <?php if(isset($request_data->washing_machine) && $request_data->washing_machine != $apartment['washing_machine']): ?>
                            <tr>
                                <td>Máy Giặt</td>
                                <td><?= $request_data->washing_machine ?></td>
                                <td><?= $apartment['washing_machine'] ?></td>
                            </tr>
                        <?php endif; ?>


                        <?php if(isset($request_data->room_cleaning) && $request_data->room_cleaning != $apartment['room_cleaning']): ?>
                            <tr>
                                <td>Dọn Phòng</td>
                                <td><?= $request_data->room_cleaning ?></td>
                                <td><?= $apartment['room_cleaning'] ?></td>
                            </tr>
                        <?php endif; ?>


                        <?php if(isset($request_data->number_of_people) && $request_data->number_of_people != $apartment['number_of_people']): ?>
                            <tr>
                                <td>Số Người Ở</td>
                                <td><?= $request_data->number_of_people ?></td>
                                <td><?= $apartment['number_of_people'] ?></td>
                            </tr>
                        <?php endif; ?>

                        <?php if(isset($request_data->kitchen) && $request_data->kitchen != $apartment['kitchen']): ?>
                            <tr>
                                <td>Bếp</td>
                                <td><?= $request_data->kitchen ?></td>
                                <td><?= $apartment['kitchen'] ?></td>
                            </tr>
                        <?php endif; ?>


                        <?php if(isset($request_data->security) && $request_data->security != $apartment['security']): ?>
                            <tr>
                                <td>Bảo Vệ</td>
                                <td><?= $request_data->security ?></td>
                                <td><?= $apartment['security'] ?></td>
                            </tr>
                        <?php endif; ?>


                        <?php if(isset($request_data->pet) && $request_data->pet != $apartment['pet']): ?>
                            <tr>
                                <td>Thú Cưng</td>
                                <td><?= $request_data->pet ?></td>
                                <td><?= $apartment['pet'] ?></td>
                            </tr>
                        <?php endif; ?>

                        <?php if(isset($request_data->car_park) && $request_data->car_park != $apartment['car_park']): ?>
                            <tr>
                                <td>Bãi Xe Ô Tô</td>
                                <td><?= $request_data->car_park ?></td>
                                <td><?= $apartment['car_park'] ?></td>
                            </tr>
                        <?php endif; ?>

                        <?php if(isset($request_data->commission_rate) && $request_data->commission_rate != $apartment['commission_rate']): ?>
                            <tr>
                                <td>Hoa Hồng 12 Tháng</td>
                                <td><?= $request_data->commission_rate ?></td>
                                <td><?= $apartment['commission_rate'] ?></td>
                            </tr>
                        <?php endif; ?>

                        <?php if(isset($request_data->commission_rate_9m) && $request_data->commission_rate_9m != $apartment['commission_rate_9m']): ?>
                            <tr>
                                <td>Hoa Hồng 9 Tháng</td>
                                <td><?= $request_data->commission_rate_9m ?></td>
                                <td><?= $apartment['commission_rate_9m'] ?></td>
                            </tr>
                        <?php endif; ?>

                        <?php if(isset($request_data->commission_rate_6m) && $request_data->commission_rate_6m != $apartment['commission_rate_6m']): ?>
                            <tr>
                                <td>Hoa Hồng 6 Tháng</td>
                                <td><?= $request_data->commission_rate_6m ?></td>
                                <td><?= $apartment['commission_rate_6m'] ?></td>
                            </tr>
                        <?php endif; ?>

                        <?php if(isset($request_data->kt3) && $request_data->kt3 != $apartment['kt3']): ?>
                            <tr>
                                <td>KT3</td>
                                <td><?= $request_data->kt3 ?></td>
                                <td><?= $apartment['kt3'] ?></td>
                            </tr>
                        <?php endif; ?>

                        <?php if($request['status'] == 'Pending'): ?>
                        <tr>
                            <td class="font-weight-bold">Đông ý duyệt Yêu cầu này hay không ?</td>
                            <td>
                                <form action="" >
                                    <input type="hidden" name="id" value="<?= $request['id'] ?>">
                                    <button name="submit"  value="YES" class="btn btn-success">Đồng Ý</button>
                                    <button name="submit" value="NO" class="btn btn-danger">Từ Chối</button>
                                </form>
                            </td>
                            <td></td>

                        </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
