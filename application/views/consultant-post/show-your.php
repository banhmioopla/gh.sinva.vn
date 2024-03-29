<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Gh</a></li>
                            <li class="breadcrumb-item active">Danh Sách Bài Đăng Tư Vấn</li>
                        </ol>
                    </div>
                    <h2 class="font-weight-bold text-danger">Danh Sách Bài Đăng Tư Vấn - <?= $this->auth['name'] ?></h2>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-12 text-center">
                <?php $this->load->view('components/list-navigation'); ?>
            </div>
            <div class="col-12 mt-1">
                <div class="card-box">
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-dark">
                                <thead>
                                <th>Tiêu Đề</th>
                                <th>Mã Phòng</th>
                                <th width="150px">Ngày Tạo</th>
                                <th>Tùy Chọn</th>
                                </thead>
                                <tbody>
                                <?php foreach ($list_post as $post):
                                    $room_text = '';
                                    $room = $ghRoom->getFirstById($post['room_id']);
                                    $apm = $ghApartment->getFirstById($room['apartment_id']);

                                    $room_text = "{$apm['address_street']} <br> <strong class='text-warning'> mã phòng {$room['code']}</strong> ";
                                    ?>
                                    <tr>
                                        <td><?= $post['title'] ? $post['title'] :'<i>không tiêu đề</i>' ?> </td>
                                        <td><?= $room_text ?> </td>
                                        <td><?= date('d-m-Y h:i', $post['time_create']) ?></td>
                                        <td>
                                            <a class="btn-danger btn btn-rounded font-weight-bold" href="/admin/consultant-post/detail?id=<?= $post['id'] ?>">Chỉnh Sửa </a>
                                            <a class="btn-danger btn btn-rounded font-weight-bold" target="_blank" href="/sinva-home/post/detail-editorial?pid=<?= $post['id'] ?>">Xem</a>
                                        </td>
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

<script>
    commands.push(function () {
        $('table').DataTable({
            "pageLength": 10,
            'pagingType': "full_numbers",
            responsive: true
        });
    });
</script>