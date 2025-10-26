<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 flex items-center gap-2">
            <span>Generate Nomor BIB Peserta</span>
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

        {{-- Form Generate --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-800">Generate Nomor BIB</h3>
                <p class="text-sm text-gray-500">Masukkan rentang nomor yang ingin dibuat</p>
            </div>

            <form method="POST" action="{{ route('participants.generate') }}" class="grid gap-6 md:grid-cols-3"
                novalidate>
                @csrf

                <div class="flex flex-col">
                    <label for="start" class="text-sm font-medium text-gray-700 mb-2">Mulai dari</label>
                    <input type="number" name="start" id="start" placeholder="Contoh: 1"
                        class="border border-gray-300 focus:border-blue-400 focus:ring focus:ring-blue-100 rounded-md text-gray-800 text-sm p-2.5 transition-all"
                        required>
                </div>

                <div class="flex flex-col">
                    <label for="end" class="text-sm font-medium text-gray-700 mb-2">Sampai</label>
                    <input type="number" name="end" id="end" placeholder="Contoh: 1000"
                        class="border border-gray-300 focus:border-blue-400 focus:ring focus:ring-blue-100 rounded-md text-gray-800 text-sm p-2.5 transition-all"
                        required>
                </div>

                <div class="flex items-end">
                    <button type="submit"
                        class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-md shadow-sm transition-colors focus:outline-none focus:ring-4 focus:ring-blue-200">
                        Generate
                    </button>
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-xl shadow-md border border-gray-100">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Daftar Peserta</h3>

                <div class="flex items-center justify-between mb-4">
                    <form method="GET" action="{{ route('participants.index') }}" class="flex items-center gap-2">
                        <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari BIB..."
                            class="border rounded px-3 py-2">
                        <button class="bg-blue-600 text-white px-3 py-2 rounded">Cari</button>
                    </form>

                    <div class="flex items-center gap-2">
                        <form method="GET" action="{{ route('participants.index') }}">
                            <label class="text-sm text-gray-600 mr-2">Per halaman</label>
                            <select name="per_page" onchange="this.form.submit()" class="border rounded px-2 py-1">
                                <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            </select>
                        </form>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th scope="col" class="px-4 py-3">No</th>
                                <th scope="col" class="px-4 py-3">Nomor BIB</th>
                                <th scope="col" class="px-4 py-3">Nama</th>
                                <th scope="col" class="px-4 py-3">Status</th>
                                <th scope="col" class="px-4 py-3">Prioritas</th>
                                <th scope="col" class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($participants as $index => $p)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 font-medium text-gray-900 w-16">
                                    {{ $participants->firstItem() + $index }}
                                </td>

                                <td class="px-4 py-3 font-mono text-blue-600 font-semibold w-36">
                                    {{ $p->bib_number }}
                                </td>

                                <td class="px-4 py-3">
                                    <div class="text-sm font-medium text-gray-800">{{ $p->name ?? '-' }}</div>
                                </td>

                                <td class="px-4 py-3">
                                    @if ($p->is_winner)
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">✅
                                        Sudah Menang</span>
                                    @else
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">⏳
                                        Belum Menang</span>
                                    @endif
                                </td>

                                <td class="px-4 py-3">
                                    @if ($p->priority)
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-yellow-100 text-yellow-800">⚡
                                            Prioritas</span>
                                        @if ($p->priorityCategory)
                                        <span class="text-sm text-gray-600">{{ $p->priorityCategory->name }}</span>
                                        @endif
                                    </div>
                                    @else
                                    <span class="text-sm text-gray-500">-</span>
                                    @endif
                                </td>

                                <td class="px-4 py-3 text-right">
                                    <div class="inline-flex items-center gap-3">
                                        <a href="{{ route('participants.edit', $p->id) }}"
                                            class="inline-flex items-center gap-2 px-3 py-1.5 bg-white border rounded text-sm text-blue-600 hover:bg-blue-50">Edit</a>

                                        <form action="{{ route('participants.prioritize') }}" method="POST"
                                            class="flex items-center">
                                            @csrf
                                            <input type="hidden" name="participant_id" value="{{ $p->id }}">
                                            <select name="category_id" class="border rounded px-2 py-1 text-sm">
                                                <option value="">-- Pilih kategori --</option>
                                                @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}"
                                                    {{ $p->priority_category_id == $cat->id ? 'selected' : '' }}>
                                                    {{ $cat->name }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit"
                                                class="ml-2 inline-flex items-center gap-2 px-3 py-1.5 bg-yellow-500 text-white rounded text-sm">Set</button>
                                        </form>

                                        <form action="{{ route('participants.destroy', $p->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus peserta ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:underline text-sm">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center space-y-3">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <p class="font-medium text-gray-700">Belum ada peserta</p>
                                        <p class="text-sm text-gray-500">Silakan generate nomor BIB terlebih dahulu</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($participants->total() > 0)
                <div class="flex flex-col md:flex-row items-center justify-between p-4 border-t mt-4">
                    <p class="text-sm text-gray-700">
                        Menampilkan
                        <span class="font-semibold text-blue-600">{{ $participants->firstItem() }}</span>
                        sampai
                        <span class="font-semibold text-blue-600">{{ $participants->lastItem() }}</span>
                        dari
                        <span class="font-semibold text-blue-600">{{ $participants->total() }}</span>
                        peserta
                    </p>

                    <nav class="mt-3 md:mt-0" aria-label="Page navigation">
                        <ul class="inline-flex -space-x-px text-sm">
                            {{-- Previous Page Link --}}
                            @if ($participants->onFirstPage())
                            <li>
                                <span
                                    class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg cursor-not-allowed">Previous</span>
                            </li>
                            @else
                            <li>
                                <a href="{{ $participants->previousPageUrl() }}"
                                    class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700">Previous</a>
                            </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($participants->links()->elements as $element)
                            {{-- Array Of Links --}}
                            @if (is_array($element))
                            @foreach ($element as $page => $url)
                            <li>
                                <a href="{{ $url }}"
                                    class="flex items-center justify-center px-3 h-8 leading-tight {{ $page == $participants->currentPage() ? 'text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700' : 'text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700' }}">
                                    {{ $page }}
                                </a>
                            </li>
                            @endforeach
                            @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($participants->hasMorePages())
                            <li>
                                <a href="{{ $participants->nextPageUrl() }}"
                                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700">Next</a>
                            </li>
                            @else
                            <li>
                                <span
                                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg cursor-not-allowed">Next</span>
                            </li>
                            @endif
                        </ul>
                    </nav>
                </div>
                @endif
            </div>
        </div>

    </div>
</x-app-layout>