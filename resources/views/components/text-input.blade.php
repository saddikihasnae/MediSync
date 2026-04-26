@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full bg-slate-50 dark:bg-slate-900/50 border-none rounded-2xl p-4 font-bold text-slate-700 dark:text-white focus:ring-4 focus:ring-indigo-100 dark:focus:ring-indigo-900/30 transition-all disabled:opacity-50']) }}>
