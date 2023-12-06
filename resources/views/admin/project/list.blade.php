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
        <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="project_status">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Project Status</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="code" id="code">
                            <label for="" class="mb-2">Status</label>
                            <select name="status" class="form-control" id="status">
                                <option value="offer">Offer</option>
                                <option value="pending_approve">Pending Approve</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="invitation_pending">Invitation Pending</option>
                                <option value="ready">Ready</option>
                                <option value="pending_pay">Pending Pay</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                                id="close">Close</button>
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="invite_contractor">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Contractor</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="invite_notify"></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Contractor:</label>
                                        <input type="hidden" class="form-control" name="project_id" id="project_id">
                                        <select name="contractor_id" class="form-control" required
                                            oninvalid="this.setCustomValidity('Select any contractor first!')"
                                            oninput="this.setCustomValidity('')">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Price:</label>
                                        <input class="form-control" type="number" step="0.1" name="price"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Message:</label>
                                        <textarea class="form-control" type="text" name="message" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Send</button>
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
                                    <h4 class="card-title">Projects</h4>
                                </div>
                                <div class="col-md-6 text-end"><a href="{{ route('project:create') }}"
                                        class="btn btn-primary">Add New Project</a></div>
                            </div>
                            <div class="table-responsive">
                                <table id="project-table" class="table table-striped" data-toggle="data-table">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase">Project Name</th>
                                            <th class="text-uppercase">Type</th>
                                            <th class="text-uppercase">Cost</th>
                                            <th class="text-uppercase">Remaining Price</th>
                                            <th class="text-uppercase">Date</th>
                                            <th class="text-uppercase">Status</th>
                                            <th class="text-uppercase">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($projects as $project)
                                            <tr>
                                                <td>{{ $project->name }}</td>
                                                <td> {{ $project->type ?? '-' }} </td>
                                                @if (session()->get('type') != 'contractor')
                                                    <td>€{{ $project->cost ?? 0 }}</td>
                                                    <td>€{{ $project->remaining_amount ?? 0 }}
                                                    </td>
                                                @else
                                                    <td>€{{ $project->invitation_price ?? 0 }}</td>
                                                    <td>€{{ $project->contractor_remaining_amount ?? 0 }}
                                                    </td>
                                                @endif
                                                <td>{{ changeDateFormatToUS($project->project_date) }}</td>
                                                <td>
                                                    {{ ucwords(str_replace('_', ' ', $project->status ?? '')) }}
                                                </td>
                                                <td>
                                                    @if (session()->get('type') != 'contractor')
                                                        <button type="button" data-id="{{ $project->project_id }}"
                                                            class="btn btn-sm btn-icon btn-primary px-2"
                                                            data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                            id="share">
                                                            <i class="fas fa-share"></i>
                                                        </button>
                                                    @endif
                                                    <a class="btn btn-sm btn-icon btn-success"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="View" target="_blank"
                                                        href="{{ route('project:view', $project->project_id) }}">
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
                                                                    r="1.5" fill="white">
                                                                </circle>
                                                            </svg>
                                                        </span>
                                                    </a>
                                                    <a class="btn btn-sm btn-icon btn-info"
                                                        style="height: 30px;"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Event Details" target="_blank"
                                                        href="{{ route('project:event-details', $project->project_id) }}">
                                                        <span class="btn-inner">
                                                            <svg class="icon-32" viewBox="0 0 24 24" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M8.9 2H15.07C17.78 2 19.97 3.07 20 5.79V20.97C20 21.14 19.96 21.31 19.88 21.46C19.75 21.7 19.53 21.88 19.26 21.96C19 22.04 18.71 22 18.47 21.86L11.99 18.62L5.5 21.86C5.351 21.939 5.18 21.99 5.01 21.99C4.45 21.99 4 21.53 4 20.97V5.79C4 3.07 6.2 2 8.9 2ZM8.22 9.62H15.75C16.18 9.62 16.53 9.269 16.53 8.83C16.53 8.39 16.18 8.04 15.75 8.04H8.22C7.79 8.04 7.44 8.39 7.44 8.83C7.44 9.269 7.79 9.62 8.22 9.62Z"
                                                                    fill="currentColor"></path>
                                                            </svg>
                                                        </span>
                                                    </a>


                                                    @if (session()->get('type') == 'admin')
                                                        <a class="btn btn-sm btn-icon btn-warning"
                                                            href="{{ route('project:edit', $project->project_id) }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Edit" data-original-title="Edit" href="#">
                                                            <span class="btn-inner">
                                                                <svg class="icon-20" width="20"
                                                                    viewBox="0 0 24 24" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341"
                                                                        stroke="currentColor" stroke-width="1.5"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round">
                                                                    </path>
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z"
                                                                        stroke="currentColor" stroke-width="1.5"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round">
                                                                    </path>
                                                                    <path d="M15.1655 4.60254L19.7315 9.16854"
                                                                        stroke="currentColor" stroke-width="1.5"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round">
                                                                    </path>
                                                                </svg>
                                                            </span>
                                                        </a>
                                                        <button type="button"
                                                            class="btn btn-primary btn-sm change_status py-1 px-2"
                                                            data-bs-toggle="modal" data-bs-target="#exampleModal1"
                                                            data-id="{{ $project->project_id }}">
                                                            <i class="fas fa-exclamation-triangle"></i>
                                                        </button>
                                                        <a class="btn btn-sm btn-icon btn-danger show_confirm"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Delete" href="#"
                                                            data-id="{{ $project->project_id }}">
                                                            <span class="btn-inner">
                                                                <svg class="icon-20" width="20"
                                                                    viewBox="0 0 24 24" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    stroke="currentColor">
                                                                    <path
                                                                        d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826"
                                                                        stroke="currentColor" stroke-width="1.5"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round">
                                                                    </path>
                                                                    <path d="M20.708 6.23975H3.75"
                                                                        stroke="currentColor" stroke-width="1.5"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path
                                                                        d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973"
                                                                        stroke="currentColor" stroke-width="1.5"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round">
                                                                    </path>
                                                                </svg>
                                                            </span>
                                                        </a>
                                                    @endif
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

    <script>
        $(document).ready(function() {
            $('#project-table').dataTable({
                destroy: true,
                ordering: false,
                pageLength: 50 // Set the default page length to 50 records per page
            });
            $(document).on("click", "#share", function() {
                var dataId = $(this).attr("data-id");
                $("#project_id").val(dataId);
                $.ajax({
                    url: "{{ route('project:fetch_available_contractors') }}",
                    type: 'POST',
                    data: {
                        project_id: dataId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status == "true") {
                            // console.log(response);
                            var availableContractors = response.contractors;
                            var options = '';
                            options += `<option value="">Select Contractor</option>`;
                            if (availableContractors.length > 0) {
                                availableContractors.forEach(function(contractor) {
                                    options +=
                                        `
                                        <option value="${contractor.user_id}">${contractor.name}</option>`;
                                });
                            } else {
                                options = '<option disabled>No Available Contractors</option>';
                            }
                            $("select[name='contractor_id']").html(options);
                        }
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
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
                            url: "{{ route('project:delete') }}",
                            type: 'delete',
                            cache: false,
                            data: {
                                _token: '{{ csrf_token() }}',
                                'id': code,
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Deleted!',
                                    'Project has been deleted.',
                                    'success'
                                )
                                setTimeout(() => {
                                    window.location = "{{ route('project:list') }}";
                                }, 2000);
                            }
                        })
                    }
                });
        });
    </script>

    <script>
        $(document).ready(function() {
            $(document).on("submit", "#invite_contractor", function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $(".invite_notify").html(
                    `
                                <div class="alert alert-left alert-success alert-dismissible fade show mb-3" role="alert">
                                    <span> Invitation is sending please wait!</span>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                `
                );
                $.ajax({
                    url: "{{ route('invite:store') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status == "true") {
                            $(".invite_notify").html(
                                `
                                <div class="alert alert-left alert-success alert-dismissible fade show mb-3" role="alert">
                                    <span> ` + response.msg + `!</span>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                `
                            ), setTimeout(function() {
                                $(".invite_notify").html(``);
                                $("#invite_contractor")[0].reset();
                                location.reload();
                            }, 2000);
                        }
                        if (response.status == "false") {
                            $(".invite_notify").html(
                                `<div class="alert alert-left alert-danger alert-dismissible fade show mb-3" role="alert">
                                    <span> ` + response.msg + `!</span>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>`), setTimeout(function() {
                                $(".invite_notify").html(``);
                            }, 2000);
                        }
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $(".change_status").click(function() {
                let code = $(this).attr("data-id");
                $.ajax({
                    url: "{{ route('project:find') }}",
                    type: 'post',
                    cache: false,
                    data: {
                        _token: '{{ csrf_token() }}',
                        'id': code
                    },
                    success: function(response) {
                        console.log(response);
                        let project_id = response.project_id;
                        let status = response.status;
                        $("#code").val(project_id);
                        if (status == 1) {
                            $('#status option[value="1"]').prop('selected', true);
                        } else {
                            $('#status option[value="0"]').prop('selected', true);
                        }

                        // Update Status
                        $(document).on("submit", "#project_status", function(e) {
                            e.preventDefault();
                            let formData = new FormData(this);
                            $.ajax({
                                url: "{{ route('project:update_status') }}",
                                type: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(response) {
                                    console.log(response);
                                    if (response.status == "true") {
                                        $('#close').trigger('click');
                                        Swal.fire(
                                            'Good job!',
                                            'You Status Updated Successfully!',
                                            'success',
                                            'Done'
                                        )
                                        setTimeout(() => {
                                            window.location =
                                                "{{ route('project:list') }}";
                                        }, 2000);
                                    }
                                    if (response.status == "false") {
                                        $('#close').trigger('click');
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Something went wrong!',
                                        });
                                        setTimeout(() => {
                                            window.location =
                                                "{{ route('project:list') }}";
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
