{{-- <div> --}}
@push('heads')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css" /> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css" />
@endpush

<div class="modal fade" id="{{ $id }}" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="{{ $id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $id }}Label">{{ $modalTitle }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered master_data_datatable w-100">
                        <thead class="bg-primary">
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Description</th>
                                <th width="120px" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            {{-- <div class="modal-footer"> --}}
            {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Understood</button> --}}
            {{-- </div> --}}
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.12.1/dataRender/datetime.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.12/sorting/datetime-moment.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="/vendor/datatables/buttons.server-side.js"></script>
    <script type="text/javascript">
        var path = {!! $path !!};
        var id = {!! json_encode($id) !!};
        var inputId = {!! $inputId !!};
        // console.log("path ==> " + path)
        // console.log("id ==> " + id)
        // console.log("inputId ==> " + inputId)
        $(function() {
            $.fn.dataTable.render.moment = function(from, to, locale) {
                // Argument shifting
                if (arguments.length === 1) {
                    locale = 'en';
                    to = from;
                    from = 'YYYY-MM-DD';
                } else if (arguments.length === 2) {
                    locale = 'en';
                }

                return function(d, type, row) {
                    if (!d) {
                        return type === 'sort' || type === 'type' ? 0 : d;
                    }

                    var m = window.moment(d, from, locale, true);

                    // Order and type get a number value from Moment, everything else
                    // sees the rendered value
                    return m.format(type === 'sort' || type === 'type' ? 'x' : to);
                };
            };

            var table = $('.master_data_datatable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: path,
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'no'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    // {
                    //     data: 'created_at',
                    //     name: 'created_at',
                    //     render: function(data) {
                    //         return moment(data, 'YYYY-MM-DD HH:mm:ss').format(
                    //             'MM/DD/YYYY')
                    //     }
                    // },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
                "columnDefs": [{
                        "width": "5%",
                        "searchable": false,
                        "orderable": false,
                        "targets": 0,
                        "className": "dt-center",
                    }, {
                        "searchable": true,
                        "orderable": true,
                        "targets": 1,
                    }, {
                        "targets": 3,
                        "className": "dt-center",
                    },
                    {
                        "className": "dt-center",
                        "targets": "_all"
                    },
                ],
                /// sort at column three
                "order": [
                    [1, 'asc']
                ],
            });
        });

        function selectData(dataId, name) {
            $('#' + id + '').modal('hide')

            $('#' + inputId + '').val(dataId)
            $('#' + inputId + '_label').val(name)
        }
    </script>
@endpush

{{-- </div> --}}
