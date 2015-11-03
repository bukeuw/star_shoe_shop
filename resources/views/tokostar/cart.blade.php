@extends('layouts.userpage')

@section('title', 'Keranjang Belanja')

@section('page-content')
	<div class="row">
		<div class="col-md-12 page-header">
			<h1>Keranjang Belanja</h1>
		</div>
		<div class="col-md-9">
			<section>
				<div class="panel panel-dark">
					<div class="panel-body">
						@if(count($cartItems) > 0)
							<a href="/product" class="btn btn-default">Lanjut Belanja</a>
							<div class="table-responsive">
								<table class="table table-hover">
									<thead>
										<tr>
											<th>Nama Produk</th>
											<th>Jumlah</th>
											<th>Harga satuan</th>
											<th>Subtotal</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
									@foreach($cartItems as $item)
										<tr>
											<td>{{ $item->product->name }}</td>
											<td>
												<form class="cart-item-qty" action="/cart/updateItem/{{$item->id}}" method="POST">
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
											<td>
												<a href="/cart/removeItem/{{ $item->id }}" class="btn btn-danger"><i class="fa fa-remove"></i></a>
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
							<a href="/cart/checkout" class="btn btn-default">Check Out</a>
						@else
							<p>Tidak ada item dalam keranjang Anda</p>
							<a href="/product" class="btn btn-default">Lanjut Belanja</a>
						@endif
					</div>
				</div>
			</section>
		</div>

		@include('layouts.partials.sidebar')
	</div>
@endsection