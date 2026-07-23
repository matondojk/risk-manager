<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-4 py-2 bg-white dark:bg-gray-950 border border-gray-200 dark:border-gray-800 rounded-md font-medium text-sm text-gray-900 dark:text-gray-50 shadow-sm hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-950 dark:focus:ring-gray-300 focus:ring-offset-2 transition-colors disabled:opacity-50 disabled:pointer-events-none']) }}>
    {{ $slot }}
</button>
