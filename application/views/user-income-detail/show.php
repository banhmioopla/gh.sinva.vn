<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Giỏ Hàng</a></li>
                            <li class="breadcrumb-item"><a href="#">Chi Phí</a></li>
                            <li class="breadcrumb-item active">Tổng Hợp Chi Tiết Thu Nhập (*)</li>
                        </ol>
                    </div>
                    <h2 class="font-weight-bold text-danger">Tổng Hợp Chi Tiết Thu Nhập (*)</h2>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-sm-6 col-lg-6 col-xl-3 ">
                <div class="card-box tilebox-one shadow">
                    <i class="mdi mdi-file-document float-right text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0">Số Lượng Hợp Đồng</h6>
                    <h2 class="m-b-20"><?= $contract_qtt ?></h2>
                </div>
            </div>
            <div class="col-sm-6 col-lg-6 col-xl-3 ">
                <div class="card-box tilebox-one shadow">
                    <i class="mdi mdi-book float-right text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0">Số Lượng Dự Án Mới</h6>
                    <h2 class="m-b-20"><?= $apartment_qtt ?></h2>
                </div>
            </div>
        </div>
        <form action="">
        <div class="row">

            <div class="col-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="text-danger font-weight-bold">Tìm Kiếm Chi Tiết Thu Nhập</h4>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                                <label class="col-4 col-form-label">Khoảng Ngày Từ</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" value="Some text value...">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                                <label class="col-4 col-form-label">Khoảng Ngày Đến</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" value="Some text value...">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                                <label class="col-4 col-form-label">Loại Thu Nhập</label>
                                <div class="col-8">
                                    <select type="text" class="form-control">
                                        <option value="">Vui Lòng Chọn...</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <button class="col-md-2 offset-md-5 btn bg-danger">Tìm Kiếm</button>
                    </div>
                </div>
            </div>

        </div>
        </form>
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <table class="table table-dark table-hover">
                        <thead>
                        <tr>
                            <th>Thời gian Áp Dụng</th>
                            <th>Thành Viên</th>
                            <th>Loại Thu Nhập</th>
                            <th>Mã HD / Mã Dự Án / Mã Th.Viên Được Tuyển</th>
                            <th class="text-right">Tổng Thu Nhập</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($list as $item):
                            $obj_info = ' - ';
                            $obj_type = ' - ';

                            if($item['type'] == $ghUserIncomeDetail::INCOME_TYPE_CONTRACT) {
                                $contract = $ghContract->getFirstById($item['contract_id']);
                                if($contract) {
                                    $room = $ghRoom->getFirstById($contract['room_id']);
                                    if($room) {
                                        $apartment = $ghApartment->getFirstById($room['apartment_id']);
                                        if($apartment) {
                                            $contract_room_price = number_format($contract['room_price']);
                                            $obj_info =
                                                "<strong class='text-light p-1 m-1 bg-muted'># {$apartment['address_street']}</strong> 
                                                <strong class='text-light p-1 m-1 bg-muted'># {$room['code']}</strong> 
                                                <strong class='text-light p-1 m-1 bg-muted'># {$contract_room_price}</strong> ";
                                        }
                                    }

                                }
                                $obj_info .= " <a class='badge badge-danger font-weight-bold' href='/admin/detail-contract?id={$item['contract_id']}' target='_blank' > Đi đến {$item['contract_id']}</a>";
                                $obj_type = 'Hợp Đồng';
                            }

                            if($item['type'] == $ghUserIncomeDetail::INCOME_TYPE_CONTRACT_SUPPORTER) {
                                $contract = $ghContract->getFirstById($item['contract_id']);
                                if($contract) {
                                    $room = $ghRoom->getFirstById($contract['room_id']);
                                    if($room) {
                                        $apartment = $ghApartment->getFirstById($room['apartment_id']);
                                        if($apartment) {
                                            $contract_room_price = number_format($contract['room_price']);
                                            $obj_info =
                                                "<strong class='text-light p-1 m-1 bg-muted'># {$apartment['address_street']}</strong> 
                                                <strong class='text-light p-1 m-1 bg-muted'># {$room['code']}</strong> 
                                                <strong class='text-light p-1 m-1 bg-muted'># {$contract_room_price}</strong> ";
                                        }
                                    }
                                }
                                $obj_info .= " <a class='badge badge-danger font-weight-bold' href='/admin/detail-contract?id={$item['contract_id']}' target='_blank' > Đi đến {$item['contract_id']}</a>";
                                $obj_type = 'Hỗ Trợ Ký';
                            }

                            if($item['type'] == $ghUserIncomeDetail::INCOME_TYPE_REFER_USER) {
                                $obj_info = " - ";
                                $obj_type = 'Tuyển Nhân Sự';
                            }

                            if($item['type'] == $ghUserIncomeDetail::INCOME_TYPE_GET_NEW_APARTMENT) {
                                $obj_info = "-";
                                $obj_type = "Đàm Phán DA Mới #{$item['apartment_id']}";
                            }

                            ?>
                            <tr>
                                <td><?= date("d/m/Y",$item['apply_time']) ?></td>
                                <td><?= $libUser->getNameByAccountid($item['user_id']) ?></td>
                                <td><?= $obj_type ?></td>
                                <td><?= $obj_info ?></td>
                                <td class="text-warning text-right contract_income_total font-weight-bold"
                                    data-name="contract_income_total"
                                    data-value="<?= $item['contract_income_total'] ?>"
                                    data-pk="<?= $item['id'] ?>"
                                ><?= number_format($item['contract_income_total']) . ' vnđ' ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <script>
            commands.push(function () {
                $('table').dataTable({
                    "fnDrawCallback": function() {
                        $('.contract_income_total').editable({
                            type: "text",
                            url: '<?= base_url() ?>admin/update-user-income-detail-editable',
                            inputclass: '',
                            mode: 'inline'
                        });
                    }
                });
            });
        </script>



    </div> <!-- end container -->
</div>