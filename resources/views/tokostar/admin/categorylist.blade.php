@extends('layouts.adminpage')

@section('title', 'Daftar Kategori')

@section('page-content')

	@include('layouts.partials.messagebag')

	<h1 class="content-header">Daftar Kategori Produk</h1>
	@if (count($categories) > 0)
		<a href="/admin/category/create" class="btn btn-primary">
			<i class="fa fa-plus"></i> Tambah Kategori Produk
		</a>
		<table class="table table-hover table-responsive">
			<thead>
				<tr>
					<th>ID Kategori</th>
					<th>Judul Kategori</th>
					<th>Kategori Induk</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
			@foreach ($categories as $category)
				<tr>
					<td>{{ $category->id }}</td>
					<td>{{ $category->title }}</td>
					<td>{{ $category->parent_id }}</td>
					<td>
						<a href="/admin/category/{{ $category->id }}/edit" class="btn btn-primary">
							<i class="fa fa-pencil"></i> Edit
						</a>

						<button class="btn btn-danger" type="button" data-toggle="modal" data-target="#confirmModal{{ $category->id }}">
							<i class="fa fa-remove"></i> Hapus
						</button>

						@include('layouts.partials.confirmmodal', [
									'id' => $category->id,
									'url' => '/admin/category/' . $category->id,
									'type' => 'kategori', 'name' => $category->title])

					</td>
				</tr>
			@endforeach
			</tbody>
			<tfoot>
				<tr>
					<td colspan="4">
						{!! $categories->render() !!}
					</td>
				</tr>
			</tfoot>
		</table>
	@else
		<p>
			Tidak ada kategori, silahkan <a href="/admin/category/create"><i class="fa fa-plus"></i> tambah Kategori produk</a>
		</p>
	@endif
@endsection

@section('custom-js')
	@include('layouts.partials.messagebagscript')
@endsection