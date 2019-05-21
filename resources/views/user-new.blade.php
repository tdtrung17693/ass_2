@extends('layout')
@section('title', 'Add new user')

@section('main')
    <div class="row page-title"><div class="col-sm"><h1>
    	Add new user
    </h1></div></div>

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="row new-user-form">
        <form action="/users/new" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="userid">User ID</label>
                <input type="text" name="userid" id="userid" class="form-control" maxlength="13">
            </div>
            <div class="form-group">
                <label for="firstname">First Name</label>
                <input type="text" name="firstname" id="firstname" class="form-control" maxlength="13">
            </div>
            <div class="form-group">
                <label for="lastname">Last Name</label>
                <input type="text" name="lastname" id="lastname" class="form-control">
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="form-control">
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input class="form-control" type="text" name="dob" id="dob" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <input name="role" id="role" cols="30" rows="10" class="form-control"/>
            </div>
            <button class="btn btn-primary btn-block">Add</button>
        </form>
    </div>
@endsection
