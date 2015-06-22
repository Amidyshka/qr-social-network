@foreach($thread->messages as $message)
    <div class="direct-chat-msg">
        <div class='direct-chat-info clearfix'>
            <span class='direct-chat-name pull-left'>{!! $message->user->name !!} {!! $message->user->s_name !!} </span>
                        <span class='direct-chat-timestamp pull-right'>
                            {!! $message->created_at->diffForHumans() !!} (<i>{!! $message->created_at !!}</i>) <a
                                    href="del/{!! $message->id !!}" class="label label-sm label-default"
                                    onclick="return confirm('Are you sure delete message?')">x</a> </span>
        </div>
        <!-- /.direct-chat-info -->
        <img class="direct-chat-img" src="{!! $message->user->photo !!}"
             alt="{!! $message->user->name !!}"/><!-- /.direct-chat-img -->
        <div class="direct-chat-text" data-linkify="this">
            {!! $message->body !!}
        </div>
        <!-- /.direct-chat-text -->
    </div>
@endforeach