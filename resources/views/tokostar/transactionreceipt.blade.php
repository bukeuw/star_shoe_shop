@extends('layouts.master')

@section('content')
	<div class="container-fluid">
		<h1 class="content-header">Transaction Detail</h1>
		@if (count($transaction->details) > 0)
			<p>Nama: {{ $transaction->user->name }}</p>
			<p>Tgl Transaksi: {{ $transaction->created_at->format('j F Y') }}</p>
			<p>Metode Pembayaran: {{ $transaction->payment_method }}</p>
			<table class="table">
				<tr>
					<td>Nama Barang</td>
					<td>Jumlah</td>
					<td>Harga Satuan</td>
					<td>Subtotal</td>
				</tr>
				@foreach ($transaction->details as $detail)
					<tr>
						<td>{{ $detail->product->name }}</td>
						<td>{{ $detail->quantity }} {{ $detail->product->unit }}</td>
						<td>{{ $detail->product->price }}</td>
						<td>Rp. {{ ($detail->product->price * $detail->quantity) }}</td>
					</tr>
				@endforeach
				<tr>
					<td>Total Bayar</td>
					<td colspan="3">
						<p class="text-right">Rp. {{ $transaction->total }}</p>
					</td>
				</tr>
			</table>
		@endif
	</div>
@endsection