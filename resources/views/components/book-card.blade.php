<div class="flex flex-col overflow-hidden rounded-lg bg-white shadow-lg">
    <div class="flex-grow p-6">
        <h3 class="mb-2 text-xl font-bold text-slate-700">
            {{ $book->title }}
        </h3>
        <span class="text-sm text-slate-600">oleh {{ $book->author }}</span>
        <p class="mt-2 text-sm text-slate-400">Diterbitkan {{ $book->created_at->diffForHumans() }}</p>
    </div>
    <div class="flex items-center justify-between bg-slate-50 p-4 text-sm">
        <div>
            <span class="font-semibold">Rating {{ number_format($book->reviews_avg_rating, 1) }} ★</span>
            <span class="text-slate-500"> (Jumlah Review {{ number_format($book->reviews_count) }})</span>
        </div>
        <a class="rounded-md bg-blue-500 px-4 py-2 text-white transition-colors hover:bg-blue-600"
            href="{{ route('books.show', $book) }}">
            Lihat Review
        </a>
    </div>
</div>
