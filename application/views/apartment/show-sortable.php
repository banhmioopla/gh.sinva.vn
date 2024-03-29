<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">test</a></li>
                            <li class="breadcrumb-item"><a href="#">Extra Pages</a></li>
                            <li class="breadcrumb-item active">Starter</li>
                        </ol>
                    </div>
                    <h2 class="font-weight-bold text-danger">Sắp xếp dự án Quận <?= $this->input->get('district-code') ?></h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <span class="d-flex justify-content-center flex-wrap ">
                    <?php if($this->session->has_userdata('current_district_code')):?>
                        <a  href="<?= '/admin/list-apartment?district-code='.$this->session->userdata('current_district_code') ?>"><button type="button" class="btn btn-rounded m-1 btn-sm btn-outline-secondary"><i class="mdi mdi-arrow-left-bold-circle"></i> Back</button></a>
                    <?php endif; ?>
                        <?php
                        foreach($this->list_OPEN_DISTRICT as $district):
                            $district_btn = 'btn-outline-success';
                            ?>

                            <a href="<?= base_url().'admin/apartment/sortable?district-code='.$district ?>"
                               class="btn m-1 btn-sm <?= $district_btn ?>
                                <?= $district_code == $district ? 'active':'' ?>
                                btn-rounded waves-light waves-effect">
                            Q. <?= $district ?> </a>

                        <?php endforeach; ?>
                    </span>
            </div>
            <div class="col-md-6 offset-md-3 mt-3">
                <div class="card-box">
                    <table class="table">
                        <tbody id="sortable-ui">
                       <?php foreach ($list_apm_ready as $apm):?>
                       <tr class="sort-apm-item" data-apm-id="<?=$apm['id']?>">
                           <td><?= $apm['address_street'] . ", Ph. ".$apm['address_ward'] ?></td>
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
        $(function () {
            $('#sortable-ui').sortable({
                revert: true,
                forceHelperSize: true,
                forcePlaceholderSize: true,
                axis: 'y',
                tolerance: 'pointer',
                connectWith: ".sort-apm-item",
                update: function (event, ui) {
                    let list_order = [];
                    $(this).children().each(function (index) {
                        let x = index + 1;
                        if ($(this).data('position') != x) {
                            $(this).data('position', x);
                            list_order.push({apm_id: $(this).data('apm-id'), order: x});
                        }
                    });

                    $.ajax({
                        url: '/admin/update-apartment-editable',
                        method: "POST",
                        data: {mode: 'sort', value: list_order},
                        success: function (res) {
                        }
                    });
                },
                start:function (event, ui) {
                }
            }).disableSelection();
        });
    });
</script>