<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-[#F7EDDA] px-4">

        {{-- Decorative background --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none opacity-30">
            <div class="absolute -top-10 -right-10 w-64 h-64 rounded-full bg-[#2D3F63]/10"></div>
            <div class="absolute -bottom-10 -left-10 w-48 h-48 rounded-full bg-[#D4A355]/20"></div>
        </div>

        <div class="relative w-full max-w-md">

            {{-- Card --}}
            <div class="bg-[#FDFAF5] shadow-lg rounded-2xl overflow-hidden">

                {{-- Top accent bar --}}
                <div class="h-1.5 w-full bg-[linear-gradient(90deg,#2D3F63_0%,#D4A355_50%,#B5655A_100%)]"></div>

                <div class="p-8">

                    {{-- Icon & Header --}}
                    <div class="flex flex-col items-center mb-6 text-center">
                        <div class="flex items-center justify-center w-16 h-16 mb-4 rounded-2xl bg-[#2D3F63] shadow-md">
                            <svg class="w-8 h-8 text-[#D4A355]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>

                        <h2 class="text-xl font-bold font-serif text-[#2D3F63]">Lupa Password?</h2>
                        <div class="w-12 h-0.5 bg-[#D4A355] rounded-full mt-2 mb-3"></div>

                        <p class="text-sm leading-relaxed text-[#8C8070]">
                            Tidak masalah! Masukkan
                            <span class="font-semibold text-[#2D3F63]">email Anda</span>
                            dan kami akan mengirimkan link untuk pengaturan ulang password.
                        </p>
                    </div>

                    {{-- Session Status --}}
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    {{-- Divider --}}
                    <div class="border-t border-[#E5DED6] mb-5"></div>

                    {{-- Form --}}
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        {{-- Email --}}
                        <div class="mb-5">
                            <label for="email" class="block mb-1.5 text-xs font-semibold tracking-wide uppercase text-[#8C8070]">
                                {{ __('Alamat Email') }}
                            </label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                class="w-full px-4 py-2.5 text-sm text-[#3A3028] bg-[#F7EDDA] border border-[#E5DED6]
                                    rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2D3F63]/30 focus:border-[#2D3F63]
                                    placeholder-[#C4B8A8] transition"
                                placeholder="contoh@email.com"
                            />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        {{-- Submit --}}
                        <button type="submit"
                            class="w-full py-2.5 px-4 text-sm font-semibold tracking-wide uppercase text-white
                                rounded-lg bg-[#2D3F63] hover:bg-[#1E2A40] transition shadow-sm hover:shadow-md">
                            {{ __('Kirim Link Reset Password') }}
                        </button>

                    </form>

                    {{-- Back to login --}}
                    <div class="mt-4 text-center">
                        <a href="{{ route('login') }}"
                            class="text-xs text-[#8C8070] hover:text-[#2D3F63] transition underline underline-offset-2">
                            ← Kembali ke halaman login
                        </a>
                    </div>

                </div>
            </div>

            {{-- Footer note --}}
            <p class="mt-4 text-xs text-center text-[#8C8070]">
                Pastikan email yang dimasukkan sesuai dengan akun yang terdaftar.
            </p>

        </div>
    </div>
</x-guest-layout>
