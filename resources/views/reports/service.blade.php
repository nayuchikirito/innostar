@extends('admin.includes.app')
@section('content')
    <div class="content-wrapper">
        <!-- Main Application (Can be VueJS or other JS framework) -->
        <div class="app">
            <center>
                {!! $chart->html() !!}
            </center>
        </div>
        <form action="{{ url('/admin/report/printpdf') }}" method="GET">
        <div class="text-center">

        <button type="submit" class="btn submit-btn btn-success btn-gradient">Print</button>

    </div>
</form>
    </div>
        <!-- End Of Main Application -->
        {!! Charts::scripts() !!}
        {!! $chart->script() !!}
@endsection

@section('scripts')
