@extends('layouts.app')

@section('title', 'Tambah Surat Keluar')

@section('content')

<form method="POST"
      action="{{ route('surat-keluar.store') }}"
      enctype="multipart/form-data"
      class="bg-white p-6 rounded shadow max-w-xl space-y-3">

    @csrf

    {{-- Nomor Surat --}}
    <input type="text"
           name="nomor_surat"
           placeholder="Nomor Surat"
           class="w-full border rounded px-3 py-2"
           required>

    {{-- Tujuan Surat --}}
    <input type="text"
           name="tujuan_surat"
           placeholder="Tujuan Surat"
           class="w-full border rounded px-3 py-2"
           required>

    {{-- Tanggal --}}
    <input type="date"
           name="tanggal_surat"
           class="w-full border rounded px-3 py-2"
           required>

    {{-- Perihal --}}
    <input type="text"
           name="perihal"
           placeholder="Perihal"
           class="w-full border rounded px-3 py-2"
           required>

    {{-- File Surat --}}
    <input type="file"
           name="file"
           class="w-full">


    <button type="submit"
            class="mt-4 px-4 py-2 bg-[#7A1E1E] text-white rounded hover:bg-[#4B0F0F]">
        Simpan
    </button>

</form>

@endsection
