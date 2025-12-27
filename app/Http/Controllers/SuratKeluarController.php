<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class SuratKeluarController extends Controller
{
    // ================== INDEX + SEARCH ==================
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        $data = SuratKeluar::when($keyword, function ($query) use ($keyword) {
                $query->where('perihal', 'like', "%{$keyword}%");
            })
            ->orderBy('tanggal_surat', 'desc')
            ->get();

        return view('surat_keluar.index', compact('data', 'keyword'));
    }

    // ================== CREATE ==================
    public function create()
    {
        return view('surat_keluar.create');
    }

    // ================== STORE ==================
    public function store(Request $request)
    {
        $request->validate([
            'nomor'          => 'required',
            'nomor_surat'    => 'required',
            'tujuan_surat'   => 'required',
            'tanggal_surat'  => 'required|date',
            'perihal'        => 'required',
            'file'           => 'nullable|mimes:pdf,jpg,jpeg,png|max:4096',
            'ocr_file'       => 'nullable|mimes:pdf,jpg,jpeg,png|max:4096'
        ]);

        // ==================
        // UPLOAD FILE SURAT
        // ==================
        $fileName = null;
        if ($request->hasFile('file')) {
            $fileName = time().'_'.$request->file('file')->getClientOriginalName();
            $request->file('file')->move(public_path('uploads/surat_keluar'), $fileName);
        }

        // ==================
        // UPLOAD FILE OCR (SIAP AI)
        // ==================
        $ocrFileName = null;
        if ($request->hasFile('ocr_file')) {
            $ocrFileName = time().'_'.$request->file('ocr_file')->getClientOriginalName();
            $request->file('ocr_file')->move(public_path('uploads/ocr/surat_keluar'), $ocrFileName);
        }

        // ==================
        // SIMPAN DATA
        // ==================
        SuratKeluar::create([
            'nomor'          => $request->nomor,
            'nomor_surat'    => $request->nomor_surat,
            'tujuan_surat'   => $request->tujuan_surat,
            'tanggal_surat'  => $request->tanggal_surat,
            'perihal'        => $request->perihal,
            'file'           => $fileName,
            'ocr_file'       => $ocrFileName
        ]);

        // ==================
        // LOG AKTIVITAS
        // ==================
        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'Mengupload Surat Keluar: '.$request->perihal
        ]);

        return redirect()
            ->route('surat-keluar.index')
            ->with('success', 'Surat keluar berhasil ditambahkan');
    }

    // ================== DELETE ==================
    public function destroy(SuratKeluar $suratKeluar)
    {
        if ($suratKeluar->file && file_exists(public_path('uploads/surat_keluar/'.$suratKeluar->file))) {
            unlink(public_path('uploads/surat_keluar/'.$suratKeluar->file));
        }

        if ($suratKeluar->ocr_file && file_exists(public_path('uploads/ocr/surat_keluar/'.$suratKeluar->ocr_file))) {
            unlink(public_path('uploads/ocr/surat_keluar/'.$suratKeluar->ocr_file));
        }

        $suratKeluar->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'Menghapus Surat Keluar'
        ]);

        return back()->with('success', 'Surat keluar berhasil dihapus');
    }

    // ================== VIEW FILE ==================
    public function viewFile($id)
    {
        $surat = SuratKeluar::findOrFail($id);

        return response()->file(
            public_path('uploads/surat_keluar/'.$surat->file)
        );
    }

    // ================== DOWNLOAD FILE ==================
    public function download($id)
    {
        $surat = SuratKeluar::findOrFail($id);

        return response()->download(
            public_path('uploads/surat_keluar/'.$surat->file)
        );
    }
}
