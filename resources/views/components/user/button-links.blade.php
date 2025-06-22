<div class="w-full flex items-center text-center justify-evenly md:justify-center">
    <div class="container mt-8 flex flex-wrap justify-evenly gap-6 mb-5">
        <a href="#pilih-meja" class="flex-col items-center gap-2 hover:text-gray-800 font-semibold">
            <div
                class="bg-[#1C3F3A] hover:bg-[#2a5e56] transition-all ease-in-out duration-300 text-white rounded-lg shadow-lg p-4 flex items-center gap-3 w-30 h-30 md:w-52 justify-center hover:shadow-xl">
                <x-icons.billiards class="w-6 h-6"></x-icons.billiards>
            </div>
            <p class="text-sm md:text-base mt-2">Booking</p>
        </a>
        @if (auth()->user()?->hasRole('Kasir'))
            <a href="{{ route('admin.dashboard') }}" class="flex-col items-center gap-2 hover:text-gray-800 font-semibold">
                <div
                    class="bg-[#1C3F3A] hover:bg-[#2a5e56] transition-all ease-in-out duration-300 text-white rounded-lg shadow-lg p-4 flex items-center gap-3 w-30 h-30 md:w-52 justify-center hover:shadow-xl">
                    <x-icons.dashboard class="w-6 h-6"></x-icons.dashboard>
                </div>
                <p class="text-sm md:text-base mt-2">Dashboard</p>
            </a>
        @else
            <a href="{{ route('paymentHistory') }}" class="flex-col items-center gap-2 hover:text-gray-800 font-semibold">
                <div
                    class="bg-[#1C3F3A] hover:bg-[#2a5e56] transition-all ease-in-out duration-300 text-white rounded-lg shadow-lg p-4 flex items-center gap-3 w-30 h-30 md:w-52 justify-center hover:shadow-xl">
                    <x-icons.history class="w-6 h-6"></x-icons.history>
                </div>
                <p class="text-sm md:text-base mt-2">Riwayat</p>
            </a>
        @endif
        <a href="#turnamen" data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="flex-col items-center gap-2 font-semibold">
            <div
                class="bg-[#1C3F3A] hover:bg-[#2a5e56] transition-all ease-in-out duration-300 text-white rounded-lg shadow-lg p-4 flex items-center gap-3 w-30 h-30 md:w-52 justify-center hover:shadow-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor" />
                    <path d="M16 2v4M8 2v4M3 10h18" stroke="currentColor" stroke-linecap="round" />
                </svg>
            </div>
            <p class="text-sm md:text-base mt-2">Turnamen</p>
        </a>
        <a href="#gallery" class="flex-col items-center gap-2 font-semibold">
            <div
                class="bg-[#1C3F3A] hover:bg-[#2a5e56] transition-all ease-in-out duration-300 text-white rounded-lg shadow-lg p-4 flex items-center gap-3 w-30 h-30 md:w-52 justify-center hover:shadow-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" />
                    <circle cx="8.5" cy="8.5" r="1.5" stroke="currentColor" />
                    <path d="M21 15l-5-5L5 21" stroke="currentColor" stroke-linecap="round" />
                </svg>
            </div>
            <p class="text-sm md:text-base mt-2">Gallery</p>
        </a>
        <a href="https://wa.me/6281809149351" target="_blank" class="flex-col items-center gap-2 font-semibold">
            <div
                class="bg-[#1C3F3A] hover:bg-[#2a5e56] transition-all ease-in-out duration-300 text-white rounded-lg shadow-lg p-4 flex items-center gap-3 w-30 h-30 md:w-52 justify-center hover:shadow-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path
                        d="M22 16.92v3a2 2 0 0 1-2.18 2A19.72 19.72 0 0 1 3.08 5.18 2 2 0 0 1 5 3h3a2 2 0 0 1 2 1.72c.13.81.36 1.6.7 2.34a2 2 0 0 1-.45 2.11l-1.27 1.27a16 16 0 0 0 6.29 6.29l1.27-1.27a2 2 0 0 1 2.11-.45c.74.34 1.53.57 2.34.7A2 2 0 0 1 22 16.92z"
                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <p class="text-sm md:text-base mt-2">Kontak</p>
        </a>
    </div>

</div>
