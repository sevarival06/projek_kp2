@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Surat Masuk</h6>
            <div class="dropdown no-arrow d-flex">
            <a href="{{ route('surat-masuk.create') }}" class="btn btn-primary btn-sm mr-2">
                <i class="fas fa-plus fa-sm"></i> Tambah Surat Masuk
            </a>
            <a href="{{ route('surat-masuk.print') }}" class="btn btn-success btn-sm" target="_blank">
                <i class="fas fa-print fa-sm"></i> Cetak Laporan
            </a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Search and Filter Section -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('surat-masuk.index') }}" method="GET" id="filter-form">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="search">Cari:</label>
                                            <input type="text" class="form-control" id="search" name="search" 
                                                    placeholder="No. Surat, Pengirim, dll" value="{{ request('search') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="tahun">Tahun:</label>
                                            <select class="form-control" id="tahun" name="tahun">
                                                <option value="">Semua Tahun</option>
                                                @php
                                                    $currentYear = date('Y');
                                                    $startYear = $currentYear - 5; // Show 5 years back
                                                @endphp
                                                @for ($year = $currentYear; $year >= $startYear; $year--)
                                                    <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="start_date">Tanggal Mulai:</label>
                                            <input type="date" class="form-control date-input" id="start_date" name="start_date" value="{{ request('start_date') }}" onfocus="this.showPicker()">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="end_date">Tanggal Akhir:</label>
                                            <input type="date" class="form-control date-input" id="end_date" name="end_date" value="{{ request('end_date') }}" onfocus="this.showPicker()">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <div class="d-flex">
                                                <button type="submit" class="btn btn-primary mr-2">Filter</button>
                                                <a href="{{ route('surat-masuk.index') }}" class="btn btn-secondary">Reset</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Download Button - Only show when filter is applied -->
            @if(request('search') || request('tahun') || request('start_date') || request('end_date'))
            <div class="row mb-3">
                <div class="col-md-12 text-right">
                    <form action="{{ url('/surat-masuk/download-files') }}" method="POST" class="d-inline">
                        @csrf
                        <!-- Parameter filter yang sedang digunakan -->
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <input type="hidden" name="tahun" value="{{ request('tahun') }}">
                        <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                        <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                        
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-file-archive mr-1"></i> Unduh Semua PDF
                        </button>
                    </form>
                </div>
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th class="sortable" data-sort="no_agenda">No. Agenda <i class="fas fa-sort"></i></th>
                            <th class="sortable" data-sort="no_surat">No. Surat <i class="fas fa-sort"></i></th>
                            <th class="sortable" data-sort="klasifikasi_surat">Klasifikasi Surat <i class="fas fa-sort"></i></th>
                            <th class="sortable" data-sort="pengirim">Pengirim <i class="fas fa-sort"></i></th>
                            <th class="sortable" data-sort="asal_surat">Asal Surat <i class="fas fa-sort"></i></th>
                            <th class="sortable" data-sort="tgl_surat">Tanggal Surat <i class="fas fa-sort"></i></th>
                            <th class="sortable" data-sort="tgl_agenda">Tanggal Agenda <i class="fas fa-sort"></i></th>
                            <th>File</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($suratMasuk as $index => $surat)
                        <tr>
                            <td>{{ ($suratMasuk->currentPage() - 1) * $suratMasuk->perPage() + $index + 1 }}</td>
                            <td>{{ $surat->no_agenda }}</td>
                            <td>{{ $surat->no_surat }}</td>
                            <td>{{ $surat->klasifikasi_surat }}</td> <!-- Tambahkan ini -->
                            <td>{{ $surat->pengirim }}</td>
                            <td>{{ $surat->asal_surat }}</td>
                            <td>{{ date('d-m-Y', strtotime($surat->tgl_surat)) }}</td>
                            <td>{{ date('d-m-Y', strtotime($surat->tgl_agenda)) }}</td>
                            <td>
                                @if($surat->file)
                                    <a href="{{ asset('storage/surat_masuk/' . $surat->file) }}" class="btn btn-sm btn-info" target="_blank">
                                        <i class="fas fa-file-pdf"></i> Lihat
                                    </a>
                                @else
                                    <span class="badge badge-secondary">Tidak ada file</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('surat-masuk.show', $surat->id_surat) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('surat-masuk.edit', $surat->id_surat) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('surat-masuk.print.disposisi', $surat->id_surat) }}" class="btn btn-success btn-sm" target="_blank">
                                    <i class="fas fa-print"></i>
                                </a>
                                <form action="{{ route('surat-masuk.destroy', $surat->id_surat) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="pagination-container mt-4">
                @if ($suratMasuk->hasPages())
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-circle justify-content-center">
                            <!-- Previous Page Link -->
                            @if ($suratMasuk->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link" aria-hidden="true">
                                        <i class="fas fa-chevron-left"></i>
                                    </span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $suratMasuk->previousPageUrl() }}" aria-label="Previous">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                            @endif

                            <!-- Pagination Elements -->
                            @php
                                $currentPage = $suratMasuk->currentPage();
                                $lastPage = $suratMasuk->lastPage();
                                $range = 2; // Show 2 pages before and after current page
                            @endphp

                            <!-- First Page -->
                            @if($currentPage > ($range + 1))
                                <li class="page-item">
                                    <a class="page-link" href="{{ $suratMasuk->url(1) }}">1</a>
                                </li>
                                @if($currentPage > ($range + 2))
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                @endif
                            @endif

                            <!-- Page Range -->
                            @for($i = max(1, $currentPage - $range); $i <= min($lastPage, $currentPage + $range); $i++)
                                @if ($i == $currentPage)
                                    <li class="page-item active">
                                        <span class="page-link">{{ $i }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $suratMasuk->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endif
                            @endfor

                            <!-- Last Page -->
                            @if($currentPage < ($lastPage - $range))
                                @if($currentPage < ($lastPage - $range - 1))
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                @endif
                                <li class="page-item">
                                    <a class="page-link" href="{{ $suratMasuk->url($lastPage) }}">{{ $lastPage }}</a>
                                </li>
                            @endif

                            <!-- Next Page Link -->
                            @if ($suratMasuk->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $suratMasuk->nextPageUrl() }}" aria-label="Next">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link" aria-hidden="true">
                                        <i class="fas fa-chevron-right"></i>
                                    </span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                    <!-- Page info -->
                    <div class="text-center mt-2 text-muted small">
                        Menampilkan {{ ($suratMasuk->currentPage() - 1) * $suratMasuk->perPage() + 1 }} - 
                        {{ min($suratMasuk->currentPage() * $suratMasuk->perPage(), $suratMasuk->total()) }} 
                        dari {{ $suratMasuk->total() }} data
                    </div>
                @endif
            </div>

