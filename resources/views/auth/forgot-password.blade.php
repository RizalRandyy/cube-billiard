<x-guest-layout>

    <section class="bg-gray-50">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <!-- Logo -->
            <a href="/" class="flex items-center mb-6 text-2xl font-semibold text-gray-900">
                <img class="w-32 h-32" src="{{ asset('assets/images/logo.png') }}" alt="logo">
            </a>

            <!-- Card -->
            <div class="w-full p-6 bg-white rounded-lg shadow md:mt-0 sm:max-w-md sm:p-8">
                <p class="mb-4 text-light leading-tight tracking-tight text-gray-900 md:text-light">
                    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </p>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Form -->
                <form class="mt-4 space-y-4 lg:mt-5 md:space-y-5" action="{{ route('password.email') }}" method="POST">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-form.input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email')" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Terms & Conditions -->
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="newsletter" type="checkbox" required
                                class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300"
                                aria-describedby="newsletter" />
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="newsletter" class="font-light text-gray-500">
                                I accept the
                                <a href="#" class="font-medium text-primary-600 hover:underline">
                                    Terms and Conditions
                                </a>
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full text-white bg-black hover:bg-gray-800 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-all duration-300 ease-in-out">
                        {{ __('Email Password Reset Link') }}
                    </button>
                </form>
            </div>
        </div>
    </section>

</x-guest-layout>
