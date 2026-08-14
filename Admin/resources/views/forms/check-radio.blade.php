@extends('shared.vertical', ['title' => 'Dashboard'])



@section('styles')

@endsection

@section('content')
    @include('shared.partials.page-title', ['subtitle' => 'Forms', 'title' => 'Input'])

    <div class="grid lg:grid-cols-2 gap-6">
        <div class="card">
            <div class="card-header">
                <div class="flex justify-between items-center">
                    <h4 class="card-title">Checkbox</h4>
                </div>
            </div>
            <div class="p-6">
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <h6 class="text-sm mb-2">Default</h6>
                        <div class="flex flex-col gap-2">
                            <div class="form-check">
                                <input class="form-checkbox rounded text-primary" id="customCheck1" type="checkbox"/>
                                <label class="ms-1.5" for="customCheck1">Check this checkbox</label>
                            </div>
                            <div class="form-check">
                                <input class="form-checkbox rounded text-primary" id="customCheck2" type="checkbox"/>
                                <label class="ms-1.5" for="customCheck2">Check this checkbox</label>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h6 class="text-sm mb-2">Disabled</h6>
                        <div class="flex flex-col gap-2">
                            <div class="opacity-75">
                                <input checked="" class="form-checkbox rounded text-primary" disabled=""
                                       id="customCheck5" type="checkbox"/>
                                <label class="ms-1.5" for="customCheck5">Check this checkbox</label>
                            </div>
                            <div class="opacity-75">
                                <input class="form-checkbox rounded text-primary" disabled="" id="customCheck6"
                                       type="checkbox"/>
                                <label class="ms-1.5" for="customCheck6">Check this checkbox</label>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <div>
                            <input checked="" class="form-checkbox rounded text-primary" id="customckeck1"
                                   type="checkbox"/>
                            <label class="ms-1.5" for="customckeck1">Primary</label>
                        </div>
                        <div>
                            <input checked="" class="form-checkbox rounded text-success" id="customckeck2"
                                   type="checkbox"/>
                            <label class="ms-1.5" for="customckeck2">Success</label>
                        </div>
                        <div>
                            <input checked="" class="form-checkbox rounded text-danger" id="customckeck3"
                                   type="checkbox"/>
                            <label class="ms-1.5" for="customckeck3">Danger</label>
                        </div>
                        <div>
                            <input checked="" class="form-checkbox rounded text-warning" id="customckeck4"
                                   type="checkbox"/>
                            <label class="ms-1.5" for="customckeck4">Warning</label>
                        </div>
                        <div>
                            <input checked="" class="form-checkbox rounded text-pink-500" id="checkBox5"
                                   type="checkbox"/>
                            <label class="ms-1.5" for="checkBox5">Pink</label>
                        </div>
                        <div>
                            <input checked="" class="form-checkbox rounded text-blue" id="checkBox7" type="checkbox"/>
                            <label class="ms-1.5" for="checkBox7">Blue</label>
                        </div>
                        <div>
                            <input checked="" class="form-checkbox rounded text-info" id="checkBox8" type="checkbox"/>
                            <label class="ms-1.5" for="checkBox8">Info</label>
                        </div>
                        <div>
                            <input checked="" class="form-checkbox rounded text-dark" id="checkBox9" type="checkbox"/>
                            <label class="ms-1.5" for="checkBox9">Dark</label>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <div>
                            <input checked="" class="form-checkbox rounded-full text-primary" id="checkBox10"
                                   type="checkbox"/>
                            <label class="ms-1.5" for="checkBox10">Primary</label>
                        </div>
                        <div>
                            <input checked="" class="form-checkbox rounded-full text-success" id="checkBox11"
                                   type="checkbox"/>
                            <label class="ms-1.5" for="checkBox11">Success</label>
                        </div>
                        <div>
                            <input checked="" class="form-checkbox rounded-full text-danger" id="checkBox12"
                                   type="checkbox"/>
                            <label class="ms-1.5" for="checkBox12">Danger</label>
                        </div>
                        <div>
                            <input checked="" class="form-checkbox rounded-full text-warning" id="checkBox13"
                                   type="checkbox"/>
                            <label class="ms-1.5" for="checkBox13">Warning</label>
                        </div>
                        <div>
                            <input checked="" class="form-checkbox rounded-full text-pink-500" id="customckec14"
                                   type="checkbox"/>
                            <label class="ms-1.5" for="customckec14">Pink</label>
                        </div>
                        <div>
                            <input checked="" class="form-checkbox rounded-full text-blue" id="checkBox15"
                                   type="checkbox"/>
                            <label class="ms-1.5" for="checkBox15">Blue</label>
                        </div>
                        <div>
                            <input checked="" class="form-checkbox rounded-full text-info" id="checkBox16"
                                   type="checkbox"/>
                            <label class="ms-1.5" for="checkBox16">Info</label>
                        </div>
                        <div>
                            <input checked="" class="form-checkbox rounded-full text-dark" id="checkBox17"
                                   type="checkbox"/>
                            <label class="ms-1.5" for="checkBox17">Dark</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="flex justify-between items-center">
                    <h4 class="card-title">Radio Button</h4>
                </div>
            </div>
            <div class="p-6">
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <h6 class="text-sm mb-2">Default</h6>
                        <div class="flex flex-col gap-2">
                            <div class="form-check">
                                <input checked="" class="form-radio text-primary" id="formRadio01" name="formRadio"
                                       type="radio"/>
                                <label class="ms-1.5" for="formRadio01">Check this radio</label>
                            </div>
                            <div class="form-check">
                                <input class="form-radio text-primary" id="formRadio02" name="formRadio" type="radio"/>
                                <label class="ms-1.5" for="formRadio02">Check this radio</label>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h6 class="text-sm mb-2">Disabled</h6>
                        <div class="flex flex-col gap-2">
                            <div class="opacity-75">
                                <input checked="" class="form-radio text-primary" disabled="" id="formRadio04"
                                       type="radio"/>
                                <label class="ms-1.5" for="formRadio04">Check this radio</label>
                            </div>
                            <div class="opacity-75">
                                <input class="form-radio text-primary" disabled="" id="formRadio05" type="radio"/>
                                <label class="ms-1.5" for="formRadio05">Check this radio</label>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <div>
                            <input checked="" class="form-radio text-primary" id="formRadio10" type="radio"/>
                            <label class="ms-1.5" for="formRadio10">Primary</label>
                        </div>
                        <div>
                            <input checked="" class="form-radio text-success" id="formRadio11" type="radio"/>
                            <label class="ms-1.5" for="formRadio11">Success</label>
                        </div>
                        <div>
                            <input checked="" class="form-radio text-danger" id="formRadio12" type="radio"/>
                            <label class="ms-1.5" for="formRadio12">Danger</label>
                        </div>
                        <div>
                            <input checked="" class="form-radio text-warning" id="formRadio13" type="radio"/>
                            <label class="ms-1.5" for="formRadio13">Warning</label>
                        </div>
                        <div>
                            <input checked="" class="form-radio text-pink-500" id="formRadio14" type="radio"/>
                            <label class="ms-1.5" for="formRadio14">Pink</label>
                        </div>
                        <div>
                            <input checked="" class="form-radio text-blue" id="formRadio15" type="radio"/>
                            <label class="ms-1.5" for="formRadio15">Blue</label>
                        </div>
                        <div>
                            <input checked="" class="form-radio text-info" id="formRadio16" type="radio"/>
                            <label class="ms-1.5" for="formRadio16">Info</label>
                        </div>
                        <div>
                            <input checked="" class="form-radio text-dark" id="formRadio17" type="radio"/>
                            <label class="ms-1.5" for="formRadio17">Dark</label>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <div>
                            <input checked="" class="form-radio rounded text-primary" id="formRadio1" type="radio"/>
                            <label class="ms-1.5" for="formRadio1">Primary</label>
                        </div>
                        <div>
                            <input checked="" class="form-radio rounded text-success" id="formRadio2" type="radio"/>
                            <label class="ms-1.5" for="formRadio2">Success</label>
                        </div>
                        <div>
                            <input checked="" class="form-radio rounded text-danger" id="formRadio3" type="radio"/>
                            <label class="ms-1.5" for="formRadio3">Danger</label>
                        </div>
                        <div>
                            <input checked="" class="form-radio rounded text-warning" id="formRadio4" type="radio"/>
                            <label class="ms-1.5" for="formRadio4">Warning</label>
                        </div>
                        <div>
                            <input checked="" class="form-radio rounded text-pink-500" id="formRadio5" type="radio"/>
                            <label class="ms-1.5" for="formRadio5">Pink</label>
                        </div>
                        <div>
                            <input checked="" class="form-radio rounded text-blue" id="formRadio7" type="radio"/>
                            <label class="ms-1.5" for="formRadio7">Blue</label>
                        </div>
                        <div>
                            <input checked="" class="form-radio rounded text-info" id="formRadio8" type="radio"/>
                            <label class="ms-1.5" for="formRadio8">Info</label>
                        </div>
                        <div>
                            <input checked="" class="form-radio rounded text-dark" id="formRadio9" type="radio"/>
                            <label class="ms-1.5" for="formRadio9">Dark</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="flex justify-between items-center">
                    <h4 class="card-title">Switch</h4>
                </div>
            </div>
            <div class="p-6">
                <div class="grid xl:grid-cols-2 gap-6">
                    <div class="flex flex-col gap-3">
                        <h6 class="text-sm mb-2">Default</h6>
                        <div class="flex items-center">
                            <input class="form-switch" id="flexSwitchCheckDefault" role="switch" type="checkbox"/>
                            <label class="ms-1.5" for="flexSwitchCheckDefault">Default switch
                                checkbox</label>
                        </div>
                        <div class="flex items-center">
                            <input checked="" class="form-switch" id="flexSwitchCheckChecked" role="switch"
                                   type="checkbox"/>
                            <label class="ms-1.5" for="flexSwitchCheckChecked">Checked switch
                                checkbox</label>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <h6 class="text-sm mb-2">Disabled</h6>
                        <div class="flex items-center opacity-60">
                            <input class="form-switch" disabled="" id="flexSwitchCheckDisabled" role="switch"
                                   type="checkbox"/>
                            <label class="ms-1.5" for="flexSwitchCheckDisabled">Disabled Switch</label>
                        </div>
                        <div class="flex items-center opacity-60">
                            <input checked="" class="form-switch" disabled="" id="flexSwitchCheckCheckedDisabled"
                                   role="switch" type="checkbox"/>
                            <label class="ms-1.5" for="flexSwitchCheckCheckedDisabled">Disabled checked
                                Switch</label>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <h6 class="text-sm mb-2">Colored</h6>
                        <div class="flex items-center">
                            <input checked="" class="form-switch text-primary" id="formSwitch" type="checkbox"/>
                            <label class="ms-1.5" for="formSwitch">Primary</label>
                        </div>
                        <div class="flex items-center">
                            <input checked="" class="form-switch text-warning" id="formSwitch2" type="checkbox"/>
                            <label class="ms-1.5" for="formSwitch2">Warning</label>
                        </div>
                        <div class="flex items-center">
                            <input checked="" class="form-switch text-danger" id="formSwitch3" type="checkbox"/>
                            <label class="ms-1.5" for="formSwitch3">Danger</label>
                        </div>
                        <div class="flex items-center">
                            <input checked="" class="form-switch text-success" id="formSwitch4" type="checkbox"/>
                            <label class="ms-1.5" for="formSwitch4">Success</label>
                        </div>
                        <div class="flex items-center">
                            <input checked="" class="form-switch text-secondary" id="formSwitch5" type="checkbox"/>
                            <label class="ms-1.5" for="formSwitch5">Secondary</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
