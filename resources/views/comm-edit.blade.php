@extends('layout')
@section('title')
    Edit community {{ $Name }}
@endsection

@section('main')
    <div class="row page-title"><div class="col-sm"><h1>
    	Edit community
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
    <div class="row new-comm-form">
        <form action="/communities/{{$CommID}}" method="post">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="form-group">
                <label for="comm-id">Community ID</label>
                <input type="text" name="comm-id" readonly id="comm-id" class="form-control" value="{{$CommID}}" maxlength="17">
            </div>
            <div class="form-group">
                <label for="comm-name">Name</label>
            <input type="text" name="comm-name" id="comm-name" value="{{$Name}}" class="form-control">
            </div>
            <div class="form-group">
                <label for="comm-desc">Description</label>
                <textarea name="comm-desc" id="comm-desc" class="form-control">{{$Desc}}</textarea>
            </div>
            <button class="btn btn-primary btn-block">Save</button>
        </form>
    </div>
    
@endsection