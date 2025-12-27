@extends('layouts.app')

@section('title', 'Surat Keluar')

@section('content')

<div class="flex flex-col md:flex-row md:items-center gap-3 mb-4">

    {{-- TAMBAH --}}
    <a href="{{ route('surat-keluar.create') }}"
       class="px-4 py-2 bg-[#7A1E1E] text-white rounded hover:bg-[#4B0F0F]">
        + Tambah Surat Keluar
    </a>

    {{-- UPLOAD OCR (SIAP EASY OCR) --}}
    <form method="POST"
          action="#"
          enctype="multipart/form-data"
          class="flex items-center gap-2">
        @csrf

        <input type="file"
               name="ocr_file"
               accept=".pdf,.jpg,.jpeg,.png"
               class="border rounded px-2 py-1 text-sm">

        <button type="submit"
                class="px-3 py-2 bg-[#7A1E1E] text-white rounded hover:bg-[#4B0F0F]">
            Upload
        </button>
    </form>

    {{-- SEARCH --}}
    <form method="GET"
          action="{{ route('surat-keluar.index') }}"
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
            <a href="{{ route('surat-keluar.index') }}"
               class="px-4 py-2 bg-gray-300 rounded">
                Reset
            </a>
        @endif
    </form>
</div>

{{-- DESKTOP --}}
<div class="hidden md:block">
<table class="w-full bg-white rounded shadow">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-3 text-left">Nomor</th>
            <th class="p-3 text-left">Nomor Surat</th>
            <th class="p-3 text-left">Tujuan</th>
            <th class="p-3 text-left">Perihal</th>
            <th class="p-3 text-left">Tanggal</th>
            <th class="p-3 text-left">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $row)
        <tr class="border-t">
            <td class="p-3">{{ $row->nomor }}</td>
            <td class="p-3">{{ $row->nomor_surat }}</td>
            <td class="p-3">{{ $row->tujuan_surat }}</td>
            <td class="p-3">{{ $row->perihal }}</td>
            <td class="p-3">{{ $row->tanggal_surat }}</td>
            <td class="p-3">
                <div class="flex gap-2">

                    @if($row->file)
                    <a href="{{ route('surat-keluar.view', $row->id) }}"
                       class="px-3 py-1 text-sm bg-blue-600 text-white rounded">
                        View
                    </a>

                    <a href="{{ route('surat-keluar.download', $row->id) }}"
                       class="px-3 py-1 text-sm bg-green-600 text-white rounded">
                        Download
                    </a>
                    @endif

                    <form action="{{ route('surat-keluar.destroy', $row->id) }}"
                          method="POST"
                          onsubmit="return confirm('Hapus surat ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="px-3 py-1 text-sm bg-[#7A1E1E] text-white rounded hover:bg-[#4B0F0F]">
                            Hapus
                        </button>
                    </form>

                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="p-4 text-center text-gray-500">
                Data surat keluar belum ada
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
</div>

@endsection
