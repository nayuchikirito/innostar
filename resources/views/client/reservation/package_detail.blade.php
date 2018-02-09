<h6>Description Detail</h6>
<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th>Service Detail Name</th>
			<th>Cost</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		@foreach($details as $detail)
		<tr>
			<td>{{ $detail->package_description->name }}</td>
			<td class="text-right">{{ number_format($detail->price,2) }} <input type="hidden" class="price" value="{{ $detail->price }}"> <input type="hidden" name="detail[]" value="{{ $detail->id }}"></td>
			<td><a href="#" class="btn btn-danger remove_this" title="Remove this service"><i class="fa fa-times"></i></a></td>
		</tr>
		@endforeach
	</tbody>
	<tfoot>
		<tr>
			<th class="text-right">TOTAL:</th>
			<th class="text-right"><b id="total"></b></th>
		</tr>
	</tfoot>
</table>

<script type="text/javascript">
	function computeTotal(){
		var total = 0.00;
		$('.price').each(function(){
			total+=parseFloat($(this).val());
		});	
		console.log(total);
		$('#total').html(accounting.formatMoney(total, '', 2));
		$('[name="balance"]').val(total);
	}
	computeTotal();
	$(document).off('click', '.remove_this').on('click', '.remove_this', function(){
		if($('.remove_this').length > 1){
			$(this).parent().parent().remove();
		}
		computeTotal();
	});
</script>