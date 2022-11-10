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
                            <li class="breadcrumb-item"><a href="#">Giỏ Hàng</a></li>
                            <li class="breadcrumb-item active">Hợp đồng của tôi</li>
                        </ol>
                    </div>
                    <h2 class="font-weight-bold text-danger">Hợp Đồng - <?= $this->auth['name'] ?></h2>
                </div>
            </div>
        </div>
        <div class="text-center">
            <?php $this->load->view('components/list-navigation')?>
        </div>



        <div class="row">
            <div class="col-12 card-box">
                <h4><strong class="text-danger">Tìm kiếm</strong></h4>
                <div class="row">

                    <div class="col-12">Chọn khoảng <strong>ngày ký</strong></div>
                    <div class="col-6">
                        <input type="text" class="form-control datepicker"
                               id="time_check_in_from"
                               value="<?= $timeCheckInFrom?>">
                    </div>
                    <div class="col-6">
                        <input type="text" class="form-control datepicker"
                               id="time_check_in_to"
                               value="<?= $timeCheckInTo  ?>">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-4 offset-4">
                        <button id="search" class="btn btn-danger w-100">Áp Dụng</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                <div class="card-box tilebox-one">
                    <i class="icon-layers float-right text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0">Doanh số</h6>
                    <h2 class="m-b-20" data-plugin="counterup"><?= number_format($this->ghContract->getTotalSaleByUser($this->auth['account_id'], $timeCheckInFrom, $timeCheckInTo)) ?></h2>
                    <span class="badge ml-2 badge-pill badge-primary font-weight-bold contract-status"> <?= $this->ghContract->getTotalRateStar($this->auth['account_id'], $timeCheckInFrom, $timeCheckInTo) ?> </span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 card-box">
                <?php $this->load->view('contract/table-default'); ?>
            </div>
        </div>
    </div>
</div>

<script>
    commands.push(function(){
        $('.table-contract').dataTable({
            "pageLength": 10,
            'pagingType': "full_numbers",
            "aaSorting": [],
            "responsive": true,
        });

        $('#search').click(function(){
            let url = '/admin/list-personal-contract?'+
                '&timeCheckInFrom='+$('#time_check_in_from').val()+
                '&timeCheckInTo='+$('#time_check_in_to').val();
            window.location = url;

        });
        $('.datepicker').datepicker({
            format: "dd-mm-yyyy"
        });
    });
</script>