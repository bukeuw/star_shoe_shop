@extends('layouts.master')

@section('content')
	<!-- page navbar -->
	<header class="navbar navbar-static-top tkstar-nav" id="top">
		<div class="container">
			<div class="navbar-header">
				<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#tkstar-navbar" aria-controls="tkstar-navbar" aria-expanded="false">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="/" class="navbar-brand">
					<img src="/assets/img/logo tokostar.png" alt="logo toko star">
				</a>
			</div>
			<nav class="collapse navbar-collapse" id="tkstar-navbar">
				<ul class="nav navbar-nav">
					<li>
						<a href="/product">Produk</a>
					</li>
					<li>
						<a href="/contact">Kontak</a>
					</li>
					<li>
						<a href="/about">Tentang Kami</a>
					</li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
				@if (Auth::check())
					<li>
						<a href="/cart"
							data-toggle="tooltip"
							data-placement="bottom"
							title="{{ Auth::user()->cart ? count(Auth::user()->cart->cartItems) : '0' }} item dalam keranjang"
						>
							<i class="fa fa-shopping-cart fa-lg hidden-xs"></i>
							<span class="visible-xs">Keranjang Belanja</span>
						</a>
					</li>
					<li class="dropdown tkstar-dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							{{ Auth::user()->name }} <span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li>
								<a href="/member/profile">Profile</a>
							</li>
							<li>
								<a href="/order">Lihat Daftar Pemesanan</a>
							</li>
							<li>
								<a href="/member/transaction">Lihat Daftar Transaksi</a>
							</li>
							<li class="divider" role="separator"></li>
							<li>
								<a href="/logout">Logout</a>
							</li>
						</ul>
					</li>
				@else
					<li>
						<a href="/login">Login</a>
					</li>
					<li>
						<a href="/register">Daftar</a>
					</li>
				@endif
				</ul>
			</nav>
		</div>
	</header>

	<div class="container tkstar-container">
		@yield('page-content')
	</div>

	@include('layouts.partials.pagefooter')

@endsection