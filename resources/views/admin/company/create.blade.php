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
                        <form id="add_company_form" class="create-company">
                            @csrf
                            {{-- Start company Form --}}
                            <div class="card">
                                <div class="card-body">
                                    <div class="new-company-info">
                                        <div class="row mb-2">
                                            <div class="col-md-6 text-start">
                                                <h4 class="card-title">Add New Company</h4>
                                            </div>
                                            <div class="col-md-6 text-end"><a href="{{ route('company:list') }}"
                                                    class="btn btn-primary">View All Companies</a></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label">Company Name:</label>
                                                        <input type="text" class="form-control" name="c_name"
                                                            placeholder="Enter Name">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label">Contact:</label>
                                                        <input type="text" class="form-control" name="c_contact"
                                                            placeholder="Enter Contact">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label">Email Address:</label>
                                                        <input type="email" class="form-control" name="c_email"
                                                            placeholder="Enter Email">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label">Address:</label>
                                                        <input type="text" class="form-control" name="c_address"
                                                            placeholder="Enter Address">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add_company_notify"></div>
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-primary float-end"
                                                    id="add_company_btn">Add
                                                    Company</button>
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
            $(".create-company").validate({
                rules: {
                    c_name: {
                        required: true,
                        maxlength: 20,
                    },
                    // c_contact: {
                    //     required: true,
                    //     maxlength: 20
                    // },
                    c_email: {
                        required: true,
                    },
                },
                messages: {
                    c_name: {
                        required: "Name is required",
                        maxlength: "Name cannot be more than 20 characters"
                    },
                    // c_contact: {
                    //     required: "Contact is required",
                    //     minlength: "Contact cannot be less than 11 characters"
                    // },
                    c_email: {
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
            $(document).on("submit", "#add_company_form", function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $("#add_company_btn").prop('disabled', true);
                $.ajax({
                    url: "{{ route('company:store') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status == "true") {
                            $(".add_company_notify").html(
                                `
                                <div class="alert alert-left alert-success alert-dismissible fade show mb-3" role="alert">
                                    <span> ` + response.msg + `!</span>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                `
                            ), setTimeout(function() {
                                $(".add_company_notify").html(``);
                                $("#add_company_btn").prop('disabled', false);
                                $("#add_company_form")[0].reset();
                                window.location = "{{ route('company:list') }}";
                            }, 2000);
                        }
                        if (response.status == "false") {
                            $(".add_company_notify").html(
                                `<div class="alert alert-left alert-danger alert-dismissible fade show mb-3" role="alert">
                                    <span> ` + response.msg + `!</span>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>`), setTimeout(function() {
                                $(".add_company_notify").html(``);
                                $("#add_company_btn").prop('disabled', false);
                            }, 2000);
                        }
                    }
                });
            });
        });
    </script>
