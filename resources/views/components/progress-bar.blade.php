@props(['percentage' => 0, 'color' => 'blue', 'size' => 'md'])

@php
    $sizeClasses = match($size) {
        'sm' => 'h-1',
        'md' => 'h-2',
        'lg' => 'h-3',
        default => 'h-2'
    };
    
    $colorClasses = match($color) {
        'success' => 'bg-green-500',
        'warning' => 'bg-yellow-500',
        'danger' => 'bg-red-500',
        'info' => 'bg-blue-500',
        default => 'bg-blue-500'
    };
@endphp

<div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full {{ $sizeClasses }}">
    <div class="{{ $colorClasses }} {{ $sizeClasses }} rounded-full transition-all duration-300 ease-in-out" 
         style="width: {{ $percentage }}%"></div>
</div>
