
@extends('layout')
@section('title')
    Edit user {{$Username}}
@endsection

@section('main')
    <div class="row page-title"><div class="col-sm"><h1>
        Edit user {{$Username}}
    </h1></div></div>

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
    <div class="row new-user-form">
        <form action="/users/{{$UserID}}" method="post">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
            <div class="form-group">
                <label for="userid">User ID</label>
                <input type="text" name="userid" id="userid" class="form-control" value="{{$UserID}}" disabled maxlength="13">
            </div>
            <div class="form-group">
                <label for="firstname">First Name</label>
                <input type="text" name="firstname" id="firstname" class="form-control" value="{{$FirstName}}" maxlength="13">
            </div>
            <div class="form-group">
                <label for="lastname">Last Name</label>
                <input type="text" name="lastname" id="lastname"  value="{{$LastName}}"class="form-control">
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username"  value="{{$Username}}"class="form-control">
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input class="form-control" type="text" name="dob" id="dob"  value="{{$DOB}}"autocomplete="off">
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <input name="role" id="role" cols="30" rows="10"  value="{{$Role}}" class="form-control"/>
            </div>
            <button class="btn btn-primary btn-block">Add</button>
        </form>
    </div>
@endsection
