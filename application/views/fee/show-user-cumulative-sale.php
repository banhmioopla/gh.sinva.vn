<div class="wrapper">

    <div class="container">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Giỏ Hàng</a></li>
                            <li class="breadcrumb-item active">Doanh Số Tích Lũy</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="district-alert"></div>
        <div class="row">
            <div class="col-12 col-md-12 ">
                <div class="card-box table-responsive shadow">
                    <h3 class="text-danger text-center">Doanh Số Tích Lũy</h3>
                    <table class="table-cumulative table table-hover table-income">
                        <thead>
                        <tr>
                            <th>Thành Viên</th>
                            <th>Tích Lũy</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list_user as $user ):

                            $cumulative = $ghUserCumulativeSale->getByUserId($user['account_id']);
                            $cumulative = $cumulative ? $cumulative[0]['sale_total']: '';

                            ?>
                            <tr>
                                <td><?= $user['name'] ?></td>
                                <td class="sale_total"
                                    data-pk="<?= $user['account_id'] ?>"
                                    data-value="<?= $cumulative ?>"
                                    data-name="sale_total"
                                ><?= $cumulative > 0 ? number_format($cumulative) :'' ?></td>
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

<script>

    commands.push(function(){
        $('.table-cumulative').DataTable({
            "pageLength": 10,
            'pagingType': "full_numbers",
            responsive: true,
            "fnDrawCallback": function() {
                $('.sale_total').editable({
                    type: "text",
                    url: '<?= base_url() ?>admin/update-user-cumulative-sale-editable',
                    inputclass: '',
                    mode : 'inline',
                    success: function(response) {
                        var data = JSON.parse(response);
                        if(data.status == true) {
                            $('.user-alert').html(notify_html_success);
                        } else {
                            $('.user-alert').html(notify_html_fail);
                        }
                    }
                });
            }
        });
    });
</script>