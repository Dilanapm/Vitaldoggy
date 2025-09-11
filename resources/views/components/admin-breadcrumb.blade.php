<nav class="flex items-center space-x-2 mb-6 text-sm text-gray-600 dark:text-gray-400">
    <!-- Botón de volver -->
    <button onclick="history.back()" 
            class="flex items-center px-3 py-2 text-gray-600 dark:text-gray-300 hover:text-[#751629] dark:hover:text-[#f56e5c] transition-colors duration-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700"
            title="Volver atrás">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Volver
    </button>

    <span class="text-gray-400 dark:text-gray-500">|</span>

    <!-- Home/Dashboard -->
    <a href="{{ route('admin.dashboard') }}" 
       class="flex items-center px-3 py-2 text-gray-600 dark:text-gray-300 hover:text-[#751629] dark:hover:text-[#f56e5c] transition-colors duration-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
        </svg>
        Dashboard
    </a>

    @if(count($items) > 0)
        @foreach($items as $item)
            <span class="text-gray-400 dark:text-gray-500">/</span>
            @if(isset($item['url']) && !$loop->last)
                <a href="{{ $item['url'] }}" 
                   class="px-3 py-2 text-gray-600 dark:text-gray-300 hover:text-[#751629] dark:hover:text-[#f56e5c] transition-colors duration-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    {{ $item['label'] }}
                </a>
            @else
                <span class="px-3 py-2 font-medium text-[#751629] dark:text-[#f56e5c]">
                    {{ $item['label'] }}
                </span>
            @endif
        @endforeach
    @endif

    @if($currentPage)
        <span class="text-gray-400 dark:text-gray-500">/</span>
        <span class="px-3 py-2 font-medium text-[#751629] dark:text-[#f56e5c]">
            {{ $currentPage }}
        </span>
    @endif
</nav>
