<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Dashboard Doorprize</h2>
    </x-slot>

    {{-- Stats Overview
    <div class="p-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                    👥
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Total Peserta</p>
                    <p class="text-xl font-semibold">{{ $totalParticipants ?? 0 }}</p>
    </div>
    </div>
    </div>

    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-500">
                🎁
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Kategori Hadiah</p>
                <p class="text-xl font-semibold">{{ $totalCategories ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                🏆
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Total Pemenang</p>
                <p class="text-xl font-semibold">{{ $totalWinners ?? 0 }}</p>
            </div>
        </div>
    </div>
    </div> --}}

    {{-- Quick Actions --}}
    {{-- <h2 class="text-2xl font-semibold pl-6">Quick Actions</h2> --}}
    <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('participants.index') }}" class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition">
            <div class="flex items-center mb-4">
                <div class="p-3 rounded-full bg-blue-100 text-blue-500">👥</div>
                <h3 class="text-lg font-bold ml-3">Kelola Peserta</h3>
            </div>
            <p class="text-gray-600">Kelola nomor BIB peserta (0001 - 1000)</p>
        </a>

        <a href="{{ route('categories.index') }}" class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition">
            <div class="flex items-center mb-4">
                <div class="p-3 rounded-full bg-green-100 text-green-500">🎁</div>
                <h3 class="text-lg font-bold ml-3">Kategori Hadiah</h3>
            </div>
            <p class="text-gray-600">Atur kategori hadiah dan jumlah pemenang</p>
        </a>

        <a href="{{ route('winners.index') }}" class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition">
            <div class="flex items-center mb-4">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">🏆</div>
                <h3 class="text-lg font-bold ml-3">Data Pemenang</h3>
            </div>
            <p class="text-gray-600">Lihat dan kelola daftar pemenang doorprize</p>
        </a>
    </div>
</x-app-layout>