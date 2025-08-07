@props([
    'src',
    'alt',
    'width' => null,
    'height' => null,
    'class' => '',
    'loading' => 'lazy',
    'sizes' => '(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw'
])

@php
    $optimizedAlt = app('App\Services\SeoService')->optimizeImageAlt($alt);
@endphp

<img 
    src="{{ $src }}" 
    alt="{{ $optimizedAlt }}"
    @if($width) width="{{ $width }}" @endif
    @if($height) height="{{ $height }}" @endif
    loading="{{ $loading }}"
    sizes="{{ $sizes }}"
    class="{{ $class }}"
    {{ $attributes }}
>