@extends('layouts.userpage')

@section('title', 'Daftar Pesanan')

@section('page-content')
	<div class="row">
		<div class="col-md-12 page-header">
			<h1>Daftar Pesanan</h1>
		</div>
		<div class="col-md-9">
			<section>
				<div class="panel panel-dark">
					<div class="panel-body">
						@if(count($orderItems) > 0)
							<a href="/product" class="btn btn-default">Lihat Daftar Produk</a>
							<div class="table-responsive">
								<table class="table table-hover">
									<thead>
										<tr>
											<th>Nama Produk</th>
											<th>Jumlah</th>
											<th>Harga satuan</th>
											<th>Subtotal</th>
											<th>Status</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
									@foreach($orderItems as $item)
										<tr>
											<td>{{ $item->product->name }}</td>
											<td>
												<form class="cart-item-qty" action="/order/updateItem/{{$item->id}}" method="POST">
													{!! csrf_field() !!}
													<div class="input-group">
														<input class="form-control" type="number" name="qty" min="1" max="20" value="{{ $item->qty }}">
														<div class="input-group-btn">
															<button type="submit" class="btn btn-primary"><i class="fa fa-pencil"></i></button>
														</div>
													</div>
												</form>
											</td>
											<td>Rp. {{ $item->product->price }}</td>
											<td>Rp. {{ ($item->product->price * $item->qty) }}</td>
											<td>{{ $item->confirmed ? 'Diterima':'Belum Dikonfirmasi' }}</td>
											<td>
											@if($item->confirmed)
												<a href="/order/removeItem/{{ $item->id }}" class="btn btn-danger"><i class="fa fa-remove"></i></a>
											@endif
											</td>
										</tr>
									@endforeach
									</tbody>
									<tfooter>
										<tr>
											<th colspan="3">Total Bayar</th>
											<th>Rp. {{ $total }}</th>
										</tr>
									</tfooter>
								</table>
							</div>
						@else
							<p>Tidak ada item</p>
							<a href="/product" class="btn btn-default">Lihat Daftar Produk</a>
						@endif
					</div>
				</div>
			</section>
		</div>

		@include('layouts.partials.sidebar')
	</div>
@endsection