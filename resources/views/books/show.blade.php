<x-layout>
    <div class="flex flex-col gap-12 lg:flex-row">
        <div class="lg:w-1/3">
            <a class="mb-4 inline-block pl-2 text-lg font-bold hover:underline" href="{{ route('books.index') }}">⬅️
                Kembali</a>
            <div class="sticky top-8 rounded-lg bg-white p-8 shadow-lg">
                <h1 class="mb-2 text-3xl font-bold">{{ $book->title }}</h1>
                <p class="mb-6 text-lg text-slate-700">oleh <span class="font-semibold">{{ $book->author }}</span></p>

                <div class="mb-4 flex items-center space-x-2 text-yellow-500">
                    <div class="text-2xl">
                        @for ($i = 1; $i <= 5; $i++)
                            {{ $i <= round($book->reviews_avg_rating ?? 0) ? '★' : '☆' }}
                        @endfor
                    </div>
                </div>

                <p class="text-lg text-slate-600">
                    Rating
                    <span class="font-bold">{{ number_format($book->reviews_avg_rating, 1) }}</span> dari
                    <span class="font-bold">{{ $book->reviews_count }}
                        {{ Str::plural('review', $book->reviews_count) }}</span>
                </p>

                <hr class="my-6">

                <h2 class="mb-4 text-2xl font-semibold">Tambah Review Anda</h2>

                <form action="{{ route('books.reviews.store', $book) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700" for="review">Review</label>
                        <textarea
                            class="mt-1 block w-full rounded-md border-gray-300 p-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            id="review" name="review" rows="4" required placeholder="Apa pendapat Anda tentang buku ini?">{{ old('review') }}</textarea>
                        @error('review')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700" for="rating">Rating</label>
                        <select
                            class="mt-1 block w-full cursor-pointer rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                            id="rating" name="rating" required>
                            <option value="">Pilih Rating</option>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>
                                    {{ $i }}</option>
                            @endfor
                        </select>
                        @error('rating')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <button
                        class="w-full cursor-pointer rounded-md bg-blue-500 px-4 py-3 font-semibold text-white transition-colors hover:bg-blue-600"
                        type="submit">
                        Kirim Review
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:w-2/3">
            <h2 class="mb-6 text-3xl font-bold">Semua Review ({{ $book->reviews_count }})</h2>
            <ul>
                @forelse ($book->reviews as $review)
                    <li class="mb-6 rounded-lg bg-white p-6 shadow-md">
                        <div class="mb-2 flex items-center justify-between">
                            <div class="font-bold text-yellow-500">
                                @for ($i = 1; $i <= 5; $i++)
                                    {{ $i <= $review->rating ? '★' : '☆' }}
                                @endfor
                            </div>
                            <div class="text-sm text-slate-500">{{ $review->created_at->diffForHumans() }}</div>
                        </div>
                        <p class="text-slate-700">{{ $review->review }}</p>
                    </li>
                @empty
                    <li class="mb-6 rounded-lg bg-white p-6 text-center text-slate-500 shadow-md">
                        Jadilah yang pertama mereview buku ini!
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
</x-layout>
