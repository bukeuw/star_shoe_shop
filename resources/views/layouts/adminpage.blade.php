@extends('layouts.master')

@section('content')
	<!-- page navbar -->
	<header class="navbar navbar-static-top tkstar-nav" id="top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#tkstar-navbar" aria-controls="tkstar-navbar" aria-expanded="false">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="/" class="navbar-brand">Toko Star</a>
			</div>
			<nav class="collapse navbar-collapse" id="tkstar-navbar">
				<ul class="nav navbar-nav">
					<li>
						<a href="/admin">Beranda</a>
					</li>
					<li class="visible-xs">
						<a href="/admin/product">Produk</a>
					</li>
					<li class="visible-xs">
						<a href="/admin/category">Kategori Produk</a>
					</li>
					<li class="visible-xs">
						<a href="/admin/messages">Messages</a>
					</li>
					<li class="visible-xs">
						<a href="/admin/order">Order List</a>
					</li>
					<li class="visible-xs">
						<a href="/admin/invoice">Invoice</a>
					</li>
					<li class="visible-xs">
						<a href="/admin/manage">Kelola Admin</a>
					</li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					@if(Auth::check())
					<li class="dropdown tkstar-dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							{{ Auth::user()->name }} <span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<!-- <li class="divider" role="separator"></li> -->
							<li>
								<a href="/admin/logout">Logout</a>
							</li>
						</ul>
					</li>
					@endif
				</ul>
			</nav>
		</div>
	</header>

	<div class="container-fluid tkstar-container">
		<div class="row">
			<div class="col-sm-3 col-md-2 tkstar-sidebar hidden-xs">
				<ul class="nav nav-sidebar">
					<li>
						<a href="/admin/product">
							<i class="fa fa-book"></i>
							Produk
						</a>
					</li>
					<li>
						<a href="/admin/category">
							<i class="fa fa-tags"></i>
							Kategory Produk
						</a>
					</li>
					<li>
						<a href="/admin/messages">
							<i class="fa fa-comments"></i>
							Daftar Pesan
						</a>
					</li>
					<li>
						<a href="/admin/order">
							<i class="fa fa-list"></i>
							Pesanan
						</a>
					</li>
					<li>
						<a href="/admin/invoice">
							<i class="fa fa-usd"></i>
							Invoice
						</a>
					</li>
					<li>
						<a href="/admin/manage">
							<i class="fa fa-users"></i>
							Kelola Admin
						</a>
					</li>
				</ul>
			</div>
			<div class="col-sm-9 col-md-10 col-sm-offset-3 col-md-offset-2 tkstar-admin-content">
				@yield('page-content')
			</div>
		</div>
	</div>
@endsection