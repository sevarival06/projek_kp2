<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total surat masuk
        $totalSuratMasuk = SuratMasuk::count();
        
        // Surat masuk hari ini
        $suratMasukHariIni = SuratMasuk::whereDate('tgl_surat', Carbon::today())->count();
        
        // Surat masuk bulan ini
        $suratMasukBulanIni = SuratMasuk::whereYear('tgl_surat', Carbon::now()->year)
            ->whereMonth('tgl_surat', Carbon::now()->month)
            ->count();
        
        // Surat masuk tahun ini
        $suratMasukTahunIni = SuratMasuk::whereYear('tgl_surat', Carbon::now()->year)
            ->count();

        // Data untuk grafik - Jumlah surat per bulan dalam tahun ini
        $tahunIni = Carbon::now()->year;
        $dataBulan = [];
        
        // Inisialisasi data untuk 12 bulan
        for ($i = 1; $i <= 12; $i++) {
            $dataBulan[$i] = 0;
        }
        
        // Ambil data aktual dari database untuk tahun ini
        $suratPerBulan = SuratMasuk::select(
                DB::raw('MONTH(tgl_surat) as bulan'),
                DB::raw('COUNT(*) as jumlah')
            )
            ->whereYear('tgl_surat', $tahunIni)
            ->groupBy('bulan')
            ->get();
        
        // Mengisi data sesuai dengan hasil dari database
        foreach ($suratPerBulan as $item) {
            $dataBulan[$item->bulan] = $item->jumlah;
        }
        
        // Ambil tahun-tahun yang tersedia untuk filter
        $tahunList = SuratMasuk::select(DB::raw('YEAR(tgl_surat) as tahun'))
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun')
            ->toArray();
        
        // Jika tidak ada data, tambahkan tahun saat ini untuk menghindari error
        if (empty($tahunList)) {
            $tahunList = [$tahunIni];
        }
        
        // Total surat masuk per pengirim (untuk pie chart)
        $suratPerPengirim = SuratMasuk::select('pengirim', DB::raw('count(*) as total'))
            ->groupBy('pengirim')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        // Ubah data untuk pie chart
        $labelsChart = [];
        $dataChart = [];
        
        foreach ($suratPerPengirim as $surat) {
            $labelsChart[] = $surat->pengirim;
            $dataChart[] = $surat->total;
        }
        
        return view('dashboard.index', compact(
            'totalSuratMasuk',
            'suratMasukHariIni',
            'suratMasukBulanIni',
            'suratMasukTahunIni',
            'dataBulan',
            'tahunList',
            'tahunIni',
            'labelsChart',
            'dataChart'
        ));
    }
    
    public function getDataByTahun($tahun)
    {
        $dataBulan = [];
        
        // Inisialisasi data untuk 12 bulan
        for ($i = 1; $i <= 12; $i++) {
            $dataBulan[$i] = 0;
        }
        
        // Ambil data aktual dari database
        $suratPerBulan = SuratMasuk::select(
                DB::raw('MONTH(tgl_surat) as bulan'),
                DB::raw('COUNT(*) as jumlah')
            )
            ->whereYear('tgl_surat', $tahun)
            ->groupBy('bulan')
            ->get();
        
        // Mengisi data sesuai dengan hasil dari database
        foreach ($suratPerBulan as $item) {
            $dataBulan[$item->bulan] = $item->jumlah;
        }
        
        // Nama bulan untuk label chart
        $namaBulan = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        
        // Data yang akan direturn
        $data = [
            'tahun' => $tahun,
            'labels' => array_values($namaBulan),
            'data' => array_values($dataBulan)
        ];
        
        return response()->json($data);
    }
}