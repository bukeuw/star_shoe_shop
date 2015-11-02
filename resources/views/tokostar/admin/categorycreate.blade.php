@extends('layouts.adminpage')

@section('title', 'Daftar Produk')

@section('page-content')
	<form action="/admin/category" method="POST" enctype="multipart/form-data" class="form-horizontal" id="category-form" role="form">
			<div class="form-group">
				<legend>Tambah Kategori</legend>
			</div>

			{!! csrf_field() !!}

			@include('layouts.partials.errorlist')

			<div class="form-group">
				<label for="title" class="col-sm-2 control-label">Nama Produk</label>
				<div class="col-sm-5 col-md-3">
					<input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
				</div>
			</div>

			<div class="form-group">
				<label for="parent_category" class="col-sm-2 control-label">Kategori Induk</label>
				<div class="col-sm-4 col-md-3">
					<select name="parent_category" id="parent_category" class="form-control">
						<option value="0">Root</option>
						@if(count($categories) > 0)
							@foreach($categories as $category)
								<option value="{{ $category->id }}">{{ $category->title }}</option>
							@endforeach
						@endif
					</select>
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
		validateFormInput('#category-form');
	});
</script>
@endsection