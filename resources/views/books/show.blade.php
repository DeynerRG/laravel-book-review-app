@extends('layouts.app')

@section('content')
    <div class="mt-5 text-gray-800 flex flex-col md:flex-row md:justify-between md:items-center">
        <div>
            <h1 class="text-2xl lg:text-4xl font-bold ">{{ $book->title }}</h1>
            <h2 class="">By {{ $book->author }}</h2>
        </div>
        <div class="mt-5 md:mt-0">
            <h3 class="flex gap-3 items-center">
                <x-star-rating :rating="number_format($book->reviews_avg_rating)"/>
                <p class="flex gap-2 items-center"> 
                    <span class="font-bold text-2xl">{{ $book->reviews_count }}</span> 
                    <span class="text-gray-800">{{ Str::plural('Review', $book->reviews_count) }}</span> 
                </p>
            </h3>
        </div>
    </div>
    <div class="flex justify-end">
        <a class="inline-block px-3  py-2 bg-gray-800 hover:bg-gray-700 rounded-lg text-white font-semibold text-sm" href="{{ route('books.reviews.create', $book) }}">Add review</a>
    </div>
    
    <ul class="mt-10">
        @forelse($book->reviews as $key => $review)
            
            
            <li class="p-3 rounded-lg border mb-3">
                <div class="flex justify-between items-center">
                    <x-star-rating :rating="$review->rating"/>
                    <p class="text-sm">{{ $review->created_at->format('M j, Y') }}</p>
                </div>
                <p class="my-3">{{ $review->review }}</p>
            </li>
        @empty
            <li>there is not reviews yet</li>
        @endforelse
    </ul>

@endsection  
