
@extends('layout')
@section('title')
    New community
@endsection

@section('main')
    <div class="row page-title"><div class="col-sm"><h1>
    	Add new community
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
    <div class="row new-comm-form">
        <form action="/communities/new" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="comm-id">Community ID</label>
                <input type="text" name="comm-id" id="comm-id" class="form-control" value="{{old('comm-id')}}" maxlength="17">
            </div>
            <div class="form-group">
                <label for="comm-name">Name</label>
            <input type="text" name="comm-name" id="comm-name" value="{{old('comm-name')}}" class="form-control">
            </div>
            <div class="form-group">
                <label for="comm-desc">Description</label>
                <textarea name="comm-desc" id="comm-desc" class="form-control">{{old('comm-desc')}}</textarea>
            </div>
            <button class="btn btn-primary btn-block">Add</button>
        </form>
    </div>
    
@endsection