<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Giỏ Hàng</a></li>
                            <li class="breadcrumb-item"><a href="#">Danh Sách Dự Án</a></li>
                            <li class="breadcrumb-item active">Dự Án: <?= $apartment['address_street'] ?></li>
                        </ol>
                    </div>
                    <h2 class="text-danger font-weight-bold">Cập Nhật: <i><?= $apartment['address_street'] ?></i></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card-box">
                    <h3 class="font-weight-bold">Địa Chỉ</h3>
                    <form role="form" class="mt-3">
                        <div class="form-group">
                            <label>Tên Đường</label>
                            <input type="text" class="form-control" value="<?= $apartment['address_street'] ?>">
                            <small id="emailHelp" class="form-text text-muted">xxx xxx xxxx</small>
                        </div>
                        <div class="form-group">
                            <label >Phường</label>
                            <input type="text" value="<?= $apartment['address_ward'] ?>" class="form-control" id="exampleInputPassword1" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Quận</label>
                            <select class="form-control">
                                <?= $cb_district ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Cập Nhật</button>
                    </form>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card-box">
                    <h3 class="font-weight-bold">Dịch Vụ</h3>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputCity" class="col-form-label">Điện</label>
                            <input type="text" class="form-control" id="inputCity">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputState" class="col-form-label">State</label>
                            <select id="inputState" class="form-control">Choose</select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputZip" class="col-form-label">Zip</label>
                            <input type="text" class="form-control" id="inputZip">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>