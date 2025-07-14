<x-layout>
    <h1 class="mb-8 text-4xl font-extrabold text-slate-900">Daftar Buku BookWise</h1>

    @php
        $filters = [
            '' => 'Semua',
            'latest' => 'Terbaru',
            'popular_last_month' => 'Populer Bulan Lalu',
            'popular_last_6months' => 'Populer 6 Bulan Lalu',
            'highest_rated_last_month' => 'Rating Tertinggi Bulan Lalu',
            'highest_rated_last_6months' => 'Rating Tertinggi 6 Bulan Lalu',
        ];
    @endphp

    <form class="mb-8 rounded-lg bg-white p-6 shadow-md" method="GET" action="{{ route('books.index') }}">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
            <div class="col-span-1 md:col-span-2">
                <label class="block text-sm font-medium text-gray-700" for="search">Cari
                    Judul</label>
                <input
                    class="mt-1 block w-full rounded-md border-gray-300 p-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    id="search" name="search" type="text" value="{{ request('search') }}"
                    placeholder="Dune, Sapiens...">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700" for="filter">Filter</label>
                <select
                    class="mt-1 block w-full cursor-pointer rounded-md border border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                    id="filter" name="filter">
                    @foreach ($filters as $key => $label)
                        <option value="{{ $key }}" {{ request('filter') === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button
                    class="w-full cursor-pointer rounded-md bg-blue-500 px-4 py-2 text-white transition-colors hover:bg-blue-600"
                    type="submit">
                    Filter
                </button>
            </div>
        </div>
    </form>

    <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($books as $book)
            <x-book-card :book="$book" />
        @empty
            <p class="col-span-full text-center text-slate-500">Daftar buku kosong.</p>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $books->links() }}
    </div>
</x-layout>
