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
                        <form id="add_client_form" class="create-client">
                            @csrf
                            {{-- Start client Form --}}
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-md-6 text-start">
                                            <h4 class="card-title">View Client Information</h4>
                                        </div>
                                        <div class="col-md-6 text-end"><a href="{{ route('client:list') }}"
                                                class="btn btn-primary">Back</a></div>
                                    </div>
                                    <div class="card-header d-flex justify-content-center">
                                        <div class="card-body px-0">
                                            <div class="row justify-content-center">
                                                <div class="col-md-2 justify-content-center">
                                                    <div class="mb-2">
                                                        <div>
                                                            <img class="w-100" src="{{ isset($client->image) && !empty($client->image) ? asset('project_images/client/') . '/' . $client->image : asset('admin/images/avatars/blank.jpg') }}"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row gy-3 mt-3 pt-75">
                                                <div class="col-12 col-md-4">
                                                    <label class="form-label" for="jobTitle">Name</label>
                                                    <div class="fw-bolder">{{ $client->name ?? '' }}</div>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <label class="form-label" for="jobType">Email</label>
                                                    <div class="fw-bolder">{{ $client->email ?? '' }}</div>
                                                </div>
                                                <div class="col-4">
                                                    <label class="form-label" for="jobPlace">Contact</label>
                                                    <div class="fw-bolder">{{ $client->contact ?? '' }}
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <label class="form-label" for="jobPlace">Date Of Birth</label>
                                                    <div class="fw-bolder">{{ changeDateFormatToUS($client->dob) ?? '' }}
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-4">
                                                    <label class="form-label" for="jobDescription">Address</label>
                                                    <div class="fw-bolder">{{ $client->address ?? '' }}</div>
                                                </div>

                                                <div class="col-12 col-md-4">
                                                    <label class="form-label" for="jobDescription">Projects</label>
                                                    <div class="fw-bolder">
                                                        @if (count($projects) > 0)
                                                            @php
                                                                $selectedProject = $client->project ?? '';
                                                            @endphp
                                                            @if (!empty($selectedProject))
                                                                <p>{{ $selectedProject }}</p>
                                                            @endif
                                                        @else
                                                            <p>Projects not Available</p>
                                                        @endif
                                                    </div>
                                                </div>


                                                <div class="col-12 col-md-4">
                                                    <label class="form-label" for="location">Status</label>
                                                    <div class="fw-bolder">
                                                        {{ $client->status == 1 ? 'Active' : 'Deactivate' }}</div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

    @include('admin.layouts.script')
