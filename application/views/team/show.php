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
                    <h2 class="text-danger font-weight-bold">Danh Sách Đội Nhóm Chi Nhánh</h2>
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
            <div class="col-12 col-md-7">
                <div class="card-box table-responsive">
                    <table id="table-district" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Tên Chi Nhánh</th>
                            <th class="text-center">Giám Đốc Chi Nhánh</th>
                            <th class="text-center">Tùy Chọn</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach($list_team as $row ): ?>
                            <tr>
                                <td>
                                    <div class="team-name" 
                                        data-pk="<?= $row['id'] ?>" 
                                        data-name="name">
                                            <?= $row['name'] ?>
                                    </div>
                                </td>
                                <td>
                                    <?= $libUser->getNameByAccountid($row['leader_user_id']) ?>
                                </td>
                                <td class="text-center">
                                    <a target="_blank" href="/admin/team/detail?id=<?= $row['id'] ?>" class="btn btn-danger">chi tiết</a>
                                </td>
                                
                            </tr>      
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 col-md-5">
                <div class="card-box">
                    <h4 class="header-title m-t-0">Thêm mới</h4>
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
            $('select').select2();
            $('#table-district').DataTable({
                "pageLength": 10,
                'pagingType': "full_numbers",
                responsive: true,
                "fnDrawCallback": function() {
                    // x editable
                    $('.team-name').editable({
                        type: "text",
                        url: '<?= base_url() ?>admin/update-team-editable',
                        inputclass: '',
                        success: function(response) {
                            var data = JSON.parse(response);
                            if(data.status == true) {
                                $('.district-alert').html(notify_html_success);
                            } else {
                                $('.district-alert').html(notify_html_fail);
                            }
                        }
                    });
                } // end fnDrawCallback
            });
        });
    });
</script>