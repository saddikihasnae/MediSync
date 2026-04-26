<button {{ $attributes->merge(['type' => 'submit', 'class' => 'px-8 py-4 bg-indigo-600 dark:bg-indigo-500 text-white font-black rounded-2xl shadow-xl shadow-indigo-100 dark:shadow-none hover:bg-indigo-700 dark:hover:bg-indigo-400 transition-all uppercase tracking-widest text-xs']) }}>
    {{ $slot }}
</button>
