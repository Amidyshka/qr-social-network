<form class="form-horizontal" id="qr_login" role="form" method="POST" action="{{ url('/qr') }}">
<div id="reader" style="width:300px;height:250px">
    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
        <input type="hidden" id="read" name="qr">

</div>
</form>