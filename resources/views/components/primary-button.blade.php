<button {{ $attributes->merge(['type' => 'submit', 'class' => 'px-8 py-4 bg-emerald-600 dark:bg-emerald-500 text-white font-black rounded-2xl shadow-xl shadow-emerald-100 dark:shadow-none hover:bg-indigo-700 dark:hover:bg-emerald-400 transition-all uppercase tracking-widest text-xs']) }}>
    {{ $slot }}
</button>
