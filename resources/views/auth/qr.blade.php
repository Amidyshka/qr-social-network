<div class="panel panel-info "
     style="background-image: url('data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(300)->generate('or user qr code to login')) }} '); background-size: 23%; ">
<form class="form-horizontal" id="qr_login" role="form" method="POST" action="{{ url('/qr') }}">

    <div class="center-block" id="reader" style="width:370px;height:320px">
    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
        <input type="hidden" id="read" name="qr">

</div>
</form>
</div>