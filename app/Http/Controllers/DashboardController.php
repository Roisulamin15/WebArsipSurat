<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ======================
        // TOTAL DATA
        // ======================
        $totalSuratMasuk  = SuratMasuk::count();
        $totalSuratKeluar = SuratKeluar::count();
        $totalUser        = User::count();

        // ======================
        // SURAT BULAN INI
        // ======================
        $bulanSekarang = now()->month;
        $tahunSekarang = now()->year;

        $totalSuratBulanIni =
            SuratMasuk::whereMonth('created_at', $bulanSekarang)
                ->whereYear('created_at', $tahunSekarang)
                ->count()
            +
            SuratKeluar::whereMonth('created_at', $bulanSekarang)
                ->whereYear('created_at', $tahunSekarang)
                ->count();

        // ======================
        // GRAFIK SURAT PER BULAN
        // ======================
        $grafikMasuk = SuratMasuk::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $grafikKeluar = SuratKeluar::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $grafikSurat = collect(range(1, 12))->map(function ($bulan) use ($grafikMasuk, $grafikKeluar) {
            return [
                'bulan' => $bulan,
                'total' => ($grafikMasuk[$bulan] ?? 0) + ($grafikKeluar[$bulan] ?? 0),
            ];
        });

        // ======================
        // AKTIVITAS USER
        // ======================
        $aktivitas = ActivityLog::with('user')
            ->latest()
            ->limit(10)
            ->get();

        return view('dashboard', compact(
            'totalSuratMasuk',
            'totalSuratKeluar',
            'totalUser',
            'totalSuratBulanIni',
            'grafikSurat',
            'aktivitas'
        ));
    }
}
