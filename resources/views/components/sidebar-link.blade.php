@props(['active', 'icon'])

@php
$classes = ($active ?? false)
            ? 'bg-emerald-600/10 text-emerald-400 border-emerald-600/20'
            : 'text-slate-400 hover:bg-white/5 hover:text-white border-transparent';
@endphp

<a {{ $attributes->merge(['class' => 'group flex items-center gap-4 px-6 py-4 text-sm font-black rounded-2xl transition-all duration-300 border-2 ' . $classes]) }}>
    <div class="p-2 rounded-xl {{ ($active ?? false) ? 'bg-emerald-600/20 text-emerald-400' : 'bg-slate-800 text-slate-500 group-hover:bg-slate-700 group-hover:text-emerald-400' }} transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"></path>
        </svg>
    </div>
    <span class="tracking-tight">{{ $slot }}</span>
    
    @if($active ?? false)
        <div class="ms-auto w-1.5 h-1.5 bg-emerald-500 rounded-full shadow-[0_0_10px_#10b981]"></div>
    @endif
</a>
