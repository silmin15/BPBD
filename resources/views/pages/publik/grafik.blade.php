@extends('layouts.app_publik')
@section('content')
<main class="py-4">
    <div class="container-xxl">
        <div class="row g-4">
            <!-- Statistik Overview -->
            <div class="col-12">
                <div class="card-lite">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Statistik Bencana Banjarnegara</h4>
                        <div class="row g-3" id="statsOverview">
                            <!-- Stats will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grafik Per Tahun -->
            <div class="col-lg-8">
                <div class="card-lite">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Trend Bencana Per Tahun</h5>
                            <div class="btn-group" role="group">
                                <input type="radio" class="btn-check" name="chartType" id="chartLine" value="line" checked>
                                <label class="btn btn-outline-primary btn-sm" for="chartLine">Garis</label>
                                <input type="radio" class="btn-check" name="chartType" id="chartBar" value="bar">
                                <label class="btn btn-outline-primary btn-sm" for="chartBar">Bar</label>
                            </div>
                        </div>
                        <canvas id="chartPerTahun"></canvas>
                    </div>
                </div>
            </div>

            <!-- Grafik Per Jenis -->
            <div class="col-lg-4">
                <div class="card-lite">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Distribusi Jenis Bencana</h5>
                        <canvas id="chartJenis"></canvas>
                    </div>
                </div>
            </div>

            <!-- Grafik Per Kecamatan -->
            <div class="col-12">
                <div class="card-lite">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Bencana Per Kecamatan</h5>
                        <canvas id="chartKecamatan"></canvas>
                    </div>
                </div>
            </div>

            <!-- Heatmap Bulanan -->
            <div class="col-12">
                <div class="card-lite">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Heatmap Bencana Bulanan</h5>
                        <div id="heatmapContainer" style="height: 400px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; border-radius: 8px; color: #6c757d;">
                            <!-- Placeholder or future heatmap content -->
                            <p>Fungsionalitas Heatmap Bulanan akan ditambahkan di sini (membutuhkan library tambahan).</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('styles')
<style>
    .card-lite {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
    }

    .stat-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        height: 100%;
        /* Ensure cards take equal height in a row */
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .stat-card.success {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    .stat-card.warning {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }

    .stat-card.danger {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 0.9rem;
        opacity: 0.9;
    }

    /* === START OF FIX FOR CHART SCROLLING/STRETCHING BUG === */

    /* Ensure card-body has relative position for absolute positioned charts if needed,
       and define its minimum height if the content within canvas is not enough to dictate it. */
    .card-body {
        position: relative;
        /* min-height: 200px; */
        /* Uncomment if charts still appear too short initially */
    }

    /* Crucial: Explicitly set height for canvas elements.
       The !important is often needed to override inline styles or Chart.js defaults. */
    canvas {
        height: 300px !important;
        /* Default height for most charts */
        width: 100% !important;
        /* Ensure it takes full width of its parent */
        /* max-height: 400px; */
        /* You can add a max-height if 300px is too much on larger screens */
    }

    /* Specific height for the horizontal bar chart (Kecamatan) */
    #chartKecamatan {
        height: 250px !important;
        /* Slightly different height for horizontal bar chart */
    }

    /* For Doughnut chart in a smaller column, adjust its height to fit */
    @media (min-width: 992px) {
        #chartJenis {
            height: 300px !important;
            /* Consistent height for side-by-side charts */
        }
    }

    /* === END OF FIX FOR CHART SCROLLING/STRETCHING BUG === */
