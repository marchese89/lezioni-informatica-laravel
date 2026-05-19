@extends('layouts.layout-bootstrap')

@section('content')

    <div class="container py-4">

        <div class="mb-4">
            <h2 class="fw-bold mb-3">Aree Tematiche</h2>

            <p class="text-muted" style="max-width: 700px;">
                Esplora tutte le aree disponibili e accedi ai contenuti, corsi e materiali correlati.
            </p>
        </div>

        @if ($themeAreas->isEmpty())
            <x-ui.card>
                <div class="text-center py-5">
                    <h4 class="mb-2">Nessuna area tematica disponibile</h4>
                    <p class="text-muted mb-0">Le aree verranno pubblicate prossimamente.</p>
                </div>
            </x-ui.card>
        @else
            <div class="row g-4">

                @foreach ($themeAreas as $item)
                    {{-- <div class="col-xl-3 col-lg-4 col-md-6">

                        <x-ui.card>

                            <h4 class="fw-semibold mb-3">{{ $item->name }}</h4>

                            <p class="text-muted flex-grow-1">
                                {{ $item->description ? Str::limit($item->description, 120) : 'Scopri tutti i contenuti disponibili per questa area tematica.' }}
                            </p>

                            <div class="mt-auto">
                                <x-ui.primary-button href="{{ url('/materie/' . $item->id) }}" class="w-100">
                                    Esplora area
                                </x-ui.primary-button>
                            </div>

                        </x-ui.card>

                    </div> --}}
                    <x-ui.card-item :title="$item->name" text="Scopri tutti i contenuti disponibili per questa area tematica"
                        :url="url('/materie/' . $item->id)" button="Esplora area" />
                @endforeach

            </div>
        @endif

    </div>

@endsection
