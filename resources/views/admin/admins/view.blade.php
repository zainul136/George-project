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
                        <form>
                            {{-- Start admin Form --}}
                            <div class="card">
                                <div class="card-body">
                                    <div class="new-employee-info">
                                        <div class="row mb-2">
                                            <div class="col-md-6 text-start">
                                                <h4 class="card-title">View Admin Information</h4>
                                            </div>
                                            <div class="col-md-6 text-end"><a href="{{ route('admin:list') }}"
                                                    class="btn btn-primary">Back</a></div>
                                        </div>

                                        <div class="card-header d-flex justify-content-center">
                                            <div class="card-body px-0">
                                                <div class="row justify-content-center">
                                                    <div class="col-md-2 justify-content-center">
                                                        <div class="mb-2">
                                                            <div>
                                                                <img class="w-100"
                                                                    src="{{ isset($admin->image) && !empty($admin->image) ? asset('project_images/admin/' . $admin->image) : asset('admin/images/avatars/blank.jpg') }}"
                                                                    alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row gy-3 mt-3 pt-75">
                                                    <div class="col-12 col-md-4">
                                                        <label class="form-label" for="jobTitle">Name</label>
                                                        <div class="fw-bolder">{{ $admin->name ?? '' }}</div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <label class="form-label" for="jobType">Email</label>
                                                        <div class="fw-bolder">{{ $admin->email ?? '' }}</div>
                                                    </div>
                                                    <div class="col-4">
                                                        <label class="form-label" for="jobPlace">Contact</label>
                                                        <div class="fw-bolder">{{ $admin->contact ?? '' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <label class="form-label" for="jobPlace">Date Of
                                                            Birth</label>
                                                        <div class="fw-bolder">{{ changeDateFormatToUS($admin->dob) ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <label class="form-label" for="jobPlace">Company</label>
                                                        @if (count($companies) > 0)
                                                            @if ($admin->company)
                                                                <p class="fw-bolder"> {{ $admin->company }}</p>
                                                            @else
                                                                <p>No Company Selected</p>
                                                            @endif
                                                        @else
                                                            <p>Company Not Available</p>
                                                        @endif
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <label class="form-label" for="location">Status</label>
                                                        <div class="fw-bolder">
                                                            {{ $admin->status == 1 ? 'Active' : 'Deactivate' }}
                                                        </div>
                                                    </div>

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
