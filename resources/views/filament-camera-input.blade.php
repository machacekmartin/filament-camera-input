@php
    $color = $getColor();
@endphp

<div
    x-data
    {{
        $attributes
            ->class([
                match ($color) {
                    'gray' => 'text-gray-600 dark:text-gray-400',
                    'red' => 'text-red-600 dark:text-red-400',
                    'yellow' => 'text-yellow-600 dark:text-yellow-400',
                    'green' => 'text-green-600 dark:text-green-400',
                    'blue' => 'text-blue-600 dark:text-blue-400',
                    default => 'text-custom-500',
                },
            ])
    }}
>
    {{ $getContent() }}
</div>
