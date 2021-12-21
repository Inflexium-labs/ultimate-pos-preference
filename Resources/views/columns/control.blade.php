<script type="text/javascript">
    $(document).ready(function() {
        $('#module').change(function() {
            if ($(this).val() == 'none')
                return false;

            let url = "{{ route('hide-columns.get-columns', ':module') }}";
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
                "url": "{{ route('hide-columns.index') }}"
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
        let url = "{{ route('hide-columns.store') }}";

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
        let url = "{{ route('hide-columns.destroy', ':id') }}";
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