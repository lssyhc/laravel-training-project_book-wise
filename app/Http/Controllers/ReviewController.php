<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Book $book)
    {
        $book->reviews()->create([
            ...$request->validate([
            'rating' => 'required|min:1|max:5|integer',
            'review' => 'required|min:15|string'
            ]),
            'created_at' => now()
        ]);
        return redirect()->route('books.show', $book)->with('success', 'Review berhasil dibuat!');
    }
}
