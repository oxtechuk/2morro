@extends('shared.base', ['title' => 'Register'])

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
                <div class="mb-4">
                    <label class="mb-2" for="LoggingName">Name</label>
                    <input class="form-input" id="LoggingName" placeholder="Enter your email" type="text"/>
                </div>
                <div class="mb-4">
                    <label class="mb-2" for="LoggingEmailAddress">Email Address</label>
                    <input class="form-input" id="LoggingEmailAddress" placeholder="Enter your email" type="email"/>
                </div>
                <div class="mb-4">
                    <label class="mb-2" for="loggingPassword">Password</label>
                    <input class="form-input" id="loggingPassword" placeholder="Enter your password" type="password"/>
                </div>
                <div class="flex items-center mb-4">
                    <input class="form-checkbox rounded" id="checkbox-signin" type="checkbox"/>
                    <label class="ms-2" for="checkbox-signin">I accept <a class="text-primary" href="#">Terms and
                            Conditions</a></label>
                </div>
                <div class="flex justify-center mb-3">
                    <button class="btn w-full text-white bg-primary"> Sign Up Free</button>
                </div>
            </div>
        </div>
        <p class="text-white text-center mt-8">Already have an account ?<a class="font-medium ms-1"
                                                                           href="{{ url('/auth/login') }}">Sign In</a>
        </p>
    </div>
@endsection

@section('scripts')

@endsection
