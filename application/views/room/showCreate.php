<?php
$check_option = true;
$check_contract = true;
$check_consultant_booking = true;

$check_update_room = false;
if(isYourPermission('Room', 'updateEditable', $this->permission_set)){
    $check_update_room = true;

}

$check_consultant_booking = false;
if(isYourPermission('ConsultantBooking', 'show', $this->permission_set)){
    $check_consultant_booking = true;
}

$check_create_promotion = false;
if(isYourPermission('ApartmentPromotion', 'create', $this->permission_set)){
    $check_create_promotion = true;
}
?>

<div class="wrapper">
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
                    <h2 class="font-weight-bold text-danger"><?= $apartment['address_street'] ?> | Cập Nhật Phòng</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <?php
                if($this->session->has_userdata('fast_notify')):
                    ?>
                    <div class="alert alert-<?= $this->session->flashdata('fast_notify')['status']?> alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('fast_notify')['message']?>
                    </div>
                    <?php unset($_SESSION['fast_notify']); endif; ?>
            </div>
        </div>

        <div class="role-alert"></div>
        <div class="row">
            <div class="form-group col-md-6 text-center">
                <select id="apartment_update_ready" class="form-control">
                    <option value="">Cập Nhật Phòng Dự Án Khác</option>
                    <?php foreach ($list_apm as $apm): ?>
                        <option value="<?= $apm['id'] ?>">Q.<?= $apm['district_code'] . ' ' . $apm['address_street'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12">
                <div class="card-box table-responsive">
                    <div class="d-flex justify-content-between">
                        <h4 class="font-weight-bold text-danger">Danh Sách Phòng | Cập Nhật <span id="time-info"><?= date('d-m-Y h:i\'', $apartment['time_update']) ?></span></h4>
                        <div class="">
                            <?php if($this->session->has_userdata('current_district_code')):?>
                                <a  href="<?= '/admin/list-apartment?district-code='.$this->session->userdata('current_district_code') ?>"><button type="button" class="btn btn-secondary m-1"><i class="mdi mdi-arrow-left-bold-circle"></i> Back</button></a>
                            <?php endif; ?>
                            <button id="update-time" data-apm="<?= $apartment['id'] ?>" class="btn btn-primary m-1"><i class=" mdi mdi-clock"></i> </button>
                            <?php if($check_create_promotion): ?>
                                <a class="" href="/admin/list-apartment-promotion?apartment-id=290">
                                    <button class="btn btn-primary m-1"><i class="mdi mdi-gift"></i> </button></a>
                            <?php endif; ?>
                            <?php if($check_consultant_booking): ?>
                                <a href="/admin/create-new-consultant-booking?apartment-id=<?= $apartment['id'] ?>&district-code=<?= $apartment['district_code'] ?>&mode=create">
                                    <button class="btn btn-danger m-1"><i class="mdi mdi-car-hatchback"></i> </button></a>
                            <?php endif; ?>
                            <a href="/admin/apartment/upload-img?apartment_id=<?= $apartment['id'] ?>"><button class="btn btn-primary m-1"> <i class="mdi mdi-folder-multiple-image"></i> </button></a>
                            <a href="/admin/profile-apartment?id=<?= $apartment['id'] ?>"><button class="btn btn-primary m-1"> <i class="mdi mdi-lead-pencil"></i></button></a>

                        </div>

                    </div>

                    <table id="list-room-<?= $apartment['id'] ?>"
                           class="table list-room mt-4">
                        <thead class="table-dark">
                        <tr>
                            <th class="font-weight-bold">Trục Phòng</th>
                            <th class="font-weight-bold">Mã Phòng</th>
                            <th>Loại Phòng</th>
                            <th>Giá <small>x1000</small></th>
                            <th class="text-center">Diện Tích</th>
                            <th>Trạng Thái</th>
                            <th>Ng.Trống</th>
                            <?php if($check_option):?>
                                <th>Tùy chọn</th>
                            <?php endif; ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($list_room)): ?>
                            <?php foreach($list_room as $room): ?>
                                <?php
                                if($room['status'] == 'Available') {
                                    $bg_for_available = 'bg-gh-apm-card';
                                    $color_for_available = 'text-primary';
                                }
                                else {
                                    $bg_for_available = '';
                                    $color_for_available = '';
                                }

                                $list_type_id = json_decode($room['room_type_id'], true);
                                $js_list_type = "";
                                $text_type_name = "";

                                $type_arr = [];
                                if($list_type_id) {
                                    $js_list_type = implode(",", $list_type_id);
                                    if ($list_type_id && count($list_type_id) > 0) {
                                        foreach ($list_type_id as $type_id) {
                                            $typeModel = $ghBaseRoomType->getFirstById($type_id);
                                            $type_arr[]= $typeModel['name'];
                                        }
                                    }
                                }
                                $text_type_name = implode(", ",$type_arr );

                                $status_txt = '<span class="badge badge-danger">Full</span>';
                                if($room['status'] === 'Available'){
                                    $status_txt = '<span class="badge badge-success">Trống</span>';
                                }

                                ?>
                                <tr class='<?= $bg_for_available ?> font-weight-bold'>
                                    <td><div class="room-shaft_id"
                                             data-pk="<?= $room['id'] ?>"
                                             data-value = "<?= $room['shaft_id'] ?>"
                                             data-name="shaft_id"><?= $room['shaft_id'] ? $libRoom->getNameByShaftId($room['shaft_id']) : '...' ?></div></td>
                                    <td><div class="room-data"
                                             data-pk="<?= $room['id'] ?>"
                                             data-value="<?= $room['code'] ?>"
                                             data-name="code"
                                        ><?= $room['code'] ? $room['code'] : 'không có thông tin' ?></div>
                                    </td>

                                    <td class="list-room-type"
                                        data-name="room_type_id"
                                        data-pk="<?= $room['id'] ?>"
                                        data-value="<?= $js_list_type ?>"><?= $text_type_name ? $text_type_name : "-" ?></td>

                                    <td><div class="room-price font-weight-bold"
                                             data-pk="<?= $room['id'] ?>"
                                             data-value="<?= $room['price'] ?>"
                                             data-name="price"><?= $room['price'] ? number_format($room['price']/1000): '-' ?></div></td>
                                    <td><div class="room-area text-center"
                                             data-pk= "<?= $room['id'] ?>"
                                             data-value= "<?= $room['area'] > 0 ? $room['area']:'' ?>"
                                             data-name="area"><?= $room['area'] > 0 ? $room['area']: '-' ?></div></td>
                                    <td><div class="room-select-status text-center <?= $color_for_available ?>"
                                             data-gh-status="<?= $room['status'] ?>"
                                             id="room-status-<?= $room['id'] ?>"
                                             data-id="<?= $room['id'] ?>"><?= $status_txt ?></div></td>
                                    <td><div class="room-time_available text-center"
                                             data-pk="<?= $room['id'] ?>"
                                             <?php if($room['time_available'] > 0):?>
                                             data-value="<?= date('d-m-Y',$room['time_available']) ?>"
                                             <?php endif ?>
                                             data-name="time_available"><?= $room['time_available'] > 0 ? date('d-m-Y',$room['time_available']) :' - ' ?></div></td>

                                    <?php if($check_option):?>
                                        <td class="">
                                            <div class="d-flex flex-column flex-md-row justify-content-center">
                                                <?php if($check_update_room): ?>
                                                <button data-room-id="<?= $room['id'] ?>" data-room-code="<?= $room['code'] ?>" type="button" class="btn m-1 room-delete btn-sm btn-outline-danger btn-rounded waves-light waves-effect">
                                                    <i class="mdi mdi-delete"></i>
                                                </button>
                                                <?php endif;?>

                                                <?php if($check_contract):?>
                                                    <a href="<?= base_url() ?>admin/create-contract-show?room-id=<?= $room['id'] ?>">
                                                        <button data-room-id="<?= $room['id'] ?>" type="button" class="btn m-1 btn-sm btn-outline-success btn-rounded waves-light waves-effect">
                                                            <i class="mdi mdi-file-document"></i>
                                                        </button>
                                                    </a>
                                                <?php endif;?>
                                            </div>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="col-12">
                <div class="card-box">
                    <h4 class="font-weight-bold text-danger">Trục Phòng</h4>

                    <div>
                        <?php foreach ($list_shaft as $item): ?>
                        <span class="badge badge-danger"><?= $item['name'] ?></span>
                        <?php endforeach;?>
                    </div>

                    <form role="form" method="post"
                          class="mt-5"
                          action="<?= base_url()?>/admin/room/create-shaft">
                        <input type="hidden" name="apartment_id" value="<?= $this->input->get('apartment-id') ?>">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-12 col-form-label">Tên Trục<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <input type="text" required class="form-control"
                                       id="name" name="name" placeholder="Tên Trục">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-8 offset-4">
                                <button type="submit" class="btn btn-danger waves-effect waves-light">
                                    Thêm Mới
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="card-box">

                    <h4 class="font-weight-bold text-danger">Thêm Mới</h4>

                    <form role="form" method="post"
                          action="<?= base_url()?>/admin/create-room?apartment-id=<?= $this->input->get('apartment-id') ?>">
                        <input type="hidden" name="apartment_id" value="<?= $this->input->get('apartment-id') ?>">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-12 col-form-label">Mã Phòng<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <input type="text" required class="form-control"
                                       id="code" name="code" placeholder="Mã Phòng">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-12 col-form-label">Giá<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <input type="number" required class="form-control"
                                       id="price" name="price" placeholder="Giá">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-12 col-form-label">Loại Phòng<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12 row">
                                <?php
                                $list_type = $ghBaseRoomType->get();
                                foreach ($list_type as $type):
                                ?>
                                <div class="col-6">
                                    <div>
                                        <div class=" checkbox checkbox-success">
                                            <input id="type-<?= $type['id'] ?>" type="checkbox" value="<?= $type['id'] ?>" name="room_type_id[]">
                                            <label for="type-<?= $type['id'] ?>">
                                                <?= $type['name'] ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach;?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-12 col-form-label">Diện Tích<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <input type="number" required class="form-control"
                                       id="area" name="area" placeholder="Diện Tích">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="hori-pass1" class="col-4 col-form-label">Trạng Thái</label>
                            <div class="col-8">
                                <select name="status" id="status" class="form-control">
                                    <option value="Available">Trống</option>
                                    <option value="Full">Full</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-12 col-form-label">Ngày Trống</label>
                            <div class="col-md-8 col-12">
                                <input type="text" class="form-control date-picker"
                                       id="time_available" name="time_available" placeholder="Ngày Trống">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-8 offset-4">
                                <button type="submit" class="btn btn-danger waves-effect waves-light">
                                    Thêm Mới
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-box">
                    <h4 class="font-weight-bold text-danger">Update Giá Phòng Nhanh</h4>
                    <div class="row">
                        <div id="notification" style="display: none;">
                            <div class="alert alert-success msg" role="alert">
                            </div>
                        </div>
                        <div class="col-12">
                            <textarea name="" id="fast-update" class="form-control"
                                      placeholder="301=5000000, 302=5500000" cols="30" rows="10"></textarea>
                        </div>
                        <div class="col-12 text-center mt-1">
                            <button class="btn btn-danger" id="checker-update">Cập Nhật</button>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end row -->

    </div> <!-- end container -->
