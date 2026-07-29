@props([
    'src',
    'alt' => '',
    'loading' => 'lazy',
    'decoding' => 'async',
    'fetchpriority' => null,
    'pictureClass' => 'contents',
])

@php
    $srcValue = (string) $src;
    $isExternal = \Illuminate\Support\Str::startsWith($srcValue, ['http://', 'https://', '//', 'data:']);
    $normalizedSrc = $isExternal ? $srcValue : ltrim($srcValue, '/');
    $imageUrl = $isExternal ? $normalizedSrc : asset($normalizedSrc);
    $webpSrc = null;

    if (! $isExternal && preg_match('/\.(png|jpe?g)$/i', $normalizedSrc)) {
        $candidate = preg_replace('/\.(png|jpe?g)$/i', '.webp', $normalizedSrc);

        if (is_string($candidate) && file_exists(public_path($candidate))) {
            $webpSrc = $candidate;
        }
    }

    $defaultAttributes = [
        'src' => $imageUrl,
        'alt' => $alt,
    ];

    foreach ([
        'loading' => $loading,
        'decoding' => $decoding,
        'fetchpriority' => $fetchpriority,
    ] as $name => $value) {
        if ($value !== null && $value !== false && $value !== '') {
            $defaultAttributes[$name] = $value;
        }
    }
@endphp

<picture @if ($pictureClass) class="{{ $pictureClass }}" @endif>
    @if ($webpSrc)
        <source srcset="{{ asset($webpSrc) }}" type="image/webp">
    @endif
    <img {{ $attributes->merge($defaultAttributes) }}>
</picture>
