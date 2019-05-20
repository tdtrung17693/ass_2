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
        <div class="msg-box-title">Messages from <span class="mb-name">{{$FullName}}</span> (<span class="mb-name">{{$Username}}</span>)</div>
        @foreach ($MbMessages as $message)
            <div class="message {{$message->UserID == 1 ? 'message-right' : ''}}">
                <div class="message-content">
                    <div class="content">{{$message->MessageContent}}</div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="col-sm-2 msg-box-info">
        <span>Members</span>
        <div class="box-members">
            @foreach ($Members as $Mb)
                <a href="/messenger/{{$CurrentBoxID}}/mb/{{$Mb->UserID}}" class="box-members__member {{$CurrentMbID == $Mb->UserID ? 'active-item' : ''}}">
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