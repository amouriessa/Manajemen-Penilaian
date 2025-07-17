@props([
    'search' => '',
    'status' => 'active',
])

<div class="p-4 bg-white shadow-md fade-in-up rounded-xl dark:bg-gray-800">
    <div class="flex flex-col items-end gap-4 sm:flex-row">
        <div class="flex-1 w-full md:w-1/2 lg:w-1/3">
            <label for="search"
                class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Cari Tugas</label>
            <div class="relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" id="search" name="search" value="{{ $search }}"
                    class="block w-full py-2 pl-10 pr-3 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm"
                    placeholder="Cari berdasarkan surah atau kelas...">
            </div>
        </div>
        {{-- <div class="w-full sm:w-40">
            <label for="status-filter"
                class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
            <select id="status-filter" name="status"
                class="block w-full py-2 pl-3 pr-10 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                <option value="all" @selected($status == 'all')>Semua</option>
                <option value="active" @selected($status == 'active')>Aktif</option>
                <option value="archived" @selected($status == 'archived')>Arsip</option>
            </select>
        </div> --}}
    </div>
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
