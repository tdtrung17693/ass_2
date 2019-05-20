
@extends('layout')
@section('title', 'Communiteis')

@section('main')

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
<div class="row">
    <div class="col-sm">
        <a href="/communities/new" class="btn btn-primary" style="margin-top: 1em;">New community</a>
        <div class="filter-action">
            <form action="/communities" method="get" class="form-inline">
                <label for="filter" class="mr-sm-2">Show communities with the number of members more than</label>
                <input type="text" name="filter" id="filter" value={{$filter ?? 0}} class="form-control mr-sm-2">
                @if (!is_null($filter))
                    <a href="/communities" class="btn btn-success">Show all</a> 
                @endif
            </form>
        </div>
        <table class="table comm-list table-bordered">
            
            @foreach ($Comms as $comm)
                <tr>
                    <td>
                        <a href="/communities/{{$comm->CommunityID}}"><span class="comm-item__name">{{ $comm->CommunityName }}</span></a>
                    </td>
                    <td>
                        {{$comm->NumberOfUsers}}
                    </td>
                    <td class="comm-item__actions">
                        <a href="/communities/edit/{{$comm->CommunityID}}" class="item-action action-edit" ><i class="fas fa-pen-alt"></i></a>
                        <a href="/communities/delete/{{$comm->CommunityID}}" class="item-action action-trash"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </li>
            @endforeach
        </table>
    </div>
</div>

@endsection