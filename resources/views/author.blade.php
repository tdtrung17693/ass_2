
@extends('layout')
@section('title')
    Author {{ $Author->AuthorName }}
@endsection

@section('main')
    <div class="row author-profile">
        <div class="col-sm-12">
                <h2 class="author-name">{{$Author->AuthorName}}</h2>
            <div class="row">
                <div class="col-sm-12 author-books">
                    <h2 class="section-title">Books</h2>
                    <div class="author-books-wrapper">
                        @if (count($Books) == 0)
                            No book
                        @else
                            <ul class="book-list">
                            @foreach ($Books as $book)
                                <li class="book-list__item">
                                    <img src="{{$book->BookCover}}" alt="" class="book-cover">
                                    <span class="book-title">{{$book->BookTitle}}</span>
                                </li>
                            @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection