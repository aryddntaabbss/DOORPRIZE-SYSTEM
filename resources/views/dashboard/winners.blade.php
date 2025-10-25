<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 flex items-center gap-2">
            <span>Daftar Pemenang</span>
        </h2>
    </x-slot>

    <div class="p-6 space-y-8">

        {{-- Alert Success --}}
        @if (session('success'))
        <div class="flex items-center p-4 mb-4 text-sm text-green-700 border border-green-300 rounded-lg bg-green-50 shadow-sm"
            role="alert">
            <svg class="flex-shrink-0 w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 1 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <div><span class="font-semibold">Berhasil!</span> {{ session('success') }}</div>
        </div>
        @endif

        {{-- Alert Error --}}
        @if (session('error'))
        <div class="flex items-center p-4 mb-4 text-sm text-red-700 border border-red-300 rounded-lg bg-red-50 shadow-sm"
            role="alert">
            <svg class="flex-shrink-0 w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 1 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <div><span class="font-semibold">Error!</span> {{ session('error') }}</div>
        </div>
        @endif

        {{-- Kategori Cards --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-800">Kelola Kategori Undian</h3>
                <p class="text-sm text-gray-500">Pilih kategori untuk memulai undian</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($categories as $category)
                <div
                    class="border rounded-xl p-6 transition-all {{ $category->is_active ? 'bg-blue-50 border-blue-300 shadow-md' : 'bg-white border-gray-200 hover:shadow-md' }}">

                    {{-- Category Header --}}
                    <div class="mb-4">
                        <h4 class="text-xl font-bold text-gray-800 mb-2">{{ $category->name }}</h4>
                        <div class="flex items-center gap-2">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                🎯 {{ $category->total_winners }} Pemenang
                            </span>
                            @if ($category->is_active)
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 animate-pulse">
                                ⚡ Aktif
                            </span>
                            @endif
                        </div>
                    </div>

                    {{-- Category Actions --}}
                    @if ($category->is_active)
                    <div class="space-y-2">
                        <form action="{{ route('winners.draw') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2.5 rounded-md shadow-sm transition-colors focus:outline-none focus:ring-4 focus:ring-blue-200">
                                Acak Pemenang
                            </button>
                        </form>
                        <form action="{{ route('winners.reset') }}" method="POST">
                            @csrf
                            <button type="submit"
                                onclick="return confirm('Yakin ingin mereset semua pemenang? Tindakan ini tidak dapat dibatalkan!')"
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2.5 rounded-md shadow-sm transition-colors focus:outline-none focus:ring-4 focus:ring-red-200">
                                Reset Semua
                            </button>
                        </form>
                    </div>
                    @else
                    <form action="{{ route('winners.setActive') }}" method="POST">
                        @csrf
                        <input type="hidden" name="category_id" value="{{ $category->id }}">
                        <button type="submit"
                            class="w-full bg-gray-600 hover:bg-gray-700 text-white font-semibold px-4 py-2.5 rounded-md shadow-sm transition-colors focus:outline-none focus:ring-4 focus:ring-gray-200">
                            Set Aktif
                        </button>
                    </form>
                    @endif
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7">
                        </path>
                    </svg>
                    <p class="font-medium text-gray-700">Belum ada kategori</p>
                    <p class="text-sm text-gray-500">Buat kategori terlebih dahulu di menu Kategori Hadiah</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Daftar Pemenang per Kategori --}}
        <div class="bg-white rounded-xl shadow-md border border-gray-100">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Daftar Pemenang per Kategori</h3>

                @forelse ($categories as $category)
                <div class="mb-6 last:mb-0">
                    {{-- Category Header --}}
                    <div
                        class="flex items-center justify-between px-6 py-4 rounded-t-lg {{ $category->is_active ? 'bg-blue-100 border-2 border-blue-300' : 'bg-gray-100 border border-gray-200' }}">
                        <div class="flex items-center gap-3">
                            <div>
                                <h4 class="font-bold text-gray-800">{{ $category->name }}</h4>
                                <p class="text-sm text-gray-600">Target: {{ $category->total_winners }} pemenang</p>
                            </div>
                        </div>
                        @if ($category->is_active)
                        <span
                            class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-green-500 text-white animate-pulse">
                            ⚡ Sedang Diundi
                        </span>
                        @endif
                    </div>

                    @php
                    $winnersOfCategory = $winners->where('category_id', $category->id);
                    @endphp

                    {{-- Winners Table --}}
                    @if ($winnersOfCategory->isEmpty())
                    <div class="border border-t-0 rounded-b-lg p-8 text-center text-gray-500 bg-gray-50">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <p class="font-medium text-gray-700">Belum ada pemenang</p>
                        <p class="text-sm text-gray-500">Klik tombol "Acak Pemenang" untuk memulai undian</p>
                    </div>
                    @else
                    <div class="border border-t-0 rounded-b-lg overflow-hidden">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-center">No</th>
                                    <th scope="col" class="px-6 py-3">Nomor BIB</th>
                                    <th scope="col" class="px-6 py-3">Waktu Menang</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($winnersOfCategory as $index => $winner)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-center font-medium text-gray-900">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center gap-2 font-mono text-xl font-bold text-green-600">
                                            {{ $winner->participant->bib_number }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2 text-gray-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="font-medium">{{ $winner->created_at->format('H:i:s') }}</span>
                                            <span
                                                class="text-xs text-gray-500">{{ $winner->created_at->format('d/m/Y') }}</span>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
                @empty
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <p class="font-medium text-gray-700 text-lg">Belum ada kategori terdaftar</p>
                    <p class="text-sm text-gray-500 mt-2">Silakan tambahkan kategori hadiah terlebih dahulu</p>
                    <a href="{{ route('categories.index') }}"
                        class="inline-flex items-center mt-4 text-blue-600 hover:underline font-medium">
                        ➜ Ke Menu Kategori Hadiah
                    </a>
                </div>
                @endforelse
            </div>
        </div>

    </div>
</x-app-layout>