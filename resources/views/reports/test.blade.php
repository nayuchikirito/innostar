@extends('admin.includes.app')
@section('content')
    <div class="content-wrapper">
        <!-- Main Application (Can be VueJS or other JS framework) -->
        <div class="app">
            <center>
                {!! $chart->html() !!}
            </center>
        </div>
    </div>
        <!-- End Of Main Application -->
        {!! Charts::scripts() !!}
        {!! $chart->script() !!}
@endsection