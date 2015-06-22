@extends('app')

@section('content')
    <div class="modal fade" id="addpicture" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add picture</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(['route' => ['user.addPicture'], 'method' => 'POST', 'files' => true]) !!}

                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
                    <label for="des">Description</label>
                    <input type="text" id="des" name="descrition" class="input-group input-lg" required>
                    <br>
                    <input name="pic" type="file" required="">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-flat">Save changes</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="pad">
        <div class="row">
            <div class="col-md-3 col-md-offset-0">
                <div class="panel panel-info" style="text-align: center;padding: 20px">

                    <div class="panel panel-body panel-info " style="padding: 0">
                        <img src="{{Auth::user()->photo}}" alt="Auth::user()->name.' '.Auth::user()->s_name"
                             width="100%">
                        {{--<span>  {{Auth::user()->information}}</span>--}}
                    </div>
                    <span style="font-size: 15px;">{{Auth::user()->name.' '.Auth::user()->s_name}}</span>
                </div>
            </div>
            <div class="col-md-5 ">
                <div class="panel panel-primary">

                    <div class="panel-heading">
                        <a type="button" class="label label-success" data-toggle="collapse" data-target="#add"> <i
                                    class="glyphicon-plus"> </i>add new post</a>

                    </div>

                    <div class="panel-body collapse" id="add">
                        <form class="form form-horizontal" method="post" action="{{url('user/post')}}">
                            <textarea name="text" class="cke_dialog_ui_input_textarea input-lg form-horizontal"
                                      style="max-width: 100% ; width:100%" placeholder="message"></textarea>
                            <br>
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
                            <button class="btn btn-primary" type="submit">post</button>
                        </form>
                    </div>

                </div>

                @foreach ($posts as $post)

                    <div class="panel panel-default">

                        <div class="panel-heading">
                            {{$post->created_at}}
                            <a href='/del/post/{{$post->id}}' onclick='return confirm(msg)'>delete</a>
                        </div>

                        <div class="panel-body">
                            {{$post->content}}
                        </div>

                    </div>
                @endforeach
            </div>
            <div class="col-md-4">
                <div class="panel panel-success">
                    <div class="panel-heading">Photos <a type="button" class="label label-sm label-success"
                                                         data-toggle="modal" data-target="#addpicture">+</a></div>
                    <div class="panel-body">
                        <div class="center-block" style="text-align: center">
                            <script>var msg = 'Are you sure delete?';</script>
                            @foreach ($photos as $photo)

                                <a href="{{$photo->link}}" class="btn btn-lg btn-{{$array[rand(0,3)]}} btn-flat"
                                   data-toggle="lightbox" data-gallery="user"
                                   data-title="{{$photo->description}} <a href='/del/photo/{{$photo->id}}' onclick='return confirm(msg)'>delete</a>"
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
