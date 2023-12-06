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
        <div class="position-relative iq-banner">
            <!--Nav Start-->
            @include('admin.layouts.nav')
            <!-- Nav Header Component Start -->
            <div class="iq-navbar-header" style="height: 70px;">
                <div class="container-fluid iq-container">
                    <div class="row">
                    </div>
                </div>
            </div>
            <!-- Nav Header Component End -->
            <!--Nav End-->
        </div>
        <div class="conatiner-fluid content-inner mt-n5 py-0">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="profile-content tab-content">
                        <div>
                            <div class="card">
                                <div class="card-header">
                                    <div class="header-title">
                                        <h4 class="card-title">Profile</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="text-center">
                                        <div class="user-profile">
                                            @if (is_null($contractorDetails->image))
                                                <img src="{{ asset('admin/images/avatars/blank.jpg') }}"
                                                    alt="{{ Str::title($contractorDetails->name) }}"
                                                    class="theme-color-default-img img-fluid avatar avatar-100 avatar-rounded">
                                            @else
                                                <img src="{{ asset('project_images/contractor/' . $contractorDetails->image) }}"
                                                    alt="profile-img" class="rounded-pill avatar-130 img-fluid">
                                            @endif
                                        </div>
                                        <div class="mt-3">
                                            <h3 class="d-inline-block">{{ Str::title($contractorDetails->name) }}</h3>
                                            <p class="d-inline-block pl-3"> - {{ Str::title($contractorDetails->type) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <div class="header-title">
                                        <h4 class="card-title">About {{ Str::title($contractorDetails->type) }}</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="user-bio">
                                        <h6 class="mb-1">Address:</h6>
                                        <p>{{ Str::title($contractorDetails->address) }}</p>
                                    </div>
                                    <div class="mt-2">
                                        <h6 class="mb-1">Email:</h6>
                                        <p>{{ $contractorDetails->email }}</p>
                                    </div>
                                    <div class="mt-2">
                                        <h6 class="mb-1">Joined:</h6>
                                        <p>{{ $contractorDetails->created_at }}</p>
                                    </div>
                                    <div class="mt-2">
                                        <h6 class="mb-1">Date of Birth:</h6>
                                        <p>{{ $contractorDetails->dob }}</p>
                                    </div>
                                    <div class="mt-2">
                                        <h6 class="mb-1">Contact:</h6>
                                        <p><a href="#" class="text-body">{{ $contractorDetails->contact }}</a>
                                        </p>
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
                                                <td>{{ $project->project_date }}</td>
                                                <td>
                                                    {{ ucwords(str_replace('_', ' ', $project->status ?? '')) }}
                                                </td>
                                                <td>
                                                    <a class="btn btn-sm btn-icon btn-success" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="View" target="_blank"
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
                                                                    <circle cx="12" cy="12" r="3"
                                                                        fill="white">
                                                                    </circle>
                                                                </mask>
                                                                <circle opacity="0.89" cx="13.5" cy="10.5"
                                                                    r="1.5" fill="white">
                                                                </circle>
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
