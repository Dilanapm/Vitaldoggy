<div class="mb-6">
    @if($url)
        <a href="{{ $url }}" 
           class="inline-flex items-center px-4 py-2 text-gray-600 dark:text-gray-300 hover:text-[#751629] dark:hover:text-[#f56e5c] transition-colors duration-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            {{ $text }}
        </a>
    @else
        <button onclick="history.back()" 
                class="inline-flex items-center px-4 py-2 text-gray-600 dark:text-gray-300 hover:text-[#751629] dark:hover:text-[#f56e5c] transition-colors duration-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            {{ $text }}
        </button>
    @endif
</div>
