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

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function scopeTitle(Builder $query, $title): Builder|QueryBuilder
    {
        return $query->where('title', 'LIKE', "%$title%");
    }

    public function scopeMostRecent(Builder $query): Builder|QueryBuilder
    {
        return $query->orderByDesc('created_at')->withCount('reviews')->withAvg('reviews', 'rating');
    }

    public function scopePopularLastMonth(Builder $query): Builder|QueryBuilder
    {
        return $query
            ->withAvg(['reviews' => function (Builder $q) {
                $q->whereBetween('created_at', [now()->subMonth(), now()]);
            }], 'rating')
            ->withCount(['reviews' => function (Builder $q) {
                $q->whereBetween('created_at', [now()->subMonth(), now()]);
            }])
            ->having('reviews_count', '>=', 2)
            ->orderByDesc('reviews_count');
    }

    public function scopePopularLast6Months(Builder $query): Builder|QueryBuilder
    {
        return $query
            ->withAvg(['reviews' => function (Builder $q) {
                $q->whereBetween('created_at', [now()->subMonth(6), now()]);
            }], 'rating')
            ->withCount(['reviews' => function (Builder $q) {
                $q->whereBetween('created_at', [now()->subMonths(6), now()]);
            }])
            ->having('reviews_count', '>=', 5)
            ->orderByDesc('reviews_count');
    }

    public function scopeHighestRatedLastMonth(Builder $query): Builder|QueryBuilder
    {
        return $query
            ->withAvg(['reviews' => function (Builder $q) {
                $q->whereBetween('created_at', [now()->subMonth(), now()]);
            }], 'rating')
            ->withCount(['reviews' => function (Builder $q) {
                $q->whereBetween('created_at', [now()->subMonth(), now()]);
            }])
            ->having('reviews_count', '>=', 2)
            ->orderByDesc('reviews_avg_rating');
    }

    public function scopeHighestRatedLast6Months(Builder $query): Builder|QueryBuilder
    {
        return $query
            ->withAvg(['reviews' => function (Builder $q) {
                $q->whereBetween('created_at', [now()->subMonths(6), now()]);
            }], 'rating')
            ->withCount(['reviews' => function (Builder $q) {
                $q->whereBetween('created_at', [now()->subMonths(6), now()]);
            }])
            ->having('reviews_count', '>=', 5)
            ->orderByDesc('reviews_avg_rating');
    }
}
