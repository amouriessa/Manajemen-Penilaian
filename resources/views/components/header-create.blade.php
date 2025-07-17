<div class="flex flex-col items-start justify-between gap-4 mb-6 sm:flex-row sm:items-center">
    <div>
        <div class="flex items-center gap-2 mb-1 text-sm text-gray-500 dark:text-gray-400">
            <a href="{{ $route }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">{{ $breadcrumbTitle }}</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="font-medium text-gray-700 dark:text-gray-300">{{ $breadcrumbActive }}</span>
        </div>
        <h1 class="text-xl font-bold text-gray-800 dark:text-white md:text-2xl">{{ $title }}</h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $description }}</p>
    </div>
    <a href="{{ $route }}"
        class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white transition duration-200 bg-gray-600 rounded-lg shadow-sm hover:bg-gray-700 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        {{ $buttonText }}
    </a>
</div>
