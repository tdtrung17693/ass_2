@extends('layout')
@section('title', 'Add new book')

@section('main')
    <div class="row page-title"><div class="col-sm"><h1>
    	Add new book
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
        <form action="/books/new" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="book-isbn">ISBN</label>
                <input type="text" name="isbn" id="book-isbn" value="{{old('isbn')}}" class="form-control" maxlength="17">
            </div>
            <div class="form-group">
                <label for="book-title">Title</label>
                <input type="text" name="title" id="book-title" value="{{old('title')}}" class="form-control">
            </div>
            <div class="form-group">
                <label for="book-pages">Pages</label>
                <input type="text" name="pages" id="book-pages" value="{{old('pages')}}" class="form-control">
            </div>
            <div class="form-group">
                <label for="book-description">Description</label>
                <textarea name="description" id="book-description" cols="30" rows="10" class="form-control">{{old('description')}}</textarea>
            </div>
            <div class="form-group">
                <label for="authors">Authors</label>
                <select id="authors-select" multiple="multiple" name="authors[]">
                    @foreach($Authors as $a)
                    <option value="{{$a->AuthorID}}">{{$a->AuthorName}}</option>
                    @endforeach
                </select>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-author-modal">
                    Add new author
                </button>
                
            </div>
            <div class="form-group">
                <label for="book-pubdate">Publication Date</label>
                <input class="form-control" type="text" name="pub-date" value="{{old('pub-date')}}" id="book-pubdate">
            </div>
            <button class="btn btn-primary btn-block">Add</button>
        </form>
                <!-- Modal -->
                <div class="modal fade" id="add-author-modal" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="add-author-title">Add new author</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/authors/new_from_book" method="post">
                        <div class="modal-body">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="author-name" class="col-form-label">Author Name:</label>
                                    <input type="text" class="form-control" name="author-name" id="author-name">
                                </div>
                                <div class="form-group">
                                    <label for="desc" class="col-form-label">Description:</label>
                                    <input type="text" class="form-control" id="desc" name="author-desc">
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                            </form>
                        </div>
                    </div>
                </div>
    </div>
    
@endsection