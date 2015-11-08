@extends('layouts.adminpage')

@section('title', 'dashboard')

@section('custom-css')
<style>
	.chart-container {
		box-sizing: border-box;
		width: 100%;
		height: 450px;
		padding: 20px 15px 15px 15px;
		margin: 15px auto 30px auto;
		border: 1px solid #ddd;
		background: #fff;
		background: linear-gradient(#f6f6f6 0, #fff 50px);
		background: -o-linear-gradient(#f6f6f6 0, #fff 50px);
		background: -ms-linear-gradient(#f6f6f6 0, #fff 50px);
		background: -moz-linear-gradient(#f6f6f6 0, #fff 50px);
		background: -webkit-linear-gradient(#f6f6f6 0, #fff 50px);
		box-shadow: 0 3px 10px rgba(0,0,0,0.15);
		-o-box-shadow: 0 3px 10px rgba(0,0,0,0.1);
		-ms-box-shadow: 0 3px 10px rgba(0,0,0,0.1);
		-moz-box-shadow: 0 3px 10px rgba(0,0,0,0.1);
		-webkit-box-shadow: 0 3px 10px rgba(0,0,0,0.1);
	}

	.chart-placeholder {
		width: 100%;
		height: 100%;
		font-size: 14px;
		line-height: 1.2em;
	}
</style>
@endsection

@section('page-content')
	<h1 class="content-header">Dasboard</h1>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Data Penjualan</h3>
		</div>
		<div class="panel-body">
			<div class="chart-container">
				<div id="placeholder" class="chart-placeholder"></div>
			</div>
		</div>
	</div>
@endsection

@section('custom-js')
<script src="/assets/js/jquery-1.11.3.min.js"></script>
<script src="/assets/js/flot/jquery.flot.js"></script>
<script type="text/javascript">
	$(function() {

		var balance = [
		@foreach($transactions as $transaction)
			[
				{{ $transaction->total }},
				"{{ $transaction->created_at->format('j M F') }}"
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
				min: 0,
				max: {{ $transactions->max('total') }}
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