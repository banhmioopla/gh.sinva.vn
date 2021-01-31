<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Giỏ Hàng</a></li>
                            <li class="breadcrumb-item active">Đối Tác Kinh Doanh</li>
                        </ol>
                    </div>
                    <h2 class="font-weight-bold text-danger"><?= $partner['name'] ?></h2>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="row">
            <div class="col-sm-12">
                <!-- meta -->
                <div class="profile-user-box card-box bg-warning">
                    <div class="row">
                        <div class="col-sm-6">
                            <span class="pull-left mr-3"><img src="https://www.cunsieupham.com/wp-content/uploads/2017/05/3967455554_518795706.400x400.jpg"
                                                              alt="" class="thumb-lg rounded-circle border border-danger"></span>
                            <div class="media-body text-white">
                                <h4 class="mt-1 mb-1 font-18"><?= $partner['name'] ?></h4>
                                <p class="font-13 text-light"> vai trò (đang code)</p>
                                <p class="text-light mb-0"><i class="mdi mdi-cellphone"></i>: <strong><?= $partner['phone'] ?></strong></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ meta -->
            </div>
        </div>
        <!-- end row -->


        <div class="row">
            <div class="col-md-4">
                <!-- Personal-Information -->
                <div class="card-box">
                    <h4 class="font-weight-bold text-danger">Ghi Chú</h4>
                    <div class="panel-body">
                        <p class="text-muted font-13">
                            <div data-name="note" data-value="<?=$partner['note'] ?>" class="business-edit"><?=$partner['note'] ?></div>
                        </p>

                        <hr/>
                        <div class="text-left">
                            <p class="text-muted font-13"><strong>Họ Tên: </strong> <span class="m-l-15 business-edit" data-name="name" data-value="<?= $partner['name'] ?>"><?= $partner['name'] ?></span></p>

                            <p class="text-muted font-13"><strong>Số điện thoại: </strong><span class="m-l-15"><?= $partner['phone'] ?></span></p>

                            <p class="text-muted font-13"><strong>Email:</strong> <span class="m-l-15"><?= $partner['email'] ?></span></p>

                            <p class="text-muted font-13"><strong>Độ Yêu Thích Đối Tác Này:</strong> (đang code)
                                <div id="score"></div>
                            </p>

                        </div>

                    </div>
                </div>

            </div>


            <div class="col-md-8">
                <div class="card-box">
                    <h4 class="font-weight-bold text-danger">Danh Sách Dự Án</h4>
                    <form action="/admin/create-merge-apartment-business" method="post">

                        <div class="row">
                            <div class="col-md-6">
                                <select class="form-control select2" id="apartment_id" name="apartment_id">
                                </select>
                                <input type="hidden" name="business_id" value="<?= $partner['id']?>">
                            </div>
                            <div class="col-md-6"> <button type="submit" class="btn btn-warning float-lg-right">Cập Nhật</button></div>

                    </form>


                    </div>
                    <div class="row mt-3">
                        <div class="col-12">

                            <div class="table-responsive">
                                <table class="table table-dark m-b-0">
                                    <tbody>
                                        <?php foreach ($list_apartment as $item): ?>
                                        <tr>
                                            <td><?= $item['address_street'] ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
            <!-- end col -->

        </div>
        <!-- end row -->

    </div> <!-- end container -->
</div>
<script>
    commands.push(function(){
        $(".select2").select2({
            placeholder: "Chọn Dự Án",
            minimumInputLength: 1,
            ajax: {
                url: "<?= base_url().'admin/apartment/search' ?>",
                dataType: 'json',
                processResults: function (data) {
                    return {
                        results: data
                    };
                }
            }
        });
        $('#score').raty({
            score: 3,
            starOff: 'fa fa-star-o text-muted',
            starOn: 'fa fa-star text-danger'
        });

        // x editable
        $('.business-edit').editable({
            type: "text",
            pk: '<?= $partner["id"] ?>',
            url: '<?= base_url() ?>admin/update-business-partner-editable',
            inputclass: '',
            mode: 'inline'
        });
    });
</script>