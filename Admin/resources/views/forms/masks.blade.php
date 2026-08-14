@extends('shared.vertical', ['title' => 'Input Masks'])



@section('styles')

@endsection

@section('content')
    @include('shared.partials.page-title', ['subtitle' => 'Form', 'title' => 'Input Masks'])

    <div class="card">
        <div class="p-6">
            <h4 class="card-title mb-4">Input Masks</h4>
            <p class="text-sm text-default-700 mb-4">A Java-Script Plugin to make masks on form fields and HTML
                elements.</p>
            <div class="grid 2xl:grid-cols-2 grid-cols-1 gap-6">
                <div>
                    <form action="#">
                        <div class="mb-3">
                            <label class="text-default-800 text-sm font-medium inline-block mb-2">Date</label>
                            <input class="form-input" data-mask-format="00/00/0000" data-toggle="input-mask"
                                   placeholder="DD/MM/YYYY" type="text"/>
                            <p class="text-xs mt-1">Add attribute <code class="text-primary">data-toggle="input-mask"
                                    data-mask-format="00/00/0000"</code></p>
                        </div>
                        <div class="mb-3">
                            <label class="text-default-800 text-sm font-medium inline-block mb-2">Hour</label>
                            <input class="form-input" data-mask-format="00:00:00" data-toggle="input-mask"
                                   placeholder="HH:MM:SS" type="text"/>
                            <p class="text-xs mt-1">Add attribute <code class="text-primary">data-toggle="input-mask"
                                    data-mask-format="00:00:00"</code></p>
                        </div>
                        <div class="mb-3">
                            <label class="text-default-800 text-sm font-medium inline-block mb-2">Date &amp;
                                Hour</label>
                            <input class="form-input" data-mask-format="00/00/0000 00:00:00" data-toggle="input-mask"
                                   placeholder="DD/MM/YYYY HH:MM:SS" type="text"/>
                            <p class="text-xs mt-1">Add attribute <code class="text-primary">data-toggle="input-mask"
                                    data-mask-format="00/00/0000 00:00:00"</code></p>
                        </div>
                        <div class="mb-3">
                            <label class="text-default-800 text-sm font-medium inline-block mb-2">ZIP Code</label>
                            <input class="form-input" data-mask-format="00000-000" data-toggle="input-mask"
                                   placeholder="xxxxx-xxx" type="text"/>
                            <p class="text-xs mt-1">Add attribute <code class="text-primary">data-toggle="input-mask"
                                    data-mask-format="00000-000"</code></p>
                        </div>
                        <div class="mb-3">
                            <label class="text-default-800 text-sm font-medium inline-block mb-2">Crazy Zip Code</label>
                            <input class="form-input" data-mask-format="0-00-00-00" data-toggle="input-mask"
                                   placeholder="x-xx-xx-xx" type="text"/>
                            <p class="text-xs mt-1">Add attribute <code class="text-primary">data-toggle="input-mask"
                                    data-mask-format="0-00-00-00"</code></p>
                        </div>
                        <div class="mb-3">
                            <label class="text-default-800 text-sm font-medium inline-block mb-2">Money</label>
                            <input class="form-input" data-mask-format="000.000.000.000.000,00" data-reverse="true"
                                   data-toggle="input-mask" placeholder="Your money" type="text"/>
                            <p class="text-xs mt-1">Add attribute <code class="text-primary">data-mask-format="000.000.000.000.000,00"
                                    data-reverse="true"</code></p>
                        </div>
                        <div class="mb-3">
                            <label class="text-default-800 text-sm font-medium inline-block mb-2">Money 2</label>
                            <input class="form-input" data-mask-format="#.##0,00" data-reverse="true"
                                   data-toggle="input-mask" placeholder="#.##0,00" type="text"/>
                            <p class="text-xs mt-1">Add attribute <code class="text-primary">data-toggle="input-mask"
                                    data-mask-format="#.##0,00" data-reverse="true"</code></p>
                        </div>
                    </form>
                </div>
                <div>
                    <form action="#">
                        <div class="mb-3">
                            <label class="text-default-800 text-sm font-medium inline-block mb-2">Telephone</label>
                            <input class="form-input" data-mask-format="0000-0000" data-toggle="input-mask"
                                   placeholder="xxxx-xxxx" type="text"/>
                            <p class="text-xs mt-1">Add attribute <code class="text-primary">data-toggle="input-mask"
                                    data-mask-format="0000-0000"</code></p>
                        </div>
                        <div class="mb-3">
                            <label class="text-default-800 text-sm font-medium inline-block mb-2">Telephone with Code
                                Area</label>
                            <input class="form-input" data-mask-format="(00) 0000-0000" data-toggle="input-mask"
                                   placeholder="(xx) xxxx-xxxx" type="text"/>
                            <p class="text-xs mt-1">Add attribute <code class="text-primary">data-toggle="input-mask"
                                    data-mask-format="(00) 0000-0000"</code></p>
                        </div>
                        <div class="mb-3">
                            <label class="text-default-800 text-sm font-medium inline-block mb-2">US Telephone</label>
                            <input class="form-input" data-mask-format="(000) 000-0000" data-toggle="input-mask"
                                   placeholder="(xxx) xxx-xxxx" type="text"/>
                            <p class="text-xs mt-1">Add attribute <code class="text-primary">data-toggle="input-mask"
                                    data-mask-format="(000) 000-0000"</code></p>
                        </div>
                        <div class="mb-3">
                            <label class="text-default-800 text-sm font-medium inline-block mb-2">São Paulo
                                Celphones</label>
                            <input class="form-input" data-mask-format="(00) 00000-0000" data-toggle="input-mask"
                                   placeholder="(xx) xxxxx-xxxx" type="text"/>
                            <p class="text-xs mt-1">Add attribute <code class="text-primary">data-toggle="input-mask"
                                    data-mask-format="(00) 00000-0000"</code></p>
                        </div>
                        <div class="mb-3">
                            <label class="text-default-800 text-sm font-medium inline-block mb-2">CPF</label>
                            <input class="form-input" data-mask-format="000.000.000-00" data-reverse="true"
                                   data-toggle="input-mask" placeholder="xxx.xxx.xxxx-xx" type="text"/>
                            <p class="text-xs mt-1">Add attribute <code class="text-primary">data-mask-format="000.000.000-00"
                                    data-reverse="true"</code></p>
                        </div>
                        <div class="mb-3">
                            <label class="text-default-800 text-sm font-medium inline-block mb-2">CNPJ</label>
                            <input class="form-input" data-mask-format="00.000.000/0000-00" data-reverse="true"
                                   data-toggle="input-mask" placeholder="xx.xxx.xxx/xxxx-xx" type="text"/>
                            <p class="text-xs mt-1">Add attribute <code class="text-primary">data-toggle="input-mask"
                                    data-mask-format="00.000.000/0000-00" data-reverse="true"</code></p>
                        </div>
                        <div class="mb-3">
                            <label class="text-default-800 text-sm font-medium inline-block mb-2">IP Address</label>
                            <input class="form-input" data-mask-format="099.099.099.099" data-reverse="true"
                                   data-toggle="input-mask" placeholder="xxx.xxx.xxx.xxx" type="text"/>
                            <p class="text-xs mt-1">Add attribute <code class="text-primary">data-toggle="input-mask"
                                    data-mask-format="099.099.099.099" data-reverse="true"</code></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> <!-- end card -->
@endsection

@section('scripts')
    @vite(['resources/js/pages/form-inputmask.js'])
@endsection
