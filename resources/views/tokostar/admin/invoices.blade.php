@extends('layouts.adminpage')

@section('title', 'Daftar Transaksi')

@section('page-content')

	<h1 class="content-header">Daftar Transaksi</h1>
	<div>
		<div class="input-group">
			//
		</div>
	</div>
	@if (count($transactions) > 0)
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Tanggal</th>
						<th>Nama</th>
						<th>Total Bayar</th>
						<th>Metode Pembayaran</th>
						<th>Status</th>
						<th>Detail</th>
					</tr>
				</thead>
				<tbody>
				@foreach ($transactions as $transaction)
					<tr>
						<td>{{ $transaction->created_at->format('j F Y') }}</td>
						<td>{{ $transaction->user->name }}</td>
						<td>Rp. {{ $transaction->total }}</td>
						<td>{{ $transaction->payment_method }}</td>
						<td>{{ $transaction->confirmed? 'Sukses':'Pending' }}</td>
						<td>
							<a href="/admin/invoice/{{ $transaction->id }}" class="btn btn-default">Lihat Detail</a>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	@else
		<p>Tidak ada data transaksi</p>
	@endif
	{!! $transactions->render() !!}
@endsection