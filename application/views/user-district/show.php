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
                <h3 class="text-center text-danger">Chia Quận</h3>

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
                <div class="w-50">
                    <select class="custom-select mt-3 form-control" name="account_id">
                        <?= $libUser->cb($this->input->get('account-id'), 'YES') ?>
                    </select>
                </div>
                <div class="form-group row mt-3">
                    <label for="is_view_only" class="col-4 col-form-label font-weight-bold
                    text-right">Chỉ xem (view only)</label>
                    <div class="col-8">
                        <div>
                            <div class=" checkbox checkbox-success">
                                <input id="is_view_only" type="checkbox"
                                       value="YES"
                                       <?= count($this->list_district_view_only) > 0
                                           ? 'checked' :"" ?>
                                       name="is_view_only">
                                <label for="is_view_only">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">

                    <?php foreach($list_district as $district):?>

                        <div class=" col-3 checkbox checkbox-custom form-check-inline">
                            <input name="code[]" 
                                    id="<?= $district['code'] ?>" 
                                    value=<?= $district['code'] ?>
                                    type="checkbox" <?= in_array((string)$district['code'], $list_ud)? 'checked':'' ?>>
                            <label for="<?= $district['code'] ?>">
                                Q. <?= $district['name'] ?>
                            </label>
                        </div>
                    <?php endforeach;?>
                </div>

                <div class="form-group row mt-3">
                    <div class="col"><p class="text-info">Nếu chỉ chia theo dự án thì không cần chọn quận</p></div>
                    <?php foreach($list_district as $district):
                        ?><h4 class="col-12 mt-3">Dự Án Quận <?= $district['name'] ?> </h4><?php
                        $list_apartment = $ghApartment->get(['district_code' => $district['code'], 'active' => 'YES']);
                        foreach ($list_apartment as $apm):
                        ?>

                            <div class="pl-2 col-3 checkbox checkbox-custom form-check-inline">
                                <input name="apm[]"
                                       id="apm-<?= $apm['id'] ?>"
                                       value="<?= $apm['id'] ?>"
                                       type="checkbox" <?= in_array((string)$apm['id'], $list_apm)? 'checked':'' ?>>
                                <label for="apm-<?= $apm['id'] ?>"><?= $apm['address_street'] ?></label>
                            </div>
                        <?php endforeach;?>
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
        });
    });
</script>