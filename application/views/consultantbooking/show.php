<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">giohang</a></li>
                            <li class="breadcrumb-item"><a href="#">Extra Pages</a></li>
                            <li class="breadcrumb-item active">Starter</li>
                        </ol>
                    </div>
                    <h4>Thống kê dẫn khách Tuần hiện tại</h4>
                </div>
            </div>
        </div>
        <div class="row">            
            <div class="col-md-3">
                <div class="card-box bg-primary widget-flat border-primary text-white">
                    <i class="fi-archive"></i>
                    <h3 class="m-b-10"><?= count($list_booking) ?></h3>
                    <p class="text-uppercase m-b-5 font-13 font-600"> Tổng số lượt dẫn </p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-box bg-primary widget-flat border-primary text-white">
                    <i class="fi-archive"></i>
                    <h3 class="m-b-10"><?= $quantity['booking_district'] ?></h3>
                    <p class="text-uppercase m-b-5 font-13 font-600">Số Lượng Quận </p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-box bg-primary widget-flat border-primary text-white">
                    <i class="fi-archive"></i>
                    <h3 class="m-b-10"><?= $quantity['booking_apm'] ?></h3>
                    <p class="text-uppercase m-b-5 font-13 font-600">Số Lượng Dự Án </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-5 offset-md-1">
                <div class="card-box table-responsive">
                <h4>Nhóm theo quận - tuần hiện tại từ <?= date('d/m/Y', strtotime('last monday')) ?></h4>
                <table class=" table-data table table-bordered">
                    <thead>
                        <tr>
                            <th>Quận</th>
                            <th>Số Lượt</th>
                        </tr>
                    </thead>
                <tbody>
                    <?php if(count($district_counter_booking) >0):?>
                    <?php foreach($district_counter_booking as $d => $count):
                    ?>
                        <tr>
                            <td>Quận <?= $libDistrict->getNameByCode($d) ?></td>                        
                            <td><?=  $count ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                </table>
                </div>
            </div>
            <div class="col-12 col-md-5">
                <div class="card-box table-responsive">
                <h4>Nhóm theo thành viên - tuần hiện tại từ <?= date('d/m/Y', strtotime('last monday')) ?></h4>
                <table class=" table-data table table-bordered">
                    <thead>
                        <tr>
                            <th>Thành viên</th>
                            <th>Số Lượt</th>
                        </tr>
                    </thead>
                <tbody>
                    <?php if(count($list_booking_this_week) >0):?>
                    <?php foreach($list_booking_this_week as $booking):
                    ?>
                        <tr>
                            <td><?= $libUser->getNameByAccountid($booking['booking_user_id']) ?></td>                        
                            <td><?=  $booking['counter'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-10 offset-md-1 ">
                <div class="card-box table-responsive">
                <h4>Thống kê chi tiết dẫn khách tuần hiện tại từ <?= date('d/m/Y', strtotime('last monday')) ?></h4>
                <table class=" table-data table table-bordered">
                <thead>
                    <tr>
                        <th>Dự Án</th>
                        <th>Mã Phòng</th>
                        <th>Thành viên</th>
                        <th>Thời Gian Dẫn Khách</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(count($list_booking) >0):?>
                <?php foreach($list_booking as $booking):
                    $roomModel = $ghRoom->get(['id' => $booking['room_id']]);
                    $address = '';
                    $roomCode = '';
                    if($roomModel){
                        $apmModel = $ghApartment->get(['id' => $roomModel[0]['apartment_id']]);
                        $roomCode = $roomModel[0]['code'];
                        if($apmModel) {
                            $address = $apmModel[0]['address_street'];
                        }
                    }
                ?>
                    <tr>
                        <td><?= $address ?></td>
                        <td><?= $roomCode ?></td>
                        <td><?= $libUser->getNameByAccountid($booking['booking_user_id']) ?></td>
                        <td><?= date('d/m/Y H:i',$booking['time_booking'])  ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php endif; ?>
               
                </tbody>
                </table>
                </div>
            </div>
            
        </div>

    </div>
</div>



<script>
commands.push(function() {
        $(document).ready(function() {
            $('.table-data').DataTable({});
            
        });
});
    
</script>