<a {{ $attributes->merge([
    'class' => 'btn btn-primary rounded-pill px-4 py-2',
]) }}>
    {{ $slot }}
</a>
