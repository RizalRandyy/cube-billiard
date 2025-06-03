<x-guest-layout>
    @push('styles')
        <style>

        </style>
    @endpush
    <!-- Konten Welcome -->
    <div class="w-full mt-28 px-4 md:px-8">

        <x-user.carousel></x-user.carousel>

        <x-user.button-links></x-user.button-links>

        <x-user.accordions></x-user.accordions>

    </div>

    <x-user.gallery></x-user.gallery>

    <!-- Pilih Meja -->
    <section id="pilih-meja" class="py-16">
        <div class="max-w-7xl mx-auto px-4 md:px-6">
            <h1 class="text-3xl font-bold text-center text-gray-800 mb-2">Booking Meja Biliar</h1>
            <p class="text-center text-gray-600 mb-6">Silakan pilih lokasi meja biliar dari denah di bawah ini. Klik
                meja biru untuk memesan.</p>

            <!-- Legenda -->
            <div class="flex justify-center flex-wrap gap-4 mb-8 text-sm text-gray-700">
                <div class="flex items-center gap-2">
                    <div class="w-5 h-5 bg-green-600 border border-green-600 rounded"></div> Pintu Masuk
                </div>
                <div class="flex items-center gap-2">
                    <img src="/assets/images/meja-biru-horizontal.png" class="w-8 h-8 object-contain"> Tersedia
                </div>
                <div class="flex items-center gap-2">
                    <img src="/assets/images/meja-putih-horizontal.png" class="w-8 h-8 object-contain"> Tidak Tersedia
                </div>
            </div>

            <!-- Navigasi Tanggal -->
            <div class="w-full flex items-center justify-center">
                <div class="bg-white p-4 mb-4 rounded-lg shadow border border-gray-200 flex overflow-x-auto max-w-3xl">
                    <!-- Tanggal Horizontal -->
                    <div id="date-buttons" class="flex space-x-4">
                        <!-- Contoh 1 tanggal aktif -->
                        {{-- <button
                            class="flex flex-col items-center px-3 py-2 rounded-lg bg-[#1C3F3A] text-white font-semibold">
                            <span class="text-sm">Sel</span>
                            <span class="text-base">3 Jun</span>
                        </button> --}}
                    </div>

                    <!-- Tombol kanan -->
                    <div class="flex items-center space-x-2 ml-4 gap-2">
                        <!-- Tombol Kalender -->
                        <x-icons.divider class="w-6 h-6"></x-icons.divider>
                        <div class="relative inline-block">
                            <!-- Ikon kalender sebagai tombol -->
                            <input type="text" id="datepicker-input" class="hidden" />
                            <x-icons.calendar id="calendar-icon" class="w-6 h-6 cursor-pointer"></x-icons.calendar>
                        </div>

                    </div>
                </div>
            </div>


            <!-- Layout Meja -->
            <div class="overflow-x-auto bg-white rounded-lg shadow p-6 border border-gray-200">
                <div id="layout" class="grid grid-cols-[repeat(16,_minmax(0,_1fr))] gap-2 w-max mx-auto">
                    <!-- Slots akan diisi oleh JS -->
                </div>
            </div>
        </div>
    </section>

    {{-- CTO Booking --}}
    <x-user.cto-booking></x-user.cto-booking>

    @push('scripts')
        <script>
            $(document).ready(function() {
                renderDateButtons(new Date());

                const flatpckr = flatpickr("#datepicker-input", {
                    clickOpens: false,
                    allowInput: true,
                    locale: Indonesian,
                    dateFormat: "d-m-Y",
                    onChange: function(selectedDates, dateStr, instance) {
                        if (selectedDates.length) {
                            renderDateButtons(selectedDates[0]); // render ulang saat tanggal dipilih
                        }
                    }
                });

                // Buka datepicker saat ikon diklik
                $("#calendar-icon").on("click", function() {
                    flatpckr.open();
                });

                // Fungsi untuk merender 7 tombol tanggal dari startDate
                function renderDateButtons(startDate) {
                    const container = document.getElementById("date-buttons");
                    container.innerHTML = ""; 

                    const days = ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"];

                    for (let i = 0; i < 7; i++) {
                        const date = new Date(startDate);
                        date.setDate(date.getDate() + i);

                        const dayName = days[date.getDay()];
                        const dayDate = date.getDate();
                        const monthShort = date.toLocaleString("id-ID", {
                            month: "short"
                        });

                        const btn = document.createElement("button");
                        btn.className =
                            "flex flex-col items-center px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100";
                        btn.innerHTML =
                            `<span class="text-sm">${dayName}</span><span class="text-base font-semibold">${dayDate} ${monthShort}</span>`;

                        btn.dataset.date = date.toISOString().split("T")[0];

                        if (i === 0) {
                            btn.classList.add("bg-[#1C3F3A]", "text-white", "font-semibold", "hover:bg-[#1C3F3A]", "active-date");
                        }

                        btn.addEventListener("click", function() {
                            document
                                .querySelectorAll("#date-buttons button")
                                .forEach((b) => b.classList.remove("bg-[#1C3F3A]", "text-white",
                                    "font-semibold", "active-date"));
                            btn.classList.add("bg-[#1C3F3A]", "text-white", "font-semibold", "hover:bg-[#1C3F3A]", "active-date");
                        });

                        container.appendChild(btn);
                    }
                }

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
        </script>
    @endpush

</x-guest-layout>
