<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-medium text-sm text-white shadow hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2 dark:bg-red-900 dark:text-gray-50 dark:hover:bg-red-900/90 dark:focus:ring-red-900 transition-colors disabled:opacity-50 disabled:pointer-events-none']) }}>
    {{ $slot }}
</button>
