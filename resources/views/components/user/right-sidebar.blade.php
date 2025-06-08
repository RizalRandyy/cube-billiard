@props(['bookings'])

<div class="drawer drawer-end z-30">
    <input id="my-drawer-4" type="checkbox" class="drawer-toggle" />
    <!-- Sidebar Drawer -->
    <div class="drawer-side">
        <label for="my-drawer-4" aria-label="close sidebar" class="drawer-overlay bg-transparent"></label>

        <div class="bg-white text-base min-h-full w-96 p-4 relative">

            <!-- Header: Jadwal + Close Button -->
            <div class="flex justify-center items-center relative mb-4">
                <h2 class="text-xl font-semibold mx-auto my-3">Jadwal Dipilih</h2>
                <label for="my-drawer-4" class="absolute right-0 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="m6.4 18.308l-.708-.708l5.6-5.6l-5.6-5.6l.708-.708l5.6 5.6l5.6-5.6l.708.708l-5.6 5.6l5.6 5.6l-.708.708l-5.6-5.6z" />
                    </svg>
                </label>
            </div>

            <!-- Garis Putus-putus -->
            <hr class="border-t border-dashed border-gray-400 mb-4" />

            <!-- Konten sidebar -->
            @forelse ($bookings as $booking)
                <div class="p-4 mb-3 border-l-4 border-gray-700 bg-gray-50 rounded">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm">
                                {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('D, j M Y') }}
                                • {{ $booking->start_time }} - {{ $booking->end_time }}
                            </p>
                            <p class="text-sm">Meja: {{ $booking->poolTable->name ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-700">Rp
                                {{ number_format($booking->poolTable->price_per_hour, 2, ',', '.') ?? 'N/A' }}</p>
                        </div>
                        <form method="POST" action="{{ route('bookings.destroy', $booking->id) }}">
                            @csrf
                            @method('DELETE')

                            <button class="text-red-500 hover:text-red-700">
                                <x-icons.trash class="w-4 h-4"></x-icons.trash>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-center text-sm text-gray-500 mt-8">Belum ada jadwal dipilih.</p>
            @endforelse

            @if ($bookings->isNotEmpty())
                <a href="{{ route('booking_groups.index') }}"
                    class="w-full bg-[#1C3F3A] text-white flex items-center justify-center p-2 rounded-xl">Selanjutnya</a>
            @endif
        </div>
    </div>
</div>
