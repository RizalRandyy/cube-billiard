<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-start">
            <div class="flex items-center text-center">
                <h2 class="font-semibold text-xl leading-tight">
                    {{ __('Data Booking ' . $bookingGroup->user->name . ' - ') }}
                </h2>
                @if ($transaction->payment_status === 'failed')
                    <span
                        class="bg-red-100 text-red-800 text-base font-medium ms-2 px-2.5 py-0.5 rounded-sm dark:bg-red-900 dark:text-red-300">
                        {{ $transaction->payment_status }}</span>
                @elseif ($transaction->payment_status === 'pending')
                    <span
                        class="bg-yellow-100 text-yellow-800 text-base font-medium ms-2 px-2.5 py-0.5 rounded-sm dark:bg-yellow-900 dark:text-yellow-300">{{ $transaction->payment_status }}</span>
                @else
                    <span
                        class="bg-green-100 text-green-800 text-base font-medium ms-2 px-2.5 py-0.5 rounded-sm dark:bg-green-900 dark:text-green-300">{{ $transaction->payment_status }}</span>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md">

        <div class="flex flex-col md:flex-row md:justify-end gap-4 my-3">

            <!-- Search Input-->
            <div class="w-full md:w-auto">
                <input type="text" id="search" placeholder="Cari transaksi..."
                    class=" rounded w-full md:w-auto px-4 py-2 border-gray-400" name="search">
            </div>
        </div>

        <div class="overflow-x-auto">
            <input type="hidden" id="bookingGroupId" value="{{ $bookingGroupId }}">
            <table id="users-table" class="min-w-full rounded-md">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 dark:bg-slate-900 dark:text-white text-sm leading-normal">
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            Nama Meja</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            Tanggal Booking</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider hidden sm:table-cell">
                            Waktu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider md:hidden">
                            Aksi</th>
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
        @include('components.js.dtBookedTablesUser')
    @endpush

</x-app-layout>
