<div class="wrapper">
    <div class="container">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Highdmin</a></li>
                            <li class="breadcrumb-item"><a href="#">Extra Pages</a></li>
                            <li class="breadcrumb-item active">Starter</li>
                        </ol>
                    </div>
                    <h2 class="font-weight-bold text-danger">FeedBack Từ Khách Hàng</h2>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-dark">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Khách Hàng </th>
                                    <th>Ngày Phản Hồi </th>
                                    <th>Thành Viên Tư Vấn </th>
                                    <th>Tùy Chọn </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($list_feedback as $fb):
                                    $res = $fb['answer'] ? json_decode($fb['answer'],true) : [];
                                    $customer_info = "";
                                    if(count($res)) {
                                        $customer_info = '<span class="badge badge-secondary m-1">'.$res['customer']['name'] . '</span>';
                                        $customer_info .= '<span class="badge badge-secondary m-1">'.$res['customer']['email'] . '</span>';
                                        $customer_info .= '<span class="badge badge-secondary m-1">'.$res['customer']['phone'] . '</span>';
                                    }

                                    ?>
                                    <tr>
                                        <td><?= $fb['id'] ?></td>
                                        <td><?= $customer_info ?></td>
                                        <td><?= date('d/m/Y', $fb['time_create']) ?></td>
                                        <td><?= $libUser->getNameByAccountid($fb['user_id']) ?></td>
                                        <td><a target="_blank" href="/admin/customer-feedback/detail?id=<?= $fb['id'] ?>"><span class="badge badge-danger m-1">Chi Tiết</span></a></td>
                                    </tr>
                                <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div> <!-- end container -->
</div>