<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="flex justify-center mb-6">
            <a href="/">
                <img src="{{ asset('images/logo.webp') }}" alt="Profil" class="object-cover w-20 h-20 text-gray-500 fill-current">
            </a>
        </div>

        <div class="mb-8 text-center">
            <h2 class="mb-2 text-2xl font-bold text-gray-800 dark:text-gray-200">Selamat Datang</h2>
            <p class="text-sm leading-relaxed text-gray-600 dark:text-gray-400">
                Masuk menggunakan <span class="font-semibold text-indigo-600">email</span> dan
                <span class="font-semibold text-indigo-600">password</span> yang telah didaftarkan oleh Admin sekolah
            </p>
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block w-full mt-1"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        {{-- <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="text-indigo-600 border-gray-300 rounded shadow-sm dark:bg-gray-900 dark:border-gray-700 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="text-sm text-gray-600 ms-2 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div> --}}
        <div class="mt-8">
            <button type="submit" class="w-full px-4 py-3 font-medium text-white transition-all duration-200 transform rounded-lg shadow-md bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 hover:shadow-lg hover:scale-105 focus:outline-none focus:ring-4 focus:ring-indigo-300">
                {{ __('Log in') }}
            </button>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="text-sm text-gray-600 underline rounded-md dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>
    </form>
</x-guest-layout>
