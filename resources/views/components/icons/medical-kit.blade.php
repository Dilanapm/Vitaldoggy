@props(['class' => 'w-8 h-8'])

<svg {{ $attributes->merge(['class' => $class]) }} fill="currentColor" viewBox="0 0 24 24">
    <path d="M10,2H14A1,1 0 0,1 15,3V5H9V3A1,1 0 0,1 10,2M21,7V13A5,5 0 0,1 16,18H8A5,5 0 0,1 3,13V7H21M11.75,9V11.5H9V13.5H11.75V16H13.25V13.5H16V11.5H13.25V9H11.75Z" />
</svg>
