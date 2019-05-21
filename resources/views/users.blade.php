@extends('layout')
@section('title', 'Users')

@section('main')

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<div class="row">
    <div class="col-sm">
        <a href="/users/new" class="btn btn-primary" style="margin-top: 1em;"><i class="fas fa-user-plus"></i> New user</a>
        <table class="table user-list table-bordered">
            
            @foreach ($users as $user)
                <tr>
                    <td>
                        <img class="user-item__avatar-sm" src="{{$user->Avatar ? $user->Avatar : '/img/default-avt.png'}}">
                    </td>
                    <td>
                        <a href="/users/{{$user->UserID}}"><span class="user-item__fullname">{{ $user->FullName }}</span></a>
                    </td>
                    <td>
                        <span class="user-item__username">{{ $user->Username }}</span>
                    </td>
                    <td class="user-item__actions">
                        <a href="/users/edit/{{$user->UserID}}" class="item-action action-edit" ><i class="fas fa-pen-alt"></i></a>
                        <a href="/users/delete/{{$user->UserID}}/{{$user->Username}}" class="item-action action-trash"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </li>
            @endforeach
        </table>
    </div>
</div>

@endsection