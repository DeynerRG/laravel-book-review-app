<?php

namespace App\Models;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Book extends Model
{
    use HasFactory;


    // Definicion de relación 'one to many'
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Este query scope permite buscar libros por el titulo
    public function scopeTitle(Builder $query, string $title): Builder
    {
        return $query->where('title', 'LIKE', "%$title%");
    }

    public function scopeWithReviewsCount(Builder $query, $from = null, $to = null): Builder|QueryBuilder
    {
        return $query->withCount([
            'reviews'=> function (Builder $q) use ($from, $to){ $this->dateRangeFilter($q, $from, $to);}
        ]);
    }

    public function scopeWithAvgRating(Builder $query, $from = null, $to = null): Builder|QueryBuilder
    {
        return $query->withAvg(
            ['reviews'=>function (Builder $q) use ($from, $to){ $this->dateRangeFilter($q, $from, $to);}],
            'rating'
        );
    }


    // Este query scope permite devolver los registros con mas reviews, especificando o no un rango de fechas, ordenados descendentemente.
    public function scopePopular(Builder $query, $from = null, $to = null): Builder|QueryBuilder
    {
        return $query->withReviewsCount()->orderBy('reviews_count', 'desc');
    }

    // Este query scope permite devolver los registros con el promedio de calificaciones en reviews especificando un rango de fechas, ordenados descendenetemente.
    public function scopeHighestRated(Builder $query, $from = null, $to = null):Builder|QueryBuilder 
    {
        return $query->withAvgRating()->orderBy('reviews_avg_rating', 'desc');
    }


    public function scopeMinReviews(Builder $query, int $minReviews):Builder|QueryBuilder
    {
        return $query->having('reviews_count', '>=', $minReviews);
    }


    // metodo para filtrar registros por rango de fechas
    private function dateRangeFilter(Builder $query, $from = null, $to = null)
    {
        if($from && !$to){
            $query->where('created_at', '>=', $from);
        }else if(!$from && $to){
            $query->where('created_at', '<=', $to);
        }else if($from && $to){
            $query->whereBetween('created_at', [$from, $to]);
        }
    }


    public function scopePopularLastMonth(Builder $query): Builder | QueryBuilder
    {
        return $query->popular(now()->subMonth(), now())
            ->highestRated(now()->subMonth(), now())
            ->minReviews(2);
    }

    public function scopePopularLast6Months(Builder $query): Builder|QueryBuilder
    {
        return $query->popular(now()->subMonths(6), now())
            ->highestRated(now()->subMonths(6), now())
            ->minReviews(5);
    }


    public function scopeHighestRatedLastMonth(Builder $query): Builder|QueryBuilder
    {
        return $query->highestRated(now()->subMonth(), now())
            ->popular(now()->subMonth(), now())
            ->minReviews(2);
    }


    public function scopeHighestRatedLast6Months(Builder $query): Builder|QueryBuilder
    {
        return $query->highestRated(now()->subMonths(6), now())
            ->popular(now()->subMonths(6), now())
            ->minReviews(5);
    }


        // Events
    protected static function booted():void
    {
        static::updated(function (Book $book){
            cache()->forget('book:'. $book->id);
        });

        static::deleted(function (Book $book){
            cache()->forget('book:'. $book->id); 
        });      
    }
    /* 
    Diferencias entre where y having
    - where se utiliza cuando es un campo de una tabla
    - having se utiliza cuando es un campo de una tabla que fue generado por 'funciones de agregacion', por ejemplo: avg, count, etc.
    */

    
}
