@extends('layouts.adminpage')

@section('title', 'Daftar Transaksi')

@section('page-content')

	<h1 class="content-header">Daftar Pesanan</h1>
	@if (count($orders) > 0)
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Tanggal</th>
						<th>Nama</th>
						<th>Total Bayar</th>
						<th>Metode Pembayaran</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
				@foreach ($orders as $order)
					<tr>
						<td>{{ $order->created_at->format('j F Y') }}</td>
						<td>{{ $order->user->name }}</td>
						<td>Rp. {{ $order->total_paid }}</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	@else
		<p>Tidak ada data transaksi</p>
	@endif
	{!! $orders->render() !!}
@endsection