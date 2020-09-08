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
                    <h3 class="page-title">Nhập hợp đồng - cọc</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-5">
                <div class="card-box">
                <h4 class="header-title m-t-0">Thông tin dự án</h4>
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
                </div>
            </div>
            <div class="col-12 col-md-5">
                <div class="card-box">
                    <h4 class="header-title m-t-0">Thêm hợp đồng mới</h4>
                    <form role="form" method="post" action="<?= base_url()?>admin/create-contract">
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Thành viên tư vấn<span class="text-danger">*</span></label>
                            <div class="col-8">
                                <select type="text" class="form-control"
                                        id="name" name="name" placeholder="Tên quận">
                                        <?= $select_user?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Khách Hàng Đã Nhập<span class="text-danger">*</span></label>
                            <div class="col-8">
                                <select type="text" class="form-control"
                                        id="customer_name" name="customer_name" placeholder="Tên quận">
                                        <?= $select_customer?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Khách Hàng Mới<span class="text-danger">*</span></label>
                            <div class="col-8">
                                <input type="text" required class="form-control"
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
                                <input type="number" required class="form-control"
                                        id="customer_name_new" name="customer_name_new">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Tình trạng<span class="text-danger">*</span></label>
                            <div class="col-8">
                                <div class="radio radio-custom">
                                    <input type="radio" name="status" checked id="sinva-info-form" value="sinva-info-form">
                                    <label for="sinva-info-form">
                                        Đang ở
                                    </label>
                                </div>
                                <div class="radio radio-custom">
                                    <input type="radio" name="status" id="sinva-rented" value="sinva-rented">
                                    <label for="sinva-rented">
                                        Đợi ký (đang cọc)
                                    </label>
                                </div>
                                <div class="radio radio-custom">
                                    <input type="radio" name="status" id="orther" value="orther">
                                    <label for="orther">
                                        Hủy
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
