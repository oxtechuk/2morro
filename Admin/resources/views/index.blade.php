@extends('shared.vertical', ['title' => 'Dashboard'])

@section('styles')

@endsection

@section('content')
    @include('shared.partials.page-title', ['subtitle' => 'Menu', 'title' => 'Dashboard'])

    <div class="grid xl:grid-cols-4 md:grid-cols-2 gap-6 mb-6">
        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body">
                <div class="flex items- justify-between">
                    <div>
                        <p class="text-xs tracking-wide font-semibold uppercase text-default-700 mb-3">Cost
                            per Unit</p>
                        <h4 class="font-semibold text-2xl text-default-700">$85.50</h4>
                    </div>
                    <div class="rounded-full flex justify-center items-center size-14 bg-primary/10 text-primary">
                        <i class="material-symbols-rounded text-2xl transition-all group-hover:fill-1">shopping_bag</i>
                    </div>
                </div>
            </div>
            <div id="total-order"></div>
        </div>
        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body">
                <div class="flex items- justify-between">
                    <div>
                        <p class="text-xs tracking-wide font-semibold uppercase text-default-700 mb-3">
                            Market Revenue</p>
                        <h4 class="font-semibold text-2xl text-default-700">$12,548.25</h4>
                    </div>
                    <div class="rounded-full flex justify-center items-center size-14 bg-secondary/10 text-secondary">
                        <i class="material-symbols-rounded text-2xl transition-all group-hover:fill-1">payments</i>
                    </div>
                </div>
            </div>
            <div id="total-sale"></div>
        </div>
        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body">
                <div class="flex items- justify-between">
                    <div>
                        <p class="text-xs tracking-wide font-semibold uppercase text-default-700 mb-3">
                            Expenses</p>
                        <h4 class="font-semibold text-2xl text-default-700">$8,451.28</h4>
                    </div>
                    <div class="rounded-full flex justify-center items-center size-14 bg-warning/10 text-warning">
                        <i class="material-symbols-rounded text-2xl transition-all group-hover:fill-1">visibility</i>
                    </div>
                </div>
            </div>
            <div id="total-visits"></div>
        </div>
        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body">
                <div class="flex items- justify-between">
                    <div>
                        <p class="text-xs tracking-wide font-semibold uppercase text-default-700 mb-3">Daily
                            Visit</p>
                        <h4 class="font-semibold text-2xl text-default-700">1,12,584</h4>
                    </div>
                    <div class="rounded-full flex justify-center items-center size-14 bg-danger/10 text-danger">
                        <i class="material-symbols-rounded text-2xl transition-all group-hover:fill-1">account_balance</i>
                    </div>
                </div>
            </div>
            <div id="chart4"></div>
        </div>
    </div>
    <div class="grid xl:grid-cols-3 md:grid-cols-2 gap-6 mb-6">
        <div class="xl:col-span-2">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Total Revenue</h4>
                    <div class="morris-chart" id="morris-line-example"></div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Activity By Teams</h4>
                <div class="morris-chart" id="morris-donut-example"></div>
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div>
    <div class="grid xl:grid-cols-2 gap-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Recent Customers</h4>
            </div>
            <div class="overflow-x-auto">
                <table class="table-auto w-full border-collapse">
                    <thead class="bg-default-100 border-b border-default-200">
                    <tr>
                        <th class="px-4 py-2 text-left">Customer</th>
                        <th class="px-4 py-2 text-left">Phone</th>
                        <th class="px-4 py-2 text-left">Email</th>
                        <th class="px-4 py-2 text-left">Location</th>
                        <th class="px-4 py-2 text-left">Create Date</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-default-200">
                    <tr class="hover:bg-default-50">
                        <td class="px-4 py-2 flex items-center gap-2">
                            <img alt="table-user" class="size-9 rounded-full"
                                 src="{{ asset('images/users/avatar-4.jpg') }}"/>
                            <a class="font-semibold text-default-800" href="javascript:void(0);">Paul
                                J. Friend</a>
                        </td>
                        <td class="px-4 py-2">937-330-1634</td>
                        <td class="px-4 py-2">pauljfrnd@jourrapide.com</td>
                        <td class="px-4 py-2">New York</td>
                        <td class="px-4 py-2">07/07/2024</td>
                    </tr>
                    <tr class="hover:bg-default-50">
                        <td class="px-4 py-2 flex items-center gap-2">
                            <img alt="table-user" class="size-9 rounded-full"
                                 src="{{ asset('images/users/avatar-3.jpg') }}"/>
                            <a class="font-semibold text-default-800" href="javascript:void(0);">Bryan
                                J. Luellen</a>
                        </td>
                        <td class="px-4 py-2">215-302-3376</td>
                        <td class="px-4 py-2">bryuellen@dayrep.com</td>
                        <td class="px-4 py-2">New York</td>
                        <td class="px-4 py-2">09/12/2024</td>
                    </tr>
                    <tr class="hover:bg-default-50">
                        <td class="px-4 py-2 flex items-center gap-2">
                            <img alt="table-user" class="size-9 rounded-full"
                                 src="{{ asset('images/users/avatar-8.jpg') }}"/>
                            <a class="font-semibold text-default-800" href="javascript:void(0);">Kathryn
                                S. Collier</a>
                        </td>
                        <td class="px-4 py-2">828-216-2190</td>
                        <td class="px-4 py-2">collier@jourrapide.com</td>
                        <td class="px-4 py-2">Canada</td>
                        <td class="px-4 py-2">06/30/2024</td>
                    </tr>
                    <tr class="hover:bg-default-50">
                        <td class="px-4 py-2 flex items-center gap-2">
                            <img alt="table-user" class="size-9 rounded-full"
                                 src="{{ asset('images/users/avatar-1.jpg') }}"/>
                            <a class="font-semibold text-default-800" href="javascript:void(0);">Timothy
                                Kauper</a>
                        </td>
                        <td class="px-4 py-2">(216) 75 612 706</td>
                        <td class="px-4 py-2">thykauper@rhyta.com</td>
                        <td class="px-4 py-2">Denmark</td>
                        <td class="px-4 py-2">09/08/2024</td>
                    </tr>
                    <tr class="hover:bg-default-50">
                        <td class="px-4 py-2 flex items-center gap-2">
                            <img alt="table-user" class="size-9 rounded-full"
                                 src="{{ asset('images/users/avatar-5.jpg') }}"/>
                            <a class="font-semibold text-default-800" href="javascript:void(0);">Zara
                                Raws</a>
                        </td>
                        <td class="px-4 py-2">(02) 75 150 655</td>
                        <td class="px-4 py-2">austin@dayrep.com</td>
                        <td class="px-4 py-2">Germany</td>
                        <td class="px-4 py-2">07/15/2024</td>
                    </tr>
                    <tr class="hover:bg-default-50">
                        <td class="px-4 py-2 flex items-center gap-2">
                            <img alt="table-user" class="size-9 rounded-full"
                                 src="{{ asset('images/users/avatar-6.jpg') }}"/>
                            <a class="font-semibold text-default-800" href="javascript:void(0);">Mike
                                John</a>
                        </td>
                        <td class="px-4 py-2">798-4651-455</td>
                        <td class="px-4 py-2">mikejohn@jourrapide.com</td>
                        <td class="px-4 py-2">New York</td>
                        <td class="px-4 py-2">08/07/2024</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div> <!-- end card-->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Account Transactions</h4>
            </div>
            <div class="overflow-x-auto">
                <table class="table-auto w-full text-left border-collapse">
                    <thead class="bg-default-100 border-b border-default-200">
                    <tr>
                        <th class="px-4 py-2">Card Number</th>
                        <th class="px-4 py-2">Amount</th>
                        <th class="px-4 py-2">Card Type</th>
                        <th class="px-4 py-2">User Name</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-default-200">
                    <tr class="hover:bg-default-50">
                        <td class="px-4 py-2">
                            <h5 class="text-base font-normal">4257 **** **** 7852</h5>
                            <span class="text-sm text-default-600">11 April 2019</span>
                        </td>
                        <td class="px-4 py-2">
                            <h5 class="text-base font-normal">$79.49</h5>
                            <span class="text-sm text-default-600">Amount</span>
                        </td>
                        <td class="px-4 py-2">
                            <h5 class="text-lg font-normal"><i class="fab fa-cc-visa"></i></h5>
                            <span class="text-sm text-default-600">Card</span>
                        </td>
                        <td class="px-4 py-2">
                            <h5 class="text-base font-normal">Helen Warren</h5>
                            <span class="text-sm text-default-600">Pay</span>
                        </td>
                    </tr>
                    <tr class="hover:bg-default-50">
                        <td class="px-4 py-2">
                            <h5 class="text-base font-normal">4265 **** **** 0025</h5>
                            <span class="text-sm text-default-600">28 Jan 2019</span>
                        </td>
                        <td class="px-4 py-2">
                            <h5 class="text-base font-normal">$1254.00</h5>
                            <span class="text-sm text-default-600">Amount</span>
                        </td>
                        <td class="px-4 py-2">
                            <h5 class="text-lg font-normal"><i class="fab fa-cc-stripe"></i></h5>
                            <span class="text-sm text-default-600">Card</span>
                        </td>
                        <td class="px-4 py-2">
                            <h5 class="text-base font-normal">Kayla Lambie</h5>
                            <span class="text-sm text-default-600">Pay</span>
                        </td>
                    </tr>
                    <tr class="hover:bg-default-50">
                        <td class="px-4 py-2">
                            <h5 class="text-base font-normal">5570 **** **** 8547</h5>
                            <span class="text-sm text-default-600">08 Dec 2024</span>
                        </td>
                        <td class="px-4 py-2">
                            <h5 class="text-base font-normal">$784.25</h5>
                            <span class="text-sm text-default-600">Amount</span>
                        </td>
                        <td class="px-4 py-2">
                            <h5 class="text-lg font-normal"><i class="fab fa-cc-amazon-pay"></i>
                            </h5>
                            <span class="text-sm text-default-600">Card</span>
                        </td>
                        <td class="px-4 py-2">
                            <h5 class="text-base font-normal">Hugo Lavarack</h5>
                            <span class="text-sm text-default-600">Pay</span>
                        </td>
                    </tr>
                    <tr class="hover:bg-default-50">
                        <td class="px-4 py-2">
                            <h5 class="text-base font-normal">7845 **** **** 5214</h5>
                            <span class="text-sm text-default-600">03 Dec 2024</span>
                        </td>
                        <td class="px-4 py-2">
                            <h5 class="text-base font-normal">$485.24</h5>
                            <span class="text-sm text-default-600">Amount</span>
                        </td>
                        <td class="px-4 py-2">
                            <h5 class="text-lg font-normal"><i class="fab fa-cc-visa"></i></h5>
                            <span class="text-sm text-default-600">Card</span>
                        </td>
                        <td class="px-4 py-2">
                            <h5 class="text-base font-normal">Amber Scurry</h5>
                            <span class="text-sm text-default-600">Pay</span>
                        </td>
                    </tr>
                    <tr class="hover:bg-default-50">
                        <td class="px-4 py-2">
                            <h5 class="text-base font-normal">4257 **** **** 7852</h5>
                            <span class="text-sm text-default-600">12 Nov 2024</span>
                        </td>
                        <td class="px-4 py-2">
                            <h5 class="text-base font-normal">$8964.04</h5>
                            <span class="text-sm text-default-600">Amount</span>
                        </td>
                        <td class="px-4 py-2">
                            <h5 class="text-lg font-normal"><i class="fab fa-cc-visa"></i></h5>
                            <span class="text-sm text-default-600">Card</span>
                        </td>
                        <td class="px-4 py-2">
                            <h5 class="text-base font-normal">Caitlyn Gibney</h5>
                            <span class="text-sm text-default-600">Pay</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @vite(['resources/js/pages/dashboard.js'])
@endsection
