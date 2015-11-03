@extends('layouts.userpage')

@section('title', 'Checkout')

@section('page-content')
	<div class="row">
		<div class="col-sm-12 page-header">
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
												{{ $item->qty }}
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
							<hr>
							<div class="col-sm-6">
								<form action="/cart/payment/bank-transfer" method="POST">
									{!! csrf_field() !!}

									<div class="form-group">
										<label for="bank" class="control-label">Bank</label>
										<select class="form-control" id="bank" name="bank">
											<option value="bca">Bank BCA</option>
											<option value="bri">Bank BRI</option>
											<option value="bni">Bank BNI</option>
										</select>
									</div>

									<div class="form-group">
										<label for="account_number" class="control-label">No Rekening</label>
										<input type="text" class="form-control" id="account_number" placeholder="Masukan no rekening anda" name="account_number">
									</div>

									<div class="form-group">
										<label for="account_name" class="control-label">Atas Nama</label>
										<input type="text" class="form-control" id="account_name" placeholder="Masukan nama pemilik rekening" name="account_name">
									</div>

									<div class="form-group">
										<label for="amount" class="control-label">Jumlah</label>
										<div class="input-group">
											<div class="input-group-addon">Rp</div>
											<input type="number" class="form-control" id="amount" placeholder="0.00" name="amount" min="0">
										</div>
									</div>

									<div class="form-group">
										<input type="submit" class="btn btn-primary" value="Kirim">
									</div>

									<div class="form-group">
										<span class="help-block">BCA transfer ke: 01480630479 atas nama Dani Cheng</span>
										<span class="help-block">BRI transfer ke: 02240485148 atas nama Dani Cheng</span>
										<span class="help-block">BNI transfer ke: 00924247668 atas nama Dani Cheng</span>
									</div>

								</form>
							</div>
							<div class="col-sm-6">
								<form action="/cart/payment/creditcard" method="POST">
									<script
										src="https://checkout.stripe.com/checkout.js" class="stripe-button"
										data-key="{{ env('STRIPE_KEY') }}"
										data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
										data-name="Toko Star"
										data-email="{{ $user->email }}"
										data-description="Pembelian Produk Tgl {{ \Carbon\Carbon::now()->toDateString() }}"
										data-label="Bayar Dengan kartu Kredit"
										data-currency="IDR"
										data-amount="{{ $total }}00"
										data-locale="auto">
									</script>
								</form>
							</div>
						@endif
					</div>
				</div>
			</section>
		</div>

		@include('layouts.partials.sidebar')
	</div>
@endsection