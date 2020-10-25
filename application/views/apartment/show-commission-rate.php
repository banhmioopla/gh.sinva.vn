<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">giohang</a></li>
                            <li class="breadcrumb-item"><a href="#">Extra Pages</a></li>
                            <li class="breadcrumb-item active">Starter</li>
                        </ol>
                    </div>
                    <h4>Thống kê Hoa hông ký gửi Dự Án đang mở</h4>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12 col-md-8 offset-md-2">
                <div class="card-box table-responsive">
                <table class=" table-data table table-bordered">
                    <thead>
                        <tr>
                            <th>Dự Án</th>
                            <th>Hoa Hồng 12m</th>
                            <th>Hoa Hồng 6m</th>
                        </tr>
                    </thead>
                <tbody>
                    <?php if(count($list_apartment) >0):?>
                    <?php foreach($list_apartment as $row):
                    ?>
                        <tr>
                            <td><?= $row['address_street'] ?></td>                        
                            <td>
                                <div class="comissionrate"
                                    data-pk="<?= $row['id'] ?>" 
                                    data-value="<?= $row['commission_rate'] ?>"
                                    data-name="commission_rate">
                                    <?= $row['commission_rate'] ?> %
                                </div>
                            </td>
                            
                            <td>
                                <div class="comissionrate"
                                    data-pk="<?= $row['id'] ?>" 
                                    data-value="<?= $row['commission_rate_6m'] ?>"
                                    data-name="commission_rate_6m">
                                    <?= $row['commission_rate_6m'] ?> %
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
    commands.push(function() {
        $(document).ready(function() {
            $('.table-data').DataTable({
                "pageLength": 10,
                'pagingType': "full_numbers",
                responsive: true,
                "fnDrawCallback": function() {
                <?php if(in_array($this->auth['role_code'], ['customer-care', 'product-manager'])): ?>
                    $('.comissionrate').editable({
                        type: "number",
                        url: '<?= base_url() ?>admin/update-apartment-editable',
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
                <?php endif; ?>
                } // end fnDrawCallback
            });
        });
    });
</script>