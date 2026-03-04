<div
    class="flex flex-col gap-4 p-6 transition-all duration-300 ease-in-out bg-[#FDFAF5] border-l-4 border-[#2D3F63] shadow-md rounded-xl dark:bg-gray-800 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-lg font-bold text-gray-800 md:text-xl">{{ $title }}</h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $subtitle }}</p>
    </div>
    <a href="{{ $route }}"
        class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white transition duration-200 bg-[#2D3F63] rounded-lg shadow-sm hover:bg-[#1E2A40] focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2 focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
        {{ $buttonText }}
    </a>
</div>
@once
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Untuk .animate-fade-in
                document.querySelectorAll('.animate-fade-in').forEach((el, index) => {
                    setTimeout(() => {
                        el.classList.add('opacity-100');
                    }, index * 100);
                });

                // Untuk .fade-in-up
                document.querySelectorAll('.fade-in-up').forEach((el, index) => {
                    setTimeout(() => {
                        el.classList.add('show');
                    }, 100 * (index + 1));
                });
            });
        </script>
    @endpush

    @push('styles')
        <style>
            /* Animation classes */
            .fade-in {
                transition: opacity 0.5s ease-in-out;
            }

            .fade-in-up {
                opacity: 0;
                transform: translateY(10px);
                transition: opacity 0.5s ease-out, transform 0.5s ease-out;
            }

            .fade-in-up.show {
                opacity: 1;
                transform: translateY(0);
            }

            /* Optional: transition helper (Tailwind-style fallback) */
            .transition-all {
                transition-property: all;
                transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
                transition-duration: 300ms;
            }
        </style>
    @endpush
@endonce
