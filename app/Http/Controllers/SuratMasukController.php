<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use ZipArchive;
use Illuminate\View\View;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SuratMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = SuratMasuk::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('no_agenda', 'like', '%' . $searchTerm . '%')
                ->orWhere('no_surat', 'like', '%' . $searchTerm . '%')
                ->orWhere('pengirim', 'like', '%' . $searchTerm . '%')
                ->orWhere('asal_surat', 'like', '%' . $searchTerm . '%')
                ->orWhere('penerima', 'like', '%' . $searchTerm . '%')
                ->orWhere('isi', 'like', '%' . $searchTerm . '%');
            });
        }

        // Year filtering (new addition)
        if ($request->has('tahun') && !empty($request->tahun)) {
            $year = $request->tahun;
            $query->whereYear('tgl_surat', $year);
        }

        // Date filtering
        if ($request->has('start_date') && !empty($request->start_date)) {
            $query->whereDate('tgl_surat', '>=', $request->start_date);
        }

        if ($request->has('end_date') && !empty($request->end_date)) {
            $query->whereDate('tgl_surat', '<=', $request->end_date);
        }

        // Sorting
        if ($request->has('sort') && !empty($request->sort)) {
            $direction = $request->direction ?? 'asc';
            $query->orderBy($request->sort, $direction);
        } else {
            $query->orderBy('tgl_surat', 'desc'); // Default sorting
        }

        // Paginate the results - 10 items per page
        $suratMasuk = $query->paginate(10)->withQueryString();
        
        return view('surat_masuk.index', compact('suratMasuk'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('surat_masuk.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_agenda' => 'required|string|max:50|regex:/^[0-9]+$/',
            'no_surat' => 'required|string|max:50',
            'pengirim' => 'required|string|max:250',
            'asal_surat' => 'required|string|max:500',
            'penerima' => 'required|string|max:250',
            'isi' => 'required|string',
            'jumlah' => 'required|integer|min:1|max:1000',
            'tgl_surat' => 'required|date',
            'tgl_agenda' => 'required|date',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240', // Changed nullable to required
        ], [
            'no_agenda.required' => 'Nomor agenda harus diisi',
            'no_agenda.max' => 'Nomor agenda maksimal 50 karakter',
            'no_agenda.regex' => 'Nomor agenda hanya boleh diisi dengan angka',
            'no_surat.required' => 'Nomor surat harus diisi',
            'no_surat.max' => 'Nomor surat maksimal 50 karakter',
            'pengirim.required' => 'Pengirim harus diisi',
            'pengirim.max' => 'Pengirim maksimal 250 karakter',
            'asal_surat.required' => 'Asal surat harus diisi',
            'asal_surat.max' => 'Asal surat maksimal 500 karakter',
            'penerima.required' => 'Penerima harus diisi',
            'penerima.max' => 'Penerima maksimal 250 karakter',
            'isi.required' => 'Perihal surat harus diisi',
            'jumlah.required' => 'Jumlah harus diisi',
            'jumlah.integer' => 'Jumlah harus berupa angka',
            'jumlah.min' => 'Jumlah minimal 1',
            'jumlah.max' => 'Jumlah maksimal 1000',
            'tgl_surat.required' => 'Tanggal surat harus diisi',
            'tgl_surat.date' => 'Format tanggal surat tidak valid',
            'tgl_agenda.required' => 'Tanggal agenda harus diisi',
            'tgl_agenda.date' => 'Format tanggal agenda tidak valid',
            'file.required' => 'File surat harus diunggah', // Added error message for required file
            'file.mimes' => 'Format file harus PDF, JPG, JPEG, atau PNG',
            'file.max' => 'Ukuran file maksimal 10MB',
        ]);

        $fileName = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('surat_masuk', $fileName, 'public');
        }

        $suratMasuk = new SuratMasuk();
        $suratMasuk->no_agenda = $validated['no_agenda'];
        $suratMasuk->no_surat = $validated['no_surat'];
        $suratMasuk->pengirim = $validated['pengirim'];
        $suratMasuk->asal_surat = $validated['asal_surat'];
        $suratMasuk->penerima = $validated['penerima'];
        $suratMasuk->isi = $validated['isi'];
        $suratMasuk->jumlah = $validated['jumlah'];
        $suratMasuk->tgl_surat = $validated['tgl_surat'];
        $suratMasuk->tgl_agenda = $validated['tgl_agenda'];
        $suratMasuk->file = $fileName;
        $suratMasuk->id_user = Auth::id();
        $suratMasuk->save();

        return redirect()->route('surat-masuk.index')
            ->with('success', 'Surat masuk berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $surat = SuratMasuk::findOrFail($id);
        
        if (!$surat->file) {
            abort(404, 'File tidak ditemukan.');
        }

        $filePath = storage_path('app/public/surat_masuk/' . $surat->file);

        if (!file_exists($filePath)) {
            abort(404, 'File tidak tersedia di penyimpanan.');
        }

        // Tentukan content-type berdasarkan ekstensi file
        $extension = pathinfo($surat->file, PATHINFO_EXTENSION);
        $contentType = 'application/octet-stream'; // Default

        if (in_array(strtolower($extension), ['pdf'])) {
            $contentType = 'application/pdf';
        } elseif (in_array(strtolower($extension), ['jpg', 'jpeg'])) {
            $contentType = 'image/jpeg';
        } elseif (in_array(strtolower($extension), ['png'])) {
            $contentType = 'image/png';
        }

        return response()->file($filePath, ['Content-Type' => $contentType]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $surat = SuratMasuk::findOrFail($id);
        return view('surat_masuk.edit', compact('surat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $suratMasuk = SuratMasuk::findOrFail($id);
        
        // Custom validation rules based on whether there's a file already
        $fileRules = 'file|mimes:pdf,jpg,jpeg,png|max:10240';
        if (!$suratMasuk->file) {
            $fileRules = 'required|' . $fileRules;
        }
        
        $validated = $request->validate([
            'no_agenda' => 'required|string|max:50|regex:/^[0-9]+$/',
            'no_surat' => 'required|string|max:50',
            'pengirim' => 'required|string|max:250',
            'asal_surat' => 'required|string|max:500',
            'penerima' => 'required|string|max:250',
            'isi' => 'required|string',
            'jumlah' => 'required|integer|min:1|max:1000',
            'tgl_surat' => 'required|date',
            'tgl_agenda' => 'required|date',
            'file' => $request->hasFile('file') ? $fileRules : '',
        ], [
            'no_agenda.required' => 'Nomor agenda harus diisi',
            'no_agenda.max' => 'Nomor agenda maksimal 50 karakter',
            'no_agenda.regex' => 'Nomor agenda hanya boleh diisi dengan angka',
            'no_surat.required' => 'Nomor surat harus diisi',
            'no_surat.max' => 'Nomor surat maksimal 50 karakter',
            'pengirim.required' => 'Pengirim harus diisi',
            'pengirim.max' => 'Pengirim maksimal 250 karakter',
            'asal_surat.required' => 'Asal surat harus diisi',
            'asal_surat.max' => 'Asal surat maksimal 500 karakter',
            'penerima.required' => 'Penerima harus diisi',
            'penerima.max' => 'Penerima maksimal 250 karakter',
            'isi.required' => 'Perihal surat harus diisi',
            'jumlah.required' => 'Jumlah harus diisi',
            'jumlah.integer' => 'Jumlah harus berupa angka',
            'jumlah.min' => 'Jumlah minimal 1',
            'jumlah.max' => 'Jumlah maksimal 1000',
            'tgl_surat.required' => 'Tanggal surat harus diisi',
            'tgl_surat.date' => 'Format tanggal surat tidak valid',
            'tgl_agenda.required' => 'Tanggal agenda harus diisi',
            'tgl_agenda.date' => 'Format tanggal agenda tidak valid',
            'file.required' => 'File surat harus diunggah',
            'file.mimes' => 'Format file harus PDF, JPG, JPEG, atau PNG',
            'file.max' => 'Ukuran file maksimal 10MB',
        ]);

        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($suratMasuk->file) {
                Storage::disk('public')->delete('surat_masuk/' . $suratMasuk->file);
            }
            
            // Upload new file
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('surat_masuk', $fileName, 'public');
            $suratMasuk->file = $fileName;
        } else if (!$suratMasuk->file) {
            // If no file uploaded and no existing file, return with error
            return back()->withInput()->withErrors(['file' => 'File surat harus diunggah']);
        }

        $suratMasuk->no_agenda = $validated['no_agenda'];
        $suratMasuk->no_surat = $validated['no_surat'];
        $suratMasuk->pengirim = $validated['pengirim'];
        $suratMasuk->asal_surat = $validated['asal_surat'];
        $suratMasuk->penerima = $validated['penerima'];
        $suratMasuk->isi = $validated['isi'];
        $suratMasuk->jumlah = $validated['jumlah'];
        $suratMasuk->tgl_surat = $validated['tgl_surat'];
        $suratMasuk->tgl_agenda = $validated['tgl_agenda'];
        $suratMasuk->save();

        return redirect()->route('surat-masuk.index')
            ->with('success', 'Surat masuk berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $suratMasuk = SuratMasuk::findOrFail($id);
        
        // Delete file if exists
        if ($suratMasuk->file) {
            Storage::disk('public')->delete('surat_masuk/' . $suratMasuk->file);
        }
        
        $suratMasuk->delete();

        return redirect()->route('surat-masuk.index')
            ->with('success', 'Surat masuk berhasil dihapus');
    }

    /**
     * View file attachment.
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function viewFile($id)
    {
        $surat = SuratMasuk::findOrFail($id);
        
        if (!$surat->file) {
            abort(404, 'File not found');
        }
        
        $filePath = storage_path('app/public/surat_masuk/' . $surat->file);
        
        if (!file_exists($filePath)) {
            abort(404, 'File not found on disk');
        }
        
        // Return file response based on file type
        $extension = pathinfo($surat->file, PATHINFO_EXTENSION);
        $contentType = 'application/octet-stream'; // Default
        
        if (in_array(strtolower($extension), ['pdf'])) {
            $contentType = 'application/pdf';
        } elseif (in_array(strtolower($extension), ['jpg', 'jpeg'])) {
            $contentType = 'image/jpeg';
        } elseif (in_array(strtolower($extension), ['png'])) {
            $contentType = 'image/png';
        }
        
        return response()->file($filePath, ['Content-Type' => $contentType]);
    }

    /**
     * Print report of incoming letters.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function printReport(Request $request)
    {
        $query = SuratMasuk::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('no_agenda', 'like', '%' . $searchTerm . '%')
                  ->orWhere('no_surat', 'like', '%' . $searchTerm . '%')
                  ->orWhere('pengirim', 'like', '%' . $searchTerm . '%')
                  ->orWhere('asal_surat', 'like', '%' . $searchTerm . '%')
                  ->orWhere('penerima', 'like', '%' . $searchTerm . '%')
                  ->orWhere('isi', 'like', '%' . $searchTerm . '%');
            });
        }

        // Year filtering (new addition)
        if ($request->has('tahun') && !empty($request->tahun)) {
            $year = $request->tahun;
            $query->whereYear('tgl_surat', $year);
        }

        // Date filtering
        if ($request->has('start_date') && !empty($request->start_date)) {
            $query->whereDate('tgl_surat', '>=', $request->start_date);
        }

        if ($request->has('end_date') && !empty($request->end_date)) {
            $query->whereDate('tgl_surat', '<=', $request->end_date);
        }

        // Sorting
        if ($request->has('sort') && !empty($request->sort)) {
            $direction = $request->direction ?? 'asc';
            $query->orderBy($request->sort, $direction);
        } else {
            $query->orderBy('tgl_surat', 'desc'); // Default sorting
        }

        $suratMasuk = $query->get();
        
        return view('surat_masuk.print_report', compact('suratMasuk'));
    }

    /**
     * Print disposition for a specific letter
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function printDisposisi($id)
    {
        $surat = SuratMasuk::findOrFail($id);
        
        // Format dates
        $formattedTglSurat = Carbon::parse($surat->tgl_surat)->locale('id')->isoFormat('DD MMMM YYYY');
        $formattedTglAgenda = Carbon::parse($surat->tgl_agenda)->locale('id')->isoFormat('DD MMMM YYYY');
        
        // Pass formatted data to view
        $data = [
            'surat' => $surat,
            'formattedTglSurat' => $formattedTglSurat,
            'formattedTglAgenda' => $formattedTglAgenda,
        ];
        
        return view('surat_masuk.print_disposisi', $data);
    }

    /**
     * Download all files based on filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadFiles(Request $request)
    {
        // Build query untuk surat yang memiliki file
        $query = SuratMasuk::query()->whereNotNull('file');

        // Terapkan filter tanggal jika ada
        if ($request->start_date) {
            $query->whereDate('tgl_surat', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->whereDate('tgl_surat', '<=', $request->end_date);
        }

        // Filter tahun jika dipilih
        if ($request->tahun) {
            $query->whereYear('tgl_surat', $request->tahun);
        }

        // Filter pencarian jika ada
        if ($request->search) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('no_agenda', 'like', "%{$searchTerm}%")
                  ->orWhere('no_surat', 'like', "%{$searchTerm}%")
                  ->orWhere('pengirim', 'like', "%{$searchTerm}%")
                  ->orWhere('asal_surat', 'like', "%{$searchTerm}%");
            });
        }

        // Dapatkan hasil
        $suratMasuk = $query->get();

        if ($suratMasuk->isEmpty()) {
            return back()->with('error', 'Tidak ada file surat yang tersedia untuk diunduh.');
        }

        // Buat ZIP file
        $zip = new ZipArchive();
        $filename = 'surat_masuk_' . date('YmdHis') . '.zip';
        $tempPath = storage_path('app/public/temp');
        
        // Buat direktori temp jika belum ada
        if (!file_exists($tempPath)) {
            mkdir($tempPath, 0755, true);
        }
        
        $zipPath = $tempPath . '/' . $filename;

        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            $fileCount = 0;
            
            foreach ($suratMasuk as $surat) {
                if (!$surat->file) continue;
                
                $filePath = storage_path('app/public/surat_masuk/' . $surat->file);
                
                if (file_exists($filePath)) {
                    // Beri nama file yang deskriptif
                    $newFilename = $surat->no_agenda . ' - ' . 
                                   preg_replace('/[^a-zA-Z0-9\-_\.]/', '_', $surat->no_surat) . ' - ' . 
                                   preg_replace('/[^a-zA-Z0-9\-_\.]/', '_', $surat->pengirim) . '.pdf';
                    
                    $zip->addFile($filePath, $newFilename);
                    $fileCount++;
                }
            }
            
            $zip->close();
            
            if ($fileCount > 0) {
                return response()->download($zipPath)->deleteFileAfterSend(true);
            } else {
                if (file_exists($zipPath)) {
                    unlink($zipPath);
                }
                return back()->with('error', 'Tidak ada file yang dapat diunduh.');
            }
        }
        
        return back()->with('error', 'Gagal membuat file zip.');
    }
}