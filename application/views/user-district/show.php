<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">giỏ hàng</a></li>
                            <li class="breadcrumb-item"><a href="#">Extra Pages</a></li>
                            <li class="breadcrumb-item active">Starter</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="row">
            <form method="post" class="col-md-8 offset-md-2 col-12 card-box"
                  name="form-user-district" action="<?= base_url().'/admin/create-user-district?account-id='.$this->auth['account_id'] ?>">
                <h2 class="text-center bg-dark text-warning p-1">Phân chia thiên hạ</h2>

                <?php if($this->session->has_userdata('fast_notify')):
                    $flash_mess = $this->session->flashdata('fast_notify')['message'];
                    $flash_status = $this->session->flashdata('fast_notify')['status'];
                    unset($_SESSION['fast_notify']); ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <?= $flash_mess ?>
                    </div>
                <?php endif; ?>

                <div class="mt-3">
                    <div class="row">
                        <div class="col-12 mb-5">
                            <div class="w-50">
                                <label for="" class="text-primary ">Chọn thành viên</label>
                                <select class="custom-select mt-3 form-control" name="account_id">
                                    <?= $libUser->cb($this->input->get('account-id'), 'YES') ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <h2>CHIA THEO QUẬN</h2>
                        </div>
                        <?php foreach($list_district as $district):

                            $model = $ghUserDistrict->getFirstByDistrictUser($district['code'], $this->input->get('account-id'));
                            $is_ov = ""; $text_ov = "text-secondary";
                            if($model && $model['is_view_only'] === 'YES'){
                                $is_ov = 'checked';
                                $text_ov = "text-pink";
                            }
                            $is_select = "";
                            if($model && $model['district_code '] === $district['code']){
                                $is_select = 'checked';
                            }
                            ?>
                            <div class="col-md-6 col-12">
                                <div class="d-flex flex-wrap justify-content-xl-between border-primary border-bottom mt-2">
                                    <div class="checkbox checkbox-primary form-check-inline px-2">
                                        <input name="code[]"
                                               id="<?= $district['code'] ?>"
                                               value="<?= $district['code'] ?>"
                                               type="checkbox" <?= $is_select ?>>
                                        <label for="<?= $district['code'] ?>">
                                            Q. <?= $district['name'] ?>
                                        </label>
                                    </div>

                                    <div class="checkbox checkbox-pink form-check-inline px-2">

                                        <input name="ov[]"
                                               id="ov-<?= $district['code'] ?>"
                                               value="<?= $district['code'] ?>"
                                               type="checkbox" <?= $is_ov ?>>
                                        <label for="ov-<?= $district['code'] ?>"><i class="<?= $text_ov ?> mdi mdi-eye"></i>
                                        </label>
                                    </div>
                                </div>


                            </div>

                        <?php endforeach;?>
                    </div>

                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="alert alert-primary" role="alert">
                                Nếu chỉ chia theo <strong>DỰ ÁN</strong> dưới đây  thì checkbox theo quận sẽ bị bỏ qua
                            </div>
                        </div>

                        <div class="col-12"><p class="text-info"></p>
                            <div class="alert alert-danger" role="alert">
                                Khi check vào <i class="text-pink mdi mdi-eye"></i> , Chế độ <strong>ONLY VIEW</strong>  được bật
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h2>CHIA THEO DỰ ÁN</h2>
                        </div>
                    </div>
                    <?php foreach($list_district as $district):?>
                        <div class="row">
                            <div class="col-12 mt-2">
                                <h3>Dự Án Quận <?= $district['name'] ?> </h3>
                                <div class="row">
                                    <?php
                                    $list_apartment = $ghApartment->get(['district_code' => $district['code'], 'active' => 'YES']);
                                    ?>
                                    <?php  foreach ($list_apartment as $apm): ?>

                                        <?php
                                        $model = $ghUserDistrict->getFirstByApmUser($apm['id'], $this->input->get('account-id'));
                                        $is_ov = ""; $text_ov = "text-secondary";
                                        if($model && $model['is_view_only'] === 'YES'){
                                            $is_ov = 'checked';
                                            $text_ov = "text-pink";
                                        }
                                        $is_select = "";
                                        if($model && $model['apartment_id'] === $apm['id']){
                                            $is_select = 'checked';
                                        }

                                        ?>
                                        <div class="col-12">
                                            <div class="d-flex flex-wrap justify-content-xl-between border-primary border-bottom mt-2">
                                                <div class="checkbox checkbox-primary form-check-inline px-2">
                                                    <input name="apm[]"
                                                           id="apm-<?= $apm['id'] ?>"
                                                           value="<?= $apm['id'] ?>"
                                                           type="checkbox" <?= $is_select ?>>
                                                    <label for="apm-<?= $apm['id'] ?>">
                                                        <?= $apm['address_street'] ?>
                                                    </label>
                                                </div>

                                                <div class="checkbox checkbox-pink form-check-inline px-2">

                                                    <input name="ov[]"
                                                           id="ov-apm-<?= $apm['id'] ?>"
                                                           value="<?= $apm['id'] ?>"
                                                           type="checkbox" <?= $is_ov ?>>
                                                    <label for="ov-apm-<?= $apm['id'] ?>"><i class="<?= $text_ov ?> mdi mdi-eye"></i>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach;?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>


                <div class="form-group row mt-3">
                    <div class="col-8 offset-4">
                        <button type="submit"
                                value="update"
                                name="submitupdate"
                                class="btn btn-custom waves-effect waves-light">
                            Cập Nhật
                        </button>
                    </div>
                </div>
            </form>

        </div>

    </div> <!-- end container -->
</div>
<!-- end wrapper -->

<script>
    commands.push(function() {
        $( document ).ready(function() {
            $('select[name=account_id]').on('change', function() {
                window.location = '/admin/list-user-district?account-id='+$('select')
                    .val();
            });
            $('select[name=account_id]').select2();
        });
    });
</script>