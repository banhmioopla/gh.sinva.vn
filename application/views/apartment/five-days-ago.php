<dl class="card-box">
    <div class="row text-info font-weight-bold">
        <div class="col-12">
            <h5 class="bg-dark text-warning p-3">NGỦ SUỐT 5 NGÀY</h5>
            <?php if($check_profile): ?>
            <button href="#custom-modal" id="five-days" class="btn btn-secondary waves-effect w-md mr-2 mb-2"
               data-animation="fadein" data-overlayColor="#36404a" data-plugin="custommodal" data-overlaySpeed="100">Danh sách của QLDA</button>
            <?php endif; ?>
        </div>
        <?php foreach ($list_apm_5days as $apm5): ?>
        <!--ITEM -->
        <dt class="col-10"> <i class="mdi mdi-chevron-double-right"></i> <?= "Q.". $apm5['district']. " | ". $apm5['address'] ?></dt>
        <dd class="col-2 text-right text-danger"><?= "-".$apm5['num_days'] ?></dd>
        <?php endforeach; ?>
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
            <dt class="col-10"> <i class="mdi mdi-chevron-double-right"></i> <?= "Q.". $apm5['district']. " | ". $apm5['address'] ?></dt>
            <dd class="col-2 text-right text-danger"><?= "-".$apm5['num_days'] ?></dd>
        <?php endforeach; ?>
        </div>
    </div>
</div>
<script>
    commands.push(function() {
        <?php if($this->session->userdata('isTriggerFiveDay') === true):
            $this->session->set_userdata(['isTriggerFiveDay' => false]);

        ?>
        $('#five-days').trigger('click');
        <?php endif; ?>
    });
</script>