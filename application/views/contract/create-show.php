<div class="wrapper">
    <div class="sk-wandering-cubes" style="display:none" id="loader">
        <div class="sk-cube sk-cube1"></div>
        <div class="sk-cube sk-cube2"></div>
    </div>
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">test</a></li>
                            <li class="breadcrumb-item"><a href="#">Extra Pages</a></li>
                            <li class="breadcrumb-item active">Starter</li>
                        </ol>
                    </div>
                    <h2>Nhập hợp đồng - cọc</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card-box">
                    <h4 class="m-t-0">Thông tin dự án</h4>
                    <table class="table">
                        <tr>
                            <td><strong>Quận</strong></td>
                            <td><?= $libDistrict->getNameByCode($apartment['district_code']) ?></td>
                        </tr>
                        <tr>
                            <td><strong>Địa chỉ<strong></td>
                            <td><?= $apartment['address_street'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Mã Phòng<strong></td>
                            <td><?= $room['code'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Giá Phòng<strong></td>
                            <td><?= number_format($room['price'], 0, '', ',')  ?></td>
                        </tr>
                    </table>
                    <h4 class="m-t-0">Thông tin dịch vụ</h4>
                    <table class="table">
                        <tr>
                            <td><strong>Ghi Chú<strong></td>
                            <td style="white-space: pre-line;"><?= $apartment['note'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Điện</strong></td>
                            <td><?= $apartment['electricity'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Nước<strong></td>
                            <td><?= $apartment['water'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Internet<strong></td>
                            <td><?= $apartment['internet'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Thang máy<strong></td>
                            <td><?= $apartment['elevator'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Máy giặt<strong></td>
                            <td><?= $apartment['washing_machine'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Dọn phòng<strong></td>
                            <td><?= $apartment['room_cleaning'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Giữ xe<strong></td>
                            <td><?= $apartment['parking'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Giữ xe Oto<strong></td>
                            <td><?= $apartment['car_park'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Bếp<strong></td>
                            <td><?= $apartment['kitchen'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>KT3<strong></td>
                            <td><?= $apartment['kt3'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Thú cưng<strong></td>
                            <td><?= $apartment['pet'] ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card-box">
                    <h4 class="m-t-0">Thêm hợp đồng mới</h4>
                    <form role="form" method="post" action="<?= base_url()?>admin/create-contract">
                    <input type="hidden" name='room_id' value= '<?= $_GET["room-id"]?>'>
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Thành viên tư vấn<span class="text-danger">*</span></label>
                            <div class="col-8">
                                <select type="text" class="form-control"
                                        id="consultant_id" name="consultant_id" placeholder="Tên quận">
                                        <?= $select_user?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Khách Hàng Tiềm Năng<span class="text-danger">*</span></label>
                            <div class="col-8">
                                <select type="text" class="form-control"
                                        id="customer_name" name="customer_name">
                                        <?= $select_customer?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Khách Hàng Mới</label>
                            <div class="col-8">
                                <input type="text" class="form-control"
                                        id="customer_name_new" name="customer_name_new" placeholder="họ tên">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Ngày ký<span class="text-danger">*</span></label>
                            <div class="col-8">
                                <input type="text" required class="form-control contract-open"
                                        id="time_open" name="time_open">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Số tháng ở<span class="text-danger">*</span></label>
                            <div class="col-8">
                                <input  type="number" 
                                        required class="form-control"
                                        id="number_of_month" 
                                        name="number_of_month">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Tình trạng<span class="text-danger">*</span></label>
                            <div class="col-8">
                                <div class="radio radio-custom">
                                    <input type="radio" name="status" checked id="sinva-info-form" value="Active">
                                    <label for="sinva-info-form">
                                        Đang ở (đang có hiệu lực)
                                    </label>
                                </div>
                                <div class="radio radio-custom">
                                    <input type="radio" name="status" id="sinva-rented" value="Pending">
                                    <label for="sinva-rented">
                                        Đợi ký HĐ (đang cọc)
                                    </label>
                                </div>
                                <div class="radio radio-custom">
                                    <input type="radio" name="status" id="sinva-rented" value="Cancel">
                                    <label for="sinva-rented">
                                        Hủy cọc
                                    </label>
                                </div>
                            </div>
                        </div>
                    
                        <div class="form-group row">
                            <label class="col-4 col-form-label">Ghi chú</label>
                            <div class="col-8">
                                <textarea class="form-control" rows="5" name="note" placeholder="Không bắt buộc"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-8 offset-4">
                                <button type="submit" class="btn btn-custom waves-effect waves-light">
                                    Thêm mới
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
commands.push(function(){
    $('.contract-open').datepicker({
        format: "dd/mm/yyyy",
    });
});

</script>
