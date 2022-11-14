<div class="wrapper">
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
                    <h2 class="text-danger font-weight-bold">Danh Sách Đội Nhóm Chi Nhánh</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md text-center">
                <?php $this->load->view('components/list-navigation'); ?>
            </div>
        </div>
        <div class="row">
            <?php foreach($list_team as $row ): ?>
            <div class="col-md-4">
                <div class="text-center card-box">

                    <div class="member-card pt-2 pb-2">
                        <div class="thumb-lg member-thumb m-b-10 mx-auto">
                            <img src="https://media.istockphoto.com/vectors/1901m30i010n010fc061016785900-business-characters-team-work-office-vector-id1144185187?k=20&m=1144185187&s=612x612&w=0&h=8ByWeD4adfl2NV9q_c8c9YRUm6xMqHbhiD0b2FJibJg="
                                 class="rounded-circle img-thumbnail" alt="profile-image">
                        </div>

                        <div class="">
                            <h4 class="m-b-5 team-name border-0"
                                data-pk="<?= $row['id'] ?>"
                                data-name="name"><?= $row['name'] ?></h4>
                            <p class="text-muted">Lead <span> </span> <span> <span class=" font-weight-bold text-secondary"><?= $libUser->getNameByAccountid($row['leader_user_id']) ?></span> </span></p>
                        </div>

                        <a type="button" href="/admin/team/detail?id=<?= $row['id'] ?>" class="btn btn-danger m-t-20 btn-rounded btn-bordered waves-effect w-md waves-light">Chi tiết</a>

                        <div class="mt-4">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mt-3">
                                        <h4 class="m-b-5"><?= $libUser->getTotalUserByTeam($row['id']) ?></h4>
                                        <p class="mb-0 text-muted">Thành Viên</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mt-3">
                                        <h4 class="m-b-5"><?= $libUser->getTotalSaleByTeam($row['id'], $this->timeFrom, $this->timeTo) ?></h4>
                                        <p class="mb-0 text-muted">Doanh số</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <?php endforeach; ?>

            <div class="col-12 col-md-5">
                <div class="card-box">
                    <h4 class="header-title m-t-0 text-danger">Tạo Nhóm Mới</h4>
                    <form role="form" method="post" action="<?= base_url()?>admin/create-team">
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Tên team<span class="text-danger">*</span></label>
                            <div class="col-8">
                                <input type="text" required class="form-control"
                                        id="name" name="name" placeholder="Tên team">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Leader<span class="text-danger">*</span></label>
                            <div class="col-8">
                                <select type="text" required class="form-control"
                                        id="name" name="leader_user_id">
                                    <?= $list_leader ?>
                                </select>
                            </div>
                        </div>
                       
                        <div class="form-group row">
                            <div class="col-8 offset-4">
                                <button type="submit" class="btn btn-custom waves-effect waves-light">
                                    Thêm mới
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
            $('.team-name').editable({
                type: "text",
                url: '<?= base_url() ?>admin/update-team-editable',
                inputclass: '',
                mode: 'inline'
            });
        });
    });
</script>