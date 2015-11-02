@extends('layouts.userpage')

@section('title', 'Produk')

@section('page-content')
	<div class="row">
		
		@include('layouts.partials.searchbox')

		<div class="col-md-9">

			<div class="row products">

			@if(count($products) > 0)

				@include('layouts.partials.productlist')
				
				<div class="col-sm-12 panel">
					{!! $products->render() !!}
				</div>
			@else
				<h1>Tidak ada produk</h1>
			@endif

			</div>
		</div>
		
		@include('layouts.partials.sidebar')
		
	</div>
@endsection