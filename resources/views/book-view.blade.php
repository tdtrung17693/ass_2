@extends('layout')
@section('title')
    Book: {{$Book->BookTitle}}
@endsection

@section('main')
<div class="row book-container">
    <div class="col-sm-4 book-cover">
        <img src="{{$Book->BookCover}}" />
    </div>
    <div class="col-sm-8 book-metadata">
        <h2 class="book-title">{{$Book->BookTitle}}</h2>
        <div class="book-authors">
            by 
            @if(count($Authors) > 0)
            @foreach($Authors as $index => $author)
                <a class="book-author" href="/authors/{{$author->AuthorID}}">{{$author->AuthorName}}</a>
                @if($index != count($Authors) - 1)
                ,
                @endif
            @endforeach
            @else
                <a href="#" class="book-author">Unknown Authors</a>
            @endif
        </div>
        <div class="book-desc">
            <p>{{$Book->BookDescription}}</p>
        </div>
        <div class="book-reviews">
            <h3 class="section-title">Reviews</h3>
            @if(count($Reviews) == 0)
                NO REVIEWS
            @else
            <ul class="review-list">
                @foreach ($Reviews as $review)
                    <li class="review">
                        <div class="review-wrap">
                            <span class="review-user">{{$review->Username}}</span> 
                            - <span class="review-rating">Rating: <span>{{$review->BookRating}}</span></span>
                            <p class="review-content">
                                {{$review->PostContent}}
                            </p>
                        </div>
                    </li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>
</div>

@endsection