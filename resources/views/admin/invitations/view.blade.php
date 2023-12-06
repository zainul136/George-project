@include('admin.layouts.head')
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
                        {{-- @csrf --}}
                        {{-- Start employee Form --}}
                        <div class="card">
                            <div class="card-body">
                                <div class="new-employee-info">
                                    <div class="row mb-2">
                                        <div class="col-md-6 text-start">
                                            <h4 class="card-title">View Invitation</h4>
                                        </div>
                                        <div class="col-md-6 text-end"><a href="{{ route('invite:list') }}"
                                                class="btn btn-primary">Back</a></div>
                                    </div>

                                    <div class="card-header d-flex justify-content-center">
                                        <div class="card-body px-0">
                                            <div class="row gy-3 mt-3 pt-75">
                                                <div class="col-12 col-md-4">
                                                    <label class="form-label" for="jobTitle">Project Name</label>
                                                    <div class="fw-bolder">{{ $invitation->project->name ?? '' }}</div>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <label class="form-label" for="jobType">Contractor</label>
                                                    <div class="fw-bolder">{{ $invitation->contractor->name ?? '' }}
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <label class="form-label" for="jobPlace">invited By</label>
                                                    <div class="fw-bolder">{{ $invitation->invitedBy->name ?? '' }}
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <label class="form-label" for="jobPlace">Price</label>
                                                    <div class="fw-bolder">€{{ $invitation->price ?? 0 }}
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <label class="form-label" for="jobPlace">Creation Date</label>
                                                    <div class="fw-bolder">
                                                        {{ date('m/d/Y', strtotime($invitation->created_at)) ?? '-' }}
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <label class="form-label" for="location">Status</label>
                                                    <div class="fw-bolder">
                                                        @if ($invitation->status == 0)
                                                            <span class="badge bg-secondary">Pending</span>
                                                        @elseif($invitation->status == 1)
                                                            <span class="badge bg-danger">Rejected</span>
                                                        @elseif($invitation->status == 2)
                                                            <span class="badge bg-success">Approved</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="form-label" for="location">Message</label>
                                                    <div class="fw-bolder">
                                                        {{ $invitation->message ?? '' }}
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
            </div>
        </div>
        <!-- Footer Section Start -->
        @include('admin.layouts.footer')
        <!-- Footer Section End -->
    </main>
    <!-- Wrapper End-->
    <!-- offcanvas start -->

    @include('admin.layouts.script')
