<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Share</a></li>
                            <li class="breadcrumb-item active"><a class="text-primary" href="/share/agency-group/show">DS Mẫu Email</a> </li>
                        </ol>
                    </div>
                    <h2 class="font-weight-bold text-primary">DS Mẫu Email</h2>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php  if($this->session->has_userdata('fast_notify')): ?>
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('fast_notify')['message'] ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col-12">
                            <table class="table">
                                <thead class="table-dark">
                                <th>Mô tả</th>
                                <th>Tiêu đề</th>
                                </thead>
                                <tbody>
                                <?php foreach ($list_template as $item): ?>
                                    <tr>
                                        <td><?= $item['description']?></td>
                                        <td><?= $item['subject']?></td>
                                        <td><?= $item['subject']?></td>

                                        <td>
                                            <a href="/">
                                                <button class="btn btn-sm btn-outline-info btn-rounded waves-light waves-effect">
                                                    <i class="mdi mdi-account-multiple"></i> <span class="d-none d-md-inline">Test</span>
                                                </button></a>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card-box">
                    <h4 class="text-primary font-weight-bold">Thêm Mẫu Mới</h4>
                    <form role="form" autocomplete="off" method="post" action="/share/user/create">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-12 col-form-label">Mô tả ngắn<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <input type="text" required class="form-control"
                                       id="name" name="name" placeholder="Mô tả ngắn">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-12 col-form-label">Tiêu đề mail<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <input type="text" required class="form-control"
                                       id="subject" name="subject" placeholder="Tiêu đề mail">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone_number" class="col-md-4 col-12 col-form-label">Content<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <textarea name="content" class="form-control" ></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-8 offset-4">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                    Thêm Mới
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> <!-- end container -->
</div>