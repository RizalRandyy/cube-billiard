<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Pengguna') }}
            </h2>
            <x-button target="" href="{{ route('admin.users.create') }}" variant="success"
                class="justify-center max-w-xl gap-2">
                <x-icons.plus class="w-4 h-4" aria-hidden="true" />
                <span>Tambah Pengguna</span>
            </x-button>
        </div>
    </x-slot>

    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md">

        <div class="flex flex-col md:flex-row md:justify-end gap-4 my-3">

            <!-- Search Input-->
            <div class="w-full md:w-auto">
                <input type="text" id="search" placeholder="Cari pengguna..."
                    class=" rounded w-full md:w-auto px-4 py-2 border-gray-400" name="search">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table id="users-table" class="min-w-full rounded-md">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 dark:bg-slate-900 dark:text-white text-sm leading-normal">
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nama</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider hidden sm:table-cell">
                            Email</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider hidden sm:table-cell">
                            No Telepon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            Role</th>

                        {{-- password? --}}

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
        @include('components.js.dtUsers')
    @endpush

</x-app-layout>