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
                        <form id="edit_project_form" class="create-project">
                            @csrf
                            {{-- Start Project Form --}}
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="header-title">
                                        <h4 class="card-title">Update Project</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="new-project-info">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="hidden" name="code"
                                                    value="{{ $data->project_id ?? '' }}">
                                                <input type="hidden" id="abc" value="{{ $data->type ?? '' }}">
                                                <div class="form-group">
                                                    <label class="form-label">Project Name:</label>
                                                    <input type="text" class="form-control" name="p_name"
                                                        placeholder="Enter Project Name"
                                                        value="{{ $data->name ?? '' }}">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Cost:</label>
                                                    <input type="number" class="form-control" name="p_cost"
                                                        placeholder="Enter Project Cost"
                                                        value="{{ $data->cost ?? '' }}">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Date:</label>
                                                    <input type="date" class="form-control" name="p_date"
                                                        value="{{ $data->project_date ?? '' }}">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Employees:</label>
                                                    <div class="d-flex">
                                                        <select name="employees[]"
                                                            class="selectpicker form-control multiple_select_employees"
                                                            data-style="py-0" multiple required>
                                                            @if (count($employees) > 0)
                                                                @foreach ($employees as $employee)
                                                                    @if ($employee->status == 1 || in_array($employee->id, explode(',', $data->employees ?? '')))
                                                                        <option
                                                                            value="{{ $employee->id }}"{{ in_array($employee->id, explode(',', $data->employees ?? '')) ? 'selected' : '' }}>
                                                                            {{ $employee->name }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                <option disabled>Employee Not Available</option>
                                                            @endif

                                                        </select>
                                                        <a href="{{ route('employee:create') }}" target="_blank"> <i
                                                                class="fa fa-plus text-primary m-2"
                                                                title="Add Employee"></i></a>
                                                    </div>
                                                </div>
                                                {{-- <div class="form-group">
                                                    <label class="form-label">Contractors:</label>
                                                    <div class="d-flex">
                                                        <select name="contractors[]"
                                                            class="selectpicker form-control multiple_select_contractors"
                                                            data-style="py-0" multiple required>
                                                            @if (count($contractors) > 0)
                                                                @foreach ($contractors as $contractor)
                                                                    @if ($contractor->status == 1 || in_array($contractor->id, explode(',', $data->contractors ?? '')))
                                                                        <option
                                                                            value="{{ $contractor->id }}"{{ in_array($contractor->id, explode(',', $data->contractors ?? '')) ? 'selected' : '' }}>
                                                                            {{ $contractor->name }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                <option disabled>Contractor Not Available</option>
                                                            @endif
                                                        </select>
                                                        <a href="{{ route('contractor:create') }}" target="_blank">
                                                            <i class="fa fa-plus text-primary m-2"
                                                                title="Add Contractor"></i></a>
                                                    </div>
                                                </div> --}}
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Type:</label>
                                                    <select name="p_type" class="selectpicker form-control"
                                                        data-style="py-0" id="type_hide_show">
                                                        <option value="" selected="selected">Select Type
                                                        </option>
                                                        <option value="Wedding and Engagement"
                                                            {{ $data->type == 'Wedding and Engagement' ? 'selected' : '' }}>
                                                            Wedding and Engagement
                                                        </option>
                                                        <option value="Christening"
                                                            {{ $data->type == 'Christening' ? 'selected' : '' }}>
                                                            Christening</option>
                                                        <option value="Events"
                                                            {{ $data->type == 'Events' ? 'selected' : '' }}>
                                                            Events</option>
                                                        <option value="Print"
                                                            {{ $data->type == 'Print' ? 'selected' : '' }}>
                                                            Print</option>
                                                        <option value="Product"
                                                            {{ $data->type == 'Product' ? 'selected' : '' }}>
                                                            Product</option>
                                                        <option value="Studio"
                                                            {{ $data->type == 'Studio' ? 'selected' : '' }}>
                                                            Studio</option>
                                                        <option value="Other"
                                                            {{ $data->type == 'Other (free text)' ? 'selected' : '' }}>
                                                            Other (free text)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Client:</label>
                                                    <select name="p_client" class="selectpicker form-control"
                                                        data-style="py-0">
                                                        <option value="" selected="selected">Select Client
                                                        </option>
                                                        @if (count($clients) > 0)
                                                            @foreach ($clients as $client)
                                                                @if ($client->status == 1 || $client->client_id == $data->client)
                                                                    <option
                                                                        value="{{ $client->client_id }}"{{ $client->client_id == $data->client ? 'selected' : '' }}>
                                                                        {{ $client->name }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <option disabled>Client Not Available</option>
                                                        @endif

                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Company:</label>
                                                    <select name="p_company" class="selectpicker form-control" required
                                                        data-style="py-0">
                                                        <option value="" selected="selected">Select Company
                                                        </option>
                                                        @if (count($companies) > 0)
                                                            @foreach ($companies as $company)
                                                                @if ($company->status == 1 || $company->company_id == $data->company)
                                                                    <option
                                                                        value="{{ $company->company_id }}"{{ $company->company_id == $data->company ? 'selected' : '' }}>
                                                                        {{ $company->name }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <option disabled>Company Not Available</option>
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-sm-12">

                                                            <button type="button" id="add_event_"
                                                                class="btn btn-sm btn-dark mb-1 mt-2"
                                                                style="float: right;">
                                                                Add Event
                                                            </button>

                                                        </div>
                                                    </div>
                                                    <table class="table text-center table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Action</th>
                                                                <th>Status</th>

                                                                <th>Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="events_list_">
                                                            @forelse ($events as $event)
                                                                <tr>
                                                                    <td>
                                                                        <input type="hidden" name="action_name[]"
                                                                            value="{{ $event->action }}" />
                                                                        {{ $event->action }}
                                                                    </td>
                                                                    <td>{{ $event->status }}</td>

                                                                    <td>
                                                                        <input type="hidden" name="action_date[]"
                                                                            value="{{ $event->action_date }}" />
                                                                        {{ $event->action_date }}
                                                                        <a href="javascript:void(0)"
                                                                            class="text-danger remove_event_row_">
                                                                            <i class="fa fa-trash"></i>
                                                                        </a>
                                                                    </td>

                                                                </tr>
                                                            @empty
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="name">Details:</label>
                                                    <textarea name="p_details" id="" cols="30" rows="10" class="form-control">{{ $data->project_details ?? '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="row">
                                            <div class="form-group col-md-12">
                                                <label class="form-label">Status:</label>
                                                <select name="p_status" id="" class="form-control">
                                                    <option value="1"
                                                        {{ $project->status == 1 ? 'selected' : '' }}>Active
                                                    </option>
                                                    <option value="0"
                                                        {{ $project->status == 0 ? 'selected' : '' }}>
                                                        Deactive</option>
                                                </select>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>

                                {{-- End Project Form --}}
                                {{-- ------------------------------------------------------------------------------------------- --}}
                                {{-- Start Wedding and Engajement Form --}}
                                <div id="wedding_and_engajement_form" style="display: none">
                                    <div class="card-header d-flex justify-content-between">
                                        <div class="header-title">
                                            <h4 class="card-title">Wedding and Engagement Form</h4>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="new-user-info">
                                            <div class="add_project_notify"></div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Date:</label>
                                                        <div class="col-sm-8">
                                                            <input type="date" class="form-control" name="we_date"
                                                                value="{{ $project->we_date ?? '' }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Church:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="we_church"
                                                                value="{{ $project->we_church ?? '' }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Xetetisi:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="we_xetetisi"
                                                                value="{{ $project->we_xetetisi ?? '' }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Reception/Party:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="we_reception"
                                                                value="{{ $project->we_reception ?? '' }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Groom
                                                            Name:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="we_groom_name"
                                                                value="{{ $project->we_groom_name ?? '' }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Bride
                                                            Name:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="we_bride_name"
                                                                value="{{ $project->we_bride_name ?? '' }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Email:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="we_email"
                                                                value="{{ $project->we_email ?? '' }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <label
                                                                    class="control-label col-sm-6 align-self-center mb-0 text-end">Zomato
                                                                    Groom:</label>
                                                                <div class="col-sm-6">
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input mt-3"
                                                                            type="checkbox" role="switch"
                                                                            id="switch_1" name="we_zomato_groom"
                                                                            value="{{ $project->we_zomato_groom ?? '' }}" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group row text-center">
                                                                <label
                                                                    class="control-label col-sm-4 align-self-center mb-0 text-end">Time:</label>
                                                                <div class="col-sm-6">
                                                                    <input type="time" class="form-control"
                                                                        name="we_zomato_groom_time" id="time_1"
                                                                        value="{{ $project->we_zomato_groom_time ?? '' }}"
                                                                        required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Groom
                                                            Home:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="we_zomato_groom_home" id="groom_home1"
                                                                value="{{ $project->we_zomato_groom_home ?? '' }}"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Other
                                                            Info:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="we_zomato_groom_info" id="other_info1"
                                                                value="{{ $project->we_zomato_groom_info ?? '' }}"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <label
                                                                    class="control-label col-sm-6 align-self-center mb-0 text-end">Zomato
                                                                    Bride:</label>
                                                                <div class="col-sm-6">
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input mt-3"
                                                                            type="checkbox" role="switch"
                                                                            id="switch_2" name="we_zomato_bride"
                                                                            value="{{ $project->we_zomato_bride ?? '' }}" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group row text-center">
                                                                <label
                                                                    class="control-label col-sm-4 align-self-center mb-0 text-end">Time:</label>
                                                                <div class="col-sm-6">
                                                                    <input type="time" class="form-control"
                                                                        name="we_zomato_bride_time" id="time_2"
                                                                        value="{{ $project->we_zomato_bride_time ?? '' }}"
                                                                        required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Bride
                                                            Home:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="we_zomato_bride_home" id="bride_home2"
                                                                value="{{ $project->we_zomato_bride_home ?? '' }}"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Other
                                                            Info:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="we_zomato_bride_info" id="other_info2"
                                                                value="{{ $project->we_zomato_bride_info ?? '' }}"
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Location:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="we_location"
                                                                value="{{ $project->we_location ?? '' }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Time:</label>
                                                        <div class="col-sm-8">
                                                            <input type="time" class="form-control"
                                                                name="we_church_time"
                                                                value="{{ $project->we_church_time ?? '' }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Time:</label>
                                                        <div class="col-sm-8">
                                                            <input type="time" class="form-control"
                                                                name="we_xetetisi_time"
                                                                value="{{ $project->we_xetetisi_time ?? '' }}"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Time:</label>
                                                        <div class="col-sm-8">
                                                            <input type="time" class="form-control"
                                                                name="we_reception_time"
                                                                value="{{ $project->we_reception_time ?? '' }}"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Phone:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="we_groom_phone"
                                                                value="{{ $project->we_groom_phone ?? '' }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Phone:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="we_bride_phone"
                                                                value="{{ $project->we_bride_phone ?? '' }}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="name">Details:</label>
                                                        <textarea name="we_details" id="" cols="30" rows="10" class="form-control">{{ $project->we_details ?? '' }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- End Wedding and Engajement Form --}}
                                {{-- ------------------------------------------------------------------------------------------- --}}
                                {{-- Start Christening Form --}}
                                <div id="christening" style="display: none">
                                    <div class="card-header d-flex justify-content-between">
                                        <div class="header-title">
                                            <h4 class="card-title">Christening Form</h4>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="new-user-info">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Date:</label>
                                                        <div class="col-sm-8">
                                                            <input type="date" class="form-control" name="c_date"
                                                                value="{{ $project->c_date ?? '' }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Church:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="c_church"value="{{ $project->c_church ?? '' }}"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Reception/Party:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="c_reception"value="{{ $project->c_reception ?? '' }}"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Baby
                                                            Name:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="c_baby_name"value="{{ $project->c_baby_name ?? '' }}"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Mother
                                                            Name:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="c_mother_name"value="{{ $project->c_mother_name ?? '' }}"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Father
                                                            Name:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="c_father_name"value="{{ $project->c_father_name ?? '' }}"required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Email:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="c_email"value="{{ $project->c_email ?? '' }}"required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <label
                                                                    class="control-label col-sm-6 align-self-center mb-0 text-end">Zomato
                                                                    Groom:</label>
                                                                <div class="col-sm-6">
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input mt-3"
                                                                            type="checkbox" role="switch"
                                                                            id="switch_3" name="c_zomato_baby"
                                                                            value="{{ $project->c_zomato_baby ?? '' }}" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <label
                                                                    class="control-label col-sm-4 align-self-center mb-0 text-end">Time:</label>
                                                                <div class="col-sm-6">
                                                                    <input type="time" class="form-control"
                                                                        name="c_zomato_baby_time"
                                                                        id="time_3"value="{{ $project->c_zomato_baby_time ?? '' }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Location:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="c_location"
                                                                value="{{ $project->c_location ?? '' }}"required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Time:</label>
                                                        <div class="col-sm-8">
                                                            <input type="time" class="form-control"
                                                                name="c_church_time"
                                                                value="{{ $project->c_church_time ?? '' }}"required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Time:</label>
                                                        <div class="col-sm-8">
                                                            <input type="time" class="form-control"
                                                                name="c_reception_time"
                                                                value="{{ $project->c_reception_time ?? '' }}"required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Birth
                                                            Date:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="c_baby_dob"
                                                                value="{{ $project->c_baby_dob ?? '' }}"required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Phone:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="c_mother_phone"
                                                                value="{{ $project->c_mother_phone ?? '' }}"required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Phone:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="c_father_phone"
                                                                value="{{ $project->c_father_phone ?? '' }}"required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="name">Details:</label>
                                                        <textarea name="c_details" id="" cols="30" rows="10" class="form-control">{{ $project->c_details ?? '' }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- End Christening Form --}}
                                {{-- ------------------------------------------------------------------------------------------- --}}
                                {{-- Start Submit Button --}}
                                <div class="edit_project_notify"></div>
                                <div class="card-body text-end">
                                    <a href="{{ route('project:list') }}" class="btn btn-danger">Back</a>
                                    <button type="submit" class="btn btn-primary" id="edit_project_btn">Update
                                    </button>
                                </div>
                            </div>
                            {{-- Start Submit Button --}}
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

    {{-- add event modal --}}
    <div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form action="javascript:void(0)" method="post" id="saveNewEvent" data-parsley-validate
                    enctype="multipart/form-data">

                    <div class="modal-body">
                        <div class="container-fluid">

                            <h3>Add Event</h3>
                            <hr />
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">

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
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Status:</label>

                                        <select name="status" class=" form-control"
                                                data-style="py-0" >
                                            <option value="pending">pending</option>
                                            <option value="in-progress">in progress</option>
                                            <option value="completed">completed</option>
                                        </select>

                                    </div>
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

    @include('admin.layouts.script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        window.addEventListener('load', function() {
            $(".create-project").validate({
                rules: {
                    p_name: {
                        required: true,
                        maxlength: 20,
                    },
                    p_cost: {
                        required: true,
                        maxlength: 20
                    },
                    p_date: {
                        required: true,
                    },
                    p_employees: {
                        required: true,
                    },
                    p_contractors: {
                        required: true,
                    },
                    p_type: {
                        required: true,
                    },
                },
                messages: {
                    p_name: {
                        required: "Project Name is required",
                        maxlength: "Project Name cannot be more than 20 characters"
                    },
                    p_cost: {
                        required: "Project cost is required",
                        maxlength: "Project cost be more than 20 characters",
                    },
                    p_date: {
                        required: "Created date is required",
                    },
                    p_employees: {
                        required: "Employee is required",
                    },
                    p_contractors: {
                        required: "Contractor is required",
                    },
                    p_type: {
                        required: "Type is required",
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
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
            $("#switch_1").on('change', function() {
                if ($(this).is(':checked')) {
                    $("#switch_1").val(1);
                    $("#time_1").prop('disabled', false);
                    $("#groom_home1").prop('disabled', false);
                    $("#other_info1").prop('disabled', false);

                } else {
                    $("#time_1").prop('disabled', true);
                    $("#groom_home1").prop('disabled', true);
                    $("#other_info1").prop('disabled', true);
                    $("#time_1").val(' ');
                    $("#groom_home1").val(' ');
                    $("#other_info1").val(' ');
                }
            });
            $("#switch_2").on('change', function() {
                if ($(this).is(':checked')) {
                    $("#switch_2").val(1);
                    $("#time_2").prop('disabled', false);
                    $("#bride_home2").prop('disabled', false);
                    $("#other_info2").prop('disabled', false);

                } else {
                    $("#time_2").prop('disabled', true);
                    $("#bride_home2").prop('disabled', true);
                    $("#other_info2").prop('disabled', true);
                    $("#time_2").val(' ');
                    $("#bride_home2").val(' ');
                    $("#other_info2").val(' ');
                }
            });
            $("#switch_3").on('change', function() {
                if ($(this).is(':checked')) {
                    $("#switch_3").val(1);
                    $("#time_3").prop('disabled', false);
                } else {
                    $("#time_3").prop('disabled', true);
                    $("#time_3").val(' ');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {

            // add event modal
            $('#add_event_').click(function() {

                $('#addEventModal').modal('show')
            })

            // save event in tr
            $(document).on("submit", "#saveNewEvent", function(e) {

                e.preventDefault();
                let action_name = $('#modal_action_name').val()
                let action_date = $('#modal_action_date').val()

                let html = `<tr>
                            <td>
                                <input type="hidden" value="` + action_name + `" name="action_name[]" />
                                ` + action_name + `
                            </td>
                            <td>
                                <input type="hidden" value="` + action_date + `" name="action_date[]" />
                                ` + action_date + `
                                <a href="javascript:void(0)" class="text-danger remove_event_row_">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>`

                $('#events_list_').append(html)

                //reset form

                $('#saveNewEvent')[0].reset()

            })

            // remove event row
            $(document).on("click", ".remove_event_row_", function() {

                $(this).closest('tr').remove()

            })

            $(document).on("submit", "#edit_project_form", function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $("#edit_project_btn").prop('disabled', true);
                $.ajax({
                    url: "{{ route('project:update') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status == "true") {
                            $(".edit_project_notify").html(
                                `<div class="alert alert-left alert-success alert-dismissible fade show mb-3" role="alert">
                                    <span> ` + response.msg + `!</span>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>`
                            ), setTimeout(function() {
                                $(".edit_project_notify").html(``);
                                $("#edit_project_btn").prop('disabled', false);
                                window.location = "{{ route('project:list') }}";
                            }, 2000);
                        }
                        if (response.status == "false") {
                            $(".edit_project_notify").html(
                                `<div class="alert alert-left alert-danger alert-dismissible fade show mb-3" role="alert">
                                    <span> ` + response.msg + `!</span>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>`), setTimeout(function() {
                                $(".edit_project_notify").html(``);
                                $("#edit_project_btn").prop('disabled', false);
                            }, 2000);
                        }
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).on("change", "#type_hide_show", function() {
                var optionValue = $(this).val();
                if (optionValue == "Wedding and Engagement") {
                    $("#wedding_and_engajement_form").show();
                    $("#christening").hide();
                } else if (optionValue == "Christening") {
                    $("#wedding_and_engajement_form").hide();
                    $("#christening").show();
                } else {
                    $("#wedding_and_engajement_form").hide();
                    $("#christening").hide();
                }
            });
        });
    </script>
    <script>
        var val = $("#abc").val();
        if (val == "Wedding and Engagement") {
            $("#wedding_and_engajement_form").show();
        }
        if (val == "Christening") {
            $("#christening").show();
        }
        var sw1 = $("#switch_1").val();
        if (sw1 == '1') {
            console.log(sw1);
            $("#switch_1").trigger("click");
            $("#time_1").prop('disabled', false);
            $("#groom_home1").prop('disabled', false);
            $("#other_info1").prop('disabled', false);
        } else {
            $("#time_1").prop('disabled', true);
            $("#groom_home1").prop('disabled', true);
            $("#other_info1").prop('disabled', true);
            $("#time_1").val(' ');
        }
        var sw2 = $("#switch_2").val();
        if (sw2 == 1) {
            console.log(sw2);
            $("#switch_2").trigger("click");
            $("#time_2").prop('disabled', false);
            $("#bride_home2").prop('disabled', false);
            $("#other_info2").prop('disabled', false);
        } else {
            $("#time_2").prop('disabled', true);
            $("#bride_home2").prop('disabled', true);
            $("#other_info2").prop('disabled', true);
            $("#time_2").val(' ');
        }
        var sw3 = $("#switch_3").val();
        if (sw3 == '1') {
            console.log(sw3);
            $("#switch_3").trigger("click");
            $("#time_3").prop('disabled', false);
        } else {
            $("#time_3").prop('disabled', true);
            $("#time_3").val(' ');
        }
    </script>
