<div class="row">
    <div class="col-md-6">
        <div class="card-box shadow">
            <form action="/admin/create-contract-partial" method="post">
                <input type="hidden" name="contract_id" value="<?= $contract['id'] ?>">
                <div class="row">
                    <div class="col-12">
                        <h4 class="text-danger font-weight-bold">Nhập Doanh Thu</h4>
                    </div>
                    <div class="col-12">
                        <div class="form-group row">
                            <label class="col-md-3 col-12 col-form-label text-right" for="example-input-normal">Ngày Thu</label>
                            <div class="col-md-9 col-12">
                                <input type="text" name="apply_time" required class="form-control datepicker" value="<?= date('d-m-Y') ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-12 col-form-label text-right" for="example-input-normal">Số Tiền Cần Thu</label>
                            <div class="col-md-9 col-12">
                                <input type="text" required name="amount" class="form-control" value="<?= $remaining_amount ?>">
                            </div>
                        </div>
                    </div>

                    <button class="btn col-md-6 offset-md-3 btn-danger" type="submit">Thêm Mới</button>

                </div>
            </form>
        </div>
    </div>

    <?php if(count($list_partial)): ?>
        <div class="col-md-6">
            <div class="card-box shadow">
                <div class="row">
                    <div class="col-12">
                        <h4 class="text-danger font-weight-bold">Các Đợt Thu Tiền</h4>
                    </div>

                    <table class="table table-hover table-dark">
                        <thead>
                        <tr>
                            <th>Ngày Thu</th>
                            <th class="text-right">Số Tiền</th>
                            <th class="text-right"></th>
                        </tr>
                        </thead>
                        <?php foreach ($list_partial as $item):?>
                            <tr>
                                <td><?= date("d/m/Y",$item['apply_time']) ?></td>
                                <td class="text-right"><?= number_format($item['amount']) ?></td>
                                <td class="text-right">
                                    <button class="btn btn-danger
                                                btn-sm delete-partial float-md-right
                                                ml-3"
                                            data-id="<?= $item['id'] ?>"
                                    ><i
                                                class="dripicons-trash"
                                                style="font-size: 10px;"
                                        ></i></button>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </table>

                </div>
            </div>
        </div>
    <?php endif; ?>


</div>

<script>
    commands.push(function () {
        $('.delete-partial').click(function () {
            let id = $(this).data("id"); console.log(id);
            let _this = $(this);
            $.ajax({
                url: '/admin/contract/partial/delete',
                method: 'post',
                data: {
                    id:id
                },
                dataType:'json',
                success: function (res) {
                    console.log(res);
                    _this.closest('tr').remove();
                }
            });
        });
    });
</script>