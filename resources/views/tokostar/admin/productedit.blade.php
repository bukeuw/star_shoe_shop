@extends('layouts.adminpage')

@section('title', 'Edit Produk')

@section('custom-css')
	@include('layouts.partials.select2cdn')
@endsection

@section('page-content')
	<form action="/admin/product/{{ $product->id }}" method="POST" enctype="multipart/form-data" class="form-horizontal" id="product-form" role="form">
		
		<div class="form-group">
			<legend>Edit Produk</legend>
		</div>

		{!! csrf_field() !!}
		
		{!! method_field('PATCH') !!}

		@include('layouts.partials.errorlist')

		<div class="form-group">
			<label for="name" class="col-sm-2 control-label">Nama Produk</label>
			<div class="col-sm-5 col-md-3">
				<input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}">
			</div>
		</div>

		<div class="form-group">
			<label for="description" class="col-sm-2 control-label">Keterangan</label>
			<div class="col-sm-10 col-md-6">
				<textarea class="form-control" id="description" name="description">{{ $product->description }}</textarea>
			</div>
		</div>

		<div class="form-group">
			<label for="stock" class="col-sm-2 control-label">Stok</label>
			<div class="col-sm-4 col-md-3">
				<input type="number" class="form-control" id="stock" name="stock" min="0" value="{{ $product->stock }}">
			</div>
		</div>

		<div class="form-group">
			<label for="unit" class="col-sm-2 control-label">Satuan</label>
			<div class="col-sm-4 col-md-3">
				<select name="unit" id="unit" class="form-control">
					<option value="lusin" selected="{{ $product->unit == 'lusin' }}">Lusin</option>
					<option value="kodi" selected="{{ $product->unit == 'kodi' }}">Kodi</option>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label for="price" class="col-sm-2 control-label">Harga</label>
			<div class="col-sm-4 col-md-3">
				<input type="number" class="form-control" id="price" name="price" min="0" value="{{ $product->price }}">
			</div>
		</div>

		@include('layouts.partials.categoryselect')

		<div class="form-group">
			<label for="product_img" class="col-sm-2 control-label">Gambar</label>
			<div class="col-sm-10 col-md-6">
				<input type="file" class="form-control" id="product_img" name="product_img" accept="image/*">
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-10 col-sm-offset-2">
				<button type="submit" class="btn btn-success">Simpan</button>
				<a href="/admin/product" class="btn btn-warning">Batal</a>
			</div>
		</div>

	</form>
@endsection

@section('custom-js')
<script src="/assets/js/jquery.validate-1.14.1.min.js"></script>
<script src="/assets/js/forms-validation.js"></script>
<script src="/assets/js/app.js"></script>

@include('layouts.partials.categoryselectscript')

<script type="text/javascript">
	$(document).ready(function() {
		validateFormInput('#product-form');
	});
</script>
@endsection