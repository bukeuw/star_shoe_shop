@extends('layouts.master')

@section('title', 'Register')

@section('content')
	<div class="container form-container row">
		<div class="col-xs-12 col-sm-6 col-sm-offset-4">
			<div class="panel panel-dark">
				<div class="panel-heading">
					<h3 class="panel-title">Registrasi Member</h3>
				</div>
				<div class="panel-body">
					<form action="/register" method="POST" class="form-horizontal" id="register-form" role="form">
						{!! csrf_field() !!}

						@include('layouts.partials.errorlist')	
						
						<div class="form-group">
							<label for="name" class="control-label col-sm-2">Nama</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="name" name="name">
							</div>
						</div>

						<div class="form-group">
							<label for="email" class="control-label col-sm-2">E-Mail</label>
							<div class="col-sm-10">
								<input type="email" class="form-control" id="email" name="email">
							</div>
						</div>
						
						<div class="form-group">
							<label for="password" class="control-label col-sm-2">Password</label>
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
								<div id="g-recaptcha" class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-sm-10 col-sm-offset-2">
								<button type="submit" class="btn btn-primary">Register</button>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-sm-10 col-sm-offset-2">
								<span class="help-block">
									Sudah punya akun, <a href="/login">Login</a>
								</span>
							</div>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('custom-js')
	<script src="https://www.google.com/recaptcha/api.js?hl=id" async defer></script>
	<script src="/assets/js/jquery.validate-1.14.1.min.js"></script>
	<script src="/assets/js/forms-validation.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			validateFormInput('#register-form');
		});
	</script>
@endsection