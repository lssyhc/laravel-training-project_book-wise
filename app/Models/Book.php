<?php

namespace App\Models;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;

    public $timestamps = false;

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function scopeTitle(Builder $query, $title): Builder|QueryBuilder
    {
        return $query->where('title', 'LIKE', "%$title%");
    }

    public function scopeLatest(Builder $query): Builder|QueryBuilder
    {
        return $query->orderByDesc('created_at');
    }

    public function scopePopular(Builder $query): Builder|QueryBuilder
    {
        return $query->withCount('reviews')->orderBy('reviews_count', 'desc');
    }

    public function scopePopularLastMonth(Builder $query): Builder|QueryBuilder
    {
        return $query->popular()
            ->whereHas('reviews', function ($query) {
                $query->whereBetween('created_at', [now()->subMonth(), now()]);
            })
            ->having('reviews_count', '>=', 2);
    }

    public function scopePopularLast6Months(Builder $query): Builder|QueryBuilder
    {
        return $query->popular()
            ->whereHas('reviews', function ($query) {
                $query->whereBetween('created_at', [now()->subMonth(6), now()]);
            })
            ->having('reviews_count', '>=', 5);
    }

    public function scopeHighestRated(Builder $query): Builder|QueryBuilder
    {
        return $query->withAvg('reviews', 'rating')->orderBy('reviews_avg_rating', 'desc');
    }

    public function scopeHighestRatedLastMonth(Builder $query): Builder|QueryBuilder
    {
        return $query->highestRated()
            ->whereHas('reviews', function ($query) {
                $query->whereBetween('created_at', [now()->subMonth(), now()]);
            })
            ->having('reviews_avg_rating', '>=', 4);
    }

    public function scopeHighestRatedLast6Months(Builder $query): Builder|QueryBuilder
    {
        return $query->highestRated()
            ->whereHas('reviews', function ($query) {
                $query->whereBetween('created_at', [now()->subMonth(6), now()]);
            })
            ->having('reviews_avg_rating', '>=', 4);
    }
}
