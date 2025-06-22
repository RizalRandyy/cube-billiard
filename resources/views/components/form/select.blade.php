@props([
    'disabled' => false,
    'withicon' => false,
])

@php
    $withiconClasses = $withicon ? 'pl-11 pr-4' : 'px-4';
    $disabledClasses = $disabled ? 'bg-gray-200' : '';
@endphp

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' =>
        $withiconClasses .
        ' border border-gray-500 text-gray-600 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 p-2.5' .
        $disabledClasses,
]) !!}>
    {{ $slot }}
</select>
