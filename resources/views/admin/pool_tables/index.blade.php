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
            <div id="layout" class="grid grid-cols-[repeat(16,_minmax(0,_1fr))] gap-[8px] w-max">
                <!-- Slots akan di-generate dengan JS -->
            </div>
        </div>
    </div>

    <!-- Main modal -->
    <div id="modal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex justify-center items-center">

        <!-- Overlay -->
        <div id="modalOverlay"
            class="fixed inset-0 bg-black bg-opacity-50 opacity-0 transition-opacity duration-300 z-40"></div>

        <div id="modalContent"
            class="relative z-50 p-4 w-full max-w-md max-h-full opacity-0 scale-95 transition-all duration-300">

            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm">

                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                    <h3 class="modal-title text-lg font-semibold text-gray-900">
                        Tambah Meja Biliar
                    </h3>
                    <button type="button" id="closeModal" onclick="closeModal()"
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
        <script>
            $(document).ready(function() {
                const notyf = new Notyf({
                    duration: 3000,
                    ripple: true,
                    dismissible: true,
                    position: {
                        x: 'center',
                        y: 'top'
                    }
                });
                const layout = $('#layout'),
                    modal = $('#modal'),
                    positionXInput = $('#positionX'),
                    positionYInput = $('#positionY');
                const rows = 8,
                    cols = 16,
                    slots = {};

                // Ambil data awal
                $.get('/pool-tables-data', data => {
                    data.forEach(item => renderPoolTables(item.name, item.x, item.y, item.orientation, item.id,
                        item.price_per_hour, item.status));
                });

                // Generate grid
                for (let y = 0; y < rows; y++) {
                    for (let x = 0; x < cols; x++) {
                        const key = `${x},${y}`,
                            isEntrance = x === 15 && y === 7;
                        const slot = $('<div></div>')
                            // .addClass(
                            //     `border border-gray-400 w-[64px] h-[64px] flex items-center justify-center text-xs rounded ${isEntrance ? 'bg-green-600 text-white font-bold' : 'bg-white hover:bg-blue-100 cursor-pointer'}`
                            // )
                            .addClass(
                                `border-none w-[64px] h-[64px] flex items-center justify-center text-xs rounded ${isEntrance ? 'bg-green-600 text-white font-bold' : 'bg-white hover:bg-blue-100 cursor-pointer'}`
                            )
                            .attr({
                                'data-x': x,
                                'data-y': y
                            })
                            // .text(isEntrance ? 'PINTU' : `(${x},${y})`);
                            .text(isEntrance ? 'PINTU' : ``);

                        if (!isEntrance) slot.on('click', () => {
                            positionXInput.val(x);
                            positionYInput.val(y);
                            toggleModal(true);
                        });
                        else slot.css('cursor', 'not-allowed');

                        slots[key] = slot;
                        layout.append(slot);
                    }
                }

                // Modal toggle
                function toggleModal(show = true) {
                    const overlay = $('#modalOverlay'),
                        content = $('#modalContent');
                    if (show) {
                        modal.removeClass('hidden');
                        setTimeout(() => {
                            overlay.removeClass('opacity-0').addClass('opacity-50');
                            content.removeClass('opacity-0 scale-95').addClass('opacity-100 scale-100');
                            console.log($('#formMeja').attr('data-id'));
                        }, 10);
                    } else {
                        overlay.removeClass('opacity-50').addClass('opacity-0');
                        content.removeClass('opacity-100 scale-100').addClass('opacity-0 scale-95');
                        setTimeout(() => {
                            modal.addClass('hidden');
                            $('.modal-title').text('Tambah Meja Biliar');
                            $('.delete-btn').addClass('invisible');
                            $('#formMeja').removeAttr('data-id');
                            $('#formMeja')[0].reset();
                            $('.input-error-message').remove();
                            $('#formMeja input, #formMeja select').removeClass(
                                'border-red-600');
                        }, 300);
                    }
                }

                window.closeModal = () => toggleModal(false);
                $('#modalOverlay').on('click', () => toggleModal(false));

                function showFormErrors(errors) {
                    // Hapus error sebelumnya
                    $('.input-error-message').remove();

                    Object.keys(errors).forEach(key => {
                        const messages = errors[key];
                        const input = $(`[name="${key}"]`);
                        if (input.length > 0) {
                            const errorEl = $(
                                `<p class="text-red-600 text-sm mt-1 input-error-message">${messages[0]}</p>`
                            );
                            input.addClass('border-red-600'); // opsional: tandai input error
                            input.after(errorEl);
                        }
                    });
                }

                // Submit create/update
                $('#formMeja').on('submit', function(e) {
                    e.preventDefault();
                    const form = $(this),
                        id = form.attr('data-id');
                    const x = +$('#positionX').val(),
                        y = +$('#positionY').val(),
                        orientation = $('#orientation').val();
                    const price = parseInt($('#price_per_hour').val().replace(/[^\d]/g, ''), 10);
                    let key1 = `${x},${y}`;
                    let key2;

                    if (orientation === 'horizontal') {
                        if (x + 1 >= cols) {
                            notyf.error('Tidak cukup ruang.');
                            return;
                        }
                        key2 = `${x + 1},${y}`;
                    } else {
                        if (y + 1 >= rows) {
                            notyf.error('Tidak cukup ruang.');
                            return;
                        }
                        key2 = `${x},${y + 1}`;
                    }

                    const currentId = id ? parseInt(id) : null;
                    const slotHasOtherTable = [key1, key2].some(key => {
                        const existing = slots[key].find('[data-id]');
                        return existing.length && parseInt(existing.attr('data-id')) !== currentId;
                    });

                    if (slotHasOtherTable) {
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
                            // Jika update, hapus meja lama dulu
                            if (id) {
                                const oldX = +form.data('old-x'),
                                    oldY = +form.data('old-y'),
                                    oldOrientation = form.data('old-orientation');

                                const oldKey1 = `${oldX},${oldY}`,
                                    oldKey2 = oldOrientation === 'horizontal' ?
                                    `${oldX + 1},${oldY}` : `${oldX},${oldY + 1}`;

                                [slots[oldKey1], slots[oldKey2]].forEach((slot, idx) => {
                                    const slotX = oldX + (idx === 1 && oldOrientation ===
                                        'horizontal' ? 1 : 0);
                                    const slotY = oldY + (idx === 1 && oldOrientation ===
                                        'vertical' ? 1 : 0);

                                    // slot.empty().removeClass().addClass(
                                    //     "border border-gray-400 w-[64px] h-[64px] flex items-center justify-center text-xs rounded cursor-pointer hover:bg-blue-100"
                                    // ).text(`(${slotX},${slotY})`).off('click').on(
                                    //     'click', () => {
                                    //         positionXInput.val(slotX);
                                    //         positionYInput.val(slotY);
                                    //         toggleModal(true);
                                    //     });

                                    slot.empty().removeClass().addClass(
                                        "border-none w-[64px] h-[64px] flex items-center justify-center text-xs rounded cursor-pointer hover:bg-blue-100"
                                    ).off('click').on(
                                        'click', () => {
                                            positionXInput.val(slotX);
                                            positionYInput.val(slotY);
                                            toggleModal(true);
                                        });
                                });
                            }

                            // Render ulang meja yang baru
                            renderPoolTables(payload.name, x, y, orientation, id || res.id, price,
                                payload.status);

                            // Tutup modal
                            toggleModal(false);

                            // Hapus data posisi lama agar tidak tertinggal
                            form.removeData('old-x old-y old-orientation');

                            // Notifikasi
                            notyf.success(res.message);
                        },
                        error: xhr => {
                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;
                                showFormErrors(errors);
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

                    Swal.fire({
                        title: 'Hapus Data?',
                        text: 'Data yang dihapus tidak dapat dikembalikan.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        background: '#fff',
                        color: '#111827',
                        customClass: {
                            popup: 'rounded-xl shadow-lg px-6 py-4',
                            confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2 rounded-lg focus:outline-none mr-5',
                            cancelButton: 'bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-4 py-2 rounded-lg focus:outline-none',
                            title: 'text-lg font-bold',
                            htmlContainer: 'text-sm',
                        },
                        buttonsStyling: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: `/admin/pool_tables/${id}`,
                                type: 'POST',
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    _method: 'DELETE'
                                },
                                success: res => {
                                    const key1 = `${x},${y}`,
                                        key2 = orientation === 'horizontal' ?
                                        `${x + 1},${y}` : `${x},${y + 1}`;
                                    [slots[key1], slots[key2]].forEach((slot, idx) => {
                                        // slot.empty().removeClass().addClass(
                                        //         "border border-gray-400 w-[64px] h-[64px] flex items-center justify-center text-xs rounded cursor-pointer hover:bg-blue-100"
                                        //     )
                                        //     .text(
                                        //         `(${idx === 0 ? x : x + (orientation === 'horizontal' ? 1 : 0)},${idx === 0 ? y : y + (orientation === 'vertical' ? 1 : 0)})`
                                        //     );

                                        slot.empty().removeClass().addClass(
                                                "border-none w-[64px] h-[64px] flex items-center justify-center text-xs rounded cursor-pointer hover:bg-blue-100"
                                            );
                                    });
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

                // Render meja
                function renderPoolTables(name, x, y, orientation, id = null, price = '', status = '') {
                    const key1 = `${x},${y}`,
                        key2 = orientation === 'horizontal' ? `${x + 1},${y}` : `${x},${y + 1}`;
                    const slot1 = slots[key1],
                        slot2 = slots[key2];
                    slot1.empty().removeClass().addClass('relative h-16 w-16');
                    slot2.empty().addClass('invisible pointer-events-none bg-gray-100 hover:bg-blue-100');

                    const wrapper = $(`
                        <div class="absolute top-0 left-0 flex cursor-pointer ${orientation === 'horizontal' ? 'w-[136px] h-[64px]' : 'w-[64px] h-[136px]'}"
                            data-id="${id}" data-name="${name}" data-x="${x}" data-y="${y}" data-orientation="${orientation}" 
                            data-price_per_hour="${parseInt(price)}" data-status="${status}" onclick="editMeja(this)">
                            <img src="/assets/images/meja-biru-${orientation}.png" alt="${name}" class="object-contain w-full h-full">
                        </div>
                    `);

                    const label = $(
                        `<div class="absolute top-0 left-0 bg-black bg-opacity-50 text-white text-xs px-1 rounded pointer-events-none">${name}</div>`
                    );
                    slot1.append(wrapper).append(label);
                }

                // Edit meja
                window.editMeja = function(el) {
                    const $el = $(el);
                    $('#name').val($el.data('name'));
                    $('#price_per_hour').val(formatPrice($el.data('price_per_hour')));
                    $('#status').val($el.data('status'));
                    $('#orientation').val($el.data('orientation'));
                    $('#positionX').val($el.data('x'));
                    $('#positionY').val($el.data('y'));
                    $('#formMeja').attr('data-id', $el.data('id'));
                    $('.modal-title').text('Edit Meja Biliar');
                    $('.delete-btn').removeClass('invisible');
                    toggleModal(true);

                    $('#formMeja').data('old-x', $el.data('x'));
                    $('#formMeja').data('old-y', $el.data('y'));
                    $('#formMeja').data('old-orientation', $el.data('orientation'));
                }

                // Format harga per jam
                $('#price_per_hour').on('input', function() {
                    $(this).val(formatPrice($(this).val()));
                });
            });

            // Format price function
            function formatPrice(value) {
                if (typeof value === 'string') {
                    value = value.replace(/[^\d]/g, '');
                }
                const number = parseInt(value, 10);
                if (isNaN(number)) return '';
                return number.toLocaleString('id-ID');
            }
        </script>
    @endpush

</x-app-layout>
