@extends('shared.vertical', ['title' => 'Validation'])



@section('styles')

@endsection

@section('content')
    @include('shared.partials.page-title', ['subtitle' => 'Forms', 'title' => 'Validation'])

    <div class="flex flex-col gap-6">
        <div class="card">
            <div class="p-6">
                <h4 class="card-title mb-4">Browser defaults</h4>
                <form class="grid lg:grid-cols-3 gap-6">
                    <div>
                        <label class="text-default-800 text-sm font-medium inline-block mb-2" for="validationDefault01">First
                            name</label>
                        <input class="form-input" id="validationDefault01" required="" type="text" value="Mark"/>
                    </div>
                    <div>
                        <label class="text-default-800 text-sm font-medium inline-block mb-2" for="validationDefault02">Last
                            name</label>
                        <input class="form-input" id="validationDefault02" required="" type="text" value="Otto"/>
                    </div>
                    <div>
                        <label class="text-default-800 text-sm font-medium inline-block mb-2"
                               for="validationDefaultUsername">Username</label>
                        <div class="flex items-center">
                            <span class="py-2 px-3 bg-light rounded-l" id="inputGroupPrepend2">@</span>
                            <input aria-describedby="inputGroupPrepend2" class="form-input rounded-l-none"
                                   id="validationDefaultUsername" required="" type="text"/>
                        </div>
                    </div>
                    <div>
                        <label class="text-default-800 text-sm font-medium inline-block mb-2" for="validationDefault03">City</label>
                        <input class="form-input" id="validationDefault03" required="" type="text"/>
                    </div>
                    <div>
                        <label class="text-default-800 text-sm font-medium inline-block mb-2" for="validationDefault04">State</label>
                        <select class="form-select" id="validationDefault04" required="">
                            <option disabled="" selected="" value="">Choose...</option>
                            <option>...</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-default-800 text-sm font-medium inline-block mb-2" for="validationDefault05">Zip</label>
                        <input class="form-input" id="validationDefault05" required="" type="text"/>
                    </div>
                    <div class="col-span-3">
                        <div class="form-check">
                            <input class="form-checkbox rounded" id="invalidCheck2" required="" type="checkbox"
                                   value=""/>
                            <label class="ms-1.5" for="invalidCheck2">
                                Agree to terms and conditions
                            </label>
                        </div>
                    </div>
                    <div class="col-span-3">
                        <button class="btn bg-primary text-white" type="submit">Submit form</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
