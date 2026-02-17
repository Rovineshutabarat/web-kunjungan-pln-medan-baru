@extends('layouts.app')

@section('content')
    <div class="w-full max-w-md mx-auto">
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-4 mb-2 max-[480px]:flex-col">
                <div
                    class="w-[70px] h-[70px] bg-blue-500 rounded-full flex items-center justify-center shadow-lg transition-transform duration-300 hover:rotate-[15deg]">
                    <span class="text-white font-extrabold text-2xl tracking-wide">PLN</span>
                </div>
                <div>
                    <h1 class="text-blue-500 text-3xl font-extrabold mb-1 max-[480px]:text-2xl">PLN</h1>
                    <p class="text-gray-500 text-sm font-medium">ULP Medan Baru</p>
                </div>
            </div>
        </div>

        <div
            class="bg-white rounded-2xl shadow-lg overflow-hidden border-t-4 border-yellow-500 animate-[fadeIn_0.6s_ease-out]">
            <div class="px-8 pt-8 pb-5 text-center">
                <h2 class="text-blue-500 text-2xl font-bold mb-1 max-[480px]:text-xl">Login Petugas</h2>
                <p class="text-gray-500 text-sm">Sistem Kunjungan Pelanggan</p>
            </div>

            <div class="mx-8 mb-6 p-4 rounded-lg bg-yellow-50 border-l-4 border-yellow-500 flex gap-3">
                <i class="fas fa-shield-alt text-yellow-500 text-lg mt-0.5"></i>
                <p class="text-yellow-800 text-sm leading-snug">
                    Akses terbatas hanya untuk petugas berwenang PT PLN (Persero) ULP Medan Baru
                </p>
            </div>

            @if (session('error'))
                <div
                    class="mx-8 mb-6 p-3 rounded-lg bg-red-100 border-l-4 border-red-500 flex items-center gap-3 text-red-700 text-sm">
                    <i class="fas fa-exclamation-circle text-lg"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form action="{{ route('auth.login.process') }}" method="POST" class="px-8 pb-8 space-y-6" id="loginForm">
                @csrf

                <div>
                    <label class="block mb-2 text-gray-700 font-semibold text-sm">Email</label>
                    <div class="relative">
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            placeholder="Masukkan email anda"
                            class="w-full px-3 py-2 border-2 rounded-lg text-base bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 transition
                {{ $errors->has('email') ? 'border-red-500 focus:border-red-500 focus:ring-red-100' : 'border-gray-300 focus:border-blue-500 focus:ring-blue-100' }}" />
                    </div>

                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>


                <div>
                    <label class="block mb-2 text-gray-700 font-semibold text-sm">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required placeholder="Masukkan password anda"
                            class="w-full px-3 py-2 border-2 rounded-lg text-base bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 transition
                {{ $errors->has('password') ? 'border-red-500 focus:border-red-500 focus:ring-red-100' : 'border-gray-300 focus:border-blue-500 focus:ring-blue-100' }}" />
                    </div>

                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>


                <button type="submit" id="submitBtn"
                    class="w-full px-3 py-2 text-white bg-yellow-500 rounded-lg text-lg font-bold flex items-center justify-center gap-2 transition hover:bg-yellow-600 hover:-translate-y-0.5 hover:shadow-lg active:translate-y-0">
                    <i class="fas fa-sign-in-alt"></i>
                    Login
                </button>
            </form>

            <div class="px-8 py-6 border-t text-center">
                <p class="text-gray-500 text-sm mb-4">Halaman internal PT PLN (Persero) ULP Medan Baru</p>
                <div class="flex justify-center gap-5 flex-wrap text-sm">
                    <a href="#" class="text-blue-500 hover:text-red-500 flex items-center gap-1">
                        <i class="fas fa-question-circle"></i> Bantuan
                    </a>
                    <a href="#" class="text-blue-500 hover:text-red-500 flex items-center gap-1">
                        <i class="fas fa-key"></i> Lupa Password
                    </a>
                    <a href="#" class="text-blue-500 hover:text-red-500 flex items-center gap-1">
                        <i class="fas fa-headset"></i> Kontak Admin
                    </a>
                </div>
            </div>
        </div>

        <div class="text-center mt-8 text-gray-500 text-xs leading-relaxed">
            <p>&copy; 2023 PT PLN (Persero) ULP Medan Baru. Hak Cipta Dilindungi Undang-Undang.</p>
            <p>Versi 1.0.0</p>
        </div>
    </div>
@endsection
