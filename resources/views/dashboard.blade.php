@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- CARD STATISTIK --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

    <div class="bg-white p-5 rounded shadow">
        <p class="text-gray-500 text-sm">Total Surat Masuk</p>
        <h2 class="text-3xl font-bold">{{ $totalSuratMasuk }}</h2>
    </div>

    <div class="bg-white p-5 rounded shadow">
        <p class="text-gray-500 text-sm">Total Surat Keluar</p>
        <h2 class="text-3xl font-bold">{{ $totalSuratKeluar }}</h2>
    </div>

    <div class="bg-white p-5 rounded shadow">
        <p class="text-gray-500 text-sm">Total User</p>
        <h2 class="text-3xl font-bold">{{ $totalUser }}</h2>
    </div>

    <div class="bg-white p-5 rounded shadow">
        <p class="text-gray-500 text-sm">Surat Bulan Ini</p>
        <h2 class="text-3xl font-bold">
            {{ $totalSuratBulanIni }}
        </h2>
    </div>

</div>

{{-- GRAFIK & AKTIVITAS --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    {{-- GRAFIK --}}
    <div class="md:col-span-2 bg-white p-6 rounded shadow">
        <h3 class="font-semibold mb-4">Grafik Surat Per Bulan</h3>
        <canvas id="chartSurat"></canvas>
    </div>

    {{-- AKTIVITAS --}}
    <div class="bg-white p-6 rounded shadow">
        <h3 class="font-semibold mb-4">Aktivitas User</h3>

        <ul class="space-y-3 text-sm">
            @forelse ($aktivitas as $log)
                <li class="border-b pb-2">
                    <span class="font-semibold">{{ $log->user->name }}</span>
                    {{ $log->activity }}
                    <div class="text-xs text-gray-400">
                        {{ $log->created_at->diffForHumans() }}
                    </div>
                </li>
            @empty
                <li class="text-gray-400">Belum ada aktivitas</li>
            @endforelse
        </ul>
    </div>

</div>

{{-- CHART JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chartSurat');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($grafikSurat->pluck('bulan')) !!},
            datasets: [{
                label: 'Jumlah Surat',
                data: {!! json_encode($grafikSurat->pluck('total')) !!},
                backgroundColor: '#7A1E1E'
            }]
        }
    });
</script>

@endsection
