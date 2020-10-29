<?php 

$check_consultant_id = false;
if(in_array($this->auth['role_code'], ['customer-care'])){
    $check_consultant_id = true;
}
?>


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
            <div class="col-12 col-md-5">
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
            <div class="col-12 col-md-7">
                <div class="card-box">
                    <h4 class="m-t-0">Thêm hợp đồng mới</h4>
                    <hr>
                    <form role="form" method="post" action="<?= base_url()?>admin/create-contract">
                        <input type="hidden" name='room_id' value= '<?= $_GET["room-id"]?>'>
                        <input type="hidden" name='room_code' value= '<?= $room['code']?>'>
                        <input type="hidden" name='apartment_id' value= '<?= $room['apartment_id']?>'>
                        <div class="form-group row">
                            <label for="consultant_id" class="col-12 col-md-4 col-form-label">Thành viên tư vấn<span class="text-danger"> (bb)</span></label>
                            <?php if($check_consultant_id):?>
                            <div class="col-md-8 col-12">
                                <select type="number" class="form-control"
                                        id="consultant_id" name="consultant_id" placeholder="171020xxx">
                                        <?= $select_user?>
                                </select>
                            </div>
                            <?php else: ?>
                                <div class="col-md-8 col-12">
                                    <input type="text" class="form-control"
                                            id="consultant_id" readonly name="consultant_id" value="<?= $this->auth['account_id']?>">
                                </div>
                            <?php endif; ?>
                        </div>
                        <hr>
                        <h5>Thông tin khách thuê</h5>
                        <div class="form-group row">
                            <label for="name" class="col-12 col-md-4 col-form-label">Khách Tiềm Năng</label>
                            <div class="col-md-8 col-12">
                            <select class="form-control select2" id="customer_name" name="customer_name">
                            </select>
                            </div>
                        </div>
                        <p class="text-info">GH: thông tin về khách hàng mới được nhập vào bảng khách hàng trước để tạo ID Khách hàng (IDKH). Sau khi có IDKH, IDKH sẽ được nhập qua bảng hợp đồng. IDKH đóng vai trò làm cầu nối giữa bảng hợp đồng & bảng khách hàng - điều này cũng trả lời cho câu hỏi - Hợp đồng này là của khách hàng nào! </p>
                        <p >Giải thích cơ chế của GH: <span class="text-info">Hãy hiểu rằng mỗi khách mới chỉ có 1 nguồn, nguồn khách sẽ được nhập vào Bảng Khách Hàng, hoàn toàn không nhập vào bảng hợp đồng. Ứng với mỗi hợp đồng sẽ có 1 ID khách hàng.</span>  </p>
                        <div class="form-group row">
                            <label for="name" class="col-12 col-md-4 col-form-label">** Họ Tên Khách Hàng Mới</label>
                            <div class="col-md-8 col-12">
                                <input type="text" class="form-control"
                                        id="customer_name_new" name="customer_name_new" placeholder="họ tên">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="birthdate" class="col-4 col-form-label">** Ngày sinh<span class="text-danger">*</span></label>
                            <div class="col-8">
                            <input type="text" name="birthdate_new" class="form-control datepicker" placeholder="dd/mm/yyyy">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-12 col-md-4 col-form-label">** Giới Tính<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <div class="radio radio-custom">
                                    <input type="radio" name="gender_new" checked id="male" value="male" checked>
                                    <label for="male">
                                        Nam
                                    </label>
                                </div>
                                <div class="radio radio-custom">
                                    <input type="radio" name="gender_new" id="sinva-rented" value="female">
                                    <label for="sinva-rented">
                                        Nữ
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-12 col-md-4 col-form-label">** Trạng thái (KH)<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <div class="radio radio-custom">
                                    <input type="radio" name="status_new" checked id="status_rented" value="" checked>
                                    <label for="status_rented">
                                        Đã ký
                                    </label>
                                </div>
                                <div class="radio radio-custom">
                                    <input type="radio" disabled="" name="status_new" id="status_follow" value="">
                                    <label for="status_follow">
                                        Đang theo dõi
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="ID_card" class="col-4 col-form-label">** CMT hoặc passport</label>
                            <div class="col-8">
                                <input type="text" class="form-control"
                                        id="ID_card" name="ID_card_new" placeholder="Cmnd, passport">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone" class="col-4 col-form-label">** Số điện thoại</label>
                            <div class="col-8">
                                <input type="number" class="form-control"
                                        id="phone" name="phone_new" placeholder="Số điện thoại">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-4 col-form-label">** Email</label>
                            <div class="col-8">
                                <input type="text" class="form-control"
                                        id="email" name="email_new" placeholder="Email">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="name" class="col-12 col-md-4 col-form-label">** Nguồn<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <div class="radio radio-custom">
                                    <input type="radio" name="source_new" id="DepMarketing" value="DepMarketing">
                                    <label for="DepMarketing">
                                        Bộ phận marketing
                                    </label>
                                </div>
                                <div class="radio radio-custom">
                                    <input type="radio" name="source_new" id="DepCustomerCare" value="DepCustomerCare">
                                    <label for="DepCustomerCare">
                                        Bộ phận chăm sóc khách hàng
                                    </label>
                                </div>
                                <div class="radio radio-custom">
                                    <input type="radio" name="source_new" id="DepSale" value="DepSale" checked>
                                    <label for="DepSale">
                                        Sale
                                    </label>
                                </div>
                                <div class="radio radio-custom">
                                    <input type="radio" name="source" id="DepOldSale" value="DepOldSale">
                                    <label for="DepOldSale">
                                        Khách Hàng Cũ Của Sale
                                    </label>
                                </div>
                                <div class="radio radio-custom">
                                    <input type="radio" name="source_new" id="DepReferral" value="DepReferral">
                                    <label for="DepReferral">
                                        Khách được giới thiệu
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h5>Thông tin hợp đồng (hoặc cọc)</h5>
                        <div class="form-group row">
                            <label for="name" class="col-12 col-md-4 col-form-label">Ngày ký <span class="text-danger">(bb)</span></label>
                            <div class="col-md-8 col-12">
                                <input type="text" required class="form-control contract-open"
                                        id="time_open" name="time_open">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-12 col-md-4 col-form-label">Số tháng ở <span class="text-danger">(bb)</span></label>
                            <div class="col-md-8 col-12">
                                <input  type="number" 
                                        required class="form-control"
                                        id="number_of_month" 
                                        name="number_of_month">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-12 col-md-4 col-form-label">Ngày hết hạn</label>
                            <div class="col-md-8 col-12">
                                <input type="text" class="form-control contract-time_expire"
                                        id="time_expire" name="time_expire">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="room_price" class="col-12 col-md-4 col-form-label">Giá Thuê <span class="text-danger"> (bb)</span></label>
                            <div class="col-md-8 col-12">
                                <input  type="text" 
                                        required class="form-control"
                                        id="room_price"
                                        value="<?= number_format($room['price']) ?>"
                                        name="room_price">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-12 col-md-4 col-form-label">Trạng thái Hợp đồng</label>
                            <div class="col-md-8 col-12">
                                <div class="radio radio-custom">
                                    <input type="radio" name="status" checked id="sinva-Active" value="Active">
                                    <label for="sinva-Active">
                                        Đang có hiệu lực
                                    </label>
                                </div>
                                <div class="radio radio-custom">
                                    <input type="radio" name="status" disabled id="sinva-Pending" value="Pending">
                                    <label for="sinva-Pending">
                                        Đợi ký HĐ (đang cọc)
                                    </label>
                                </div>
                                <div class="radio radio-custom">
                                    <input type="radio" name="status" id="sinva-Cancel" value="Cancel">
                                    <label for="sinva-Cancel">
                                        Hủy cọc
                                    </label>
                                </div>
                            </div>
                        </div>
                    
                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Ghi chú</label>
                            <div class="col-md-8 col-12">
                                <textarea class="form-control" disabled placeholder="sẽ mở khi áp dụng chính thức" rows="4" name="note"></textarea>
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
    $('.contract-open, .datepicker, .contract-time_expire').datepicker({
        format: "dd/mm/yyyy"
    });
    $(".select2").select2({
        placeholder: "Search for an Item",
        minimumInputLength: 2,
        ajax: {
            url: "<?= base_url().'admin/search-customer' ?>",
            dataType: 'json',
            processResults: function (data) {
                return {
                    results: data
                };
            }
        }
    });
    $( 'input[name=room_price]' ).on('keyup', function() {
        // 1
        var $this = $( 'input[name=room_price]');
        var input = $this.val();
        console.log(input);
        // 2
        var input = input.replace(/[\D\s\._\-]+/g, "");
        
        // 3
        input = input ? parseInt( input, 10 ) : 0;
        
        // 4
        $this.val( function() {
            return ( input === 0 ) ? "" : input.toLocaleString( "en-US" );
        } );
    });

});

</script>
