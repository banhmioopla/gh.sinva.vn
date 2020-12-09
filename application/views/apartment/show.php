<?php
function money_format11( $n, $precision = 1 ) {
    if ($n < 900) {
        // 0 - 900
        $n_format = number_format($n, $precision);
        $suffix = '';
    } else if ($n < 900000) {
        // 0.9k-850k
        $n_format = number_format($n / 1000, $precision);
        $suffix = ' k';
    } else if ($n < 900000000) {
        // 0.9m-850m
        $n_format = number_format($n / 1000000, $precision);
        $suffix = ' mi';
    } else if ($n < 900000000000) {
        // 0.9b-850b
        $n_format = number_format($n / 1000000000, $precision);
        $suffix = 'bi';
    } else {
        // 0.9t+
        $n_format = number_format($n / 1000000000000, $precision);
        $suffix = 'T';
    }

  // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
  // Intentionally does not affect partials, eg "1.50" -> "1.50"
    if ( $precision > 0 ) {
        $dotzero = '.' . str_repeat( '0', $precision );
        $n_format = str_replace( $dotzero, '', $n_format );
    }

    return $n_format . $suffix;
}

$check_contract = in_array($this->auth['role_code'], ['human-resources','product-manager', 'ceo', 'customer-care']);
$check_consultant_booking = false;
if(isYourPermission('ConsultantBooking', 'show', $this->permission_set)){
    $check_consultant_booking = true;
}

$check_contract = false;
if(isYourPermission('Contract', 'createShow', $this->permission_set)){
    $check_contract = true;
}

