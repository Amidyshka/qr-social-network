@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{$user->name}}</div>

                    <div class="panel-body">
                       Created in {{$user->created_at}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
