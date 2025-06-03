<section id="gallery">
    <div class="relative w-full mb-4">
        <h1 class="text-2xl md:text-3xl font-semibold text-black text-center">Gallery</h1>
        <a href="{{ route('gallery') }}"
            class="absolute right-10 top-1/2 -translate-y-1/2 text-sm md:text-base underline text-blue-500">
            lebih banyak
        </a>
    </div>
    <div class="w-full px-4 md:px-8">
        <div class="grid md:grid-cols-2 gap-8">
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-6 flex flex-col items-center">
                <img src="{{ asset('assets/images/landing-page-user/event.jpg') }}" alt="Kompetisi Billiard"
                    class="rounded-md mb-4 w-full object-cover">
                <h3 class="text-lg md:text-xl font-semibold mb-2">Kompetisi & Event Rutin</h3>
                <p class="text-gray-700 dark:text-gray-300 text-center text-sm md:text-base">Ikuti turnamen billiard
                    seru setiap bulan dan menangkan hadiah menarik! Pantau jadwal event terbaru di sosial media
                    kami.</p>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-6 flex flex-col items-center">
                <img src="{{ asset('assets/images/landing-page-user/waitinglist.jpg') }}"
                    class="rounded-md mb-4 w-full object-cover">
                <h3 class="text-lg md:text-xl font-semibold mb-2">Cafe Nyaman</h3>
                <p class="text-gray-700 dark:text-gray-300 text-center text-sm md:text-base">Nikmati berbagai
                    pilihan makanan dan minuman lezat di area cafe kami. Tempat yang pas untuk nongkrong santai
                    bersama teman.</p>
            </div>
        </div>

        <!-- Gallery Pemenang Turnamen -->
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-6 my-8">
            <h3 class="text-lg md:text-xl font-semibold mb-4 text-center">Pemenang Turnamen</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div>
                    <img src="{{ asset('assets/images/landing-page-user/s2.jpg') }}" alt="Pemenang 1"
                        class="rounded-md h-40 w-full object-cover mb-2">
                    <div class="text-center text-sm md:text-base font-semibold text-gray-700 dark:text-gray-300">
                        Juara Season 2
                    </div>
                </div>
                <div>
                    <img src="{{ asset('assets/images/landing-page-user/s3.jpg') }}" alt="Pemenang 2"
                        class="rounded-md h-40 w-full object-cover mb-2">
                    <div class="text-center text-sm md:text-base font-semibold text-gray-700 dark:text-gray-300">
                        Juara Season 3
                    </div>
                </div>
                <div class="col-span-2 md:col-span-1 mx-auto w-full">
                    <img src="{{ asset('assets/images/landing-page-user/s4.jpg') }}" alt="Pemenang 3"
                        class="rounded-md h-40 w-full object-cover mb-2">
                    <div class="text-center text-sm md:text-base font-semibold text-gray-700 dark:text-gray-300">
                        Juara Season 4
                    </div>
                </div>
            </div>
        </div>
</section>
