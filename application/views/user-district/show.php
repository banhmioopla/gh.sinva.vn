<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Highdmin</a></li>
                            <li class="breadcrumb-item"><a href="#">Extra Pages</a></li>
                            <li class="breadcrumb-item active">Starter</li>
                        </ol>
                    </div>
                    <h3> Phân Quận Cho Quản Lý Dự Án </h3>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="row">
            <form method="post" class="col-md-6 col-12 card-box" name="form-user-district" action="<?= base_url().'/admin/list-user-district' ?>">
                <div class="">
                    <select class="custom-select mt-3 form-control" name="account_id">
                        <?= $cb_product_manager ?>
                    </select>
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
                $('form[name=form-user-district]').submit();
            });
        });
    });
</script>