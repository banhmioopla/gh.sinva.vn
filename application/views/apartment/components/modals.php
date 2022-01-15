<div id="custom-modal" class="modal-demo bs-example-modal-lg">
    <button type="button" class="close" onclick="Custombox.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title text-center"> <div>Đã 5 ngày rồi bạn chưa cập nhật</div> <div class="mt-2">Hãy kiểm tra danh sách ngay nhé!</div></h4>
    <div class="custom-modal-text">
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger" role="alert">
                    <strong><?= count($list_apm_5days_CURD) ?> dự án</strong> đợi bạn review
                </div>
            </div>
            <?php foreach ($list_apm_5days_CURD as $apm5): ?>
                <!--ITEM -->
                <dt class="col-10" >
                    <div class="checkbox checkbox-danger">
                        <input id="checkboxFive-<?= $apm5['apm_id'] ?>" class="check-five-days" value="<?= $apm5['apm_id'] ?>" type="checkbox">
                        <label for="checkboxFive-<?= $apm5['apm_id'] ?>">
                            <a target="_blank" href="/admin/profile-apartment?id=<?= $apm5['apm_id'] ?>"><?= "Q.". $apm5['district']. " | ". $apm5['address'] ?></a>
                        </label>
                    </div> </dt>
                <dd class="col-2 text-right text-danger"><?= "-".$apm5['num_days'] ?></dd>
            <?php endforeach; ?>
        </div>
    </div>
    <?php if(count($list_apm_5days_CURD)): ?>
        <div class="modal-footer">
            <button type="button" id="update-all-apm-today" class="btn btn-primary waves-effect waves-light">Đồng bộ ngày cập nhật dự án thành ngày <?= date('d-m-Y') ?></button>
        </div>
    <?php endif; ?>
</div>

<div id="setting" class="modal fade" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Cài đặt dự án</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-primary">Quận mặc định khi đăng nhập</div>

                    <div class="col-12">
                        <select id="setting_default_district" data-keyword="<?= $this->ghUserConfig::KEYWORD_DEFAULT_DISTRICT ?>" data-account_id="<?= $this->auth['account_id'] ?>" name="default_district" class="form-control select2">
                            <?php foreach($list_district as $district):
                                $slc = ""; if($this->default_district == $district['code']) $slc="selected";
                                ?>
                                <option <?= $slc ?> value="<?= $district['code'] ?>"><?= $district['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <div id="setting-msg" class="text-success"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light waves-effect"
                        data-dismiss="modal">Đóng</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->