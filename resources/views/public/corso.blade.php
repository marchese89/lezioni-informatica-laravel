@extends('layouts.theme-areas-layout')
@php
    use App\Models\ThemeArea;
    use App\Models\Matter;
    use App\Models\Course;
    use App\Models\Lesson;
    use App\Models\Exercise;
    use App\Services\AcquistiService;

    $corso = Course::where('id', '=', request('id'))->first();

@endphp
@section('page-title')
    <div class="container py-4">
        <h2 class="fw-bold mb-0">Corso di {{ $corso->name }}</h2>
    </div>
@endsection

@section('inner')

    <div class="container" style="text-align: center;width:35%">


        @if (!Auth::check())
            <strong style="color: red">Devi essere autenticato come studente per poter fare aquisti!</strong>
        @endif
    </div>
    <br>
    <div class="container" style="text-align: center;width:80%">
        <br>
        <h3>Lezioni</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Numero</th>
                    <th scope="col">Titolo</th>
                    <th scope="col">Prezzo</th>
                    <th scope="col">Operazioni</th>
                </tr>
            </thead>
            @php
                $lezioni = Lesson::where('course_id', '=', request('id'))->get();
            @endphp
            <tbody>
                @foreach ($lezioni as $item)
                    @if (
                        (auth()->user()->student && !AcquistiService::prodotto_acquistato(auth()->user()->student?->id, $item->id, 0)) ||
                            auth()->user()->role === 'admin')
                        <tr>

                            <th scope="row">{{ $item->id }}</th>
                            <td>
                                {{ $item->number }}
                            </td>
                            <td>
                                {{ $item->title }}
                            </td>
                            <td>
                                @if ($item->price !== 0)
                                    {{ $item->price }} <strong>&euro;</strong>
                                @else
                                    <strong style="color: green">Gratis</strong>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-primary"
                                    onclick=location.href="presentazione-lezione-{{ $item->id }}-{{ $item->course_id }}">Anteprima</button>
                                @if (Auth::check() && auth()->user()->role === 'student' && $item->price !== 0)
                                    <button type="submit" class="btn btn-primary"
                                        onclick=location.href="/carrello/add/{{ $item->id }}/0">Acquista</button>
                                @endif
                                @if ($item->price === 0)
                                    <button type="submit" class="btn btn-primary"
                                        onclick=location.href="visualizza-lezione-{{ $item->id }}-{{ $item->course_id }}">Contenuto</button>
                                @endif
                            </td>
                        </tr>
                    @else
                        @if (auth()->user() == null)
                            <tr>

                                <th scope="row">{{ $item->id }}</th>
                                <td>
                                    {{ $item->number }}
                                </td>
                                <td>
                                    {{ $item->title }}
                                </td>
                                <td>
                                    @if ($item->price !== 0)
                                        {{ $item->price }} <strong>&euro;</strong>
                                    @else
                                        <strong style="color: green">Gratis</strong>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-primary"
                                        onclick=location.href="presentazione-lezione-{{ $item->id }}-{{ $item->course_id }}">Anteprima</button>
                                    @if (Auth::check() && auth()->user()->role === 'student' && $item->price !== 0)
                                        <button type="submit" class="btn btn-primary"
                                            onclick=location.href="/carrello/add/{{ $item->id }}/0">Acquista</button>
                                    @endif
                                    @if ($item->price === 0)
                                        <button type="submit" class="btn btn-primary"
                                            onclick=location.href="visualizza-lezione-{{ $item->id }}-{{ $item->course_id }}">Contenuto</button>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endif
                @endforeach
            </tbody>
        </table>
        <br>
        <br>
        <h3>Esercizi</h3>

        <br>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"></th>
                    <th scope="col">Titolo</th>
                    <th scope="col">Prezzo</th>
                    <th scope="col">Operazioni</th>
                </tr>
            </thead>
            @php
                $esercizi = Exercise::where('course_id', '=', request('id'))->get();
            @endphp
            <tbody>
                @foreach ($esercizi as $item)
                    @if (
                        (auth()->user() != null &&
                            auth()->user()->student &&
                            !AcquistiService::prodotto_acquistato(auth()->user()->student->id, $item->id, 2)) ||
                            auth()->user()->role === 'admin')
                        <tr>
                            <th scope="row">{{ $item->id }}</th>
                            <td>

                            </td>
                            <td>
                                {{ $item->title }}
                            </td>
                            <td>
                                @if ($item->price !== 0)
                                    {{ $item->price }} <strong>&euro;</strong>
                                @else
                                    <strong style="color: green">Gratis</strong>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-primary"
                                    onclick=location.href="/traccia-esercizio/{{ $item->id }}/{{ request('id') }}">Anteprima</button>
                                @if (Auth::check() && auth()->user()->role === 'student' && $item->price !== 0)
                                    <button type="submit" class="btn btn-primary"
                                        onclick=location.href="/carrello/add/{{ $item->id }}/2">Acquista</button>
                                @endif
                                @if ($item->price === 0)
                                    <button type="submit" class="btn btn-primary">Contenuto</button>
                                @endif
                            </td>
                        </tr>
                    @else
                        @if (auth()->user() == null)
                            <tr>
                                <th scope="row">{{ $item->id }}</th>
                                <td>

                                </td>
                                <td>
                                    {{ $item->title }}
                                </td>
                                <td>
                                    @if ($item->price !== 0)
                                        {{ $item->price }} <strong>&euro;</strong>
                                    @else
                                        <strong style="color: green">Gratis</strong>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-primary"
                                        onclick=location.href="/traccia-esercizio/{{ $item->id }}/{{ request('id') }}">Anteprima</button>
                                    @if (Auth::check() && auth()->user()->role === 'student' && $item->price !== 0)
                                        <button type="submit" class="btn btn-primary"
                                            onclick=location.href="/carrello/add/{{ $item->id }}/2">Acquista</button>
                                    @endif
                                    @if ($item->price === 0)
                                        <button type="submit" class="btn btn-primary">Contenuto</button>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
