<?php 
    include VIEWPATH.'functions.php';
?>
<?php
$check_contract = in_array($this->auth['role_code'], ['consultant', 'customer-care', 'ceo', 'customer-care']);
$check_consultant_booking = in_array($this->auth['role_code'], ['customer-care', 'product-manager', 'ceo','consultant', 'human-resources']);
$check_option = in_array($this->auth['role_code'], ['customer-care', 'product-manager', 'ceo','consultant', 'human-resources']);
$check_commission_rate = in_array($this->auth['role_code'], ['customer-care','product-manager', 'ceo']);
?>

<div class="wrapper">
    <div class="sk-wandering-cubes" style="display:none" id="loader">
        <div class="sk-cube sk-cube1"></div>
    </div>
    <div class="container-fluid">
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
                    <h3 class="page-title">Danh sách dự án quận <?= $district_code?></h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 d-md-block d-none">
                <?php if(count($contract_noti) && isYourPermission('Apartment', 'showNotificaton', $this->permission_set)):?>
                    <div class="mt-1 text-center font-weight-bold">Thông báo các lượt tạo hợp đồng</div>
                    <?php foreach($contract_noti as $item):?>
                    <div class="m-2 alert alert-<?= $item['is_approve'] =='YES' ?"success" :'warning' ?> alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <?= $item['message'] . ' <br> Tạo lúc '. date('d/m/Y H:i', $item['time_insert']) ?>
                        <br><a href="/admin/detail-contract?id=<?= $item['object_id'] ?>">>> thông tin hợp đồng</a>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if(count($consultant_booking)):?>
                    <div class="mt-3 text-center font-weight-bold">Đăng ký lịch dẫn khách</div>
                    <?php foreach($consultant_booking as $booking):?>
                    <div class=" m-2 alert alert-primary alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <?= '<strong>'.$this->libUser->getNameByAccountid($booking['booking_user_id']) . '</strong> đã đăng ký dẫn khách ngày </strong> <strong>'. date('d/m/Y', $booking['time_booking']). '</strong> tại '. $this->libRoom->getAddressById($booking['room_id']) . ' : <strong>' . $this->libRoom->getCodeById($booking['room_id']). '</strong>'  ?>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php $this->load->view('apartment/metric', ['district_code' => $district_code]) ?>
            </div>
            <div class="pl-0 pr-0 col-12 col-md-8">
                <?php $this->load->view('components/list-navigation'); ?>
                <div class="shadow">
                    <?php $this->load->view('apartment/search-by-room-price'); ?>
                </div>

                <div class="mt-2 mb-3 list-action card-box shadow">
                    <span class="d-flex justify-content-center flex-wrap">
                    <?php foreach($list_district as $district): ?>
                        <a href="<?= base_url().'admin/list-apartment?district-code='.$district['code'] ?>" 
                            class="btn m-1 btn-sm btn-outline-success
                            <?= $district_code == $district['code'] ? 'active':'' ?>
                            btn-rounded waves-light waves-effect">
                            <?= $district['name'] ?></a>
                            
                    <?php endforeach; ?>
                    </span>
                    <div class="mt-3">
                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2 col-10 offset-1">
                                <input type="text" placeholder="Tìm kiếm dự án, vui lòng nhập địa chỉ..." class="form-control search-address border border-info">
                            </div>
                        </div>
                    </div>
                </div>

                <?php foreach ($list_apartment as $apartment): ?>
                <div class="card-header apartment-block" role="tab"
                     id="headingThree">
                    <?php if($apartment['short_message']) echo '<h5 class="col text-center notifier-apartment">'.$apartment["short_message"].'</h5>'; ?>
                    
                    <div class="row">
                        <div class="col-4">
                            <a class="apm-direction text-secondary font-weight-bold"><?= $apartment['partner_id'] ? $libPartner->getNameById($apartment['partner_id']):'#' ?></a>
                        </div>
                        <div class="col-4 text-center p-0">
                            <span class="text-primary" id="time-update-<?= $apartment['id'] ?>"><?= $apartment['time_update'] ? '<i class="mdi mdi-update"></i>'.date('d/m/Y H:i', 
                                max($apartment['time_update'],$ghRoom->getMaxTimeUpdate($apartment['id']))) :'' ?></span>
                        </div>
                        <div class="col-4 text-right">
                            <a class="apm-direction text-secondary font-weight-bold"><?= $apartment['direction'] ? $label_apartment[$apartment['direction']]:'#' ?></a>
                        </div>
                        <h5 class="col text-center notifier-apartment d-none">Tiêu đề Shock</h5>
                    </div>
                    <div class="mt-1 apm-tag-list">
                        <span>
                        <?php if($apartment['tag_id']): ?>
                            <span class="badge badge-pink"><?= $libTag->getNameById($apartment['tag_id']) ?></span>
                        </span>
                        <?php endif; ?>
                    </div>
                    <div class="col address-text text-center text-purple text-address font-weight-bold">
                        <?=$apartment['address_street'] ?>
                        <?=$apartment['address_ward'] ? ', Ph. '.$apartment['address_ward']:''  ?>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="mb-md-2">Mô tả dự án</h5>
                            <div class="more apm-description" 
                                data-pk="<?= $apartment['id'] ?>"
                                data-name= "description"
                                data-value="<?= $apartment['description'] ?>">
                                <?= $apartment['description'] ?>
                            </div>
                        </div>
                        <div class="col-md-4 font-weight-bold" >
                            <div class="text-right text-md-left">
                                <h5 class="mb-md-2">Số lượng phòng</h5>
                                <span>
                                    <span class="ml-4 text-success"><?= $ghRoom->getNumberByStatus($apartment['id'], 'Available') ?><i class="mdi mdi-checkerboard"></i></span>
                                    <span class="ml-2 text-warning"><?= $ghRoom->getNumberByTimeavailable($apartment['id']) ?><i class="mdi mdi-checkerboard"></i></span>
                                    <span class="ml-2 text-danger"><?= $ghRoom->getNumber($apartment['id']) ?><i class="mdi mdi-checkerboard"></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    

                    <div class="mt-2 list-action border-top">
                        <div class="d-flex justify-content-center notification-list">
                            <?php 
                            $list_comment = $ghApartmentComment->get(['apartment_id' => $apartment['id']]);
                            ?>
                            <a class="m-1 collapsed btn btn-sm btn-outline-warning btn-rounded waves-light waves-effect "
                                data-toggle="collapse" 
                                data-parent="#accordion" 
                                href="#modal-apartment-comment-<?=$apartment['id'] ?>" aria-expanded="false" aria-controls="#modal-apartment-comment-<?=$apartment['id'] ?>">
                                <i class="mdi mdi-comment-outline"></i>
                                <?php if(count($list_comment) > 0):?>
                                    <span class="badge badge-danger badge-pill mr-2 noti-icon-badge"><?= count($list_comment) ?></span>
                                <?php endif; ?>
                            </a>
                            <button type="button" 
                                    data-apartment-id="<?= $apartment['id'] ?>" 
                                    class="btn m-1 btn-sm apartment-reload-time btn-outline-custom btn-rounded waves-light waves-effect">
                                <i class="mdi mdi-update"></i>
                            </button>
                            <button type="button" class="btn m-1 btn-sm btn-outline-primary btn-rounded waves-light waves-effect" 
                                data-toggle="collapse" 
                                data-parent="#accordion"
                                aria-controls="#modal-apartment-detail-<?=$apartment['id'] ?>"
                                data-target="#modal-apartment-detail-<?=$apartment['id'] ?>">
                                <i class="mdi mdi-eye"></i>
                            </button>
                            <a href="/admin/upload-image?apartment-id=<?= $apartment['id'] ?>" target="_blank">
                                <button type="button" class="btn m-1 btn-sm btn-outline-primary btn-rounded waves-light waves-effect">
                                    <i class="mdi mdi-folder-multiple-image"></i>
                                </button>
                            </a>

                            <?php if($check_consultant_booking): ?>
                            <a href="<?= base_url() ?>admin/create-new-consultant-booking?apartment-id=<?= $apartment['id'] ?>&district-code=<?= $apartment['district_code'] ?>&mode=create">
                                <button type="button" class="btn m-1 btn-sm btn-outline-success btn-rounded waves-light waves-effect">
                                    <i class="mdi mdi-car-hatchback"></i>
                                </button>
                            </a>
                            <?php endif; ?>
                            
                            <button type="button" 
                                    data-apartment-id="<?= $apartment['id'] ?>" 
                                    class="btn m-1 btn-sm apartment-delete btn-outline-primary btn-rounded waves-light waves-effect">
                                <i class="mdi mdi-delete"></i>
                            </button>
                        </div>
                    </div> 
                </div>
                
                <div id="modal-apartment-comment-<?=$apartment['id'] ?>" class="collapse" role="tabpanel" aria-labelledby="modal-apartment-comment-<?=$apartment['id'] ?>">
                
                    <div class="card-body">
                        <h4 class="mb-4">Bình luận gần đây</h4>

                        <div class="comment-list slimscroll">
                            <div id='newContentComment'></div>
                        <?php if(count($list_comment) > 0): ?>
                            <?php foreach($list_comment as $comment):?>
                                <div class="comment-box-item taskList">
                                    <p class="commnet-item-date"><?= date('d/m/Y, H:i') ?></p>
                                    <p class="commnet-item-msg text-info"><?= $comment['content'] ?></p>

                                    <small class="commnet-item-user text-right text-danger"><?= $libUser->getNameByAccountid($comment['user_id']) ?></small>
                                </div>
                            <?php endforeach; ?>
                        <?php endif;?>
                        </div>
                    </div>
            
                </div>

                <div id="modal-apartment-detail-<?=$apartment['id'] ?>" class="collapse" role="tabpanel" aria-labelledby="modal-apartment-detail-<?=$apartment['id'] ?>">
                    <div class="card-box">
                        <ul class="nav nav-pills navtab-bg nav-justified pull-in ">
                            <li class="nav-item">
                                <a href="#apm-note-<?= $apartment['id'] ?>" 
                                    data-toggle="tab" 
                                    aria-expanded="false" 
                                    class="nav-link">
                                    <i class="mdi mdi-note-text mr-2"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#apm-service-<?= $apartment['id'] ?>" 
                                    data-toggle="tab" 
                                    aria-expanded="true" 
                                    class="nav-link active">
                                    <i class="mdi mdi-paw mr-2"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#apm-room-<?= $apartment['id'] ?>" data-toggle="tab" aria-expanded="false" class="nav-link">
                                    <i class="mdi mdi-border-all mr-2"></i>
                                </a>
                            </li>
                            <!-- <li class="nav-item">
                                <a href="#apm-map" data-toggle="tab" aria-expanded="false" class="nav-link">
                                    <i class="mdi mdi-google-maps mr-2"></i>
                                </a>
                            </li> -->
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane apm-note" id="apm-note-<?= $apartment['id'] ?>" 
                            data-pk="<?= $apartment['id'] ?>"
                            data-name= "note"
                            data-value="<?= $apartment['note'] ?>"
                            data-title="Enter username">
                                <p><?= $apartment['note'] ?></p>
                            </div>
                            <div class="tab-pane service-list show active" 
                                id="apm-service-<?= $apartment['id'] ?>">
                                <div id="carouselButton-<?= $apartment['id'] ?>" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner">
                                        <?php $this->load->view('apartment/service', ['apartment' => $apartment, 'label_apartment' => $label_apartment, 'check_commission_rate' => $check_commission_rate]) ?>
                                    </div>
                                    <a class="carousel-control-prev" 
                                        href="#carouselButton-<?= $apartment['id'] ?>" 
                                        role="button" 
                                        data-slide="prev"><i class="dripicons-chevron-left"></i> </a>
                                    <a class="carousel-control-next" 
                                        href="#carouselButton-<?= $apartment['id'] ?>" 
                                        role="button" 
                                        data-slide="next"><i class="dripicons-chevron-right"></i></a>
                                </div>
                            </div>
                            <div class="tab-pane" id="apm-room-<?= $apartment['id'] ?>">
                                <?php $this->load->view('apartment/room-full-permission',[
                                    'apartment' => $apartment,
                                    'libRoom' => $libRoom,
                                    'check_option' =>$check_option,
                                    'check_contract' =>$check_contract,
                                    'check_consultant_booking' => $check_consultant_booking
                                ]) ?>
                            </div>
                            <div class="tab-pane" id="apm-map">
                                <!-- Develop -->
                            </div>
                        </div>
                        <div class="float-right mt-1">
                            <a class="collapsed btn btn-sm btn-outline-warning btn-rounded waves-light waves-effect" 
                                data-toggle="collapse" 
                                data-parent="#accordion" 
                                href="#modal-apartment-detail-<?=$apartment['id'] ?>" aria-expanded="false" aria-controls="#modal-apartment-detail-<?=$apartment['id'] ?>">
                                <i class="mdi mdi-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
    </div>