<style>
/* Custom Pagination Styling */
.pagination-container {
    margin-top: 30px;
}

.pagination-circle .page-item .page-link {
    border-radius: 50% !important;
    margin: 0 3px;
    width: 36px;
    height: 36px;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 500;
    border: none;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.pagination-circle .page-item.active .page-link {
    background-color: #4e73df;
    border-color: #4e73df;
    transform: scale(1.1);
    box-shadow: 0 4px 8px rgba(78, 115, 223, 0.3);
}

.pagination-circle .page-item .page-link:hover {
    background-color: #eaecf4;
    transform: scale(1.1);
    z-index: 3;
}

.pagination-circle .page-item.active .page-link:hover {
    background-color: #4e73df;
}

.pagination-circle .page-item.disabled .page-link {
    opacity: 0.5;
    box-shadow: none;
}

/* Subtle Animation - Reduced */
@keyframes gentle-pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.03); }
    100% { transform: scale(1); }
}

.pagination-circle .page-item.active .page-link {
    animation: gentle-pulse 3s infinite;
}
</style>        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Tambahkan event listener untuk semua input dengan kelas date-input
    const dateInputs = document.querySelectorAll('.date-input');
    
    dateInputs.forEach(function(input) {
        // Event listener untuk click (bukan hanya focus)
        input.addEventListener('click', function() {
            this.showPicker();
        });
    });
});
    $(document).ready(function() {
        // Custom sorting for columns
        $('.sortable').on('click', function() {
            var column = $(this).data('sort');
            var currentUrl = new URL(window.location);
            var sort = currentUrl.searchParams.get('sort') || '';
            var direction = currentUrl.searchParams.get('direction') || 'asc';
            
            // Toggle direction if same column is clicked
            if (sort === column) {
                direction = direction === 'asc' ? 'desc' : 'asc';
            } else {
                direction = 'asc';
            }
            
            currentUrl.searchParams.set('sort', column);
            currentUrl.searchParams.set('direction', direction);
            window.location = currentUrl.toString();
        });
        
        // Highlight sorted column
        var currentSort = new URL(window.location).searchParams.get('sort');
        var currentDirection = new URL(window.location).searchParams.get('direction');
        if (currentSort) {
            $('.sortable[data-sort="' + currentSort + '"] i')
                .removeClass('fa-sort')
                .addClass(currentDirection === 'asc' ? 'fa-sort-up' : 'fa-sort-down');
        }
    });
    
    // Add this to your scripts section
$(document).ready(function() {
    // Handle export button loading state
    $('#export-btn').on('click', function() {
        var originalText = $(this).html();
        $(this).html('<i class="fas fa-spinner fa-spin mr-1"></i> Menyiapkan...');
        $(this).addClass('disabled');
        
        // Add hidden tracking element
        $('body').append('<div id="download-tracker" style="display:none;"></div>');
        
        // Reset button after 30 seconds (in case of error)
        setTimeout(function() {
            if ($('#download-tracker').length) {
                $('#export-btn').html(originalText);
                $('#export-btn').removeClass('disabled');
                $('#download-tracker').remove();
            }
        }, 15000);
    });
});
</script>
@endsection
