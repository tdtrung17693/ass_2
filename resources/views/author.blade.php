
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
                    <h2 class="section-title">
                        Books 
                        <span class="book-count">(Total {{count($Books)}})</span>
                        
                    </h2>
                    <div class="author-books-wrapper">
                        @if (count($Books) == 0)
                            No book
                        @else
                            <ul class="book-list">
                            @foreach ($Books as $book)
                                <li class="book-list__item">
                                    <a class="books__item-cover" href="/books/{{$book->ISBN}}"><img src="{{$book->BookCover}}" alt="" class="book-cover"></a>
                                    
                                    <a class="books__item-title" href="/books/{{$book->ISBN}}">{{$book->BookTitle}}</a>
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