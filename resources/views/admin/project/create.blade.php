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
                        <form id="add_project_form" class="create-project">
                            @csrf
                            {{-- Start Project Form --}}
                            <div class="card">
                                <div class="card-body">
                                    <div class="new-project-info">
                                        <div class="row mb-2">
                                            <div class="col-md-6 text-start">
                                                <h4 class="card-title">New Project Information</h4>
                                            </div>
                                            <div class="col-md-6 text-end"><a href="{{ route('project:list') }}"
                                                    class="btn btn-primary">View All Projects</a></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Project Name:</label>
                                                    <input type="text" class="form-control" name="p_name"
                                                        placeholder="Enter Project Name">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Cost:</label>
                                                    <input type="number" class="form-control" name="p_cost"
                                                        placeholder="Enter Project Cost">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Date:</label>
                                                    <input type="date" class="form-control" name="p_date">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Employees:</label>
                                                    <div class="d-flex">
                                                        <select name="employees[]"
                                                            class="selectpicker form-control multiple_select_employees"
                                                            data-style="py-0" multiple required>
                                                            @if (count($employees) > 0)
                                                                @foreach ($employees as $employee)
                                                                    <option value="{{ $employee->id }}">
                                                                        {{ $employee->name }}
                                                                    </option>
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
                                                                    <option value="{{ $contractor->id }}">
                                                                        {{ $contractor->name }}
                                                                    </option>
                                                                @endforeach
                                                            @else
                                                                <option disabled>Contractor Not Available</option>
                                                            @endif
                                                        </select>
                                                        <a href="{{ route('contractor:create') }}" target="_blank"> <i
                                                                class="fa fa-plus text-primary m-2"
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
                                                        <option>Wedding and Engagement</option>
                                                        <option>Christening</option>
                                                        <option>Events</option>
                                                        <option>Print</option>
                                                        <option>Product</option>
                                                        <option>Studio</option>
                                                        <option>Other (free text)</option>
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
                                                                <option value="{{ $client->client_id }}">
                                                                    {{ $client->name }}
                                                                </option>
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
                                                                <option value="{{ $company->company_id }}">
                                                                    {{ $company->name }}
                                                                </option>
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
                                                                <th>Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="events_list_">

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="name">Details:</label>
                                                    <textarea name="p_details" id="" cols="30" rows="10" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- End Project Form --}}
                                {{-- ------------------------------------------------------------------------------------------- --}}
                                {{-- Start Wedding and Engajement Form --}}
                                <div id="wedding_and_engajement_form" class="create-project">
                                    <div class="card-header d-flex justify-content-between">
                                        <div class="header-title">
                                            <h4 class="card-title">Wedding and Engagement Form</h4>
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
                                                            <input type="date" class="form-control" name="we_date"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Church:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="we_church" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Xetetisi:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="we_xetetisi" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Reception/Party:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="we_reception" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Groom
                                                            Name:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="we_groom_name" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Bride
                                                            Name:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="we_bride_name" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Email:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="we_email" required>
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
                                                                            value="0" />
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
                                                                        id="we_zomato_groom_time" required>
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
                                                                id="we_zomato_groom_home" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Other
                                                            Info:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="we_zomato_groom_info" id="other_info1"
                                                                id="we_zomato_groom_info" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-6">
                                                            <div class="form-group row text-center">
                                                                <label
                                                                    class="control-label col-sm-6 align-self-center mb-0 text-end">Zomato
                                                                    Bride:</label>
                                                                <div class="col-sm-6">
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input mt-3"
                                                                            type="checkbox" role="switch"
                                                                            id="switch_2" name="we_zomato_bride"
                                                                            value="0" />
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
                                                                name="we_zomato_bride_home" id="bride_home2" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Other
                                                            Info:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="we_zomato_bride_info" id="other_info2" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Location:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="we_location" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Time:</label>
                                                        <div class="col-sm-8">
                                                            <input type="time" class="form-control"
                                                                name="we_church_time" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Time:</label>
                                                        <div class="col-sm-8">
                                                            <input type="time" class="form-control"
                                                                name="we_xetetisi_time" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Time:</label>
                                                        <div class="col-sm-8">
                                                            <input type="time" class="form-control"
                                                                name="we_reception_time" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Phone:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="we_groom_phone" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Phone:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="we_bride_phone" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="name">Details:</label>
                                                        <textarea name="we_details" id="" cols="30" rows="10" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- End Wedding and Engajement Form --}}
                                {{-- ------------------------------------------------------------------------------------------- --}}
                                {{-- Start Christening Form --}}
                                <div id="christening">
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
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Church:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="c_church" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Reception/Party:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="c_reception" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Baby
                                                            Name:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="c_baby_name" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Mother
                                                            Name:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="c_mother_name" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Father
                                                            Name:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="c_father_name" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Email:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" name="c_email"
                                                                required>
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
                                                                            id="switch_3" name="c_zomato_baby" />
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
                                                                        name="c_zomato_baby_time" id="time_3"
                                                                        required>
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
                                                                name="c_location" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Time:</label>
                                                        <div class="col-sm-8">
                                                            <input type="time" class="form-control"
                                                                name="c_church_time" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Time:</label>
                                                        <div class="col-sm-8">
                                                            <input type="time" class="form-control"
                                                                name="c_reception_time" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Birth
                                                            Date:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="c_baby_dob" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Phone:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="c_mother_phone" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label
                                                            class="control-label col-sm-3 align-self-center mb-0 text-end">Phone:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                name="c_father_phone" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="name">Details:</label>
                                                        <textarea name="c_details" id="" cols="30" rows="10" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- End Christening Form --}}
                                {{-- ------------------------------------------------------------------------------------------- --}}
                                {{-- Start Submit Button --}}
                                <div class="add_project_notify"></div>
                                <div class="card-body">
                                    <button type="submit" class="btn btn-primary float-end" id="add_project_btn">Add
                                        Project</button>
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
    <!-- offcanvas start -->

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

                                        <label class="control-label mb-0 text-end">Date</label>
                                        <label class="form-label">Status:</label>
                                        <select name="status" class="form-control"
                                                data-style="py-0" id="type_hide_show">
                                            <option value="" selected="selected">Select Status
                                            </option>
                                            <option value="pending">Pending</option>
                                            <option value="in-progress">In progress</option>
                                            <option value="complete">Complete</option>
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
        $(document).ready(function() {


        });
    </script>
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
            $("#switch_1").val('0');
            $("#time_1").prop('disabled', true);
            $("#groom_home1").prop('disabled', true);
            $("#other_info1").prop('disabled', true);
            $("#switch_1").on('change', function() {
                if ($(this).is(':checked')) {
                    $("#switch_1").val('1');
                    $("#time_1").prop('disabled', false);
                    $("#groom_home1").prop('disabled', false);
                    $("#other_info1").prop('disabled', false);
                } else {
                    $("#switch_1").val('0');
                    $("#time_1").prop('disabled', true);
                    $("#groom_home1").prop('disabled', true);
                    $("#other_info1").prop('disabled', true);
                }
            });
            $("#switch_2").val('0');
            $("#time_2").prop('disabled', true);
            $("#bride_home2").prop('disabled', true);
            $("#other_info2").prop('disabled', true);
            $("#switch_2").on('change', function() {
                if ($(this).is(':checked')) {
                    $("#switch_2").val('1');
                    $("#time_2").prop('disabled', false);
                    $("#bride_home2").prop('disabled', false);
                    $("#other_info2").prop('disabled', false);
                } else {
                    $("#switch_2").val('0');
                    $("#time_2").prop('disabled', true);
                    $("#bride_home2").prop('disabled', true);
                    $("#other_info2").prop('disabled', true);
                }
            });
            $("#switch_3").val('0');
            $("#time_3").prop('disabled', true);

            $("#switch_3").on('change', function() {
                if ($(this).is(':checked')) {
                    $("#switch_3").val('1');
                    $("#time_3").prop('disabled', false);
                } else {
                    $("#switch_3").val('0');
                    $("#time_3").prop('disabled', true);
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

            $(document).on("submit", "#add_project_form", function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('project:store') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        let status = response.status;
                        let msg = response.msg;

                        let alertClass = status === "true" ? "success" : "danger";

                        let alertHTML = `
                <div class="alert alert-left alert-${alertClass} alert-dismissible fade show mb-3" role="alert">
                    <span>${msg}!</span>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`;

                        $(".add_project_notify").html(alertHTML);

                        setTimeout(function() {
                            $(".add_project_notify").html('');
                            $("#add_project_btn").prop('disabled', false);

                            if (status === "true") {
                                $("#add_project_form")[0].reset();
                                window.location = "{{ URL('projects/project-view/') }}" + '/' + response.project_id;
                            }
                        }, 2000);
                    }
                });
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            $("#wedding_and_engajement_form").hide();
            $("#christening").hide();
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
