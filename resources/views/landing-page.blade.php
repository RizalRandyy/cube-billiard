<x-guest-layout>

    <div class="flex items-end justify-end">
        <x-user.right-sidebar :bookings="$bookings"></x-user.right-sidebar>
    </div>
    <!-- Konten Welcome -->
    <div class="w-full mt-28 px-4 md:px-8">

        <x-user.carousel></x-user.carousel>

        <x-user.button-links></x-user.button-links>

        <div id="popup-modal" tabindex="-1"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                    <button type="button"
                        class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="popup-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="p-4 md:p-5 text-center">
                        <img src="{{ asset('assets/images/landing-page-user/turnamen.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>

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
                            <button type="button" id="closeModal" onclick="closeModalPoolTableUser()"
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
            window.Laravel = {
                unavailableBookingsPoolTableUser: @json($unavailableBookings),
                bookingsPoolTableUser: @json($bookings),
            }
        </script>
        @vite('resources/js/pages/user/pool-table/index.js')
    @endpush

</x-guest-layout>
