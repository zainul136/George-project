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

                        <div class="card">
                            <div class="card-body">
                                <div class="new-contractor-info">
                                    <div class="row">
                                        <div class="row mb-2">
                                            <div class="col-md-6 text-start">
                                                <h4 class="card-title">View Contractor Information</h4>
                                            </div>
                                            <div class="col-md-6 text-end"><a href="{{ route('contractor:list') }}"
                                                    class="btn btn-primary">Back</a></div>
                                        </div>

                                        <div class="card-header d-flex justify-content-center">
                                            <div class="card-body px-0">
                                                <div class="row justify-content-center">
                                                    <div class="col-md-2 justify-content-center">
                                                        <div class="mb-2">
                                                            <div>
                                                                <img class="w-100"
                                                                    src="{{ isset($contractor->image) && !empty($contractor->image) ? asset('project_images/contractor/') . '/' . $contractor->image : asset('admin/images/avatars/blank.jpg') }}"
                                                                    alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row gy-3 mt-3 pt-75">
                                                    <div class="col-12 col-md-4">
                                                        <label class="form-label" for="jobTitle">Name</label>
                                                        <div class="fw-bolder">{{ $contractor->name ?? '' }}</div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <label class="form-label" for="jobType">Email</label>
                                                        <div class="fw-bolder">{{ $contractor->email ?? '' }}</div>
                                                    </div>
                                                    <div class="col-4">
                                                        <label class="form-label" for="jobPlace">Contact</label>
                                                        <div class="fw-bolder">{{ $contractor->contact ?? '' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <label class="form-label" for="jobPlace">Date Of
                                                            Birth</label>
                                                        <div class="fw-bolder">
                                                            {{ changeDateFormatToUS($contractor->dob) ?? '' }}
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-4">
                                                        <label class="form-label" for="location">Status</label>
                                                        <div class="fw-bolder">
                                                            {{ $contractor->status == 1 ? 'Active' : 'Deactivate' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <p class="m-0 p-0">
                                                            <label class="form-label" for="location">Projects</label>

                                                        </p>
                                                        @if (count($projects) > 0)

                                                            @foreach ($projects as $project)
                                                                <span
                                                                    class="fw-bolder">{{ $project->name ?? '' }}</span>
                                                            @endforeach
                                                        @else
                                                            <p class="fw-bolder">Project Not Available</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <div class="header-title">
                                    <h4 class="card-title">Projects</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-striped" data-toggle="data-table">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase">Project</th>
                                                <th class="text-uppercase">Type</th>
                                                @if (session()->get('type') != 'contractor')
                                                    <th class="text-uppercase">Contractor Payment</th>
                                                    <th class="text-uppercase">Remaining Payment</th>
                                                @endif
                                                <th class="text-uppercase">Date</th>
                                                <th class="text-uppercase">Status</th>
                                                <th class="text-uppercase">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($projects as $project)
                                                <tr>
                                                    <td>{{ $project->name }}</td>
                                                    <td>{{ $project->type }}</td>
                                                    @if (session()->get('type') != 'contractor')
                                                        <td>€{{ $project->contractor_payment ?? 0 }} </td>
                                                        <td>€{{ $project->remaining_amount ?? 0 }}</td>
                                                    @endif
                                                    <td>{{ changeDateFormatToUS($project->project_date) }}</td>
                                                    <td>
                                                        {{ ucwords(str_replace('_', ' ', $project->status ?? '')) }}
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-sm btn-icon btn-success"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="View" target="_blank"
                                                            href="{{ route('project:view', $project->project_id) }}">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        @if (session()->get('type') != 'contractor')
                                                            <a class="btn btn-sm btn-icon btn-success"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#addContractorPaymentModal"id="contractor_payment"
                                                                project-id="{{ $project->project_id }}"
                                                                contractor-id="{{ $contractor->id }}" target="_blank"
                                                                href="javascript:void();">
                                                                <i class="fa fa-dollar-sign p-1"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Add Payment"></i>
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
                        @if (session()->get('type') != 'contractor')
                            <div class="card">
                                <div class="card-header">
                                    <div class="header-title">
                                        <h4 class="card-title">Payment Logs</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        @if ($projects)
                                            @foreach ($projects as $project)
                                                <h5>Project {{ $project->name }}:</h5>
                                                <br>
                                                @if (!empty($contractorLogs[$project->project_id]))
                                                    <table id="contractor_payment_logs" class="table table-striped"
                                                        data-toggle="data-table">
                                                        <thead>
                                                            <tr>
                                                                <th>Payment</th>
                                                                <th>Remaining Payment</th>
                                                                <th>Payment Type</th>
                                                                <th>Message</th>
                                                                <th>Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($contractorLogs[$project->project_id] as $log)
                                                                <tr>
                                                                    <td>€{{ $log->payment }}</td>
                                                                    <td>€{{ $log->remaining_payment }}</td>
                                                                    <td>{{ ucwords(str_replace('_', ' ', $log->payment_type)) ?? '' }}
                                                                    <td>{{ $log->message ?? '' }}</td>
                                                                    <td>{{ changeDateFormatToUS($log->date) }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                @else
                                                    <p>No payment history for this project.</p>
                                                @endif
                                            @endforeach
                                        @else
                                            <p>No projects available.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addContractorPaymentModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form id="project_payment">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Contractor Project Payment</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="project_notify"></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Amount:</label>
                                        <input type="hidden" name="project_id" id="project_id">
                                        <input type="hidden" name="contractor_id" id="contractor_id">
                                        <input class="form-control" type="number" step="0.1" name="payment"
                                            required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label mb-0 text-end">Date</label>
                                        <input type="date" class="form-control form-contol-sm"
                                            id="modal_action_date" name="date" required />
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label mb-0 text-end">Payment Type</label>
                                        <select name="payment_type" class="selectpicker form-control" required
                                            oninvalid="this.setCustomValidity('Select any Payment Type first!')"
                                            oninput="this.setCustomValidity('')" data-style="py-0">
                                            <option value="" selected="selected">Select Payment Type
                                            </option>
                                            <option value="cash">Cash</option>
                                            <option value="cheque"> Cheque </option>
                                            <option value="bank_transfer"> Bank Transfer</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Message:</label>
                                        <textarea class="form-control" type="text" name="message"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Footer Section Start -->
        @include('admin.layouts.footer')
        <!-- Footer Section End -->
    </main>
    <!-- Wrapper End-->
    <!-- offcanvas start -->

    @include('admin.layouts.script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#contractor_payment_logs').dataTable({
                destroy: true,
                pageLength: 10,
                ordering: false
            });

            $(".multiple_select_projects").select2({
                placeholder: 'Select Employees',
                maximumSelectionLength: 200
            });
        });


        $(document).ready(function() {
            $("#contractor_payment").click(function() {
                var project_id = $(this).attr("project-id");
                var contractor_id = $(this).attr("contractor-id");
                console.log(project_id, contractor_id);
                $("#project_id").val(project_id);
                $("#contractor_id").val(contractor_id);
            });

            $(document).on("submit", "#project_payment", function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    url: "{{ route('contractor:add_payment') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status == true) {
                            $(".project_notify").html(
                                `
                            <div class="alert alert-left alert-success alert-dismissible fade show mb-3" role="alert">
                                <span> ` + response.message + `!</span>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            `
                            ), setTimeout(function() {
                                $(".project_notify").html(``);
                                location.reload();
                            }, 2000);
                        }
                        if (response.status == false) {
                            $(".project_notify").html(
                                `<div class="alert alert-left alert-danger alert-dismissible fade show mb-3" role="alert">
                                <span> ` + response.message + `!</span>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`), setTimeout(function() {
                                $(".project_notify").html(``);
                            }, 2000);
                        }
                    }
                });
            });
        });
    </script>
