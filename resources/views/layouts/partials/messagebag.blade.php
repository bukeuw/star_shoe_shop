@if(Session::has('message'))
	<div class="alert alert-info flash-msg">
		<p><i class="fa fa-check"></i> {{ Session::get('message') }}</p>
	</div>
@endif