@php
    $tag = $href ? 'a' : 'button';
    $personalize = tallstackui_personalization('button', $personalization());

    $sizes['wrapper'] = $personalize['wrapper.sizes.' . $size];
    $sizes['icon'] = $personalize['icon.sizes.' . $size];
@endphp

<{{ $tag }} @if ($href) href="{{ $href }}" @else role="button" @endif {{ $attributes->class([
        $personalize['wrapper.class'],
        $sizes['wrapper'],
        $colors['background'],
        'rounded-md' => !$square && !$round,
        'rounded-full' => !$square && $round !== null,
    ]) }} wire:loading.attr="disabled" wire:loading.class="!cursor-wait">
    @if ($icon && $position === 'left')
        <x-icon :$icon @class([$sizes['icon'], $colors['icon']]) />
    @endif
    {{ $text ?? $slot }}
    @if ($icon && $position === 'right')
        <x-icon :$icon @class([$sizes['icon'], $colors['icon']]) />
    @endif
    @if ($loading)
        <x-tallstack-ui::icon.others.loading-button :$loading :$delay @class([
            'animate-spin',
            $sizes['icon'],
            $colors['icon'],
        ]) />
    @endif
</{{ $tag }}>
