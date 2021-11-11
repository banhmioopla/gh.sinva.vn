<dl class="card-box">
    <div class="row text-info font-weight-bold">
        <div class="col-12">
            <h5 class="bg-dark text-warning p-3">NGỦ SUỐT 5 NGÀY</h5>
            <?php if($check_profile): ?>
                <?php if(count($list_apm_5days_CURD)): ?>
                <button href="#custom-modal" id="five-days" class="btn btn-secondary waves-effect w-md mr-2 mb-2"
                        data-animation="fadein"
                        data-overlayColor="#36404a" data-plugin="custommodal" data-overlaySpeed="100">Danh sách của QLDA</button>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <div class="slimscroll col-12" style="max-height: 450px">
            <?php foreach ($list_apm_5days as $apm5): ?>
                <!--ITEM -->
                <dt class="col-10"> <i class="mdi mdi-chevron-double-right"></i> <?= "Q.". $apm5['district']. " | ". $apm5['address'] ?></dt>
                <dd class="col-2 text-right text-danger"><?= "-".$apm5['num_days'] ?></dd>
            <?php endforeach; ?>
        </div>

    </div>

</dl>
<!-- Modal -->
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
        <div class="row">
            <div class="col-12 text-muted">
                Một lần chơi lớn! thử xem thiên hạ có trầm trồ! <span id="time-info"></span>
            </div>
            <div class="col-12">
                <button type="button" id="update-all-apm-today" class="btn btn-primary waves-effect waves-light">Đồng bộ ngày cập nhật dự án thành ngày <?= date('d-m-Y') ?></button>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<script>
    commands.push(function() {
        <?php if(count($list_apm_5days_CURD)): ?>
            <?php if($this->session->userdata('isTriggerFiveDay') === true):
                $this->session->set_userdata(['isTriggerFiveDay' => false]);
            ?>
                $('#five-days').trigger('click');
            <?php endif; ?>
        <?php endif; ?>
        $('#update-all-apm-today').click(function () {
            let arr_pk = [];
            $('.check-five-days').each(function () {
                if($(this).is(":checked")){
                    arr_pk.push($(this).val());
                }

            });

            $.ajax({
                method: 'post',
                url:'<?= base_url()."admin/update-apartment-editable" ?>',
                data: {arr_pk: arr_pk ,mode: 'list_only_time_update'},
                dataType: "json",
                success: function (res) {
                    $('#time-info').text(res.content);
                    $('#time-info').addClass('bg-success text-light pl-2 pr-2');
                    setTimeout(function(){ $('#time-info').removeClass('bg-success text-light pl-2 pr-2') }, 1500);

                }
            });
        });

    });
</script>