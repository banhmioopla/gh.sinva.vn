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
                    <h2 class="text-danger font-weight-bold">Tạo Hợp Đồng</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="card-box shadow">
                    <h4 class="m-t-0 font-weight-bold text-danger">Thông Tin Dự Án</h4>
                    <table class="table">
                        <tr>
                            <td><strong>Quận</strong></td>
                            <td class="text-right"><?= $libDistrict->getNameByCode($apartment['district_code']) ?></td>
                        </tr>
                        <tr>
                            <td><strong>Địa chỉ<strong></td>
                            <td class="text-right"><?= $apartment['address_street'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Mã Phòng<strong></td>
                            <td class="text-right"><?= $room['code'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Giá Phòng<strong></td>
                            <td class="text-right"><?= number_format($room['price'], 0, '', ',')  ?></td>
                        </tr>
                    </table>
                    <h4 class="m-t-0 font-weight-bold text-danger">Thông tin dịch vụ</h4>
                    <table class="table">
                        <tr>
                            <td><strong>Ghi Chú<strong></td>
                            <td style="white-space: pre-line;"><?= $apartment['note'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Hoa Hồng 12 Tháng<strong></td>
                            <td style="white-space: pre-line;"
                                class="text-right"
                                id="cr_12m"
                                data-cr="<?= $apartment['commission_rate'] ?>">
                                <?= $apartment['commission_rate'] ?>%</td>
                        </tr>
                        <tr>
                            <td><strong>Hoa Hồng 9 Tháng<strong></td>
                            <td style="white-space: pre-line;"
                                class="text-right"
                                id="cr_9m"
                                data-cr="<?= $apartment['commission_rate_9m'] ?>">
                                <?= $apartment['commission_rate_9m'] ?>%</td>
                        </tr>
                        <tr>
                            <td><strong>Hoa Hồng 6 Tháng<strong></td>
                            <td style="white-space: pre-line;"
                                class="text-right"
                                id="cr_6m"
                                data-cr="<?= $apartment['commission_rate_6m'] ?>"><?= $apartment['commission_rate_6m']
                                ?>%</td>
                        </tr>
                        <tr>
                            <td><strong>Điện</strong></td>
                            <td class="text-right"><?= $apartment['electricity'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Nước<strong></td>
                            <td class="text-right"><?= $apartment['water'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Internet<strong></td>
                            <td class="text-right"><?= $apartment['internet'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Thang máy<strong></td>
                            <td class="text-right"><?= $apartment['elevator'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Máy giặt<strong></td>
                            <td class="text-right"><?= $apartment['washing_machine'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Dọn phòng<strong></td>
                            <td class="text-right"><?= $apartment['room_cleaning'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Giữ xe<strong></td>
                            <td class="text-right"><?= $apartment['parking'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Giữ xe Oto<strong></td>
                            <td class="text-right"><?= $apartment['car_park'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Bếp<strong></td>
                            <td class="text-right"><?= $apartment['kitchen'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>KT3<strong></td>
                            <td class="text-right"><?= $apartment['kt3'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Thú cưng<strong></td>
                            <td class="text-right"><?= $apartment['pet'] ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-12 col-md-8">
                <div class="card-box shadow">
                    <h4 class="m-t-0 text-danger font-weight-bold">Hợp Đồng Mới</h4>
                    <hr>
                    <form role="form" method="post" autocomplete="off"
                          enctype="multipart/form-data" action="<?= base_url()?>admin/create-contract">
                        <input type="hidden" name='room_id' value= '<?= $_GET["room-id"]?>'>
                        <input type="hidden" name='room_code' value= '<?= $room['code']?>'>
                        <input type="hidden" name='apartment_id' value= '<?= $room['apartment_id']?>'>
                        <div class="form-group row">
                            <label for="consultant_id" class="col-12 col-md-4 col-form-label text-right">Thành Viên Chốt</span></label>
                            <?php if($check_consultant_id):?>
                                <div class="col-md-6 col-12">
                                    <select type="number" class="form-control" required
                                            id="consultant_id" name="consultant_id" placeholder="171020xxx">
                                        <?= $select_user?>
                                    </select>
                                </div>
                            <?php else: ?>
                                <div class="col-md-6 col-12">
                                    <input type="text" class="form-control"
                                           id="consultant_id" readonly name="consultant_id" value="<?= $this->auth['account_id']?>">
                                    <p class="p-2 text-light bg-dark text-right"><?= $this->auth['name'] ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <hr>
                        <h5 class="font-weight-bold"><u>Thông Tin Khách Thuê</u></h5>
                        <div class="form-group row old-customer">
                            <label for="name" class="col-12 col-md-4 col-form-label text-right">Số Điện Thoại</label>
                            <div class="col-md-6 col-12">
                                <input type="text" class="form-control is-valid"
                                       autocomplete="autocomplete_off_hack_xfr4!k<?= time() ?>"
                                       id="phone" name="phone" placeholder="Số điện thoại">
                                <p class="p-2 text-light bg-dark text-right text-success" style="display: none" id="customer-short-info" ></p>
                                <p class="text-danger msg-phone p-2"></p>
                            </div>
                        </div>
                        <div class="form-group row old-customer">
                            <label for="name" class="col-12 col-md-4 col-form-label text-right">Họ & Tên</label>
                            <div class="col-md-6 col-12">
                                <input type="text" class="form-control"
                                       autocomplete="none"
                                       id="name" name="name" placeholder="Họ & Tên">
                                <p class="text-danger msg-name p-2"></p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="birthdate" class="col-4 col-form-label text-right">Ngày Sinh</label>
                            <div class="col-md-6 col-12">
                                <input type="text" name="birthdate"
                                       autocomplete="false"
                                       id="birthdate" class="form-control datepicker" placeholder="ngày - tháng - năm">
                                <p class="text-danger msg-birthdate p-2"></p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ID_card" class="col-md-4 col-12 col-form-label text-right">Chứng minh thư, Passport</label>
                            <div class="col-md-6 col-12">
                                <input type="text" class="form-control"
                                       autocomplete="false"
                                       id="ID_card" name="ID_card" placeholder="Chứng minh thư, Passport">
                                <p class="text-danger msg-ID_card p-2"></p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-12 col-form-label text-right">Email</label>
                            <div class="col-md-6 col-12">
                                <input type="text" class="form-control"
                                       autocomplete="autocomplete_off_hack_xfr4!k"
                                       id="email" name="email" placeholder="Email">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-12 col-md-4 col-form-label text-right">Giới Tính</label>
                            <div class="col-md-6 col-12">
                                <div class="radio radio-danger">
                                    <input type="radio" name="gender" id="male" value="male" checked>
                                    <label for="male">
                                        Nam
                                    </label>
                                </div>
                                <div class="radio radio-danger">
                                    <input type="radio" name="gender" id="sinva-rented" value="female">
                                    <label for="sinva-rented">
                                        Nữ
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-12 col-md-4 col-form-label text-right">Trạng Thái<span class="text-danger">*</span></label>
                            <div class="col-md-6 col-12">
                                <div class="radio radio-danger">
                                    <input type="radio" name="customer_status" checked id="status_rented" value="" checked>
                                    <label for="status_rented">
                                        Đã ký
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-12 col-md-4 col-form-label text-right">Nguồn<span class="text-danger">*</span></label>
                            <div class="col-md-6 col-12">
                                <div class="radio radio-danger">
                                    <input type="radio" name="source" id="DepMarketing" value="DepMarketing">
                                    <label for="DepMarketing">
                                        Bộ phận marketing
                                    </label>
                                </div>
                                <div class="radio radio-danger">
                                    <input type="radio" name="source" id="DepCustomerCare" value="DepCustomerCare">
                                    <label for="DepCustomerCare">
                                        Bộ phận chăm sóc khách hàng
                                    </label>
                                </div>
                                <div class="radio radio-danger">
                                    <input type="radio" name="source" id="DepSale" value="DepSale" checked>
                                    <label for="DepSale">
                                        Sale
                                    </label>
                                </div>
                                <div class="radio radio-danger">
                                    <input type="radio" name="source" id="DepOldSale" value="DepOldSale">
                                    <label for="DepOldSale">
                                        Khách Hàng Cũ Của Sale
                                    </label>
                                </div>
                                <div class="radio radio-custom">
                                    <input type="radio" name="source" id="DepReferral" value="DepReferral">
                                    <label for="DepReferral">
                                        Khách được giới thiệu
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- end new version -->

                        <hr>
                        <h5 class="font-weight-bold"><u>Thông Tin Hợp Đồng</u></h5>
                        <div class="form-group row">
                            <label for="time_check_in" class="col-12 col-md-4 col-form-label text-right">Ngày ký</label>
                            <div class="col-md-6 col-12">
                                <input type="text" required class="form-control datepicker"
                                       autocomplete="autocomplete_off_hack_xfr4!k"
                                       id="time_check_in" name="time_check_in">
                                <p class="text-danger msg-time_check_in"></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="number_of_month" class="col-12 col-md-4 col-form-label text-right">Số
                                tháng thuê</label>
                            <div class="col-md-6 col-12">
                                <input  type="number"
                                        required class="form-control"
                                        id="number_of_month"
                                        autocomplete="autocomplete_off_hack_xfr4!k"
                                        name="number_of_month">
                                <p class="text-danger msg-number_of_month"></p>
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="time_expire" class="col-12 col-md-4 col-form-label text-right">Ngày Hết Hạn</label>
                            <div class="col-md-6 col-12">
                                <input type="text" class="form-control datepicker"
                                       autocomplete="autocomplete_off_hack_xfr4!k"
                                       id="time_expire" name="time_expire">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="room_price" class="col-12 col-md-4
                            col-form-label text-right">Giá Thuê <span class="text-danger">*</span></label>
                            <div class="col-md-6 col-12">
                                <input  type="text"
                                        required class="form-control"
                                        id="room_price"
                                        value="<?= number_format($room['price']) ?>"
                                        name="room_price">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="commission_rate" class="col-12 col-md-4
                            col-form-label text-right">Hoa Hồng Ký Gửi</label>
                            <div class="col-md-6 col-12">
                                <input  type="number"
                                        class="form-control"
                                        value=""
                                        id="commission_rate"
                                        placeholder="81"
                                        name="commission_rate">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-12 col-md-4 col-form-label text-right">Trạng thái Hợp đồng </label>
                            <div class="col-md-8 col-12">
                                <div class="radio radio-danger">
                                    <input type="radio" name="status" checked id="sinva-Active" value="Active">
                                    <label for="sinva-Active">
                                        Đang Còn Hạn
                                    </label>
                                </div>
                                <div class="radio radio-danger">
                                    <input type="radio" name="status" disabled id="sinva-Pending" value="Pending">
                                    <label for="sinva-Pending">
                                        Đợi Duyệt
                                    </label>
                                </div>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="file" class="col-12 col-md-4
                            col-form-label text-right">Ảnh Hợp Đồng</label>
                            <div class="col-md-8 col-12">
                                <input type="file"
                                       required
                                       id="file"
                                       multiple
                                       class="filestyle"
                                       name="files[]"
                                       data-input="false" data-btnClass="btn-secondary">
                                <p class="number-file"></p>
                                <p class="text-danger msg-file"></p>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label text-right">Ghi chú</label>
                            <div class="col-md-8 col-12">
                                <textarea class="form-control" rows="4" name="note"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-8 offset-4">
                                <button type="button" id="submitNewContract" class="btn btn-danger waves-effect waves-light">
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
        $('.datepicker').datepicker({
            format: "dd-mm-yyyy"
        });

        $(':file').change(function () {
            $('.number-file').text(this.files.length + " ảnh");
        });

        $('input[name=number_of_month]').change(function () {
            let number_of_month = $(this).val();
            let cr_6m = $('#cr_6m').data('cr');
            let cr_9m = $('#cr_9m').data('cr');
            let cr_12m = $('#cr_12m').data('cr');

            let contract_cr = $('input[name=commission_rate]');
            contract_cr.val(0);
            if(cr_6m == '') {
                cr_6m = 0;
            }

            if(cr_9m == '') {
                cr_9m = 0;
            }

            if(cr_12m == '') {
                cr_12m = 0;
            }

            if(cr_6m == 0 && cr_9m == 0) {
                contract_cr.val(cr_12m/12*number_of_month);
                return;
            }

            if(cr_6m == 0 && cr_12m == 0) {
                contract_cr.val(cr_9m/9*number_of_month);
                return;
            }

            if(cr_9m == 0 && cr_12m == 0) {
                contract_cr.val(cr_6m/6*number_of_month);
                return;
            }

            /*TH*/

            if(cr_6m == 0) {
                if(number_of_month <= 9 ) {
                    contract_cr.val(cr_9m/9*number_of_month);
                    return;
                } else {
                    contract_cr.val(cr_12m/12*number_of_month);
                    return;
                }

            }

            if(cr_9m == 0) {
                if(number_of_month <= 6 ) {
                    contract_cr.val(cr_6m/6*number_of_month);
                    return;
                } else {
                    contract_cr.val(cr_12m/12*number_of_month);
                    return;
                }

            }

            if(cr_12m == 0) {
                if(number_of_month <= 6 ) {
                    contract_cr.val(cr_6m/6*number_of_month);
                    return;
                } else {
                    contract_cr.val(cr_9m/9*number_of_month);
                    return;
                }

            }

            /*TH*/



            if(number_of_month > 6 && cr_9m > 0) {
                contract_cr.val(cr_9m/9*number_of_month);
            }

            if(number_of_month > 9 && cr_12m > 0) {
                contract_cr.val(cr_12m/12*number_of_month);
            }

            if(number_of_month <= 6 && cr_6m > 0) {
                contract_cr.val(cr_6m/6*number_of_month);
            }

            console.log(contract_cr.val());


        });

        $('#phone').change(function(){
            let phone_search = $(this).val();
            $.ajax({
                url: "<?= base_url().'admin/search-customer' ?>",
                method: "get",
                data: {q:phone_search, full: 'true'},
                success:function (data) {

                    data = JSON.parse(data);
                    let customer_short_info = $('#customer-short-info');
                    let form_phone = $('#phone');
                    let form_name = $('#name');
                    let form_birthdate = $('#birthdate');
                    let form_email = $('#email');
                    let form_ID_card = $('#ID_card');
                    let form_gender = $('input[name=gender]');
                    let form_customer_status = $('input[name=customer_status]');
                    let form_source = $('input[name=source]');
                    console.log(data.status);
                    if(data.status === true) {
                        let profile = data.profile;
                        customer_short_info.show();
                        customer_short_info.text(profile.name + ' - ' + profile.phone);

                        /*set value input*/
                        form_phone.val(profile.phone);

                        form_name.val(profile.name);
                        form_name.prop( "disabled", true );

                        form_birthdate.val(profile.birthdate);
                        form_birthdate.prop( "disabled", true );

                        form_email.val(profile.email);
                        form_email.prop( "disabled", true );

                        form_ID_card.val(profile.ID_card);
                        form_email.prop( "disabled", true );

                        form_gender.val(profile.gender);
                        form_gender.prop( "disabled", true );
                    } else {
                        if(phone_search.length > 0) {
                            customer_short_info.show();
                            customer_short_info.html('<i class="mdi mdi-heart"></i> Chào mừng khách hàng mới, vui lòng nhập đầy đủ thông tin tiếp theo nhé!');
                        } else {
                            customer_short_info.hide();
                            customer_short_info.html("");
                        }

                    }

                }
            });
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
            let check = false;

            if($('#birthdate').val().length === 0) {
                $('.msg-birthdate').text('thông tin này là bắt buộc');
                check = false;
            } else {
                check = true;
                $('.msg-birthdate').text('');
            }

            if($('#name').val().length === 0) {
                $('.msg-name').text('thông tin này là bắt buộc');
                check = false;
            } else {
                check = true;
                $('.msg-name').text('');
            }

            if($('#phone').val().length === 0) {
                $('.msg-phone').text('thông tin này là bắt buộc');
                check = false;
            } else {
                check = true;
                $('.msg-phone').text('');
            }

            if($('#file')[0].files.length == 0){
                $('.msg-file').text('vui lòng chọn ảnh hợp đồng');
                check = false;
            } else {
                check = true;
                $('.msg-file').text('');
            }


            if(check) {
                $('form').submit();
            }
        });



    });

</script>
