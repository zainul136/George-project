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
                <form id="employee_status">
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
                                    <h4 class="card-title">Employees</h4>
                                </div>
                                <div class="col-md-6 text-end"><a href="{{ route('employee:create') }}"
                                        class="btn btn-primary">Add New Account</a></div>
                            </div>
                            <div class="table-responsive">
                                <table id="employee-table" class="table table-striped" data-toggle="data-table">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase">Image</th>
                                            <th class="text-uppercase">Employee Name</th>
                                            <th class="text-uppercase">Email</th>
                                            <th class="text-uppercase">Contact</th>
                                            <th class="text-uppercase">Company</th>
                                            <th class="text-uppercase">Status</th>
                                            <th class="text-uppercase">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employees as $employee)
                                            <tr>
                                                <td>
                                                    @if (is_null($employee->image))
                                                        <img src="{{ asset('admin/images/avatars/blank.jpg') }}"
                                                            alt="{{ Str::title($employee->name) }}"
                                                            class="theme-color-default-img img-fluid avatar avatar-50 avatar-rounded">
                                                    @else
                                                        <img src="{{ asset('project_images/employee/' . $employee->image) }}"
                                                            alt="{{ Str::title($employee->name) }}"
                                                            class="theme-color-default-img img-fluid avatar avatar-50 avatar-rounded">
                                                    @endif
                                                </td>
                                                <td>{{ $employee->name }}</td>
                                                <td>{{ $employee->email }}</td>
                                                <td>{{ $employee->contact }}</td>
                                                <td>{{ $employee->company_name }}</td>
                                                <td>
                                                    @if ($employee->status == 1)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Deactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="btn btn-sm btn-icon btn-success" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="View" target="_blank"
                                                        href="{{ route('employee:view', $employee->employee_id) }}">
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
                                                    <a class="btn btn-sm btn-icon btn-warning"
                                                        href="{{ route('employee:edit', $employee->employee_id) }}"
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
                                                    <button type="button"
                                                        class="btn btn-primary btn-sm change_status py-1 px-2"
                                                        data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                        data-id="{{ $employee->employee_id }}">
                                                        <i class="fas fa-exclamation-triangle"></i>
                                                    </button>
                                                    <a class="btn btn-sm btn-icon btn-danger show_confirm"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Delete" href="#"
                                                        data-id="{{ $employee->employee_id }}">
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

    <script type="text/javascript">
        $(document).ready(function() {
            $('#employee-table').dataTable({
                destroy: true,
                pageLength: 50 // Set the default page length to 50 records per page
            });
            $('.show_confirm').click(function(event) {
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
                                url: "{{ route('employee:delete') }}",
                                type: 'delete',
                                cache: false,
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    'id': code,
                                },
                                success: function(response) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Employee has been deleted.',
                                        'success'
                                    )
                                    setTimeout(() => {
                                        window.location =
                                            "{{ route('employee:list') }}";
                                    }, 2000);
                                }
                            })
                        }
                    })
            });
        });
    </script>
