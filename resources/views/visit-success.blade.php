@extends('layouts.main')

@section('main-content')
    <div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-green-500 p-6 text-center">
                    <div class="mx-auto w-16 h-16 bg-white rounded-full flex items-center justify-center mb-3">
                        <i class="fas fa-check text-green-500 text-3xl"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-white">Berhasil!</h1>
                    <p class="text-sm mt-1 text-white">Kunjungan Anda telah terdaftar</p>
                </div>

                <div class="p-6">
                    <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-4 mb-6 text-center">
                        <p class="text-blue-600 text-xs uppercase font-semibold mb-1">ID Kunjungan</p>
                        <h2 class="text-3xl font-bold text-blue-900 font-mono" id="visitId">
                            {{ $visit->visit_id }}
                        </h2>
                        <button id="copyBtn" class="mt-2 text-blue-600 hover:text-blue-800 text-sm font-medium">
                            <i class="fas fa-copy mr-1"></i>Salin ID
                        </button>


                    </div>

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Nama:</span>
                            <span class="font-semibold text-gray-900">{{ $visit->visitor->full_name }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tanggal:</span>
                            <span
                                class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($visit->visit_date)->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Jam:</span>
                            <span
                                class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($visit->check_in)->format('H:i') }}
                                WIB</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tujuan:</span>
                            <span class="font-semibold text-gray-900">{{ $visit->purpose }}</span>
                        </div>
                    </div>

                    <div class=" rounded-lg p-3 mb-6">
                        <p class=" text-sm flex items-center">
                            <i class="fas fa-clock mr-2"></i>
                            <span><strong>Status:</strong> Menunggu persetujuan admin</span>
                        </p>
                    </div>

                    <div class="space-y-2">
                        <button onclick="window.print()"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition-all">
                            <i class="fas fa-print mr-2"></i>Cetak Bukti
                        </button>
                        <a href="{{ route('index') }}"
                            class="block w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-3 px-4 rounded-lg transition-all text-center">
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>

            <p class="text-center text-gray-600 text-sm mt-4">
                Simpan ID kunjungan ini untuk keperluan check-in
            </p>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function copyVisitId() {
            const visitId = document.getElementById('visitId').textContent.trim();
            const copyBtn = document.getElementById('copyBtn');

            copyBtn.addEventListener('click', async () => {
                const toastMagic = new ToastMagic();
                try {
                    await navigator.clipboard.writeText(visitId);
                    toastMagic.success("Success!", "Text copied to clipboard!");
                } catch (err) {
                    toastMagic.success("Success!", "Failed to copy text.");
                }
            });
        }

        copyVisitId();
    </script>


    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .max-w-md,
            .max-w-md * {
                visibility: visible;
            }

            .max-w-md {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            button,
            a {
                display: none !important;
            }
        }
    </style>
@endpush
