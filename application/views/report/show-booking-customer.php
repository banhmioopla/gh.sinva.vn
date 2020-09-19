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
                    <h3>Dự Án (*)</h3>
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
        <div class="apartment-alert"></div>
        <div class="row">
            <div class="col-12 col-md-7">
                <div class="card-box table-responsive">
                    <table id="table-apartment" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Địa chỉ</th>
                            <th>Số lượt dẫn khách</th>
                            <th>Số Cọc</th>
                            <th>Số HĐ Đã Ký</th>
                            <th>SL Trống(?)</th>
                            <th>SL S.Trống(?)</th>
                            <th>Vấn đề </th>
                            <th>Đề xuất</th>
                            <th>Tùy Chọn</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach($list_apartment as $row ):  ?>
                            <tr>

                                <td class="apartment-select-district">
                                <span class="font-weight-bold">
                                Quận <?= $libDistrict->getNameByCode($row['district_code']) ?>
                                </span>
                                     - <?= $row['address_street'] ?>
                                    <?= $row['address_ward'] ? ' ph. '.$row['address_ward'] :''?>
                                </td>

                                <td class="report-data"
                                data-name="number_of_book"
                                data-value="<?= $row['number_of_book'] ?>"
                                data-pk="<?= $row['id'] ?>">
                                    <?= $row['number_of_book'] ?>
                                </td>
                                <td class="apartment-short_message"
                                data-name="short_message"
                                data-value="<?= $row['short_message'] ?>"
                                data-pk="<?= $row['id'] ?>">
                                    <?= $row['short_message'] ? $row['short_message']:'#' ?>
                                </td>
                                <td class="apartment-data"
                                data-name="number_of_floor"
                                data-value="<?= $row['number_of_floor'] ?>"
                                data-pk="<?= $row['id'] ?>">
                                    <?= $row['number_of_floor'] ?> Lầu
                                </td>
                                <td class="apartment-data"
                                data-name="kt3"
                                data-value="<?= $row['kt3'] ?>"
                                data-pk="<?= $row['id'] ?>">
                                    <?= $row['kt3'] ? $row['kt3']:'#' ?>
                                </td>
                                <td class="apartment-select-direction"
                                data-name="direction"
                                data-value="<?= $row['direction'] ?>"
                                data-pk="<?= $row['id'] ?>">
                                    <?= $row['direction'] ? $label_apartment[$row['direction']]:'#' ?>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <div class="checkbox checkbox-success is-active-apartment">
                                            <input id="apartment-<?= $row['id'] ?>" 
                                                value="<?= $row['active'] ?>"
                                                type="checkbox" 
                                                <?= $row['active'] =='YES' ? 'checked':'' ?>>
                                            <label for="apartment-<?= $row['id'] ?>">
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
            <div class="col-12 col-md-5">
                <div class="card-box">
                    <h4 class="header-title m-t-0">Thêm mới</h4>
                    <form role="form" method="post" action="<?= base_url()?>admin/create-apartment">
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Đối Tác<span class="text-danger">*</span></label>
                            <div class="col-7">
                            <select class="custom-select mt-3" name="partner_id">
                                <?= $cb_partner ?>
                            </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Quận<span class="text-danger">*</span></label>
                            <div class="col-7">
                            <select class="custom-select mt-3" name="district_code">
                                <?= $cb_district ?>
                            </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Đường<span class="text-danger">*</span></label>
                            <div class="col-7">
                                <input type="text" required class="form-control"
                                        id="address_street" name="address_street" placeholder="đường">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Phường<span class="text-danger">*</span></label>
                            <div class="col-7">
                                <input type="text" required class="form-control"
                                        id="address_ward" name="address_ward" placeholder="phường">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="hori-pass1" class="col-4 col-form-label">Mở dự án này<span class="text-danger">*</span></label>
                            <div class="col-7">
                                <div>
                                    <div class=" checkbox checkbox-success">
                                        <input id="active" type="checkbox" value="YES" name="active">
                                        <label for="active">
                                        </label>
                                    </div>
                                </div>
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
            $('#table-apartment').DataTable({
                "pageLength": 10,
                'pagingType': "full_numbers",
                "aaSorting": [],
                responsive: true,
                "fnDrawCallback": function() {
                    $('.apartment-data').editable({
                        type:'text',
                        url: '<?= base_url()."admin/update-apartment-editable" ?>'
                    });
                    $('.apartment-short_message').editable({
                        type:'text',
                        placeholder: 'nhập tối đa 50 kí tự',
                        url: '<?= base_url()."admin/update-apartment-editable" ?>'
                    });
                    $('.is-active-apartment input[type=checkbox]').click(function() {
                        var is_active = 'NO';
                        var this_id = $(this).attr('id');
                        var matches = this_id.match(/(\d+)/);
                        var apartment_id = matches[0];
                        if($(this).is(':checked')) {
                            is_active = 'YES';
                        }
                        $.ajax({
                            type: 'POST',
                            url: '<?= base_url() ?>admin/update-apartment-editable',
                            data: {value: is_active, pk: apartment_id, name : 'active'},
                            async: false,
                            success:function(response){
                                var data = JSON.parse(response);
                                if(data.status == true) {
                                    $('.apartment-alert').html(notify_html_success);
                                } else {
                                    $('.apartment-alert').html(notify_html_fail);
                                }
                            },
                            beforeSend: function(){
                                $('#loader').show();
                            },
                            complete: function(){
                                $('#loader').hide();
                            }
                        });
                    });
                }
            });
            

            $('body').delegate('.apartment-select-district', 'click', function(){
                $(this).editable({
                    type: 'select',
                    url: '<?= base_url() ?>admin/apartment-get-district',
                    inputclass: '',
                    source: function() {
                        data = [];
                        $.ajax({
                            url: '<?= base_url() ?>admin/apartment-get-district',
                            dataType: 'json',
                            async: false,
                            success: function(res) {
                                data = res;
                                return res;
                            }
                        });
                        return data;
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        if(data.status == true) {
                            $('.apartment-alert').html(notify_html_success);
                        } else {
                            $('.apartment-alert').html(notify_html_fail);
                        }
                        $('.apartment-alert').show();
                        $('.apartment-alert').fadeOut(3000);
                    }
                });
            });
            
            $('body').delegate('.apartment-select-partner', 'click', function(){
                $(this).editable({
                    type: 'select',
                    url: '<?= base_url() ?>admin/apartment-get-partner',
                    inputclass: '',
                    source: function() {
                        data = [];
                        $.ajax({
                            url: '<?= base_url() ?>admin/apartment-get-partner',
                            dataType: 'json',
                            async: false,
                            success: function(res) {
                                data = res;
                                return res;
                            }
                        });
                        return data;
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        if(data.status == true) {
                            $('.apartment-alert').html(notify_html_success);
                        } else {
                            $('.apartment-alert').html(notify_html_fail);
                        }
                        $('.apartment-alert').show();
                        $('.apartment-alert').fadeOut(3000);
                    }
                });
            });

            $('body').delegate('.apartment-select-tag', 'click', function(){
                $(this).editable({
                    type: 'select',
                    url: '<?= base_url() ?>admin/apartment-get-tag',
                    inputclass: '',
                    source: function() {
                        data = [];
                        $.ajax({
                            url: '<?= base_url() ?>admin/apartment-get-tag',
                            dataType: 'json',
                            async: false,
                            success: function(res) {
                                data = res;
                                return res;
                            }
                        });
                        return data;
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        if(data.status == true) {
                            $('.apartment-alert').html(notify_html_success);
                        } else {
                            $('.apartment-alert').html(notify_html_fail);
                        }
                        $('.apartment-alert').show();
                        $('.apartment-alert').fadeOut(3000);
                    }
                });
            });

            $('body').delegate('.apartment-select-direction', 'click', function(){
                $(this).editable({
                    type: 'select',
                    url: '<?= base_url() ?>admin/update-apartment-editable',
                    inputclass: '',
                    source: [
                        {'value': 'east', 'text':'Đông'},
                        {'value': 'west', 'text':'Tây'},
                        {'value': 'south', 'text':'Nam'},
                        {'value': 'north', 'text':'Bắc'},
                        {'value': 'east-south', 'text':'Đông Nam'},
                        {'value': 'west-south', 'text':'Tây Nam'},
                        {'value': 'east-north', 'text':'Đông Bắc'},
                        {'value': 'west-south', 'text':'Tây Bắc'},
                    ],
                    success: function(response) {
                        var data = JSON.parse(response);
                        if(data.status == true) {
                            $('.apartment-alert').html(notify_html_success);
                        } else {
                            $('.apartment-alert').html(notify_html_fail);
                        }
                        $('.apartment-alert').show();
                        $('.apartment-alert').fadeOut(3000);
                    }
                });
            });

            $('.delete-apartment').click(function(){
                var this_id = $(this).attr('id');
                var this_click = $(this);
                var matches = this_id.match(/(\d+)/);
                var apartment_id = matches[0];
                if(apartment_id > 0) {
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url() ?>admin/delete-apartment',
                        // data: {apartment_id: apartment_id},
                        success: function(response) {
                            var data = JSON.parse(response);
                            if(data.status == true) {
                                $('.apartment-alert').html(notify_html_success);
                                this_click.parents('tr').remove();

                            } else {
                                $('.apartment-alert').html(notify_html_fail);
                            }
                        }
                    });
                }
            });
        });
    });
</script>