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
                                </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td>{{ $project->name }}</td>
                                        <td> {{ $project->type ?? '-' }} </td>
                                        @if (session()->get('type') != 'contractor')
                                            <td>${{ $project->cost ?? 0 }}</td>
                                            <td>${{ $project->remaining_amount ?? 0 }}
                                            </td>
                                        @else
                                            <td>${{ $project->invitation_price ?? 0 }}</td>
                                            <td>${{ $project->contractor_remaining_amount ?? 0 }}
                                            </td>
                                        @endif
                                        <td>{{ changeDateFormatToUS($project->project_date) }}</td>
                                        <td>
                                            {{ ucwords(str_replace('_', ' ', $project->status ?? '')) }}
                                        </td>

                                    </tr>
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
