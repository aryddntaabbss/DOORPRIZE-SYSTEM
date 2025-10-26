@extends('layouts.display')

@section('content')
@endsection

@push('scripts')
<script>
    async function fetchWinners() {
    try {
        const response = await axios.get('/display/fetch');
        const data = response.data;

        const scrollContent = document.getElementById('scrollContent');
        const categoryTitle = document.getElementById('categoryTitle');

        if (!data.active) {
            categoryTitle.innerText = data.message || 'Menunggu undian dimulai...';
            scrollContent.innerHTML = '';
            return;
        }

        const category = data.category;
        const winners = category.winners || [];

        categoryTitle.innerText = category.name;

        // Gandakan konten agar animasi tidak pernah putus
        let html = '';
        for (let i = 0; i < 2; i++) {
            winners.forEach((winner, index) => {
                html += `
                    <div class="winner-card">
                        <div class="text-sm font-semibold uppercase text-white mb-2">
                            Pemenang ${index + 1}
                        </div>
                        <div class="bib">${winner.bib_number}</div>
                        <div class="name">${winner.name || ''}</div>
                    </div>
                `;
            });
        }

        scrollContent.innerHTML = html;

    } catch (error) {
        console.error('Error fetching winners:', error);
    }
}

// Panggil pertama kali & perbarui tiap 10 detik
fetchWinners();
setInterval(fetchWinners, 10000);
</script>
@endpush