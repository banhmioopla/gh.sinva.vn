<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">giohang</a></li>
                            <li class="breadcrumb-item"><a href="#">Extra Pages</a></li>
                            <li class="breadcrumb-item active">Starter</li>
                        </ol>
                    </div>
                    <h2 class="font-weight-bold text-danger">Kho Ảnh Dự Án</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-8 offset-md-2">
                <div class="card-box table-responsive">
                <table id="table-data" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Quận</th>
                        <th>Địa Chỉ</th>
                        <th class="text-center">Số lượng Hình</th>
                    </tr>
                </thead>
                
                <tbody>
               
                    
                <?php foreach($list_apartment as $apartment):
                ?>
                    <tr>
                        <td>Quận <?= $libDistrict->getNameByCode($apartment['district_code']) ?></td>
                        <td><a href="/admin/apartment/show-image?apartment-id=<?= $apartment['id'] ?>" target="_blank"><?= $apartment['address_street'] ?></a></td>
                        <td class="text-center"><?= count($ghImage->getRows($apartment['id'])) ?></td>
                    </tr>
                <?php endforeach; ?>
               
                </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
commands.push(function() {
        $(document).ready(function() {
            $('#table-data').DataTable({});
        });
});
    
</script>