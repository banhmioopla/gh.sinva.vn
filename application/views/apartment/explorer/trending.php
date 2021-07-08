<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Giỏ Hàng</a></li>
                            <li class="breadcrumb-item active">Trending</li>
                        </ol>
                    </div>
                    <h2 class="font-weight-bold text-danger">Trending Tuần - TOP 10</i></h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md text-center">
                <?php $this->load->view('components/list-navigation'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card-box">
                    <div class="row">
                        <div class="col-12">
                            <table class="table">
                                <thead class="table-dark">
                                <th>View Tuần</th>
                                <th>Dự Án</th>
                                </thead>
                                <tbody>
                                <?php foreach ($arr_view as $view): ?>
                                    <tr>
                                        <td><?= $view['counter_view'] ?></td>
                                        <td><?= $view['apartment_address'] ?></td>

                                    </tr>
                                <?php endforeach;?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-box">
                    <div class="row">
                        <div class="col-12">
                            <table class="table">
                                <thead class="table-dark">
                                <th>Booking Tuần</th>
                                <th>Dự Án</th>
                                </thead>
                                <tbody>
                                <?php foreach ($arr_booking as $booking): ?>
                                    <tr>
                                        <td><?= $booking['counter_view'] ?></td>
                                        <td><?= $booking['apartment_address'] ?></td>

                                    </tr>
                                <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>