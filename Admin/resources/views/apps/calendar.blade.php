@extends('shared.vertical', ['title' => 'Calendar'])

@section('styles')

@endsection

@section('content')
    @include('shared.partials.page-title', ['subtitle' => 'Menu', 'title' => 'Calendar'])

    <div class="card">
        <div class="card-body">
            <div id="calendar"></div>
        </div>
    </div>
@endsection

@section('scripts')
    @vite(['resources/js/pages/app-calendar.js'])
@endsection
