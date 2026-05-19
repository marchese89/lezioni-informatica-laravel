@extends('layouts.theme-areas-layout')

@section('page-title')
    <div class="container py-4">
        <h2 class="fw-bold">Materie</h2>
    </div>
@endsection

@section('inner')
    <div class="container pb-5">

        <div class="row g-4">

            @foreach ($materie as $item)
                <x-ui.card-item :title="$item->name" text="Materia del percorso selezionato" :url="url('/corsi/' . $item->id)" button="Accedi" />
            @endforeach

        </div>

    </div>
@endsection
