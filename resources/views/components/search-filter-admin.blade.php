@props([
    'action',
    'search' => '',
    'sortOptions' => [],
    'perPageOptions' => [10, 25, 50, 100],
])

<div class="p-6 bg-white shadow-md rounded-xl dark:bg-gray-800 fade-in-up">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <!-- Search -->
        <div class="w-full md:w-1/2 lg:w-1/3">
            <form method="GET" action="{{ $action }}" class="relative">
                <div class="flex items-center">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ $search }}"
                        placeholder="Cari data..."
                        class="w-full py-2.5 pl-10 pr-4 border border-gray-300 text-sm rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                    <button type="submit"
                        class="absolute inset-y-0 right-0 flex items-center px-3 text-indigo-600 dark:text-indigo-400">
                        <span class="text-sm font-medium">Cari</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Sort & Per Page -->
        <form method="GET" action="{{ $action }}">
            <div class="flex flex-wrap items-center gap-3">
                <div class="w-full sm:w-auto">
                    <select name="sort" onchange="this.form.submit()"
                        class="text-sm mr-5 block w-full py-2.5 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                        @foreach ($sortOptions as $value => $label)
                            <option value="{{ $value }}" {{ request('sort') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full sm:w-auto">
                    <select name="perPage" onchange="this.form.submit()"
                        class="text-sm mr-5 block w-full py-2.5 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                        @foreach ($perPageOptions as $option)
                            <option value="{{ $option }}" {{ request('perPage', 10) == $option ? 'selected' : '' }}>
                                {{ $option }} per halaman
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
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
