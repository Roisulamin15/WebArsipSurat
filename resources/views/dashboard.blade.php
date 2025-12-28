@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- ================= CARD STATISTIK ================= --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    <div class="bg-white p-5 rounded shadow">
        <p class="text-gray-500 text-sm">Total Surat Masuk</p>
        <h2 class="text-3xl font-bold">{{ $totalSuratMasuk }}</h2>
    </div>

    <div class="bg-white p-5 rounded shadow">
        <p class="text-gray-500 text-sm">Total Surat Keluar</p>
        <h2 class="text-3xl font-bold">{{ $totalSuratKeluar }}</h2>
    </div>

    @if(auth()->user()->role === 'admin')
    <div class="bg-white p-5 rounded shadow">
        <p class="text-gray-500 text-sm">Total User</p>
        <h2 class="text-3xl font-bold">{{ $totalUser }}</h2>
    </div>
    @endif

    <div class="bg-white p-5 rounded shadow">
        <p class="text-gray-500 text-sm">Surat Bulan Ini</p>
        <h2 class="text-3xl font-bold">{{ $totalSuratBulanIni }}</h2>
    </div>

</div>

{{-- ================= GRAFIK & AKTIVITAS ================= --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ===== GRAFIK (ADMIN ONLY) ===== --}}
    @if(auth()->user()->role === 'admin')
    <div class="lg:col-span-2 bg-white p-6 rounded shadow">
        <h3 class="font-semibold mb-4">Grafik Surat Per Bulan</h3>
        <div class="relative w-full h-[300px]">
            <canvas id="chartSurat"></canvas>
        </div>
    </div>
    @endif

    {{-- ===== AKTIVITAS ===== --}}
    <div class="bg-white p-6 rounded shadow
        {{ auth()->user()->role !== 'admin' ? 'lg:col-span-3' : '' }}">

        <h3 class="font-semibold mb-4">
            {{ auth()->user()->role === 'admin' ? 'Aktivitas User' : 'Aktivitas Saya' }}
        </h3>

        <div class="max-h-[320px] overflow-y-auto pr-2">
            <ul class="space-y-3 text-sm">
                @forelse ($aktivitas as $log)
                    <li class="border-b pb-2">
                        <p class="font-semibold">
                            {{ $log->user->name }}
                        </p>
                        <p class="text-gray-700">
                            {{ $log->activity }}
                        </p>
                        <p class="text-xs text-gray-400">
                            {{ $log->created_at->diffForHumans() }}
                        </p>
                    </li>
                @empty
                    <li class="text-gray-400">Belum ada aktivitas</li>
                @endforelse
            </ul>
        </div>
    </div>

</div>

{{-- ================= CHART JS (ADMIN ONLY) ================= --}}
@if(auth()->user()->role === 'admin')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    new Chart(document.getElementById('chartSurat'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($grafikSurat->pluck('bulan')) !!},
            datasets: [{
                label: 'Jumlah Surat',
                data: {!! json_encode($grafikSurat->pluck('total')) !!},
                backgroundColor: '#7A1E1E'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>
@endif

@endsection
