<!-- NAVBAR -->
<nav class="bg-[#1A2E44] fixed w-full z-20 top-0 start-0 border-b border-gray-200">
    <div class="max-w-full flex flex-wrap items-center justify-between p-4 mx-3">
        <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ asset('assets/images/logo.png') }}" class="w-16 h-16" alt="Cube Billiard Logo">
        </a>
        <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
            @if (auth()->check()  && (auth()->user()->hasRole('User') || auth()->user()->hasRole('Kasir')))
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="text-white border border-white bg-transparent hover:text-[#22D172] hover:border-[#22D172] focus:outline-none font-medium rounded-lg text-sm px-5 py-2 text-center transition-all duration-300 ease-in-out md:mx-2">
                        Log Out 
                    </button>
                </form>

            @else
                <a href="{{ route('login') }}">
                    <button type="button"
                        class="text-white border border-white bg-transparent hover:text-[#22D172] hover:border-[#22D172] focus:outline-none font-medium rounded-lg text-sm px-5 py-2 text-center transition-all duration-300 ease-in-out md:mx-2">
                        Log In
                    </button>
                </a>
                <a href="{{ route('register') }}">
                    <button type="button"
                        class="text-white bg-[#22D172] hover:bg-[#45d686] focus:outline-none font-medium rounded-lg text-sm px-5 py-2 text-center transition-all duration-300 ease-in-out hidden md:block">
                        Sign Up
                    </button>
                </a>
            @endif
            <button id="mobile-menu-toggle" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden bg-gray-100 focus:outline-none focus:ring-2">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
        </div>
    </div>
</nav>

<!-- DROPDOWN (Mobile Menu) -->
<div id="navbar-sticky"
    class="fixed top-[72px] left-0 w-full z-10 transition-all duration-500 ease-in-out max-h-0 overflow-hidden md:hidden mt-6">

    <!-- Inner container with spacing and style -->
    <div class="mx-6 bg-white shadow-lg rounded-xl border border-gray-200">
        <ul class="flex flex-col px-4 py-4 font-medium space-y-3">
            {{-- <li>
                <a href="{{ route('login') }}"
                    class="block py-2 px-4 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    Sign In
                </a>
            </li> --}}
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
