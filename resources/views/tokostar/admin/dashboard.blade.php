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
		background-color: #fff;
	}

	.chart-placeholder {
		width: 100%;
		height: 100%;
		font-size: 14px;
		line-height: 1.2em;
	}
	#chart-tooltip {
		position: absolute;
		display: none;
		border: 1px solid #1976d2;
		padding: 3px;
		color: #fff;
		background-color: #1976d2;
		opacity: 0.90;
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
<!--[if lte IE 8]><script src="/assets/js/flot/excanvas.min.js"></script><![endif]-->
<script src="/assets/js/flot/jquery.flot.js"></script>
<script src="/assets/js/flot/jquery.flot.categories.js"></script>
<script src="/assets/js/flot/jquery.flot.canvas.js"></script>
<script type="text/javascript">
	function getMonthName(id) {
		switch(id) {
			case 0:
				return "Januari";
				break;
			case 1:
				return "Februari";
				break;
			case 2:
				return "Maret";
				break;
			case 3:
				return "April";
				break;
			case 4:
				return "Mei";
				break;
			case 5:
				return "Juni";
				break;
			case 6:
				return "Juli";
				break;
			case 7:
				return "Agustus";
				break;
			case 8:
				return "September";
				break;
			case 9:
				return "Oktober";
				break;
			case 10:
				return "November";
				break;
			case 11:
				return "Desember";
				break;
		}
	}

	$(function() {

		var balance = [
		@foreach($chartData as $month => $data)
			[
				"{{ $month }}",
				{{ $data }},
			],
		@endforeach
		];

		var plot = $.plot("#placeholder", [{
			data: balance,
			label: "Pendapatan"
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
				max: 10000000
			},
			xaxis: {
				mode: "categories",
				tickLength: 0
			}
		});

		$("<div id='chart-tooltip'></div>").appendTo("body");

		$("#placeholder")
			.bind("plothover", function(event, pos, item) {

				if (item) {
					var x = item.datapoint[0],
						y = item.datapoint[1];

					$("#chart-tooltip")
						.html(item.series.label + " bulan " + getMonthName(x) + " : Rp. " + y)
						.css({
							top: item.pageY + 5,
							left: item.pageX + 5
						})
						.fadeIn(200);
				} else {
					$("#chart-tooltip")
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