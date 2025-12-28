@extends('layouts.app')

@section('title', 'Surat Masuk')

@section('content')

{{-- ================= HEADER ACTION ================= --}}
<div class="flex flex-col md:flex-row md:items-center gap-3 mb-6">

    {{-- TAMBAH --}}
    <a href="{{ route('surat-masuk.create') }}"
       class="px-4 py-2 bg-[#7A1E1E] text-white rounded hover:bg-[#4B0F0F]">
        + Tambah Surat
    </a>

    {{-- UPLOAD OCR --}}
    <form method="POST" action="#" enctype="multipart/form-data"
          class="flex items-center gap-2">
        @csrf
        <input type="file" name="ocr_file"
               accept=".pdf,.jpg,.jpeg,.png"
               class="border rounded px-2 py-1 text-sm">
        <button class="px-3 py-2 bg-[#7A1E1E] text-white rounded">
            Upload
        </button>
    </form>

    {{-- SEARCH --}}
    <form method="GET"
          action="{{ route('surat-masuk.index') }}"
          class="flex gap-2 w-full md:w-auto md:ml-auto">

        <input type="text"
               name="keyword"
               value="{{ request('keyword') }}"
               placeholder="Cari perihal..."
               class="border rounded px-3 py-2 w-full md:w-64">

        <button class="px-4 py-2 bg-[#7A1E1E] text-white rounded">
            Cari
        </button>

        @if(request('keyword'))
            <a href="{{ route('surat-masuk.index') }}"
               class="px-4 py-2 bg-gray-300 rounded">
                Reset
            </a>
        @endif
    </form>
</div>

{{-- ================= DESKTOP TABLE ================= --}}
<div class="hidden md:block">
<table class="w-full bg-white rounded shadow">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-3">No</th>
            <th class="p-3">Nomor Surat</th>
            <th class="p-3">Asal</th>
            <th class="p-3">Perihal</th>
            <th class="p-3">Tanggal</th>
            <th class="p-3">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $row)
        <tr class="border-t">
            <td class="p-3 text-center">{{ $loop->iteration }}</td>
            <td class="p-3">{{ $row->nomor_agenda }}</td>
            <td class="p-3">{{ $row->asal_surat }}</td>
            <td class="p-3">{{ $row->perihal }}</td>
            <td class="p-3">{{ $row->tanggal_surat }}</td>
            <td class="p-3">
                <div class="flex gap-2">

                    @if($row->file)
                    <a href="{{ route('surat-masuk.view', $row->id) }}"
                       target="_blank"
                       class="px-3 py-1 text-sm bg-blue-600 text-white rounded">
                        View
                    </a>

                    <a href="{{ route('surat-masuk.download', $row->id) }}"
                       class="px-3 py-1 text-sm bg-green-600 text-white rounded">
                        Download
                    </a>
                    @endif

                    @if(auth()->user()->role === 'admin')
                    <form method="POST"
                          action="{{ route('surat-masuk.destroy', $row->id) }}"
                          onsubmit="return confirm('Hapus surat ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="px-3 py-1 text-sm bg-[#7A1E1E] text-white rounded">
                            Hapus
                        </button>
                    </form>
                    @endif

                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="p-4 text-center text-gray-500">
                Data surat masuk belum ada
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
</div>

{{-- ================= MOBILE CARD ================= --}}
<div class="md:hidden space-y-4">
@foreach($data as $row)
<div class="bg-white p-4 rounded shadow">
    <p class="font-semibold text-[#7A1E1E]">
        {{ $row->nomor_surat }}
    </p>
    <p class="text-sm">Agenda: {{ $row->nomor_agenda }}</p>
    <p class="text-sm">Asal: {{ $row->asal_surat }}</p>
    <p class="text-sm">Perihal: {{ $row->perihal }}</p>
    <p class="text-sm">Tanggal: {{ $row->tanggal_surat }}</p>

    <div class="mt-3 flex gap-2 flex-wrap">
        @if($row->file)
        <a href="{{ route('surat-masuk.view', $row->id) }}"
           class="px-3 py-1 text-sm bg-blue-600 text-white rounded">
            View
        </a>
        <a href="{{ route('surat-masuk.download', $row->id) }}"
           class="px-3 py-1 text-sm bg-green-600 text-white rounded">
            Download
        </a>
        @endif

        @if(auth()->user()->role === 'admin')
        <form method="POST"
              action="{{ route('surat-masuk.destroy', $row->id) }}">
            @csrf
            @method('DELETE')
            <button class="px-3 py-1 text-sm bg-red-600 text-white rounded">
                Hapus
            </button>
        </form>
        @endif
    </div>
</div>
@endforeach
</div>

@endsection
