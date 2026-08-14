@extends('shared.vertical', ['title' => 'Dashboard'])



@section('styles')

@endsection

@section('content')
    @include('shared.partials.page-title', ['subtitle' => 'Forms', 'title' => 'Input'])

    <div class="flex flex-col gap-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Input</h4>
            </div>
            <div class="p-6">
                <div class="grid lg:grid-cols-2 gap-6">
                    <div>
                        <label class="text-default-800 text-sm font-medium inline-block mb-2"
                               for="simpleinput">Text</label>
                        <input class="form-input" id="simpleinput" type="text"/>
                    </div>
                    <div>
                        <label class="text-default-800 text-sm font-medium inline-block mb-2"
                               for="example-email">Email</label>
                        <input class="form-input" id="example-email" name="example-email" placeholder="Email"
                               type="email"/>
                    </div>
                    <div>
                        <label class="text-default-800 text-sm font-medium inline-block mb-2" for="example-password">Password</label>
                        <input class="form-input" id="example-password" type="password" value="password"/>
                    </div>
                    <div>
                        <label class="text-default-800 text-sm font-medium inline-block mb-2" for="password">Show/Hide
                            Password</label>
                        <div class="flex">
                            <input class="form-input" id="password" placeholder="Enter your password" type="password"/>
                            <div class="input-group-text" data-password="false">
                                <span class="password-eye">*</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="text-default-800 text-sm font-medium inline-block mb-2"
                               for="example-palaceholder">Placeholder</label>
                        <input class="form-input" id="example-palaceholder" placeholder="placeholder" type="text"/>
                    </div>
                    <div>
                        <label class="text-default-800 text-sm font-medium inline-block mb-2" for="example-readonly">Readonly</label>
                        <input class="form-input" id="example-readonly" readonly="" type="text" value="Readonly value"/>
                    </div>
                    <div>
                        <label class="text-default-800 text-sm font-medium inline-block mb-2" for="example-disable">Disabled</label>
                        <input class="form-input" disabled="" id="example-disable" type="text" value="Disabled value"/>
                    </div>
                    <div>
                        <label class="text-default-800 text-sm font-medium inline-block mb-2"
                               for="example-date">Date</label>
                        <input class="form-input" id="example-date" name="date" type="date"/>
                    </div>
                    <div>
                        <label class="text-default-800 text-sm font-medium inline-block mb-2"
                               for="example-month">Month</label>
                        <input class="form-input" id="example-month" name="month" type="month"/>
                    </div>
                    <div>
                        <label class="text-default-800 text-sm font-medium inline-block mb-2"
                               for="example-time">Time</label>
                        <input class="form-input" id="example-time" name="time" type="time"/>
                    </div>
                    <div>
                        <label class="text-default-800 text-sm font-medium inline-block mb-2"
                               for="example-week">Week</label>
                        <input class="form-input" id="example-week" name="week" type="week"/>
                    </div>
                    <div>
                        <label class="text-default-800 text-sm font-medium inline-block mb-2" for="example-number">Number</label>
                        <input class="form-input" id="example-number" name="number" type="number"/>
                    </div>
                    <div>
                        <label class="text-default-800 text-sm font-medium inline-block mb-2"
                               for="example-color">Color</label>
                        <input class="form-input h-10" id="example-color" name="color" type="color" value="#1E85FF"/>
                    </div>
                    <div>
                        <label class="text-default-800 text-sm font-medium inline-block mb-2" for="example-select">Input
                            Select</label>
                        <select class="form-select" id="example-select">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-default-800 text-sm font-medium inline-block mb-2" for="example-multiselect">Multiple
                            Select</label>
                        <select class="form-input" id="example-multiselect" multiple="">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                </div>
            </div>
        </div> <!-- end card -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Input Group</h4>
            </div>
            <div class="p-6">
                <div class="grid lg:grid-cols-2 gap-6">
                    <div class="mb-5">
                        <div class="flex">
                            <div
                                class="flex items-center justify-center border border-default-200 bg-default-100 px-3 font-semibold rounded-s-md border-e-0">
                                @
                            </div>
                            <input class="form-input rounded-s-none" placeholder="Username" type="text">
                            </input></div>
                    </div>
                    <div class="mb-5">
                        <div class="flex">
                            <input class="form-input rounded-e-none" placeholder="Recipient's username" type="text">
                            <div
                                class="flex items-center justify-center border border-default-200 bg-default-100 px-3 font-semibold rounded-r-md border-s-0">
                                @example.com
                            </div>
                            </input></div>
                    </div>
                    <div class="mb-5">
                        <div class="flex">
                            <div
                                class="flex items-center justify-center border border-default-200 bg-default-100 px-3 font-semibold rounded-s-md border-e-0">
                                https://
                            </div>
                            <input class="form-input rounded-s-none" id="url" placeholder="example.com/users/"
                                   type="text">
                            </input></div>
                    </div>
                    <div class="mb-5">
                        <div class="flex">
                            <div
                                class="flex items-center justify-center border border-default-200 bg-default-100 px-3 font-semibold rounded-s-md border-e-0">
                                $
                            </div>
                            <input class="form-input rounded-none" placeholder="" type="text">
                            <div
                                class="flex items-center justify-center border border-default-200 bg-default-100 px-3 font-semibold rounded-e-md border-s-0">
                                .00
                            </div>
                            </input></div>
                    </div>
                    <div>
                        <div class="flex rounded-md -space-x-px">
                            <span
                                class="px-4 inline-flex items-center rounded-s border border-default-200 bg-default-50 text-sm text-default-500">Default</span>
                            <input class="form-input rounded-s-none" type="text"/>
                        </div>
                    </div>
                    <div>
                        <div class="sm:flex border border-default-200 rounded-md">
                            <input class="form-input border-none" type="text"/>
                            <span
                                class="py-2.5 px-4 inline-flex items-center min-w-fit w-full sm:border-x border-default-200 bg-default-50 text-sm text-default-500 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:w-auto sm:first:rounded-l-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-tr-none sm:last:rounded-bl-none sm:last:rounded-r-lg">
