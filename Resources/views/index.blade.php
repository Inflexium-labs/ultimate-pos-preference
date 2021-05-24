@extends('layouts.app')

@section('title', __('Preferences'))

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>@lang('Hide Columns')</h1>
    </section>
    <!-- Main content -->
    <section class="content no-print">

        {!! Form::open(['url' => route('preference.store'), 'method' => 'post', 'id' => 'column_hide_form']) !!}
        <div class="row">
            <div class="col-md-12 col-sm-12">
                @component('components.widget')
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="repair_status_id">{{ __('Select Business') . ':*' }}</label>
                            <select name="business" class="form-control" id="business" required>
                                <option value="none">Select</option>
                                @foreach ($businesses as $id => $business)
                                    <option value="{{ $id }}">{{ $business }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="repair_status_id">{{ __('Select Module') . ':*' }}</label>
                            <select name="module" class="form-control" id="module" required>
                                <option value="none">Select</option>
                                @foreach ($modules as $module)
                                    <option>{{ $module }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="repair_status_id">{{ __('Select Column') . ':*' }}</label>
                            <select name="column" class="form-control" id="column" required>
                                <option>Select</option>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12">
                        <button class="btn btn-primary pull-right btn-flat">@lang('Hide')</button>
                    </div>
                    {!! Form::close() !!}
                @endcomponent

                @component('components.widget')
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped ajax_view hide-footer" id="hidden_columns">
                            <thead>
                                <tr>
                                    <th>Business</th>
                                    <th>Module</th>
                                    <th>Column</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                @endcomponent
            </div>
        </div>

        {!! Form::close() !!}
    </section>
@stop

@section('javascript')
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#module').change(function() {
                if ($(this).val() == 'none')
                    return false;

                let url = "{{ route('preference.get-columns', ':module') }}";
                url = url.replace(':module', $(this).val());

                $.get(url, function(response, status) {
                    $('#column').html('<option value="none">Select</option>');
                    for (let i = 0; i < response.data.length; i++) {
                        $('#column').append($('<option>', {
                            value: response.data[i],
                            text: response.data[i]
                        }));
                    }
                });
            });


            hidden_columns = $('#hidden_columns').DataTable({
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": "{{ route('preference.index') }}"
                },
                columns: [{
                        data: 'business'
                    },
                    {
                        data: 'module'
                    },
                    {
                        data: 'column'
                    },
                    {
                        data: function(data) {
                            return '<a class="btn btn-success" href="javascript:;" title="Unhide" onclick="showColumn(' +
                                data.id + ')"><i class="fa fa-eye"></i></a>';
                        }
                    },
                ],
            });
        });

        $('#column_hide_form').submit(function(e) {
            e.preventDefault();
            let url = "{{ route('preference.store') }}";

            $.ajax({
                method: 'POST',
                url: url,
                data: $(this).serialize(),
                success: function(response) {
                    toastr.success(response.msg);
                    $('form#column_hide_form').trigger("reset");
                    hidden_columns.ajax.reload();
                }
            });
        })

        function showColumn(id) {
            let url = "{{ route('preference.destroy', ':id') }}";
            url = url.replace(':id', id);

            $.ajax({
                method: 'DELETE',
                url: url,
                success: function(response) {
                    if (response.status) {
                        toastr.success(response.msg);
                        $('form#column_hide_form').trigger("reset");
                        hidden_columns.ajax.reload();
                    } else {
                        toastr.error(response.msg);
                    }
                }
            })
        }

    </script>
@endsection
