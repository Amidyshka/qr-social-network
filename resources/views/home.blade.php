@extends('app')

@section('content')
<div class="pad">
	<div class="row">
		<div class="col-md-2 col-md-offset-0">
			<div class="panel panel-default">

				<div class="panel-body">
					<img src="{{Auth::user()->photo}}" width="100%">
					<span><i class="glyphicon-barcode">:</i> {{Auth::user()->information}} </span>
				</div>

			</div>
			</div>
		<div class="col-md-8 ">
			<div class="panel panel-default">
				<div class="panel-heading">{{Auth::user()->name.' '.Auth::user()->s_name}}</div>

				<div class="panel-body">




					You are logged in!
					You QR code for auth
					<a href="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(400)->generate(Auth::user()->password)) }} " download="QR">
						Download QR
					</a>

				</div>

			</div>

			</div>

		</div>
	</div>
</div>
@endsection
