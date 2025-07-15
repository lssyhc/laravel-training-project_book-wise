<?php

namespace App\Observers;

use App\Models\Review;
use Illuminate\Support\Facades\Cache;

class ReviewObserver
{
    /**
     * Handle the Review "created" event.
     */
    public function created(Review $review): void
    {
        Cache::tags(['books'])->flush();
    }

    /**
     * Handle the Review "updated" event.
     */
    public function updated(Review $review): void
    {
        Cache::tags(['books'])->flush();
    }

    /**
     * Handle the Review "deleted" event.
     */
    public function deleted(Review $review): void
    {
        Cache::tags(['books'])->flush();
    }
}
