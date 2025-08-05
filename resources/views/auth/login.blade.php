<x-layouts.guest>
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <a href="/" class="flex items-center mb-6 text-2xl font-semibold text-gray-900">
            RestoranEnak
        </a>
        <div class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                    Masuk ke akun Anda
                </h1>

                <!-- Session StAatus -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-4 md:space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email Anda</label>
                        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="nama@email.com" :value="old('email')" required autofocus autocomplete="username">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                        <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required autocomplete="current-password">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between">
                        <!-- Remember Me -->
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="remember_me" name="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="remember_me" class="text-gray-500">{{ __('Remember me') }}</label>
                            </div>
                        </div>

                        <!-- Forgot Password -->
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm font-medium text-teal-600 hover:underline">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="w-full text-white bg-teal-600 hover:bg-teal-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        {{ __('Log in') }}
                    </button>

                    <!-- Register Link -->
                    <p class="text-sm font-light text-gray-500">
                        Belum punya akun? <a href="{{ route('register') }}" class="font-medium text-teal-600 hover:underline">Daftar di sini</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</x-layouts.guest>
