@extends('layouts.mail')

@section('mail-content')
	<h1>Link Reset</h1>
	<p>Silahkan klik link ini untuk mereset password Anda: <a href="{{ url('password/reset/'.$token) }}">{{ url('password/reset/'.$token) }}</a></p>
@endsection