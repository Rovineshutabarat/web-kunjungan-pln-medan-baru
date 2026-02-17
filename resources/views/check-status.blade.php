@extends('layouts.main')

@section('main-content')
    <section class="py-12 bg-gradient-to-b from-white to-gray-50">
        <div class="max-w-4xl mx-auto px-6">

            <!-- Header -->
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-blue-700 mb-4">
                    Cek Status Kunjungan
                </h2>
                <p class="text-gray-500 text-sm max-w-2xl mx-auto">
                    Masukkan nomor identitas atau kode kunjungan untuk melihat status persetujuan kunjungan Anda.
                </p>
            </div>

            <!-- Card -->
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-10 md:p-14">

                <!-- Form -->
                <form action="{{ route('visit.check') }}" method="GET" class="space-y-8">

                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-3">
                            Kode Kunjungan
                        </label>
                        <input type="text" name="keyword" required placeholder="Contoh: KUNJUNGAN-0000007"
                            class="w-full rounded-2xl border p-3 border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full md:w-auto px-10 py-3 bg-blue-600 hover:bg-blue-700
                                   text-white font-semibold rounded-2xl shadow-md
                                   transition duration-300 hover:shadow-lg">
                            Cek Status
                        </button>
                    </div>

                </form>

                <!-- ===================== -->
                <!-- RESULT SECTION (Optional) -->
                <!-- ===================== -->
                @isset($visit)
                    <div class="mt-14 border-t pt-10">

                        <h3 class="text-xl font-semibold text-gray-800 mb-8">
                            Detail Status Kunjungan
                        </h3>

                        <div class="grid md:grid-cols-2 gap-8 text-sm">

                            <div>
                                <p class="text-gray-500">Nama</p>
                                <p class="font-medium text-gray-800">
                                    {{ $visit->visitor->full_name }}
                                </p>
                            </div>

                            <div>
                                <p class="text-gray-500">Keperluan</p>
                                <p class="font-medium text-gray-800">
                                    {{ $visit->purpose }}
                                </p>
                            </div>

                            <div>
                                <p class="text-gray-500">Tanggal Kunjungan</p>
                                <p class="font-medium text-gray-800">
                                    {{ $visit->visit_date }}
                                </p>
                            </div>

                            <div>
                                <p class="text-gray-500">Status</p>

                                @php
                                    $statusLabels = [
                                        'pending' => [
                                            'label' => 'Menunggu Persetujuan',
                                            'bg' => 'bg-yellow-100',
                                            'text' => 'text-yellow-700',
                                        ],
                                        'accepted' => [
                                            'label' => 'Diterima',
                                            'bg' => 'bg-blue-100',
                                            'text' => 'text-blue-700',
                                        ],
                                        'in_progress' => [
                                            'label' => 'Sedang Berlangsung',
                                            'bg' => 'bg-indigo-100',
                                            'text' => 'text-indigo-700',
                                        ],
                                        'complete' => [
                                            'label' => 'Selesai',
                                            'bg' => 'bg-green-100',
                                            'text' => 'text-green-700',
                                        ],
                                        'cancelled' => [
                                            'label' => 'Dibatalkan',
                                            'bg' => 'bg-red-100',
                                            'text' => 'text-red-700',
                                        ],
                                    ];

                                    $status = $statusLabels[$visit->status] ?? [
                                        'label' => 'Unknown',
                                        'bg' => 'bg-gray-100',
                                        'text' => 'text-gray-700',
                                    ];
                                @endphp

                                <span
                                    class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold {{ $status['bg'] }} {{ $status['text'] }}">
                                    {{ $status['label'] }}
                                </span>
                            </div>


                        </div>

                    </div>
                @endisset

            </div>

        </div>
    </section>
@endsection
