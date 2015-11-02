@extends('layouts.adminpage')

@section('title', 'Daftar Produk')

@section('page-content')
	<form action="/admin/product" method="POST" enctype="multipart/form-data" class="form-horizontal" id="product-form" role="form">
			<div class="form-group">
				<legend>Tambah Produk</legend>
			</div>

			{!! csrf_field() !!}

			@include('layouts.partials.errorlist')

			<div class="form-group">
				<label for="name" class="col-sm-2 control-label">Nama Produk</label>
				<div class="col-sm-5 col-md-3">
					<input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
				</div>
			</div>

			<div class="form-group">
				<label for="description" class="col-sm-2 control-label">Keterangan</label>
				<div class="col-sm-10 col-md-6">
					<textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
				</div>
			</div>

			<div class="form-group">
				<label for="stock" class="col-sm-2 control-label">Stok</label>
				<div class="col-sm-4 col-md-3">
					<input type="number" class="form-control" id="stock" name="stock" min="0" value="{{ old('stock') }}">
				</div>
			</div>

			<div class="form-group">
				<label for="unit" class="col-sm-2 control-label">Satuan</label>
				<div class="col-sm-4 col-md-3">
					<select name="unit" id="unit" class="form-control">
						<option value="lusin">Lusin</option>
						<option value="kodi">Kodi</option>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label for="price" class="col-sm-2 control-label">Harga</label>
				<div class="col-sm-4 col-md-3">
					<input type="number" class="form-control" id="price" name="price" min="0" value="{{ old('price') }}">
				</div>
			</div>

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
<script type="text/javascript">
	$(document).ready(function() {
		validateFormInput('#product-form');
	});
</script>
@endsection