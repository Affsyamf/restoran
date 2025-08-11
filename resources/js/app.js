import './bootstrap';

// Impor Alpine.js untuk fungsionalitas sidebar
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Impor Chart.js
import Chart from 'chart.js/auto';

// Jalankan kode ini setelah halaman selesai dimuat
document.addEventListener('DOMContentLoaded', function () {
    
    // Cari elemen canvas untuk grafik
    const chartCanvas = document.getElementById('weeklyRevenueChart');
    
    // Jika elemen canvas ada di halaman ini, maka buat grafiknya
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
                            callback: function(value) {
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