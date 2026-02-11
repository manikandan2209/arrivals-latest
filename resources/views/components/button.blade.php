@props([
    'type' => 'primary',
    'buttonType' => 'submit',
    'tag' => 'button',
    'icon' => null,
])

@php
    $styleClasses = \Illuminate\Support\Arr::toCssClasses([
        'text-white font-medium py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors flex row items-center justify-center cursor-pointer ',
        match ($type) {
            'primary' => 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500',
            'danger' => 'bg-red-600 hover:bg-red-700 focus:ring-red-500',
            'secondary' => 'bg-gray-600 hover:bg-gray-700 focus:ring-gray-500',
            'success' => 'bg-green-600 hover:bg-green-700 focus:ring-green-500',    
        },
    ]);
@endphp

<{{ $tag }} {{ $attributes->merge(['class' => $styleClasses]) }}>
    @if ($icon)
        @svg($icon, 'h-5 w-5 mr-2 inline-block align-middle')
    @endif
    {{ $slot }}
    </{{ $tag }}>