</style>
@endpush

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Chart.js Plugins -->
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let chartPerTahun, chartJenis, chartKecamatan;

        Chart.register(ChartDataLabels);

        loadStatistics();

        // Delaying chart loading slightly can sometimes help with rendering issues
        setTimeout(() => {
            loadChartPerTahun();
            loadChartJenis();
            loadChartKecamatan();
            console.log("Heatmap Bulanan placeholder loaded. Actual heatmap implementation needed.");
        }, 100);

        document.querySelectorAll('input[name="chartType"]').forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    loadChartPerTahun(this.value);
                }
            });
        });

        function loadStatistics() {
            fetch('/api/kejadian-bencana/statistics')
                .then(res => {
                    if (!res.ok) {
                        throw new Error(`HTTP error! status: ${res.status}`);
                    }
                    return res.json();
                })
                .then(data => {
                    if (data.status === 'success') {
                        displayStatistics(data.data);
                    } else {
                        console.error('API Error (Statistics):', data.message);
                    }
                })
                .catch(err => {
                    console.error('Error loading statistics:', err);
                    document.getElementById('statsOverview').innerHTML = `<p class="text-danger">Gagal memuat statistik. Silakan coba lagi nanti.</p>`;
                });
        }

        function displayStatistics(stats) {
            const container = document.getElementById('statsOverview');
            container.innerHTML = `
            <div class="col-md-3 col-sm-6">
                <div class="stat-card success">
                    <div class="stat-number">${stats.total_kejadian || 0}</div>
                    <div class="stat-label">Total Kejadian</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card warning">
                    <div class="stat-number">${stats.jenis_bencana_unik || 0}</div>
                    <div class="stat-label">Jenis Bencana Unik</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card danger">
                    <div class="stat-number">${stats.kecamatan_terdampak || 0}</div>
                    <div class="stat-label">Kecamatan Terdampak</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-number">${stats.tahun_terakhir || new Date().getFullYear()}</div>
                    <div class="stat-label">Tahun Terakhir</div>
                </div>
            </div>
        `;
        }

        function loadChartPerTahun(type = 'line') {
            fetch('/api/kejadian-bencana/statistics/yearly')
                .then(res => {
                    if (!res.ok) {
                        throw new Error(`HTTP error! status: ${res.status}`);
                    }
                    return res.json();
                })
                .then(data => {
                    if (data.status === 'success' && data.data) {
                        const ctx = document.getElementById('chartPerTahun').getContext('2d');

                        if (chartPerTahun) chartPerTahun.destroy();

                        chartPerTahun = new Chart(ctx, {
                            type: type,
                            data: {
                                labels: data.data.labels,
                                datasets: [{
                                    label: 'Jumlah Kejadian',
                                    data: data.data.values,
                                    borderColor: '#3b82f6',
                                    backgroundColor: type === 'bar' ? 'rgba(59, 130, 246, 0.6)' : 'rgba(59, 130, 246, 0.2)',
                                    borderWidth: 2,
                                    fill: type === 'line',
                                    tension: 0.4
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: false
                                    },
                                    datalabels: {
                                        color: '#333',
                                        anchor: 'end',
                                        align: 'top',
                                        formatter: (value) => value > 0 ? value : '',
                                        font: {
                                            weight: 'bold',
                                            size: 10
                                        }
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        grid: {
                                            color: 'rgba(0,0,0,0.1)'
                                        },
                                        ticks: {
                                            callback: function(value) {
                                                if (value % 1 === 0) return value;
                                            }
                                        }
                                    },
                                    x: {
                                        grid: {
                                            display: false
                                        }
                                    }
                                }
                            }
                        });
                    } else {
                        console.error('API Error (Yearly Chart):', data.message || 'No data returned.');
                    }
                })
                .catch(err => console.error('Error loading yearly chart:', err));
        }

        function loadChartJenis() {
            fetch('/api/kejadian-bencana/statistics/by-type')
                .then(res => {
                    if (!res.ok) {
                        throw new Error(`HTTP error! status: ${res.status}`);
                    }
                    return res.json();
                })
                .then(data => {
                    if (data.status === 'success' && data.data) {
                        const ctx = document.getElementById('chartJenis').getContext('2d');

                        if (chartJenis) chartJenis.destroy();

                        chartJenis = new Chart(ctx, {
                            type: 'doughnut',
                            data: {
                                labels: data.data.labels,
                                datasets: [{
                                    data: data.data.values,
                                    backgroundColor: [
                                        '#3b82f6', '#f59e0b', '#ef4444', '#f97316',
                                        '#06b6d4', '#eab308', '#8b5cf6', '#10b981', '#6b7280'
                                    ],
                                    borderWidth: 2,
                                    borderColor: '#fff'
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                        labels: {
                                            padding: 20,
                                            usePointStyle: true,
                                            boxWidth: 10,
                                            font: {
                                                size: 10
                                            }
                                        }
                                    },
                                    datalabels: {
                                        color: '#fff',
                                        textAlign: 'center',
                                        font: {
                                            weight: 'bold',
                                            size: 10
                                        },
                                        formatter: (value, ctx) => {
                                            let sum = 0;
                                            let dataArr = ctx.chart.data.datasets[0].data;
                                            dataArr.map(data => {
                                                sum += data;
                                            });
                                            let percentage = (value * 100 / sum).toFixed(1) + '%';
                                            return percentage;
                                        }
                                    }
                                }
                            }
                        });
                    } else {
                        console.error('API Error (Jenis Chart):', data.message || 'No data returned.');
                    }
                })
                .catch(err => console.error('Error loading jenis chart:', err));
        }

        function loadChartKecamatan() {
            fetch('/api/kejadian-bencana/statistics/by-kecamatan')
                .then(res => {
                    if (!res.ok) {
                        throw new Error(`HTTP error! status: ${res.status}`);
                    }
                    return res.json();
                })
                .then(data => {
                    if (data.status === 'success' && data.data) {
                        const ctx = document.getElementById('chartKecamatan').getContext('2d');

                        if (chartKecamatan) chartKecamatan.destroy();

                        const sortedData = data.data.labels.map((label, index) => ({
                            label: label,
                            value: data.data.values[index]
                        })).sort((a, b) => b.value - a.value);

                        const sortedLabels = sortedData.map(item => item.label);
                        const sortedValues = sortedData.map(item => item.value);

                        chartKecamatan = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: sortedLabels,
                                datasets: [{
                                    label: 'Jumlah Kejadian',
                                    data: sortedValues,
                                    backgroundColor: 'rgba(59, 130, 246, 0.8)',
                                    borderColor: '#3b82f6',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                indexAxis: 'y',
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: false
                                    },
                                    datalabels: {
                                        color: '#333',
                                        anchor: 'end',
                                        align: 'right',
                                        offset: 4,
                                        formatter: (value) => value > 0 ? value : '',
                                        font: {
                                            weight: 'bold',
                                            size: 10
                                        }
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        grid: {
                                            display: false
                                        }
                                    },
                                    x: {
                                        grid: {
                                            color: 'rgba(0,0,0,0.1)'
                                        },
                                        ticks: {
                                            callback: function(value) {
                                                if (value % 1 === 0) return value;
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    } else {
                        console.error('API Error (Kecamatan Chart):', data.message || 'No data returned.');
                    }
                })
                .catch(err => console.error('Error loading kecamatan chart:', err));
        }
    });
</script>
@endpush