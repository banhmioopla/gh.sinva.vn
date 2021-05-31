
<div class="wrapper">
    <div class="container">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">GH</a></li>
                            <li class="breadcrumb-item"><a href="#">Dự Án</a></li>
                            <li class="breadcrumb-item active">Mô Tả</li>
                        </ol>
                    </div>
                    <h2 class="font-weight-bold text-danger">Mô Tả <?= $apartment['address_street'] ?></h2>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-12">
                <?php
                if($this->session->has_userdata('fast_notify')):
                    ?>
                    <div class="alert alert-<?= $this->session->flashdata('fast_notify')['status']?> alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('fast_notify')['message']?>
                    </div>
                <?php unset($_SESSION['fast_notify']); endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card-box">
                    <form role="form" method="post" action="">
                        <div class="form-group row">
                            <label class="col-md-4 col-12 col-form-label">Mô tả</label>
                            <div class="col-md-12 col-12">
                                <textarea name="description" rows="10" id="summernote"><?= $apartment['description'] ?></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-8 offset-4">
                                <button type="submit" name="submit" class="btn btn-custom waves-effect waves-light">
                                    Cập Nhật
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
            $('#summernote').summernote({
                height: 300,                 // set editor height
                minHeight: null,             // set minimum height of editor
                maxHeight: null,             // set maximum height of editor
                focus: true
            });

        });
    });
</script>