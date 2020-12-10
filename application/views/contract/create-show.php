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
                <div class="card-box shadow">
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
                <div class="card-box shadow">
                    <h4 class="m-t-0">Hợp Đồng Mới</h4>
                    <hr>
                    <form role="form" method="post" enctype="multipart/form-data" action="<?= base_url()?>admin/create-contract">
                        <input type="hidden" name='room_id' value= '<?= $_GET["room-id"]?>'>
                        <input type="hidden" name='room_code' value= '<?= $room['code']?>'>
                        <input type="hidden" name='apartment_id' value= '<?= $room['apartment_id']?>'>
                        <div class="form-group row">
                            <label for="consultant_id" class="col-12 col-md-4 col-form-label">Thành viên tư vấn<span class="text-danger"> (bb)</span></label>
                            <?php if($check_consultant_id):?>
                            <div class="col-md-8 col-12">
                                <select type="number" class="form-control" required
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
                        <h5>Thông Tin Khách Thuê</h5>
                        <div class="form-group row old-customer">
                            <label for="name" class="col-12 col-md-4 col-form-label">Khách Tiềm Năng Đã Lưu</label>
                            <div class="col-md-8 col-12">
                            <select class="form-control select2" id="customer_name" name="customer_name">
                            </select>
                            <p class="text-danger msg-customer_name"></p>
                            </div>
                        </div>
                        <div class="new-customer">
                            <div class="form-group row">
                                <label for="phone_new" class="col-md-4 col-12 col-form-label">** Số điện thoại</label>
                                <div class="col-md-8 col-12">
                                    <input type="number" class="form-control"
                                            id="phone_new" name="phone_new" placeholder="Số điện thoại">
                                            <p class="text-danger msg-phone_new"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-12 col-md-4 col-form-label">** Họ & Tên Khách Thuê</label>
                                <div class="col-md-8 col-12">
                                    <input type="text" class="form-control"
                                            id="customer_name_new" name="customer_name_new" placeholder="họ tên">
                                    <p class="msg-customer_name_new text-danger"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="birthdate" class="col-4 col-form-label">** Ngày sinh<span class="text-danger">*</span></label>
                                <div class="col-8">
                                <input type="text" name="birthdate_new" class="form-control datepicker" placeholder="dd/mm/yyyy">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ID_card" class="col-md-4 col-12 col-form-label">** CMND hoặc passport</label>
                                <div class="col-md-8 col-12">
                                    <input type="text" class="form-control"
                                            id="ID_card" name="ID_card_new" placeholder="Cmnd, passport">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-12 col-form-label">** Email</label>
                                <div class="col-md-8 col-12">
                                    <input type="text" class="form-control"
                                            id="email" name="email_new" placeholder="Email">
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
                        </div>

                        
                        <hr>
                        <h5>Thông tin hợp đồng (hoặc cọc)</h5>
                        <div class="form-group row">
                            <label for="name" class="col-12 col-md-4 col-form-label">Ngày ký <span class="text-danger">(bb)</span></label>
                            <div class="col-md-8 col-12">
                                <input type="text" required class="form-control contract-open"
                                       autocomplete="off"
                                        id="time_open" name="time_open">
                                        <p class="text-danger msg-time_open"></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-12 col-md-4 col-form-label">Số tháng ở <span class="text-danger">(bb)</span></label>
                            <div class="col-md-8 col-12">
                                <input  type="number" 
                                        required class="form-control"
                                        id="number_of_month" 
                                        name="number_of_month">
                                <p class="text-danger msg-number_of_month"></p>
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
                            <label for="room_price" class="col-12 col-md-4
                            col-form-label">Hoa Hồng Ký Gửi <span class="text-danger">
                                    (bb)
                                </span></label>
                            <div class="col-md-8 col-12">
                                <input  type="number"
                                        required class="form-control"
                                        value=""
                                        placeholder="vd: 80%"
                                        name="commission_rate">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-12 col-md-4 col-form-label">Trạng thái Hợp đồng</label>
                            <div class="col-md-8 col-12">
                                <div class="radio radio-custom">
                                    <input type="radio" name="status" checked id="sinva-Active" value="Active">
                                    <label for="sinva-Active">
                                        Còn hạn (gh sẽ tự động chọn "đợi duyệt" nếu bạn không phải TV Chăm sóc khách hàng)
                                    </label>
                                </div>
                                <div class="radio radio-custom">
                                    <input type="radio" name="status" disabled id="sinva-Pending" value="Pending">
                                    <label for="sinva-Pending">
                                        Đợi duyệt
                                    </label>
                                </div>
                            </div>
                        </div>

                        
                        <div class="form-group row">
                            <label for="file" class="col-12 col-md-4 col-form-label">Upload Ảnh Hợp Đồng</label>
                            <div class="col-md-8 col-12">
                                <input type="file"
                                    required
                                    id="file"
                                    multiple
                                    class="filestyle" 
                                    name="files[]"
                                    data-input="false" data-btnClass="btn-info">
                                <p class="number-file"></p>
                                <p class="text-danger msg-file"></p>
                            </div>
                        </div>
                            
                    
                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Ghi chú</label>
                            <div class="col-md-8 col-12">
                                <textarea class="form-control" rows="4" name="note"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-8 offset-4">
                                <button type="button" id="submitNewContract" class="btn btn-custom waves-effect waves-light">
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

    $(':file').change(function () {
        $('.number-file').text(this.files.length + " ảnh được chọn");
    });

    $('.new-customer').hide();
    $(".select2").select2({
        placeholder: "Search for an Item",
        minimumInputLength: 1,
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
    
    $('.select2').on('select2:closing', function(){
        console.log('closing');
        console.log($(this).val());
        let phone_number = $('.select2-search__field')[0].value;
        if($(this).val() == null && phone_number.length > 5) {
            $('.new-customer').show();
            $('.old-customer').hide();
            $('#phone_new').val(phone_number);
        } else {
            $('.old-customer').show();
            $('.new-customer').hide();
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
        });
    });

    $('#submitNewContract').click(function(){
        let customer_name = $('select[name=customer_name]').val(); // old customer
        console.log(customer_name);
        let customer_name_new = $('input[name=customer_name_new]').val();
        let phone_new = $('input[name=phone_new]').val();
        let check = true;
        let number_of_month = $('input[name=number_of_month]').val();
        let time_open = $('input[name=time_open]').val();
        let room_price = $('input[name=room_price]').val();
        if(customer_name == null) {
            
            if(customer_name_new == '') {
                $('.msg-customer_name_new').text('vui lòng nhập họ tên khách thuê');
                check = false;
            } else {
                $('.msg-customer_name_new').text('');
            
            }

            if(phone_new == '' || phone_new.length < 5) {
                $('.msg-phone_new').text('vui lòng nhập số điện thoại khách thuê');
                check = false;
            } else {
                $('.msg-phone_new').text('');
            }
            
        }

        if(customer_name == null && customer_name_new == '') {
            check = false;
            $('.msg-customer_name').text('vui lòng nhập SDT khách thuê');
        } else {
            $('.msg-customer_name').text('');
        }
        
        if(number_of_month == '') {
            $('.msg-number_of_month').text('vui lòng nhập thời hạn thuê (x tháng)');
            check = false;
        } else {
            $('.msg-number_of_month').text('');
        }
        
        if(time_open == '') {
            $('.msg-time_open').text('vui lòng nhập ngày ký');
            check = false;
        } else {
            $('.msg-time_open').text('');
        }
        
        if(room_price == '') {
            $('.msg-room_price').text('vui lòng nhập giá thuê');
            check = false;
        } else {
            $('.msg-room_price').text('');
        }

        if($('#file')[0].files.length == 0){
            $('.msg-file').text('vui lòng chọn ảnh hợp đồng');
            check = false;
        } else {
            $('.msg-file').text('');
        }


        if(check) {
            $('form').submit();
        }


        


    });



});

</script>
