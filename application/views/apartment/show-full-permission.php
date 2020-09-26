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
                <?php $this->load->view('apartment/metric', ['district_code' => $district_code]) ?>
            </div>
            <div class="card card-body pl-0 pr-0 col-12 col-md-8">
                <div class="mt-2 mb-2 list-action">
                    <span class="d-flex justify-content-center flex-wrap">
                    <?php foreach($list_district as $district): ?>
                        <a href="<?= base_url().'admin/list-apartment?district-code='.$district['code'] ?>" 
                            class="btn m-1 btn-sm btn-outline-success
                            <?= $district_code == $district['code'] ? 'active':'' ?>
                            btn-rounded waves-light waves-effect">
                            <?= $district['name'] ?></a>
                    <?php endforeach; ?>
                    </span>
                </div>
                <?php foreach ($list_apartment as $apartment): ?>
                <div class="card-header apartment-block mt-1" role="tab" id="headingThree">
                    <?php if($apartment['short_message']) echo '<h5 class="col text-center notifier-apartment">'.$apartment["short_message"].'</h5>'; ?>
                    
                    <div class="row">
                        <div class="col-4">
                            <a class="apm-direction text-secondary font-weight-bold"><?= $apartment['partner_id'] ? $libPartner->getNameById($apartment['partner_id']):'#' ?></a>
                        </div>
                        <div class="col-4 text-center font-weight-bold">
                            <span class="text-success"><?= $ghRoom->getNumberByStatus($apartment['id'], 'Available') ?></span>
                            <span class="text-warning"><?= $ghRoom->getNumberByTimeavailable($apartment['id']) ?></span>
                            <span class="text-muted"><?= $ghRoom->getNumber($apartment['id']) ?></span>
                        </div>
                        <div class="col-4 text-right">
                            <a class="apm-direction text-secondary font-weight-bold"><?= $apartment['direction'] ? $apartment['direction']:'#' ?></a>
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
                    <div class="col text-center text-purple font-weight-bold">
                        <?=$apartment['address_street'] ?>
                        <?=$apartment['address_ward'] ? ', Ph. '.$apartment['address_ward']:''  ?>
                    </div>

                    <div class="col text-center text-warning font-weight-bold mt-2" id="time-update-<?= $apartment['id'] ?>"><i class="mdi mdi-update"></i> <?= $apartment['time_update'] ? date('d/m/Y H:i', 
                    max($apartment['time_update'],$ghRoom->getMaxTimeUpdate($apartment['id']))) :'' ?></div>

                    <div class="mt-2 list-action">
                        <span class="d-flex justify-content-center">
                            <!-- <button type="button" class="btn m-1 btn-sm btn-outline-success btn-rounded waves-light waves-effect">
                                <i class="mdi mdi-credit-card-plus"></i>
                            </button> -->
                            <!-- <button type="button" class="btn m-1 btn-sm btn-outline-primary btn-rounded waves-light waves-effect">
                                <i class="mdi mdi-comment-outline"></i>
                            </button> -->
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
                            <!-- <a href="/admin/upload-image?apartment-id=<?//=$apartment['id'] ?>" target="_blank"> -->
                                <!-- <button type="button" class="btn m-1 btn-sm btn-outline-primary btn-rounded waves-light waves-effect">
                                    <i class="mdi mdi-folder-multiple-image"></i>
                                </button> -->
                            <!-- </a> -->
                            
                            <button type="button" 
                                    data-apartment-id="<?= $apartment['id'] ?>" 
                                    class="btn m-1 btn-sm apartment-delete btn-outline-danger btn-rounded waves-light waves-effect">
                                <i class="mdi mdi-delete"></i>
                            </button>
                        </span>
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
                                        <?php $this->load->view('apartment/service', ['apartment' => $apartment, 'label_apartment' => $label_apartment]) ?>
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
        
        var t_room = $('.list-room').DataTable();
        $('.apartment-block').find('.list-action').show();
        // $('.apartment-block').mouseenter(function() {
        //     $(this).find('.list-action').show(600);
        // }).mouseleave(function() {
        //     $(this).find('.list-action').hide(600); 
        // });
        /* =========== MODIFY DATA JS ========= */
        if(modify_mode == 'false') return;
        
        $('.apm-note').editable({
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
        
        $('body').delegate('.list-room .room-data', 'click', function(){
            console.log('123123');
            $(this).editable({
                type: "text",
                url: '<?= base_url()."admin/update-room-editable" ?>',
                inputclass: ''
            });
        });
        
        $('body').delegate('.list-room .room-price, .list-room .room-area', 'click', function(){
            $(this).editable({
                type: "number",
                url: '<?= base_url()."admin/update-room-editable" ?>',
                inputclass: '',
                display: function(value, response) {
                    return false;   //disable this method
                },
                success: function(response, newValue) {
                    $(this).html(nFormatter(newValue));
                }
            });
        });
        
        $('body').delegate('.list-room .room-consulting_user_id', 'click', function(){
            $(this).editable({
                type: "number",
                url: '<?= base_url()."admin/update-room-editable" ?>',
                inputclass: '',
                placeholder:'171020XXX',
            });
        });

        $('body').delegate('.list-room .room-select-type', 'click', function(){
            $(this).editable({
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
        });
        
        $('body').delegate('.list-room .room-select-status', 'click',function(){
            $(this).editable({
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
        });

        $.fn.combodate.defaults.maxYear = 2022;
        $.fn.combodate.defaults.minYear = 2020;
        $('body').delegate('.list-room .room-time_available', 'click', function() {
            $('.list-room .room-time_available').editable({
                placement: 'right',
                type: 'combodate',
                template:"D / MM / YYYY",
                format:"DD-MM-YYYY",
                viewformat:"DD-MM-YYYY",
                mode: 'inline',
                combodate: {
                    firstItem: 'name'
                },
                inputclass: 'form-control-sm',
                url: '<?= base_url()."admin/update-room-editable" ?>'
            });
        });
        
        $('body').delegate('.room-delete', 'click', function() {
            console.log('hello');
            let this_btn = $(this);
            let room_id = $(this).data('room-id');
            console.log(room_id);
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
        });

        $('body').delegate('.apartment-delete', 'click', function(){
            let apartment_id = $(this).data('apartment-id');
            let this_btn = $(this);
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
        });

        $("body").delegate('.room-status', 'click', function(){
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
            $(this).text(content);
            $.ajax({
                method: 'post',
                url:'<?= base_url()."admin/update-room-editable" ?>',
                data: {pk: room_id, name: 'status', value: db_value},
                success: function(){
                    console.log('>> room.status updated to: '+ content);
                }
            })
        });

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
                            >#</div></td>
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
        
    });
</script>
