<div class="wrapper">
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
                    <h2 class="text-danger font-weight-bold"><?= $team['name'] ?> - Leader: <?= $team['leader_user_id'] ?> </h2>
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
            <div class="col-12">
                <div class="card-box">
                    <form>
                        <input type="hidden" name="id" value="<?= $team['id'] ?>">
                        <div class="row align-items-center">
                            <div class="col">
                                <strong>Khoảng ngày Từ</strong>
                                <input type="text" class="form-control datepicker mt-1 mb-2" name="timeFrom" value="<?= $timeFrom ?>" >
                            </div>
                            <div class="col">
                                <strong>Khoảng ngày Đến</strong>
                                <input type="text" class="form-control datepicker mt-1 mb-2" name="timeTo" value="<?= $timeTo ?>">
                            </div>
                            <div class="col-12 float-right">
                                <button type="submit" class="btn btn-danger mt-2 pull-right mb-2">TÌM KIẾM</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-12 col-md-7">
                <div class="card-box table-responsive">
                    <h3 class="text-danger font-weight-bold">Danh Sách Thành Viên</h3>
                    <table id="table-district" class="table table-dark table-hover table-bordered">
                        <thead>
                        <tr >
                            <th>Tên Thành Viên</th>
                            <th class="text-center">Số Lượng Hợp Đồng</th>
                            <th class="text-center">Số Lượt Book</th>
                            <th>Doanh Số <small>x1000</small></th>
                            <th>Tùy Chọn</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list_member as $row ):
                            $contract =count($ghContract->get([
                                    'consultant_id' => $row['user_id'],
                                    'time_insert >= ' => strtotime($timeFrom),
                                    'time_insert <= ' => strtotime($timeTo) + 86399,
                            ]));

                            $total = $ghContract->getTotalSaleByConsultant($row['user_id'], $timeFrom, $timeTo);

                            $booking =count($ghConsultantBooking->get([
                                    'booking_user_id' => $row['user_id'],
                                    'time_booking >=' => strtotime($timeFrom),
                                    'time_booking <=' => strtotime($timeTo) + 86399,
                            ]));

                            ?>
                            <tr>
                                <td>
                                    <div class="team-name"
                                         data-pk="<?= $row['id'] ?>"
                                         data-name="name">
                                        <?= $libUser->getNameByAccountid($row['user_id']) ?>
                                    </div>
                                </td>
                                <td class="text-center"><?= $contract ?></td>
                                <td class="text-center"><?= $booking ?></td>
                                <td class="text-warning"><?= number_format($total/1000) ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-icon waves-effect waves-light btn-danger"> <i class="fa fa-trash"></i> </button>
                                    <button type="button" class="btn btn-sm btn-icon waves-effect waves-light btn-danger"> <i class="fa fa-trash"></i> </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 col-md-5">
                <div class="card-box">
                    <h3 class="text-danger font-weight-bold">Thêm Thành Viên Mới</h3>
                    <form role="form" method="post" action="<?= base_url()?>admin/create-team-user">
                        <input type="hidden" name="team_id" value="<?= $team['id'] ?>">
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Thành Viên<span class="text-danger">*</span></label>
                            <div class="col-8">
                                <select type="text" required class="form-control"
                                        id="name" name="user_id">
                                    <?= $list_user ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-8 offset-4">
                                <button type="submit" class="btn btn-danger waves-effect waves-light">
                                   <i class="fa fa-user-plus"></i> THÊM MỚI
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
            $('select').select2();
            $('#table-district').DataTable({
                "pageLength": 10,
                'pagingType': "full_numbers",
                responsive: true
            });

            $('.datepicker').datepicker({
                format: "dd-mm-yyyy"
            });

        });
    });
</script>