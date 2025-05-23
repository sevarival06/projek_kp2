@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Surat Masuk</h1>
    </div>

    <!-- Cards Overview -->
    <div class="row">
        <!-- Surat Masuk Hari Ini -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Surat Masuk Hari Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $suratMasukHariIni }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Surat Masuk Bulan Ini -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Surat Masuk Bulan Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $suratMasukBulanIni }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Surat Masuk Tahun Ini -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Surat Masuk Tahun Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $suratMasukTahunIni }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Surat Masuk -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Surat Masuk</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalSuratMasuk }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="row">
        <!-- Bar Chart Surat Masuk Per Bulan -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Surat Masuk Perbulan</h6>
                    <div class="dropdown no-arrow">
                        <select id="tahun-filter" class="form-control form-control-sm">
                            @foreach ($tahunList as $tahun)
                                <option value="{{ $tahun }}" {{ $tahun == $tahunIni ? 'selected' : '' }}>
                                    {{ $tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="barChartBulanan"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Top 5 Pengirim Surat</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="pieChartPengirim"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        @foreach ($labelsChart as $index => $label)
                            <span class="mr-2">
                                <i class="fas fa-circle text-{{ ['primary', 'success', 'info', 'warning', 'danger'][$index % 5] }}"></i> {{ \Illuminate\Support\Str::limit($label, 15) }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Surat Masuk -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Surat Masuk Terbaru</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No. Agenda</th>
                                    <th>No. Surat</th>
                                    <th>Pengirim</th>
                                    <th>Tanggal Surat</th>
                                    <th>Isi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(App\Models\SuratMasuk::orderBy('tgl_surat', 'desc')->take(5)->get() as $surat)
                                <tr>
                                    <td>{{ $surat->no_agenda }}</td>
                                    <td>{{ $surat->no_surat }}</td>
                                    <td>{{ $surat->pengirim }}</td>
                                    <td>{{ \Carbon\Carbon::parse($surat->tgl_surat)->format('d-m-Y') }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($surat->isi, 50) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// ------------------------------
// Inisialisasi Variabel Chart
// ------------------------------
let barChart;
let pieChart;

// ------------------------------
// Nama Bulan Untuk Label
// ------------------------------
const namaBulan = [
    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
];

// ------------------------------
// Warna untuk Chart
// ------------------------------
const backgroundColors = [
    'rgba(54, 162, 235, 0.5)',
    'rgba(255, 99, 132, 0.5)',
    'rgba(255, 206, 86, 0.5)',
    'rgba(75, 192, 192, 0.5)',
    'rgba(153, 102, 255, 0.5)',
];

const borderColors = [
    'rgba(54, 162, 235, 1)',
    'rgba(255, 99, 132, 1)',
    'rgba(255, 206, 86, 1)',
    'rgba(75, 192, 192, 1)',
    'rgba(153, 102, 255, 1)',
];

// ------------------------------
// Data Awal Chart
// ------------------------------
// Bar Chart - Surat Per Bulan
const initialBarData = {
    labels: namaBulan,
    datasets: [{
        label: 'Jumlah Surat Masuk Tahun {{ $tahunIni }}',
        data: [
            @foreach($dataBulan as $bulan => $jumlah)
                {{ $jumlah }},
            @endforeach
        ],
        backgroundColor: 'rgba(54, 162, 235, 0.5)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
    }]
};

// Pie Chart - Top 5 Pengirim
const initialPieData = {
    labels: [
        @foreach($labelsChart as $label)
            '{{ \Illuminate\Support\Str::limit($label, 15) }}',
        @endforeach
    ],
    datasets: [{
        data: [
            @foreach($dataChart as $data)
                {{ $data }},
            @endforeach
        ],
        backgroundColor: backgroundColors,
        borderColor: borderColors,
        borderWidth: 1
    }]
};

// ------------------------------
// Fungsi untuk Membuat Chart
// ------------------------------
function createBarChart() {
    const barCtx = document.getElementById('barChartBulanan').getContext('2d');
    
    barChart = new Chart(barCtx, {
        type: 'bar',
        data: initialBarData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Jumlah Surat Masuk Per Bulan Tahun {{ $tahunIni }}'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0
                    }
                }
            }
        }
    });
}

function createPieChart() {
    const pieCtx = document.getElementById('pieChartPengirim').getContext('2d');
    
    pieChart = new Chart(pieCtx, {
        type: 'pie',
        data: initialPieData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.dataset.data.reduce((acc, data) => acc + data, 0);
                            const percentage = Math.round((value / total) * 100);
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
}

// ------------------------------
// Fungsi untuk Update Chart
// ------------------------------
function updateBarChart(tahun) {
    fetch(`/dashboard/data/${tahun}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Update chart data
            barChart.data.datasets[0].label = `Jumlah Surat Masuk Tahun ${data.tahun}`;
            barChart.data.datasets[0].data = data.data;
            barChart.options.plugins.title.text = `Jumlah Surat Masuk Per Bulan Tahun ${data.tahun}`;
            barChart.update();
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            alert('Gagal mengambil data. Silakan coba lagi.');
        });
}

// ------------------------------
// Event Listener
// ------------------------------
document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi Chart
    createBarChart();
    createPieChart();
    
    // Event listener untuk filter tahun
    document.getElementById('tahun-filter').addEventListener('change', function() {
        updateBarChart(this.value);
    });
});
</script>
@endpush