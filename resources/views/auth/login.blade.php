<x-guest-layout>
    <div class="flex items-center justify-center min-h-screen px-4 py-8">
        <div class="w-full max-w-2xl overflow-hidden transition-all duration-300 bg-[#FDFAF5] shadow-xl rounded-2xl">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <!-- LEFT: Branding Section -->
                <div
                    class="relative md:flex flex-col justify-between p-10 text-white rounded-l-2xl overflow-hidden
                    bg-[linear-gradient(155deg,#1E2A40_0%,#2D3F63_55%,#243550_100%)]">

                    <div class="absolute inset-0 opacity-[0.06] pointer-events-none"
                        style="background-image:url('data:image/svg+xml,%3Csvg xmlns=&quot;http://www.w3.org/2000/svg&quot; width=&quot;80&quot; height=&quot;80&quot; viewBox=&quot;0 0 80 80&quot;%3E%3Cg fill=&quot;none&quot; stroke=&quot;white&quot; stroke-width=&quot;0.6&quot;%3E%3Ccircle cx=&quot;40&quot; cy=&quot;40&quot; r=&quot;30&quot;/%3E%3Cpolygon points=&quot;40,10 70,40 40,70 10,40&quot;/%3E%3C/g%3E%3C/svg%3E');">
                    </div>

                    <div class="relative z-10">
                        <div class="flex items-center justify-center w-20 h-20 mb-6">
                            <img src="{{ asset('images/logo.png') }}" class="object-contain w-20 h-20" alt="Logo">
                        </div>

                        <p class="text-[11px] tracking-[0.2em] uppercase text-[#E8C990] mb-2 font-sans">
                            Yayasan Pendidikan Islamiyah
                        </p>

                        <h1 class="font-serif text-3xl font-medium leading-tight">
                            SMP <span class="italic text-[#E8C990]">Islamiyah</span><br>
                            Widodaren
                        </h1>

                        <p class="max-w-xs mt-4 text-xs leading-relaxed font-ui text-indigo-200/70">
                            Portal Sistem Manajemen Sekolah Terpadu —
                            Kabupaten Ngawi, Jawa Timur
                        </p>

                        <div class="w-10 h-[2px] mt-6 bg-gradient-to-r from-[#E8C990] to-transparent"></div>
                    </div>
                </div>

                <!-- RIGHT: Login Form Section -->
                <div class="p-6 md:p-8">
                    <div class="mb-6 text-left">
                        <p class="text-[11px] tracking-[0.2em] uppercase text-[#B07833] mb-2 font-sans font-medium">
                            Selamat datang kembali
                        </p>
                        <h2 class="font-serif text-3xl font-medium text-[#1E1810]">{{ __('Login') }} ke Portal Sekolah
                        </h2>
                        {{-- <p class="mt-1 text-sm text-gray-600">{{ __('Access your account') }}</p> --}}
                        <p class="max-w-xs mt-2 text-xs leading-relaxed font-ui text-[#8C8070]">
                            Silakan masuk menggunakan akun yang telah didaftarkan oleh admin sekolah.
                        </p>
                    </div>
                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email')" class="text-[#3A3028] uppercase text-xs font-medium mb-2" />
                            <x-text-input id="email" class="block w-full mt-1 text-xs" type="email" name="email" placeholder="Masukkan email" :value="old('email')" required autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password')" class="text-[#3A3028] uppercase text-xs font-medium mb-2" />

                            <x-text-input id="password" class="block w-full mt-1 text-xs"
                                            type="password"
                                            name="password"
                                            placeholder="Masukkan kata sandi"
                                            required autocomplete="current-password" />

                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <x-primary-button
                        class=" mt-8
                            relative w-full justify-center
                            py-[0.7rem]
                            rounded-xl
                            font-ui text-[0.9rem] font-semibold tracking-[0.02em]
                            text-white
                            bg-[linear-gradient(135deg,#4A6491_0%,#2D3F63_100%)]
                            shadow-[0_4px_20px_rgba(45,63,99,0.3),inset_0_1px_0_rgba(255,255,255,0.1)]
                            transition-all duration-200 ease-out
                            hover:-translate-y-[2px]
                            hover:shadow-[0_8px_28px_rgba(45,63,99,0.35)]
                            active:translate-y-0
                            overflow-hidden
                        ">
                        <span class="absolute inset-0 bg-[linear-gradient(135deg,rgba(212,163,85,0.15),transparent)]
                            opacity-0 transition-opacity duration-200 group-hover:opacity-100"></span>

                        <span class="relative z-10">
                            {{ __('Login') }}
                        </span>
                        </x-primary-button>

                        <div class="flex items-center justify-end mt-4">
                            @if (Route::has('password.request'))
                                <a class="text-xs font-normal text-[#B07833] no-underline hover:underline" href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-0 left-0 right-0 py-4 text-center text-[#8C8070]">
        <p class="text-xs">&copy; {{ date('Y') }} {{ __('SMP Islamiyah Widodaren') }}.
            {{ __('All rights reserved.') }}</p>
    </div>
</x-guest-layout>
