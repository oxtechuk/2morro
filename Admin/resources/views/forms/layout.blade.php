@extends('shared.vertical', ['title' => 'Dashboard'])



@section('styles')

@endsection

@section('content')
    @include('shared.partials.page-title', ['subtitle' => 'Apps', 'title' => 'Calendar'])

    <div class="grid lg:grid-cols-2 grid-cols-1 gap-6">
        <div class="card">
            <div class="p-6">
                <h4 class="card-title mb-4">Basic Example</h4>
                <form>
                    <div class="mb-3">
                        <label class="text-default-800 text-sm font-medium inline-block mb-2" for="exampleInputEmail1">Email
                            address</label>
                        <input aria-describedby="emailHelp" class="form-input" id="exampleInputEmail1"
                               placeholder="Enter email" type="email"/>
                        <small class="form-text text-sm text-default-700" id="emailHelp">We'll never share your email
                            with anyone else.</small>
                    </div>
                    <div class="mb-3">
                        <label class="text-default-800 text-sm font-medium inline-block mb-2"
                               for="exampleInputPassword1">Password</label>
                        <input class="form-input" id="exampleInputPassword1" placeholder="Password" type="password"/>
                    </div>
                    <div class="flex items-center gap-2 mb-3">
                        <input class="form-checkbox rounded border border-default-200" id="checkmeout0"
                               type="checkbox"/>
                        <label class="text-default-800 text-sm font-medium inline-block" for="checkmeout0">Check me out
                            !</label>
                    </div>
                    <button class="btn bg-primary text-white" type="submit">Submit</button>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-4">Horizontal form</h4>
            </div>
            <div class="p-6">
                <form class="flex flex-col gap-3">
                    <div class="grid grid-cols-4 items-center gap-6">
                        <label class="text-default-800 text-sm font-medium inline-block mb-2"
                               for="inputEmail3">Email</label>
                        <div class="md:col-span-3">
                            <input class="form-input" id="inputEmail3" placeholder="Email" type="email"/>
                        </div>
                    </div>
                    <div class="grid grid-cols-4 items-center gap-6">
                        <label class="text-default-800 text-sm font-medium inline-block mb-2" for="inputPassword3">Password</label>
                        <div class="md:col-span-3">
                            <input class="form-input" id="inputPassword3" placeholder="Password" type="password"/>
                        </div>
                    </div>
                    <div class="grid grid-cols-4 items-center gap-6">
                        <label class="text-default-800 text-sm font-medium inline-block mb-2" for="inputPassword5">Re
                            Password</label>
                        <div class="md:col-span-3">
                            <input class="form-input" id="inputPassword5" placeholder="Retype Password"
                                   type="password"/>
                        </div>
                    </div>
                    <div class="grid grid-cols-4 items-center gap-6">
                        <div class="md:col-start-2">
                            <div class="flex items-center gap-2">
                                <input class="form-checkbox rounded border border-default-200" id="checkmeout"
                                       type="checkbox"/>
                                <label class="text-default-800 text-sm font-medium inline-block" for="checkmeout">Check
                                    me out !</label>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-4 items-center gap-6">
                        <div class="md:col-start-2">
                            <button class="btn bg-info text-white" type="submit">Sign in</button>
                        </div>
                    </div>
                </form>
            </div>
        </div> <!-- end card -->
        <div class="lg:col-span-2">
            <div class="card">
                <div class="p-6">
                    <h4 class="card-title mb-4">Sizing</h4>
                    <p class="text-sm text-default-700 mb-4">
                        As shown in the previous examples, our grid system allows you to place any number of a <code
                            class="text-primary">.grid-cols-*</code> and <code class="text-primary">.flex</code>
                    </p>
                    <form class="grid grid-cols-4 gap-4 mb-6">
                        <div>
                            <label class="sr-only" for="staticEmail2">Email</label>
                            <input class="form-input" id="staticEmail2" readonly="" type="text"
                                   value="email@example.com"/>
                        </div>
                        <div>
                            <label class="sr-only" for="inputPassword2">Password</label>
                            <input class="form-input" id="inputPassword2" placeholder="Password" type="password"/>
                        </div>
                        <div>
                            <button class="btn bg-primary text-white" type="submit">Confirm identity</button>
                        </div>
                    </form>
                    <form>
                        <div class="flex flex-wrap items-center gap-4">
                            <div>
                                <label class="sr-only" for="inlineFormInput">Name</label>
                                <input class="form-input" id="inlineFormInput" placeholder="Jane Doe" type="text"/>
                            </div>
                            <div>
                                <label class="sr-only" for="inlineFormInputGroup">Username</label>
                                <div class="flex">
                                    <span
                                        class="px-4 inline-flex items-center min-w-fit rounded-l border border-e-0 border-default-200 bg-default-50 text-sm text-default-500">@</span>
                                    <input class="form-input rounded-l-none" placeholder="Username" type="text"/>
                                </div>
                            </div>
                            <div>
                                <button class="btn bg-primary text-white" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div> <!-- end card -->
        </div> <!-- end col -->
        <div class="lg:col-span-2">
            <div class="card">
                <div class="p-6">
                    <h4 class="card-title mb-4">Grid</h4>
                    <p class="text-sm text-default-700 mb-4">More complex layouts can also be created with the grid
                        system.</p>
                    <form>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="text-default-800 text-sm font-medium inline-block mb-2" for="inputEmail4">Email</label>
                                <input class="form-input" id="inputEmail4" placeholder="Email" type="email"/>
                            </div>
                            <div>
                                <label class="text-default-800 text-sm font-medium inline-block mb-2"
                                       for="inputPassword4">Password</label>
                                <input class="form-input" id="inputPassword4" placeholder="Password" type="password"/>
                            </div>
                            <div class="lg:col-span-2">
                                <label class="text-default-800 text-sm font-medium inline-block mb-2"
                                       for="inputAddress">Address</label>
                                <input class="form-input" id="inputAddress" placeholder="1234 Main St" type="text"/>
                            </div>
                            <div>
                                <label class="text-default-800 text-sm font-medium inline-block mb-2"
                                       for="inputAddress2">Address 2</label>
                                <input class="form-input" id="inputAddress2" placeholder="Apartment, studio, or floor"
                                       type="text"/>
                            </div>
                            <div>
                                <label class="text-default-800 text-sm font-medium inline-block mb-2" for="inputCity">City</label>
                                <input class="form-input" id="inputCity" type="text"/>
                            </div>
                            <div>
                                <label class="text-default-800 text-sm font-medium inline-block mb-2" for="inputState">State</label>
                                <select class="form-select" id="inputState">
                                    <option>Choose</option>
                                    <option>Option 1</option>
                                    <option>Option 2</option>
                                    <option>Option 3</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-default-800 text-sm font-medium inline-block mb-2"
                                       for="inputZip">Zip</label>
                                <input class="form-input" id="inputZip" type="text"/>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 my-3">
                            <input class="form-checkbox rounded border border-default-200" id="customCheck11"
                                   type="checkbox"/>
                            <label class="text-default-800 text-sm font-medium inline-block" for="customCheck11">Check
                                this custom checkbox !</label>
                        </div>
                        <button class="btn bg-primary text-white" type="submit">Sign in</button>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
@endsection

@section('scripts')

@endsection
