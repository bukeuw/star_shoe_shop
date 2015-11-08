@extends('layouts.adminpage')

@section('title', 'dashboard')

@section('page-content')
	<h1 class="content-header">Dasboard</h1>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Data Penjualan</h3>
		</div>
		<div class="panel-body">
			<div id="placeholder" class="chart-placeholder"></div>
		</div>
	</div>
@endsection

@section('custom-js')
<script src="/assets/js/jquery.1.11.3.min.js"></script>
<script src="/assets/js/flot/jquery.flot.js"></script>
<script type="text/javascript">
	$(function() {

		var balance = [
		@foreach($transactions as $transaction)
			[
				'{{ $transaction->created_at->format() }}',
				{{ $transaction->total }}
			],
		@endforeach
		];

		var plot = $.plot("#placeholder", [{
			data: balance,
			label: "Penjualan"
		}], {
			series: {
				lines: {
					show: true
				},
				points: {
					show: true
				}
			},
			grid: {
				hoverable: true,
				clickable: true
			},
			yaxis: {
				min: -1.2,
				max: 1.2
			}
		});

		$("<div id='tooltip'></div>")
			.css({
				position: "absolute",
				display: "none",
				border: "1px solid #fdd",
				padding: "2px",
				"background-color": "#fee",
				opacity: 0.80
			})
			.appendTo("body");

		$("#placeholder")
			.bind("plothover", function(event, pos, item) {

				if (item) {
					var x = item.datapoint[0].toFixed(2),
						y = item.datapoint[1].toFixed(2);

					$("#tooltip")
						.html(item.series.label + " of " + x + " = " + y)
						.css({
							top: item.pageY + 5,
							left: item.pageX + 5
						})
						.fadeIn(200);
				} else {
					$("#tooltip")
						.hide();
				}
			});

		$("#placeholder")
			.bind("plotclick", function(event, pos, item) {
				if (item) {
					plot.highlight(item.series, item.datapoint);
				}
			});
	});
</script>
@endsection