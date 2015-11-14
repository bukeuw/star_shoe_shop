@extends('layouts.adminpage')

@section('title', 'Daftar Transaksi')

@section('page-content')

	<h1 class="content-header">Daftar Pesanan</h1>
	@if (count($orderItems) > 0)
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Tanggal</th>
						<th>Pemesan</th>
						<th>Nama Barang</th>
						<th>Jumlah</th>
						<th>Terpenuhi</th>
					</tr>
				</thead>
				<tbody>
				@foreach ($orderItems as $item)
					<tr>
						<td>{{ $item->order->created_at->format('j F Y') }}</td>
						<td>{{ $item->order->user->name }}</td>
						<td>{{ $item->product->name }}</td>
						<td>{{ $item->product->qty }}</td>
						<td>{{ $item->confirmed ? 'Ya' : 'Belum' }}</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	@else
		<p>Tidak ada data transaksi</p>
	@endif
	{!! $orderItems->render() !!}
@endsection