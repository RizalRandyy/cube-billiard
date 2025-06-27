<x-app-layout>
    <x-slot name="header">
        <div class="flex-1">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                        {{ __('Hello, ' . auth()->user()->name . '!') }}
                    </h2>
                    <p class="text-gray-500 text-sm mb-5">Lihat statistik dan kontrol sistem billiard Anda</p>
                    @if (auth()->user()->hasRole('Kasir'))
                        <a href="{{ route('/') }}"
                            class="bg-[#1C3F3A] text-white hover:bg-[#2a5e56] transition-all ease-in-out duration-300 px-3 py-2 text-sm rounded">Booking
                            Meja</a>
                    @endif
                </div>
                <div class="md:flex items-center gap-4 hidden">
                    <div class="relative w-64">
                        <input type="text" placeholder="Search..."
                            class="w-full px-4 py-2 rounded-full border border-gray-300 focus:outline-none" />
                        <div
                            class="absolute right-1 top-1/2 transform -translate-y-1/2 text-white bg-black p-2 rounded-full">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1111 3.5a7.5 7.5 0 015.65 13.15z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
    </x-slot>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <!-- Card 1 -->
        <div class="bg-white p-4 rounded-2xl shadow">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-sm mb-3">Jumlah Meja</p>
                    <h2 class="text-xl font-bold">{{ $total_table }}</h2>
                </div>
                <x-icons.pool-table class="w-10 h-10"></x-icons.pool-table>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white p-4 rounded-2xl shadow">
            <div class="flex items-center gap-4">
                <div class="bg-[#1C3F3A] text-white rounded-full p-2">
                    <x-icons.book class="w-8 h-8"></x-icons.book>

                </div>
                <div>
                    <p class="text-gray-500 text-sm mb-3">Transaksi Hari Ini</p>
                    <h2 class="text-xl font-bold">{{ $total_transaction_today }}</h2>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white p-4 rounded-2xl shadow">
            <div class="flex items-center gap-4">
                <div class="bg-[#1C3F3A] text-white rounded-full p-2">
                    <x-icons.dollar class="w-8 h-8"></x-icons.dollar>

                </div>
                <div>
                    <p class="text-gray-500 text-sm mb-3">Pendapatan Hari Ini</p>
                    <h2 class="text-lg font-bold">Rp. {{ number_format($earnings_today, 2, ',', '.') }}</h2>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="bg-green-600 p-4 rounded-2xl shadow">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-white text-sm mb-3">Pendapatan Bulan Ini</p>
                    <h2 class="text-lg font-bold text-white">Rp. {{ number_format($total_earnings_month, 2, ',', '.') }}
                    </h2>
                </div>
                <x-icons.line class="w-10 h-10 text-white"></x-icons.line>
            </div>
        </div>

        <!-- Card Balance -->
        <div class="col-span-2 bg-white p-4 rounded-xl shadow">
            <div class="flex justify-between items-center">
                <p class="text-gray-500">Statistik Booking</p>
                <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded">Hari Ini</span>
            </div>
            <div class="mt-2">
                <h1 class="text-2xl font-bold text-green-600">{{ $percent_filled_today }}%</h1>
                <p class="text-sm text-gray-400">Total Transaksi Hari Ini: {{ $total_transaction_today }}</p>
                <p class="text-sm text-gray-400">Total Booking Hari Ini: {{ $total_booking_today }}</p>
            </div>
            <!-- Placeholder untuk grafik -->
            <canvas id="bookingChart" height="100"></canvas>
        </div>

        <!-- Card Earnings Graph -->
        <div class="bg-white p-4 rounded-xl shadow text-start">
            <p class="text-gray-500">Pendapatan Hari Ini</p>
            <h2 class="text-xl font-bold">Rp{{ number_format($earnings_today, 0, ',', '.') }}</h2>
            <p class="text-green-500 text-sm">
                @php
                    $selisih = $earnings_today - $donut_chart_data['yesterday'];
                    $persen =
                        $donut_chart_data['yesterday'] > 0
                            ? round(($selisih / $donut_chart_data['yesterday']) * 100, 2)
                            : 100;
                @endphp
                {{ $persen >= 0 ? '+' : '' }}{{ $persen }}% dibanding kemarin
            </p>

            <canvas id="donutChart" width="80" height="80" class="mx-auto mt-4"></canvas>
        </div>

        <!-- Profile Info -->
        <div class="bg-white p-4 rounded-xl shadow text-center">
            <div class="w-16 h-16 md:w-24 md:h-24 mx-auto bg-gray-300 rounded-full mb-2">
                <img src="{{ asset('assets/images/logo.png') }}" alt="">
            </div>
            <h3 class="font-bold text-base md:text-xl">{{ auth()->user()->name }}</h3>
            <p class="text-sm md:text-lg text-gray-500 mb-1">{{ auth()->user()->email }}</p>
            <p class="text-sm md:text-lg text-gray-500">{{ auth()->user()->phone }}</p>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                const ctx = $('#bookingChart')[0].getContext('2d');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($bookings_last_7_days->pluck('date')) !!},
                        datasets: [{
                            label: 'Booking',
                            data: {!! json_encode($bookings_last_7_days->pluck('count')) !!},
                            borderColor: '#34d399',
                            backgroundColor: 'rgba(52, 211, 153, 0.1)',
                            tension: 0.3,
                            fill: true,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });

                const ctx1 = $('#donutChart')[0].getContext('2d');
                const donutChart = new Chart(ctx1, {
                    type: 'doughnut',
                    data: {
                        labels: ['Hari Ini', 'Kemarin'],
                        datasets: [{
                            data: [{{ $donut_chart_data['today'] }},
                                {{ $donut_chart_data['yesterday'] }}
                            ],
                            backgroundColor: ['#10b981', '#d1d5db'], // hijau & abu-abu
                            borderWidth: 0
                        }]
                    },
                    options: {
                        cutout: '70%',
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
