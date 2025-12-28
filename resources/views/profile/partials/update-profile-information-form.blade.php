<form method="POST"
      action="{{ route('profile.update') }}"
      class="space-y-5">

    @csrf
    @method('PATCH')

    {{-- NAMA --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Nama Lengkap
        </label>
        <input type="text"
               name="name"
               value="{{ old('name', $user->name) }}"
               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-[#7A1E1E]/30"
               required>
        @error('name')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- EMAIL --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Email
        </label>
        <input type="email"
               name="email"
               value="{{ old('email', $user->email) }}"
               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-[#7A1E1E]/30"
               required>
        @error('email')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- BUTTON --}}
    <div class="flex items-center gap-3 pt-2">
        <button
            class="bg-[#7A1E1E] text-white px-5 py-2 rounded hover:bg-[#4B0F0F]">
            Simpan Perubahan
        </button>

        @if (session('status') === 'profile-updated')
            <span class="text-sm text-green-600">
                Profil berhasil diperbarui
            </span>
        @endif
    </div>

</form>
