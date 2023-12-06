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
                        <form id="add_employee_form" class="create-employee">
                            @csrf
                            {{-- Start employee Form --}}
                            <div class="card">
                                <div class="card-body">
                                    <div class="new-employee-info">
                                        <div class="row mb-2">
                                            <div class="col-md-6 text-start">
                                                <h4 class="card-title">Add New Employee</h4>
                                            </div>
                                            <div class="col-md-6 text-end"><a href="{{ route('employee:list') }}"
                                                    class="btn btn-primary">View All Employees</a></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <img id="c_emp_image"
                                                    src="{{ asset('admin/images/avatars/blank.jpg') }}"
                                                    alt="User-Profile"
                                                    class="theme-color-default-img img-fluid avatar avatar-130 avatar-rounded mx-auto d-block">
                                                <div class="form-group col-lg-9 col-md-11 col-3 mx-auto d-block mt-3">
                                                    <input type="file" class="form-control col-md-8" name="e_image"
                                                        onchange="document.getElementById('c_emp_image').src = window.URL.createObjectURL(this.files[0])">
                                                </div>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label">Name:</label>
                                                        <input type="text" class="form-control" name="e_name"
                                                            placeholder="Enter Name">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label">Contact:</label>
                                                        <input type="text" class="form-control" name="e_contact"
                                                            placeholder="Enter Contact">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label">Email Address:</label>
                                                        <input type="email" class="form-control" name="e_email"
                                                            placeholder="Enter Email">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label">Password:</label>
                                                        <input type="password" class="form-control" name="e_password"
                                                            placeholder="Enter Password">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label">Company:</label>
                                                        <select name="e_company" id="" class="form-control">
                                                            <option value="" selected="selected">Select Company
                                                            </option>
                                                            @if (count($companies) > 0)
                                                                @foreach ($companies as $company)
                                                                    <option value="{{ $company->company_id }}">
                                                                        {{ $company->name }}</option>
                                                                @endforeach
                                                            @else
                                                                <option selected disabled>Company not Available</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label">Date Of Birth:</label>
                                                        <input type="date" name="e_dob" class="form-control">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="name">Details:</label>
                                                            <textarea name="e_details" id="" cols="30" rows="10" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add_employee_notify"></div>
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-primary float-end"
                                                    id="add_employee_btn">Add
                                                    Employee</button>
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
    <script>
        window.addEventListener('load', function() {
            $(".create-employee").validate({
                rules: {
                    e_name: {
                        required: true,
                        maxlength: 20,
                    },
                    e_email: {
                        required: true,
                    },
                    e_password: {
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
                    e_password: {
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
    </script>
    <script>
        $(document).ready(function() {
            $(document).on("submit", "#add_employee_form", function(e) {
                e.preventDefault();
                let image = $("#image-upload-btn").val();
                if (image == '') {
                    $(".add_employee_notify").html(
                        `
                                <div class="alert alert-left alert-danger alert-dismissible fade show mb-3" role="alert">
                                    <span> Image Filed Required!</span>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                `
                    ), setTimeout(function() {
                        $(".add_employee_notify").html(``);
                    }, 2000);
                } else {
                    let formData = new FormData(this);
                    $("#add_employee_btn").prop('disabled', true);
                    $.ajax({
                        url: "{{ route('employee:store') }}",
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.status == "true") {
                                $(".add_employee_notify").html(
                                    `
                                <div class="alert alert-left alert-success alert-dismissible fade show mb-3" role="alert">
                                    <span> ` + response.msg + `!</span>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                `
                                ), setTimeout(function() {
                                    $(".add_employee_notify").html(``);
                                    $("#add_employee_btn").prop('disabled', false);
                                    $("#add_employee_form")[0].reset();
                                    window.location = "{{ route('employee:list') }}";
                                }, 2000);
                            }
                            if (response.status == "false") {
                                $(".add_employee_notify").html(
                                    `<div class="alert alert-left alert-danger alert-dismissible fade show mb-3" role="alert">
                                    <span> ` + response.msg + `!</span>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>`), setTimeout(function() {
                                    $(".add_employee_notify").html(``);
                                    $("#add_employee_btn").prop('disabled', false);
                                }, 2000);
                            }
                        }
                    });
                }
            });
        });
    </script>
