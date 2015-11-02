@extends('layouts.userpage')

@section('title', 'Hubungi Kami')

@section('page-content')
	<div class="col-sm-12 page-header">
		<h1>Hubungi Kami</h1>
	</div>
	<div class="col-md-9">

		@include('layouts.partials.errorlist')

		@include('layouts.partials.messagebag')

		<form action="/contact" method="POST" role="form">

			{!! csrf_field() !!}

			<div class="form-group">
				<label for="name">Nama Lengkap</label>
				<input type="text" class="form-control" id="name" placeholder="Masukan nama lengkap Anda" >
			</div>

			<div class="form-group">
				<label for="phone">No Telepon/Hp</label>
				<input type="text" class="form-control" id="phone" placeholder="Masukan no telepon/hp Anda" >
			</div>
		
			<div class="form-group">
				<label for="email">Email</label>
				<input type="email" class="form-control" id="email" placeholder="Masukan email Anda">
			</div>

			<div class="form-group">
				<label for="message">Pesan</label>
				<textarea class="form-control" name="message" id="message" cols="30" rows="10" placeholder="Masukan pesan anda"></textarea>
			</div>

			<div class="form-group">
				<button type="submit" class="btn btn-primary">Kirim Pesan</button>
			</div>
		</form>
	</div>

	@include('layouts.partials.sidebar')
@endsection