@extends('layouts.adminpage')

@section('title', 'Daftar Produk')

@section('page-content')
	<h1 class="content-header">Kategori Produk</h1>
	@if (count($categories) > 0)
		<a href="/admin/category/create" class="btn btn-primary">
			<i class="fa fa-plus"></i> Tambah Kategori Produk
		</a>
		<table class="table table-hover table-responsive">
			<thead>
				<tr>
					<td>Judul Kategori</td>
					<td>Keterangan</td>
					<td>Kategori Induk</td>
					<td>Action</td>
				</tr>
			</thead>
			<tbody>
			@foreach ($categories as $category)
				<tr>
					<td>{{ $category->title }}</td>
					<td>{{ $category->parent_id }}</td>
					<td>
						<a href="/admin/category/{{ $category->id }}/edit" class="btn btn-primary">
							<i class="fa fa-pencil"></i>
						</a>
						<form action="/admin/category/{{ $category->id }}">
							{!! csrf_field() !!}
							{!! method_field('DELETE') !!}
							<button class="btn btn-danger" type="submit">
								<i class="fa fa-delete"></i>
							</button>
						</form>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	@else
		<p>
			Tidak ada produk, silahkan <a href="/admin/category/create"><i class="fa fa-plus"></i> tambah Kategori produk</a>
		</p>
	@endif
@endsection