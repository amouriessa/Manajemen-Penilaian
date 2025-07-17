@php
    $types = [
        'success' => [
            'color' => 'green',
            'icon' =>
                '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>',
        ],
        'error' => [
            'color' => 'red',
            'icon' =>
                '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>',
        ],
    ];
@endphp

@foreach ($types as $type => $data)
    @if (session($type))
        <div id="{{ $type }}-alert"
            class="p-4 mb-4 text-{{ $data['color'] }}-700 bg-{{ $data['color'] }}-100 border-l-4 border-{{ $data['color'] }}-500 rounded-md dark:bg-{{ $data['color'] }}-900 dark:text-{{ $data['color'] }}-100 dark:border-{{ $data['color'] }}-600">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        {!! $data['icon'] !!}
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">{{ session($type) }}</p>
                </div>
                <div class="pl-3 ml-auto">
                    <div class="-mx-1.5 -my-1.5">
                        <button onclick="document.getElementById('{{ $type }}-alert').remove()"
                            class="inline-flex p-1.5 text-{{ $data['color'] }}-500 rounded-md hover:bg-{{ $data['color'] }}-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-{{ $data['color'] }}-500">
                            <span class="sr-only">Dismiss</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach

@push('scripts')
    <script>
        // Auto-dismiss alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('#success-alert, #error-alert');
            alerts.forEach(alert => {
                if (alert) {
                    alert.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                    setTimeout(() => {
                        alert.remove();
                    }, 500);
                }
            });
        }, 5000);
    </script>
@endpush
