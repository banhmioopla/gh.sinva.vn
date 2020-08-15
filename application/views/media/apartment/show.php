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
                    <h4 class="page-title">Starter</h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="row">
            <div class="col-sm-12">
                <div class="card-box">
                    <h4 class="m-t-0 header-title">Upload Ảnh dự Án</h4>
                    <h5 class="text-warning"><?= 'tại '.$apartment_model['address_street'] ?></h5>
                    <p class="text-muted mb-0 font-14">
                        Từ khi cúp họp, tôi quyết tâm mần chỗ upload ảnh này thiệt là đầu tư. 1 bức ảnh thuộc nhiều thể loại mà bạn muốn... let's kill this love
                    </p>

                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="demo-box">
                                <form>
                                    <div class="form-group">
                                        <p class="mb-2 mt-4 font-weight-bold text-muted">chọn ảnh tại đây</p>
                                        <input type="file" 
                                        class="filestyle" 
                                        name="img-apartment[]"
                                        data-input="false" data-btnClass="btn-custom">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col checkbox checkbox-custom form-check-inline">
                            <input name="" 
                                    id="" 
                                    class="form-control"
                                    type="checkbox">
                            <label for="">Mở</label>
                        </div>
                    </div> <!-- end row -->
                </div> <!-- end card-box -->
            </div> <!-- end col -->
        </div>

        

    </div> <!-- end container -->
</div>
<!-- end wrapper -->