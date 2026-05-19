@extends('layouts.layout-bootstrap')

@section('content')

    <div class="container py-5">

        {{-- HERO --}}
        <div class="text-center mb-5">

            <h1 class="fw-bold mb-3">
                Aree Tematiche
            </h1>

            <p class="text-muted mx-auto" style="max-width: 700px;">
                Esplora tutte le aree disponibili e accedi ai contenuti,
                corsi e materiali correlati.
            </p>

        </div>
        {{-- EMPTY STATE --}}
        @if ($themeAreas->isEmpty())
            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body text-center py-5">

                    <h4 class="mb-2">
                        Nessuna area tematica disponibile
                    </h4>

                    <p class="text-muted mb-0">
                        Le aree verranno pubblicate prossimamente.
                    </p>

                </div>

            </div>
        @else
            {{-- GRID --}}
            <div class="row g-4">

                @foreach ($themeAreas as $item)
                    <div class="col-xl-3 col-lg-4 col-md-6">

                        <div class="card h-100 border-0 shadow-sm rounded-4 transition-card">

                            <div class="card-body d-flex flex-column p-4">

                                {{-- TITLE --}}
                                <h4 class="fw-semibold mb-3">
                                    {{ $item->name }}
                                </h4>

                                {{-- DESCRIPTION --}}
                                @if (!empty($item->description))
                                    <p class="text-muted flex-grow-1">
                                        {{ Str::limit($item->description, 120) }}
                                    </p>
                                @else
                                    <p class="text-muted flex-grow-1">
                                        Scopri tutti i contenuti disponibili
                                        per questa area tematica.
                                    </p>
                                @endif

                                {{-- BUTTON --}}
                                <div class="mt-3">

                                    <a href="{{ url('/materie/' . $item->id) }}" class="btn btn-primary w-100 rounded-3">

                                        Esplora area

                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>
                @endforeach

            </div>
        @endif

    </div>

    <style>
        .transition-card {
            transition: all 0.2s ease;
        }

        .transition-card:hover {
            transform: translateY(-4px);
        }
    </style>

@endsection
