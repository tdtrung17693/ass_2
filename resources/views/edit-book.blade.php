
@extends('layout')
@section('title')
    Edit book {{ $title }}
@endsection

@section('main')
    <div class="row page-title"><div class="col-sm"><h1>
    	Edit book
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
    <div class="row new-book-form">
        <form action="/books/{{$ISBN}}" method="post">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="form-group">
                <label for="book-isbn">ISBN</label>
                <input type="text" name="isbn" readonly id="book-isbn" class="form-control" value="{{$ISBN}}" maxlength="17">
            </div>
            <div class="form-group">
                <label for="book-title">Title</label>
            <input type="text" name="title" id="book-title" value="{{$title}}" class="form-control">
            </div>
            <div class="form-group">
                <label for="book-pages">Pages</label>
                <input type="text" name="pages" id="book-pages" value="{{$pnum}}" class="form-control">
            </div>
            <div class="form-group">
                <label for="book-description">Description</label>
                <textarea name="description" id="book-description" cols="30" rows="10" class="form-control">{{$description}}</textarea>
            </div>
            <div class="form-group">
                <label for="book-pubdate">Publication Date</label>
                <input class="form-control" type="text" name="pub-date" value="{{$pubdate}}" id="book-pubdate">
            </div>
            <button class="btn btn-primary btn-block">Save</button>
        </form>
    </div>
    
@endsection