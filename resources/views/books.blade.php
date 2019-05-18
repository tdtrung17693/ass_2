@extends('layout')

@section('main')

<div class="row">
    <div class="col-sm books-container">
        @foreach ($books as $book)
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
                <div class="books__item-actions">
                <a href="#" class="item-action" data-isbn="{{$book->ISBN}}"><i class="fas fa-trash-alt"></i></a>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection