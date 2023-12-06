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
                        <form id="edit_invitation_form">
                            @csrf
                            {{-- Start company Form --}}
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="header-title">
                                        <h4 class="card-title">Edit Invitation</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="new-company-info">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label">Project Name:</label>
                                                        <input type="hidden" name="code"
                                                            value="{{ $invite->invitation_id }}">
                                                        <input type="text" class="form-control" name="project"
                                                            placeholder="Enter Project Name"
                                                            value="{{ $invite->project }}" disabled>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label">Contractor Name:</label>
                                                        <input type="text" class="form-control" name="contractor"
                                                            placeholder="Enter Contractor Name"
                                                            value="{{ $invite->contractor }}" disabled>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label">Invited Name:</label>
                                                        <input type="text" class="form-control" name="invited"
                                                            placeholder="Enter Invited Name"
                                                            value="{{ $invite->invited }}" disabled>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label">Status:</label>
                                                        <select name="status" id="" class="form-control">
                                                            <option value="0"
                                                                {{ $invite->status == 0 ? 'selected' : '' }}>
                                                                Pending</option>
                                                            <option value="1"
                                                                {{ $invite->status == 1 ? 'selected' : '' }}>Rejected
                                                            </option>
                                                            <option value="2"
                                                                {{ $invite->status == 2 ? 'selected' : '' }}>Approved
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="edit_invitation_notify"></div>
                                            <div class="card-footer text-end">
                                                <a href="{{ route('invite:list') }}" class="btn btn-danger">Back</a>
                                                <button type="submit" class="btn btn-primary"
                                                    id="edit_invitation_btn">Update
                                                </button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function() {
            $(document).on("submit", "#edit_invitation_form", function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    url: "{{ route('invite:update') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status == "true") {
                            $(".edit_invitation_notify").html(
                                `
                                <div class="alert alert-left alert-success alert-dismissible fade show mb-3" role="alert">
                                    <span> ` + response.msg + `!</span>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                `
                            ), setTimeout(function() {
                                $(".edit_invitation_notify").html(``);
                                window.location = "{{ route('invite:list') }}";
                            }, 2000);
                        }
                        if (response.status == "false") {
                            $(".edit_invitation_notify").html(
                                `<div class="alert alert-left alert-danger alert-dismissible fade show mb-3" role="alert">
                                    <span> ` + response.msg + `!</span>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>`), setTimeout(function() {
                                $(".edit_invitation_notify").html(``);
                            }, 2000);
                        }
                    }
                });
            });
        });
    </script>
