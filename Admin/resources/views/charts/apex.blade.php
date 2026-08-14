@extends('shared.vertical', ['title' => 'Dashboard'])



@section('styles')

@endsection

@section('content')
    @include('shared.partials.page-title', ['subtitle' => 'Documentation', 'title' => 'Changelog'])

    <div class="grid lg:grid-cols-2 gap-6">
        <div class="card">
            <div class="p-6">
                <h4 class="card-title mb-4">Line with Data Labels</h4>
                <div class="apex-charts" dir="ltr" id="line_chart_datalabel"></div>
            </div>
        </div><!--end card-->
        <div class="card">
            <div class="p-6">
                <h4 class="card-title mb-4">Dashed Line</h4>
                <div class="apex-charts" dir="ltr" id="line_chart_dashed"></div>
            </div>
        </div><!--end card-->
        <div class="card">
            <div class="p-6">
                <h4 class="card-title mb-4">Spline Area</h4>
                <div class="apex-charts" dir="ltr" id="spline_area"></div>
            </div>
        </div><!--end card-->
        <div class="card">
            <div class="p-6">
                <h4 class="card-title mb-4">Column Chart</h4>
                <div class="apex-charts" dir="ltr" id="column_chart"></div>
            </div>
        </div><!--end card-->
        <div class="card">
            <div class="p-6">
                <h4 class="card-title mb-4">Column with Data Labels</h4>
                <div class="apex-charts" dir="ltr" id="column_chart_datalabel"></div>
            </div>
        </div><!--end card-->
        <div class="card">
            <div class="p-6">
                <h4 class="card-title mb-4">Bar Chart</h4>
                <div class="apex-charts" dir="ltr" id="bar_chart"></div>
            </div>
        </div><!--end card-->
        <div class="card">
            <div class="p-6">
                <h4 class="card-title mb-4">Line, Column &amp; Area Chart</h4>
                <div class="apex-charts" dir="ltr" id="mixed_chart"></div>
            </div>
        </div><!--end card-->
        <div class="card">
            <div class="p-6">
                <h4 class="card-title mb-4">Radial Chart</h4>
                <div class="apex-charts" dir="ltr" id="radial_chart"></div>
            </div>
        </div><!--end card-->
        <div class="card">
            <div class="p-6">
                <h4 class="card-title mb-4">Pie Chart</h4>
                <div class="apex-charts" dir="ltr" id="pie_chart"></div>
            </div>
        </div>
        <div class="card">
            <div class="p-6">
                <h4 class="card-title mb-4">Donut Chart</h4>
                <div class="apex-charts" dir="ltr" id="donut_chart"></div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @vite(['resources/js/pages/charts-apex.js'])
@endsection
