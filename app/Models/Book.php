<?php

namespace App\Models;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

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

    protected function scopeWithReviewStats(Builder $query, Carbon $fromDate, int $minReviewCount): Builder|QueryBuilder
    {
        $dateConstraint = function (Builder $q) use ($fromDate) {
            $q->where('created_at', '>=', $fromDate);
        };

        return $query
            ->withCount(['reviews' => $dateConstraint])
            ->withAvg(['reviews' => $dateConstraint], 'rating')
            ->having('reviews_count', '>=', $minReviewCount);
    }

    public function scopePopularLastMonth(Builder $query): Builder|QueryBuilder
    {
        return $query->withReviewStats(now()->subMonth(), 2)
            ->orderByDesc('reviews_count');
    }

    public function scopePopularLast6Months(Builder $query): Builder|QueryBuilder
    {
        return $query->withReviewStats(now()->subMonth(6), 5)
            ->orderByDesc('reviews_count');
    }

    public function scopeHighestRatedLastMonth(Builder $query): Builder|QueryBuilder
    {
        return $query->withReviewStats(now()->subMonth(), 2)
            ->orderByDesc('reviews_avg_rating');
    }

    public function scopeHighestRatedLast6Months(Builder $query): Builder|QueryBuilder
    {
        return $query->withReviewStats(now()->subMonth(6), 5)
            ->orderByDesc('reviews_avg_rating');
    }
}
