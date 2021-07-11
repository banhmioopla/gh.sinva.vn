<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Share</a></li>
                            <li class="breadcrumb-item"><a href="/share/agency-group/show">Đội nhóm môi giới</a></li>
                            <li class="breadcrumb-item active"><a class="text-primary" href="/share/agency-group-apartment/show?group-id=<?= $this->input->get("group-id") ?>">Chia Sẻ Dự Án - <?= $group['name'] ?></a> </li>
                        </ol>
                    </div>
                    <h2 class="font-weight-bold text-primary">Chia Sẻ Dự Án - <?= $group['name'] ?> </h2>
                </div>
            </div>

            <div class="col-12">
                <?php
                if($this->session->has_userdata('fast_notify')) {
                    $flash_mess = $this->session->flashdata('fast_notify')['message'];
                    $flash_status = $this->session->flashdata('fast_notify')['status'];
                    unset($_SESSION['fast_notify']);
                    ?>

                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <?= $flash_mess ?>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <form action="" method="POST">
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <div class="row">
                        <?php foreach ($list_district as $district):?>
                            <div class="col-12 mt-2">
                                <h4>Quận <?= $district['name'] ?></h4>
                            </div>
                        <?php foreach ($list_apartment as $apm):
                                if($district['code'] !== $apm['district_code']){
                                    continue;
                                }

                                $checked = '';
                                if(in_array($apm['id'], $arr_apm_shared_id)){
                                    $checked = 'checked';
                                }

                                ?>
                            <div class="col-md-6">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="apartment_id[]" value="<?= $apm['id']?>" <?= $checked ?> class="custom-control-input" id="apm-<?= $apm['id']?>">
                                    <label class="custom-control-label" for="apm-<?= $apm['id']?>">Q. <?= $libDistrict->getNameByCode($apm['district_code']) . ' | ' . $apm['address_street'] ?></label>
                                </div>
                            </div>

                        <?php endforeach;?>
                            <div class="col-12">
                                <hr>
                            </div>
                        <?php endforeach;?>

                        <div class="col-md-12 text-center">
                            <button type="submit" name="submit" class="btn btn-primary">Cập Nhật</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>