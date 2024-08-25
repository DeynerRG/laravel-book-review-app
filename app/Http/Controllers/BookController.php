<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;


class BookController extends Controller
{
   
    public function index(Request $request)
    {
        $title = $request->input('title');
        $filter = $request->input('filter');
    
        $books = Book::when($title, function ($query, $title){
           $query->title($title);
        });

        $books = match($filter){
            'popular_last_month'        => $books->popularLastMonth(),
            'popular_last_6months'      => $books->popularLast6Months(),
            'highest_rated_last_month'  => $books->highestRatedLastMonth(),
            'highest_rated_last_6months'=> $books->highestRatedLast6Months(),
            default                     => $books->latest()->withAvgRating()->withReviewsCount(),
        };
        
        $cacheKey = 'books:' . $filter . ':' . $title;
        $books = cache()->remember($cacheKey, 3600, function() use($books) {
            return $books->get();
        });

        return view('books.index', ['books'=>$books]);
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
    }


    public function show(int $id)
    {
        // Eager loading -> carga el modelo con sus relaciones directamente (como en este caso).
        // Lazy loading -> carga unicamente el modelo, las relaciones se cargan en otro query al solicitarlas.
        // Devuelve el modelo con los registros de la tabla reviews que estan asociados al modelo. 

        $cacheKey = 'book:' . $id;
        $book = cache()->remember(
            $cacheKey, 
            3600, 
            fn() => Book::with([
                'reviews'=> fn ($query)=>$query->latest()
            ])->withAvgRating()->withReviewsCount()->findOrFail($id)
        );

        return view('books.show', [ 'book'=> $book ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
