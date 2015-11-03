@extends('layouts.userpage')

@section('title', 'Home')

@section('page-content')
	<div class="row">

		<div class="col-md-12 page-header">
			<h1>Profile Member</h1>
		</div>

		<div class="col-md-9">
			<div class="panel panel-dark">
				<div class="panel-heading">
					<h3 class="panel-title">Profile Member</h3>
				</div>
				<div class="panel-body">
					<form action="{{ $submitTo }}" method="POST">

						@include('layouts.partials.errorlist')

						{!! csrf_field() !!}
						
						@include('layouts.partials.profilefield')

					</form>
				</div>
			</div>
		</div>
		
		@include('layouts.partials.sidebar')

	</div>
@endsection