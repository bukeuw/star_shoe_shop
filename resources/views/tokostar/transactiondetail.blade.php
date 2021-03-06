@extends('layouts.userpage')

@section('title', 'Detail Transaksi')

@section('page-content')

	@include('layouts.partials.messagebag')

	<h1 class="content-header">Transaction Detail</h1>
	@if (count($transaction->details) > 0)
		<p>Nama: {{ Auth::user()->name }}</p>
		<p>Tgl Transaksi: {{ $transaction->created_at->format('j F Y') }}</p>
		<p>Metode Pembayaran: {{ $transaction->payment_method }}</p>
		<a href="/member/transaction/{{ $transaction->id }}/download" class="btn btn-default">
			<i class="fa fa-file-pdf-o"></i> Download as PDF
		</a>
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Nama Barang</th>
						<th>Jumlah</th>
						<th>Harga Satuan</th>
						<th>Subtotal</th>
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
					<th>Total Bayar</th>
					<th colspan="3">
						<p class="text-right">Rp. {{ $transaction->total }}</p>
					</th>
				</tfoot>
			</table>
		</div>
	@endif
@endsection

@section('custom-js')
	@include('layouts.partials.messagebagscript')
@endsection