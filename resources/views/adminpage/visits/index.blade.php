@extends('layouts.adminpage')

@section('admin-content')
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Manajemen Kunjungan</h1>
                <p class="mt-1 text-sm text-gray-500">Manage and track all visitor records</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('visit.export.excel') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-download mr-2"></i>Export Excel
                </a>
                <a href="{{ route('visit.export.pdf') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-download mr-2"></i>Export PDF
                </a>

                <a href="{{ route('adminpage.visit.create') }}"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-plus mr-2"></i>Kunjungan Baru
                </a>
            </div>
        </div>
    </div>

    <form method="GET" id="filterForm" class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-4">
        <div class="flex flex-col lg:flex-row lg:items-center gap-4">

            <div class="flex-1">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama, nik, atau tujuan kunjungan..."
                        class="w-80 pl-10 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">

                <select name="status"
                    class="px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="complete" {{ request('status') == 'complete' ? 'selected' : '' }}>Selesai</option>
                </select>

                <select name="date_filter"
                    class="px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Waktu Kunjungan</option>
                    <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Hari ini</option>
                    <option value="last7" {{ request('date_filter') == 'last7' ? 'selected' : '' }}>7 Hari Terakhir
                    </option>
                </select>

                <a href="{{ route('adminpage.visit.index') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                    Atur Ulang
                </a>
            </div>
        </div>
    </form>


    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            ID
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Nama
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            NIK
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            ID Kunjungan
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Tujuan Kunjungan
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Tanggal Kunjungan
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Check In/Out
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($visits as $visit)
                        <tr class="hover:bg-gray-50 transition-all duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900">{{ $visit->id }}</span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900">
                                    {{ $visit->visitor->full_name }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900">
                                    {{ $visit->visitor->identity_number }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900">
                                    {{ $visit->visit_id }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900">
                                    {{ $visit->purpose }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm text-gray-900">{{ $visit->visit_date }}</p>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm text-gray-900">
                                    <i class="fas fa-sign-in-alt text-green-600 mr-1"></i>
                                    {{ $visit->check_in }}
                                </p>

                                @if ($visit->check_out)
                                    <p class="text-sm text-gray-900">
                                        <i class="fas fa-sign-out-alt text-red-600 mr-1"></i>
                                        {{ $visit->check_out }}
                                    </p>
                                @else
                                    <p class="text-xs text-gray-500">
                                        <i class="fas fa-clock mr-1"></i>
                                        Belum Checkout
                                    </p>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-500',
                                        'accepted' => 'bg-blue-500',
                                        'in_progress' => 'bg-indigo-500',
                                        'complete' => 'bg-green-500',
                                        'cancelled' => 'bg-red-500',
                                    ];
                                @endphp

                                <span
                                    class="inline-flex items-center px-2.5 py-1 text-xs font-semibold text-white rounded-full {{ $statusColors[$visit->status] ?? 'bg-gray-500' }}">
                                    <span
                                        class="w-1.5 h-1.5 bg-white rounded-full mr-1.5 {{ in_array($visit->status, ['pending', 'accepted', 'in_progress']) ? 'animate-pulse' : '' }}"></span>
                                    {{ ucfirst(str_replace('_', ' ', $visit->status)) }}
                                </span>
                            </td>


                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    @php
                                        $statusOrder = ['pending', 'accepted', 'in_progress', 'complete', 'cancelled'];
                                        $currentIndex = array_search($visit->status, $statusOrder);
                                        $nextStatus = $statusOrder[$currentIndex + 1] ?? null;
                                    @endphp

                                    @if ($nextStatus && !in_array($visit->status, ['complete', 'cancelled']))
                                        <a href="{{ route('adminpage.visit.update.status', ['id' => $visit->id, 'status' => $nextStatus]) }}"
                                            class="p-1.5 text-gray-600 hover:text-green-600 hover:bg-green-50 rounded transition-all"
                                            title="Update Status to {{ ucfirst(str_replace('_', ' ', $nextStatus)) }}">
                                            <i class="fas fa-sync-alt text-sm"></i>
                                        </a>
                                    @endif

                                    <button onclick="openModal({{ json_encode($visit) }})"
                                        class="p-1.5 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded transition-all"
                                        title="View Details">
                                        <i class="fas fa-eye text-sm"></i>
                                    </button>

                                    <a href="{{ route('adminpage.visit.destroy', ['id' => $visit->id]) }}"
                                        class="p-1.5 text-gray-600 hover:text-red-600 hover:bg-red-50 rounded transition-all"
                                        title="Delete"
                                        onclick="return confirm('Are you sure you want to delete this visit record?')">
                                        <i class="fas fa-trash text-sm"></i>
                                    </a>
                                </div>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($visits->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                <div class="flex items-center justify-between">

                    <p class="text-sm text-gray-600">
                        Showing
                        <span class="font-medium text-gray-900">{{ $visits->firstItem() }}</span>
                        to
                        <span class="font-medium text-gray-900">{{ $visits->lastItem() }}</span>
                        of
                        <span class="font-medium text-gray-900">{{ $visits->total() }}</span>
                        results
                    </p>

                    <div class="flex items-center space-x-1">
                        @if ($visits->onFirstPage())
                            <span class="px-3 py-1.5 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                Previous
                            </span>
                        @else
                            <a href="{{ $visits->previousPageUrl() }}"
                                class="px-3 py-1.5 text-sm text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                Previous
                            </a>
                        @endif

                        @foreach ($visits->getUrlRange(1, $visits->lastPage()) as $page => $url)
                            @if ($page == $visits->currentPage())
                                <span class="px-3 py-1.5 text-sm font-semibold text-white bg-blue-600 rounded-lg">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}"
                                    class="px-3 py-1.5 text-sm text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        @if ($visits->hasMorePages())
                            <a href="{{ $visits->nextPageUrl() }}"
                                class="px-3 py-1.5 text-sm text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                Next
                            </a>
                        @else
                            <span class="px-3 py-1.5 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                Next
                            </span>
                        @endif

                    </div>
                </div>
            </div>
        @endif
    </div>

    <div id="detailModal"
        class="hidden fixed inset-0 bg-black bg-opacity-60 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[95vh] overflow-hidden animate-fadeIn">

            <div class="sticky top-0 px-8 py-6 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center">
                        <i class="fas fa-user-check text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold">Detail Kunjungan</h3>
                        <p class="text-sm mt-0.5">Informasi Lengkap Kunjungan</p>
                    </div>
                </div>
                <button onclick="closeModal()"
                    class="w-10 h-10 rounded-lg transition-all duration-200 flex items-center justify-center">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="p-8 space-y-8 overflow-y-auto max-h-[calc(95vh-180px)]">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="rounded-xl overflow-hidden transition-all duration-300">
                        <div class="bg-gray-100 px-4 py-3">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-id-card"></i>
                                <h4 class="font-semibold text-sm">Foto KTP</h4>
                            </div>
                        </div>
                        <div class="p-4">
                            <div id="modal-ktp-photo"
                                class="relative aspect-[16/10] bg-gray-100 rounded-lg overflow-hidden group cursor-pointer">
                                <img src="" alt="KTP Photo"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <div
                                    class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300 flex items-center justify-center">
                                    <button type="button" onclick="viewFullImage(event, 'ktp')"
                                        class="opacity-0 group-hover:opacity-100 bg-white text-gray-900 px-4 py-2 rounded-lg font-medium text-sm shadow-lg transition-all duration-300 transform scale-90 group-hover:scale-100">
                                        <i class="fas fa-search-plus mr-2"></i>View Full
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl overflow-hidden transition-all duration-300">
                        <div class="bg-gray-100 px-4 py-3">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-camera"></i>
                                <h4 class="font-semibold text-sm">Foto Selfie</h4>
                            </div>
                        </div>
                        <div class="p-4">
                            <div id="modal-selfie-photo"
                                class="relative aspect-[16/10] bg-gray-100 rounded-lg overflow-hidden group cursor-pointer">
                                <img src="" alt="Selfie Photo"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <div
                                    class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300 flex items-center justify-center">
                                    <button type="button" onclick="viewFullImage(event, 'selfie')"
                                        class="opacity-0 group-hover:opacity-100 bg-white text-gray-900 px-4 py-2 rounded-lg font-medium text-sm shadow-lg transition-all duration-300 transform scale-90 group-hover:scale-100">
                                        <i class="fas fa-search-plus mr-2"></i>View Full
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl overflow-hidden shadow-lg">
                    <div class="bg-gray-100 px-6 py-4">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-user text-gray-600"></i>
                            <h4 class="font-bold text-gray-900 text-base">Informasi Pengunjung</h4>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Nama</label>
                                <p class="text-base font-semibold text-gray-900" id="modal-full-name">-</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">NIK</label>
                                <p class="text-base font-semibold text-gray-900 font-mono" id="modal-nik">-</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">No
                                    Handphone</label>
                                <p class="text-base font-semibold text-gray-900" id="modal-phone">-</p>
                            </div>
                            <div class="space-y-1">
                                <p id="modal-status"
                                    class="inline-flex items-center gap-2 px-3 py-1 text-xs font-semibold rounded-lg shadow-sm">
                                    -
                                </p>
                            </div>

                            <div class="space-y-1 md:col-span-2">
                                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Alamat</label>
                                <p class="text-base font-semibold text-gray-900" id="modal-address">-</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl overflow-hidden shadow-lg">
                    <div class="bg-gray-100 px-6 py-4">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-calendar-check text-gray-600"></i>
                            <h4 class="font-bold text-gray-900 text-base">Informasi Kunjungan</h4>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1 md:col-span-2">
                                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Tujuan
                                    Kunjungan</label>
                                <p class="text-base font-semibold text-gray-900" id="modal-purpose">-</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Tanggal
                                    Kunjungan</label>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-calendar text-gray-600"></i>
                                    <p class="text-base font-semibold text-gray-900" id="modal-visit-date">-</p>
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Durasi</label>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-clock text-gray-600"></i>
                                    <p class="text-base font-semibold text-gray-900" id="modal-duration">-</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6 pt-6 border-t border-gray-200">
                            <div class="border rounded-lg p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-sign-in-alt text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-700 uppercase">Waktu Check In</p>
                                        <p class="text-lg font-bold text-gray-700" id="modal-check-in">-</p>
                                    </div>
                                </div>
                            </div>

                            <div id="modal-check-out-box" class="border rounded-lg p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-sign-out-alt text-red-500"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-700 uppercase">Waktu Check Out</p>
                                        <p class="text-lg font-bold text-gray-700" id="modal-check-out">-</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="border-t border-gray-200 px-8 py-5 bg-gray-50 flex items-center justify-between gap-3">
                <p class="text-sm text-gray-500">
                    <i class="fas fa-info-circle mr-1"></i>
                    Semua informasi pengunjung bersifat rahasia.
                </p>
                <div class="flex gap-3">
                    <button onclick="closeModal()"
                        class="px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-all duration-200 shadow-sm">
                        <i class="fas fa-times mr-2"></i>Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="imageViewerModal"
        class="hidden fixed inset-0 bg-black bg-opacity-90 z-[60] flex items-center justify-center p-4"
        onclick="closeImageViewer()">
        <button onclick="closeImageViewer()"
            class="absolute top-6 right-6 text-white hover:text-gray-300 transition-colors z-10">
            <i class="fas fa-times text-3xl"></i>
        </button>
        <div class="max-w-6xl max-h-[90vh] relative" onclick="event.stopPropagation()">
            <img id="fullImageView" src="" alt="Full View"
                class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl">
        </div>
    </div>
@endsection

@push('styles')
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
        }

        .overflow-y-auto::-webkit-scrollbar {
            width: 8px;
        }

        .overflow-y-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
@endpush

@push('scripts')
    <script>
        const form = document.getElementById('filterForm');

        document.querySelectorAll('#filterForm select').forEach(select => {
            select.addEventListener('change', () => {
                form.submit();
            });
        });

        let currentKtpPhoto = '';
        let currentSelfiePhoto = '';

        function openModal(visit) {
            console.log(visit)
            currentKtpPhoto = visit.visitor.id_card_image.path || '';
            currentSelfiePhoto = visit.selfie_image.path || '';

            document.getElementById('modal-full-name').textContent = visit.visitor.full_name || '-';
            document.getElementById('modal-nik').textContent = visit.visitor.identity_number || '-';
            document.getElementById('modal-phone').textContent = visit.visitor.phone_number || '-';
            document.getElementById('modal-address').textContent = visit.visitor.address || '-';
            document.getElementById('modal-purpose').textContent = visit.purpose || '-';
            document.getElementById('modal-visit-date').textContent = visit.visit_date || '-';
            document.getElementById('modal-check-in').textContent = visit.check_in || '-';

            const ktpPhotoDiv = document.getElementById('modal-ktp-photo');
            const ktpImg = ktpPhotoDiv.querySelector('img');
            if (currentKtpPhoto) {
                console.log(currentKtpPhoto);

                ktpImg.src = `/storage/${currentKtpPhoto}`;
                ktpImg.style.display = 'block';
            } else {
                ktpImg.style.display = 'none';
                ktpPhotoDiv.innerHTML = `
                    <div class="flex items-center justify-center h-full">
                        <div class="text-center">
                            <i class="fas fa-image text-gray-400 text-4xl mb-2"></i>
                            <p class="text-sm text-gray-500">No KTP photo</p>
                        </div>
                    </div>
                `;
            }

            const selfiePhotoDiv = document.getElementById('modal-selfie-photo');
            const selfieImg = selfiePhotoDiv.querySelector('img');
            if (currentSelfiePhoto) {
                selfieImg.src = `http://localhost:8000/storage/${currentSelfiePhoto}`;
                selfieImg.style.display = 'block';
            } else {
                selfieImg.style.display = 'none';
                selfiePhotoDiv.innerHTML = `
                    <div class="flex items-center justify-center h-full">
                        <div class="text-center">
                            <i class="fas fa-image text-gray-400 text-4xl mb-2"></i>
                            <p class="text-sm text-gray-500">No selfie photo</p>
                        </div>
                    </div>
                `;
            }

            if (visit.check_out) {
                const duration = calculateDuration(visit.check_in, visit.check_out);
                document.getElementById('modal-duration').textContent = duration;
            } else {
                document.getElementById('modal-duration').textContent = 'Ongoing';
            }

            const checkOutBox = document.getElementById('modal-check-out-box');
            if (visit.check_out) {
                checkOutBox.className = 'border rounded-lg p-4';
                checkOutBox.querySelector('.text-gray-700').textContent = 'Waktu Chekout';
                document.getElementById('modal-check-out').textContent = visit.check_out;
            } else {
                checkOutBox.className = 'bg-gray-50 border border-gray-200 rounded-lg p-4';
                checkOutBox.innerHTML = `
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-gray-500"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase">Waktu Chekout</p>
                            <p class="text-lg font-bold text-gray-700">Belum Checkout</p>
                        </div>
                    </div>
                `;
            }

            const statusElement = document.getElementById('modal-status');

            const statusColors = {
                pending: {
                    bg: 'bg-yellow-500',
                    label: 'Menunggu Persetujuan',
                    pulse: true
                },
                accepted: {
                    bg: 'bg-blue-500',
                    label: 'Diterima',
                    pulse: true
                },
                in_progress: {
                    bg: 'bg-indigo-500',
                    label: 'Sedang Berlangsung',
                    pulse: true
                },
                complete: {
                    bg: 'bg-green-500',
                    label: 'Selesai',
                    pulse: false
                },
                cancelled: {
                    bg: 'bg-red-500',
                    label: 'Dibatalkan',
                    pulse: false
                },
            };

            const status = statusColors[visit.status] || {
                bg: 'bg-gray-500',
                label: 'Unknown',
                pulse: false
            };

            statusElement.className =
                `inline-flex items-center gap-2 px-3 py-1 text-xs font-semibold ${status.bg} text-white rounded-lg shadow-sm`;
            statusElement.innerHTML = `
    <span class="w-2 h-2 bg-white rounded-full ${status.pulse ? 'animate-pulse' : ''}"></span>
    ${status.label}
`;


            document.getElementById('detailModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function calculateDuration(checkIn, checkOut) {
            try {
                const start = new Date(`2000-01-01 ${checkIn}`);
                const end = new Date(`2000-01-01 ${checkOut}`);
                const diff = end - start;

                const hours = Math.floor(diff / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));

                if (hours > 0) {
                    return `${hours}h ${minutes}m`;
                } else {
                    return `${minutes}m`;
                }
            } catch (e) {
                return '-';
            }
        }

        function viewFullImage(event, type) {
            event.preventDefault();
            event.stopPropagation();

            const imgSrc = type === 'ktp' ? `/storage/${currentKtpPhoto}` : `/storage/${currentSelfiePhoto}`;

            if ((type === 'ktp' && currentKtpPhoto) || (type === 'selfie' && currentSelfiePhoto)) {
                document.getElementById('fullImageView').src = imgSrc;
                document.getElementById('imageViewerModal').classList.remove('hidden');
            }
        }

        function closeImageViewer() {
            document.getElementById('imageViewerModal').classList.add('hidden');
        }

        function closeModal() {
            document.getElementById('detailModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        document.getElementById('detailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const imageViewer = document.getElementById('imageViewerModal');
                const detailModal = document.getElementById('detailModal');

                if (!imageViewer.classList.contains('hidden')) {
                    closeImageViewer();
                } else if (!detailModal.classList.contains('hidden')) {
                    closeModal();
                }
            }
        });
    </script>
@endpush
