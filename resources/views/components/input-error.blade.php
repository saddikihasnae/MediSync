@props(['messages'])

@if ($messages)
    <div {{ $attributes->merge(['class' => 'text-xs text-red-500 flex items-center gap-1 font-medium mt-1 animate-pulse']) }}>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <ul class="space-y-1">
            @foreach ((array) $messages as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif
