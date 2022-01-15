<div class="row">
    <div class="col-12">
        <h4 class="text-primary"> <i class="mdi mdi-arrow-right-drop-circle-outline"></i>Dự án đã update sau 5 ngày</h4>
        <?php if($check_profile): ?>
            <?php if(count($list_apm_5days_CURD)): ?>
                <button href="#custom-modal" id="five-days" class="btn btn-danger waves-effect w-md mr-2 mb-2"
                        data-animation="fadein"
                        data-overlayColor="#36404a" data-plugin="custommodal" data-overlaySpeed="100">Xem danh sách</button>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <div class="slimscroll col-12" style="max-height: 350px">
        <?php foreach ($list_apm_5days_CURD as $apm5): ?>
            <!--ITEM -->
            <div> <i class="mdi mdi-chevron-double-right"></i> <?= "Q.". $apm5['district']. " | ". $apm5['address']?> <span class="pull-right text-danger"> <?= "-{$apm5['num_days']}" ?></span></div>
        <?php endforeach; ?>
    </div>

</div>
<!-- Modal -->

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