@extends('layouts.app')

@section('content')
    <header class="bg-white/90 backdrop-blur shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-x-2">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="h-full w-10 object-cover">
                <h1 class="text-xl font-bold text-blue-700 tracking-wide">
                    PLN ULP Medan Baru
                </h1>
            </div>
            <nav class="hidden md:flex gap-8 text-sm font-medium">

                <a href="/" class="relative group text-gray-700 hover:text-blue-600 transition">
                    Beranda
                    <span
                        class="absolute left-0 -bottom-1 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                </a>

                <a href="#about" class="relative group text-gray-700 hover:text-blue-600 transition">
                    Tentang
                    <span
                        class="absolute left-0 -bottom-1 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                </a>

                <a href="#services" class="relative group text-gray-700 hover:text-blue-600 transition">
                    Layanan
                    <span
                        class="absolute left-0 -bottom-1 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                </a>

                <a href="#alur" class="relative group text-gray-700 hover:text-blue-600 transition">
                    Alur
                    <span
                        class="absolute left-0 -bottom-1 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                </a>

                <a href="#faq" class="relative group text-gray-700 hover:text-blue-600 transition">
                    FAQ
                    <span
                        class="absolute left-0 -bottom-1 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                </a>

                <a href="#contact" class="relative group text-gray-700 hover:text-blue-600 transition">
                    Kontak
                    <span
                        class="absolute left-0 -bottom-1 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                </a>

            </nav>

            <a href="{{ route('visit') }}"
                class="bg-blue-600 text-white px-5 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                Daftar Kunjungan
            </a>
        </div>
    </header>

    @yield('main-content')

    <footer class="bg-gray-900 text-gray-400 pt-16 pb-10">
        <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-4 gap-10 text-sm">
            <div>
                <h4 class="text-white font-semibold mb-4">
                    PLN ULP Medan Baru
                </h4>
                <p class="leading-relaxed">
                    Sistem registrasi kunjungan resmi untuk
                    mendukung pelayanan pelanggan yang lebih
                    efisien dan profesional.
                </p>
            </div>

            <!-- Navigasi -->
            <div>
                <h4 class="text-white font-semibold mb-4">Navigasi</h4>
                <ul class="space-y-2">
                    <li><a href="#about" class="hover:text-white transition">Tentang</a></li>
                    <li><a href="#services" class="hover:text-white transition">Layanan</a></li>
                    <li><a href="#contact" class="hover:text-white transition">Kontak</a></li>
                    <li><a href="/register" class="hover:text-white transition">Registrasi</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-semibold mb-4">Informasi</h4>
                <ul class="space-y-2">
                    <li>Kebijakan Privasi</li>
                    <li>Syarat & Ketentuan</li>
                    <li>Keamanan Data</li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-semibold mb-4">Hubungi Kami</h4>
                <p class="mb-2">(Nomor Telepon Resmi)</p>
                <p>(Email Resmi)</p>
            </div>
        </div>

        <div class="border-t border-gray-800 mt-12 pt-6 text-center text-xs text-gray-500">
            © 2026 PLN ULP Medan Baru. Seluruh data pengunjung bersifat rahasia dan dilindungi.
        </div>
    </footer>
@endsection
