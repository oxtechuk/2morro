@extends('shared.base', ['title' => '404 Error'])

@section('body_attribute')
    class="bg-primary h-screen w-screen flex justify-center items-center"
@endsection

@section('content')
    <div class="2xl:w-1/4 lg:w-1/3 md:w-1/2 w-full">
        <div class="card overflow-hidden sm:rounded-md rounded-none">
            <div class="px-6 py-8">
                <a class="flex justify-center mb-8" href="{{ url('/') }}">
                    <img alt="" class="h-6" src="{{ asset('images/logo-dark.png') }}"/>
                </a>
                <div class="w-1/2 mx-auto block my-8">
                    <img src="{{ asset('images/404-error.svg') }}" title="maintenance.svg"/>
                </div>
                <h3 class="text-dark mb-4 mt-6 text-center text-3xl">Page Not Found</h3>
                <p class="text-dark/75 mb-8 mx-auto text-base text-center">It's looking like you may have taken a wrong
                    turn. Don't worry... it happens to the best of us. You might want to check your internet
                    connection.</p>
                <div class="flex justify-center">
                    <a class="btn text-white bg-primary" href="{{ url('/') }}"> Back To Home </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
