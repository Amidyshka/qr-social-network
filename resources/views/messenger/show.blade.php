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
                    {!! Form::open(['route' => ['messages.addPicture', $thread->id], 'method' => 'POST', 'files' =>
                    true]) !!}

                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
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
    <div class="modal fade" id="addmusic" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add audio file</h4>
                </div>
                <div class="modal-body">

                    {!! Form::open(['route' => ['messages.addaudio', $thread->id], 'method' => 'POST', 'files' => true])
                    !!}

                    <input name="audio" type="file" required="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-flat">Save changes</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="box box-danger direct-chat direct-chat-danger">
        <div class="box-header with-border">
            <h3 class="box-title">{!! $thread->subject !!}</h3>

            <div class="box-tools pull-right">
                <span data-toggle="tooltip" title=" @include('messenger.unread-count') New Messages"
                      class='badge bg-red'> @include('messenger.unread-count')</span>

                <button class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">
                    <i class="fa fa-comments"></i></button>
                {{--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>--}}
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body" id="boxz">
            <!-- Conversations are loaded here -->
            <div class="hide" data-thread="{{$thread->id}}"></div>
            <div class="direct-chat-messages" data-thread="{{$thread->id}}" onload="refresh()">
                <!-- Message. Default to the left -->


            </div>
            <!-- /.direct-chat-msg -->
            <!-- Contacts are loaded here -->
            <div class="direct-chat-contacts">
                <ul class='contacts-list'>
                    <li>

                    </li>
                    <!-- End Contact Item -->
                </ul>
                <!-- /.contatcts-list -->
            </div>
            <!-- /.direct-chat-pane -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            {!! Form::open(['route' => ['messages.update', $thread->id], 'method' => 'PUT']) !!}
            <div class="input-group">
                <button type="button" class="btn btn-primary btn-flat" data-toggle="modal" data-target="#addpicture">
                    <span class="glyphicon glyphicon-picture"></span></button>
                <span> </span>
                <button type="button" class="btn btn-warning btn-flat" data-toggle="modal" data-target="#addmusic"><span
                            class="glyphicon glyphicon-music"></span></button>
                <span> </span>
                <button type="button" class="btn btn-primary btn-flat"><span
                            class="glyphicon glyphicon-tree-deciduous"></span></button>

                <textarea name="message" class="form-control" rows="3" required></textarea>

      <span class="input-group-btn">


        <button type="submit" class="btn btn-danger btn-lg btn-flat"><span class="glyphicon glyphicon-send"></span> Send
        </button>
                 {!! Form::close() !!}

      </span>
            </div>
        </div>
        <!-- /.box-footer-->
    </div><!--/.direct-chat -->

    @stop
    </div>