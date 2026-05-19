<div class="col-xl-4 col-md-6">

    <div class="card border-0 shadow-sm h-100 rounded-4 transition-card">
        <div class="card-body p-4 d-flex flex-column">

            <h4 class="fw-bold mb-3">
                {{ $title }}
            </h4>

            <p class="text-muted flex-grow-1">
                {{ $text }}
            </p>

            <div class="mt-auto">
                <a href="{{ $url }}" class="btn btn-primary rounded-pill px-4">
                    {{ $button }}
                </a>
            </div>

        </div>
    </div>

</div>
