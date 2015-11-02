<div class="table-responsive">
	<table class="table-stripped">
		<thead>
			<tr>
			@foreach($columns as $column)
				<td>{{ $column }}</td>
			@endforeach
			</tr>
		</thead>
		<tbody>
			<tr>
				<td></td>
			</tr>
		</tbody>
	</table>
</div>