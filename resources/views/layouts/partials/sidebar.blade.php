<div class="col-md-3">
	<div class="panel panel-dark">
		<div class="panel-heading">
			<h3 class="panel-title">Kategory</h3>
		</div>
		@if(count($categories) > 0)

			@foreach($categories as $category)
				<div class="list-group">
					<div>
					@if($category->parent_id == 0)
						<a class="list-group-item"
							href="#category{{ $category->id }}"
							data-toggle="collapse" 
							data-targe="#category{{ $category->id }}">
							{{ $category->title }}
						</a>
						{{-- TODO: fix replace this nested looping with something better --}}
						<ul class="collapse in" id="category{{ $category->id }}">
						@foreach($categories as $child_category)
							@if($child_category->parent_id == $category->id)
								<li>
									<a href="/category/{{ $child_category->title }}">{{ $child_category->title }}</a>
								</li>
							@endif
						@endforeach
						</ul>
					@endif
					</div>
				</div>
			@endforeach

		@else
			Tidak ada kategori
		@endif
	</div>

	<div class="panel panel-dark partner">
		<div class="panel-heading">
			<h3 class="panel-title">Metode Pembayaran</h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-4 col-xs-6">
					<img src="/assets/img/BCA-logo.png" alt="BCA" class="img-responsive">
				</div>
				<div class="col-sm-4 col-xs-6">
					<img src="/assets/img/BRI-logo.png" alt="BRI" class="img-responsive">
				</div>
				<div class="col-sm-4 col-xs-6">
					<img src="/assets/img/BNI-logo.png" alt="BNI" class="img-responsive">
				</div>
				<div class="col-sm-4 col-xs-6">
					<img src="/assets/img/Mastercard-logo.png" alt="MasterCard" class="img-responsive">
				</div>
				<div class="col-sm-4 col-xs-6">
					<img src="/assets/img/Visa-logo.png" alt="Visa" class="img-responsive">
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-dark partner">
		<div class="panel-heading">
			<h3 class="panel-title">Jasa Pengiriman</h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-4 col-xs-6">
					<a href="http://tiki-online.com"><img src="/assets/img/Tiki-logo.png" alt="Tiki" class="img-responsive"></a>
				</div>
				<div class="col-sm-4 col-xs-6">
					<a href="http://www.jne.co.id"><img src="/assets/img/JNE-logo.png" alt="JNE" class="img-responsive"></a>
				</div>
				<div class="col-sm-4 col-xs-6">
					<a href="http://www.posindonesia.co.id"><img src="/assets/img/pos-indonesia-logo.png" alt="Post Indonesia" class="img-responsive"></a>
				</div>
			</div>
		</div>
	</div>
</div>