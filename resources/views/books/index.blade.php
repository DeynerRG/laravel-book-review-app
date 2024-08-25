@extends('layouts.app')


@section('content')
    <h1 class="uppercase text-3xl font-bold mb-5">books</h1>    
    <form method="GET" action="{{route('books.index')}}"  class="flex gap-2 items-center w-full mb-5">
        <input value="{{ request('title') }}" class="w-full p-2 border rounded-lg" type="text" name="title" placeholder="Enter book title">
        <input type="hidden" name="filter" value="{{ request('filter') }}">
        <input  class="bg-orange-500 hover:bg-orange-600 font-bold text-white p-2 rounded-lg" type="submit" value="Search">
        <a class="bg-gray-800 hover:bg-gray-700 font-bold text-white p-2 rounded-lg" href="{{route('books.index')}}">Clear</a>
    </form>
    <p class="text-md font-bold text-gray-800 mb-3">
        Filter by:
    </p>
    <div class="grid grid-cols-3 gap-2 mb-5">
        @php
            $filters = [
                ''=>'Latest',
                'popular_last_month'=>'Popular Last Month',
                'popular_last_6months'=>'Popular Last 6 Months',
                'highest_rated_last_month'=>'Highest Rated Last Month',
                'highest_rated_last_6months'=>'Highest Rated Last 6 Months',
            ];
        @endphp
        @foreach($filters as $key => $value)
            <a href="{{ route('books.index', [ ...request()->query(), 'filter'=> $key]) }}" class="{{ request('filter') == $key || (request('filter')==null && $key==='') ? 'bg-gray-800 text-white' : ' bg-white text-gray-600 hover:bg-gray-100'}} text-sm font-bold  border h-16 p-2 rounded-lg flex items-center justify-center text-center">{{ $value }}</a>
        @endforeach
    </div>

    <p class="text-md font-bold text-gray-800 mb-3">
        Results:
    </p>
    <ul class="flex flex-col gap-3">
        @forelse($books as $book)
            <li class="border rounded-lg p-3 text-sm hover:bg-gray-100 flex justify-between">
                <div class="flex flex-col gap-1">
                    <a href="{{route('books.show', $book)}}" class="font-bold text-lg m-0">{{$book->title}}</a>
                    <span class="text-sm text-gray-500 m-0">by: {{$book->author}}</span>
                </div>
                <div class="flex flex-col gap-2 items-end">
                   
                    <x-star-rating :rating="number_format($book->reviews_avg_rating)"/>
                    <span class="text-sm text-gray-500 flex gap-2"> 
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                        </svg>
                        {{ $book->reviews_count}}
                    </span>
                    
                </div>
            </li>
        @empty
            <div class="flex flex-col gap-2 items-center">
                <p class="empty-text font-bold text-3xl text-gray-400 mb-3">No books found</p>
                <a href="{{ route('books.index') }}" class="reset-link text-sm bg-gray-800 hover:bg-gray-600 rounded-lg p-2 text-white font-bold flex gap-2 items-center">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>                    
                    </span>
                    Reset criteria
                </a>
            </div>
        @endforelse
    </ul>
@endsection