@extends('layouts.adminapp')
@extends('layouts.nav')
@extends('layouts.sidebar')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Edit /</span> {{ ucwords(Request::segment(2)) }}</h4>

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
                    @if($users->count() > 0)
                    <form action="{{ url('admin/users') }}" method="POST" enctype="multipart/form-data" id="formAccountSettings">
                        @csrf
                        <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img src="{{ url('assets/img/avatars/1.png') }}" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                                <div class="button-wrapper">
                                    <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                        <span class="d-none d-sm-block">Upload new photo</span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                        <input type="file" id="upload" class="account-file-input" name="user_picture" hidden accept="image/png, image/jpeg" />
                                    </label>
                                    <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                        <i class="bx bx-reset d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Reset</span>
                                    </button>

                                    <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="firstName" class="form-label">First Name *</label>
                                    <input class="form-control" type="text" id="firstName" name="first_name" placeholder="John" autofocus required="required" value="{{ $users->name ? explode(' ', $users->name)[0] : '' }}" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="lastName" class="form-label">Last Name *</label>
                                    <input class="form-control" type="text" name="last_name" value="{{ $users->name ? explode(' ', $users->name)[1] : '' }}" id="lastName" placeholder="Doe" required="required" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">E-mail *</label>
                                    <input class="form-control" type="text" id="email" name="email" value="{{ $users->email }}" placeholder="john.doe@example.com" required="required" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="user_organization" class="form-label">Organization</label>
                                    <input type="text" class="form-control" id="user_organization" name="user_organization" value="{{ $users->user_organization }}" readonly/>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="user_contact">Phone Number</label>
                                    <div class="input-group input-group-merge">
                                        <!-- <span class="input-group-text">US (+1)</span> -->
                                        <input type="text" id="user_contact" name="user_contact" class="form-control" placeholder="202 555 0111" value="{{ $users->user_contact }}" />
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="user_address" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="user_address" value="{{ $users->user_address }}" name="user_address" placeholder="Address" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="user_state" class="form-label">State</label>
                                    <input class="form-control" type="text" id="user_state" value="{{ $users->user_state }}" name="user_state" placeholder="California" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="user_city" class="form-label">City</label>
                                    <input class="form-control" type="text" id="user_city" value="{{ $users->user_city }}" name="user_city" placeholder="Denver" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Gender</label>
                                    <select id="user_gender" name="user_gender" class="form-select">
                                        <option value="">Select Gender</option>
                                        <option value="M" {{ $users->user_gender == 'M' ? 'selected' : ''}}>Male</option>
                                        <option value="F" {{ $users->user_gender == 'F' ? 'selected' : ''}}>Female</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="zipCode" class="form-label">Zip Code</label>
                                    <input type="text" class="form-control" id="zipCode" value="{{ $users->user_zipcode }}" name="zipCode" placeholder="231465" maxlength="6" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="user_dob" class="form-label">DOB</label>
                                    <input type="date" class="form-control" id="user_dob" value="{{ $users->user_dob }}" name="user_dob" placeholder="231465" maxlength="6" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Role *</label>
                                    <select id="role" name="role_id" class="Role form-select" required="required">
                                        <option value="">Select Brand</option>
                                        @if($roles->count() > 0)
                                        @foreach($roles as $row)
                                        <option value="{{$row->id}}" {{ $users->role_id == $row->id ? 'selected' : ''}}>{{ucwords($row->name)}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Brands *</label>
                                    <select id="brand" name="brand_id" class="select2 form-select" required="required">
                                        <option value="">Select Brand</option>
                                        @if($brands->count() > 0)
                                        @foreach($brands as $row)
                                        <option value="{{$row->id}}" {{ $users->brand_id == $row->id ? 'selected' : ''}}>{{$row->brand_name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="country">Country</label>
                                    <select id="country" name="user_country" class="select2 form-select">
                                        <option value="">Select</option>
                                        @if(count($countries) > 0)
                                        @foreach($countries as $ctr)
                                        <option value="{{ $ctr->name }}" {{ $users->user_country == $ctr->name ? 'selected' : ''}}>{{ $ctr->name }}</option>
                                        @endforeach
                                        @else
                                        dd(1);
                                        <option value="Australia">Australia</option>
                                        <option value="Bangladesh">Bangladesh</option>
                                        <option value="Belarus">Belarus</option>
                                        <option value="Brazil">Brazil</option>
                                        <option value="Canada">Canada</option>
                                        <option value="China">China</option>
                                        <option value="France">France</option>
                                        <option value="Germany">Germany</option>
                                        <option value="India">India</option>
                                        <option value="Indonesia">Indonesia</option>
                                        <option value="Israel">Israel</option>
                                        <option value="Italy">Italy</option>
                                        <option value="Japan">Japan</option>
                                        <option value="Korea">Korea, Republic of</option>
                                        <option value="Mexico">Mexico</option>
                                        <option value="Philippines">Philippines</option>
                                        <option value="Russia">Russian Federation</option>
                                        <option value="South Africa">South Africa</option>
                                        <option value="Thailand">Thailand</option>
                                        <option value="Turkey">Turkey</option>
                                        <option value="Ukraine">Ukraine</option>
                                        <option value="United Arab Emirates">United Arab Emirates</option>
                                        <option value="United Kingdom">United Kingdom</option>
                                        <option value="United States">United States</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="language" class="form-label">Language</label>
                                    <select id="language" name="user_language" class="select2 form-select">
                                        <option value="">Select Language</option>
                                        <option value="en">English</option>
                                        <option value="fr">French</option>
                                        <option value="de">German</option>
                                        <option value="pt">Portuguese</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="timeZones" class="form-label">Timezone</label>
                                    <select id="timeZones" name="user_timezone" class="select2 form-select">
                                        <option value="">Select Timezone</option>
                                        <option value="-12">(GMT-12:00) International Date Line West</option>
                                        <option value="-11">(GMT-11:00) Midway Island, Samoa</option>
                                        <option value="-10">(GMT-10:00) Hawaii</option>
                                        <option value="-9">(GMT-09:00) Alaska</option>
                                        <option value="-8">(GMT-08:00) Pacific Time (US & Canada)</option>
                                        <option value="-8">(GMT-08:00) Tijuana, Baja California</option>
                                        <option value="-7">(GMT-07:00) Arizona</option>
                                        <option value="-7">(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
                                        <option value="-7">(GMT-07:00) Mountain Time (US & Canada)</option>
                                        <option value="-6">(GMT-06:00) Central America</option>
                                        <option value="-6">(GMT-06:00) Central Time (US & Canada)</option>
                                        <option value="-6">(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
                                        <option value="-6">(GMT-06:00) Saskatchewan</option>
                                        <option value="-5">(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
                                        <option value="-5">(GMT-05:00) Eastern Time (US & Canada)</option>
                                        <option value="-5">(GMT-05:00) Indiana (East)</option>
                                        <option value="-4">(GMT-04:00) Atlantic Time (Canada)</option>
                                        <option value="-4">(GMT-04:00) Caracas, La Paz</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="currency" class="form-label">Currency</label>
                                    <select id="currency" name="user_currency" class="select2 form-select">
                                        <option value="">Select Currency</option>
                                        <option value="usd">USD</option>
                                        <option value="euro">EURO</option>
                                        <option value="pound">POUND</option>
                                        <option value="pkr">PKR</option>
                                        <!-- <option value="bitcoin">Bitcoin</option> -->
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6 form-password-toggle">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label" for="password">Set Password *</label>
                                    </div>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" class="form-control" name="user_password" 
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                            </div>

                        </div>
                    </form>
                    @endif
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
</script>
@endsection