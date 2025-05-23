@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    
    <!-- Summary Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <h4>{{ $totalSuratMasuk ?? 0 }}</h4>
                    <div>Total Surat Masuk</div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('surat-masuk.index') }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <h4>{{ $suratMasukBulanIni ?? 0 }}</h4>
                    <div>Surat Masuk Bulan Ini</div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('surat-masuk.index', ['start_date' => $startOfMonth ?? '', 'end_date' => $endOfMonth ?? '']) }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <h4>{{ $suratMasukMingguIni ?? 0 }}</h4>
                    <div>Surat Masuk Minggu Ini</div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('surat-masuk.index', ['start_date' => $startOfWeek ?? '', 'end_date' => $endOfWeek ?? '']) }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                    <h4>{{ $suratMasukHariIni ?? 0 }}</h4>
                    <div>Surat Masuk Hari Ini</div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('surat-masuk.index', ['start_date' => $today ?? '', 'end_date' => $today ?? '']) }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Charts Row -->
    <div class="row">
        <!-- Monthly Chart -->
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Surat Masuk Per Bulan ({{ date('Y') }})
                </div>
                <div class="card-body">
                    <canvas id="monthlyChart" width="100%" height="40"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Pengirim Chart -->
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-pie me-1"></i>
                    Top 5 Pengirim Surat
                </div>
                <div class="card-body">
                    <canvas id="pengirimChart" width="100%" height="40"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Incoming Letters -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Surat Masuk Terbaru
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No. Surat</th>
                            <th>Pengirim</th>
                            <th>Asal Surat</th>
                            <th>Tanggal Surat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentSuratMasuk ?? [] as $surat)
                        <tr>
                            <td>{{ $surat->no_surat }}</td>
                            <td>{{ $surat->pengirim }}</td>
                            <td>{{ $surat->asal_surat }}</td>
                            <td>{{ \Carbon\Carbon::parse($surat->tgl_surat)->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('surat-masuk.edit', $surat->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($surat->file)
                                <a href="{{ route('surat-masuk.view-file', $surat->id) }}" class="btn btn-sm btn-info" target="_blank">
                                    <i class="fas fa-file"></i>
                                </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data surat masuk terbaru</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mt-3">
                <a href="{{ route('surat-masuk.index') }}" class="btn btn-primary">Lihat Semua Surat Masuk</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
    // Monthly Chart
    var monthlyCtx = document.getElementById('monthlyChart');
    var monthlyChart = new Chart(monthlyCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($monthlyLabels ?? []) !!},
            datasets: [{
                label: 'Jumlah Surat Masuk',
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                data: {!! json_encode($monthlyData ?? []) !!},
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
    
    // Pengirim Chart
    var pengirimCtx = document.getElementById('pengirimChart');
    var pengirimChart = new Chart(pengirimCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($topPengirimLabels ?? []) !!},
            datasets: [{
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1,
                data: {!! json_encode($topPengirimData ?? []) !!},
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
</script>
@endsection