@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')

<div class="max-w-3xl mx-auto space-y-6">

    {{-- ================= UPDATE PROFIL ================= --}}
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-1">
            Informasi Profil
        </h2>
        <p class="text-sm text-gray-500 mb-4">
            Perbarui nama dan alamat email akun Anda
        </p>

        @include('profile.partials.update-profile-information-form')
    </div>

    <!-- {{-- ================= UPDATE PASSWORD ================= --}}
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-1">
            Ganti Password
        </h2>
        <p class="text-sm text-gray-500 mb-4">
            Gunakan password yang kuat untuk menjaga keamanan akun
        </p>

        @include('profile.partials.update-password-form')
    </div> -->

</div>

@endsection
