<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-[#F7EDDA] px-4">

        {{-- Decorative background pattern --}}
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
                                    d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>

                        <h2 class="text-xl font-bold font-serif text-[#2D3F63]">Verifikasi Email</h2>
                        <div class="w-12 h-0.5 bg-[#D4A355] rounded-full mt-2 mb-3"></div>

                        <p class="text-sm leading-relaxed text-[#8C8070]">
                            Terima kasih! Akun Anda telah terdaftar. Untuk melanjutkan, silakan
                            <span class="font-semibold text-[#2D3F63]">verifikasi email Anda</span>
                            dengan mengklik link yang telah kami kirimkan.
                        </p>
                    </div>

                    {{-- Status Alert --}}
                    @if (session('status') == 'verification-link-sent')
                        <div class="flex items-center gap-2 px-4 py-3 mb-5 text-sm font-medium rounded-lg bg-[#EAF2EE] text-[#5C8270] border border-[#5C8270]/20">
                            <svg class="flex-shrink-0 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </div>
                    @endif

                    {{-- Divider --}}
                    <div class="border-t border-[#E5DED6] mb-5"></div>

                    {{-- Actions --}}
                    <div class="flex flex-col gap-3">

                        {{-- Resend Button --}}
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit"
                                class="w-full py-2.5 px-4 text-sm font-semibold tracking-wide uppercase text-white
                                    rounded-lg bg-[#2D3F63] hover:bg-[#1E2A40] transition shadow-sm hover:shadow-md">
                                {{ __('Kirim Ulang Email Verifikasi') }}
                            </button>
                        </form>

                        {{-- Logout --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full py-2.5 px-4 text-sm font-medium text-[#8C8070] border border-[#E5DED6]
                                    rounded-lg bg-transparent hover:bg-[#F7EDDA] hover:text-[#3A3028] transition">
                                {{ __('Keluar dari Akun') }}
                            </button>
                        </form>

                    </div>

                </div>
            </div>

            {{-- Footer note --}}
            <p class="mt-4 text-xs text-center text-[#8C8070]">
                Tidak menerima email? Periksa folder <span class="font-medium text-[#3A3028]">spam</span> atau coba kirim ulang.
            </p>

        </div>
    </div>
</x-guest-layout>
