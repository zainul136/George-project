@include('admin.layouts.head')

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
                        <form id="add_role_form" class="create-role">
                            @csrf
                            {{-- Start employee Form --}}
                            <div class="card">
                                <div class="card-body">
                                    <div class="new-employee-info">
                                        <div class="row mb-2">
                                            <div class="col-md-6 text-start">
                                                <h4 class="card-title">Create Roles and Permissions</h4>
                                            </div>
                                            <div class="col-md-6 text-end"><a href="{{ route('role:list') }}"
                                                    class="btn btn-primary">List Role</a></div>
                                        </div>
                                        <div class="add_role_notify"></div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label class="form-label">Role:</label>
                                                        <input type="text" class="form-control" name="name"
                                                            placeholder="Enter Name">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label class="form-label">Type:</label>
                                                        <select name="type" class="form-control">
                                                            <option value="" selected>Select Type</option>
                                                            <option value="employees">Employees</option>
                                                            <option value="contractors">contractors</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label class="form-label">Description:</label>
                                                        <textarea name="description" class="form-control" cols="10" rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-primary float-end"
                                                    id="add_role_btn">Add
                                                    Role and Permission</button>
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
            $(".create-role").validate({
                rules: {
                    name: {
                        required: true,
                    },
                    type: {
                        required: true,
                    }
                },
                messages: {
                    name: {
                        required: "Name is required",
                    },
                    type: {
                        required: "Type is required",
                    }
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
            $(document).on("submit", "#add_role_form", function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    url: "{{ route('role:store') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status == "true") {
                            $(".add_role_notify").html(
                                `
                                <div class="alert alert-left alert-success alert-dismissible fade show mb-3" role="alert">
                                    <span> ` + response.msg + `!</span>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                `
                            ), setTimeout(function() {
                                $(".add_role_notify").html(``);
                                $("#add_role_btn").prop('disabled', false);
                                $("#add_role_form")[0].reset();
                                window.location = "{{ route('role:list') }}";
                            }, 2000);
                        }
                        if (response.status == "false") {
                            $(".add_role_notify").html(
                                `<div class="alert alert-left alert-danger alert-dismissible fade show mb-3" role="alert">
                                    <span> ` + response.msg + `!</span>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>`), setTimeout(function() {
                                $(".add_role_notify").html(``);
                                $("#add_role_btn").prop('disabled', false);
                            }, 2000);
                        }
                    }
                });
            });
        });
    </script>
