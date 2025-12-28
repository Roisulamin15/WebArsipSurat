@extends('layouts.app')

@section('title', 'Surat Keluar')

@section('content')

<div class="flex flex-col md:flex-row md:items-center gap-3 mb-6">

    <a href="{{ route('surat-keluar.create') }}"
       class="px-4 py-2 bg-[#7A1E1E] text-white rounded">
        + Tambah Surat Keluar
    </a>

    <form method="POST" action="#" enctype="multipart/form-data"
          class="flex items-center gap-2">
        @csrf
        <input type="file" name="ocr_file"
               class="border rounded px-2 py-1 text-sm">
        <button class="px-3 py-2 bg-[#7A1E1E] text-white rounded">
            Upload
        </button>
    </form>

    <form method="GET"
          action="{{ route('surat-keluar.index') }}"
          class="flex gap-2 w-full md:ml-auto md:w-auto">

        <input type="text"
               name="keyword"
               value="{{ request('keyword') }}"
               placeholder="Cari perihal..."
               class="border rounded px-3 py-2 md:w-64">

        <button class="px-4 py-2 bg-[#7A1E1E] text-white rounded">
            Cari
        </button>
    </form>
</div>

<table class="w-full bg-white rounded shadow">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-3">No</th>
            <th class="p-3">Nomor Surat</th>
            <th class="p-3">Tujuan</th>
            <th class="p-3">Perihal</th>
            <th class="p-3">Tanggal</th>
            <th class="p-3">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $row)
        <tr class="border-t">
            <td class="p-3">{{ $loop->iteration }}</td>
            <td class="p-3">{{ $row->nomor_surat }}</td>
            <td class="p-3">{{ $row->tujuan_surat }}</td>
            <td class="p-3">{{ $row->perihal }}</td>
            <td class="p-3">{{ $row->tanggal_surat }}</td>
            <td class="p-3 flex gap-2">

                @if($row->file)
                <a href="{{ route('surat-keluar.view', $row->id) }}"
                   class="px-3 py-1 bg-blue-600 text-white rounded text-sm">
                    View
                </a>
                <a href="{{ route('surat-keluar.download', $row->id) }}"
                   class="px-3 py-1 bg-green-600 text-white rounded text-sm">
                    Download
                </a>
                @endif

                @if(auth()->user()->role === 'admin')
                <form method="POST"
                      action="{{ route('surat-keluar.destroy', $row->id) }}">
                    @csrf
                    @method('DELETE')
                    <button class="px-3 py-1 bg-[#7A1E1E] text-white rounded">
                        Hapus
                    </button>
                </form>
                @endif
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

@endsection