$check_option = true;
$check_commission_rate = in_array($this->auth['role_code'], ['business-manager','consultant','customer-care',
    'product-manager', 'ceo']);
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
            <div class="card card-body pl-0 pr-0 col-12 col-md-8">
                <?php $this->load->view('components/list-navigation'); ?>
                <?php $this->load->view('apartment/search-by-room-price', ['list_price' => $list_price]); ?>
                <div class="m-2 list-action">
                    <span class="d-flex justify-content-center flex-wrap ">
                        <?php 
                        foreach($list_district as $district):
                            $district_btn = 'btn-outline-success';
                        ?>
                            
                            <a href="<?= base_url().'admin/list-apartment?district-code='.$district['code'] ?>" 
                                class="btn m-1 btn-sm <?= $district_btn ?>
                                <?= $district_code == $district['code'] ? 'active':'' ?>
                                btn-rounded waves-light waves-effect">
                            Q. <?= $district['name'] ?> </a>
                            
                        <?php endforeach; ?>
                    </span>
                </div>
                <div class="card">
                    <div class="form-group row">
                        <div class="col-md-8 offset-md-2 col-10 offset-1">
                            <input type="text" placeholder="Tìm kiếm dự án, vui lòng nhập địa chỉ..." class="form-control search-address border border-info">
                        </div>
                    </div>
                </div>
                <?php foreach ($list_apartment as $apartment): ?>
                <!-- item -->
                <div class="card-header apartment-block mt-1" role="tab" id="headingThree">
                    <?php if($apartment['short_message']) echo '<h5 class="col text-center notifier-apartment">'.$apartment["short_message"].'</h5>'; ?>
                    <div class="row">
                    <div class="col-4">
                            <a class="apm-direction text-secondary font-weight-bold"><?= $apartment['partner_id'] ? $libPartner->getNameById($apartment['partner_id']):'#' ?></a>
                    </div>
                    <div class="col-4 text-center p-0">
                        <span class="text-primary"><?= $apartment['time_update'] ? '<i class="mdi mdi-update"></i>'.date('d/m/Y H:i', 
                                    max($apartment['time_update'],$ghRoom->getMaxTimeUpdate($apartment['id']))) :'' ?></span>
                    </div>
                    <div class="col-4 text-right">
                        <a class="apm-direction text-secondary font-weight-bold"><?= $apartment['direction'] ? $label_apartment[$apartment['direction']]:'#' ?></a>
                    </div>
                        <h4 class="col text-center d-none">Tiêu đề Shock</h4>
                    </div>
                    <div class="mt-1 apm-tag-list">
                        <span>
                        <?php if($apartment['tag_id']): ?>
                            <span class="badge badge-pink"><?= $libTag->getNameById($apartment['tag_id']) ?></span>
                        </span>
                        <?php endif; ?>
                    </div>
                    <div class="col text-center address-text text-purple font-weight-bold">
                        <?=$apartment['address_street'] ?>
                        <?=$apartment['address_ward'] ? ', Ph. '.$apartment['address_ward']:''  ?>
                    </div>
                   
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="mb-md-2">Mô tả dự án</h5>
                            <div class="more apm-description">
                                <?= $apartment['description'] ?>
                            </div>
                        </div>
                        <div class="col-md-4 font-weight-bold" id="time-update-<?= $apartment['id'] ?>">
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
                    <div class="mt-2 list-action" >
                        <span class="d-flex justify-content-center notification-list">
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
                            
                            <a class="m-1 collapsed btn btn-sm btn-outline-warning btn-rounded waves-light waves-effect" 
                                data-toggle="collapse" 
                                data-parent="#accordion" 
                                href="#modal-apartment-detail-<?=$apartment['id'] ?>" aria-expanded="false" aria-controls="#modal-apartment-detail-<?=$apartment['id'] ?>">
                                <i class="mdi mdi-eye"></i>
                            </a>
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
                            
                            <!-- <button type="button" class="btn m-1 btn-sm btn-outline-primary btn-rounded waves-light waves-effect">
                                <i class="mdi mdi-folder-multiple-image"></i>
                            </button> -->
                        </span>
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

                                    <small class="commnet-item-user text-right text-danger"><?= $libUser->getNameByAccountid($this->auth['account_id']) ?></small>
                                </div>
                            <?php endforeach; ?>
                        <?php endif;?>
                        
                            <div class="comment-box-item mt-3">
                                <input type="text" id="apm-comment-<?= $apartment['id'] ?>" class="new-comment border border-info form-control" placeholder = "nhập bình luận ...">
                            </div>
                            <button type="button" data-apm-id="<?= $apartment['id'] ?>" class="btn m-1 add-new-comment room-delete btn-sm btn-outline-success btn-rounded waves-light waves-effect">
                                +<i class="mdi mdi-comment-plus-outline"></i>
                            </button>
                        </div>
                    </div>
            
                </div>
                <div id="modal-apartment-detail-<?=$apartment['id'] ?>" class="collapse" role="tabpanel" aria-labelledby="modal-apartment-detail-<?=$apartment['id'] ?>">
                    <div class="card-body">
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
                            <div class="tab-pane apm-note" id="apm-note-<?= $apartment['id'] ?>">
                                <p><?= $apartment['note'] ?></p>
                            </div>
                            <div class="tab-pane service-list show active" id="apm-service-<?= $apartment['id'] ?>">
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
                                <?php $this->load->view('apartment/room',[
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
                        </div> <!-- end tab content , end item-->
                        
                    </div>
                </div>
                <?php endforeach;?>
            </div>
        </div> 
    </div>
</div>
<script>

    commands.push(function() {
        
        var t_room = $('.list-room').DataTable();
        $('.apartment-block').find('.list-action').show();
        // $('.apartment-block').mouseenter(function() {
        //     $(this).find('.list-action').show(600);
        // }).mouseleave(function() {
        //     $(this).find('.list-action').hide(600); 
        // });

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

            $('.add-new-comment').click(function() {
                var apm_id = $(this).data('apm-id');
                var content = $('#apm-comment-'+ apm_id).val();
                var account_id = '<?= $this->auth['account_id'] ?>';
                var user_name = '<?= $this->auth['name'] ?>';
                var time = "<?= date('d/m/Y, H:i') ?>";
                if(content.length > 0) {
                    $.ajax({
                        url: '/admin/create-apartment-comment',
                        method: 'POST',
                        data: {content: content, accountId: account_id, apmId: apm_id},
                        success: function() {
                            console.log('123');
                            $('#newContentComment').after(function() {
                                return `<div class='comment-box-item'>
                                    <p class='commnet-item-date'>${time}</p>
                                    <p class='commnet-item-msg text-info'>${content}</p>
                                    <small class='commnet-item-user text-danger text-right'>${user_name}</small>`;
                            });
                        }
                    })
                }
            });

            //Warning Message
        $('.consultant-booking').click(function () {
            let thisBooking = $(this);
            let time = null;
            swal({
                title: '',
                text: "Chúc Bạn Chốt Khách Thành Công!",
                type: 'warning',
                html: `
                <form>
                    <label>Ngày Dẫn Khách</label>
                    <input name="bookingtime" class="datepicker form-control booking-time">

                    <label>Số điện thoại</label>
                    <input name="phonenumber" tpe="text" placeholder="0900..." class="form-control">
                    <p class='msg-phonenumber text-danger'></p>
                    <label>Giới tính</label>
                    <input class="form-control">
                    <label>Ghi Chú</label>
                    <input required class="form-control">
                </form>
                `,
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
                preConfirm: function () {
                    let phone = $('input[name=phonenumber]').val();
                    if(phone == '')
                        return;
                    else {
                        $('.msg-phonenumber').text('hello');
                    }
                }
            }).then(function () {
                roomId = thisBooking.data('room-id');
                time = $('.booking-time').val();
                console.log(time);
                // $.ajax({
                //     method: "post",
                //     url: "<?//= base_url(). 'admin/create-consultant-booking' ?>",
                //     data: {roomId: roomId, time: time }
                // });
                swal({
                    title: 'Đã Book Xong!',
                    type: 'success',
                    confirmButtonClass: 'btn btn-confirm mt-2'
                }
                );

            })
        });

        $('.datepicker').datepicker({
            format: "dd/mm/yyyy"
        });

    });
</script>
