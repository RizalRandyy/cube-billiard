<div id="default-carousel" class="relative w-full z-0" data-carousel="slide">
    <!-- Carousel wrapper -->
    <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
        <!-- Item 1 -->
        <div class="hidden duration-700 ease-in-out" data-carousel-item>
            <img src="{{ asset('assets/images/landing-page-user/bl3.svg') }}"
                class="absolute block w-full h-full object-cover -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 z-0"
                alt="...">

            <!-- Overlay -->
            <div class="absolute inset-0 bg-black/50 z-10"></div>

            <div class="absolute inset-0 flex flex-col justify-center items-center text-center px-4 z-20">
                <h1 class="text-xl md:text-4xl font-bold mb-4 text-white">
                    Selamat Datang di Cube Billiard!
                </h1>
                <p class="text-sm md:text-lg text-white max-w-2xl mx-10">
                    Main billiard nyaman, lengkap, dan terjangkau.
                </p>
            </div>
        </div>
        <!-- Item 2 -->
        <div class="hidden duration-700 ease-in-out" data-carousel-item>
            <img src="{{ asset('assets/images/landing-page-user/bl2.svg') }}"
                class="absolute block w-full h-full object-cover -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 z-0"
                alt="...">

            <!-- Overlay -->
            <div class="absolute inset-0 bg-black/50 z-10"></div>

            <div
                class="ms-10 md:ms-0 absolute inset-0 flex flex-col justify-center items-start text-left px-6 md:px-16 z-20">
                <h1 class="text-xl md:text-4xl font-bold mb-4 text-white">
                    Main Billiard Jadi Lebih Seru
                </h1>
                <p class="text-sm md:text-lg text-white max-w-xl">
                    Nyaman, lengkap, dan terjangkau.
                </p>
            </div>
        </div>
        <!-- Item 3 -->
        <div class="hidden duration-700 ease-in-out" data-carousel-item>
            <img src="{{ asset('assets/images/landing-page-user/bl1.svg') }}"
                class="absolute block w-full h-full object-cover -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 z-0"
                alt="...">

            <!-- Overlay -->
            <div class="absolute inset-0 bg-black/50 z-10"></div>

            <div
                class="ms-10 md:ms-0 absolute inset-0 flex flex-col justify-center items-start text-left px-6 md:px-16 z-20">
                <h1 class="text-xl md:text-4xl font-bold mb-4 text-white">
                    Santai, Main, Repeat!
                </h1>
                <p class="text-sm md:text-lg text-white max-w-xl">
                    Billiard jadi lebih asyik di sini.
                </p>
            </div>
        </div>
        <!-- Item 4 -->
        <div class="hidden duration-700 ease-in-out" data-carousel-item>
            <img src="{{ asset('assets/images/landing-page-user/waitinglist.jpg') }}"
                class="absolute block w-full h-full object-cover -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 z-0"
                alt="...">

            <!-- Overlay -->
            <div class="absolute inset-0 bg-black/50 z-10"></div>

            <div
                class="ms-10 md:ms-0 absolute inset-0 flex flex-col justify-center items-start text-left px-6 md:px-16 z-20">
                <h1 class="text-xl md:text-4xl font-bold mb-4 text-white">
                    Billiard Seru Setiap Hari
                </h1>
                <p class="text-sm md:text-lg text-white max-w-xl">
                    Ajak teman, kumpul, dan main bareng!
                </p>
            </div>
        </div>
    </div>
    <!-- Slider controls -->
    <button type="button"
        class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
        data-carousel-prev>
        <span
            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 1 1 5l4 4" />
            </svg>
            <span class="sr-only">Previous</span>
        </span>
    </button>
    <button type="button"
        class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
        data-carousel-next>
        <span
            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 9 4-4-4-4" />
            </svg>
            <span class="sr-only">Next</span>
        </span>
    </button>
</div>
