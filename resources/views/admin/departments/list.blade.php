@extends('layouts.adminapp')
@extends('layouts.nav')
@extends('layouts.sidebar')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">List /</span> {{ ucwords(Request::segment(2)) }}</h4>
    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="row">
            <div class="col-md-8">
                <h5 class="card-header">All {{ ucwords(Request::segment(2)) }}</h5>
            </div>
            <div class="col-md-2 mt-4">
                <button type="button" class="btn btn-outline-primary account-image-reset mb-4" data-bs-toggle="modal" data-bs-target="#modalCenter">
                    Create Department
                </button>
            </div>
            <div class="col-md-2 mt-4">
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
                        <th>Department Name</th>
                        <th>Department Logo</th>
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
<div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">{{ ucwords(Request::segment(2)) }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('departments.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Department Name *</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="basic-default-name" placeholder="John Doe" name="department_name" value="{{ request()->old('department_name') }}" required="required"/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-email">Department Logo *</label>
                        <div class="col-sm-10">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img src="{{ url('assets/img/avatars/1.png') }}" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                                <div class="button-wrapper">
                                    <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                        <span class="d-none d-sm-block">Upload new photo</span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                        <input type="file" id="upload" class="account-file-input" name="department_picture" hidden accept="image/png, image/jpeg" required="required"/>
                                    </label>
                                    <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                        <i class="bx bx-reset d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Reset</span>
                                    </button>
                                    <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-message">Department Description</label>
                        <div class="col-sm-10">
                            <textarea id="basic-default-message" name="department_description" class="form-control" placeholder="Hi, Do you have a moment to talk Joe?" aria-label="Hi, Do you have a moment to talk Joe?" aria-describedby="basic-icon-default-message2">
                            {{ request()->old('department_description') }}
                            </textarea>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Go!</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Close
                </button> -->
            </div>
        </div>
    </div>
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
                url: "{{ url('admin/departments') }}",
            },
            columns: [{
                    data: "checkbox",
                    name: 'checkbox'
                },
                {
                    data: 'department_name',
                    name: 'department_name'
                },
                {
                    data: 'department_picture',
                    name: 'department_picture'
                },
                {
                    data: 'department_status',
                    name: 'department_status'
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
            $('.departments_checkbox:checked').each(function() {
                id.push($(this).val());
            });
            if (id.length > 0) {
                $.ajax({
                    url: "{{ url('admin/departments/mass_destroy') }}",
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