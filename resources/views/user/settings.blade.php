@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">Edit profile</div>
                    <div class="panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data"
                              action="{{url('/user/update')}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-md-4 control-label">First Name</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" value="{{ $user->name}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Second Name</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="s_name" value="{{ $user->s_name}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" value="{{ $user->email}}"
                                           disabled>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">About</label>

                                <div class="col-md-6">
                                    <textarea class="form-control" name="info">{{ $user->information}}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Confirm Password</label>

                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password_confirmation">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Chose avatar</label>

                                <div class="col-md-6 ">
                                    {!! Form::file('pic', null) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Update
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading"> You QR code for auth</div>
                    <div class="panel-body">


                        <br>
                        <a href="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(400)->generate(Auth::user()->password)) }} "
                           download="QR">
                            Download QR <img
                                    src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(400)->generate(Auth::user()->password)) }} ">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@stop