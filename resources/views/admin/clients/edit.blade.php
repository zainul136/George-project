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
                        <form id="edit_client_form" class="create-client">
                            @csrf
                            {{-- Start client Form --}}
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="header-title">
                                        <h4 class="card-title">Edit Client Information</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="new-client-info">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <img id="e_cl_image"
                                                    src="{{ isset($client->image) && !empty($client->image) ? asset('project_images/client/' . $client->image) : asset('admin/images/avatars/blank.jpg') }}"
                                                    alt="User-Profile"
                                                    class="theme-color-default-img img-fluid avatar avatar-130 avatar-rounded mx-auto d-block">
                                                <div class="form-group col-lg-9 col-md-11 col-3 mx-auto d-block mt-3">
                                                    <input type="file" class="form-control" name="image"
                                                        onchange="document.getElementById('e_cl_image').src = window.URL.createObjectURL(this.files[0])">
                                                </div>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label">Name:</label>
                                                        <input type="hidden" name="code"
                                                            value="{{ $client->client_id }}">
                                                        <input type="text" class="form-control" name="name"
                                                            placeholder="Enter Name" value="{{ $client->name }}">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label">Contact:</label>
                                                        <input type="text" class="form-control" name="contact"
                                                            placeholder="Enter Contact" value="{{ $client->contact }}">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label">Email Address:</label>
                                                        <input type="email" class="form-control" name="email"
                                                            placeholder="Enter Email" value="{{ $client->email }}">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label">Project:</label>
                                                        <select name="project" class="form-control">
                                                            <option value="" selected="selected">Select Project
                                                            </option>
                                                            @if (count($projects) > 0)
                                                                @foreach ($projects as $project)
                                                                    @if ($project->status == 1 || ($project->status == 0 && $project->name == $client->project))
                                                                        <option value="{{ $project->name }}"
                                                                            {{ $project->name == $client->project ? 'selected' : '' }}>
                                                                            {{ $project->name }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                <option selected disabled>Projects not Available
                                                                </option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label">Date Of Birth:</label>
                                                        <input type="date" name="dob" class="form-control"
                                                            value="{{ $client->dob }}">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Address:</label>
                                                            <textarea name="address" id="" cols="30" rows="10" class="form-control">{{ $client->address }}</textarea>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-md-12">
                                                        <label class="form-label">Status:</label>
                                                        <select name="status" id="" class="form-control">
                                                            <option value="1"
                                                                {{ $client->status == 1 ? 'selected' : '' }}>Active
                                                            </option>
                                                            <option value="0"
                                                                {{ $client->status == 0 ? 'selected' : '' }}>
                                                                Deactive</option>
                                                        </select>
                                                    </div> --}}
                                                </div>
                                            </div>
                                            <div class="edit_client_notify"></div>
                                            <div class="card-footer text-end">
                                                <a href="{{ route('client:list') }}"
                                                    class="btn btn-danger">Back</a>&nbsp;
                                                <button type="submit" class="btn btn-primary"
                                                    id="edit_client_btn">Update
                                                </button>
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
            $(".create-client").validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 20,
                    },
                    // contact: {
                    //     required: true,
                    //     maxlength: 11
                    // },
                    email: {
                        required: true,
                    },
                    company: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: "Name is required",
                        maxlength: "Name cannot be more than 20 characters"
                    },
                    // contact: {
                    //     required: "Contact is required",
                    //     minlength: "Contact cannot be less than 11 characters"
                    // },
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
            $(document).on("submit", "#edit_client_form", function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    url: "{{ route('client:update') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status == "true") {
                            $(".edit_client_notify").html(
                                `
                                <div class="alert alert-left alert-success alert-dismissible fade show mb-3" role="alert">
                                    <span> ` + response.msg + `!</span>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                `
                            ), setTimeout(function() {
                                $(".edit_client_notify").html(``);
                                window.location = "{{ route('client:list') }}";
                            }, 2000);
                        }
                        if (response.status == "false") {
                            $(".edit_client_notify").html(
                                `<div class="alert alert-left alert-danger alert-dismissible fade show mb-3" role="alert">
                                    <span> ` + response.msg + `!</span>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>`), setTimeout(function() {
                                $(".edit_client_notify").html(``);
                            }, 2000);
                        }
                    }
                });
            });
        });
    </script>
