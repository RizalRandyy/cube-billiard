<x-guest-layout>
    <div class="mx-6 mt-28 flex flex-col gap-4 md:flex-row md:items-center md:justify-start">
        <div class="flex items-center gap-4">
            <x-button target="" href="{{ route('/') }}" variant="black" size="sm"
                class="justify-center gap-2">
                <x-icons.arrow-left class="w-4 h-4" aria-hidden="true" />
            </x-button>
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Riwayat') }}
            </h2>
        </div>
    </div>
    <div class="mx-6 p-6 mt-4 overflow-hidden bg-white rounded-md shadow-lg">
        <div class="flex flex-col md:flex-row md:justify-end gap-4 my-3">

            <!-- Search Input-->
            <div class="w-full md:w-auto">
                <input type="text" id="search" placeholder="Cari transaksi..."
                    class=" rounded w-full md:w-auto px-4 py-2 border-gray-400" name="search">
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
        </script>
        @include('components.js.dtPaymentHistoryUser')
    @endpush

</x-guest-layout>
