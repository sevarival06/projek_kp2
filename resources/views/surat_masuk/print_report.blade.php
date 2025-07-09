<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Surat Masuk</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12pt;
            background-color: #fff;
        }
        .container {
            width: 95%;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h2, .header h1 {
            margin: 2px 0;
            text-transform: uppercase;
        }
        .header h2 {
            font-size: 15pt;
        }
        .header h1 {
            font-size: 18pt;
        }
        .header p {
            margin: 5px 0;
            font-size: 11pt;
            color: #444;
        }
        .title {
            text-align: center;
            font-weight: bold;
            margin: 20px 0;
            font-size: 14pt;
            text-decoration: underline;
        }
        .date-range {
            text-align: center;
            margin-bottom: 15px;
            font-style: italic;
            font-size: 11pt;
        }
        table.report {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table.report th, table.report td {
            border: 1px solid #444;
            padding: 8px;
            font-size: 10pt;
        }
        table.report th {
            background-color: #e0e0e0;
            text-align: center;
        }
        table.report td {
            vertical-align: top;
        }
        .text-center {
            text-align: center;
        }
        .signature {
            width: 100%;
            margin-top: 40px;
            display: flex;
            justify-content: flex-end;
        }
        .signature-box {
            text-align: center;
            width: 250px;
        }
        .signature-line {
            margin-top: 60px;
            border-bottom: 1px solid #000;
            width: 100%;
        }
        .footer {
            text-align: center;
            font-size: 10pt;
            color: #888;
            margin-top: 30px;
        }
        .btn-print {
            background-color: #4e73df;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 14px;
            margin: 10px 5px;
            cursor: pointer;
            border-radius: 4px;
        }
        .no-print {
            text-align: center;
        }
        @media print {
            .no-print {
                display: none;
            }
            @page {
                size: landscape;
                margin: 1cm;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Tombol Aksi -->
        <div class="no-print">
            <button class="btn-print" onclick="window.print()">Cetak Laporan</button>
            <a href="{{ route('surat-masuk.index') }}" class="btn-print" style="background-color: #6c757d;">Kembali</a>
        </div>

        <!-- Header -->
        <div class="header">
            <h2>DINAS KOMUNIKASI INFORMATIKA DAN STATISTIK PROVINSI RIAU</h2>
            <h1>BIDANG PERSANDIAN - KASI TATA KELOLA PERSANDIAN</h1>
            <p>Jl. Diponegoro No. 24, Kec. Pekanbaru Kota, Kota Pekanbaru, Riau 28156</p>
        </div>

        <!-- Judul -->
        <div class="title">Laporan Surat Masuk</div>

        <!-- Periode -->
        @if(request('start_date') && request('end_date'))
            <div class="date-range">
                Periode: {{ date('d-m-Y', strtotime(request('start_date'))) }} s/d {{ date('d-m-Y', strtotime(request('end_date'))) }}
            </div>
        @endif

        <!-- Tabel Laporan -->
        <table class="report">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No. Agenda</th>
                    <th>No. Surat</th>
                    <th>Klasifikasi</th>
                    <th>Pengirim</th>
                    <th>Asal Surat</th>
                    <th>Penerima</th>
                    <th>Tanggal Surat</th>
                    <th>Tanggal Agenda</th>
                    <th>Isi Ringkas</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suratMasuk as $index => $surat)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $surat->no_agenda }}</td>
                        <td>{{ $surat->no_surat }}</td>
                        <td>{{ $surat->klasifikasi_surat }}</td>
                        <td>{{ $surat->pengirim }}</td>
                        <td>{{ $surat->asal_surat }}</td>
                        <td>{{ $surat->penerima }}</td>
                        <td class="text-center">{{ date('d-m-Y', strtotime($surat->tgl_surat)) }}</td>
                        <td class="text-center">{{ date('d-m-Y', strtotime($surat->tgl_agenda)) }}</td>
                        <td>{{ $surat->isi }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">Tidak ada data surat masuk</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Tanda Tangan -->
        <div class="signature">
            <div class="signature-box">
                <p>Pekanbaru, {{ now()->format('d F Y') }}</p>
                <p>Petugas Administratif</p>
                <div class="signature-line"></div>
                <p>( {{ Auth::user()->name ?? 'Admin' }} )</p>
                <p>NIP. {{ Auth::user()->nip ?? '-' }}</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer no-print">
            Dinas Komunikasi Informatika dan Statistik Provinsi Riau © {{ date('Y') }} - Semua Hak Dilindungi
        </div>
    </div>
</body>
</html>
