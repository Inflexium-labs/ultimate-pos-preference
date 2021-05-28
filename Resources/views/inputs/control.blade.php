<script type="text/javascript">
    $(document).ready(function() {
        $('#inputModule').change(function() {
            if ($(this).val() == 'none')
                return false;

            let url = "{{ route('hide-inputs.get-inputs', ':module') }}";
            url = url.replace(':module', $(this).val());

            $.get(url, function(response, status) {
                $('#input').html('<option value="none">Select</option>');
                for (let i = 0; i < response.data.length; i++) {
                    $('#input').append($('<option>', {
                        value: response.data[i],
                        text: response.data[i]
                    }));
                }
            });
        });

        $('body .list-group-item').click(function() {
            if ($('#inputTab').hasClass('active') && !$.fn.dataTable.isDataTable('#hidden_inputs')) {
                hidden_inputs = $('#hidden_inputs').DataTable({
                    processing: true,
                    serverSide: true,
                    "ajax": {
                        "url": "{{ route('hide-inputs.index') }}"
                    },
                    columns: [{
                            data: 'business'
                        },
                        {
                            data: 'module'
                        },
                        {
                            data: 'input'
                        },
                        {
                            data: function(data) {
                                return '<a class="btn btn-success" href="javascript:;" title="Unhide" onclick="showInput(' +
                                    data.id + ')"><i class="fa fa-eye"></i></a>';
                            }
                        },
                    ],
                });
            }
        })
    });

    $('#input_hide_form').submit(function(e) {
        e.preventDefault();
        let url = "{{ route('hide-inputs.store') }}";

        $.ajax({
            method: 'POST',
            url: url,
            data: $(this).serialize(),
            success: function(response) {
                toastr.success(response.msg);
                $('form#input_hide_form').trigger("reset");
                hidden_inputs.ajax.reload();
            }
        });
    })

    function showInput(id) {
        let url = "{{ route('hide-inputs.destroy', ':id') }}";
        url = url.replace(':id', id);

        $.ajax({
            method: 'DELETE',
            url: url,
            success: function(response) {
                if (response.status) {
                    toastr.success(response.msg);
                    $('form#inputs_hide_form').trigger("reset");
                    hidden_inputs.ajax.reload();
                } else {
                    toastr.error(response.msg);
                }
            }
        })
    }

</script>
