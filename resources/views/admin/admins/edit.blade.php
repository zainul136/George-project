@include('admin.layouts.head')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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

                        {{-- Start admin Form --}}
                        <div class="card">
                            <form id="edit_admin_form" class="edit-admin">
                                @csrf
                                <div class="card-header d-flex justify-content-between">
                                    <div class="header-title">
                                        <h4 class="card-title">Edit Admin Information</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="new-employee-info">
                                        <div class="row">
                                            <div class="col-md-2">
                                                @if (is_null($admin->image))
                                                    <img id="e_emp_image"
                                                        src="{{ asset('admin/images/avatars/blank.jpg') }}"
                                                        alt="User-Profile"
                                                        class="theme-color-default-img img-fluid avatar avatar-130 avatar-rounded mx-auto d-block">
                                                @else
                                                    <img id="e_emp_image"
                                                        src="{{ asset('project_images/admin/' . $admin->image) }}"
                                                        alt="User-Profile"
                                                        class="theme-color-default-img img-fluid avatar avatar-130 avatar-rounded mx-auto d-block">
                                                @endif
                                                <div class="form-group col-lg-9 col-md-11 col-3 mx-auto d-block mt-3">
                                                    <input type="file" class="form-control col-md-8" name="image"
                                                        onchange="document.getElementById('e_emp_image').src = window.URL.createObjectURL(this.files[0])">
                                                </div>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label">Name:</label>
                                                        <input type="hidden" name="code"
                                                            value="{{ $admin->admin_id }}">
                                                        <input type="text" class="form-control" name="name"
                                                            placeholder="Enter Name" value="{{ $admin->name }}">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label">Contact:</label>
                                                        <input type="text" class="form-control" name="contact"
                                                            placeholder="Enter Contact" value="{{ $admin->contact }}">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label">Email Address:</label>
                                                        <input type="email" class="form-control" name="email"
                                                            placeholder="Enter Email" value="{{ $admin->email }}">
                                                    </div>
                                                    {{-- <div class="form-group col-md-6">
                                                        <label class="form-label">Password:</label>
                                                        <input type="password" class="form-control" name="password"
                                                            placeholder="Enter Password">
                                                    </div> --}}
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label">Company:</label>
                                                        <select name="company" class="form-control">
                                                            <option value="" selected="selected">Select Company
                                                            </option>
                                                            @if (count($companies) > 0)
                                                                @foreach ($companies as $company)
                                                                    @if ($company->status == 1 || ($company->status == 0 && $company->name == $admin->company))
                                                                        <option
                                                                            value="{{ $company->name }}"{{ $company->name == $admin->company ? 'selected' : '' }}>
                                                                            {{ $company->name }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                <option selected disabled>Company not Available</option>
                                                            @endif

                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label">Date Of Birth:</label>
                                                        <input type="date" name="dob" class="form-control"
                                                            value="{{ $admin->dob }}">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="name">Address:</label>
                                                            <textarea name="address" id="" cols="30" rows="10" class="form-control">{{ $admin->address }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Status:</label>
                                                            <select name="status" id="" class="form-control">
                                                                <option value="1"
                                                                    {{ $admin->status == 1 ? 'selected' : '' }}>
                                                                    Active
                                                                </option>
                                                                <option value="0"
                                                                    {{ $admin->status == 0 ? 'selected' : '' }}>
                                                                    Deactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="edit_admin_notify"></div>
                                            <div class="card-footer text-end">
                                                <button type="submit" class="btn btn-primary"
                                                    id="edit_admin_btn">Update
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
                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    <form method="post" id="update_pass"
                                        action="{{ route('admin:update.change_password') }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $admin->id ?? '' }}">
                                        <div class="form-group row">
                                            @if ($errors->has('errors'))
                                                <span class="invalid-feedback" style="display: block;"
                                                    role="alert">
                                                    <strong>{{ $errors->first('errors') }}</strong>
                                                </span>
                                            @endif
                                            <br><br>
                                            <div class="col-md-6">
                                                <label for="new_password">New Password</label>
                                                <input class="form-control" id="new_password" name="new_password"
                                                    type="password" value="{{ old('new_password') }}">
                                                @if ($errors->has('new_password'))
                                                    <span class="invalid-feedback" style="display: block;"
                                                        role="alert">
                                                        <strong>{{ $errors->first('new_password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <label for="confirm_password">Confirm Password</label>
                                                <input class="form-control" id="confirm_password"
                                                    name="confirm_password" type="password"
                                                    value="{{ old('confirm_password') }}">
                                                @if ($errors->has('confirm_password'))
                                                    <span class="invalid-feedback" style="display: block;"
                                                        role="alert">
                                                        <strong>{{ $errors->first('confirm_password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mt-4 d-flex justify-content-end">
                                            <a href="{{ route('admin:list') }}" class="btn btn-danger "
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        window.addEventListener('load', function() {
            $(".edit-admin").validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 20,
                    },
                    email: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: "Name is required",
                        maxlength: "Name cannot be more than 20 characters"
                    },
                    email: {
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

        $(".multiple_select_employees").select2({
            placeholder: 'Select Employees',
            maximumSelectionLength: 200
        });

        $(".multiple_select_contractors").select2({
            placeholder: 'Select Contractor',
            maximumSelectionLength: 200
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#edit_admin_form").on("submit", function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    url: "{{ route('admin:update') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status == "true") {
                            $(".edit_admin_notify").html(
                                `
                                <div class="alert alert-left alert-success alert-dismissible fade show mb-3" role="alert">
                                    <span> ` + response.msg + `!</span>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                `
                            ), setTimeout(function() {
                                $(".edit_admin_notify").html(``);
                                window.location = "{{ route('admin:list') }}";
                            }, 2000);
                        }
                        if (response.status == "false") {
                            $(".edit_admin_notify").html(
                                `<div class="alert alert-left alert-danger alert-dismissible fade show mb-3" role="alert">
                                    <span> ` + response.msg + `!</span>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>`), setTimeout(function() {
                                $(".edit_admin_notify").html(``);
                            }, 2000);
                        }
                    }
                });
            });
        });
    </script>
