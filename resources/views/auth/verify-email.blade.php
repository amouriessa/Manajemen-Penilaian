<x-guest-layout>
    <div class="mb-6 text-center">
        <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-br from-purple-100 to-indigo-100">
            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
        </div>
        <h2 class="mb-2 text-xl font-bold text-gray-800 dark:text-gray-200">Verifikasi Email</h2>
        <p class="text-sm leading-relaxed text-gray-600 dark:text-gray-400">
            Terima kasih! Akun Anda telah terdaftar. Untuk melanjutkan, silakan
            <span class="font-semibold text-purple-600">verifikasi email Anda</span>
            dengan mengklik link yang telah kami kirimkan.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 text-sm font-medium text-green-600 dark:text-green-400">
            {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
        </div>
    @endif

    <div class="flex items-center justify-between mt-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                {{-- <x-primary-button>
                    {{ __('Resend Verification Email') }}
                </x-primary-button> --}}
                <button type="submit" class="text-sm uppercase w-full py-3 px-4 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-[1.02] transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-indigo-300 focus:ring-opacity-50">
                    {{ __('Resend Verification Email') }}
                </button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="text-sm text-gray-600 underline rounded-md dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
