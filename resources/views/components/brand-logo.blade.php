@props(['size' => 'md', 'tagline' => true, 'tone' => 'light'])

@php
    // tone light: texto blanco (fondos oscuros). tone dark: texto oscuro (fondos claros)
    $icon = ['sm' => 'w-8 h-8', 'md' => 'w-10 h-10', 'lg' => 'w-12 h-12'][$size] ?? 'w-10 h-10';
    $name = ['sm' => 'text-[16px]', 'md' => 'text-[18px]', 'lg' => 'text-[24px]'][$size] ?? 'text-[18px]';
    $nameColor = $tone === 'light' ? 'text-white' : 'text-slate-900';
    $accent = $tone === 'light' ? 'text-brand-300' : 'text-brand-600';
    $tagColor = $tone === 'light' ? 'text-white/50' : 'text-slate-500';
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-3']) }}>
    <img src="{{ asset('images/favicon.svg') }}" alt="MediVortex" class="{{ $icon }} shrink-0 drop-shadow-sm">
    <span class="flex flex-col leading-none">
        <span class="font-extrabold tracking-tight {{ $name }} {{ $nameColor }}">Medi<span class="{{ $accent }}">Vortex</span></span>
        @if ($tagline)
            <span class="mt-1.5 text-[9.5px] font-semibold uppercase tracking-[0.2em] {{ $tagColor }}">Logística &amp; Distribución</span>
        @endif
    </span>
</span>
