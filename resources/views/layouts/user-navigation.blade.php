<!-- NAVBAR -->
<nav class="bg-white fixed w-full z-20 top-0 start-0 border-b border-gray-200">
    <div class="max-w-full flex flex-wrap items-center justify-between p-4 mx-3">
        <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ asset('assets/images/logo.png') }}" class="w-16 h-16 border border-gray-800 rounded-full" alt="Cube Billiard Logo">
        </a>
        <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
            @if (auth()->check()  && (auth()->user()->hasRole('User') || auth()->user()->hasRole('Kasir')))
                <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button
                    class="flex items-center p-2 text-md font-medium text-gray-500 rounded-md transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none focus:ring focus:ring-black focus:ring-offset-1 focus:ring-offset-white">
                    <div>{{ Auth::user()->name }}</div>

                    <div class="ml-1">
                        <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>
            </x-slot>

            <x-slot name="content">
                <!-- Profile -->
                <x-dropdown-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-dropdown-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>

            @else
                <a href="{{ route('login') }}">
                    <button type="button"
                        class="hover:text-gray-600 font-semibold rounded-lg text-sm px-0 md:px-5 py-3 text-center transition-all duration-300 ease-in-out md:mx-2">
                        Log In
                    </button>
                </a>
                <a href="{{ route('register') }}">
                    <button type="button"
                        class="text-white bg-black hover:bg-gray-600 focus:outline-none font-semibold rounded-full text-sm px-5 py-3 text-center transition-all duration-300 ease-in-out hidden md:block">
                        Sign Up
                    </button>
                </a>
                <button id="mobile-menu-toggle" type="button"
                    class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden bg-gray-100 focus:outline-none focus:ring-2">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1h15M1 7h15M1 13h15" />
                    </svg>
                </button>
            @endif
        </div>
    </div>
</nav>

<!-- DROPDOWN (Mobile Menu) -->
<div id="navbar-sticky"
    class="fixed top-[72px] left-0 w-full z-10 transition-all duration-500 ease-in-out max-h-0 overflow-hidden md:hidden mt-6">

    <!-- Inner container with spacing and style -->
    <div class="mx-6 bg-white shadow-lg rounded-xl border border-gray-200">
        <ul class="flex flex-col px-4 py-4 font-medium space-y-3">
            <li>
                <a href="{{ route('register') }}"
                    class="block py-2 px-4 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    Sign Up
                </a>
            </li>
        </ul>
    </div>
</div>



<!-- Script -->
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#mobile-menu-toggle').on('click', function() {
                const $menu = $('#navbar-sticky');

                if ($menu.hasClass('max-h-0')) {
                    $menu.removeClass('max-h-0').addClass('max-h-[300px]');
                } else {
                    $menu.removeClass('max-h-[300px]').addClass('max-h-0');
                }
            });
        });
    </script>
@endpush
