@php
    $color = $getColor();
@endphp

<div
    x-data
    {{
        $attributes
            ->class([
                match ($color) {
                    default => 'text-primary-600 dark:text-primary-400',
                },
            ])
    }}
>
    {{ $getContent() }}
</div>
