@extends('layouts.adminpage')

@section('admin-content')
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Manajemen Pengunjung</h1>
                <p class="mt-1 text-sm text-gray-500">Manage and track all visitor records</p>
            </div>
            <div class="flex items-center gap-3">
                <button
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-download mr-2"></i>Export
                </button>
                <a
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-plus mr-2"></i>Pengunjung Baru
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
                        placeholder="Cari nama, NIK, atau No HP..."
                        class="w-80 pl-10 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('adminpage.visitor.index') }}"
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
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">NIK
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No HP
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jumlah
                            Kunjungan</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($visitors as $visitor)
                        <tr class="hover:bg-gray-50 transition-all duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $visitor->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $visitor->full_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $visitor->identity_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $visitor->phone_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $visitor->visits->count() }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <button onclick="openModal({{ json_encode($visitor) }})"
                                    class="p-1.5 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded transition-all"
                                    title="View Details">
                                    <i class="fas fa-eye text-sm"></i>
                                </button>
                                <a href="{{ route('adminpage.visitor.destroy', ['id' => $visitor->id]) }}"
                                    class="p-1.5 text-gray-600 hover:text-red-600 hover:bg-red-50 rounded transition-all"
                                    title="Delete"
                                    onclick="return confirm('Are you sure you want to delete this visit record?')">
                                    <i class="fas fa-trash text-sm"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($visitors->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                <p class="text-sm text-gray-600">
                    Showing {{ $visitors->firstItem() }} to {{ $visitors->lastItem() }} of {{ $visitors->total() }}
                    results
                </p>
                <div class="flex items-center space-x-1">
                    {{ $visitors->links() }}
                </div>
            </div>
        @endif
    </div>

    {{-- Modal Detail Visitor --}}
    <div id="detailModal"
        class="hidden fixed inset-0 bg-black bg-opacity-60 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[95vh] overflow-hidden animate-fadeIn">
            <div class="sticky top-0 px-8 py-6 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center">
                        <i class="fas fa-user-check text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold">Detail Pengunjung</h3>
                        <p class="text-sm mt-0.5">Informasi Lengkap Pengunjung</p>
                    </div>
                </div>
                <button onclick="closeModal()"
                    class="w-10 h-10 rounded-lg transition-all duration-200 flex items-center justify-center">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="p-8 space-y-8 overflow-y-auto max-h-[calc(95vh-180px)]">

                <div class="grid grid-cols-1 gap-6">
                    <div class="rounded-xl overflow-hidden">
                        <div class="bg-gray-100 px-4 py-3 flex items-center gap-2">
                            <i class="fas fa-id-card"></i>
                            <h4 class="font-semibold text-sm">Foto KTP</h4>
                        </div>
                        <div class="p-4 relative h-80 bg-gray-100 rounded-lg overflow-hidden">
                            <img id="modal-ktp-photo" class="w-full h-full object-cover rounded-lg" src=""
                                alt="KTP">
                        </div>
                    </div>
                </div>

                <div class="rounded-xl overflow-hidden shadow-lg">
                    <div class="bg-gray-100 px-6 py-4 flex items-center gap-2">
                        <i class="fas fa-user text-gray-600"></i>
                        <h4 class="font-bold text-gray-900 text-base">Informasi Pengunjung</h4>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase">Nama</label>
                            <p id="modal-full-name" class="text-gray-900 font-semibold">-</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase">NIK</label>
                            <p id="modal-nik" class="text-gray-900 font-semibold">-</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase">No HP</label>
                            <p id="modal-phone" class="text-gray-900 font-semibold">-</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase">Jumlah Kunjungan</label>
                            <p id="modal-visit-count" class="text-gray-900 font-semibold">-</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-xs font-semibold text-gray-500 uppercase">Alamat</label>
                            <p id="modal-address" class="text-gray-900 font-semibold">-</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="border-t border-gray-200 px-8 py-5 bg-gray-50 flex items-center justify-between gap-3">
                <p class="text-sm text-gray-500">
                    <i class="fas fa-info-circle mr-1"></i>
                    Semua informasi pengunjung bersifat rahasia.
                </p>
                <button onclick="closeModal()"
                    class="px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-all duration-200 shadow-sm">
                    <i class="fas fa-times mr-2"></i>Tutup
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let currentKtpPhoto = '';

        function openModal(visitor) {
            currentKtpPhoto = visitor.id_card_image.path || '';

            document.getElementById('modal-full-name').textContent = visitor.full_name || '-';
            document.getElementById('modal-nik').textContent = visitor.identity_number || '-';
            document.getElementById('modal-phone').textContent = visitor.phone_number || '-';
            document.getElementById('modal-address').textContent = visitor.address || '-';
            document.getElementById('modal-visit-count').textContent = visitor.visits_count || visitor.visits?.length || 0;

            const ktpImg = document.getElementById('modal-ktp-photo');
            if (currentKtpPhoto) {
                ktpImg.src = `/storage/${currentKtpPhoto}`;
                ktpImg.style.display = 'block';
            } else {
                ktpImg.style.display = 'none';
            }

            document.getElementById('detailModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('detailModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>
@endpush
