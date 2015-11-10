@extends('layouts.userpage')

@section('title', 'Home')

@section('page-content')
	<div class="row">
		
		@include('layouts.partials.searchbox')

		<div class="col-sm-12">
			<div class="jumbotron tkstar-banner">
				<h1>Selamat datang di tokostar.com</h1>
				<p>Kami menyediakan berbagai jenis sendal dan sepatu berkualitas.</p> <br />
				<a href="/product" class="btn">Lihat semua produk</a>
			</div>
		</div>

		<div class="col-md-9">
			<div class="row products">

			@if(count($products) > 0)
				
				@include('layouts.partials.productlist')
				
				<div class="col-sm-12 panel">
					<p class="text-center">
						<a href="/product">More Product</a>
					</p>
				</div>
			@else
				<h1>Maaf, saat ini tidak ada produk yang tersedia</h1>
			@endif

			</div>
		</div>
		
		@include('layouts.partials.sidebar')

	</div>
@endsection