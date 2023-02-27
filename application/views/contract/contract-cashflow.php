<?php
$list_cash_in = $list_cash_out = [];
if(!empty($contract['arr_cash_in']) && strlen($contract['arr_cash_in']) > 2){
	$list_cash_in = json_decode($contract['arr_cash_in'], true);
}

if(!empty($contract['arr_cash_out']) && strlen($contract['arr_cash_out']) > 2){
	$list_cash_out = json_decode($contract['arr_cash_out'], true);
}

?>

<div class="row">
	<div class="col-md-12">
		<div class="card-box shadow">
			DÒNG TIỀN ĐANG !!! CODE CÁI J ĐÓ ??!>!?!#?#>@#>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card-box shadow">
			<h4 class="m-t-0 m-b-30 header-title text-success font-weight-bold">TIỀN ĐI VÀO SALE</h4>
			<?php for ($i = 0; $i <$row_cash; $i++): ?>
			<div class="form-group">
				<label for="cashIn_<?= $i ?>">Khoản <?= $i+1 ?></label>
				<input type="number" name="list_cash_in[]" min="0" value="<?=isset($list_cash_in[$i]) ? $list_cash_in[$i]:'' ?>" class="form-control" id="cashIn_<?= $i ?>">
			</div>
			<?php endfor;?>
			<button type="button" data-con-id="<?= $contract['id'] ?>" class="btn btn-danger submitCashFlow">Cập nhật tiền</button>

		</div>
	</div>
	<div class="col-md-6">
		<div class="card-box shadow">
			<h4 class="m-t-0 m-b-30 header-title text-danger font-weight-bold">TIỀN ĐI RA SALE</h4>

			<?php for ($i = 0; $i <$row_cash; $i++): ?>
				<div class="form-group">
					<label for="cashIn_<?= $i ?>">Khoản <?= $i ?></label>
					<input type="number" min="0" name="list_cash_out[]" value="<?= isset($list_cash_out[$i]) ? $list_cash_out[$i]:''  ?>" class="form-control" id="cashIn_<?= $i ?>">
				</div>
			<?php endfor;?>
			<button type="button" data-con-id="<?= $contract['id'] ?>" class="btn btn-danger submitCashFlow">Cập nhật tiền</button>
		</div>
	</div>
</div>

<script type="text/javascript">
	commands.push(function () {
		$(document).ready(function () {
			$('.submitCashFlow').click(function () {
				let _this = $(this);
				let _inputCashIn = $('input[name="list_cash_in[]"]');
				let _inputCashOut = $('input[name="list_cash_out[]"]');
				let cashInVal = _inputCashIn.map(function (){ return  $(this).val();}).get();
				let cashOutVal = _inputCashOut.map(function (){ return  $(this).val();}).get();
				$.ajax({
					method:'POST',
					url: '/admin/contract-cashflow/ajax-update',
					dataType:'json',
					data:{con_id:_this.data('con-id'), list_cash_in: cashInVal, list_cash_out: cashOutVal},
					success: function (res){
						if(res.status === true){
							swal({
								title: 'Cập nhật tiền Thành Công!',
								type: 'success',
								confirmButtonClass: 'btn btn-confirm mt-2'
							});
						}

					}
				})
			});

		});
	});
</script>
