@if(Session::has('message'))
	<script type="text/javascript">
		// wait 5 second than slide up
		$('div.alert').delay(5000).slideUp(300);
	</script>
@endif