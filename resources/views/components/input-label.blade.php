@props(['value'])

<label {{ $attributes->merge(['class' => 'text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 block']) }}>
    {{ $value ?? $slot }}
</label>
