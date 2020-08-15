<div class="wrapper">
    <div class="sk-wandering-cubes" style="display:none" id="loader">
        <div class="sk-cube sk-cube1"></div>
    </div>
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item">
                                <a href="#">Test</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Test</a>
                            </li>
                            <li class="breadcrumb-item active">Quận XXX</li>
                        </ol>
                    </div>
                    <h3>Quận XXX</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card card-body pl-0 pr-0 col-12 col-md-8 offset-md-2">
            <div class="mt-2 mb-2 list-action">
                <span class="d-flex justify-content-center">
                <?php foreach($list_district as $district): ?>
                    <a href="<?= base_url().'admin/list-apartment?district-code='.$district['code'] ?>" 
                        class="btn m-1 btn-sm btn-outline-success
                        <?= $district_code == $district['code'] ? 'active':'' ?>
                        btn-rounded waves-light waves-effect">
                        <?= $district['name'] ?>
                    </a>
                <?php endforeach; ?>
                </span>
            </div>
                <?php foreach ($list_apartment as $apartment): ?>
                <div class="col-12 apartment-block">
                    <div id="accordion" role="tablist" aria-multiselectable="true" class="m-b-30">
                        <div class="card">
                            <div class="card-header" role="tab" id="headingThree">
                                <div class="row">
                                    <div class="col-6">
                                        <a class="collapsed text-secondary font-weight-bold" data-toggle="collapse" href="#collapseThree">TÊN ĐỐI TÁC</a>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a class="collapsed text-secondary font-weight-bold" data-toggle="collapse" href="#collapseThree">12 | 22 | 23</a>
                                    </div>
                                    <h4 class="col text-center d-none">Tiêu đề Shock</h4>
                                </div>
                                <div class="mt-1 apm-tag-list">
                                    <span>
                                        <span class="badge badge-pink">test</span>
                                    </span>
                                    <span>
                                        <span class="badge badge-pink">test</span>
                                    </span>
                                </div>
                                <div class="col text-center text-purple font-weight-bold">
                                    <?=$apartment['address_street'] ?>
                                </div>
                                <div class="col text-center text-warning font-weight-bold"><i class="mdi mdi-update"></i> <?= date('d/m/Y H:i', $apartment['time_update']) ?></div>
                                <div class="mt-2 list-action" style="display:none">
                                    <span class="d-flex justify-content-center">
                                        <button type="button" class="btn m-1 btn-sm btn-outline-primary btn-rounded waves-light waves-effect">
                                            <i class="mdi mdi-comment-outline"></i>
                                        </button>
                                        <button type="button" class="btn m-1 btn-sm btn-outline-primary btn-rounded waves-light waves-effect" 
                                            data-toggle="modal"
                                            data-target="#modal-apartment-detail-<?=$apartment['id'] ?>"
                                            data-overlaySpeed="200">
                                            <i class="mdi mdi-eye"></i>
                                        </button>
                                        <button type="button" class="btn m-1 btn-sm btn-outline-primary btn-rounded waves-light waves-effect">
                                            <i class="mdi mdi-folder-multiple-image"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--  Modal Card - Large -->
            <div class="modal fade apartment-detail" 
            id="modal-apartment-detail-<?=$apartment['id'] ?>" 
            tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="custom-modal-title">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title">ZACOLAND</h4>
                        </div>
                        <div class="modal-body">
                            <div class="">
                                <h5 class="header-title m-t-0 mb-3"><?= $apartment['address_street']?></h5>
    
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
                                    <li class="nav-item">
                                        <a href="#apm-map" data-toggle="tab" aria-expanded="false" class="nav-link">
                                            <i class="mdi mdi-google-maps mr-2"></i>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane apm-note" id="apm-note-<?= $apartment['id'] ?>">
                                        <p><?= $apartment['note'] ?></p>
                                    </div>
                                    <div class="tab-pane service-list show active" id="apm-service-<?= $apartment['id'] ?>">
                                        <div id="carouselButton" class="carousel slide" data-ride="carousel">
                                            <div class="carousel-inner">
                                                <?php $this->load->view('apartment/service', ['apartment' => $apartment, 'label_apartment' => $label_apartment]) ?>
                                            </div>
                                            <a class="carousel-control-prev" 
                                                href="#carouselButton" 
                                                role="button" 
                                                data-slide="prev"><i class="dripicons-chevron-left"></i> </a>
                                            <a class="carousel-control-next" 
                                                href="#carouselButton" 
                                                role="button" 
                                                data-slide="next"><i class="dripicons-chevron-right"></i></a>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="apm-room-<?= $apartment['id'] ?>">
                                        <?php $this->load->view('apartment/room',[
                                            'apartment' => $apartment,
                                            'libRoom' => $libRoom,
                                        ]) ?>
                                    </div>
                                    <div class="tab-pane" id="apm-map">
                                        <!-- Develop -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
                <?php endforeach; ?>
            </div>
        </div>
        <!-- end container -->
    </div>
</div>
<script>

    commands.push(function() {
        
        var t_room = $('.list-room').DataTable();

        $('.apartment-block').mouseenter(function() {
            $(this).find('.list-action').show(600);
        }).mouseleave(function() {
            $(this).find('.list-action').hide(600); 
        });

    });
</script>
