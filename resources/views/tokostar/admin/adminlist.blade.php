@extends('layouts.adminpage')

@section('title', 'Daftar Admin')

@section('page-content')

	@include('layouts.partials.messagebag')

	<h1 class="content-header">Daftar Admin</h1>
	@if (count($admins) > 0)
		<a href="/admin/add" class="btn btn-primary">
			<i class="fa fa-plus"></i> Tambah Admin
		</a>
		<table class="table table-hover table-responsive">
			<thead>
				<tr>
					<th>Nama</th>
					<th>Email</th>
					<th colspan="2">Action</th>
				</tr>
			</thead>
			<tbody>
			@foreach ($admins as $admin)
				<tr>
					<td>{{ $admin->name }}</td>
					<td>{{ $admin->email }}</td>
					<td colspan="2">
						<a href="/admin/{{ $admin->id }}/edit" class="btn btn-primary">
							<i class="fa fa-pencil"></i> Edit
						</a>
						@if(Auth::user()->id != $admin->id)
						<button class="btn btn-danger" type="button" data-toggle="modal" data-target="#confirmModal{{ $admin->id }}">
							<i class="fa fa-remove"></i> Hapus
						</button>

							@include('layouts.partials.confirmmodal', [
										'id' => $admin->id,
										'url' => '/admin/' . $admin->id,
										'type' => 'admin', 'name' => $admin->name])
						@endif

					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	@endif
@endsection

@section('custom-js')
	@include('layouts.partials.messagebagscript')
@endsection