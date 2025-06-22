<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (auth()->user()->hasRole('Kasir'))
                <x-button target="" href="{{ route('/') }}" variant="black" class="justify-center max-w-xl gap-2 mb-3">
                    <span>Booking Meja</span>
                </x-button>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                    <p class="text-xl text-blue-700 font-semibold">TESTOOOO</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
