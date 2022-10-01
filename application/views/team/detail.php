<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">GH</a></li>
                            <li class="breadcrumb-item"><a href="#">Chi nhánh</a></li>
                            <li class="breadcrumb-item active"><?= $team['name'] ?></li>
                        </ol>
                    </div>
                    <h2 class="text-danger font-weight-bold">Team | <?= $team['name'] ?></h2>
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
            <div class="col-xs-12 col-md-3 ">
                <div class="card-box tilebox-one">
                    <i class="icon-chart float-right text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0">Tổng Số Lượng Hợp Đồng</h6>
                    <h2 class="m-b-20"><span ><?= $libUser->getNumberContractByTeam($team['id'], $timeFrom, $timeTo) ?></span></h2>
                </div>
            </div>

            <div class="col-xs-12 col-md-3 ">
                <div class="card-box tilebox-one">
                    <i class="icon-chart float-right text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0">Tổng Doanh Số</h6>
                    <h2 class="m-b-20"><span ><?= $libUser->getTotalSaleByTeam($team['id'], $timeFrom, $timeTo) ?></span></h2>
                </div>
            </div>

            <div class="col-12">
                <div class="card-box">
                    <form>
                        <input type="hidden" name="id" value="<?= $team['id'] ?>">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <strong>Khoảng ngày Từ</strong>
                                <input type="text" class="form-control datepicker mt-1 mb-2" name="timeFrom" value="<?= $timeFrom ?>" >
                            </div>
                            <div class="col-md-3">
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
                    <table id="table-member" class="table table-hover table-bordered">
                        <thead>
                        <tr >
                            <th>Tên Thành Viên</th>
                            <th class="text-center">Hợp đồng  <br> <small>Click để xem chi tiết</small></th>
                            <th class="text-right">Doanh Số <br> <small>(x1000)</small></th>
                            <th>Tùy Chọn</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list_member as $row ):
                            $contract = $ghContract->get([
                                'consultant_id' => $row['user_id'],
                                'time_check_in >= ' => strtotime($timeFrom),
                                'time_check_in <= ' => strtotime($timeTo) + 86399,
                                'status <>' => 'Cancel'
                            ]);

                            $total = $ghContract->getTotalSaleByConsultant($row['user_id'], $timeFrom, $timeTo);

                            ?>
                            <tr>
                                <td>
                                    <div class="team-name"
                                         data-pk="<?= $row['id'] ?>"
                                         data-name="name">
                                        <?= $libUser->getNameByAccountid($row['user_id']) . ' <br> <small>(' . $row['user_id'] . ')</small>'?>
                                    </div>
                                </td>
                                <td>
                                    <ul>
                                        <?php foreach ($contract as $item):
                                            $room = $this->ghRoom->getFirstById($item['room_id']);
                                            $apm = $this->ghApartment->getFirstById($item['apartment_id']);
                                            ?>
                                            <li><a href="/admin/detail-contract?id=<?= $item['id'] ?>"
                                                   target="_blank">  <?= $apm['address_street'] ." <strong>({$room['code']})</strong>  Ký ngày " . date('d/m/Y',$item['time_check_in']) ?></a></li>
                                        <?php endforeach;?>

                                    </ul>
                                </td>
                                <td class="text-right"><?= number_format($total/1000) ?></td>
                                <td>
                                    <button type="button"
                                            data-member-id="<?= $row['user_id'] ?>"
                                            class="btn btn-sm delete-member btn-icon waves-effect waves-light btn-danger"> <i class="fa fa-trash"></i> </button>
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
            $('#table-member').DataTable({
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