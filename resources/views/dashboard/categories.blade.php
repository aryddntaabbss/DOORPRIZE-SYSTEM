<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 flex items-center gap-2">
            <span>Tambah Kategori Hadiah</span>
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

        {{-- Form Tambah Kategori --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-800">Tambah Kategori Baru</h3>
                <p class="text-sm text-gray-500">Buat kategori hadiah untuk doorprize</p>
            </div>

            <form method="POST" action="{{ route('categories.store') }}" class="grid gap-6 md:grid-cols-3">
                @csrf

                <div class="flex flex-col">
                    <label for="name" class="text-sm font-medium text-gray-700 mb-2">Nama Kategori</label>
                    <input type="text" name="name" id="name" placeholder="Contoh: Hadiah Utama"
                        class="border border-gray-300 focus:border-blue-400 focus:ring focus:ring-blue-100 rounded-md text-gray-800 text-sm p-2.5 transition-all"
                        required>
                </div>

                <div class="flex flex-col">
                    <label for="total_winners" class="text-sm font-medium text-gray-700 mb-2">Jumlah Pemenang</label>
                    <input type="number" name="total_winners" id="total_winners" placeholder="Contoh: 3 pemenang"
                        class="border border-gray-300 focus:border-blue-400 focus:ring focus:ring-blue-100 rounded-md text-gray-800 text-sm p-2.5 transition-all"
                        required min="1">
                </div>

                <div class="flex items-end">
                    <button type="submit"
                        class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-md shadow-sm transition-colors focus:outline-none focus:ring-4 focus:ring-blue-200">
                        Tambah Kategori
                    </button>
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-xl shadow-md border border-gray-100">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Daftar Kategori Hadiah</h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-3">No</th>
                                <th scope="col" class="px-6 py-3">Nama Kategori</th>
                                <th scope="col" class="px-6 py-3">Jumlah Pemenang</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($categories as $c)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-800">
                                    {{ $c->name }}
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $c->total_winners }} Pemenang
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($c->is_active)
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Sedang Aktif
                                    </span>
                                    @else
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Tidak Aktif
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center space-y-3">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7">
                                            </path>
                                        </svg>
                                        <p class="font-medium text-gray-700">Belum ada kategori</p>
                                        <p class="text-sm text-gray-500">Tambahkan kategori hadiah terlebih dahulu</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>