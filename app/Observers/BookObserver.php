<?php

namespace App\Observers;

use App\Models\Book;
use Illuminate\Support\Facades\Cache;

class BookObserver
{
    /**
     * Handle the Book "created" event.
     */
    public function created(Book $book): void
    {
        Cache::tags(['books'])->flush();
    }

    /**
     * Handle the Book "updated" event.
     */
    public function updated(Book $book): void
    {
        Cache::tags(['books'])->flush();
    }

    /**
     * Handle the Book "deleted" event.
     */
    public function deleted(Book $book): void
    {
        Cache::tags(['books'])->flush();
    }
}
