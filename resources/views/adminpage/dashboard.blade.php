@extends('layouts.adminpage')

@section('admin-content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Kunjungan PLN</h1>
        <p class="text-gray-500">Selamat datang kembali, Admin! Berikut ringkasan kunjungan hari ini.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover-lift transition-all">
            <div class="flex items-center justify-between mb-4">
                {{-- <div class="w-12 h-12 rounded-lg flex items-center justify-center">
                </div> --}}
                <i class="fas fa-calendar-day text-xl"></i>
            </div>
            <h3 class="text-gray-500 text-sm font-medium">Total Kunjungan Hari Ini</h3>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['total_visits_today'] }}</p>
            <p class="text-gray-400 text-sm mt-2">{{ $stats['active_visitors'] }} pengunjung sedang aktif</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover-lift transition-all">
            <div class="flex items-center justify-between mb-4">
                <i class="fas fa-calendar-alt text-xl"></i>
                <span
                    class="text-white text-sm font-medium bg-{{ $stats['growth_percentage'] >= 0 ? 'green' : 'red' }}-500 px-2 py-1 rounded-full">
                    {{ $stats['growth_percentage'] >= 0 ? '+' : '' }}{{ number_format($stats['growth_percentage'], 1) }}%
                </span>
            </div>
            <h3 class="text-gray-500 text-sm font-medium">Total Kunjungan Bulan Ini</h3>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_visits_month']) }}</p>
            <p class="text-gray-400 text-sm mt-2">Dibandingkan bulan lalu</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover-lift transition-all">
            <div class="flex items-center justify-between mb-4">
                <i class="fas fa-users text-xl"></i>
                <span class="text-white text-sm font-medium bg-purple-500 px-2 py-1 rounded-full">Aktif</span>
            </div>
            <h3 class="text-gray-500 text-sm font-medium">Pengunjung Aktif</h3>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['active_visitors'] }}</p>
            <p class="text-gray-400 text-sm mt-2">Belum checkout</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover-lift transition-all">
            <div class="flex items-center justify-between mb-4">
                <i class="fas fa-clock text-xl"></i>
                <span class="text-white text-sm font-medium bg-yellow-500 px-2 py-1 rounded-full">Pending</span>
            </div>
            <h3 class="text-gray-500 text-sm font-medium">Menunggu Persetujuan</h3>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['pending_accepted'] }}</p>
            <p class="text-gray-400 text-sm mt-2">Perlu tindak lanjut</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-800">
                    Statistik Kunjungan Harian (08.00 – 17.00 WIB)
                </h3>

                <select
                    class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>Hari Ini</option>
                    <option disabled>7 Hari Terakhir</option>
                    <option disabled>30 Hari Terakhir</option>
                </select>
            </div>
            <div class="h-64">
                @if (count($visitsByHour) > 0 && array_sum(array_column($visitsByHour, 'count')) > 0)
                    <canvas id="visitsChart"></canvas>
                @else
                    <div class="flex items-center justify-center h-full bg-gray-50 rounded-lg">
                        <div class="text-center">
                            <i class="fas fa-chart-line text-gray-300 text-4xl mb-2"></i>
                            <p class="text-gray-400">Belum ada data kunjungan hari ini</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-800">Pengunjung Terbanyak</h3>
                <a href="{{ route('adminpage.visitor.index') }}" class="text-blue-600 text-sm hover:underline">Lihat
                    Semua</a>
            </div>
            <div class="space-y-4">
                @forelse($topVisitors as $visitor)
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg mr-3 flex items-center justify-center">
                            <i class="fas fa-user text-blue-600"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-1">
                                <div>
                                    <p class="text-sm font-medium text-gray-800">{{ $visitor['visitor_name'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $visitor['phone_number'] }}</p>
                                </div>
                                <p class="text-sm font-semibold text-gray-800">{{ $visitor['visit_count'] }}x</p>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $visitor['percentage'] }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <i class="fas fa-inbox text-gray-300 text-4xl mb-2"></i>
                        <p class="text-gray-400">Belum ada data pengunjung bulan ini</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Visits Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">Kunjungan Terbaru</h3>
        </div>
        <div class="overflow-x-auto">
            @if (count($recentVisits) > 0)
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID Kunjungan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama Pengunjung</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tujuan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Check In</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Check Out</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($recentVisits as $visit)
                            <tr class="hover:bg-gray-50 transition-all">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                    {{ $visit['visit_id'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $visit['visitor_name'] }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $visit['purpose'] ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $visit['check_in'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $visit['check_out'] ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($visit['status'] == 'completed')
                                        <span
                                            class="px-2 py-1 text-xs font-medium bg-green-100 text-green-600 rounded-full">
                                            Selesai
                                        </span>
                                    @elseif($visit['status'] == 'active')
                                        <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-600 rounded-full">
                                            Aktif
                                        </span>
                                    @else
                                        <span
                                            class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-600 rounded-full">
                                            {{ ucfirst($visit['status']) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $visit['visit_date'] }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-calendar-times text-gray-300 text-5xl mb-3"></i>
                    <h4 class="text-lg font-medium text-gray-600 mb-1">Belum Ada Kunjungan</h4>
                    <p class="text-gray-400">Belum ada data kunjungan hari ini</p>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            @if (count($visitsByHour) > 0 && array_sum(array_column($visitsByHour, 'count')) > 0)
                // Visits Chart
                const ctx = document.getElementById('visitsChart').getContext('2d');
                const visitsData = @json($visitsByHour);

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: visitsData.map(item => item.hour),
                        datasets: [{
                            label: 'Jumlah Kunjungan',
                            data: visitsData.map(item => item.count),
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.4,
                            fill: true,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                padding: 12,
                                titleFont: {
                                    size: 14
                                },
                                bodyFont: {
                                    size: 13
                                },
                                callbacks: {
                                    label: function(context) {
                                        return 'Kunjungan: ' + context.parsed.y;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 5,
                                    precision: 0
                                },
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            @endif
        </script>
    @endpush
@endsection
