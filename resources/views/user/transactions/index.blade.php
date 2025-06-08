<x-guest-layout>
    <h2 class="text-xl font-bold">Bayar Sekarang</h2>
    <p>Client Key: {{ config('midtrans.client_key') }}</p>

    <button id="pay-button" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">Bayar</button>

    @push('scripts')
        <!-- Midtrans Snap.js -->
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
        </script>

        <script>
            document.getElementById('pay-button').addEventListener('click', function() {
                snap.pay('{{ $snapToken }}', {
                    onSuccess: function(result) {
                        console.log('Payment Success:', result);
                    },
                    onPending: function(result) {
                        console.log('Payment Pending:', result);
                    },
                    onError: function(result) {
                        console.error('Payment Error:', result);
                    },
                    onClose: function() {
                        alert('Anda menutup popup tanpa menyelesaikan pembayaran.');
                    }
                });
            });
        </script>
    @endpush
</x-guest-layout>
