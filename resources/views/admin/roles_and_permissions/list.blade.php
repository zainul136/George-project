@include('admin.layouts.head')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap5-toggle@5.0.4/css/bootstrap5-toggle.min.css" rel="stylesheet">
<style>
    #image-upload-btn {
        position: absolute;
        font-size: 30px;
        opacity: 0;
        right: 0;
        top: 0;
    }
</style>

<body class="">
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
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="row">
                        <div class="col-md-6 m-0 text-center">
                            <div class="card" style="min-height: 85vh">
                                <div class="card-header pt-0" style="background-color: #ffe135; color: black">
                                    <h4 class="p-3"><b>EMPLOYEES PERMISSIONS</b></h4>
                                </div>
                                <div class="card-body">
                                    <div class="col-md-12">
                                        <div class="card-body p-0">
                                            <div class="table mt-4">
                                                <table id="basic-table" class="table mb-0" role="grid"
                                                    style="font-size: 23px">
                                                    <tbody>
                                                        @foreach ($employees as $data)
                                                            <tr>
                                                                <td style="width: 70%">
                                                                    <div class="d-flex align-items-center">
                                                                        <table>
                                                                            <tr>
                                                                                <td style="width: 50%">
                                                                                    {{ Str::title($data->role) }}
                                                                                </td>
                                                                                <td style="width: 50%"></td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </td>
                                                                <td style="width: 30%">
                                                                    <div class="iq-media-group iq-media-group-1">
                                                                        <input class="test_id"
                                                                            data-id="{{ $data->id }}" class="togBtn"
                                                                            data-size="sm" class="toggle-class"
                                                                            type="checkbox" data-onstyle="success"
                                                                            data-offstyle="danger" data-toggle="toggle"
                                                                            data-on="ON" data-off="OFF"
                                                                            {{ $data->permission ? 'checked' : '' }}>
                                                                    </div>
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
                        <div class="col-md-6 p-0 m-0 text-center">
                            <div class="card" style="min-height: 85vh">
                                <div class="card-header pt-0" style="background-color: #002147; color: black">
                                    <h4 class="p-3 text-white"><b>CONTRACTORS PERMISSIONS</b></h4>
                                </div>
                                <div class="card-body">
                                    <div class="col-md-12">
                                        <div class="card-body p-0">
                                            <div class="table mt-4">
                                                <table id="basic-table" class="table mb-0" role="grid"
                                                    style="font-size: 23px">
                                                    <tbody>
                                                        @foreach ($contractors as $data)
                                                            <tr>
                                                                <td style="width: 70%">
                                                                    <div class="d-flex align-items-center">
                                                                        <table>
                                                                            <tr>
                                                                                <td style="width: 50%">
                                                                                    {{ Str::title($data->role) }}
                                                                                </td>
                                                                                <td style="width: 50%"></td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </td>
                                                                <td style="width: 30%">
                                                                    <div class="iq-media-group iq-media-group-1">
                                                                        <input class="test_id"
                                                                            data-id="{{ $data->id }}" class="togBtn"
                                                                            data-size="sm" class="toggle-class"
                                                                            type="checkbox" data-onstyle="success"
                                                                            data-offstyle="danger" data-toggle="toggle"
                                                                            data-on="ON" data-off="OFF"
                                                                            {{ $data->permission ? 'checked' : '' }}>
                                                                    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap5-toggle@5.0.4/js/bootstrap5-toggle.jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".test_id").on("change", function(event) {
                if ($(this).is(":checked")) {
                    var code = $(this).data("id");
                    var type = "on";
                    $.ajax({
                        url: "{{ route('role:update') }}",
                        type: "post",
                        data: {
                            _token: '{{ csrf_token() }}',
                            code: code,
                            type: type,
                        },
                        success: function(response) {
                            console.log(response);
                        }
                    });
                } else {
                    var code = $(this).data("id");
                    var type = "off";
                    $.ajax({
                        url: "{{ route('role:update') }}",
                        type: "post",
                        data: {
                            _token: '{{ csrf_token() }}',
                            code: code,
                            type: type,
                        },
                        success: function(response) {
                            console.log(response);
                        }
                    });
                }
            });
        });
    </script>
