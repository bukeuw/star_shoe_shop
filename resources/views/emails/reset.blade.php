@extends('layouts.mail')

@section('mail-content')
	<h1>Link Reset</h1>
	<p>Silahkan klik link ini untuk mereset password Anda: {{ url('password/reset/'.$token) }}</p>
@endsection