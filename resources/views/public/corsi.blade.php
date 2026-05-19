@extends('layouts.theme-areas-layout')

@section('page-title')
    <div class="container py-4">
        <h2 class="fw-bold mb-0">Corsi</h2>
        <p class="text-muted mb-0">Seleziona un corso per continuare</p>
    </div>
@endsection

@section('inner')
    <div class="container pb-5">

        <div class="row g-4">

            @foreach ($corsi as $item)
                <x-ui.card-item :title="$item->name" text="Percorso formativo disponibile nella materia selezionata"
                    :url="url('/corso/' . $item->id)" button="Vai" />
            @endforeach

        </div>

    </div>
@endsection
