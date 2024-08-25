<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;


    protected $fillable = ['review', 'rating'];


    // Contraparte de la definición de relación 'one to many'
    public function book(){
        return $this->belongsTo(Book::class);
    }


    // Events
    protected static function booted():void
    {
        static::updated(function (Review $review){
            cache()->forget('book:'. $review->book_id); // tambien se puede usar $review->book->id por que está relacionado a la tabla book
        });

        static::deleted(function (Review $review){
            cache()->forget('book:'. $review->book_id); // tambien se puede usar $review->book->id por que está relacionado a la tabla book
        });      

        static::created(function (Review $review){
            cache()->forget('book:'. $review->book_id);
        });
    }




}
