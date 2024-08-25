@extends('layouts.app')

@section('page','create review')

@section('content')
    <form action="{{ route('books.reviews.store', $book) }}" method="POST" class="flex flex-col gap-3 text-gray-800">
        @csrf
        <div class="flex flex-col gap-3">
            <label
                class=""
                for="review"
            >What do you think about <span class="font-bold">"{{ $book->title }}"</span>?</label>    
            <textarea
                placeholder="Enter your comment..." 
                class="border rounded-lg p-3 @error('review') border-red-500 @enderror"
                name="review" 
                id="review" 
                cols="30" 
                rows="5"
            >{{ old('review') }}</textarea>
            @error('review')
                <div class="text-red-500 text-sm font-semibold">
                    {{ $message }}
                </div>
            @enderror
        </div>
        
        <div class="flex flex-col gap-3">
            <label
                for="rating"
            >Rating</label>
            <select
                class="rounded-lg bg-white border p-2 @error('rating') border-red-500 @enderror" 
                class="w-full"
                name="rating" 
                id="rating"
            >
                <option value="" disabled @selected(old('rating') == "")>Select an option.</option>
                @for($value = 1; $value <= 5; $value++)
                    <option value="{{ $value }}" @selected(old('rating') == $value)>{{ $value }} </option>
                @endfor
            </select>
            @error('rating')
                <div class="text-red-500 text-sm font-semibold">
                    {{ $message }}
                </div>
            @enderror   
        </div>
        <div class="flex justify-end mt-3 gap-2">
            <a class=" hover:bg-gray-200 p-3 rounded-lg text-center font-bold w-1/3" href="{{ route('books.show', $book) }}">Cancel</a>
            <input
                class="bg-gray-800 hover:bg-gray-700 p-3 rounded-lg text-white font-bold w-1/3"
                type="submit" 
                class="" 
                value="Save"
            >
        </div>
    </form>    
@endsection



