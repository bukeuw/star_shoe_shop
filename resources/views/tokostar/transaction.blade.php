@extends('layouts.adminpage')

@section('title', 'Daftar Transaksi')

@section('page-content')

	@include('layouts.partials.messagebag')

	<h1 class="content-header">Produk</h1>
	@if (count(Auth::user()->transactions) > 0)
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Tanggal</th>
						<th>Total Bayar</th>
						<th>Metode Pembayaran</th>
						<th>Status</th>
						<th>Detail</th>
					</tr>
				</thead>
				<tbody>
				@foreach (Auth::user()->transactions as $transaction)
					<tr>
						<td>{{ $transaction->create_at->toDateString() }}</td>
						<td>{{ $transaction->total }}</td>
						<td>{{ $transaction->payment_method }}</td>
						<td>{{ $transaction->confirmed? 'Sukses':'Pending' }}</td>
						<td>
							<a href="/member/{{ $transaction->id }}" class="btn btn-default">Lihat Detail</a>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	@else
		<p>Tidak ada transaksi</p>
		<a href="/product" class="btn btn-default">Lanjut Belanja</a>
	@endif
@endsection

@section('custom-js')
	@include('layouts.partials.messagebagscript')
@endsection