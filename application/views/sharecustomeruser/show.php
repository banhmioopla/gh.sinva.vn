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
        <form method="get" action="/admin/list-share-customer-user">
            <div class="row">
                <div class="col-md-4 mt-3 col-12 offset-0">
                    <div class="card-box shadow">
                        <select id="user" name="user" class="form-control">
                            <option value="">Chọn Thành Viên</option>
                            <?php foreach ($list_user as $item):

                                $select = "";
                                if($this->input->get('user') == $item['account_id']) {
                                    $select = "selected";
                                }
                                ?>
                                <option value="<?= $item['account_id'] ?>" <?= $select ?> ><?=
                            $item['account_id'].' - '.$item['name'] ?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 mt-3 col-12 offset-0">
                    <div class="card-box shadow">
                        <select id="customer" name="customer" class="form-control
                        select2">
                            <option value="">Chọn Khách Hàng</option>
                            <?php foreach ($list_customer as $item):
                                $select = "";
                                if($this->input->get('customer') == $item['id']) {
                                    $select = "selected";
                                }

                                ?>
                                <option value="<?= $item['id'] ?>" <?= $select ?>><?= $item['phone'].' - '. $item['name']
                                    ?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="card-box shadow table-responsive">
                        <table id="table-user" class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Tên</th>
                                <th>Xóa</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php foreach($list_share as $row ):

                                if($type === 'user') {
                                    $data_1 = $row['user_id']
                                        . ' - ' . $libUser->getNameByAccountid($row['user_id']);

                                } else {
                                    $data_1 = $libCustomer->getNameById($row['customer_id']);
                                    }
                                ?>
                                <tr>
                                    <td>
                                        <div >
                                            <?= $data_1 ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <div class="checkbox checkbox-danger
                                            is-active-district">
                                                <input id="share-<?= $row['id'] ?>"
                                                       value="<?= $row['id'] ?>"
                                                       name="share[]"
                                                       type="checkbox">
                                                <label for="share-<?= $row['id'] ?>">
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end row -->
        </form>

    </div> <!-- end container -->
</div>
<!-- end wrapper -->
<script type="text/javascript">
    commands.push(function() {
        $(document).ready(function() {
            $('#table-user, #table-customer').DataTable({
                "pageLength": 10,
                'pagingType': "full_numbers",
                responsive: true,
            });
            $('select').change(function(){
                if($(this).attr('id') == 'user') {
                    $('#customer').val("");
                } else {
                    $('#user').val("");
                }
               $('form').submit();
            });

            $(".select2").select2({
                placeholder: "Search for an Item",
                minimumInputLength: 1,
                ajax: {
                    url: "<?= base_url().'admin/search-customer' ?>",
                    dataType: 'json',
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    }
                }
            });
        });
    });
</script>