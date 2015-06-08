@extends('app')

@section('content')
    @if (Session::has('error_message'))
        <div class="alert alert-danger" role="alert">
            {!! Session::get('error_message') !!}
        </div>
    @endif
    @if($threads->count() > 0)
        @foreach($threads as $thread)

            <div class="box box-default collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?php $class = $thread->isUnread($currentUserId) ? 'alert-info' : ''; ?>
                        {!! link_to('messages/' . $thread->id, $thread->subject) !!}</h3>
                    <div class="box-tools pull-right">
                        <span class="label label-primary">{!! $thread->participantsString(Auth::id()) !!}</span>
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                    </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                    {!! $thread->latestMessage->body !!}
                </div><!-- /.box-body -->
            </div><!-- /.box -->


        @endforeach
    @else
        <p>Sorry, no threads.</p>
    @endif
@stop