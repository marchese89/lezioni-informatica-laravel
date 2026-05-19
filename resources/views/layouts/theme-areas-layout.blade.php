@extends('layouts.layout-bootstrap')
@section('content')
    @yield('page-title')
    <div class="container">
        {{ Breadcrumbs::render() }}
    </div>
    @yield('inner')
@endsection
