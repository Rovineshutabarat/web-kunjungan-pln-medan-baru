@extends('layouts.main')

@section('main-content')
    <section class="relative bg-gradient-to-br from-blue-700 to-indigo-800 text-white py-28">
        <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-16 items-center">
            <div>
                <h2 class="text-4xl md:text-5xl font-bold leading-tight mb-6">
                    Registrasi Kunjungan Resmi
                    <br>PLN ULP Medan Baru
                </h2>
                <p class="text-blue-200 mb-8 text-lg">
                    Sistem digital untuk mempermudah proses kunjungan
                    layanan pelanggan kelistrikan secara profesional,
                    aman, dan terstruktur.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('visit') }}"
                        class="bg-white text-blue-700 px-6 py-3 rounded-xl font-semibold hover:bg-gray-100 transition">
                        Daftar Sekarang
                    </a>
                    <a href="{{ route('visit.check') }}"
                        class="border border-white px-6 py-3 rounded-xl font-semibold hover:bg-white hover:text-blue-700 transition">
                        Cek Status
                    </a>
                </div>
            </div>

            <div class="bg-white/10 backdrop-blur rounded-3xl h-80 shadow-2xl border overflow-hidden border-white/20">
                <img src="{{ asset('pln.jpeg') }}" alt="Logo" class="object-center h-[33rem] w-full">
            </div>

        </div>
    </section>

    <section id="about" class="py-24 bg-white">
        <div class="max-w-5xl mx-auto px-6 text-center">
            <h3 class="text-3xl font-bold text-blue-700 mb-6">
                Tentang PLN ULP Medan Baru
            </h3>
            <p class="text-gray-600 leading-relaxed text-lg">
                PLN ULP Medan Baru merupakan unit layanan pelanggan
                PT PLN (Persero) yang melayani kebutuhan kelistrikan
                masyarakat di wilayah Medan Baru dan sekitarnya.
                Sistem registrasi kunjungan ini dirancang untuk
                meningkatkan efisiensi pelayanan serta keamanan
                data pengunjung.
            </p>
        </div>
    </section>

    <section class="py-24 bg-gray-50">
        <div class="max-w-6xl mx-auto px-6">

            <div class="text-center mb-16">
                <h3 class="text-3xl font-bold text-blue-700 mb-4">
                    Keunggulan Sistem Registrasi
                </h3>
                <p class="text-gray-500 text-sm">
                    Dirancang untuk efisiensi, keamanan, dan kenyamanan pengunjung.
                </p>
            </div>

            <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-4 gap-8 text-center">
                <div class="bg-gray-50 p-8 rounded-2xl shadow-sm">
                    <h4 class="text-3xl font-bold text-blue-600">24/7</h4>
                    <p class="text-sm text-gray-500 mt-2">Monitoring Sistem</p>
                </div>
                <div class="bg-gray-50 p-8 rounded-2xl shadow-sm">
                    <h4 class="text-3xl font-bold text-blue-600">&lt; 5 Menit</h4>
                    <p class="text-sm text-gray-500 mt-2">Rata-rata Registrasi</p>
                </div>
                <div class="bg-gray-50 p-8 rounded-2xl shadow-sm">
                    <h4 class="text-3xl font-bold text-blue-600">100%</h4>
                    <p class="text-sm text-gray-500 mt-2">Data Tersimpan Aman</p>
                </div>
                <div class="bg-gray-50 p-8 rounded-2xl shadow-sm">
                    <h4 class="text-3xl font-bold text-blue-600">Resmi</h4>
                    <p class="text-sm text-gray-500 mt-2">Unit Layanan PLN</p>
                </div>
            </div>
        </div>
    </section>

    <section id="services" class="py-24 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            <h3 class="text-3xl font-bold text-blue-700 text-center mb-12">
                Layanan Pengunjung
            </h3>

            <div class="grid md:grid-cols-3 gap-10">
                <div class="p-8 bg-gray-50 rounded-3xl shadow-sm hover:shadow-md transition">
                    <h4 class="font-semibold text-lg mb-3">
                        Registrasi Online
                    </h4>
                    <p class="text-sm text-gray-600">
                        Isi formulir kunjungan sebelum datang
                        untuk mempercepat proses pelayanan.
                    </p>
                </div>

                <div class="p-8 bg-gray-50 rounded-3xl shadow-sm hover:shadow-md transition">
                    <h4 class="font-semibold text-lg mb-3">
                        Check-in & Check-out
                    </h4>
                    <p class="text-sm text-gray-600">
                        Sistem pencatatan kehadiran pengunjung
                        secara digital dan terintegrasi.
                    </p>
                </div>

                <div class="p-8 bg-gray-50 rounded-3xl shadow-sm hover:shadow-md transition">
                    <h4 class="font-semibold text-lg mb-3">
                        Informasi Layanan
                    </h4>
                    <p class="text-sm text-gray-600">
                        Dukungan untuk pemasangan baru,
                        perubahan daya, dan konsultasi pelanggan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="alur" class="py-24 bg-gray-50">
        <div class="max-w-6xl mx-auto px-6">
            <h3 class="text-3xl font-bold text-blue-700 text-center mb-16">
                Alur Kunjungan
            </h3>

            <div class="grid md:grid-cols-4 gap-8 text-center">
                <div class="space-y-4">
                    <div
                        class="w-14 h-14 mx-auto rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">
                        1
                    </div>
                    <h4 class="font-semibold">Isi Formulir</h4>
                    <p class="text-sm text-gray-600">
                        Daftar secara online sebelum datang ke kantor.
                    </p>
                </div>

                <div class="space-y-4">
                    <div
                        class="w-14 h-14 mx-auto rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">
                        2
                    </div>
                    <h4 class="font-semibold">Verifikasi</h4>
                    <p class="text-sm text-gray-600">
                        Data diverifikasi oleh petugas layanan.
                    </p>
                </div>

                <div class="space-y-4">
                    <div
                        class="w-14 h-14 mx-auto rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">
                        3
                    </div>
                    <h4 class="font-semibold">Check-in</h4>
                    <p class="text-sm text-gray-600">
                        Lakukan check-in saat tiba di lokasi.
                    </p>
                </div>

                <div class="space-y-4">
                    <div
                        class="w-14 h-14 mx-auto rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">
                        4
                    </div>
                    <h4 class="font-semibold">Pelayanan</h4>
                    <p class="text-sm text-gray-600">
                        Petugas membantu sesuai kebutuhan layanan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="faq" class="py-24 bg-white">
        <div class="max-w-4xl mx-auto px-6">
            <h3 class="text-3xl font-bold text-blue-700 text-center mb-12">
                Pertanyaan Umum
            </h3>

            <div class="space-y-4">
                <div class="bg-gray-50 p-6 rounded-2xl">
                    <h4 class="font-semibold mb-2">Apakah wajib registrasi sebelum datang?</h4>
                    <p class="text-sm text-gray-600">
                        Disarankan untuk mempercepat proses pelayanan dan mengurangi waktu tunggu.
                    </p>
                </div>

                <div class="bg-gray-50 p-6 rounded-2xl">
                    <h4 class="font-semibold mb-2">Bagaimana cara cek status kunjungan?</h4>
                    <p class="text-sm text-gray-600">
                        Gunakan fitur "Cek Status" dengan memasukkan data registrasi Anda.
                    </p>
                </div>

                <div class="bg-gray-50 p-6 rounded-2xl">
                    <h4 class="font-semibold mb-2">Apakah data saya aman?</h4>
                    <p class="text-sm text-gray-600">
                        Data pengunjung dilindungi sesuai standar keamanan sistem informasi.
                    </p>
                </div>
            </div>
        </div>
    </section>


    <section id="contact" class="py-24 bg-gray-100">
        <div class="max-w-6xl mx-auto px-6">
            <h3 class="text-3xl font-bold text-blue-700 text-center mb-16">
                Kontak & Informasi Kantor
            </h3>

            <div class="grid md:grid-cols-2 gap-12 items-stretch">
                <div class="bg-white rounded-3xl p-10 shadow-sm space-y-8">
                    <div>
                        <p class="text-gray-800 font-semibold mb-1">Alamat Kantor</p>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Jl. Sei Batu Gingging Ps. X, Medan Baru,
                            Kota Medan, Sumatera Utara
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-800 font-semibold mb-1">Jam Operasional</p>
                        <p class="text-gray-600 text-sm">
                            Senin – Jumat | 08.00 – 16.45 WIB
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-800 font-semibold mb-1">Telepon</p>
                        <p class="text-gray-600 text-sm">
                            (Nomor Kantor Resmi)
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-800 font-semibold mb-1">Email</p>
                        <p class="text-gray-600 text-sm">
                            (Email Resmi Unit Layanan)
                        </p>
                    </div>
                </div>
                <div class="bg-white rounded-3xl p-7 shadow-sm overflow-hidden">
                    <div class="w-full h-full min-h-[350px] rounded-3xl overflow-hidden">
                        <iframe src="https://www.google.com/maps?q=PLN%20ULP%20Medan%20Baru&output=embed"
                            class="w-full h-full" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>


            </div>
        </div>
    </section>
@endsection
