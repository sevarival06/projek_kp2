<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembar Disposisi - {{ $surat->no_surat }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12pt;
            background-color: white;
        }
        .container {
            width: 21cm;
            margin: 0 auto;
            padding: 10px;
            box-sizing: border-box;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
            position: relative;
            display: flex;
            align-items: center;
        }
        .header-content {
            flex: 1;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 14pt;
            text-transform: uppercase;
        }
        .header h1 {
            margin: 5px 0;
            font-size: 16pt;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0;
            font-size: 12pt;
        }
        .logo-container {
            padding-right: 15px;
        }
        .logo {
            display: block;
            max-height: 80px;
            width: auto;
        }
        .content {
            width: 100%;
        }
        .title {
            text-align: center;
            font-weight: bold;
            margin: 10px 0;
            font-size: 14pt;
            text-transform: uppercase;
        }
        table.main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }
        table.main-table td, table.main-table th {
            border: 1px solid #000;
            padding: 5px 10px;
            vertical-align: top;
        }
        .disposisi-content {
            display: flex;
            border: 1px solid #000;
            border-top: none;
            height: 200px;
        }
        .disposisi-left {
            width: 50%;
            border-right: 1px solid #000;
            height: 100%;
            padding: 10px;
            box-sizing: border-box;
        }
        .disposisi-right {
            width: 50%;
            height: 100%;
            padding: 10px;
            box-sizing: border-box;
        }
        .signature {
            text-align: right;
            margin-top: 20px;
            padding-right: 50px;
        }
        .signature-line {
            margin-top: 60px;
        }
        .nip {
            margin-top: 5px;
        }
        @media print {
            body {
                font-size: 12pt;
            }
            .no-print {
                display: none;
            }
            @page {
                size: A4 portrait;
                margin: 1cm;
            }
            .container {
                width: 21cm;
                height: 29.7cm;
                padding: 1cm;
                margin: 0 auto;
            }
            .header {
                display: flex;
                align-items: center;
                page-break-inside: avoid;
            }
            .logo {
                display: block;
                page-break-inside: avoid;
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
        .background-image {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.1;
            background-image: url("{{ asset('img/logo.png') }}");
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
        }
    </style>
</head>
<body>
    <div class="background-image"></div>
    <div class="container">
        <div class="no-print" style="text-align: center; margin-bottom: 20px;">
            <button class="btn-print" onclick="window.print()">Cetak Disposisi</button>
        </div>
        
        <div class="header">
            <div class="logo-container">
                <img src="{{ asset('img/logo.png') }}" alt="Logo Provinsi Riau" class="logo">
            </div>
            <div class="header-content">
                <h2>DINAS KOMUNIKASI INFORMATIKA DAN STATISTIK PROVINSI RIAU</h2>
                <h1>KASI TATA KELOLA PERSANDIAN, BIDANG PERSANDIAN</h1>
                <p>Rekapitulasi Laporan</p>
                <p>Jalan Diponegoro No. 24, Kec. Pekanbaru Kota, Kota Pekanbaru, Riau 28156</p>
            </div>
        </div>
        
        <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembar Disposisi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
        }
        .content {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #000;
        }
        .title {
            text-align: center;
            font-size: 16pt;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .main-table td {
            padding: 8px;
            vertical-align: top;
        }
        .disposisi-content {
            display: flex;
            margin-bottom: 20px;
        }
        .disposisi-left, .disposisi-right {
            width: 50%;
            padding: 10px;
        }
        .signature {
            text-align: right;
            margin-top: 30px;
            padding-right: 50px;
        }
        .signature-line {
            margin: 40px 0 10px 0;
            border-bottom: 1px solid #000;
            width: 200px;
            display: inline-block;
        }
        .nip {
            margin-top: 5px;
        }
        @media print {
            body {
                padding: 0;
            }
            .content {
                border: none;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="content">
        <div class="title">LEMBAR DISPOSISI</div>
        
        <table class="main-table">
            <tr>
                <td width="25%">Jumlah Berkas Dilampirkan</td>
                <td width="75%">: {{ $surat->jumlah }}</td>
            </tr>
            <tr>
                <td>Tanggal Surat</td>
                <td>: {{ $formattedTglSurat }}</td>
            </tr>
            <tr>
                <td>Nomor Surat</td>
                <td>: {{ $surat->no_surat }}</td>
            </tr>
            <tr>
                <td>Asal Surat</td>
                <td>: {{ $surat->asal_surat }}</td>
            </tr>
            <tr>
                <td>Isi Ringkas</td>
                <td>: {{ $surat->isi }}</td>
            </tr>
            <tr>
                <td>Diterima Tanggal</td>
                <td>: {{ $formattedTglAgenda }} <span style="float: right;">No. Agenda: {{ $surat->no_agenda }}</span></td>
            </tr>
            <tr>
                <td>Tanggal Penyelesaian</td>
                <td>: </td>
            </tr>
        </table>
        
        <div class="disposisi-content">
            <div class="disposisi-left">
                <div>Isi Disposisi:</div>
                <div style="min-height: 150px;"></div>
            </div>
            <div class="disposisi-right">
                <div>Diteruskan Kepada:</div>
                <div style="min-height: 150px;"></div>
            </div>
        </div>
        
        <div class="signature">
            <div>Kepala Bidang Persandian, Diskominfo</div>
            <div class="signature-line"></div>
            <div>Candra Lisano Saputra, S.T.</div>
            <div class="nip">NIP: 19790914 200501 1 007</div>
        </div>
    </div>
    
    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()">Cetak Disposisi</button>
        <button onclick="window.history.back()">Kembali</button>
    </div>
    </div>
</body>
</html>