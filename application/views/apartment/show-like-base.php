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
                    <h2 class="font-weight-bold text-danger">Dự Án Bảng</h2>
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
                    <h4 class="text-danger font-weight-bold text-center">Dự Án Đang Mở</h4>
                    <table class="table table-bordered">
                        <tr>
                            <th>Đối tác</th>
                            <th>Quận</th>
                            <th>Đường</th>
                            <th>Phường</th>
                            <th>Số Lầu</th>
                            <th>KT3</th>
                            <th>Hướng</th>
                            <th>Tag #</th>
                            <th>TV Lấy Về</th>
                            <th>Ngày Nhập</th>
                            <th class="text-center">Mở</th>
                        </tr>
                    </table>
                    <table id="table-apartment-active-yes" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Đối tác</th>
                            <th>Quận</th>
                            <th>Đường</th>
                            <th>Phường</th>
                            <th>Số Lầu</th>
                            <th>KT3</th>
                            <th>Hướng</th>
                            <th>Tag #</th>
                            <th>TV Lấy Về</th>
                            <th>Ngày Nhập</th>
                            <th class="text-center">Mở</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list_apartment as $row ):
                            if($row['active'] == 'NO') continue;
                            ?>
                            <tr>
                                <td class="apartment-select-partner"
                                    data-name="partner_id"
                                    data-value="<?= $row['partner_id'] ?>"
                                    data-pk="<?= $row['id'] ?>">
                                    <?= $row['partner_id'] ? $libPartner->getNameById($row['partner_id']) : 'cập nhật' ?>
                                </td>

                                <td class="apartment-select-district"
                                    data-name="district_code"
                                    data-value="<?= $row['district_code'] ?>"
                                    data-pk="<?= $row['id'] ?>">
                                    quận <?= $libDistrict->getNameByCode($row['district_code']) ?>
                                </td>

                                <td class="apartment-data"
                                    data-name="address_street"
                                    data-value="<?= ' '.$row['address_street'] ?>"
                                    data-pk="<?= $row['id'] ?>">
                                    <?= $row['address_street'] ?>
                                </td>

                                <td class="apartment-data"
                                    data-name="address_ward"
                                    data-value="<?= $row['address_ward'] ?>"
                                    data-pk="<?= $row['id'] ?>">
                                    phường <?= $row['address_ward'] ?>
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
                                <td class="apartment-select-tag"
                                    data-name="tag_id"
                                    data-value="<?= $row['tag_id'] ?>"
                                    data-pk="<?= $row['id'] ?>">
                                    # <?= $row['tag_id'] ? $libTag->getNameById($row['tag_id']):'chọn...' ?>
                                </td>
                                <td class="apartment-data"
                                    data-name="user_collected_id"
                                    data-value="<?= $row['user_collected_id'] ?>"
                                    data-pk="<?= $row['id'] ?>">
                                    <?= $row['user_collected_id'] > 0 ? $libUser->getNameByAccountid($row['user_collected_id']):'#' ?>
                                </td>
                                <td >
                                    <div class="time_insert"
                                         data-name="time_insert"
                                         data-value="<?= $row['time_insert'] ? date("d-m-Y",$row['time_insert']):'' ?>"
                                         data-pk="<?= $row['id'] ?>">
                                        <?= $row['time_insert'] ? date("d-m-Y",$row['time_insert']):'#' ?>
                                    </div>

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
            <div class="col-12 col-md-7">
                <div class="card-box table-responsive">
                    <h4 class="text-danger font-weight-bold text-center">Dự Án Đã Đóng</h4>
                    <table id="table-apartment-active-no" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Đối tác</th>
                            <th>Quận</th>
                            <th>Đường</th>
                            <th>Phường</th>
                            <th>Thông báo ngắn</th>
                            <th>Số Lầu</th>
                            <th>KT3</th>
                            <th>Hướng</th>
                            <th>map_longitude</th>
                            <th>map_latitude</th>
                            <th>Tag #</th>
                            <th>TV Lấy Về</th>
                            <th class="text-center">Mở</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Đối tác</th>
                            <th>Quận</th>
                            <th>Đường</th>
                            <th>Phường</th>
                            <th>Thông báo ngắn</th>
                            <th>Số Lầu</th>
                            <th>KT3</th>
                            <th>Hướng</th>
                            <th>map_longitude</th>
                            <th>map_latitude</th>
                            <th>Tag #</th>
                            <th>TV Lấy Về</th>
                            <th class="text-center">Mở</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <?php foreach($list_apartment as $row ):
                            if($row['active'] !== 'NO') continue;
                            ?>
                            <tr>
                                <td class="apartment-select-partner"
                                    data-name="partner_id"
                                    data-value="<?= $row['partner_id'] ?>"
                                    data-pk="<?= $row['id'] ?>">
                                    <?= $libPartner->getNameById($row['partner_id']) ?>
                                </td>

                                <td class="apartment-select-district"
                                    data-name="district_code"
                                    data-value="<?= $row['district_code'] ?>"
                                    data-pk="<?= $row['id'] ?>">
                                    quận <?= $libDistrict->getNameByCode($row['district_code']) ?>
                                </td>

                                <td class="apartment-data"
                                    data-name="address_street"
                                    data-value="<?= ' '.$row['address_street'] ?>"
                                    data-pk="<?= $row['id'] ?>">
                                    <?= $row['address_street'] ?>
                                </td>

                                <td class="apartment-data"
                                    data-name="address_ward"
                                    data-value="<?= $row['address_ward'] ?>"
                                    data-pk="<?= $row['id'] ?>">
                                    phường <?= $row['address_ward'] ?>
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
                                <td class="apartment-data"
                                    data-name="map_longitude"
                                    data-value="<?= $row['map_longitude'] ?>"
                                    data-pk="<?= $row['id'] ?>">
                                    <?= $row['map_longitude'] ? $row['map_longitude']:'#' ?>
                                </td>
                                <td class="apartment-data"
                                    data-name="map_latitude"
                                    data-value="<?= $row['map_latitude'] ?>"
                                    data-pk="<?= $row['id'] ?>">
                                    <?= $row['map_latitude'] ? $row['map_latitude']:'#' ?>
                                </td>
                                <td class="apartment-select-tag"
                                    data-name="tag_id"
                                    data-value="<?= $row['tag_id'] ?>"
                                    data-pk="<?= $row['id'] ?>">
                                    # <?= $row['tag_id'] ? $libTag->getNameById($row['tag_id']):'chọn...' ?>
                                </td>
                                <td class="apartment-data"
                                    data-name="user_collected_id"
                                    data-value="<?= $row['user_collected_id'] ?>"
                                    data-pk="<?= $row['id'] ?>">
                                    <?= $row['user_collected_id'] > 0 ? $libUser->getNameByAccountid($row['user_collected_id']):'#' ?>
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
                                <select class="custom-select mt-3 " id="slc-partner" name="partner_id">
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
                            <label for="name" class="col-4 col-form-label">Mức Hoa Hồng<span class="text-danger">*</span></label>
                            <div class="col-7">
                                <input type="number" required class="form-control"
                                       id="commission_rate" name="commission_rate" placeholder="%">
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
                            <label for="user_collected_id" class="col-4 col-form-label">Thành viên đàm phán<span class="text-danger">*</span></label>
                            <div class="col-7">
                                <div>
                                    <div class=" checkbox checkbox-success">
                                        <select class="custom-select mt-3" name="user_collected_id" id="user_collected_id">
                                            <?= $cb_user ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Ngày Nhận Dự Án<span class="text-danger">*</span></label>
                            <div class="col-7">
                                <input type="text" class="form-control"
                                       id="time_insert" name="time_insert" value="<?= date('d-m-Y') ?>" >
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
            $('#user_collected_id').select2();
            $('#slc-partner').select2();

            var tableYes = $('#table-apartment-active-yes').DataTable({
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

                    $('.time_insert').editable({
                        placement: 'right',
                        type: 'combodate',
                        template:"D / MM / YYYY",
                        format:"DD-MM-YYYY",
                        viewformat:"DD-MM-YYYY",
                        mode: 'inline',
                        combodate: {
                            firstItem: 'name'
                        },
                        inputclass: 'form-control-sm',
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
            $('#table-apartment-active-yes thead th').each( function () {
                var title = $('#table-apartment-active-yes thead th').eq( $(this).index() ).text();
                $(this).html( '<input type="text" class="form-control" placeholder="Search '+title+'" />' );
            } );

            // Apply the search
            tableYes.columns().every( function () {
                var that = this;
                $( 'input', this.header() ).on( 'keyup change', function () {
                    that
                        .search( this.value )
                        .draw();
                } );
            } );

            var tableNo = $('#table-apartment-active-no').DataTable({
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
            $('#table-apartment-active-no thead th').each( function () {
                var title = $('#table-apartment-active-no thead th').eq( $(this).index() ).text();
                $(this).html( '<input type="text" class="form-control" placeholder="Search '+title+'" />' );
            } );

            // Apply the search
            tableNo.columns().every( function () {
                var that = this;
                $( 'input', this.header() ).on( 'keyup change', function () {
                    that
                        .search( this.value )
                        .draw();
                } );
            } );


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
                    type: 'select2',
                    url: '<?= base_url() ?>admin/apartment-get-partner',
                    inputclass: '',
                    mode: 'inline',
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