@extends('layouts.master')

@section('title', 'Login')

@section('content')
	<div class="container form-container row">
		<div class="col-xs-12 col-sm-5 col-sm-offset-4">
			<div class="panel panel-dark">
				<div class="panel-heading">
					<h3 class="panel-title">Member Login</h3>
				</div>
				<div class="panel-body">
					<form action="/login" method="POST" class="form-horizontal" id="login-form" role="form">
						{!! csrf_field() !!}				
						
						@include('layouts.partials.errorlist')

						<div class="form-group">
							<label for="email" class="control-label col-sm-2">E-Mail</label>
							<div class="col-sm-10">
								<input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label for="password" class="control-label col-sm-2">Password</label>
							<div class="col-sm-10">
								<input type="password" class="form-control" id="password" name="password">
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-10 col-sm-offset-2">
								<p class="help-block">
									Tidak punya akun? <a href="/register">Daftar</a>
								</p>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-10 col-sm-offset-2">
								<div id="g-recaptcha" class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-2 col-sm-offset-2">
								<button type="submit" class="btn btn-primary">Login</button>
							</div>
							<div class="col-sm-8">
								<p class="help-block">
									Lupa Password? <a href="/password/reset">Reset Password</a>
								</p>
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
	<script src="/assets/js/app.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			validateFormInput('#login-form');
		});
	</script>
@endsection