@include('admin.layouts.head')
<style>
    #image-upload-btn {
        position: absolute;
        font-size: 30px;
        opacity: 0;
        right: 0;
        top: 0;
    }
</style>

<body class="  ">
    <!-- loader Start -->
    <div id="loading">
        <div class="loader simple-loader">
            <div class="loader-body"></div>
        </div>
    </div>
    <!-- loader END -->

    @include('admin.layouts.sidebar')
    <main class="main-content">
        <div class="position-relative iq-banner">
            <!--Nav Start-->
            @include('admin.layouts.nav')
            <!-- Nav Header Component Start -->
            <div class="iq-navbar-header" style="height: 80px;">
            </div> <!-- Nav Header Component End -->
            <!--Nav End-->
        </div>
        <div class="conatiner-fluid content-inner mt-n5 py-0">
            <div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12">

                        {{-- Start employee Form --}}
                        <div class="card">
                            <form id="edit_employee_form" class="edit-employee">
                                @csrf
                                <div class="card-header d-flex justify-content-between">
                                    <div class="header-title">
                                        <h4 class="card-title">Edit Employee Information</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="new-employee-info">
                                        <div class="row">
                                            <div class="col-md-2">
                                                @if (is_null($employee->image))
                                                    <img id="e_emp_image"
                                                        src="{{ asset('admin/images/avatars/blank.jpg') }}"
                                                        alt="User-Profile"
                                                        class="theme-color-default-img img-fluid avatar avatar-130 avatar-rounded mx-auto d-block">
                                                @else
                                                    <img id="e_emp_image"
                                                        src="{{ asset('project_images/employee/' . $employee->image) }}"
                                                        alt="User-Profile"
                                                        class="theme-color-default-img img-fluid avatar avatar-130 avatar-rounded mx-auto d-block">
                                                @endif
                                                <div class="form-group col-lg-9 col-md-11 col-3 mx-auto d-block mt-3">
                                                    <input type="file" class="form-control col-md-8" name="e_image"
                                                        onchange="document.getElementById('e_emp_image').src = window.URL.createObjectURL(this.files[0])">
                                                </div>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label">Name:</label>
                                                        <input type="hidden" name="code"
                                                            value="{{ $employee->employee_id }}">
                                                        <input type="text" class="form-control" name="e_name"
                                                            placeholder="Enter Name"
                                                            value="{{ Str::title($employee->name) }}">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label">Contact:</label>
                                                        <input type="text" class="form-control" name="e_contact"
                                                            placeholder="Enter Contact"
                                                            value="{{ $employee->contact }}">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label">Email Address:</label>
                                                        <input type="email" class="form-control" name="e_email"
                                                            placeholder="Enter Email" value="{{ $employee->email }}">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label">Company:</label>
                                                        <select name="e_company" class="form-control">
                                                            <option value="" selected="selected">Select Company
                                                            </option>
                                                            @if (count($companies) > 0)
                                                                @foreach ($companies as $company)
                                                                    @if ($company->status == 1 || $company->company_id == $employee->company)
                                                                        <option
                                                                            value="{{ $company->company_id }}"{{ $company->company_id == $employee->company ? 'selected' : '' }}>
                                                                            {{ $company->name }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                <option disabled>Company not Available</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label">Date Of Birth:</label>
                                                        <input type="date" name="e_dob" class="form-control"
                                                            value="{{ $employee->dob }}">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="name">Details:</label>
                                                            <textarea name="e_details" id="" cols="30" rows="10" class="form-control">{{ $employee->description }}</textarea>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="form-group col-md-12">
                                                        <label class="form-label">Status:</label>
                                                        <select name="e_status" id="" class="form-control">
                                                            <option value="1"
                                                                {{ $employee->status == 1 ? 'selected' : '' }}>Active
                                                            </option>
                                                            <option value="0"
                                                                {{ $employee->status == 0 ? 'selected' : '' }}>
                                                                Deactive</option>
                                                        </select>
                                                    </div> --}}
                                                </div>
                                            </div>
                                            <div class="edit_employee_notify"></div>
                                            <div class="card-footer text-end">
                                                <a href="{{ route('employee:list') }}" class="btn btn-danger">Back</a>
                                                <button type="submit" class="btn btn-primary"
                                                    id="edit_employee_btn">Update
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="col-lg-10 offset-lg-2">
                                <div class="m-4">
                                    <div class="header-title mb-4">
                                        <h4 class="card-title">
                                            Change Password
                                        </h4>
                                    </div>
                                    <form id="employee_update_password" class="employee-change-password">
                                        @csrf
                                        <div class="employee_password_notify"></div>
                                        <input type="hidden" name="id" value="{{ $employee->id ?? '' }}">
                                        <div class="row">
                                            @if (session()->get('type') != 'admin')
                                                <div class="form-group col-md-6">
                                                    <label class="form-label">Old Password:</label>
                                                    <input type="password" name="old_password" class="form-control">
                                                </div>
                                            @endif
                                            <div class="form-group col-md-6">
                                                <label class="form-label">New Password:</label>
                                                <input type="password" name="new_password" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="form-label">Confirm Password:</label>
                                                <input type="password" name="confirm_password" class="form-control">
                                            </div>
                                        </div>
                                        <div class="mt-4 d-flex justify-content-end">
                                            <a href="{{ route('employee:list') }}" class="btn btn-danger "
                                                style="margin-right:5px">Back</a>
                                            <button type="submit" class="btn btn-primary">
                                                Submit
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer Section Start -->
        @include('admin.layouts.footer')
        <!-- Footer Section End -->
    </main>
    <!-- Wrapper End-->
    <!-- offcanvas start -->

    @include('admin.layouts.script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script>
        window.addEventListener('load', function() {
            $(".edit-employee").validate({
                rules: {
                    e_name: {
                        required: true,
                        maxlength: 20,
                    },
                    e_email: {
                        required: true,
                    },
                },
                messages: {
                    e_name: {
                        required: "Name is required",
                        maxlength: "Name cannot be more than 20 characters"
                    },
                    e_email: {
                        required: "Email is required",
                        email: "Email must be a valid email address",
                        maxlength: "Email cannot be more than 30 characters",
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).on("submit", "#edit_employee_form", function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    url: "{{ route('employee:update') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status == "true") {
                            $(".edit_employee_notify").html(
                                `
                                <div class="alert alert-left alert-success alert-dismissible fade show mb-3" role="alert">
                                    <span> ` + response.msg + `!</span>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                `
                            ), setTimeout(function() {
                                $(".edit_employee_notify").html(``);
                                window.location = "{{ route('employee:list') }}";
                            }, 2000);
                        }
                        if (response.status == "false") {
                            $(".edit_employee_notify").html(
                                `<div class="alert alert-left alert-danger alert-dismissible fade show mb-3" role="alert">
                                    <span> ` + response.msg + `!</span>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>`), setTimeout(function() {
                                $(".edit_employee_notify").html(``);
                            }, 2000);
                        }
                    }
                });
            });
        });
    </script>
    <script>
        window.addEventListener('load', function() {
            $(".employee-change-password").validate({
                rules: {
                    old_password: {
                        required: true,
                    },
                    new_password: {
                        required: true,
                    },
                    confirm_password: {
                        required: true,
                    },
                },
                messages: {
                    old_password: {
                        required: "Required Old Password",
                    },
                    new_password: {
                        required: "Required New Password",
                    },
                    confirm_password: {
                        required: "Required Confirm Password",
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).on("submit", "#employee_update_password", function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    url: "{{ route('employee:update_password') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status == "true") {
                            $(".employee_password_notify").html(
                                `
                                <div class="alert alert-left alert-success alert-dismissible fade show mb-3" role="alert">
                                    <span> ` + response.msg + `!</span>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                `
                            ), setTimeout(function() {
                                $(".employee_password_notify").html(``);
                                window.location = "{{ route('employee:list') }}";
                            }, 2000);
                        }
                        if (response.status == "false") {
                            $(".employee_password_notify").html(
                                `<div class="alert alert-left alert-danger alert-dismissible fade show mb-3" role="alert">
                                    <span> ` + response.msg + `!</span>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>`), setTimeout(function() {
                                $(".employee_password_notify").html(``);
                            }, 2000);
                        }
                    }
                });
            });
        });
    </script>
