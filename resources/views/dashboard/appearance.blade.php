<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pengaturan Tampilan
        </h2>
    </x-slot>

    <div class="p-6 bg-gray-100 rounded-lg">
        @if(session('success'))
        <div class="mb-4 text-green-700 bg-green-50 border border-green-200 p-4 rounded">{{ session('success') }}</div>
        @endif

        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('appearance.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Logo (gambar)</label>
                        @if ($logo)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $logo) }}" alt="Logo"
                                class="h-24 object-contain border rounded">
                        </div>
                        @endif
                        <input type="file" name="logo" accept="image/*"
                            class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        @error('logo') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Background (gambar)</label>
                        @if ($background)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $background) }}" alt="Background"
                                class="w-full h-48 object-cover rounded">
                        </div>
                        @endif
                        <input type="file" name="background" accept="image/*"
                            class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        @error('background') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-md shadow">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>