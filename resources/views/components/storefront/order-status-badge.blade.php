@props(['status'])

@php
    $styles = [
        'pending'    => 'bg-amber-50 text-amber-700 ring-amber-200',
        'processing' => 'bg-blue-50 text-blue-700 ring-blue-200',
        'shipped'    => 'bg-indigo-50 text-indigo-700 ring-indigo-200',
        'delivered'  => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
        'cancelled'  => 'bg-red-50 text-red-700 ring-red-200',
    ][$status] ?? 'bg-gray-50 text-gray-700 ring-gray-200';
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium ring-1 ring-inset {$styles}"]) }}>
    {{ ucfirst($status) }}
</span>
