@extends('layouts.display')

@section('body')
<div>
    <div class="max-w-7xl w-full text-center relative z-10">
        <!-- Header -->
        <div class="mb-10 animate-fadeInDown">
            <img src="{{ asset('assets/img/ternateberlari.png') }}" alt="Logo" class="h-20 mx-auto">
            {{-- <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-white drop-shadow-2xl mb-2">
                🎉 Doorprize Event 🎉
            </h1>
            <p class="text-xl text-purple-200">Selamat kepada para pemenang!</p> --}}
        </div>

        <!-- Display Content -->
        <div id="displayContent">
            <div class="bg-white/10 backdrop-blur-md rounded-3xl p-12 shadow-2xl animate-pulse-slow">
                <div class="flex items-center justify-center gap-3">
                    <span class="w-3 h-3 bg-green-400 rounded-full animate-blink"></span>
                    <p class="text-2xl text-white/80">Menunggu undian dimulai...</p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection