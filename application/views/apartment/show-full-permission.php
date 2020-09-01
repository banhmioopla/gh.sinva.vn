<div class="wrapper">
    <div class="sk-wandering-cubes" style="display:none" id="loader">
        <div class="sk-cube sk-cube1"></div>
    </div>
    <div class="container-fluid">
        <div class="card card-body pl-0 pr-0 col-12 col-md-8 offset-md-2">
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
            <div class="card-header mt-1" role="tab" id="headingThree">
                <div class="row">
                    <div class="col-6">
                        <a class="collapsed text-secondary font-weight-bold"><?= $apartment['partner_id'] ? $libPartner->getNameById($apartment['partner_id']):'#' ?></a>
                    </div>
                    <div class="col-6 text-right">
                        <a class="collapsed text-secondary font-weight-bold"><?= $apartment['direction'] ? $apartment['direction']:'Hướng...' ?></a>
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
                <div class="col text-center text-purple font-weight-bold">
                    <?=$apartment['address_street'] ?>
                </div>
                <div class="col text-center text-warning font-weight-bold"><i class="mdi mdi-update"></i> <?= $apartment['time_update'] ? date('d/m/Y H:i', $apartment['time_update']) :'' ?></div>
                <div class="mt-2 list-action">
                    <span class="d-flex justify-content-center">
                        <!-- <button type="button" class="btn m-1 btn-sm btn-outline-success btn-rounded waves-light waves-effect">
                            <i class="mdi mdi-credit-card-plus"></i>
                        </button> -->
                        <!-- <button type="button" class="btn m-1 btn-sm btn-outline-primary btn-rounded waves-light waves-effect">
                            <i class="mdi mdi-comment-outline"></i>
                        </button> -->
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
        // if(modify_mode == 'view') return;
        
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

        // Default Datatable
        
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
                            data-value="CODE"
                            data-name="code"
                            >CODE</div></td>
                    <td><div class="room-select-type" 
                            data-pk="${room_id}"
                            data-value="1"
                            data-name="type_id"
                            >Studio</div></td>
                    <td><div class="room-data font-weight-bold"
                            data-pk="${room_id}"
                            data-value="0"
                            data-name="price"
                            >0</div></td>
                    <td><div class="room-data" 
                            data-pk= "${room_id}"
                            data-value= "0"
                            data-name="area">0</div></td>
                    <td><div class="room-select-status" 
                            data-pk="${room_id}"
                            data-value="Full"
                            data-name="status">Full</div></td>
                    <td><div class="room-time_available" 
                            data-pk="${room_id}"
                            data-value="<?= date('d-m-Y', 0) ?>"
                            data-name="time_available"><?= date('d-m-Y', 0) ?></div></td>
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
