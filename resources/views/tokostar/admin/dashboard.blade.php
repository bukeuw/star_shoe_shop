@extends('layouts.adminpage')

@section('title', 'dashboard')

@section('page-content')
	<h1 class="content-header">Dasboard</h1>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Account Detail</h3>
		</div>
		<div class="panel-body">
			<table class="table table-responsive table-hover">
				<thead>
					<tr>
						<th>Display Name</th>
						<th>Email</th>
						<th>Balance Avaiable</th>
						<th>Balance Pending</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							{{ $account->display_name }}
						</td>
						<td>
							{{ $account->email }}
						</td>
						<td>
							{{ $balance->available[0]->amount . ' ' . $balance->available[0]->currency }}
						</td>
						<td>
							{{ $balance->pending[0]->amount . ' ' . $balance->pending[0]->currency }}
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
@endsection