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
                <form id="invitation_status">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Invitation Status</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="code" id="code">
                            <label for="" class="mb-2">Status</label>
                            <select name="status" class="form-control" id="status">
                                <option value="0" id="p">Pending</option>
                                <option value="1" id="a">Rejected</option>
                                <option value="2" id="r">Accepted</option>
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
                                    <h4 class="card-title">Invitation Lists</h4>
                                </div>
                                {{-- <div class="col-md-6 text-end"><a href="{{ route('invite:list') }}"
                                        class="btn btn-primary">Request Invite</a></div> --}}
                            </div>
                            <div class="table-responsive">
                                <table id="invitation-table" class="table table-striped" data-toggle="data-table">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase">Project</th>
                                            <th class="text-uppercase">Contractor</th>
                                            <th class="text-uppercase">Invited By</th>
                                            <th class="text-uppercase">Invited At</th>
                                            <th class="text-uppercase">Status</th>
                                            <th class="text-uppercase">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($invitation as $invite)
                                            @if ($invite->contractor)
                                                <tr>
                                                    <td>{{ Str::title($invite->project->name) }}</td>
                                                    <td>{{ isset($invite->contractor) ? Str::title($invite->contractor->name) : '' }}
                                                    </td>
                                                    <td>{{ Str::title($invite->invitedBy->name) }}</td>
                                                    <td>
                                                        {{ changeDateFormatToUS($invite->created_at) ?? '-' }}
                                                    </td>
                                                    <td>
                                                        @if ($invite->status == 0)
                                                            <span class="badge bg-secondary">Pending</span>
                                                        @elseif($invite->status == 1)
                                                            <span class="badge bg-danger">Rejected</span>
                                                        @elseif($invite->status == 2)
                                                            <span class="badge bg-success">Approved</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-sm btn-icon btn-success"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="View" target="_blank"
                                                            href="{{ route('invite:view', $invite->invitation_id) }}">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        @if ($invite->status == 0)
                                                            <button type="button"
                                                                class="btn btn-sm btn-icon btn-primary change_status"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Change Status"
                                                                data-id="{{ $invite->invitation_id }}">
                                                                <i class="fas fa-exclamation-triangle"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModal"></i>
                                                            </button>
                                                        @endif
                                                        @if ($invite->status != 2)
                                                            <button type="button"
                                                                class="btn btn-sm btn-icon btn-danger text-white remove_invitation_"
                                                                data-id="{{ $invite->invitation_id }}">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
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
    <!-- Modal -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#invitation-table').dataTable({
                destroy: true,
                pageLength: 50,
                ordering: false
            });
            $(".change_status").click(function() {
                let code = $(this).attr("data-id");
                $.ajax({
                    url: "{{ route('invite:find') }}",
                    type: 'post',
                    cache: false,
                    data: {
                        _token: '{{ csrf_token() }}',
                        'id': code
                    },
                    success: function(response) {
                        let invitation_id = response.invitation_id;
                        let status = response.status;
                        $("#code").val(invitation_id);
                        if (status == 1) {
                            $('#status option[value="1"]').prop('selected', true);
                        } else if (status == 2) {
                            $('#status option[value="2"]').prop('selected', true);
                        } else {
                            $('#status option[value="0"]').prop('selected', true);
                        }

                        // Update Status
                        $(document).on("submit", "#invitation_status", function(e) {
                            e.preventDefault();
                            let formData = new FormData(this);
                            $.ajax({
                                url: "{{ route('invite:update_status') }}",
                                type: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(response) {
                                    if (response.status == "true") {
                                        $('#exampleModal').modal('toggle');
                                        Swal.fire(
                                            'Good job!',
                                            'You Status Updated Successfully!',
                                            'success',
                                            'Done'
                                        )
                                        setTimeout(() => {
                                            window.location =
                                                "{{ route('invite:list') }}";
                                        }, 2000);
                                    }
                                    if (response.status == "false") {
                                        $('#exampleModal').modal('toggle');
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Something went wrong!',
                                        });
                                        setTimeout(() => {
                                            window.location =
                                                "{{ route('invite:list') }}";
                                        }, 2000);
                                    }
                                }
                            });
                        });
                    }
                })
            });
            $(document).on("click", ".remove_invitation_", function(event) {
                //$(this).closest("tr").remove();
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
                            var dataId = $(this).attr("data-id");
                            $.ajax({
                                url: "{{ route('project:delete_invitation') }}",
                                type: 'delete',
                                cache: false,
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    'id': dataId,
                                },
                                success: function(response) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Invitation has been deleted.',
                                        'success'
                                    );
                                    location.reload();
                                }
                            })
                        }
                    });
            });
        });
    </script>
