<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-start">
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Pembayaran') }}
            </h2>
        </div>
    </x-slot>

    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md">

        <div class="flex flex-col md:flex-row gap-4 my-3 md:justify-between w-full">
            <!-- Kiri -->
            <div class="flex justify-start w-full md:w-auto">
                <x-form.select id="period" class="block w-full md:w-40 h-10" name="type">
                    <option value="" {{ old('period') == '' ? 'selected' : '' }}>Pilih Periode...</option>
                    <option value="day">Hari ini</option>
                    <option value="month">Bulan ini</option>
                    <option value="custom">Custom</option>
                </x-form.select>

                <div class="flex gap-4 hidden custom">
                    <input id="start_date"
                        class="ms-4 block flatpickr-input border border-gray-500 text-gray-600 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 p-2.5"
                        type="date" name="start_date" autocomplete="off" placeholder="Dari"
                        style="width: 120px !important; height: 40px !important;" />

                    <input id="end_date"
                        class="block flatpickr-input border border-gray-500 text-gray-600 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 p-2.5"
                        type="date" name="end_date" autocomplete="off" placeholder="Sampai"
                        style="width: 120px !important; height: 40px !important;" />
                </div>
            </div>

            <!-- Kanan -->
            <div class="flex md:justify-between justify-end gap-4 w-full md:w-auto">
                @if (auth()->user()->hasRole('Admin'))
                    <form id="excelForm" action="{{ route('admin.report.transactions.export.excel') }}" method="POST"
                        class="flex items-center">
                        @csrf
                        <input type="hidden" name="period" id="excelPeriod">
                        <input type="hidden" name="start_date" id="excelStartDate">
                        <input type="hidden" name="end_date" id="excelEndDate">
                        <button type="submit"
                            class="w-12 md:w-44 rounded-md md:rounded-sm flex items-center px-4 py-2 text-sm text-white bg-green-700 hover:bg-green-800 transition-all ease-in-out duration-300 gap-2"
                            role="menuitem" tabindex="-1" id="menu-item-1">
                            <x-icons.excel class="w-5 h-5" aria-hidden="true" />
                            <span class="hidden md:block">Download Excel</span>
                        </button>
                    </form>
                @endif

                <!-- Search Input-->
                <div class="w-48 md:w-auto">
                    <input type="text" id="search" placeholder="Cari transaksi..."
                        class="rounded w-full md:w-auto px-4 py-2 border-gray-400" name="search">
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table id="users-table" class="min-w-full rounded-md">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 dark:bg-slate-900 dark:text-white text-sm leading-normal">
                        <th
                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider hidden sm:table-cell">
                            Id</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            Nama</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider hidden sm:table-cell">
                            Tanggal Pembayaran</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider hidden sm:table-cell">
                            Order Id</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider hidden sm:table-cell">
                            Metode Pembayaran</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider hidden sm:table-cell">
                            Total Pembayaran</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            Status</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider hidden sm:table-cell">
                            Pembayaran Terakhir</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody id="itemTable"
                    class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-dark-eval-1">
                </tbody>
            </table>
        </div>

        <!-- Pagination Controls -->
        <div class="mt-4 flex items-center justify-center">
            <div id="paginationNumbers" class="flex items-center justify-center gap-2 mt-4"></div>
        </div>
    </div>

    @push('scripts')
        <script>
            function toggleDetails(index) {
                const detailRow = document.getElementById(`details-${index}`);
                if (detailRow.classList.contains('hidden')) {
                    detailRow.classList.remove('hidden');
                } else {
                    detailRow.classList.add('hidden');
                }
            }

            $(document).ready(function() {

                flatpickr("#start_date", {
                    dateFormat: "Y-m-d",
                    allowInput: true,
                });

                flatpickr("#end_date", {
                    dateFormat: "Y-m-d",
                    allowInput: true,
                });

                $('#period').change(function() {
                    if ($(this).val() === 'custom') {
                        $('.custom').removeClass('hidden');
                    } else {
                        $('.custom').addClass('hidden');
                        $('#start_date').val("")
                        $('#end_date').val("")
                    }
                });

                $('#excelForm').on('submit', function(event) {
                    let period = $('#period').val();
                    $('#excelPeriod').val(period);

                    let startDate = $('#start_date').val();
                    $('#excelStartDate').val(startDate);

                    let endDate = $('#end_date').val();
                    $('#excelEndDate').val(endDate);
                });

                $('#period').change(function() {
                    if ($(this).val() === 'custom') {
                        $('.custom').removeClass('hidden');
                    } else {
                        $('.custom').addClass('hidden');
                        $('#start_date').val("")
                        $('#end_date').val("")
                    }
                });
            });
        </script>
        @include('components.js.dtTransaction')
    @endpush

</x-app-layout>
