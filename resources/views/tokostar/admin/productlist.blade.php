@extends('layouts.adminpage')

@section('title', 'Daftar Produk')

@section('page-content')

	@include('layouts.partials.messagebag')

	<h1 class="content-header">Produk</h1>
	@if (count($products) > 0)
		<a href="/admin/product/create" class="btn btn-primary">
			<i class="fa fa-plus"></i> Tambah Produk
		</a>
		<table class="table table-hover table-responsive">
			<thead>
				<tr>
					<th>Nama</th>
					<th>Keterangan</th>
					<th>Stok</th>
					<th>Satuan</th>
					<th>Harga</th>
					<th colspan="2">Action</th>
				</tr>
			</thead>
			<tbody>
			@foreach ($products as $product)
				<tr>
					{{-- <td><img src="{{ '/data/products/thumbnail/' . $product->img_name . '_thumb.jpg' }}" alt="{{ $product->name }}"></td> --}}
					<td>{{ $product->name }}</td>
					<td>{{ $product->description }}</td>
					<td>{{ $product->stock }}</td>
					<td>{{ $product->unit }}</td>
					<td>Rp. {{ $product->price }}</td>
					<td colspan="2">
						<a href="/admin/product/{{ $product->id }}/edit" class="btn btn-primary">
							<i class="fa fa-pencil"></i> Edit
						</a>
						<button class="btn btn-danger" type="button" data-toggle="modal" data-target="#confirmModal{{ $product->id }}">
							<i class="fa fa-remove"></i> Hapus
						</button>

						@include('layouts.partials.confirmmodal', [
									'id' => $product->id,
									'url' => '/admin/product/' . $product->id,
									'type' => 'produk', 'name' => $product->name])
					</td>
				</tr>
			@endforeach
			</tbody>
			<tfoot>
				<td>{!! $products->render() !!}</td>
			</tfoot>
		</table>
	@else
		<p>
			Tidak ada produk, silahkan <a href="/admin/product/create"><i class="fa fa-plus"></i> tambah produk</a>
		</p>
	@endif
@endsection

@section('custom-js')
	@include('layouts.partials.messagebagscript')
@endsection