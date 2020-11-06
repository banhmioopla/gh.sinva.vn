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
                    <h3 class="page-title text-center">Danh sách tìm kiếm phòng đang
                        trống & giá =
                        <?=
                        number_format($this->input->get('roomPrice')) ?></h3>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="tag-alert"></div>
        <div class="row">
            <div class="col-md-8 offset-md-2"><?php $this->load->view('apartment/search-by-room-price', ['list_price' => $list_price]); ?></div>
            <div class="col-12 col-md-8 offset-2">
                <div class="card-box table-responsive shadow">
                    <table id="table-tag" class="table table-data table-bordered">
                        <thead>
                        <tr>
                            <th>Dự Án</th>
                            <th>Mã Phòng</th>
                            <th>Loại Phòng</th>
                            <th class="text-center">Giá</th>
                            <th class="text-center">Diện tích</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list_data as $row ):
                                $apartment = $ghApartment->get(['id' => $row['apartment_id']])[0];
                            ?>
                            <tr>
                                <td>
                                    <div class="tag-name">
                                        <?= $apartment['address_street'] ?>
                                    </div>
                                </td>
                                <td><?= $row['code'] ?></td>
                                <td>
                                    <?= $row['type'] ?>
                                </td>
                                <td>
                                    <?= number_format($row['price']) ?>
                                </td>
                                <td>
                                    <?= $row['area'] ?>
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
                responsive: true
            });
        });
    });
</script>