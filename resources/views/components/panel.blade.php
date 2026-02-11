@props(['paneltitle' => ''])
<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-4">
    <div class="flex items-center mb-4">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $paneltitle }}</h2>
    </div>
    {{ $slot }}
</div>