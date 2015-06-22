@extends('app')

@section('content')

    <div class="pad">
        <div class="row">
            <div class="col-md-3 col-md-offset-0">
                <div class="panel panel-info" style="text-align: center;padding: 20px">

                    <div class="panel panel-body panel-info " style="padding: 0">
                        <img src="{{$user->photo}}" alt="$user->name.' '.$user->s_name"
                             width="100%">
                        {{--<span>  {{$user->information}}</span>--}}
                    </div>
                    <span style="font-size: 15px;">{{$user->name.' '.$user->s_name}}</span>
                </div>
            </div>
            <div class="col-md-5 ">


                @foreach ($posts as $post)

                    <div class="panel panel-default">

                        <div class="panel-heading">
                            {{$post->created_at}}

                        </div>

                        <div class="panel-body">
                            {{$post->content}}
                        </div>

                    </div>
                @endforeach
            </div>
            <div class="col-md-4">
                <div class="panel panel-success">
                    <div class="panel-heading">Photos</div>
                    <div class="panel-body">
                        <div class="center-block" style="text-align: center">
                            <script>var msg = 'Are you sure delete?';</script>
                            @foreach ($photos as $photo)

                                <a href="{{$photo->link}}" class="btn btn-lg btn-{{$array[rand(0,3)]}} btn-flat"
                                   data-toggle="lightbox" data-gallery="user" data-title="{{$photo->description}}"
                                   style="font-size: 20px">

                                    <img src="{{$photo->link}}" width="130px">

                                </a>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    </div>
@endsection
