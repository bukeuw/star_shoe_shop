@extends('layouts.adminpage')

@section('title', 'message list')

@section('page-content')
	<h1 class="content-header">Daftar Pesan</h1>
	@foreach($messages as $message)
		<div class="panel panel-dark">
			<div class="panel-heading">
				<h3 class="panel-title">Pesan</h3>
			</div>
			<div class="panel-body">
				<p class="form-control">Dari : {{ $message->name }} &lt;{{ $message->email }}&gt;</p>
				<p class="form-control">Telp : {{ $message->phone }}</p>
				<p class="form-control">{{ $message->message }}</p>
			</div>
		</div>
	@endforeach
	<div>
		{!! $messages->render() !!}
	</div>
@endsection