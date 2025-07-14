<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = $request->input('search');
        $filter = $request->input('filter', '');

        $books = Book::query();
        $books = $books->when($title, fn ($query, $title) => $query->title($title));
        $books = match($filter) {
            'latest' => $books->latest(),
            'popular_last_month' => $books->popularLastMonth(),
            'popular_last_6months' => $books->popularLast6Months(),
            'highest_rated_last_month' => $books->highestRatedLastMonth(),
            'highest_rated_last_6months' => $books->highestRatedLast6Months(),
            default => $books
        };

        $books = $books->withCount('reviews')->withAvg('reviews', 'rating')->paginate(9);
        return view('books.index', compact('books'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
    }
}
