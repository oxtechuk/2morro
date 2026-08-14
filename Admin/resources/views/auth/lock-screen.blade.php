@extends('shared.base', ['title' => 'Lock Screen'])

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
                <div class="mt-6 mb-4 flex justify-center">
                    <img alt="thumbnail" class="rounded-full h-20" src="{{ asset('images/users/avatar-4.jpg') }}"/>
                </div>
                <p class="text-dark/75 text-center mb-6 text-sm mt-3">Enter your password to access the admin. </p>
                <div class="mb-4">
                    <label class="mb-2" for="loggingPassword">Password</label>
                    <input class="form-input" id="loggingPassword" placeholder="Enter your password" type="password"/>
                </div>
                <div class="flex justify-center mb-6">
                    <button class="btn w-full text-white bg-primary"> Unlock</button>
                </div>
                <div class="flex items-center my-6">
                    <div class="flex-auto mt-px border-t border-dashed border-gray-200"></div>
                    <div class="mx-4 text-secondary">Or</div>
                    <div class="flex-auto mt-px border-t border-dashed border-gray-200"></div>
                </div>
                <p class="text-gray-500 text-center">Already have an account ?<a class="text-primary ms-1"
                                                                                 href="{{ url('/auth/login') }}"><b>
                            Sign In</b></a></p>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
