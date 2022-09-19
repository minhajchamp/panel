@extends('layouts.adminapp')
@extends('layouts.nav')
@extends('layouts.sidebar')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Add /</span> {{ ucwords(Request::segment(2)) }}</h4>

    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <!-- <h5 class="mb-0">Create New Brand</h5> -->
                    <small class="text-muted float-end">Field with (*) are mandatory.</small>
                </div>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="card mb-4">
                    <!-- Account -->
                    <form action="{{ url('admin/payment/create_payment_link') }}" method="POST" enctype="multipart/form-data" id="formAccountSettings">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="amount" class="form-label">Amount *</label>
                                    <input class="form-control" type="text" id="amount" name="amount" value="{{ request()->old('amount') }}" placeholder="" required="required" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Brands</label>
                                    <select id="brands" name="brands" class="select2 form-select" required>
                                        <option value="">Select Brands</option>
                                        @if($brands->count() > 0)
                                        @foreach($brands as $pm)
                                        <option value="{{ $pm->id }}">{{ $pm->brand_name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Clients</label>
                                    <select id="clients" name="clients" class="select2 form-select" disabled required>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Payment Methods *</label>
                                    <select id="payment_methods" name="payment_methods" class="select2 form-select" required>
                                        <option value="">Select Payment Method</option>
                                        @if($payment_methods->count() > 0)
                                        @foreach($payment_methods as $pm)
                                        <option value="{{ $pm->id }}">{{ $pm->method_name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">Sales Email *</label>
                                    <input class="form-control" type="text" id="email" name="email" value="{{ request()->old('email') }}" placeholder="john.doe@example.com" required="required" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="currency" class="form-label">Currency</label>
                                    <select id="currency" name="user_currency" class="select2 form-select" required>
                                        <option value="">Select Currency</option>

                                        <!-- <option value="bitcoin">Bitcoin</option> -->
                                    </select>

                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Create Payment</button>
                                <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                            </div>

                        </div>
                    </form>
                    <!-- /Account -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.right-side -->
</div>
@endsection

@section('page_js')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ url('assets/js/custom.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
    $("#brands").change(function() {
        var brand_id = $(this).val();
        $("#clients").empty();
        $("#currency").empty();
        $("#currency").append('<option value="">Select Currency</option>');
        $("#clients").append('<option value="">Select Client</option>');
        $.ajax({
            type: 'GET',
            url: "{{ url('admin/payment/get_clients') }}/" + brand_id,
            data: '_token = <?php echo csrf_token() ?>',
            success: function(data) {
                if (data.length > 0) {
                    $("#clients").removeAttr('disabled');
                    for (let i = 0; i < data.length; i++) {
                        $("#clients").append(`<option value='${data[i].id}'>${data[i].name}</option>`);
                    }
                }
            }
        });
    });
    $("#clients").change(function() {
        var client_id = $(this).val();
        $("#currency").empty();
        $("#currency").append('<option value="">Select Client</option>');
        $.ajax({
            type: 'GET',
            url: "{{ url('admin/payment/get_client') }}/" + client_id,
            data: '_token = <?php echo csrf_token() ?>',
            success: function(data) {
                if (!data.user_currency) {
                    $("#currency").append(`
                        <option value="usd">USD</option>
                        <option value="euro">EURO</option>
                        <option value="pound">POUND</option>
                        <option value="pkr">PKR</option>
                    `);
                } else {
                    $("#currency").append(`
                        <option value="${data.user_currency}">${data.user_currency}</option>
                    `);
                }
            }
        });
    });
</script>
@endsection