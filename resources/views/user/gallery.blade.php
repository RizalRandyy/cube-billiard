<x-guest-layout>
    <div class="mt-28">
        <div class="max-w-[1600px] mx-auto px-6 sm:px-12 py-10 bg-white rounded-2xl shadow-2xl border border-gray-200">

            @php
                $gallery = [
                    ["src" => asset('assets/images/landing-page-user/s2.jpg'), 'category' => 'event', 'alt' => 'Juara 1', 'title' => 'Juara 1'],
                    ["src" => asset('assets/images/landing-page-user/s3.jpg'), 'category' => 'event', 'alt' => 'Juara 2', 'title' => 'Juara 2'],
                    ["src" => asset('assets/images/landing-page-user/s4.jpg'), 'category' => 'event', 'alt' => 'Juara 3', 'title' => 'Juara 3'],
                    ["src" => asset('assets/images/landing-page-user/bl1.png'), 'category' => 'tempat', 'alt' => 'Tempat 1', 'title' => 'Tempat'],
                    ["src" => asset('assets/images/landing-page-user/bl2.png'), 'category' => 'tempat', 'alt' => 'Tempat ', 'title' => 'Tempat'],
                    ["src" => asset('assets/images/landing-page-user/bl3.png'), 'category' => 'tempat', 'alt' => 'Tempat ', 'title' => 'Tempat'],
                    ["src" => asset('assets/images/landing-page-user/waitinglist.jpg'), 'category' => 'karyawan', 'alt' => 'Suasana 1', 'title' => 'Cafe'],
                ];
                $categories = [
                    'tempat' => 'Tempat',
                    'event' => 'Event',
                    'karyawan' => 'Cafe',
                ];
                $uniqueCategories = collect($gallery)->pluck('category')->unique()->values();
            @endphp

            {{-- Filter Kategori --}}
            <div class="flex justify-center flex-wrap gap-2 mb-10">
                <button class="filter-btn px-4 py-2 bg-blue-600 text-white rounded shadow hover:shadow-lg transition" data-filter="all">Semua</button>
                @foreach($uniqueCategories as $cat)
                    <button class="filter-btn px-4 py-2 bg-gray-200 text-gray-800 rounded shadow hover:shadow-lg transition capitalize" data-filter="{{ $cat }}">
                        {{ $categories[$cat] ?? ucfirst($cat) }}
                    </button>
                @endforeach
            </div>

            {{-- Grid Galeri --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-6" id="galleryGrid">
                @foreach ($gallery as $item)
                    <div class="gallery-item" data-category="{{ $item['category'] }}">
                        <img 
                            src="{{ $item['src'] }}" 
                            data-full="{{ $item['src'] }}"
                            alt="{{ $item['alt'] }}"
                            class="w-full h-[200px] object-cover rounded-xl shadow hover:scale-105 transition-transform duration-300 cursor-pointer"
                        >
                        <div class="mt-3 text-center">
                            <h2 class="font-semibold text-base md:text-lg">{{ $item['title'] }}</h2>
                            <button class="text-sm text-blue-600 hover:underline view-btn" data-image="{{ $item['src'] }}">Lihat Gambar</button>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Lightbox Modal --}}
            <div id="lightbox" class="fixed inset-0 bg-black bg-opacity-80 hidden items-center justify-center z-50">
                <img id="lightboxImage" class="max-w-[90vw] max-h-[85vh] rounded shadow-xl">
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const filterButtons = document.querySelectorAll(".filter-btn");
            const items = document.querySelectorAll(".gallery-item");
            filterButtons.forEach(button => {
                button.addEventListener("click", () => {
                    const filter = button.dataset.filter;
                    filterButtons.forEach(btn => btn.classList.remove("bg-blue-600", "text-white"));
                    button.classList.add("bg-blue-600", "text-white");
                    items.forEach(item => {
                        item.style.display = (filter === "all" || item.dataset.category === filter) ? "block" : "none";
                    });
                });
            });

            // Lightbox
            const lightbox = document.getElementById("lightbox");
            const lightboxImage = document.getElementById("lightboxImage");
            document.querySelectorAll(".view-btn, .gallery-item img").forEach(button => {
                button.addEventListener("click", () => {
                    const imgUrl = button.dataset.image || button.dataset.full;
                    lightboxImage.src = imgUrl;
                    lightbox.classList.remove("hidden");
                });
            });
            lightbox.addEventListener("click", () => lightbox.classList.add("hidden"));
        });
    </script>
    @endpush
</x-guest-layout>