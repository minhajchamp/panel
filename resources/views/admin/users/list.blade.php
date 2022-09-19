@extends('layouts.adminapp')
@extends('layouts.nav')
@extends('layouts.sidebar')

@section('head_includes')
<style>

</style>
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">List /</span> {{ ucwords(Request::segment(2)) }}</h4>
    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="row">
            <div class="col-sm-10">
                <h5 class="card-header">All users</h5>
            </div>
            <div class="col-md-2 mt-3">
                <button type="button" name="bulk_delete" id="bulk_delete" class="btn btn-outline-danger account-image-reset mb-4">
                    <i class="bx bx-reset d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Mass Delete</span>
                </button>
            </div>
        </div>
        <div class="table-responsive text-nowrap p-4">
            <table class="table card-table" id="dataTable">
                <thead>
                    <tr>
                        <th width="5px"></th>
                        <th>User Name</th>
                        <th>User Email</th>
                        <th>User Picture</th>
                        <th>Verify Status</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                </tbody>
            </table>
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->
</div>
@endsection
@section('page_js')
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"> -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

<!-- <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> -->

<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

<script type="text/javascript">
    $(function() {

        var table = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ url('admin/users') }}",
            },
            columns: [{
                    data: "checkbox",
                    name: 'checkbox'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'user_picture',
                    name: 'user_picture'
                },
                {
                    data: 'user_verified',
                    name: 'user_verified'
                },
                {
                    data: 'user_status',
                    name: 'user_status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            dom: 'Bfrtip',
            buttons: [
                'excel', 'pdf', 'print'
            ]
        });

    });

    $(document).on('click', '.delete', function() {
        var id = $(this).attr('id');
        if (confirm("Are you sure you want to Delete this data?")) {
            $.ajax({
                url: "#",
                mehtod: "get",
                data: {
                    id: id
                },
                success: function(data) {
                    $('#dataTable').DataTable().ajax.reload();
                }
            })
        } else {
            return false;
        }
    });

    $(document).on('click', '#bulk_delete', function() {
        var id = [];
        if (confirm("Are you sure you want to Delete this data?")) {
            $('.users_checkbox:checked').each(function() {
                id.push($(this).val());
            });
            if (id.length > 0) {
                $.ajax({
                    url: "{{ url('admin/users/mass_destroy') }}",
                    method: "get",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        alert("Deleted");
                        $('#dataTable').DataTable().ajax.reload();
                    }
                });
            } else {
                alert("Please select atleast one checkbox");
            }
        }
    });
</script>
@endsection