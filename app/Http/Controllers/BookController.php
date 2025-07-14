<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::query();
        $books = $books->withCount('reviews')->withAvg('reviews', 'rating')->get();
        return view('books.index', ['books' => $books]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
    }
}
