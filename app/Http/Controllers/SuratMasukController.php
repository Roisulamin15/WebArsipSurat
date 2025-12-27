<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class SuratMasukController extends Controller
{
    // ================== INDEX + SEARCH ==================
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        $data = SuratMasuk::when($keyword, function ($query) use ($keyword) {
                $query->where('perihal', 'like', "%{$keyword}%");
            })
            ->orderBy('tanggal_surat', 'desc')
            ->get();

        return view('surat_masuk.index', compact('data', 'keyword'));
    }

    // ================== CREATE ==================
    public function create()
    {
        return view('surat_masuk.create');
    }

    // ================== STORE ==================
    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat'   => 'required',
            'nomor_agenda'  => 'required',
            'asal_surat'    => 'required',
            'tanggal_surat' => 'required|date',
            'perihal'       => 'required',
            'file'          => 'nullable|mimes:pdf,jpg,jpeg,png|max:4096',
            'ocr_file'      => 'nullable|mimes:pdf,jpg,jpeg,png|max:4096'
        ]);

        // ==================
        // UPLOAD FILE SURAT
        // ==================
        $fileName = null;
        if ($request->hasFile('file')) {
            $fileName = time().'_'.$request->file('file')->getClientOriginalName();
            $request->file('file')->move(public_path('uploads/surat_masuk'), $fileName);
        }

        // ==================
        // UPLOAD FILE OCR
        // ==================
        $ocrFileName = null;
        if ($request->hasFile('ocr_file')) {
            $ocrFileName = time().'_'.$request->file('ocr_file')->getClientOriginalName();
            $request->file('ocr_file')->move(public_path('uploads/ocr/surat_masuk'), $ocrFileName);
        }

        // ==================
        // SIMPAN DATA
        // ==================
        SuratMasuk::create([
            'nomor_surat'   => $request->nomor_surat,
            'nomor_agenda'  => $request->nomor_agenda,
            'asal_surat'    => $request->asal_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'perihal'       => $request->perihal,
            'file'          => $fileName,
            'ocr_file'      => $ocrFileName
        ]);

        // ==================
        // LOG AKTIVITAS
        // ==================
        ActivityLog::create([
            'user_id'  => auth()->id(),
            'activity' => 'Mengupload Surat Masuk: '.$request->perihal
        ]);

        return redirect()
            ->route('surat-masuk.index')
            ->with('success', 'Surat masuk berhasil ditambahkan');
    }

    // ================== DELETE ==================
    public function destroy(SuratMasuk $suratMasuk)
    {
        if ($suratMasuk->file && file_exists(public_path('uploads/surat_masuk/'.$suratMasuk->file))) {
            unlink(public_path('uploads/surat_masuk/'.$suratMasuk->file));
        }

        if ($suratMasuk->ocr_file && file_exists(public_path('uploads/ocr/surat_masuk/'.$suratMasuk->ocr_file))) {
            unlink(public_path('uploads/ocr/surat_masuk/'.$suratMasuk->ocr_file));
        }

        $suratMasuk->delete();

        ActivityLog::create([
            'user_id'  => auth()->id(),
            'activity' => 'Menghapus Surat Masuk'
        ]);

        return back()->with('success', 'Surat masuk berhasil dihapus');
    }

    // ================== VIEW FILE ==================
    public function viewFile($id)
    {
        $surat = SuratMasuk::findOrFail($id);

        return response()->file(
            public_path('uploads/surat_masuk/'.$surat->file)
        );
    }

    // ================== DOWNLOAD FILE ==================
    public function download($id)
    {
        $surat = SuratMasuk::findOrFail($id);

        return response()->download(
            public_path('uploads/surat_masuk/'.$surat->file)
        );
    }
}
