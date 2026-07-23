<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2 bg-gray-900 dark:bg-gray-50 border border-transparent rounded-md font-medium text-sm text-white dark:text-gray-900 shadow hover:bg-gray-800 dark:hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-950 dark:focus:ring-gray-300 focus:ring-offset-2 transition-colors disabled:opacity-50 disabled:pointer-events-none']) }}>
    {{ $slot }}
</button>
