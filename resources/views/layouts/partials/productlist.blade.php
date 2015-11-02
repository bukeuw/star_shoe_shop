@foreach($products as $product)
	<div class="col-sm-4 col-md-3 product">
		<div class="thumbnail">
			<img src="{{ '/data/products/thumbnail/' . $product->img_name . '_thumb.jpg' }}" alt="{{ $product->name }}">
			<div class="caption">
				<p><b>{{ $product->name }}</b></p>
				<p>Harga: Rp. {{ $product->price }}</p>
				<p>{{ $product->description }}</p>
				<p>Stok: {{ $product->stock }} {{ ucfirst($product->unit) }}</p>
				
				@if($product->stock > 0)
					<p>
						<a href="/cart/addItem/{{ $product->id }}" class="btn btn-dark btn-block">
							<i class="fa fa-lg fa-cart-plus"></i> Add to Cart
						</a>
					</p>
				@else
					<p>
						<a href="/order/addItem/{{ $product->id }}" class="btn btn-warning btn-block">
							<i class="fa fa-lg fa-cart-plus"></i> Order
						</a>
					</p>
				@endif

			</div>
		</div>
	</div>
@endforeach