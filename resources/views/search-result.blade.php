
@extends('layout')

@section('title')
    {{ $title }}
@endsection
@section('main')
    @if (count($result) === 0)
        <div class="no-result">
            <img src="/img/noresult.png" alt="No result">
            <span>NO SEARCH RESULTS</span>
        </div>
    @else
        <div class="row">
            @if ($scope === 'author')
            <div class="col-sm author-result">
                @foreach ($result as $author)
                    <div class="author-card">
                        <h3><a href="/authors/{{ $author->AuthorID }}">{{ $author->AuthorName }}</a></h3>
                        Number of book: <span class="author-row__book-count">{{ $author->BookCount }}</span>
                    </div>
                @endforeach
            </div>
            @else
            <div class="col-sm book-result books-container">
                @foreach ($result as $book)
                    <div class="books__item">
                        <a href="#" class="books__item-cover">
                            <img src="{{$book->BookCover}}" alt="">
                        </a>
                        <div class="books__item-title">
                            <a href="#" class="books__item-title-link">{{$book->BookTitle}}</a>
                        </div>
                        <div class="books__item-rating">
                            @if($book->AvgRating)
                                Ratings: {{ $book->AvgRating }} 
                            @else 
                                No ratings
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            @endif
        </div>
    @endif
@endsection