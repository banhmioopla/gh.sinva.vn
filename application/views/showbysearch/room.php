
<?php

$check_consultant_booking = false;
if(isYourPermission('ConsultantBooking', 'show', $this->permission_set)){
    $check_consultant_booking = true;
}

?>
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
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="tag-alert"></div>
        <div class="row">
            <div class="col-md-12"><?php $this->load->view('apartment/search-by-room-price', ['list_price' => $list_price]); ?></div>
            <div class="col-12">
                <div class="card-box table-responsive shadow">
                    <h4 class="text-center text-danger">Kết Quả Tìm Kiếm: <?= count
                        ($list_data) ?> phòng</h4>
                    <table id="table-tag" class="table table-data table-bordered">
                        <thead>
                        <tr>
                            <th>Dự Án</th>
                            <th>Mã Phòng</th>
                            <th>Loại Phòng</th>
                            <th class="text-center">Giá</th>
                            <th class="text-center">Diện tích</th>
                            <th class="text-center">Trạng Thái</th>
                            <th class="text-center">Ngày Trống</th>
                            <th class="text-center">Tùy Chọn</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list_data as $row ):
                                $apartment = $ghApartment->get(['id' => $row['apartment_id']])[0];
                            ?>
                            <?php
                            if($row['status'] == 'Available') {
                                $bg_for_available = 'bg-gh-apm-card';
                                $color_for_available = 'text-primary';
                            }
                            else {
                                $bg_for_available = '';
                                $color_for_available = '';
                            }
                            ?>
                            <tr class='<?= $bg_for_available ?>'>
                                <td>
                                    <a href="/admin/upload-image?apartment-id=<?= $apartment['id'] ?>">
                                        <u>
                                        <div class="tag-name text-purple font-weight-bold">
                                            <?= $apartment['address_street'] . ' - quận ' . $libDistrict->getNameByCode($apartment['district_code']) ?>
                                        </div>
                                        </u>
                                    </a>
                                </td>
                                <td class="text-center"><u><a class=" text-danger font-weight-bold"
                                                              href="/admin/upload-image?apartment-id=<?= $apartment['id'] ?>&room-id=<?= $row['id'] ?>"><?= $row['code'] ?></a></u></td>
                                <td>
                                    <?= $row['type'] ?>
                                </td>
                                <td>
                                    <?= number_format($row['price']) ?>
                                </td>
                                <td class="text-center">
                                    <?= $row['area'] ?>
                                </td>

                                <td class="font-weight-bold text-center <?=
                                $color_for_available ?>">
                                    <div><?= $row['status'] ? $label_apartment[$row['status']] : '#' ?>
                                </td>
                                <td><?= $row['time_available'] ? date('d/m/Y',$row['time_available']) :'' ?></td>
                                <td>
                                    <?php if($check_consultant_booking): ?>
                                        <a href="<?= base_url() ?>admin/create-new-consultant-booking?apartment-id=<?= $apartment['id'] ?>&district-code=<?= $apartment['district_code'] ?>&mode=create">
                                            <button type="button" class="btn m-1 btn-sm btn-outline-success btn-rounded waves-light waves-effect">
                                                <i class="mdi mdi-car-hatchback"></i>
                                            </button>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end row -->

    </div> <!-- end container -->
</div>
<!-- end wrapper -->
<script type="text/javascript">
    commands.push(function() {
        $(document).ready(function() {
            $('.table-data').DataTable({
                "pageLength": 20,
                'pagingType': "full_numbers",
                responsive: true,
                "oSearch": {"bSmart": false}
            });
        });
    });
</script>