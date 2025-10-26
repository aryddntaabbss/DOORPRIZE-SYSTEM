<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ config('app.name', 'Doorprize Display') }}</title>

        @vite('resources/css/app.css')

        <style>
            html,
            body {
                height: 100%;
                margin: 0;
                overflow: hidden;
            }

            body {
                font-family: 'Poppins', sans-serif;
                color: white;
            }

            main {
                min-height: 100vh;
                background-position: center;
                background-size: cover;
                position: relative;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }

            /* Overlay gradasi */
            .overlay {
                position: absolute;
                inset: 0;
                background: linear-gradient(to bottom right, rgba(99, 155, 17, 0.65), rgba(175, 133, 7, 0.65));
                z-index: 1;
            }

            .content-wrapper {
                position: relative;
                z-index: 2;
                width: 100%;
                max-width: 1920px;
                padding: 2rem;
                text-align: center;
            }

            .logo-container img {
                width: 150px;
                height: auto;
                margin: 0 auto 1.5rem;
            }

            .category-title {
                font-size: 2.5rem;
                font-weight: 700;
                color: #fde047;
                text-shadow: 0 0 12px rgba(0, 0, 0, 0.5);
                margin-bottom: 1.5rem;
            }

            .scroll-wrapper {
                display: flex;
                overflow: hidden;
                white-space: nowrap;
                position: relative;
            }

            .scroll-content {
                display: flex;
                animation: scroll 120s linear infinite;
            }

            /* Animasi jalan tanpa putus */
            @keyframes scroll {
                from {
                    transform: translateX(0);
                }

                to {
                    transform: translateX(-50%);
                }
            }

            .winner-card {
                flex: 0 0 auto;
                width: 280px;
                margin-right: 1.5rem;
                background: rgba(255, 255, 255, 0.471);
                border-radius: 1.25rem;
                padding: 1.5rem;
                text-align: center;
                backdrop-filter: blur(6px);
                transition: transform 0.9s ease;
                box-shadow: 0 0 15px rgba(255, 255, 255, 0.222);
            }

            .winner-card:hover {
                transform: scale(1.05);
            }

            .winner-card .bib {
                font-size: 2.5rem;
                font-weight: bold;
                color: #4ade80;
            }

            .winner-card .name {
                font-size: 1.1rem;
                color: #e2e8f0;
                margin-top: 0.5rem;
            }
        </style>
    </head>

    <body>
        @php
        $bgUrl = isset($background) && $background ? asset('storage/' . $background) : null;
        $logoUrl = isset($logo) && $logo ? asset('storage/' . $logo) : null;
        @endphp

        <main style="background-image: url('{{ $bgUrl ?? '' }}');">
            <div class="overlay"></div>

            <div class="content-wrapper">
                @if ($logoUrl)
                <div class="logo-container">
                    <img src="{{ $logoUrl }}" alt="Logo Event">
                </div>
                @endif

                <div class="category-title" id="categoryTitle">Menunggu undian dimulai...</div>

                <div class="scroll-wrapper">
                    <div id="scrollContent" class="scroll-content"></div>
                </div>
            </div>
        </main>

        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        @vite('resources/js/app.js')
        @stack('scripts')
    </body>

</html>