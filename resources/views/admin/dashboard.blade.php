<x-layouts.admin>
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
        <p class="mt-1 text-sm text-gray-600">Selamat datang kembali, {{ auth()->user()->name }}!</p>
    </div>

    {{-- Grid untuk Kartu Statistik --}}
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        
        <!-- Kartu Total Pengguna -->
        <div class="bg-white overflow-hidden shadow rounded-lg p-5">
            <dt class="text-sm font-medium text-gray-500 truncate">Total Pengguna</dt>
            <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ $userCount }}</dd>
        </div>

        <!-- Kartu Total Menu -->
        <div class="bg-white overflow-hidden shadow rounded-lg p-5">
            <dt class="text-sm font-medium text-gray-500 truncate">Total Menu</dt>
            <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ $menuCount }}</dd>
        </div>

        <!-- Kartu Total Pesanan -->
        <div class="bg-white overflow-hidden shadow rounded-lg p-5">
            <dt class="text-sm font-medium text-gray-500 truncate">Total Pesanan</dt>
            <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ $orderCount }}</dd>
        </div>

        <!-- KARTU BARU: Total Pendapatan -->
        <div class="bg-white overflow-hidden shadow rounded-lg p-5">
            <dt class="text-sm font-medium text-gray-500 truncate">Total Pendapatan</dt>
            <dd class="mt-1 text-3xl font-semibold text-green-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</dd>
        </div>
    </div>

    {{-- PANEL GRAFIK PENDAPATAN MINGGUAN --}}
    <div class="mt-8 bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <h3 class="text-lg font-medium text-gray-900">Pendapatan dalam 7 Hari Terakhir</h3>
            <div class="mt-4">
                <canvas 
                    id="weeklyRevenueChart" 
                    height="100"
                    data-labels="{{ json_encode($chartLabels) }}"
                    data-data="{{ json_encode($chartData) }}"
                ></canvas>
            </div>
        </div>
    </div>

    {{-- Grid untuk Panel Aktivitas Terbaru --}}
    <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Panel Menu Terbaru --}}
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <h3 class="text-lg font-medium text-gray-900">Menu Terbaru Ditambahkan</h3>
                <div class="mt-4 flow-root">
                    <ul role="list" class="-my-5 divide-y divide-gray-200">
                        @forelse($recentMenus as $menu)
                            <li class="py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        @if ($menu->gambar)
                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama_menu }}">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-xs">?</div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $menu->nama_menu }}</p>
                                        <p class="text-sm text-gray-500 truncate">{{ $menu->kategori }}</p>
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.menus.edit', $menu->id) }}" class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50">
                                            Edit
                                        </a>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="py-4 text-sm text-gray-500">Belum ada menu yang ditambahkan.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
        {{-- Panel Pengguna Baru --}}
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <h3 class="text-lg font-medium text-gray-900">Pengguna Baru Bergabung</h3>
                <div class="mt-4 flow-root">
                    <ul role="list" class="-my-5 divide-y divide-gray-200">
                        @forelse($recentUsers as $user)
                            <li class="py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $user->name }}</p>
                                        <p class="text-sm text-gray-500 truncate">{{ $user->email }}</p>
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50">
                                            Edit
                                        </a>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="py-4 text-sm text-gray-500">Belum ada pengguna baru.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    {{-- SCRIPT UNTUK MENGGAMBAR GRAFIK (DIPERBARUI) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const chartCanvas = document.getElementById('weeklyRevenueChart');
            if (chartCanvas) {
                const labels = JSON.parse(chartCanvas.dataset.labels || '[]');
                const data = JSON.parse(chartCanvas.dataset.data || '[]');

                const ctx = chartCanvas.getContext('2d');
                const weeklyRevenueChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Pendapatan (Rp)',
                            data: data,
                            backgroundColor: 'rgba(22, 163, 74, 0.1)',
                            borderColor: 'rgba(22, 163, 74, 1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    // HAPUS stepSize: 1 dari sini
                                    callback: function(value, index, values) {
                                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                    }
                                }
                            }
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        if (context.parsed.y !== null) {
                                            label += 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                                        }
                                        return label;
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
</x-layouts.admin>
