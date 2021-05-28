<div class="pos-tab-content active">
    {!! Form::open(['url' => route('hide-columns.store'), 'method' => 'post', 'id' => 'column_hide_form']) !!}
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