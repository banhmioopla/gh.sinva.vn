<style>

    .navire{background:url(https://res.cloudinary.com/dioieuprs/image/upload/v1471359656/navire_n02z6s.png) no-repeat; background-size:100% auto; width:120px; height:100px; position:absolute; top:-50px; right:-130px;-webkit-transition: right 0.2s ease; transition: right 0.2s ease; }

    .mainMenuOverlay.open .navire{right:70%;-webkit-transition: right 28s ease 1s; transition: right 28s ease 1s;}
    /* ### main Menu Overlay */
    .mainMenuOverlay {
        background-color: rgba(34, 152, 195, 0.84);
        position: fixed;left: 0;right: 0;bottom: -420px;z-index: 999;
        height: 420px;
        box-shadow: 0 0 15px -3px #03374A;
        border-radius: 100% 100% 0 0 / 14% 14% 0 0;
        -webkit-transition: bottom 0.5s ease; transition: bottom 0.5s ease;
    }

    .mainMenuOverlay.open {	bottom: 0; }

    .mainMenuOverlay .toggleMenu {
        display: block;
        /*background: url(https://res.cloudinary.com/dioieuprs/image/upload/v1466688705/floating-menu/sandwich.png) no-repeat center center #65B5D0;background-size: 23px auto;*/
        background-color: #3ad0b7;
        border: 1px solid #FFF;	border-radius: 80px;
        width: 62px;height: 62px;
        position: absolute;top: -25px;left: 50%;
        margin: -31px 0 0 -31px;
        cursor: pointer;
        font-size:24px; color:#FFF; text-align:center; line-height:62px;
        box-shadow: 0 0 0 10px rgba(255, 255, 255, 0.2) inset, 0 0 16px -4px #063343;
        -webkit-transition: box-shadow 0.5s ease, top 0.5s ease; transition: box-shadow 0.5s ease, top 0.5s ease;
    }

    .mainMenuOverlay .toggleMenu:hover, .mainMenuOverlay .toggleMenu:active{}

    .mainMenuOverlay.open .toggleMenu {	top: 50%;	background-color: #2298C3;}

    .mainMenuOverlay .itemMenuBox {
        background: url(https://res.cloudinary.com/dioieuprs/image/upload/v1466688705/floating-menu/go2.png) no-repeat center center;background-size: 28px auto;
        position: absolute;	top: 50%;	left: 50%;
        margin: -31px 0 0 -31px;
        height: 62px;	width: 142px;
        text-align: right;
        border-radius: 40px;
        -webkit-transform-origin: 31px 31px;
        -ms-transform-origin: 31px 31px;
        transform-origin: 31px 31px;
        -webkit-transition: all 1s ease 0.4s;
        transition: all 1s ease 0.4s;
    }

    .mainMenuOverlay.open .itemMenuBox {width: 182px;	-webkit-transition: all 1s ease 0s;	transition: all 1s ease 0s;
    }

    .mainMenuOverlay .itemMenuBox.bills {-webkit-transform: rotate(270deg);	-ms-transform: rotate(270deg);	transform: rotate(270deg);
    }

    .mainMenuOverlay .itemMenuBox.tarsheed {-webkit-transform: rotate(330deg);	-ms-transform: rotate(330deg);	transform: rotate(330deg);
    }

    .mainMenuOverlay .itemMenuBox.employees {-webkit-transform: rotate(30deg);	-ms-transform: rotate(30deg);	transform: rotate(30deg);
    }

    .mainMenuOverlay .itemMenuBox.location {-webkit-transform: rotate(90deg);	-ms-transform: rotate(90deg);	transform: rotate(90deg);
    }

    .mainMenuOverlay .itemMenuBox.eservices {-webkit-transform: rotate(150deg);	-ms-transform: rotate(150deg);	transform: rotate(150deg);
    }

    .mainMenuOverlay .itemMenuBox.contact {-webkit-transform: rotate(210deg);	-ms-transform: rotate(210deg);	transform: rotate(210deg);
    }

    .mainMenuOverlay .itemMenuBox .itemMenu {
        display: inline-block;
        border: 2px solid rgba(255,255,255,0.6);	border-radius: 40px;
        background-color: #1f97c2;	background-repeat: no-repeat;	background-position: center center;
        width: 62px;height: 62px;
        border-radius: 40px;
        transition: all 0.8s ease;
        color:#FFF; font-size:28px; line-height:64px; text-align:center;
    }


    .mainMenuOverlay .itemMenuBox.bills .itemMenu {
        /*background-image: url(https://res.cloudinary.com/dioieuprs/image/upload/v1466688705/floating-menu/file.png);
        background-size: 20px auto;*/
        -webkit-transform: rotate(90deg);	-ms-transform: rotate(90deg);	transform: rotate(90deg);
    }


    .mainMenuOverlay .itemMenuBox.tarsheed .itemMenu {
        /* background-image: url(https://res.cloudinary.com/dioieuprs/image/upload/v1466688705/floating-menu/tarsheed.png);
        background-size: 38px auto;*/
        -webkit-transform: rotate(30deg);	-ms-transform: rotate(30deg);	transform: rotate(30deg);
    }

    .mainMenuOverlay .itemMenuBox.employees .itemMenu {
        /*background-image: url(https://res.cloudinary.com/dioieuprs/image/upload/v1466688705/floating-menu/employees.png);
        background-size: 38px auto;*/
        -webkit-transform: rotate(330deg);-ms-transform: rotate(330deg);transform: rotate(330deg);
    }



    .mainMenuOverlay .itemMenuBox.location .itemMenu {
        /*background-image: url(https://res.cloudinary.com/dioieuprs/image/upload/v1466688705/floating-menu/marker.png);
        background-size: 24px auto;*/
        -webkit-transform: rotate(270deg);	-ms-transform: rotate(270deg);	transform: rotate(270deg);
    }



    .mainMenuOverlay .itemMenuBox.eservices .itemMenu {
        /*background-image: url(https://res.cloudinary.com/dioieuprs/image/upload/v1466688705/floating-menu/mouse.png);
        background-size: 32px auto;*/
        -webkit-transform: rotate(210deg);	-ms-transform: rotate(210deg);	transform: rotate(210deg);
    }



    .mainMenuOverlay .itemMenuBox.contact .itemMenu {
        /*background-image: url(https://res.cloudinary.com/dioieuprs/image/upload/v1466688705/floating-menu/phone.png);
        background-size: 19px auto;*/
        -webkit-transform: rotate(150deg);	-ms-transform: rotate(150deg);	transform: rotate(150deg);
    }

    /* Hover */
    .mainMenuOverlay .itemMenuBox.bills .itemMenu:hover {
        -webkit-transform: rotate(450deg);	-ms-transform: rotate(450deg);	transform: rotate(450deg);
    }

    .mainMenuOverlay .itemMenuBox.tarsheed .itemMenu:hover {
        -webkit-transform: rotate(390deg);	-ms-transform: rotate(390deg);	transform: rotate(390deg);
    }

    .mainMenuOverlay .itemMenuBox.employees .itemMenu:hover {
        -webkit-transform: rotate(690deg);	-ms-transform: rotate(690deg);	transform: rotate(690deg);
    }

    .mainMenuOverlay .itemMenuBox.location .itemMenu:hover {
        -webkit-transform: rotate(630deg);	-ms-transform: rotate(630deg);	transform: rotate(630deg);
    }

    .mainMenuOverlay .itemMenuBox.eservices .itemMenu:hover {
        -webkit-transform: rotate(570deg);	-ms-transform: rotate(570deg);	transform: rotate(570deg);
    }

    .mainMenuOverlay .itemMenuBox.contact .itemMenu:hover {
        -webkit-transform: rotate(510deg);	-ms-transform: rotate(510deg);	transform: rotate(510deg);
    }



    .floating{
        -webkit-animation-name: Floatingx;
        -webkit-animation-duration: 3s;
        -webkit-animation-iteration-count: infinite;
        -webkit-animation-timing-function: ease-in-out;
        -moz-animation-name: Floating;
        -moz-animation-duration: 3s;
        -moz-animation-iteration-count: infinite;
        -moz-animation-timing-function: ease-in-out;
    }

    @-webkit-keyframes Floatingx{
        from {-webkit-transform:translate(0, 0px);}
        65% {-webkit-transform:translate(0, 5px);}
        to {-webkit-transform: translate(0, -0px);    }
    }

    @-moz-keyframes Floating{
        from {-moz-transform:translate(0, 0px);}
        65% {-moz-transform:translate(0, 5px);}
        to {-moz-transform: translate(0, -0px);}
    }

    .floating2{
        -webkit-animation-name: Floatingx2;
        -webkit-animation-duration: 3s;
        -webkit-animation-iteration-count: infinite;
        -webkit-animation-timing-function: ease-in-out;
        -moz-animation-name: Floating2;
        -moz-animation-duration: 3s;
        -moz-animation-iteration-count: infinite;
        -moz-animation-timing-function: ease-in-out;
    }

    @-webkit-keyframes Floatingx2{
        from {-webkit-transform:translate(0, 0px);}
        45% {-webkit-transform:translate(0, 8px);}
        to {-webkit-transform: translate(0, -0px);    }
    }

    @-moz-keyframes Floating2{
        from {-moz-transform:translate(0, 0px);}
        45% {-moz-transform:translate(0, 8px);}
        to {-moz-transform: translate(0, -0px);}
    }

    .floating3{
        -webkit-animation-name: Floatingx3;
        -webkit-animation-duration: 3s;
        -webkit-animation-iteration-count: infinite;
        -webkit-animation-timing-function: ease-in-out;
        -moz-animation-name: Floating3;
        -moz-animation-duration: 3s;
        -moz-animation-iteration-count: infinite;
        -moz-animation-timing-function: ease-in-out;
    }

    @-webkit-keyframes Floatingx3{
        from {-webkit-transform:translate(0, 0px);}
        50% {-webkit-transform:translate(2px, 4px);}
        to {-webkit-transform: translate(0, -0px);    }
    }

    @-moz-keyframes Floating3{
        from {-moz-transform:translate(0, 0px);}
        50% {-moz-transform:translate(2px, 4px);}
        to {-moz-transform: translate(0, -0px);}
    }



    /* signature */
    .signatureBox{text-align:right; padding:4px;}
    .signatureBox.fixed{ position:fixed; bottom:8px; right:8px; }
    .signature, .signature a{color:#484848; }
    .signature:before, .signature:after{ display:inline-block; overflow:hidden; vertical-align: bottom; -webkit-transition: all 0.5s; -webkit-transition: all 0.5s; width:11px}
    .signature:before{content:'Mahmoud';}
    .signature:after{content:'NBET'; margin-left:0px;width:10px}

    .signature:hover{color:#484848;}
    .signature:hover:before{width:76px;}
    .signature:hover:after{width:34px; margin-left:3px;}

</style>


<div id="circleMenuModal" class="modal fade" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog mt-5">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Menu Phụ</h4>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-center flex-wrap ">
                    <?php foreach ($list_features as $feature_k => $feature_v):
                        $active_element = "";
                        if(!empty($this->input->get('feature')) && $this->input->get('feature') == $feature_k){
                            $active_element = "active";
                        }
                        ?>
                        <a href="<?= base_url().'admin/list-apartment?feature='.$feature_k ?>"
                           class="btn m-1 btn-sm item-feature btn-rounded btn-outline-danger <?= $active_element ?> waves-light waves-effect"> <?= $feature_v ?> </a>
                    <?php endforeach;?>

                    <?php
                    foreach($list_district as $district):
                        $active_element = "";
                        if(!empty($current_apartment) && $district['code'] == $current_apartment["district_code"]){
                            $active_element = "active";
                        }
                        ?>

                        <a href="<?= base_url().'admin/list-apartment?district-code='.$district['code'] ?>"
                           class="btn m-1 btn-sm item-feature btn-outline-success <?= $active_element ?> btn-rounded waves-light waves-effect">
                            Q. <?= $district['name'] ?> </a>

                    <?php endforeach; ?>


                </div>

            </div>

            <div class="d-flex justify-content-center flex-wrap border-bottom mt-2 mb-3">
                <div class=" loadMore m-1 badge badge-pill badge-primary"> <i class="fa fa-arrow-circle-down"></i> Mở rộng</div>
                <div class=" showLess m-1 badge badge-pill badge-primary"> <i class="fa fa-arrow-circle-up"></i> Thu gọn</div>
            </div>
            <div class="pl-2 pr-3">
                <h4 class="font-weight-bold text-center text-danger">Danh sách dự án Q. <?= $this->libDistrict->getNameByCode($district_code) ?></h4>
                <input type="text" placeholder="Tìm kiếm dự án, vui lòng nhập địa chỉ..." class="form-control search-address border border-info">

                <ul
                    class="list-unstyled slimscroll mb-0 mt-1"
                    style="max-height: 300px"
                >
                    <?php foreach ($list_apartment as $apm): ?>
                        <li class="mb-3 address-item">
                            <h5 class="font-weight-bold"><a href="/admin/list-apartment?current_apm_id=<?= $apm['id'] ?>"><i class="mdi mdi-arrow-right-bold-circle-outline"></i> <?= $apm['address_street'] ?></a> </h5>
                            <div class="text-right text-muted"><i class="mdi mdi-clock"></i> <?= date('d/m/Y H:i', $this->ghApartment->getUpdateTimeByApm($apm['id'])) ?></div>
                            <div class="clearfix"></div>
                        </li>
                    <?php endforeach;?>
                </ul>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light waves-effect"
                        data-dismiss="modal">đóng</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div id="mainMenu" class="mainMenuOverlay floating2">
    <!--<div class="navire floating3">xx</div>
    <div class="itemMenuBox bills"><a href="javascript:void(0)" target="_blank" class="itemMenu "><i class="fa fa-file-text-o" aria-hidden="true"></i></a></div>
    <div class="itemMenuBox tarsheed"><a href="javascript:void(0)" class="itemMenu "><i class="fa fa-diamond" aria-hidden="true"></i></a></div>
    <div class="itemMenuBox employees"><a href="javascript:void(0)" class="itemMenu "><i class="fa fa-users" aria-hidden="true"></i></a></div>
    <div class="itemMenuBox location"><a href="javascript:void(0)" class="itemMenu "><i class="fa fa-location-arrow" aria-hidden="true"></i></a></div>
    <div class="itemMenuBox eservices"><a href="javascript:void(0)" class="itemMenu "><i class="fa fa-key" aria-hidden="true"></i></a></div>
    <div class="itemMenuBox contact"><a href="javascript:void(0)" class="itemMenu "><i class="fa fa-phone" aria-hidden="true"></i></a></div>
    <div class="itemMenuBox contact"><a href="javascript:void(0)" class="itemMenu "><i class="fa fa-phone" aria-hidden="true"></i></a></div>-->


    <a href="javascript:void(0)" data-toggle="modal" data-target="#circleMenuModal" class="toggleMenu circle-menu floating" ><i class="fa fa-bars" aria-hidden="true"></i>XXX</a>
</div>

<script>
    commands.push(function () {
        /*$(".toggleMenu").on('click', function () {
            $("#mainMenu").toggleClass('open');
        });*/
        $(".circle-menu").click(function () {
            
        });
    });
</script>