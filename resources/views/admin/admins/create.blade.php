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
                        <form id="add_admin_form" class="create-admin">
                            @csrf
                            {{-- Start admin Form --}}
                            <div class="card">
                                <div class="card-body">
                                    <div class="new-employee-info">
                                        <div class="row mb-2">
                                            <div class="col-md-6 text-start">
                                                <h4 class="card-title">Add New Admin</h4>
                                            </div>
                                            <div class="col-md-6 text-end"><a href="{{ route('admin:list') }}"
                                                    class="btn btn-primary">View All Admins</a></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <img id="c_emp_image"
                                                    src="{{ asset('admin/images/avatars/blank.jpg') }}"
                                                    alt="User-Profile"
                                                    class="theme-color-default-img img-fluid avatar avatar-130 avatar-rounded mx-auto d-block">
                                                <div class="form-group col-lg-9 col-md-11 col-3 mx-auto d-block mt-3">
                                                    <input type="file" class="form-control col-md-8" name="image"
                                                        onchange="document.getElementById('c_emp_image').src = window.URL.createObjectURL(this.files[0])">
                                                </div>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label">Name:</label>
                                                        <input type="text" class="form-control" name="name"
                                                            placeholder="Enter Name">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label">Contact:</label>
                                                        <input type="text" class="form-control" name="contact"
                                                            placeholder="Enter Contact">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label">Email Address:</label>
                                                        <input type="email" class="form-control" name="email"
                                                            placeholder="Enter Email">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label">Password:</label>
                                                        <input type="password" class="form-control" name="password"
                                                            placeholder="Enter Password">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label">Company:</label>
                                                        <select name="company" id="" class="form-control">
                                                            <option value="" selected="selected">Select Company
                                                            </option>
                                                            @if (count($companies) > 0)
                                                                @foreach ($companies as $company)
                                                                    <option value="{{ $company->name }}">
                                                                        {{ $company->name }}</option>
                                                                @endforeach
                                                            @else
                                                                <option selected disabled>Company not Available</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label">Date Of Birth:</label>
                                                        <input type="date" name="dob" class="form-control">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="name">Address:</label>
                                                            <textarea name="address" id="" cols="30" rows="10" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add_admin_notify"></div>
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-primary float-end"
                                                    id="add_admin_btn">Add
                                                    Admin</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
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
            $(".create-admin").validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 20,
                    },
                    email: {
                        required: true,
                    },
                    password: {
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
                    password: {
                        required: "Password is required",
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
            $(document).on("submit", "#add_admin_form", function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $("#add_admin_btn").prop('disabled', true);
                $.ajax({
                    url: "{{ route('admin:store') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status == "true") {
                            $(".add_admin_notify").html(
                                `
                                <div class="alert alert-left alert-success alert-dismissible fade show mb-3" role="alert">
                                    <span> ` + response.msg + `!</span>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                `
                            ), setTimeout(function() {
                                $(".add_admin_notify").html(``);
                                $("#add_admin_btn").prop('disabled', false);
                                $("#add_admin_form")[0].reset();
                                window.location = "{{ route('admin:list') }}";
                            }, 2000);
                        }
                        if (response.status == "false") {
                            $(".add_admin_notify").html(
                                `<div class="alert alert-left alert-danger alert-dismissible fade show mb-3" role="alert">
                                    <span> ` + response.msg + `!</span>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>`), setTimeout(function() {
                                $(".add_admin_notify").html(``);
                                $("#add_admin_btn").prop('disabled', false);
                            }, 2000);
                        }
                    }
                });
            });
        });
    </script>
