@props(['type' => 'info', 'message'])

@php
    $alertTypes = [
        'success' => 'bg-green-100 border-green-500 text-green-900',
        'error' => 'bg-red-100 border-red-500 text-red-900',
        'info' => 'bg-blue-100 border-blue-500 text-blue-900',
        'warning' => 'bg-yellow-100 border-yellow-500 text-yellow-900',
    ];
@endphp

@if (session($message))
    <div class="{{ $alertTypes[$type] }} border-t-4 px-4 py-3 shadow-md my-2" role="alert">
        <div class="flex">
            <div class="py-1">
                   @if ($type === 'success')
                        <i class="fa-solid fa-check-circle mr-2 text-lg "></i>   
                    @elseif ($type === 'error')
                        <i class="fa-solid fa-xmark mr-2 text-lg"></i>
                    @elseif ($type === 'info')
                        <i class="fa-solid fa-info-circle mr-2 text-lg"></i>
                    @elseif ($type === 'warning')
                        <i class="fa-solid fa-exclamation-triangle mr-2 text-lg"></i>
                    @endif
            </div>
            <div>
                <p class="font-bold">{{ ucfirst($type) }}</p>
                <p class="text-sm">{{ session($message) }}</p>
            </div>
        </div>
    </div>
@endif
