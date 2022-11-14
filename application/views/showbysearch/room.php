
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
            <div class="col-md-12">
                <div class="text-center w-100 mb-2">
                    <?php $this->load->view('components/list-navigation'); ?>
                </div>
            </div>
            <div class="col-md-12 border-top"><?php $this->load->view('apartment/search-by-room-price', ['list_price' => $list_price]); ?></div>
            <div class="col-12">
                <div class="card-box table-responsive shadow">
                    <h4 class="text-center text-danger">Kết Quả Tìm Kiếm: <?= count
                        ($list_data) ?> phòng</h4>
                    <table id="table-tag" class="table table-data table-bordered">
                        <thead>
                        <tr>
                            <th>Quận</th>
                            <th>Phường</th>
                            <th>Địa Chỉ</th>
                            <th>Mã Phòng</th>
                            <th>Loại Phòng</th>
                            <th class="text-warning">LP (thử nghiệm) </th>
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

                            $list_type_id = json_decode($row['room_type_id'], true);
                            $js_list_type = "";
                            $text_type_name = "";
                            if($list_type_id) {
                                $js_list_type = implode(",", $list_type_id);
                                if ($list_type_id && count($list_type_id) > 0) {
                                    foreach ($list_type_id as $type_id) {
                                        $typeModel = $ghBaseRoomType->get(['id' => $type_id]);
                                        $text_type_name .= $typeModel[0]['name'] . ', ';
                                    }
                                }

                            }


                            ?>
                            <tr class='<?= $bg_for_available ?>'>
                                <td>
                                    <?= $libDistrict->getNameByCode($apartment['district_code']) ?>
                                </td>

                                <td>
                                    <?= $apartment['address_ward'] ? $apartment['address_ward'] : '-' ?>
                                </td>
                                <td>
                                    <a href="/admin/apartment/show-image?apartment-id=<?= $apartment['id'] ?>">
                                        <u>
                                        <div class="tag-name text-purple font-weight-bold">
                                            <?= $apartment['address_street'] ?>
                                        </div>
                                        </u>
                                    </a>
                                </td>
                                <td class="text-center"><u><a class=" text-danger font-weight-bold"
                                                              href="/admin/apartment/show-image?apartment-id=<?= $apartment['id'] ?>&room-id=<?= $row['id'] ?>"><?= $row['code'] ?></a></u></td>
                                <td>
                                    <?= $row['type'] ?>
                                </td>

                                <td class="room-type"
                                    data-pk="<?= $row['id'] ?>"
                                    data-value="<?= $js_list_type ?>"
                                    data-name="room_type_id"><?= $text_type_name ? $text_type_name: " # "?>
                                </td>

                                <td>
                                    <?= number_format($row['price']/1000) ?>
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
            function sortNumbersIgnoreText(a, b, high) {
                var reg = /[+-]?((\d+(\.\d*)?)|\.\d+)([eE][+-]?[0-9]+)?/;
                a = a.match(reg);
                a = a !== null ? parseFloat(a[0]) : high;
                b = b.match(reg);
                b = b !== null ? parseFloat(b[0]) : high;
                return ((a < b) ? -1 : ((a > b) ? 1 : 0));
            }
            jQuery.extend( jQuery.fn.dataTableExt.oSort, {
                "sort-numbers-ignore-text-asc": function (a, b) {
                    return sortNumbersIgnoreText(a, b, Number.POSITIVE_INFINITY);
                },
                "sort-numbers-ignore-text-desc": function (a, b) {
                    return sortNumbersIgnoreText(a, b, Number.NEGATIVE_INFINITY) * -1;
                }
            });
            $('.table-data').DataTable({
                columnDefs: [
                    { type: 'sort-numbers-ignore-text', targets : 0 }
                ],
                "pageLength": 20,
                'pagingType': "full_numbers",
                responsive: true,
                "oSearch": {"bSmart": false}
            });

            $('body').delegate('.room-type', 'click', function(){
                console.log("1");
                $(this).editable({
                    type: 'checklist',
                    url: '<?= base_url() ?>admin/update-room-editable',
                    inputclass: '',
                    source: function () {
                        let data = [];
                        $.ajax({
                            url: '<?= base_url() ?>admin/room-type/get-list-editable',
                            dataType: 'json',
                            async: false,
                            success: function (res) {
                                data = res;
                                console.log(data);
                                return res;
                            }
                        });
                        return data;
                    }
                });
            });


        });
    });
</script>