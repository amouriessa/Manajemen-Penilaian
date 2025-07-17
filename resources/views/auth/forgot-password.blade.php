<x-guest-layout>
    {{-- <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div> --}}

    <div class="mb-6 text-center">
        <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-br from-indigo-100 to-purple-100">
            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
        </div>
        <h2 class="mb-2 text-xl font-bold text-gray-800 dark:text-gray-200">Lupa Password?</h2>
        <p class="text-sm leading-relaxed text-gray-600 dark:text-gray-400">
            Tidak masalah! Masukkan <span class="font-semibold text-indigo-600">email Anda</span> dan kami akan mengirimkan link untuk pengaturan ulang password
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-6">
            <button type="submit" class="text-sm uppercase w-full py-3 px-4 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-[1.02] transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-indigo-300 focus:ring-opacity-50">
                {{ __('Email Password Reset Link') }}
            </button>
        </div>
    </form>
</x-guest-layout>
