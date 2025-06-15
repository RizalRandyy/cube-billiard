<x-guest-layout>
    <div class="flex flex-col lg:flex-row gap-6 p-6 w-full mt-28 px-4 md:px-8 mb-28">

        <!-- Left Section -->
        <div class="w-full lg:w-2/3 bg-white p-4 md:p-6 rounded-lg shadow-lg">
            <h2 class="text-lg font-semibold">Cube Billiard</h2>
            <div class="flex items-center text-center gap-2">
                <x-icons.star class="w-4 h-4 text-yellow-400"></x-icons.star>
                <p class="text-sm text-yellow-400">4.9</p>
                <p class="text-sm text-gray-500">•</p>
                <p class="text-sm text-gray-500">Lembang</p>
            </div>
            <hr class="my-5 border-t border-dashed border-gray-400" />

            <!-- Schedule List -->
            <div class="space-y-2">
                @foreach ($bookings as $booking)
                    <div class="p-2 md:p-4 mb-3 border-l-4 border-gray-700 bg-gray-50 rounded">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm mb-1 md:mb-2">
                                    {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('D, j M Y') }}
                                    • {{ $booking->start_time }} - {{ $booking->end_time }}
                                </p>
                                <p class="text-sm mb-1 md:mb-2">Meja: {{ $booking->poolTable->name ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-700 mb-1 md:mb-2">Rp
                                    {{ number_format($booking->poolTable->price_per_hour, 2, ',', '.') ?? 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <hr class="my-5 border-t border-dashed border-gray-400" />

            <a href="{{ route('/') }}"
                class="mt-4 text-sm text-gray-700 flex items-center font-semibold hover:text-gray-500 transition-all ease-in-out duration-300">
                <x-icons.arrow-left class="w-4 h-4 me-2"></x-icons.arrow-left>
                Kembali
            </a>
        </div>

        <!-- Right Section -->
        <div class="w-full lg:w-1/2">

            <!-- Rincian Biaya -->
            <div class="bg-white p-4 rounded-lg shadow">
                <div class="flex items-center text-center gap-3 mb-5">
                    <x-icons.money class="w-7 h-7 md:w-8 md:h-8"></x-icons.money>
                    <h4 class="text-base md:text-lg font-semibold">Rincian Biaya</h4>
                </div>
                <div class="text-sm md:text-base text-gray-600">
                    <div class="flex justify-between mb-3">
                        <span>Biaya Sewa</span><span>Rp {{ number_format($total_table_price, 2, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between mb-5">
                        <span>Biaya Tambahan</span><span>Rp0</span>
                    </div>
                    <hr class="my-2" />
                    <div class="flex justify-between font-semibold">
                        <span>Total Bayar</span><span>Rp {{ number_format($total_table_price, 2, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            @if ($transaction && $transaction->payment_status == 'paid')
                <button id="status-button"
                    class="mt-5 w-full bg-[#1C3F3A] hover:bg-[#2a5e56] transition-all ease-in-out duration-300 text-white font-semibold py-3 rounded-lg shadow">
                    Lihat Status Pembayaran
                </button>
                <a href="">
                    <button
                        class="mt-5 w-full bg-[#1C3F3A] hover:bg-[#2a5e56] transition-all ease-in-out duration-300 text-white font-semibold py-3 rounded-lg shadow">
                        Lihat Riwayat
                    </button>
                </a>
            @else
                <!-- Lanjutkan Button -->
                <button id="pay-button"
                    class="mt-5 w-full bg-[#1C3F3A] hover:bg-[#2a5e56] transition-all ease-in-out duration-300 text-white font-semibold py-3 rounded-lg shadow">
                    Lanjutkan ke Pembayaran
                </button>
            @endif
        </div>
    </div>

    @push('scripts')
        <!-- Midtrans Snap.js -->
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
        </script>

        <script>
            $(document).ready(function() {

                $('#pay-button').on('click', function() {
                    $.ajax({
                        url: 'initiate-transaction',
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(data) {

                            if (data.snapToken) {
                                const transactionId = data.transaction.id;

                                console.log(data);

                                snap.pay(data.snapToken, {
                                    onSuccess: function(result) {
                                        console.log('Pembayaran sukses!');

                                        $.ajax({
                                            url: `update-transaction/${transactionId}`,
                                            method: 'POST',
                                            data: {
                                                _token: '{{ csrf_token() }}',
                                                payment_status: 'paid',
                                                payment_type: result.payment_type,
                                                transaction_status: result.transaction_status,
                                            },
                                            success: function(data) {
                                                console.log(
                                                    'Update data sukses!'
                                                    );
                                                console.log(transactionId);
                                                window.location.reload(); // refresh halaman setelah sukses
                                            },
                                            error: function() {
                                                console.log("error");
                                            }
                                        });
                                    },
                                    onPending: function(result) {
                                        console.log('Pembayaran pending!');
                                    },
                                    onError: function(result) {
                                        console.log('Pembayaran gagal!');
                                    }
                                });
                            } else {
                                console.log('Gagal mendapatkan snap token');
                            }
                        },
                        error: function() {
                            console.log('Terjadi kesalahan saat request snap token');
                        }
                    });
                });

                const transaction = @json($transaction);

                $('#status-button').on('click', function() {
                    Swal.fire({
                        title: 'Pembayaran Berhasil',
                        html: `<p class="mb-1 text-base">Status: <strong>${transaction.payment_status ?? '-'}</strong></p>
                                <p class="mb-1 text-base">Metode: <strong>${transaction.payment_type ?? '-'}</strong></p>
                                <p class="mb-1 text-base">Total: <strong>Rp ${Number(transaction.amount ?? 0).toLocaleString('id-ID')}</strong></p>`,
                        icon: 'success',
                        confirmButtonText: 'Ok',
                        focusCancel: true,
                        background: '#fff',
                        color: '#111827',
                        customClass: {
                            popup: 'rounded-xl shadow-lg px-6 py-4',
                            confirmButton: 'bg-gray-700 hover:bg-gray-500 text-white font-medium px-4 py-2 rounded-lg focus:outline-none mr-5 transtion-all ease-in-out duration-300',
                            title: 'text-lg font-bold',
                            htmlContainer: 'text-sm',
                        },
                        buttonsStyling: false
                    });
                });
            });
        </script>
    @endpush
</x-guest-layout>
