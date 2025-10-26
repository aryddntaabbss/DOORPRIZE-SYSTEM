<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Edit Peserta</h2>
    </x-slot>

    <div class="p-6">
        @if(session('success'))
        <div class="mb-4 text-green-700 bg-green-50 border border-green-200 p-4 rounded">{{ session('success') }}</div>
        @endif

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('participants.update', $participant->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nomor BIB</label>
                        <input type="text" name="bib_number" value="{{ old('bib_number', $participant->bib_number) }}"
                            class="w-full border rounded p-2">
                        @error('bib_number')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" name="name" value="{{ old('name', $participant->name) }}"
                            class="w-full border rounded p-2">
                        @error('name')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Prioritaskan untuk kategori</label>
                        <select name="priority_category_id" class="w-full border rounded p-2">
                            <option value="">-- Tidak ada --</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ $participant->priority_category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center gap-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="priority" value="1"
                                {{ $participant->priority ? 'checked' : '' }} class="mr-2"> Prioritas aktif
                        </label>
                    </div>

                    <div>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                        <a href="{{ route('participants.index') }}" class="ml-2 text-gray-600">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>