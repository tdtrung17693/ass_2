
@extends('layout')


@section('title', 'Messenger')
@section('body-class')
class="full-height"
@endsection
@section('isFluid', '1')
@section('main')

<div class="row">
    <div class="col-sm-2 all-msg-boxes">
        @foreach ($MsgBoxes as $box)
            <div class="box-item{{ $box->BoxID == $CurrentBoxID ? ' active-item' : '' }}">
                <a href="/messenger/{{$box->BoxID}}">{{$box->BoxName}}</a>
            </div>
        @endforeach
    </div>
    <div class="col-sm-8 msg-pool">
        <?php $prev = 0; ?>
        @foreach ($Current as $message)
            <div class="message {{$message->UserID == 1 ? 'message-right' : ''}}">
            @if ($prev != $message->UserID) 
                <div class="sender-avatar">
                    <img src="{{$message->Avatar}}" class="sender-avt-sm">
                </div>
            @endif
                <div class="message-content">
                    @if ($prev != $message->UserID)
                    <div class="sender-name">{{ $message->Username }}</div>

                    <?php $prev = $message->UserID; ?>
                    @endif
                    <div class="content">{{$message->MessageContent}}</div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="col-sm-2 msg-box-info">
        <span>Members</span>
        <div class="box-members">
            @foreach ($Members as $Mb)
                <a href="/messenger/{{$CurrentBoxID}}/mb/{{$Mb->UserID}}" class="box-members__member">
                    <div class="sender-avatar">
                        <img src="{{$Mb->Avatar}}" class="sender-avt-sm"/>
                    </div>
                    <span class="member-name">{{$Mb->Username}}</span>
                </a>
            @endforeach
        </div>
    </div>
</div>

@endsection