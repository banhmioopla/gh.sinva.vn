
<div class="wrapper">
    <div class="container">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">GH</a></li>
                            <li class="breadcrumb-item"><a href="#">Bài Đăng Tư Vấn</a></li>
                            <li class="breadcrumb-item active">Chỉnh Sửa</li>
                        </ol>
                    </div>
                    <h2 class="font-weight-bold text-danger"><?= $post['title'] ?></h2>
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
                    <form action="">
                        <div class="form-group row">
                            <label class="col-md-4 col-12 col-form-label font-weight-bold">Chỉnh Sửa Bài Đăng Khác</label>
                            <div class="col-md-9 col-12">
                                <select name="id" class="select2 form-control">
                                    <option value="" disabled> - Chỉnh Sửa Bài Đăng Khác - </option>
                                    <?php foreach ($list_post as $item): ?>
                                        <option value="<?= $item['id'] ?>"> <?= $item['title'] ?> </option>
                                    <?php endforeach; ?>
                                </select>

                            </div>
                            <div class="col text-center">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                    Chỉnh Sửa
                                </button>
                            </div>
                        </div>
                    </form>
                    <form role="form" method="post" action="">
                        <div class="form-group row">
                            <label class="col-md-4 col-12 col-form-label font-weight-bold">Tiêu Đề</label>
                            <div class="col-md-12 col-12">
                                <input value="<?= $post['title'] ?>" type="text" class="form-control" required name="title">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-12 col-form-label font-weight-bold">Mô Tả</label>
                            <div class="col-md-12 col-12">
                                <textarea name="content" rows="10" id="summernote"><?= $post['content'] ?></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col text-center">
                                <a href="/admin/consultant-post/your-list">
                                <button type="button" class="btn btn-secondary waves-effect waves-light">
                                    Danh Sách Bài Đăng
                                </button>
                                </a>
                                <button type="submit" name="submit" class="btn btn-danger waves-effect waves-light">
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

            $('.select2').select2();

        });
    });
</script>