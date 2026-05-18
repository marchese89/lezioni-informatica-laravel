{{-- components/hero.blade.php --}}
<div class="hero">
    <h1>{{ $title }}</h1>
    <p class="text-muted">{{ $subtitle }}</p>

    <a href="{{ $ctaLink }}" class="btn btn-success mt-3 px-4">
        {{ $ctaText }}
    </a>
</div>
