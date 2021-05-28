@extends('layouts.app')

@section('title', __('Preferences'))

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>@lang('Preferences')</h1>
    </section>
    <!-- Main content -->

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <!--  <pos-tab-container> -->
                <div class="col-xs-12 pos-tab-container">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 pos-tab-menu">
                        <div class="list-group">
                            <a href="#" class="list-group-item text-center active">@lang('Hide Columns')</a>
                            <a href="#" class="list-group-item text-center">@lang('Hide Inputs')</a>
                        </div>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 pos-tab">
                        @include('preference::columns.list')
                        @include('preference::inputs.list')
                    </div>
                </div>
            </div>
    </section>
@stop

@section('javascript')
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    @include('preference::columns.control')
    @include('preference::inputs.control')
@endsection
