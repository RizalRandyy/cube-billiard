<x-guest-layout>
    
    <div class="flex items-end justify-end">
        <x-user.right-sidebar :bookings="$bookings"></x-user.right-sidebar>
    </div>
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
                        <!-- Button tanggal disini -->
                    </div>

                    <!-- Tombol kanan -->
                    <div class="flex items-center space-x-2 ml-4 gap-2">
                        <x-icons.divider class="w-6 h-6" />
                        <div id="calendar-wrapper" class="flatpickr relative inline-block" data-wrap>

                            <input type="text" id="datepicker-input"
                                class="sr-only absolute left-0 top-0 opacity-0 w-0 h-0" data-input />
                            <x-icons.calendar id="calendar-icon" class="w-6 h-6 cursor-pointer" data-toggle />
                        </div>
                    </div>

                </div>
            </div>


            <!-- Layout Meja -->
            <div class="overflow-x-auto bg-white rounded-lg shadow p-6 border border-gray-200">
                <div id="layout" class="grid grid-cols-[repeat(8,_minmax(0,_1fr))] gap-2 w-max md:w-full">
                    <!-- Slots akan di-generate dengan JS -->
                </div>
            </div>

            <!-- Main modal -->
            <div id="modal" tabindex="-1" aria-hidden="true"
                class="hidden fixed inset-0 z-50 flex justify-center items-center">

                <!-- Overlay -->
                <div id="modalOverlay"
                    class="fixed inset-0 bg-black bg-opacity-50 opacity-0 transition-opacity duration-300 z-40"></div>

                <div id="modalContent"
                    class="relative z-50 p-4 w-full max-w-2xl max-h-full opacity-0 scale-95 transition-all duration-300">

                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow-sm">

                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                            <h3 class="modal-title text-lg font-semibold text-gray-900">
                                Booking Meja
                            </h3>
                            <button type="button" id="closeModal" onclick="closeModal()"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>

                        <!-- Modal body -->
                        <form class="p-4 md:p-5 " id="formBooking" action="{{ route('bookings.store') }}"
                            method="post">
                            @csrf
                            @method('POST')

                            <input type="hidden" name="pool_table_id" id="pool_table_id">
                            <input type="hidden" name="booking_date" id="booking_date">
                            <input type="hidden" name="start_time" id="start_time">
                            <input type="hidden" name="end_time" id="end_time">
                            <input type="hidden" name="status" id="status">

                            <div id="timeSlots" class="grid grid-cols-3 md:grid-cols-4 gap-4">

                                <!-- Tombol Booking Otomatis dari Jam 09:00 - 21:00 -->
                            </div>


                            {{-- Submit --}}
                            <div class="flex justify-end">

                                <button type="submit"
                                    class="submit-btn mt-3 text-white inline-flex items-center bg-black hover:bg-gray-800 transition-all ease-in-out duration-300 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                    <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="btn-text">Pilih</span>
                                    <span
                                        class="spinner hidden w-4 h-4 ms-2 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                                </button>
                            </div>
                        </form>
                    </div>
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

                flatpickr("#calendar-wrapper", {
                    wrap: true,
                    allowInput: true,
                    clickOpens: true,
                    locale: Indonesian,
                    dateFormat: "d-m-Y",
                    minDate: "today",
                    maxDate: new Date().fp_incr(1),
                    position: "below",
                    onChange: function(selectedDates) {
                        if (selectedDates.length) {
                            renderDateButtons(selectedDates[0]);
                        }
                    }
                });

                function renderDateButtons(startDate) {
                    const $container = $("#date-buttons");
                    $container.empty();

                    const days = ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"];

                    for (let i = 0; i < 7; i++) {
                        const date = new Date(startDate);
                        date.setDate(date.getDate() + i);

                        const dayName = days[date.getDay()];
                        const dayDate = date.getDate();
                        const monthShort = date.toLocaleString("id-ID", {
                            month: "short"
                        });

                        const isoDate = date.toLocaleDateString('sv-SE'); // Format: YYYY-MM-DD

                        const $btn = $("<button></button>")
                            .addClass(
                                "flex flex-col items-center px-2 md:px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100"
                            )
                            .attr("data-date", isoDate)
                            .html(
                                `<span class="text-xs md:text-sm">${dayName}</span><span class="text-xs md:text-base font-semibold">${dayDate} ${monthShort}</span>`
                            );

                        if (i === 0) {
                            $btn
                                .removeClass("text-gray-700 hover:bg-gray-100")
                                .addClass("bg-[#1C3F3A] text-white font-semibold hover:bg-[#1C3F3A] active-date");
                        }

                        $btn.on("click", function() {
                            $("#date-buttons button")
                                .removeClass(
                                    "bg-[#1C3F3A] text-white font-semibold active-date hover:bg-[#1C3F3A]")
                                .addClass("text-gray-700 hover:bg-gray-100");

                            $(this)
                                .removeClass("text-gray-700 hover:bg-gray-100")
                                .addClass(
                                    "bg-[#1C3F3A] text-white font-semibold hover:bg-[#1C3F3A] active-date");
                            console.log($(this).attr("data-date"));
                        });

                        $container.append($btn);
                    }
                }

                const startHour = 9;
                const endHour = 21;

                for (let i = startHour; i < endHour; i++) {
                    const start = String(i).padStart(2, '0') + ":00";
                    const end = String(i + 1).padStart(2, '0') + ":00";
                    const timeRange = `${start} - ${end}`;

                    $('#timeSlots').append(`
                      <button 
                        type="button" 
                        class="time-btn border rounded-lg p-2 md:p-4 text-center hover:bg-gray-100 transition w-full"
                        data-time="${timeRange}">
                        <p class="text-xs text-gray-500 mb-1">60 Menit</p>
                        <p class="font-bold text-sm">${timeRange}</p>
                        <p class="price text-gray-700 text-sm">Rp</p>
                      </button>
                    `);
                }

                // Toggle button selection
                $(document).on('click', '.time-btn', function() {
                    $(this).toggleClass('bg-[#1C3F3A] text-white border-none active hover:bg-[#1C3F3A]')
                        .toggleClass('text-gray-700 hover:bg-gray-100');

                    $(this).find('p')
                        .toggleClass('text-white')
                        .toggleClass('text-gray-700 text-gray-500');

                    // Ambil semua waktu yang dipilih
                    const selectedTimes = $('.time-btn.active').map(function() {
                        return $(this).data('time');
                    }).get(); // .get() untuk ubah ke array JavaScript biasa

                    // Update input hidden
                    // Bersihkan input lama
                    $('#formBooking input[name="selected_time[]"]').remove();

                    selectedTimes.forEach(time => {
                        $('#formBooking').append(
                            `<input type="hidden" name="selected_time[]" value="${time}">`
                        );
                    });

                    // Ambil informasi dari tombol yang diklik
                    const tableId = $('#formBooking').attr('data-id');
                    const date = $('.active-date').data('date');

                    // Isi input hidden yang lain
                    $('#pool_table_id').val(tableId);
                    $('#booking_date').val(date);
                    $('#start_time').val(selectedTimes[0] || '');
                    $('#end_time').val(selectedTimes[selectedTimes.length - 1] || '');

                    console.log("Jam dipilih:", selectedTimes);
                });

            });
        </script>
        @include('components.js.renderPoolTablesUser')
    @endpush

</x-guest-layout>