</div>
<script type="text/javascript">
    commands.push(function() {
        $(document).ready(function() {

            $('#update-time').click(function () {
                $.ajax({
                    method: 'post',
                    url:'<?= base_url()."admin/update-apartment-editable" ?>',
                    data: {pk: $(this).data('apm') ,mode: 'only_time_update'},
                    dataType: "json",
                    success: function (res) {
                        console.log(res);
                        $('#time-info').text(res.content);
                        $('#time-info').addClass('bg-success text-light pl-2 pr-2');
                        setTimeout(function(){ $('#time-info').removeClass('bg-success text-light pl-2 pr-2') }, 1500);

                    }
                });
            });


            $('#checker-update').click(function () {
                let content = $('#fast-update').val();

                if(content.length) {
                    content =  content.replace(/[\r\n]+/gm, "");
                    let arr_item =  content.split(",");
                    let result = [];
                    for(let xx of arr_item) {
                        let ii = xx.split("=");
                        if(ii.length === 2) {
                            result.push({code:ii[0], price:ii[1]});
                        }
                    }

                    $.ajax({
                        url: '/admin/room/fast-update',
                        data: {apartment_id: '<?= $this->input->get("apartment-id") ?>', room_code: result},
                        method: 'POST',
                        success: function (res) {
                            res = JSON.parse(res);
                            $('#notification').show();
                            $('#notification .msg').text(res.msg);

                        }
                    });
                }
            });

            <?php if($check_update_room): ?>
            $('.room-select-status').click(function() {
                let status = $(this).data('gh-status');
                let room_id = $(this).data('id');
                let update = 'Full';
                if(status === 'Available') {
                    $('#room-status-'+room_id).html('<span class="badge badge-danger">Full</span>');
                    update = 'Full';
                    $('#room-status-'+room_id).data('gh-status', update);
                }

                if(status === 'Full') {
                    $('#room-status-'+room_id).html('<span class="badge badge-success">Trống</span>');
                    update = 'Available';
                    $('#room-status-'+room_id).data('gh-status', update);
                }

                $.ajax({
                    method: 'post',
                    url:'<?= base_url()."admin/update-room-editable" ?>',
                    data: {pk: room_id, name: 'status', value: update}
                });
            });
            <?php endif; ?>


            $('.list-room').DataTable({
                "pageLength": 10,
                'pagingType': "full_numbers",
                 responsive: true,
                "fnDrawCallback": function() {
                    <?php if($check_update_room): ?>

                    $('.list-room .room-data').editable({
                        type: "text",
                        url: '<?= base_url()."admin/update-room-editable" ?>',
                        inputclass: ''
                    }).on("shown", tab_key);

                    $('.list-room .room-price, .list-room .room-area').editable({
                        type: "number",
                        url: '<?= base_url()."admin/update-room-editable" ?>',
                        inputclass: '',
                        display: function(value, response) {
                            return false;   //disable this method
                        },
                        success: function(response, newValue) {
                            $(this).html(nFormatter(newValue));
                        }
                    }).on("shown", tab_key);

                    $('.list-room-type').click(function(){
                        $(this).editable({
                            type: 'checklist',
                            url: '<?= base_url() ?>admin/update-room-editable',
                            inputclass: '',
                            source: function () {
                                let data = [];
                                $.ajax({
                                    url: '<?= base_url() ?>admin/room-type/get-list-editable',
                                    dataType: 'json',
                                    async: false,
                                    success: function (res) {
                                        data = res;
                                        return res;
                                    }
                                });
                                return data;
                            }
                        });
                    });



                    $('.list-room .room-time_available').editable({
                        type:'date',
                        format: 'dd-mm-yyyy',
                        viewformat: 'dd-mm-yyyy',
                        datepicker: {
                            "setDate": new Date(),
                            "autoclose": true
                        },
                        placement: 'left',
                        url: '<?= base_url()."admin/update-room-editable" ?>'
                    });

                    $('.room-delete').on('click', function() {
                        let this_btn = $(this);
                        let room_id = $(this).data('room-id');
                        let room_code = $(this).data('room-code');
                        swal({
                            title: 'Bạn Muốn Xóa Phòng ' + room_code,
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonClass: 'btn btn-confirm mt-2',
                            cancelButtonClass: 'btn btn-cancel ml-2 mt-2',
                            confirmButtonText: 'Xóa',
                        }).then(function () {
                            $.ajax({
                                type: 'POST',
                                url:'<?= base_url()."admin/update-room-editable" ?>',
                                data: {pk: room_id, name: 'active', value: 'NO'},
                                success:function(response) {
                                    let data = JSON.parse(response);
                                    if(data.status > 0) {
                                        this_btn.parents('tr').remove();
                                    }
                                }
                            });
                            swal({
                                title: 'Đã Xóa Thành Công!',
                                type: 'success',
                                confirmButtonClass: 'btn btn-confirm mt-2'
                            });
                        })
                    });

                    $('.room-shaft_id').click(function(){
                        $(this).editable({
                            type: 'select',
                            url: '<?= base_url()."admin/update-room-editable" ?>',
                            inputclass: '',
                            source: function() {
                                data = [];
                                $.ajax({
                                    url: '<?= base_url() ?>admin/get-room-shaft?apartment-id=<?= $apartment["id"] ?>',
                                    dataType: 'json',
                                    async: false,
                                    success: function(res) {
                                        data = res;
                                        return res;
                                    }
                                });
                                return data;
                            },

                        });
                    });
                    // End Draw

                    <?php endif; ?>
                }
            });
            $('.date-picker').datepicker({
                format: "dd-mm-yyyy"
            });
            $('#apartment_update_ready').select2();
            $('#apartment_update_ready').change(function () {
                window.location = '/admin/room/show-create?apartment-id='+$(this).val();
            });

        });
    });
</script>