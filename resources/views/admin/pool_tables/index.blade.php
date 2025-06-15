<x-app-layout>
    <x-slot name="header">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Meja Biliar') }}
            </h2>
        </div>
    </x-slot>

    <!-- Grid Layout -->
    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md">
        <div class="overflow-x-auto w-full">
            <div id="layoutAdminPage" class="grid grid-cols-[repeat(8,_minmax(0,_1fr))] gap-2 w-max md:w-full">
                <!-- Slots akan di-generate dengan JS -->
            </div>
        </div>
    </div>

    <!-- Main modal -->
    <div id="modalPoolTable" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex justify-center items-center">

        <!-- Overlay -->
        <div id="modalOverlayPoolTable"
            class="fixed inset-0 bg-black bg-opacity-50 opacity-0 transition-opacity duration-300 z-40"></div>

        <div id="modalContentPoolTable"
            class="relative z-50 p-4 w-full max-w-md max-h-full opacity-0 scale-95 transition-all duration-300">

            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm">

                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                    <h3 class="modal-title text-lg font-semibold text-gray-900">
                        Tambah Meja Biliar
                    </h3>
                    <button type="button" id="closeModalPoolTable" onclick="closeModalPoolTable()"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal body -->
                <form class="p-4 md:p-5" id="formMeja">

                    {{-- Input hidden positon x dan y --}}
                    <input type="hidden" id="positionX" name="x" />
                    <input type="hidden" id="positionY" name="y" />

                    <div class="grid gap-4 mb-4 grid-cols-2">

                        {{-- Nama meja --}}
                        <div class="col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama Meja</label>
                            <input type="text" name="name" id="name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Nama / nomor meja" required>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- Harga per jam --}}
                        <div class="col-span-2 sm:col-span-1">
                            <label for="price_per_hour" class="block mb-2 text-sm font-medium text-gray-900">Harga per
                                Jam</label>
                            <input type="text" name="price_per_hour" id="price_per_hour"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="40.000" required>
                            <x-input-error :messages="$errors->get('price_per_hour')" class="mt-2" />
                        </div>

                        {{-- Status --}}
                        <div class="col-span-2 sm:col-span-1">
                            <label for="status" class="block mb-2 text-sm font-medium text-gray-900">Status</label>
                            <select id="status" name="status"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                                required>
                                <option selected="">Pilih status</option>
                                <option value="1">Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        {{-- Orientasi --}}
                        <div class="col-span-2">
                            <label for="orientation"
                                class="block mb-2 text-sm font-medium text-gray-900">Orientasi</label>
                            <select id="orientation" name="orientation"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                                required>
                                <option selected="">Pilih orientasi</option>
                                <option value="horizontal">Horizontal</option>
                                <option value="vertical">Vertical</option>
                            </select>
                            <x-input-error :messages="$errors->get('orientation')" class="mt-2" />
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="flex justify-between">
                        <button type="submit"
                            class="delete-btn text-white invisible inline-flex items-center bg-red-600 hover:bg-red-700 transition-all ease-in-out duration-300 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">

                            <x-icons.trash class="w-3 h-3 me-2 -ms-1"></x-icons.trash>

                            <span class="btn-text">Hapus Meja</span>

                            <span
                                class="spinner hidden w-4 h-4 ms-2 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                        </button>

                        <button type="submit"
                            class="submit-btn text-white inline-flex items-center bg-black hover:bg-gray-800 transition-all ease-in-out duration-300 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="btn-text">Simpan</span>
                            <span
                                class="spinner hidden w-4 h-4 ms-2 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    @vite([
        'resources/js/pages/admin/pool-table/render.js',
        'resources/js/pages/admin/pool-table/toggle-modal.js',
        'resources/js/pages/admin/pool-table/close-modal.js',
        'resources/js/pages/admin/pool-table/form-error.js',
        'resources/js/helpers/format-price.js',
    ])
        <script>
            $(document).ready(function() {
                // Ambil data awal
                $.get('/pool-tables-data', data => {
                    data.forEach(item => renderPoolTables(item.name, item.x, item.y, item.orientation, item.id,
                        item.price_per_hour, item.status));
                });

                // Submit create/update
                $('#formMeja').on('submit', function(e) {
                    e.preventDefault();
                    const form = $(this),
                        id = form.attr('data-id');
                    const x = +$('#positionX').val(),
                        y = +$('#positionY').val(),
                        orientation = $('#orientation').val();
                    const price = parseInt($('#price_per_hour').val().replace(/[^\d]/g, ''), 10);
                    let key = `${x},${y}`;

                    const currentId = id ? parseInt(id) : null;
                    const existing = slotsAdminPage[key].find('[data-id]' ?? null);
                    if (existing.length && parseInt(existing.attr('data-id')) !== currentId) {
                        notyf.error('Posisi ini sudah ditempati meja lain.');
                        return;
                    }

                    const submitBtn = $('.submit-btn');
                    submitBtn.prop('disabled', true);
                    submitBtn.find('.btn-text').text('Menyimpan...');
                    submitBtn.find('.spinner').removeClass('hidden');

                    const payload = {
                        _token: "{{ csrf_token() }}",
                        _method: id ? 'PUT' : 'POST',
                        name: $('#name').val(),
                        price_per_hour: price,
                        status: $('#status').val(),
                        x,
                        y,
                        orientation
                    };

                    $.ajax({
                        url: id ? `/admin/pool_tables/${id}` : `{{ route('admin.pool_tables.store') }}`,
                        method: 'POST',
                        data: payload,
                        success: res => {

                            // Render ulang meja yang baru
                            renderPoolTables(payload.name, x, y, orientation, id || res.id, price,
                                payload.status);

                            // Tutup modal
                            toggleModal(false);

                            // Notifikasi
                            notyf.success(res.message);
                        },
                        error: xhr => {
                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;
                                showFormPoolTableErrors(errors);
                            } else {
                                notyf.error('Gagal menyimpan ke database.');
                                console.log(xhr.responseText);
                            }
                        },
                        complete: () => {
                            submitBtn.prop('disabled', false);
                            submitBtn.find('.btn-text').text('Simpan');
                            submitBtn.find('.spinner').addClass('hidden');
                        }
                    });
                });

                // Delete meja
                $('.delete-btn').on('click', function(e) {
                    e.preventDefault();
                    const form = $('#formMeja'),
                        id = form.attr('data-id');
                    const x = +$('#positionX').val(),
                        y = +$('#positionY').val(),
                        orientation = $('#orientation').val();

                    const deleteBtn = $('.delete-btn');

                    // Mulai loading
                    deleteBtn.prop('disabled', true);
                    deleteBtn.find('.btn-text').text('Menghapus...');
                    deleteBtn.find('.spinner').removeClass('hidden');

                    SwalDeletePoolTableAdmin().then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: `/admin/pool_tables/${id}`,
                                type: 'POST',
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    _method: 'DELETE'
                                },
                                success: res => {
                                    // Hapus elemen meja dari layout
                                    const key = `${x},${y}`;
                                    const slot = slotsAdminPage[key];
                                    if (slot) {
                                        slot.empty().removeClass().addClass(
                                            "border-none w-[128px] h-[128px] flex items-center justify-center text-xs rounded cursor-pointer hover:bg-blue-100"
                                        );
                                    }

                                    toggleModal(false);
                                    notyf.success(res.message || 'Data berhasil dihapus.');
                                },
                                error: () => notyf.error('Gagal menghapus data.'),
                                complete: () => {
                                    deleteBtn.prop('disabled', false);
                                    deleteBtn.find('.btn-text').text('Hapus Meja');
                                    deleteBtn.find('.spinner').addClass('hidden');
                                }
                            });
                        }
                    });
                });

                // Edit meja
                editMeja = function(el) {
                    const $el = $(el);
                    $('#name').val($el.data('name'));
                    $('#price_per_hour').val(formatPricePoolTable($el.data('price_per_hour')));
                    $('#status').val($el.data('status'));
                    $('#orientation').val($el.data('orientation'));
                    $('#positionX').val($el.data('x'));
                    $('#positionY').val($el.data('y'));
                    $('#formMeja').attr('data-id', $el.data('id'));
                    $('.modal-title').text('Edit Meja Biliar');
                    $('.delete-btn').removeClass('invisible');
                    toggleModal(true);
                }

                // Format harga per jam
                $('#price_per_hour').on('input', function() {
                    $(this).val(formatPricePoolTable($(this).val()));
                });
            });
        </script>
    @endpush

</x-app-layout>
