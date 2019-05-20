
@extends('layout')
@section('title')
    {{ $user->Username }}
@endsection

@section('main')
    <div class="row user-profile">
        <div class="col-sm-2">
            <div class="card">
                <img src="{{$user->Avatar ? $user->Avatar : '/img/default-avt.png'}}" alt="" class="user-avt">
                <h3 class="user-fullname">{{$user->FirstName . " " . $user->LastName}}</h2>
                <span class="user-username">{{"@{$user->Username}"}}</span>
            </div>
        </div>
        <div class="col-sm-10">
            <div class="row">
                <div class="col-sm-12 owned-books">
                    <h2 class="section-title">Owned Books</h2>
                    <div class="owned-books-wrapper">
                        @if (count($OwnedBooks) == 0)
                            No book
                        @else
                            <ul class="book-list">
                            @foreach ($OwnedBooks as $book)
                                <li class="book-list__item">
                                    <img src="{{$book->BookCover}}" alt="" class="book-cover">
                                    <span class="book-title">{{$book->BookTitle}}</span>
                                </li>
                            @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
                <div class="col-sm-12 active-msg-boxes">
                    <h2 class="section-title">Message Boxes</h2>
                    <div class="filter-action">
                        <form action="/users/{{$user->UserID}}" method="get" class="form-inline">
                            <label for="filter" class="mr-sm-2">Show message boxes with the number of messages more than</label>
                            <input type="text" name="filter" id="filter" value={{$filter ?? 0}} class="form-control mr-sm-2">
                            @if (!is_null($filter))
                                <a href="/users/{{$user->UserID}}" class="btn btn-success">Show all</a> 
                            @endif
                        </form>
                    </div>
                    <div class="active-msg-boxes-wrapper">
                        @if (count($ActiveMsgBox) == 0)
                            No active message box
                        @else
                            <ul class="list-group">
                                @foreach ($ActiveMsgBox as $box)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="/messenger/{{$box->BoxID}}">{{ $box->BoxName }}</a>
                                    <span class="badge badge-primary badge-pill">{{ $box->NumberOfMessage }}</span>
                                </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
                <div class="col-sm-12 created-comms">
                    <h2 class="section-title">Created Communities</h2>
                    <div class="created-comms-wrapper">
                        @if (count($CreatedComms) == 0)
                            No community
                        @else
                            <ul class="list-group">
                                @foreach ($CreatedComms as $comm)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="#">{{ $comm->CommunityName }}</a>
                                </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
        </div>
    </div>
    
@endsection