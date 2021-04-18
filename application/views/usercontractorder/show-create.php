<div class="wrapper">
    <div class="sk-wandering-cubes" style="display:none" id="loader">
        <div class="sk-cube sk-cube1"></div>
        <div class="sk-cube sk-cube2"></div>
    </div>
    <div class="container">

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
                    <h2 class="text-danger font-weight-bold">Thu Nhập Đã Chi: <i><?= $libUser->getNameByAccountid($this->input->get('uid')) ?></i></h2>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($this->session->has_userdata('fast_notify')) {
            $flash_mess = $this->session->flashdata('fast_notify')['message'];
            $flash_status = $this->session->flashdata('fast_notify')['status'];
            unset($_SESSION['fast_notify']);
        }
        ?>
        <div class="district-alert"></div>
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card-box table-responsive">
                    <h3 class="font-weight-bold text-danger">Thu Nhập Hợp Đồng</h3>
                    <table id="table-income" class="table table-bordered table-dark">
                        <thead>
                        <tr>
                            <th>Thời Gian</th>
                            <th class="text-center">Nguồn</th>
                            <th class="text-right">Thu Nhập <small>x1000</small></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list_income_detail as $row ):
                            if($row['type'] === 'ReferUser') {
                                $obj_type = 'Tuyển Thành Viên';
                            } else if($row['type'] === 'Contract'){
                                $obj_type = 'Hợp Đồng';
                            }
                            else if($row['type'] === 'ContractSupporter'){
                                $obj_type = 'Hỗ trợ Chốt sale';
                            }
                            else if($row['type'] === 'Penalty'){
                                $obj_type = 'Phí Phạt';
                            }
                            else if($row['type'] === 'GetNewApartment'){
                                $obj_type = 'Đàm phán DA mới';
                            }
                            ?>
                            <tr>
                                <td><?= $row['apply_time'] ? date('d-m-Y',$row['apply_time']) :"-" ?></td>
                                <td>
                                    <?= $obj_type ?>
                                </td>
                                <td class="text-right"><?= number_format($row['contract_income_total']/1000) ?></td>

                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card-box table-responsive">
                    <h3 class="font-weight-bold text-danger">Phiếu Chi</h3>
                    <table id="table-order" class="table table-bordered table-dark">
                        <thead>
                        <tr>
                            <th>Thời Gian</th>
                            <th class="text-right">Đã Chi <small>x1000</small></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list_order as $row ): ?>
                            <tr>
                                <td><?= $row['time_create'] ? date('d-m-Y',$row['time_create']) :"-" ?></td>
                                <td class="text-right text-success">
                                    <?= number_format($row['amount']) ?> <small>vnđ</small>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="">
                            <td>Còn Lại</td>
                            <td class="text-right text-warning font-weight-bold">
                                <?= number_format($remain/1000) ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="col-12 col-md-5">
                <div class="card-box">
                    <h3 class="font-weight-bold text-danger">Lập Phiếu Chi: <?= $libUser->getNameByAccountid($this->input->get('uid')) ?></h3>
                    <form role="form" method="post" action="<?= base_url()?>admin/user-contract-order?uid=<?= $this->input->get('uid') ?>">
                        <input type="hidden"
                               name="user_id"
                               value="<?= $this->input->get('uid') ?>" >
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-12 col-form-label">Số Tiền<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <input type="number" required class="form-control" name="amount" id="amount"
                                       value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-12 col-form-label">Ngày Lập<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <input type="text" required class="form-control datepicker"
                                       name="time_create"
                                       value="<?= date('d-m-Y') ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-8 offset-4">
                                <button type="button" class="btn remain btn-secondary waves-effect waves-light">
                                    +<?= number_format($remain) ?>
                                </button>
                                <button type="submit" class="btn btn-danger waves-effect waves-light">
                                    Lập Phiếu
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div> <!-- end row -->

    </div> <!-- end container -->
</div>
<!-- end wrapper -->
<script type="text/javascript">
    commands.push(function() {
        $(document).ready(function() {
            $('.remain').click(function(){
                $('#amount').val('<?= $remain ?>');
            });
            $('#table-income, #table-order').DataTable({
                "pageLength": 10,
                'pagingType': "full_numbers",
                responsive: true,
                "fnDrawCallback": function() {
                    $('.is-active-district input[type=checkbox]').click(function() {
                        var is_active = 'NO';
                        var this_id = $(this).attr('id');
                        var matches = this_id.match(/(\d+)/);
                        var district_id = matches[0];
                        if($(this).is(':checked')) {
                            is_active = 'YES';
                        }
                        console.log('hello');
                        console.log(is_active );
                        $.ajax({
                            type: 'POST',
                            url: '<?= base_url() ?>admin/update-district',
                            data: {field_value: is_active, district_id: district_id, field_name : 'active'},
                            async: false,
                            success:function(response){
                                var data = JSON.parse(response);
                                console.log(data);
                                if(data.status == true) {
                                    $('.district-alert').html(notify_html_success);
                                } else {
                                    $('.district-alert').html(notify_html_fail);
                                }
                            },
                            beforeSend: function(){
                                $('#loader').show();
                            },
                            complete: function(){
                                $('#loader').hide();
                            }
                        });
                    });
                    // x editable
                    $('.district-name').editable({
                        type: "text",
                        url: '<?= base_url() ?>admin/update-district-editable',
                        inputclass: '',
                        success: function(response) {
                            var data = JSON.parse(response);
                            if(data.status == true) {
                                $('.district-alert').html(notify_html_success);
                            } else {
                                $('.district-alert').html(notify_html_fail);
                            }
                        }
                    });
                } // end fnDrawCallback
            });
            $('.datepicker').datepicker({
                format: "dd-mm-yyyy"
            });
        });
    });
</script>