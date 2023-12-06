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
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="company_status">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Client Status</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="code" id="code">
                            <label for="" class="mb-2">Status</label>
                            <select name="status" class="form-control" id="status">
                                <option value="1">Active</option>
                                <option value="0">Deactive</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal fade" id="add_company" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="add_employee_form">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Employee</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="add_employee_notify"></div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label">Name:</label>
                                        <input type="text" class="form-control" name="e_name"
                                            placeholder="Enter Name" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label">Contact:</label>
                                        <input type="text" class="form-control" name="e_contact"
                                            placeholder="Enter Contact">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label">Email Address:</label>
                                        <input type="email" class="form-control" name="e_email"
                                            placeholder="Enter Email" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label">Password:</label>
                                        <input type="password" class="form-control" name="e_password"
                                            placeholder="Enter Password" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label">Date Of Birth:</label>
                                        <input type="date" name="e_dob" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6">
                                        {{-- <label class="form-label">Company:</label> --}}
                                        <input type="hidden" class="form-control" name="e_company" id="e_company">
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label" for="name">Details:</label>
                                            <textarea name="e_details" id="" cols="30" rows="3" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="form-label">Profile Image:</label>
                                        <input type="file" class="form-control" name="e_image">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="position-relative iq-banner">
            <!--Nav Start-->
            @include('admin.layouts.nav')
            <!-- Nav Header Component Start -->
            <div class="iq-navbar-header" style="height: 80px;">
            </div> <!-- Nav Header Component End -->
            <!--Nav End-->
        </div>
        <div class="conatiner-fluid content-inner mt-n5 py-0">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-md-6 text-start">
                                    <h4 class="card-title">Companies</h4>
                                </div>
                                <div class="col-md-6 text-end"><a href="{{ route('company:create') }}"
                                        class="btn btn-primary">Add New Account</a></div>
                            </div>
                            <div class="table-responsive">
                                <table id="company-table" class="table table-striped" data-toggle="data-table">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase">Company Name</th>
                                            <th class="text-uppercase">Email</th>
                                            <th class="text-uppercase">Contact</th>
                                            <th class="text-uppercase">Address</th>
                                            <th class="text-uppercase">Status</th>
                                            <th class="text-uppercase">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($companies as $company)
                                            <tr>
                                                <td>{{ Str::title($company->name) }}</td>
                                                <td>{{ $company->email }}</td>
                                                <td>{{ $company->contact }}</td>
                                                <td>{{ Str::title($company->address) }}</td>
                                                <td>
                                                    @if ($company->status == 1)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Deactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-secondary btn-sm py-1 px-2 add_company"
                                                        data-bs-toggle="modal" data-bs-target="#add_company"
                                                        data-id="{{ $company->company_id }}">
                                                        <i class="fas fa-plus" data-bs-placement="top"
                                                            title="Add Employee" data-bs-toggle="tooltip"></i>
                                                    </button>
                                                    <a class="btn btn-sm btn-icon btn-success"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="View" target="_blank"
                                                        href="{{ route('company:view', $company->company_id) }}">
                                                        <span class="btn-inner">
                                                            <svg class="icon-20" width="20" viewBox="0 0 24 24"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M22.4541 11.3918C22.7819 11.7385 22.7819 12.2615 22.4541 12.6082C21.0124 14.1335 16.8768 18 12 18C7.12317 18 2.98759 14.1335 1.54586 12.6082C1.21811 12.2615 1.21811 11.7385 1.54586 11.3918C2.98759 9.86647 7.12317 6 12 6C16.8768 6 21.0124 9.86647 22.4541 11.3918Z"
                                                                    stroke="white"></path>
                                                                <circle cx="12" cy="12" r="5"
                                                                    stroke="white"></circle>
                                                                <circle cx="12" cy="12" r="3"
                                                                    fill="white"></circle>
                                                                <mask mask-type="alpha" maskUnits="userSpaceOnUse"
                                                                    x="9" y="9" width="6"
                                                                    height="6">
                                                                    <circle cx="12" cy="12"
                                                                        r="3" fill="white"></circle>
                                                                </mask>
                                                                <circle opacity="0.89" cx="13.5" cy="10.5"
                                                                    r="1.5" fill="white"></circle>
                                                            </svg>
                                                        </span>
                                                    </a>
                                                    <button type="button"
                                                        class="btn btn-primary btn-sm change_status py-1 px-2"
                                                        data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                        data-id="{{ $company->company_id }}">
                                                        <i class="fas fa-exclamation-triangle" data-bs-placement="top"
                                                            title="Change Status" data-bs-toggle="tooltip"></i>
                                                    </button>
                                                    <a class="btn btn-sm btn-icon btn-warning"
                                                        href="{{ route('company:edit', $company->company_id) }}"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Edit" data-original-title="Edit">
                                                        <span class="btn-inner">
                                                            <svg class="icon-20" width="20" viewBox="0 0 24 24"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341"
                                                                    stroke="currentColor" stroke-width="1.5"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                </path>
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z"
                                                                    stroke="currentColor" stroke-width="1.5"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                </path>
                                                                <path d="M15.1655 4.60254L19.7315 9.16854"
                                                                    stroke="currentColor" stroke-width="1.5"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                </path>
                                                            </svg>
                                                        </span>
                                                    </a>
                                                    <a class="btn btn-sm btn-icon btn-danger delete_company"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Delete" href="#"
                                                        data-id="{{ $company->company_id }}">
                                                        <span class="btn-inner">
                                                            <svg class="icon-20" width="20" viewBox="0 0 24 24"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg"
                                                                stroke="currentColor">
                                                                <path
                                                                    d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826"
                                                                    stroke="currentColor" stroke-width="1.5"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                </path>
                                                                <path d="M20.708 6.23975H3.75" stroke="currentColor"
                                                                    stroke-width="1.5" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                                <path
                                                                    d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973"
                                                                    stroke="currentColor" stroke-width="1.5"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                </path>
                                                            </svg>
                                                        </span>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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

    @include('admin.layouts.script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#company-table').dataTable({
                destroy: true,
                pageLength: 50 // Set the default page length to 50 records per page
            });
            $(".change_status").click(function() {
                let code = $(this).attr("data-id");
                $.ajax({
                    url: "{{ route('company:find') }}",
                    type: 'post',
                    cache: false,
                    data: {
                        _token: '{{ csrf_token() }}',
                        'id': code
                    },
                    success: function(response) {
                        let company_id = response.company_id;
                        let status = response.status;
                        $("#code").val(company_id);
                        if (status == 1) {
                            $('#status option[value="1"]').prop('selected', true);
                        } else {
                            $('#status option[value="0"]').prop('selected', true);
                        }

                        // Update Status
                        $(document).on("submit", "#company_status", function(e) {
                            e.preventDefault();
                            let formData = new FormData(this);
                            $.ajax({
                                url: "{{ route('company:update_status') }}",
                                type: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(response) {
                                    if (response.status == "true") {
                                        $('#exampleModal').modal('toggle');
                                        setTimeout(function() {}, 1000);
                                        Swal.fire(
                                            'Good job!',
                                            'You Status Updated Successfully!',
                                            'success',
                                            'Done'
                                        )
                                        setTimeout(() => {
                                            window.location =
                                                "{{ route('company:list') }}";
                                        }, 2000);
                                    }
                                    if (response.status == "false") {
                                        $('#exampleModal').modal('toggle');
                                        setTimeout(function() {}, 1000);
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Something went wrong!',
                                        });
                                        setTimeout(() => {
                                            window.location =
                                                "{{ route('company:list') }}";
                                        }, 2000);
                                    }
                                }
                            });
                        });
                    }
                })
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.delete_company').click(function(event) {
                var form = $(this).closest("form");
                var name = $(this).data("name");
                event.preventDefault();
                Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            let code = $(this).attr("data-id");
                            $.ajax({
                                url: "{{ route('company:delete') }}",
                                type: 'delete',
                                cache: false,
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    'id': code,
                                },
                                success: function(response) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Company has been deleted.',
                                        'success'
                                    )
                                    setTimeout(() => {
                                        window.location =
                                            "{{ route('company:list') }}";
                                    }, 2000);
                                }
                            })
                        }
                    })
            });
        });
    </script>
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
            $(".add_company").on("click", function(e) {
                e.preventDefault();
                var dataId = $(this).attr("data-id");
                $("#e_company").val(dataId);
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