<i class="iconify tabler--arrows-left-right size-4 text-default-400 hidden sm:block"></i>
<i class="iconify tabler--arrows-down-up mx-auto size-4 text-default-400 sm:hidden"></i>
</span>
                            <input class="form-input border-none" type="text"/>
                        </div>
                    </div>
                    <div>
                        <label class="text-default-800 text-sm font-medium inline-block mb-2" for="simpleinput">Email
                            Address</label>
                        <div class="relative">
                            <input class="form-input ps-11" id="leading-icon" name="leading-icon"
                                   placeholder="you@site.com" type="email"/>
                            <div class="absolute inset-y-0 start-4 flex items-center z-20">
                                <i class="iconify tabler--mail text-lg text-default-400"></i>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="text-default-800 text-sm font-medium inline-block mb-2"
                               for="simpleinput">Text</label>
                        <div class="relative">
                            <input class="form-input px-8" id="input-with-leading-and-trailing-icon"
                                   name="input-with-leading-and-trailing-icon" placeholder="0.00" type="text"/>
                            <div class="absolute inset-y-0 start-4 flex items-center pointer-events-none z-20">
                                <span class="text-default-500">$</span>
                            </div>
                            <div class="absolute inset-y-0 end-4 flex items-center pointer-events-none z-20">
                                <span class="text-default-500">USD</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="text-default-800 text-sm font-medium inline-block mb-2"
                               for="simpleinput">Text</label>
                        <div class="flex rounded-md">
                            <div
                                class="px-4 inline-flex items-center min-w-fit rounded-l-md border border-e-0 border-default-200 bg-default-50">
                                <span class="text-sm text-default-500">http://</span>
                            </div>
                            <input class="form-input" id="input-with-add-on-url" name="input-with-add-on-url"
                                   placeholder="www.example.com" type="text"/>
                        </div>
                    </div>
                    <div>
                        <label class="text-default-800 text-sm font-medium inline-block mb-2"
                               for="simpleinput">Text</label>
                        <div class="flex rounded-md">
                            <div
                                class="px-4 inline-flex items-center min-w-fit rounded-l-md border border-e-0 border-default-200 bg-default-50">
                                <span class="text-sm text-default-500">$</span>
                            </div>
                            <div
                                class="px-4 inline-flex items-center min-w-fit border border-e-0 border-default-200 bg-default-50">
                                <span class="text-sm text-default-500">0.00</span>
                            </div>
                            <input class="form-input" id="leading-multiple-add-on" name="inline-add-on"
                                   placeholder="www.example.com" type="text"/>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end card -->
    </div>
@endsection

@section('scripts')

@endsection
