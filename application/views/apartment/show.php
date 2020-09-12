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
            <!-- item -->
            <div class="card-header mt-1" role="tab" id="headingThree">
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
                <div class="col text-center text-warning font-weight-bold mt-2"><i class="mdi mdi-update"></i> <?= $apartment['time_update'] ? date('d/m/Y H:i', 
                max($apartment['time_update'],$ghRoom->getMaxTimeUpdate($apartment['id']))) :'' ?></div>
                <div class="mt-2 list-action" >
                    <span class="d-flex justify-content-center">
                        <!-- <button type="button" class="btn m-1 btn-sm btn-outline-primary btn-rounded waves-light waves-effect">
                            <i class="mdi mdi-comment-outline"></i>
                        </button> -->
                        <a class="collapsed btn btn-sm btn-outline-warning btn-rounded waves-light waves-effect" 
                            data-toggle="collapse" 
                            data-parent="#accordion" 
                            href="#modal-apartment-detail-<?=$apartment['id'] ?>" aria-expanded="false" aria-controls="#modal-apartment-detail-<?=$apartment['id'] ?>">
                            <i class="mdi mdi-eye"></i>
                        </a>
                        
                        <!-- <button type="button" class="btn m-1 btn-sm btn-outline-primary btn-rounded waves-light waves-effect">
                            <i class="mdi mdi-folder-multiple-image"></i>
                        </button> -->
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
                        <div class="tab-pane apm-note" id="apm-note-<?= $apartment['id'] ?>">
                            <p><?= $apartment['note'] ?></p>
                        </div>
                        <div class="tab-pane service-list show active" id="apm-service-<?= $apartment['id'] ?>">
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
                            <?php $this->load->view('apartment/room',[
                                'apartment' => $apartment,
                                'libRoom' => $libRoom,
                            ]) ?>
                        </div>
                        <div class="tab-pane" id="apm-map">
                            <!-- Develop -->
                        </div>
                    </div> <!-- end tab content , end item-->
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
            <?php endforeach;?>
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

    });
</script>