</div>
<script>
    commands.push(function() {
        $(document).ready(function () {
            $.fn.editable.defaults.mode = 'inline';
            $.fn.combodate.defaults.maxYear = 2022;
            $.fn.combodate.defaults.minYear = 2020;
            var t_room = $('.list-room').DataTable({
                "fnDrawCallback": function() {
                    if(modify_mode == 'false') return;

                    $('.apm-note, .apm-description').editable({
                        type: "textarea",
                        url: '<?= base_url()."admin/update-apartment-editable" ?>',
                        inputclass: '',
                        rows: 8
                    });

                    $('.service-list ul li div').editable({
                        type: "text",
                        url: '<?= base_url()."admin/update-apartment-editable" ?>',
                        inputclass: ''
                    });

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

                    $('.list-room .room-consulting_user_id').editable({
                        type: "number",
                        url: '<?= base_url()."admin/update-room-editable" ?>',
                        inputclass: '',
                        placeholder:'171020XXX',
                    });

                    $('.list-room .room-select-type').editable({
                        type: 'select',
                        url: '<?= base_url() ?>admin/get-room-type',
                        inputclass: '',
                        source: function() {
                            data = [];
                            $.ajax({
                                url: '<?= base_url() ?>admin/get-room-type',
                                dataType: 'json',
                                async: false,
                                success: function(res) {
                                    data = res;
                                    return res;
                                }
                            });
                            return data;
                        },
                        success: function(response) {
                            var data = JSON.parse(response);
                            if(data.status == true) {
                                $('.apartment-alert').html(notify_html_success);
                            } else {
                                $('.apartment-alert').html(notify_html_fail);
                            }
                            $('.apartment-alert').show();
                            $('.apartment-alert').fadeOut(3000);
                        }
                    });

                    $('.list-room .room-select-status').editable({
                        type: 'select',
                        url: '<?= base_url() ?>admin/get-room-status',
                        inputclass: '',
                        source: function() {
                            data = [];
                            $.ajax({
                                url: '<?= base_url() ?>admin/get-room-status',
                                dataType: 'json',
                                async: false,
                                success: function(res) {
                                    data = res;
                                    return res;
                                }
                            });
                            return data;
                        },
                        success: function(response) {
                            var data = JSON.parse(response);
                            if(data.status == true) {
                                $('.apartment-alert').html(notify_html_success);
                            } else {
                                $('.apartment-alert').html(notify_html_fail);
                            }
                            $('.apartment-alert').show();
                            $('.apartment-alert').fadeOut(3000);
                        }
                    });

                    $('.list-room .room-time_available').editable({
                        placement: 'right',
                        type: 'combodate',
                        template:"D / MM / YYYY",
                        format:"DD-MM-YYYY",
                        viewformat:"DD-MM-YYYY",
                        mode: 'popup',
                        combodate: {
                            firstItem: 'name'
                        },
                        inputclass: 'form-control-sm',
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

                    $('.apartment-delete').on('click', function() {
                        let apartment_id = $(this).data('apartment-id');
                        let this_btn = $(this);
                        swal({
                            title: 'Bạn Muốn Ẩn Dự Án Này',
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonClass: 'btn btn-confirm mt-2',
                            cancelButtonClass: 'btn btn-cancel ml-2 mt-2',
                            confirmButtonText: 'Ẩn',
                        }).then(function () {
                            $.ajax({
                            url: '<?= base_url() ?>admin/update-apartment-editable',
                            data: {pk: apartment_id, name: 'active', value: 'NO', mode: 'del'},
                            type: 'POST',
                            success: function(response) {
                                    let data = JSON.parse(response);
                                    if(data.status > 0) {
                                        this_btn.parents('.apartment-block').fadeOut(1500, function(){
                                            this_btn.parents('.apartment-block').remove();
                                            $('#modal-apartment-detail-' + apartment_id).remove();
                                        });
                                    }
                                }
                            });
                            swal({
                                title: 'Đã Ẩn Thành Công!',
                                type: 'success',
                                confirmButtonClass: 'btn btn-confirm mt-2'
                            });
                        });

                        
                    });
                    // End Draw
                    }
                });
            $('.apartment-block').find('.list-action').show();
            // Default Datatable
            $('.apartment-reload-time').click(function(){
                var apm_id = $(this).data('apartment-id');
                $.ajax({
                    url:'<?= base_url()."admin/update-apartment-editable" ?>',
                    data: {pk: apm_id, name: '_reloadtime', value: '1'},
                    method: 'POST',
                    success:function(){
                        var t = "<?= date('d/m/Y H:i') ?>";
                        $('#time-update-'+apm_id).html('<i class="mdi mdi-update"></i>' + t);
                    }
                })
            });

            $('body').delegate('.room-status','click', function() {
                var content = $(this).text().trim();
                console.log(">> room.status current is: " + content);
                var room_id = $(this).data('id');
                if (content === "#") {
                    content = "trống";
                    var db_value = 'Available'
                } else {
                    content ="#";
                    var db_value = 'Full' 
                }
                console.log(room_id);
                $(this).text(content);
                $.ajax({
                    method: 'post',
                    url:'<?= base_url()."admin/update-room-editable" ?>',
                    data: {pk: room_id, name: 'status', value: db_value},
                    success: function(){
                        console.log('>> room.status updated to: '+ content);
                    }
                });
            });

            $('.room-add').click(function(){
                let apm_id = $(this).data('apartment-id');
                // rooom.destroy();
                let room = $('#list-room-' + apm_id).DataTable();
                // console.log(t_room);
                console.log(apm_id);
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url()."admin/create-room-datatable" ?>',
                    data: {apartment_id: apm_id},
                    success: function(data){
                        data = JSON.parse(data);
                        console.log(data);
                        let room_id = data.room_id;
                        let new_row = `
                        <tr>
                        <td><div class="room-data" 
                                data-pk="${room_id}"
                                data-value=""
                                data-name="code"
                                >000</div></td>
                        <td><div class="room-data" 
                                data-pk="${room_id}"
                                data-value=""
                                data-name="type"
                                >#</div></td>
                        <td><div class="room-price text-success"
                                data-pk="${room_id}"
                                data-value=""
                                data-name="price"
                                >#</div></td>
                        <td><div class="room-area" 
                                data-pk= "${room_id}"
                                data-value= ""
                                data-name="area">0</div></td>
                        <td><div class="room-status text-primary" 
                                data-pk="${room_id}"
                                data-value=""
                                data-name="status">#</div></td>
                        <td><div class="room-time_available text-success" 
                                data-pk="${room_id}"
                                data-value=""
                                data-name="time_available">#</div></td>
                        <td class="d-flex justify-content-center">
                            <button data-room-id="${room_id}" type="button" class="btn m-1 room-delete btn-sm btn-outline-danger btn-rounded waves-light waves-effect">
                                <i class="mdi mdi-delete"></i>
                            </button>
                        </td>     
                        </tr>
                        `;
                        room.row.add($(new_row)[0]).draw(false);
                    } // end success
                }); 
            });

            $('.search-address').on('keyup', function(){
                var value = $(this).val().toLowerCase();
                $(".card-header.apartment-block").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            // viewmore
            var showChar = 100;  // How many characters are shown by default
            var ellipsestext = "...";
            var moretext = "Xem thêm";
            var lesstext = "Thu gọn";

            $('.more').each(function() {
                var content = $(this).html();
        
                if(content.length > showChar) {
        
                    var c = content.substr(0, showChar);
                    var h = content.substr(showChar, content.length - showChar);
        
                    var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span> <a href="" class="morelink font-600 text-purple">' + moretext + '</a></span>';
        
                    $(this).html(html);
                }
        
            });
        
            $(".morelink").click(function(){
                if($(this).hasClass("less")) {
                    $(this).removeClass("less");
                    $(this).html(moretext);
                } else {
                    $(this).addClass("less");
                    $(this).html(lesstext);
                }
                $(this).parent().prev().toggle();
                $(this).prev().toggle();
                return false;
            });
        });

            //Warning Message
            $('.consultant-booking').click(function () {t
            let thisBooking = $(this);
            let time = null;
            swal({
                title: 'Book Phòng Dẫn Khách',
                text: "Chúc Bạn Chốt Khách Thành Công!",
                type: 'info',
                html: `
                    <label>Vui Lòng Chọn Ngày Dẫn Khách</label>
                    <input required class="datepicker form-control booking-time">`,
                showCancelButton: true,
                confirmButtonClass: 'btn btn-confirm mt-2',
                cancelButtonClass: 'btn btn-cancel ml-2 mt-2',
                confirmButtonText: 'Book',
                onOpen: function() {
                    $('.datepicker').datetimepicker({
                        inline: true,
                        sideBySide: true,
                        format: 'DD/MM/YYYY hh:mm a',
                    });
                },
            }).then(function () {
                roomId = thisBooking.data('room-id');
                time = $('.booking-time').val();
                console.log(time);
                console.log
                $.ajax({
                    method: "post",
                    url: "<?= base_url(). 'admin/create-consultant-booking' ?>",
                    data: {roomId: roomId, time: time }
                });
                swal({
                    title: 'Đã Book Xong!',
                    type: 'success',
                    confirmButtonClass: 'btn btn-confirm mt-2'
                }
                );

            })
        });

        $('.carousel').carousel({
            interval: false,
        });
        
        
        
        // $('.apartment-block').mouseenter(function() {
        //     $(this).find('.list-action').show(600);
        // }).mouseleave(function() {
        //     $(this).find('.list-action').hide(600); 
        // });
        
    });
</script>
