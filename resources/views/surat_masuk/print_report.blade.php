<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Surat Masuk</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12pt;
            background-color: white;
        }
        .container {
            width: 100%;
            margin: 0 auto;
            padding: 10px;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 14pt;
            text-transform: uppercase;
        }
        .header h1 {
            margin: 5px 0;
            font-size: 18pt;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0;
            font-size: 12pt;
        }
        .title {
            text-align: center;
            font-weight: bold;
            margin: 20px 0;
            font-size: 14pt;
            text-transform: uppercase;
            text-decoration: underline;
        }
        table.report {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table.report th, table.report td {
            border: 1px solid #000;
            padding: 5px;
            font-size: 10pt;
        }
        table.report th {
            background-color: #f2f2f2;
            text-align: center;
            vertical-align: middle;
        }
        .text-center {
            text-align: center;
        }
        .signature {
            width: 100%;
            text-align: right;
            margin-top: 30px;
        }
        .signature-box {
            width: 200px;
            float: right;
            text-align: center;
        }
        .signature-line {
            margin-top: 60px;
            border-bottom: 1px solid #000;
        }
        @media print {
            body {
                font-size: 12pt;
            }
            .no-print {
                display: none;
            }
            @page {
                size: landscape;
                margin: 1cm;
            }
        }
        .btn-print {
            background-color: #4e73df;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
        }
        .date-range {
            text-align: center;
            margin-bottom: 15px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="no-print" style="text-align: center; margin-bottom: 20px;">
            <button class="btn-print" onclick="window.print()">Cetak Laporan</button>
            <a href="{{ route('surat-masuk.index') }}" class="btn-print" style="background-color: #858796;">Kembali</a>
        </div>
        
        <div class="header">
            <h2>DINAS KOMUNIKASI INFORMATIKA DAN STATISTIK PROVINSI RIAU</h2>
            <h1>KASI TATA KELOLA PERSANDIAN, BIDANG PERSANDIAN</h1>
            <h1>LAPORAN SURAT MASUK</h1>
            <p>Jalan Diponegoro No. 24, Kec. Pekanbaru Kota, Kota Pekanbaru, Riau 28156</p>
        </div>
        
        @if(request('start_date') && request('end_date'))
            <div class="date-range">
                Periode: {{ date('d-m-Y', strtotime(request('start_date'))) }} s/d {{ date('d-m-Y', strtotime(request('end_date'))) }}
            </div>
        @endif
        
        <table class="report">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No. Agenda</th>
                    <th>No. Surat</th>
                    <th>Pengirim</th>
                    <th>Asal Surat</th>
                    <th>Penerima</th>
                    <th>Tanggal Surat</th>
                    <th>Tanggal Agenda</th>
                    <th>Isi Ringkas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($suratMasuk as $index => $surat)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $surat->no_agenda }}</td>
                    <td>{{ $surat->no_surat }}</td>
                    <td>{{ $surat->pengirim }}</td>
                    <td>{{ $surat->asal_surat }}</td>
                    <td>{{ $surat->penerima }}</td>
                    <td class="text-center">{{ date('d-m-Y', strtotime($surat->tgl_surat)) }}</td>
                    <td class="text-center">{{ date('d-m-Y', strtotime($surat->tgl_agenda)) }}</td>
                    <td>{{ $surat->isi }}</td>
                </tr>
                @endforeach
                
                @if($suratMasuk->count() == 0)
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data surat masuk</td>
                </tr>
                @endif
            </tbody>
        </table>
        
        <div class="signature">
            <div class="signature-box">
                <p>{{ now()->format('d F Y') }}</p>
                <p>Petugas Administratif</p>
                <div class="signature-line"></div>
                <p>( {{ Auth::user()->name ?? 'Admin' }} )</p>
                <p>NIP. {{ Auth::user()->nip ?? '-' }}</p>
            </div>
        </div>
        <div class="footer no-print">
            <p>Dinas Komunikasi Informatika dan Statistik Provinsi Riau © {{ date('Y') }} - Semua Hak Dilindungi</p>
        </div>
    </div>
</body>
</html>