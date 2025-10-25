<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ config('app.name', 'Ternate Berlari - Doorprize') }}</title>

        <link href="{{ asset('assets/img/ternateberlari.png') }}" rel="icon">
        <link href="{{ asset('assets/img/ternateberlari.png') }}" rel="apple-touch-icon">
        <meta name="author" content="TongIt">

        @livewireStyles

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Display -->
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
        <style>
            @keyframes fadeInDown {
                from {
                    opacity: 0;
                    transform: translateY(-30px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes newWinner {
                0% {
                    transform: scale(0.5);
                    opacity: 0;
                }

                50% {
                    transform: scale(1.1);
                }

                100% {
                    transform: scale(1);
                    opacity: 1;
                }
            }

            @keyframes pulse {

                0%,
                100% {
                    opacity: 1;
                }

                50% {
                    opacity: 0.5;
                }
            }

            @keyframes blink {

                0%,
                100% {
                    opacity: 1;
                }

                50% {
                    opacity: 0.3;
                }
            }

            .animate-fadeInDown {
                animation: fadeInDown 1s ease-out;
            }

            .animate-fadeInUp {
                animation: fadeInUp 0.5s ease-out;
            }

            .animate-newWinner {
                animation: newWinner 1s ease-out;
            }

            .animate-pulse-slow {
                animation: pulse 2s infinite;
            }

            .animate-blink {
                animation: blink 1.5s infinite;
            }
        </style>
    </head>

    <body>
        <!-- Page Content -->
        <main class=" bg-gradient-to-br w-auto from-purple-600 via-purple-700 to-indigo-800 min-h-screen flex
        items-center justify-center p-4 overflow-hidden">
            @yield('body')
        </main>
        @livewireScripts

        <!-- Display -->
        <script>
            let lastWinnerIds = new Set();
                        let isFirstLoad = true;
                
                        function triggerConfetti() {
                            const duration = 3000;
                            const end = Date.now() + duration;
                
                            (function frame() {
                                confetti({
                                    particleCount: 3,
                                    angle: 60,
                                    spread: 55,
                                    origin: { x: 0 },
                                    colors: ['#ffd700', '#00ff88', '#667eea', '#f093fb']
                                });
                                confetti({
                                    particleCount: 3,
                                    angle: 120,
                                    spread: 55,
                                    origin: { x: 1 },
                                    colors: ['#ffd700', '#00ff88', '#667eea', '#f093fb']
                                });
                
                                if (Date.now() < end) {
                                    requestAnimationFrame(frame);
                                }
                            }());
                        }
                
                        async function fetchWinners() {
                            try {
                                const response = await axios.get('/display/fetch');
                                const data = response.data;
                
                                const displayContent = document.getElementById('displayContent');
                
                                if (!data.active) {
                                    displayContent.innerHTML = `
                                        <div class="bg-white/10 backdrop-blur-md rounded-3xl p-12 shadow-2xl animate-pulse-slow">
                                            <div class="flex items-center justify-center gap-3">
                                                <span class="w-3 h-3 bg-green-400 rounded-full animate-blink"></span>
                                                <p class="text-2xl text-white/80">${data.message || 'Menunggu undian dimulai...'}</p>
                                            </div>
                                        </div>
                                    `;
                                    lastWinnerIds.clear();
                                    isFirstLoad = true;
                                    return;
                                }
                
                                const category = data.category;
                                const winners = category.winners || [];
                
                                // Deteksi pemenang baru
                                const currentWinnerIds = new Set(winners.map(w => w.id));
                                const hasNewWinner = !isFirstLoad && winners.some(w => !lastWinnerIds.has(w.id));
                
                                if (hasNewWinner) {
                                    triggerConfetti();
                                }
                
                                // Update lastWinnerIds setelah cek
                                const newWinnerIds = winners.filter(w => !lastWinnerIds.has(w.id)).map(w => w.id);
                                lastWinnerIds = currentWinnerIds;
                                isFirstLoad = false;
                
                                if (winners.length === 0) {
                                    displayContent.innerHTML = `
                                        <div class="bg-white/10 backdrop-blur-md rounded-3xl p-10 shadow-2xl">
                                            <div class="text-4xl font-bold text-yellow-300 mb-6 drop-shadow-lg">
                                                ${category.name}
                                            </div>
                                            <div class="flex items-center justify-center gap-3">
                                                <span class="w-3 h-3 bg-green-400 rounded-full animate-blink"></span>
                                                <p class="text-2xl text-white/80">Menunggu pengundian...</p>
                                            </div>
                                        </div>
                                    `;
                                    return;
                                }
                
                                let html = `
                                    <div class="bg-white/10 backdrop-blur-md rounded-3xl p-8 md:p-10 shadow-2xl">
                                        <div class="text-3xl md:text-4xl lg:text-5xl font-bold text-yellow-300 mb-8 drop-shadow-lg">
                                            ${category.name}
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                                `;
                
                                winners.forEach((winner, index) => {
                                    const isNew = newWinnerIds.includes(winner.id);
                                    html += `
                                        <div class="bg-white/15 backdrop-blur-sm rounded-2xl p-6 shadow-xl transition-all duration-300 hover:scale-105 hover:shadow-2xl ${isNew ? 'animate-newWinner' : ''}">
                                            <div class="text-sm text-purple-200 mb-2">
                                                Pemenang ${index + 1}
                                            </div>
                                            <div class="text-4xl md:text-5xl font-bold text-green-300 my-4 drop-shadow-lg font-mono">
                                                ${winner.bib_number}
                                            </div>
                                            <div class="text-sm text-purple-300 flex items-center justify-center gap-2">
                                                <span>⏰</span>
                                                <span>${winner.created_at}</span>
                                            </div>
                                        </div>
                                    `;
                                });
                
                                html += `
                                        </div>
                                    </div>
                                `;
                
                                displayContent.innerHTML = html;
                
                            } catch (error) {
                                console.error('Error fetching winners:', error);
                            }
                        }
                
                        // Refresh setiap 2 detik
                        setInterval(fetchWinners, 2000);
                        
                        // Load pertama kali
                        fetchWinners();
        </script>
    </body>

</html>