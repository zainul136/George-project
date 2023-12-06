@include('admin.layouts.head')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

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
                                        <input class="form-control" type="integer" step="0.1" name="price"
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
        <div class="modal fade" id="addPaymentModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form id="project_payment">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Project Payment</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="payment_project_notify"></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Amount:</label>
                                        <input type="hidden" name="project_id" id="project_id2">
                                        <input class="form-control" type="number" step="0.1" name="price"
                                            required>
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
                                            <option value="credit_card"> Credit Card </option>
                                            <option value="bank_transfer"> Bank Transfer</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label mb-0 text-end">Date</label>
                                        <input type="date" class="form-control form-contol-sm"
                                            id="modal_action_date" name="date" required />
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
                        {{-- Start Project Form --}}
                        <div class="card">
                            <div class="card-body">
                                <div class="new-project-info">
                                    <div class="row mb-2">
                                        <div class="col-md-6 text-start">
                                            <h4 class="card-title">View Project Information</h4>
                                        </div>
                                        <div class="col-md-6 text-end">
                                            <a href="{{ route('project:list') }}" class="btn btn-primary">Back</a>
                                        </div>
                                    </div>

                                    <div class="card-header d-flex justify-content-center">
                                        <div class="card-body px-0">
                                            <div class="row gy-3 pt-75">
                                                <div class="col-12 col-md-4">
                                                    <label class="form-label" for="jobTitle">Name</label>
                                                    <div class="fw-bolder">{{ $project->name ?? '' }}</div>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <label class="form-label" for="jobType">Type</label>
                                                    <div class="fw-bolder">{{ $project->type ?? '' }}</div>
                                                </div>
                                                <div class="col-4">
                                                    <label class="form-label" for="jobPlace">Date</label>
                                                    <div class="fw-bolder">
                                                        {{ changeDateFormatToUS($project->project_date) ?? '' }}
                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <label class="form-label" for="jobPlace">Employees</label>
                                                    @if (count($employees) > 0)
                                                        @php
                                                            $selectedemployees = [];
                                                        @endphp

                                                        @if (isset($employees) && !empty($employees))
                                                            @foreach ($employees as $key => $value)
                                                                @php
                                                                    $selectedemployees[] = $value->name;
                                                                @endphp
                                                            @endforeach

                                                        @endif
                                                        @if (count($selectedemployees) > 0)
                                                            <p class="fw-bolder">
                                                                {{ implode(', ', $selectedemployees) }}</p>
                                                        @else
                                                            <p>No Employees Selected</p>
                                                        @endif
                                                    @else
                                                        <p>Employees Not Available</p>
                                                    @endif
                                                </div>
                                                {{-- <div class="col-4">
                                                    <label class="form-label" for="jobPlace">Contractors</label>
                                                    @if (count($contractors) > 0)
                                                        @php
                                                            $selectedContractors = [];
                                                        @endphp

                                                        @if (isset($contractors) && !empty($contractors))
                                                            @foreach ($contractors as $key => $value)
                                                                @php
                                                                    $selectedContractors[] = $value->name;
                                                                @endphp
                                                            @endforeach

                                                        @endif
                                                        @if (count($selectedContractors) > 0)
                                                            <p class="fw-bolder">
                                                                {{ implode(', ', $selectedContractors) }}</p>
                                                        @else
                                                            <p>No Contractors Selected</p>
                                                        @endif
                                                    @else
                                                        <p>Contractor Not Available</p>
                                                    @endif

                                                </div> --}}
                                                <div class="col-12 col-md-4">
                                                    <label class="form-label" for="location">Company</label>
                                                    <div class="fw-bolder">
                                                        {{ $project->company_name ?? '-' }}
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <label class="form-label" for="jobPlace">Client</label>
                                                    <p class="fw-bolder"> {{ $client->name ?? '-' }}
                                                    </p>
                                                </div>

                                                <div class="col-12 col-md-4">
                                                    <label class="form-label" for="location">Status</label>
                                                    <div class="fw-bolder">
                                                        {{ $project->status == 1 ? 'Active' : 'Deactivate' }}
                                                    </div>
                                                </div>
                                                @if (session()->get('type') != 'contractor')
                                                    <div class="col-12 col-md-4">
                                                        <label class="form-label" for="jobPlace">Cost
                                                        </label>
                                                        <div class="fw-bolder">€{{ $project->cost ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <label class="form-label" for="jobPlace">Remaining Amount
                                                        </label>
                                                        <div class="fw-bolder">
                                                            ${{ $project->cost - ($remaining_amount ?? 0) > 0 ? $project->cost - ($remaining_amount ?? 0) : 0 }}
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="col-12">
                                                    <label class="form-label" for="jobPlace">Details
                                                    </label>
                                                    <div class="fw-bolder">{{ $project->project_details ?? '-' }}
                                                    </div>
                                                </div>
                                                @if ($project->type == 'Wedding and Engagement')
                                                    <div class="col-12">
                                                        <h4>Wedding and Engagement
                                                        </h4>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Date:
                                                        </label>
                                                        <div class="fw-bolder">{{ $data->we_date ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Location
                                                            :
                                                        </label>
                                                        <div class="fw-bolder">{{ $data->we_location ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Church:
                                                        </label>
                                                        <div class="fw-bolder">{{ $data->we_church ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Church Time:
                                                        </label>
                                                        <div class="fw-bolder">{{ $data->we_church_time ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Xetetisi:
                                                        </label>
                                                        <div class="fw-bolder">{{ $data->we_xetetisi ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Xetetisi Time:
                                                        </label>
                                                        <div class="fw-bolder">{{ $data->we_xetetisi_time ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Reception:
                                                        </label>
                                                        <div class="fw-bolder">{{ $data->we_reception ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Reception Time:
                                                        </label>
                                                        <div class="fw-bolder">{{ $data->we_reception_time ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Groom Name:
                                                        </label>
                                                        <div class="fw-bolder">{{ $data->we_groom_name ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Groom Phone:
                                                        </label>
                                                        <div class="fw-bolder">{{ $data->we_groom_phone ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Bride Name:
                                                        </label>
                                                        <div class="fw-bolder">{{ $data->we_bride_name ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Bride Phone:
                                                        </label>
                                                        <div class="fw-bolder">{{ $data->we_bride_phone ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Email:
                                                        </label>
                                                        <div class="fw-bolder">{{ $data->we_email ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-6"></div>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Zomato
                                                            Groom:
                                                        </label>
                                                        <div class="fw-bolder">
                                                            @if ($data->we_zomato_groom == 1)
                                                                YES
                                                            @else
                                                                NO
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Time:
                                                        </label>
                                                        <div class="fw-bolder">
                                                            {{ $data->we_zomato_groom_time ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Groom
                                                            Home:

                                                        </label>
                                                        <div class="fw-bolder">
                                                            {{ $data->we_zomato_groom_home ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Other
                                                            Info:
                                                        </label>
                                                        <div class="fw-bolder">
                                                            {{ $data->we_zomato_groom_info ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Zomato
                                                            Bride:
                                                        </label>
                                                        <div class="fw-bolder">
                                                            @if ($data->we_zomato_bride == 1)
                                                                YES
                                                            @else
                                                                NO
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Time:
                                                        </label>
                                                        <div class="fw-bolder">
                                                            {{ $data->we_zomato_bride_time ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Bride
                                                            Home:
                                                        </label>
                                                        <div class="fw-bolder">
                                                            {{ $data->we_zomato_bride_home ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Other
                                                            Info:
                                                        </label>
                                                        <div class="fw-bolder">
                                                            {{ $data->we_zomato_bride_info ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label" for="jobPlace">Details
                                                            :
                                                        </label>
                                                        <div class="fw-bolder">{{ $data->we_details ?? '-' }}
                                                        </div>
                                                    </div>
                                                @endif
                                                <br>

                                                @if ($project->type == 'Christening')
                                                    <div class="col-12">
                                                        <h4>Christening</h4>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Date:
                                                        </label>
                                                        <div class="fw-bolder">{{ $data->c_date ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Location:
                                                        </label>
                                                        <div class="fw-bolder">{{ $data->c_location ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Church:
                                                        </label>
                                                        <div class="fw-bolder">{{ $data->c_church ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Time:
                                                        </label>
                                                        <div class="fw-bolder">{{ $data->c_church_time ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Reception / Party:
                                                        </label>
                                                        <div class="fw-bolder">{{ $data->c_reception ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Time:
                                                        </label>
                                                        <div class="fw-bolder">{{ $data->c_reception_time ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Baby Name:
                                                        </label>
                                                        <div class="fw-bolder">{{ $data->c_baby_name ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Birth Date:
                                                        </label>
                                                        <div class="fw-bolder">{{ $data->c_baby_dob ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Mother Name:
                                                        </label>
                                                        <div class="fw-bolder">{{ $data->c_mother_name ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Phone:
                                                        </label>
                                                        <div class="fw-bolder">{{ $data->c_mother_phone ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Father Name:
                                                        </label>
                                                        <div class="fw-bolder">{{ $data->c_father_name ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Phone:
                                                        </label>
                                                        <div class="fw-bolder">{{ $data->c_father_phone ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Email:
                                                        </label>
                                                        <div class="fw-bolder">{{ $data->c_email ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Zomato
                                                            Groom:
                                                        </label>
                                                        <div class="fw-bolder">
                                                            @if ($data->c_zomato_baby == 1)
                                                                YES
                                                            @else
                                                                NO
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Time:
                                                        </label>
                                                        <div class="fw-bolder">
                                                            {{ $data->c_zomato_baby_time ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label" for="jobPlace">Details:
                                                        </label>
                                                        <div class="fw-bolder">
                                                            {{ $data->c_details ?? '-' }}
                                                        </div>
                                                    </div>
                                                @endif
                                                <br><br> <br><br>
                                                <div class="col-md-6">
                                                    <h4 class="">Events
                                                    </h4>
                                                </div>
                                                <div class="col-md-6">
                                                    @if (session()->get('type') != 'contractor')
                                                        <button type="button" id="view_event_"
                                                            class="btn btn-sm btn-dark " style="float: right;">
                                                            Add Event
                                                        </button>
                                                    @endif

                                                    <a target="_blank"
                                                        href="{{ route('project:event-details', $project->project_id) }}">
                                                        <button type="button" id="todo"
                                                            class="btn btn-sm btn-primary"
                                                            style="float: right;margin-right:20px">
                                                            View Todo
                                                        </button>
                                                    </a>
                                                </div>
                                                <div class="col-md-12">
                                                    <table class="table table-border table-striped event_table">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 50%">Action</th>
                                                                <th style="width: 50%">Date</th>
                                                                <th style="width: 50%">Status</th>
                                                                @if (session()->get('type') == 'admin')
                                                                    <th style="width: 10%">Action</th>
                                                                @endif
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if (!is_null($events))
                                                                @foreach ($events as $event)
                                                                    <tr>
                                                                        <td>{{ $event->action }}</td>
                                                                        <td>{{ changeDateFormatToUS($event->action_date) }}
                                                                        </td>
                                                                        <td>{{ $event->status }}</td>
                                                                        @if (session()->get('type') == 'admin')
                                                                            <td>
                                                                                <a href="javascript:void(0)"
                                                                                    class="text-danger remove_event_row_"
                                                                                    data-id="{{ $event->id }}">
                                                                                    <i class="fa fa-trash"></i>
                                                                                </a>
                                                                                <a href="javascript:void(0)"
                                                                                    class="text-primary edit_event_"
                                                                                    data-id="{{ $event->id }}">
                                                                                    <i class="fa fa-edit"></i>
                                                                                </a>
                                                                            </td>
                                                                        @endif

                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <br><br> <br><br>
                                                <div class="col-md-6">
                                                    <h4>Invitation List
                                                    </h4>
                                                </div>
                                                <div class="col-md-6">
                                                    @if (session()->get('type') != 'contractor')
                                                        <button type="button" style="float:right"
                                                            data-id="{{ $project->project_id }}"
                                                            class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                            data-bs-target="#exampleModal" id="share">
                                                            Invite Contractor
                                                        </button>
                                                    @endif
                                                </div>
                                                <div class="col-12">
                                                    <table class="table table-border table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Contractor</th>
                                                                @if (session()->get('type') != 'contractor')
                                                                    <th>Price</th>
                                                                    <th>Status</th>
                                                                    <th> Actions </th>
                                                                @endif
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if (!is_null($invitation))
                                                                @foreach ($invitation as $invite)
                                                                    @if (session()->get('type') != 'contractor')
                                                                        <tr>
                                                                            <td>{{ $invite->contractor_name }}</td>
                                                                            <td>€{{ $invite->price ?? 0 }}</td>
                                                                            <td>
                                                                                @if ($invite->status == 0)
                                                                                    <span
                                                                                        class="badge bg-secondary">Pending</span>
                                                                                @elseif($invite->status == 1)
                                                                                    <span
                                                                                        class="badge bg-danger">Rejected</span>
                                                                                @elseif($invite->status == 2)
                                                                                    <span
                                                                                        class="badge bg-success">Approved</span>
                                                                                @endif
                                                                            </td>
                                                                            <td>
                                                                                @if ($invite->status != 2)
                                                                                    <a href="javascript:void(0)"
                                                                                        class="text-danger remove_invitation_"
                                                                                        data-id="{{ $invite->invitation_id }}">
                                                                                        <i class="fa fa-trash"></i>
                                                                                    </a>
                                                                                @else
                                                                                    No Action Available!
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    @else
                                                                        @if ($invite->status == 2)
                                                                            <tr>
                                                                                <td>{{ $invite->contractor_name }}</td>

                                                                            </tr>
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <br><br> <br><br>
                                                @if (session()->get('type') != 'contractor')
                                                    <div class="col-md-6">
                                                        <h4>Paid Amount
                                                        </h4>
                                                    </div>
                                                    <div class="col-md-6">
                                                        @if (session()->get('type') != 'contractor')
                                                            <button type="button" style="float: right"
                                                                data-id="{{ $project->project_id }}"
                                                                class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                                data-bs-target="#addPaymentModal" id="addPayment">
                                                                Add Payment
                                                            </button>
                                                        @endif
                                                    </div>
                                                    <div class="col-12">
                                                        <table class="table table-border table-striped"
                                                            id="project_payment_logs">
                                                            <thead>
                                                                <tr>
                                                                    <th>Price</th>
                                                                    <th>Remaining Price</th>
                                                                    <th>Payment Type</th>
                                                                    <th>Message</th>
                                                                    <th>Date</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if (!is_null($payments))
                                                                    @foreach ($payments as $payment)
                                                                        <tr>
                                                                            <td>€{{ $payment->price ?? 0 }}</td>
                                                                            <td>€{{ $payment->remaining_price ?? 0 }}
                                                                            </td>
                                                                            <td>{{ ucwords(str_replace('_', ' ', $payment->payment_type)) ?? '' }}
                                                                            <td>{{ $payment->message ?? '' }}</td>
                                                                            <td>
                                                                                {{ changeDateFormatToUS($payment->created_at) ?? '-' }}
                                                                            </td>
                                                                            <td>
                                                                                <a href="javascript:void(0)"
                                                                                    class="text-danger remove_paid_payment_"
                                                                                    data-id="{{ $payment->project_payment_id }}">
                                                                                    <i class="fa fa-trash"></i>
                                                                                </a>

                                                                            </td>

                                                                        </tr>
                                                                    @endforeach

                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @else
                                                    <div class="col-md-6">
                                                        <h4>Project Paid Amount
                                                        </h4>
                                                    </div>
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
                                                            @foreach ($contractor_payment_logs as $log)
                                                                <tr>
                                                                    <td>€{{ $log->payment }}</td>
                                                                    <td>€{{ $log->remaining_payment }}
                                                                    </td>
                                                                    <td>{{ ucwords(str_replace('_', ' ', $log->payment_type)) ?? '' }}
                                                                    <td>{{ $log->message ?? '' }}</td>
                                                                    <td>{{ changeDateFormatToUS($log->date) }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
    <!-- Wrapper End-->
    <div class="modal fade" id="viewEventModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                {{-- <form action="javascript:void(0)" method="post" id="saveNewEvent" data-parsley-validate
                    enctype="multipart/form-data"> --}}
                <form id="add_event">
                    @csrf
                    <div class="modal-body">
                        <div class="container-fluid">

                            <h3>Add Event</h3>
                            <hr />
                            <div class="add_event_notify"></div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input type="hidden" name="project_id" value="{{ $project->project_id }}">
                                        <label class="control-label mb-0 text-end">Action</label>
                                        <input type="text" class="form-control form-contol-sm"
                                            id="modal_action_name" name="act_name" required />
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label mb-0 text-end">Date</label>
                                        <input type="date" class="form-control form-contol-sm"
                                            id="modal_action_date" name="act_date" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Status:</label>
                                    <select name="status" class=" form-control" data-style="py-0">
                                        <option value="pending">pending</option>
                                        <option value="in-progress">in progress</option>
                                        <option value="complete">completed</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-primary">Add Event</button>
                        <button type="button" class="btn btn-sm btn-secondary"
                            data-bs-dismiss="modal">Cancel</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="viewEditEventModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                {{-- <form action="javascript:void(0)" method="post" id="saveNewEvent" data-parsley-validate
                enctype="multipart/form-data"> --}}
                <form id="edit_event">
                    @csrf
                    <div class="modal-body">
                        <div class="container-fluid">

                            <h3>Edit Event</h3>
                            <hr />
                            <div class="edit_event_notify"></div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input type="hidden" name="event_id" class="event_id">
                                        <input type="hidden" name="project_id" value="{{ $project->project_id }}">
                                        <label class="control-label mb-0 text-end">Action</label>
                                        <input type="text" class="form-control form-contol-sm act_name"
                                            id="modal_action_name" name="act_name" required />
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label mb-0 text-end">Date</label>
                                        <input type="date" class="form-control form-contol-sm act_date"
                                            id="modal_action_date" name="act_date" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Status:</label>
                                    <select name="status" class=" form-control status" data-style="py-0">
                                        <option value="pending">Pending</option>
                                        <option value="in-progress">In Progress</option>
                                        <option value="complete">Complete</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-primary">Update Event</button>
                        <button type="button" class="btn btn-sm btn-secondary"
                            data-bs-dismiss="modal">Cancel</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    @include('admin.layouts.script')
    <script>
        $(document).ready(function() {
            $('#project_payment_logs').dataTable({
                destroy: true,
                pageLength: 10,
                ordering: false
            });

            $('.event_table').dataTable({
                destroy: true,
                pageLength: 10,
                ordering: false
            })

            $('#contractor_payment_logs').dataTable({
                destroy: true,
                pageLength: 10,
                ordering: false
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
            $('#view_event_').click(function() {
                $('#viewEventModal').modal('show')
            })
            $('.edit_event_').click(function() {
                var event_id = $(this).attr('data-id');
                var modal = $('#viewEditEventModal');
                $.ajax({
                    url: "{{ route('Event:find') }}",
                    type: 'POST',
                    cache: false,
                    data: {
                        _token: '{{ csrf_token() }}',
                        'id': event_id,
                    },
                    success: function(response) {
                        console.log(response);
                        modal.find('.event_id').val(response.id);
                        modal.find('.act_name').val(response.action);
                        modal.find('.act_date').val(response.action_date);
                        var statusSelect = modal.find('select.status option[value="' +
                            response.status + '"]');
                        statusSelect.prop('selected', true);
                    }
                });
                $('#viewEditEventModal').modal('show')
            })

            $(document).on("submit", "#add_event", function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    url: "{{ route('project:add_event') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status == "true") {
                            $(".add_event_notify").html(
                                `
                            <div class="alert alert-left alert-success alert-dismissible fade show mb-3" role="alert">
                                <span> ` + response.msg + `!</span>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            `
                            ), setTimeout(function() {
                                $(".add_event_notify").html(``);
                                $("#add_event")[0].reset();
                                location.reload();
                            }, 2000);
                        }
                        if (response.status == "false") {
                            $(".add_event_notify").html(
                                `<div class="alert alert-left alert-danger alert-dismissible fade show mb-3" role="alert">
                                <span> ` + response.msg + `!</span>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`), setTimeout(function() {
                                $(".add_event_notify").html(``);
                            }, 2000);
                        }
                    }
                });
            });
            $(document).on("submit", "#edit_event", function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    url: "{{ route('project:edit_event') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status == "true") {
                            $(".edit_event_notify").html(
                                `
                            <div class="alert alert-left alert-success alert-dismissible fade show mb-3" role="alert">
                                <span> ` + response.msg + `!</span>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            `
                            ), setTimeout(function() {
                                $(".edit_event_notify").html(``);
                                location.reload();
                            }, 2000);
                        }
                        if (response.status == "false") {
                            $(".edit_event_notify").html(
                                `<div class="alert alert-left alert-danger alert-dismissible fade show mb-3" role="alert">
                                <span> ` + response.msg + `!</span>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`), setTimeout(function() {
                                $(".edit_event_notify").html(``);
                            }, 2000);
                        }
                    }
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $(document).on("click", ".remove_event_row_", function(event) {
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
                                url: "{{ route('project:delete_event') }}",
                                type: 'delete',
                                cache: false,
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    'id': dataId,
                                },
                                success: function(response) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Event has been deleted.',
                                        'success'
                                    );
                                    location.reload();
                                }
                            })
                        }
                    });
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

            $(document).on("click", ".remove_paid_payment_", function(event) {
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
                                url: "{{ route('project:delete_payment') }}",
                                type: 'delete',
                                cache: false,
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    'id': dataId,
                                },
                                success: function(response) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Payment has been deleted.',
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

    <script>
        $(document).ready(function() {
            $("#addPayment").click(function() {
                var dataId = $(this).attr("data-id");
                $("#project_id2").val(dataId);
            });

            $(document).on("submit", "#project_payment", function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    url: "{{ route('project:add_payment') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // console.log(response);
                        if (response.status == true) {
                            $(".payment_project_notify").html(
                                `
                                <div class="alert alert-left alert-success alert-dismissible fade show mb-3" role="alert">
                                    <span> ` + response.msg + `!</span>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                `
                            ), setTimeout(function() {
                                $(".payment_project_notify").html(``);
                                $("#project_payment")[0].reset();
                                location.reload();
                            }, 2000);
                        }
                        if (response.status == false) {
                            $(".payment_project_notify").html(
                                `<div class="alert alert-left alert-danger alert-dismissible fade show mb-3" role="alert">
                                    <span> ` + response.msg + `</span>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>`), setTimeout(function() {
                                $(".payment_project_notify").html(``);
                            }, 2000);
                        }
                    }
                });
            });
        });
    </script>
