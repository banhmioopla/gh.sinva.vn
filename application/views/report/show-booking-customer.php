<?php 

function weekOfMonth($int_date) {
    $firstOfMonth = date("Y-m-01");
    return intval(date("W", $int_date)) - intval(date("W", strtotime($firstOfMonth))) + 1;
}
$number_of_book = $this->is_modify ? 'report-number_of_book':''; 
$number_of_deposit = $this->is_modify ? 'report-number_of_deposit':''; 
$number_of_contract = $this->is_modify ? 'report-number_of_contract':''; 
?>

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
                            <li class="breadcrumb-item"><a href="#">test</a></li>
                            <li class="breadcrumb-item"><a href="#">Extra Pages</a></li>
                            <li class="breadcrumb-item active">Starter</li>
                        </ol>
                    </div>
                    <h3 >Báo cáo dẫn khách Tuần Số (<?= date('W') ?>)</h3>
                    <div class="card-box">
                        <!-- <blockquote class="blockquote">
                            <div class="font-weight-bold">Chú ý chú ý...</div>
                            <dd class="text-primary">
                            - GH sẽ tự động tạo bảng báo cáo & tự động cập nhật lại SL phòng trống, sắp trống hằng ngày trừ <i class="text-danger">thứ Sáu, thứ Bảy, Chủ nhật</i>. <br>
                            - Một tuần mới sẽ bắt đầu từ ngày Thứ Hai. Nếu bạn vào GH từ Thứ Hai trở đi, GH sẽ tự động tạo bảng báo cáo & tự động cập nhật lại SL phòng trống, sắp trống hằng ngày trừ <i class="text-danger">thứ Sáu, thứ Bảy, Chủ nhật...</i> Bruhhh...</dd>
                            <footer class="blockquote-footer text-right">Hãy ib góp ý tôi nếu bất cập.
                            <cite title="Source Title">Quốc Bình</cite></footer>
                        </blockquote> -->
                    </div>
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
        <div class="page-alert"></div>
        <h4 >Bạn đang ở tuần số - <?= weekOfMonth(time()) ?> Tháng <?= date('m/Y') ?></h4>
        <div class="row">
            <div class="col-12 col-md-7">
                <div class="card-box table-responsive">
                    <table id='table-district' class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Quận</th>
                            <th class="text-center">Số Phòng Trống</th>
                            <th class="text-center">Số Phòng Sắp Trống</th>
                        </tr>
                        </thead>
                        <?php 
                        $sum_available = 0;
                        $sum_ready_room = 0;
                        ?>
                        <?php 
                            foreach($list_district as $d):
                                $sum_ready_room += $district_data[$d]['sum_ready_room'];
                                $sum_available += $district_data[$d]['sum_available'];
                                $not_empty = ($district_data[$d]['sum_ready_room'] or $district_data[$d]['sum_available']) ? true:false;
                                if($not_empty):
                        ?>
                                <tr>
                                    <td class="font-weight-bold">Quận <?= $libDistrict->getNameByCode($d)?></td>
                                    <td class="text-center"><?= $district_data[$d]['sum_available'] ?></td>
                                    <td class="text-center"><?= $district_data[$d]['sum_ready_room'] ?></td>
                                </tr>
                                <?php endif; ?>
                        <?php endforeach; ?>
                        <tr class="font-weight-bold bg-warning">
                            <td>Tổng Cộng</td>
                            <td class="text-center"><?= $sum_available ?></td>
                            <td class="text-center"><?= $sum_ready_room ?></td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-12 col-md-7">
                <div class="card-box table-responsive">
                    <table id="table-apartment" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Địa chỉ</th>
                            <th>Số lượt dẫn khách</th>
                            <th>Số Cọc</th>
                            <th>Số HĐ Đã Ký</th>
                            <th>SL P. Trống</th>
                            <th>SL P. Sắp Trống</th>
                            <th>Tùy Chọn</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php if($list_data):?>
                            <?php foreach($list_data as $row ):  ?>
                            <tr class="font-weight-bold text-center">
                                <td class="text-left">
                                <span class="font-weight-bold text-primary ">
                                <?= $row['apartment_address_street'] ?>
                                    <?= $row['apartment_address_ward'] ? ', p.'.$row['apartment_address_ward'] :''?>
                                </span> <br>
                                    <i>Quận <?= $libDistrict->getNameByCode($row['apartment_district_code']) ?></i>   
                                </td>

                                <td class="<?= $number_of_book ?>"
                                data-name="number_of_book"
                                data-value="<?= $row['number_of_book'] > 0 ? $row['number_of_book'] : null ?>"
                                data-pk="<?= $row['id'] ?>">
                                    <?= $row['number_of_book'] > 0 ? $row['number_of_book'] : '#' ?>
                                </td>

                                <td class="<?= $number_of_deposit ?>"
                                data-name="number_of_deposit"
                                data-value="<?= $row['number_of_deposit'] > 0 ? $row['number_of_deposit'] : null ?>"
                                data-pk="<?= $row['id'] ?>">
                                    <?= $row['number_of_deposit'] > 0 ? $row['number_of_deposit']:'#' ?>
                                </td>
                                <td class="<?= $number_of_contract ?>"
                                data-name="number_of_contract"
                                data-value="<?= $row['number_of_contract'] > 0 ? $row['number_of_contract']:null ?>"
                                data-pk="<?= $row['id'] ?>">
                                    <?= $row['number_of_contract'] ? $row['number_of_contract']:'#' ?>
                                </td>

                                <td class="report-number_of_available_room">
                                    <?= $row['number_of_available_room'] > 0 ? $row['number_of_available_room']:'-' ?>
                                </td>

                                <td class="report-number_of_ready_room">
                                    <?= $row['number_of_ready_room'] > 0 ?  $row['number_of_ready_room']:'-' ?>
                                </td>

                                <td>
                                    <div class="d-flex justify-content-center">
                                        <button class="btn btn-muted">đang code</button>
                                    </div>
                                </td>
                            </tr>      
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end row -->

    </div> <!-- end container -->
</div>
<?php var_dump($this->is_modify); ?>
<!-- end wrapper -->
<script type="text/javascript">
    commands.push(function() {
        $(document).ready(function() {
            $('#table-apartment, #table-district').DataTable({
                "pageLength": 10,
                'pagingType': "full_numbers",
                "aaSorting": [],
                responsive: true,
                "fnDrawCallback": function() {
                    $('.report-number_of_contract, .report-number_of_deposit, .report-number_of_book').editable({
                            type:'number',
                            url: '<?= base_url()."admin/update-rp-booking-customer-editable" ?>'
                    });
                    
                }
            });
            
        });
    });
</script>