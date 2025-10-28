{{-- Optimized Image Component with Lazy Loading --}}
@props([
    'src',
    'alt' => '',
    'class' => '',
    'width' => null,
    'height' => null,
    'lazy' => true,
    'placeholder' => 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB2aWV3Qm94PSIwIDAgMSAxIiBmaWxsPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxyZWN0IHdpZHRoPSIxIiBoZWlnaHQ9IjEiIGZpbGw9IiNmM2Y0ZjYiLz48L3N2Zz4='
])

@php
    $lazyClass = $lazy ? 'lazy' : '';
    $lazySrc = $lazy ? $placeholder : $src;
    $dataSrc = $lazy ? "data-src=\"{$src}\"" : '';
@endphp

<img 
    src="{{ $lazySrc }}"
    {!! $dataSrc !!}
    alt="{{ $alt }}"
    class="{{ $class }} {{ $lazyClass }}"
    @if($width) width="{{ $width }}" @endif
    @if($height) height="{{ $height }}" @endif
    loading="lazy"
    decoding="async"
    @if($lazy) onload="this.classList.add('loaded')" @endif
>

@if($lazy)
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Lazy loading implementation
    const lazyImages = document.querySelectorAll('img.lazy');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                img.classList.add('loaded');
                observer.unobserve(img);
            }
        });
    });
    
    lazyImages.forEach(img => imageObserver.observe(img));
});
</script>

<style>
img.lazy {
    opacity: 0;
    transition: opacity 0.3s;
}

img.lazy.loaded {
    opacity: 1;
}
</style>
@endif
