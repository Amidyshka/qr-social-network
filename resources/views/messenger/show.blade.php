@extends('app')

@section('content')

    <div class="box box-danger direct-chat direct-chat-danger">
        <div class="box-header with-border">
            <h3 class="box-title">{!! $thread->subject !!}</h3>
            <div class="box-tools pull-right">
                <span data-toggle="tooltip" title=" @include('messenger.unread-count') New Messages" class='badge bg-red'> @include('messenger.unread-count')</span>

                <button class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle"><i class="fa fa-comments"></i></button>
                {{--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>--}}
            </div>
        </div><!-- /.box-header -->
        <div class="box-body">
            <!-- Conversations are loaded here -->
            <div class="direct-chat-messages">
                <!-- Message. Default to the left -->
                @foreach($thread->messages as $message)
                <div class="direct-chat-msg">
                    <div class='direct-chat-info clearfix'>
                        <span class='direct-chat-name pull-left'>{!! $message->user->name !!} {!! $message->user->s_name !!}</span>
                        <span class='direct-chat-timestamp pull-right'>{!! $message->created_at->diffForHumans() !!}</span>
                    </div><!-- /.direct-chat-info -->
                    <img class="direct-chat-img" src="{!! $message->user->photo !!}" alt="{!! $message->user->name !!}" /><!-- /.direct-chat-img -->
                    <div class="direct-chat-text">
                        {!! $message->body !!}
                    </div><!-- /.direct-chat-text -->
                    </div>
                    @endforeach

            </div><!-- /.direct-chat-msg -->
            <!-- Contacts are loaded here -->
            <div class="direct-chat-contacts">
                <ul class='contacts-list'>
                    <li>

                    </li><!-- End Contact Item -->
                </ul><!-- /.contatcts-list -->
            </div><!-- /.direct-chat-pane -->
        </div><!-- /.box-body -->
        <div class="box-footer">
            {!! Form::open(['route' => ['messages.update', $thread->id], 'method' => 'PUT']) !!}
            <div class="input-group">
                <input type="text" name="message" placeholder="Type Message ..." class="form-control"/>
      <span class="input-group-btn">

        <button type="submit" class="btn btn-danger btn-flat">Send</button>
                 {!! Form::close() !!}
      </span>
            </div>
        </div><!-- /.box-footer-->
    </div><!--/.direct-chat -->
@stop