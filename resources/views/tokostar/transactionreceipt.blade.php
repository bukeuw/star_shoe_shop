@extends('layouts.master')

@section('content')
	<div class="container-fluid">
		<h1 class="content-header">Transaction Detail</h1>
		@if (count($transaction->details) > 0)
			<p>Nama: {{ Auth::user()->name }}</p>
			<p>Tgl Transaksi: {{ $transaction->created_at->format('j F Y') }}</p>
			<p>Metode Pembayaran: {{ $transaction->payment_method }}</p>
			<div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
							<td>Nama Barang</td>
							<td>Jumlah</td>
							<td>Harga Satuan</td>
							<td>Subtotal</td>
						</tr>
					</thead>
					<tbody>
					@foreach ($transaction->details as $detail)
						<tr>
							<td>{{ $detail->product->name }}</td>
							<td>{{ $detail->quantity }} {{ $detail->product->unit }}</td>
							<td>{{ $detail->product->price }}</td>
							<td>Rp. {{ ($detail->product->price * $detail->quantity) }}</td>
						</tr>
					@endforeach
					</tbody>
					<tfoot>
						<td>Total Bayar</td>
						<td colspan="3">
							<p class="text-right">Rp. {{ $transaction->total }}</p>
						</td>
					</tfoot>
				</table>
			</div>
		@endif
	</div>
@endsection