
@extends('layout')

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
    <div class="col-sm search-msg">
        <form action="/search_msg_by_user" method="post">
            {{ csrf_field() }}
            <div class="input-group">
                <label for="userid">User ID</label>
                <input type="text" name="userid" id="userid" class="form-control">
            </div>
            <div class="input-group">
                <label for="boxid">Box ID</label>
                <input type="text" name="boxid" id="boxid" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>
</div>

@endsection