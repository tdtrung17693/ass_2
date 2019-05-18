@extends('layout')
@section('title', 'Add new book')

@section('main')
    <div class="row page-title"><div class="col-sm"><h1>
    	Add new book
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
    <div class="row new-book-form">
        <form action="/books/new" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="book-isbn">ISBN</label>
                <input type="text" name="isbn" id="book-isbn" class="form-control" maxlength="13">
            </div>
            <div class="form-group">
                <label for="book-title">Title</label>
                <input type="text" name="title" id="book-title" class="form-control">
            </div>
            <div class="form-group">
                <label for="book-pages">Pages</label>
                <input type="text" name="pages" id="book-pages" class="form-control">
            </div>
            <div class="form-group">
                <label for="book-description">Description</label>
                <textarea name="description" id="book-description" cols="30" rows="10" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="book-pubdate">Publication Date</label>
                <input class="form-control" type="text" name="pub-date" id="book-pubdate">
            </div>
            <button class="btn btn-primary btn-block">Add</button>
        </form>
    </div>
    
@endsection