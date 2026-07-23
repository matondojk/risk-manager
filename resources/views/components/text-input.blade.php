@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'flex w-full border-gray-300 dark:border-gray-800 dark:bg-gray-950 dark:text-gray-50 focus:border-gray-900 dark:focus:border-gray-300 focus:ring-gray-900 dark:focus:ring-gray-300 rounded-md shadow-sm text-sm transition-colors disabled:opacity-50']) }}>
