@extends('layout')

@section('main')

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
<div class="row">
    <div class="col-sm books-container">
        @foreach ($books as $book)
            <div class="books__item">
                <a href="/books/{{$book->ISBN}}" class="books__item-cover">
                    <img src="{{$book->BookCover}}" alt="">
                </a>
                <div class="books__item-title">
                    <a href="/books/{{$book->ISBN}}" class="books__item-title-link">{{$book->BookTitle}}</a>
                </div>
                @if (!is_null($authors[$book->ISBN]))
                <div class="books__item-author">
                    <?php $count = 0; ?>
                    @foreach ($authors[$book->ISBN] as $id => $name)
                        <a href="/authors/{{$id}}" class="books__item-author-link">{{$name}}</a>
                        @if ($count != count($authors[$book->ISBN]) - 1)
                        ,
                        @endif
                        <?php ++$count; ?>
                    @endforeach
                </div>
                @endif
                <div class="books__item-rating">
                    @if($book->AvgRating)
                        Rating: {{ $book->AvgRating }} 
                    @else 
                        No ratings
                    @endif
                </div>
                <div class="books__item-actions">
                    <a href="/books/edit/{{$book->ISBN}}" class="item-action action-edit"><i class="fas fa-pen-alt"></i></a>
                    <a href="/books/delete/{{$book->ISBN}}" class="item-action action-trash"><i class="fas fa-trash-alt"></i></a>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection