@extends('layouts.adminpage')

@section('title', 'Update Admin')

@section('page-content')
	<form action="/admin" method="POST" class="form-horizontal" id="admin-form" role="form">
			<div class="form-group">
				<legend>Tambah Admin</legend>
			</div>

			{!! csrf_field() !!}

			@include('layouts.partials.errorlist')

			<div class="form-group">
				<label for="name" class="control-label col-sm-2">Nama</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="name" name="name" value="{{ $admin->name }}">
				</div>
			</div>

			<div class="form-group">
				<label for="email" class="control-label col-sm-2">E-Mail</label>
				<div class="col-sm-10">
					<input type="email" class="form-control" id="email" name="email" value="{{ $admin->name }}">
				</div>
			</div>
			
			<div class="form-group">
				<label for="password" class="control-label col-sm-2">Password*</label>
				<div class="col-sm-10">
					<input type="password" class="form-control" id="password" name="password">
				</div>
			</div>
			
			<div class="form-group">
				<label for="password_confirmation" class="control-label col-sm-2">Konfirmasi Password*</label>
				<div class="col-sm-10">
					<input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
				</div>
			</div>

			<div class="form-control">
				<span class="help-blok">
					note: * Kosongkan jika tidak ingin diubah
				</span>
			</div>

			<div class="form-group">
				<div class="col-sm-10 col-sm-offset-2">
					<button type="submit" class="btn btn-success">Update</button>
					<a href="/admin/manage" class="btn btn-warning">Batal</a>
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
		validateFormInput('#admin-form');
	});
</script>
@endsection