@extends('layouts.master')

@section('title', 'Login')

@section('content')
	<div class="container form-container row">
		<div class="col-xs-12 col-sm-5 col-sm-offset-4">
			<div class="panel panel-dark">
				<div class="panel-heading">
					<h3 class="panel-title">Reset Password</h3>
				</div>
				<div class="panel-body">
					<form action="/password/reset" method="POST" class="form-horizontal" id="register-form" role="form">
						{!! csrf_field() !!}

						@include('layouts.partials.errorlist')

						<input type="hidden" name="token" value="{{ $token }}">

						<div class="form-group">
							<label for="email" class="control-label col-sm-2">E-Mail</label>
							<div class="col-sm-10">
								<input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label for="password" class="control-label col-sm-2">Password Baru</label>
							<div class="col-sm-10">
								<input type="password" class="form-control" id="password" name="password">
							</div>
						</div>
						
						<div class="form-group">
							<label for="password_confirmation" class="control-label col-sm-2">Konfirmasi Password</label>
							<div class="col-sm-10">
								<input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-10 col-sm-offset-2">
								<button type="submit" class="btn btn-primary">Reset Password</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('custom-js')
	<script src="/assets/js/jquery.validate-1.14.1.min.js"></script>
	<script src="/assets/js/app.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			validateFormInput('#register-form');
		});
	</script>
@endsection