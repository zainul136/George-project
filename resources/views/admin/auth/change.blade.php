<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Change Password</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('admin/images/favicon.ico') }}" />

    <!-- Library / Plugin Css Build -->
    <link rel="stylesheet" href="{{ asset('admin/css/core/libs.min.css') }}" />


    <!-- Hope Ui Design System Css -->
    <link rel="stylesheet" href="{{ asset('admin/css/hope-ui.min.css?v=2.0.0') }}" />

    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('admin/css/custom.min.css?v=2.0.0') }}" />

    <!-- Dark Css -->
    <link rel="stylesheet" href="{{ asset('admin/css/dark.min.css') }}" />

    <!-- Customizer Css -->
    <link rel="stylesheet" href="{{ asset('admin/css/customizer.min.css') }}" />

    <!-- RTL Css -->
    <link rel="stylesheet" href="{{ asset('admin/css/rtl.min.css') }}" />


</head>

<body class=" " data-bs-spy="scroll" data-bs-target="#elements-section" data-bs-offset="0" tabindex="0">
    <!-- loader Start -->
    <div id="loading">
        <div class="loader simple-loader">
            <div class="loader-body"></div>
        </div>
    </div>
    <!-- loader END -->

    <div class="wrapper">
        <section class="login-content">
            <div class="row m-0 align-items-center bg-white vh-100">
                <div class="col-md-6">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="card card-transparent shadow-none d-flex justify-content-center mb-0 auth-card">
                                <div class="card-body">
                                    <a href="../../dashboard/index.html"
                                        class="navbar-brand d-flex align-items-center mb-3">
                                        <!--Logo start-->
                                        <!--logo End-->

                                        <!--Logo start-->
                                        {{-- <div class="logo-main">
                                            <div class="logo-normal">
                                                <svg class="text-primary icon-30" viewBox="0 0 30 30" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="-0.757324" y="19.2427" width="28" height="4"
                                                        rx="2" transform="rotate(-45 -0.757324 19.2427)"
                                                        fill="currentColor" />
                                                    <rect x="7.72803" y="27.728" width="28" height="4"
                                                        rx="2" transform="rotate(-45 7.72803 27.728)"
                                                        fill="currentColor" />
                                                    <rect x="10.5366" y="16.3945" width="16" height="4"
                                                        rx="2" transform="rotate(45 10.5366 16.3945)"
                                                        fill="currentColor" />
                                                    <rect x="10.5562" y="-0.556152" width="28" height="4"
                                                        rx="2" transform="rotate(45 10.5562 -0.556152)"
                                                        fill="currentColor" />
                                                </svg>
                                            </div>
                                            <div class="logo-mini">
                                                <svg class="text-primary icon-30" viewBox="0 0 30 30" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="-0.757324" y="19.2427" width="28" height="4"
                                                        rx="2" transform="rotate(-45 -0.757324 19.2427)"
                                                        fill="currentColor" />
                                                    <rect x="7.72803" y="27.728" width="28" height="4"
                                                        rx="2" transform="rotate(-45 7.72803 27.728)"
                                                        fill="currentColor" />
                                                    <rect x="10.5366" y="16.3945" width="16" height="4"
                                                        rx="2" transform="rotate(45 10.5366 16.3945)"
                                                        fill="currentColor" />
                                                    <rect x="10.5562" y="-0.556152" width="28" height="4"
                                                        rx="2" transform="rotate(45 10.5562 -0.556152)"
                                                        fill="currentColor" />
                                                </svg>
                                            </div>
                                        </div> --}}
                                        <!--logo End-->

                                        {{-- <h4 class="logo-title ms-3">Hope UI</h4> --}}
                                    </a>
                                    <h2 class="mb-2 text-center">Reset Password</h2>
                                    {{-- <p class="text-center">Login to stay connected.</p> --}}
                                    <form id="change_password_form" class="change_form">
                                        @csrf
                                        <div class="row">
                                            <div class="change_notify"></div>
                                            <input type="hidden" name="token" class="form-control"
                                                value="{{ $token }}">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    {{-- <label class="form-label">Email</label> --}}
                                                    <input type="hidden" name="email" class="form-control"
                                                        placeholder="Enter Email" value="{{ $email }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-label">Password</label>
                                                    <input type="password" name="password" class="form-control"
                                                        placeholder="Enter Password" id="password">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-label">Confirm Password</label>
                                                    <input type="password" name="c_password" class="form-control"
                                                        placeholder="Enter Confirm Password">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button type="submit" class="btn btn-primary"
                                                id="forgot_form_btn">Reset</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="sign-bg">
                        <svg width="280" height="230" viewBox="0 0 431 398" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g opacity="0.05">
                                <rect x="-157.085" y="193.773" width="543" height="77.5714" rx="38.7857"
                                    transform="rotate(-45 -157.085 193.773)" fill="#3B8AFF" />
                                <rect x="7.46875" y="358.327" width="543" height="77.5714" rx="38.7857"
                                    transform="rotate(-45 7.46875 358.327)" fill="#3B8AFF" />
                                <rect x="61.9355" y="138.545" width="310.286" height="77.5714" rx="38.7857"
                                    transform="rotate(45 61.9355 138.545)" fill="#3B8AFF" />
                                <rect x="62.3154" y="-190.173" width="543" height="77.5714" rx="38.7857"
                                    transform="rotate(45 62.3154 -190.173)" fill="#3B8AFF" />
                            </g>
                        </svg>
                    </div> --}}
                </div>
                <div class="col-md-6 d-md-block d-none bg-primary p-0 mt-n1 vh-100 overflow-hidden">
                    <img src="{{ asset('admin/images/auth/01.png') }}" class="img-fluid gradient-main animated-scaleX"
                        alt="images">
                </div>
            </div>
        </section>
    </div>

    <!-- Library Bundle Script -->
    <script src="{{ asset('admin/js/core/libs.min.js') }}"></script>

    <!-- External Library Bundle Script -->
    <script src="{{ asset('admin/js/core/external.min.js') }}"></script>

    <!-- Widgetchart Script -->
    <script src="{{ asset('admin/js/charts/widgetcharts.js') }}"></script>

    <!-- mapchart Script -->
    <script src="{{ asset('admin/js/charts/vectore-chart.js') }}"></script>
    <script src="{{ asset('admin/js/charts/dashboard.js') }}"></script>

    <!-- fslightbox Script -->
    <script src="{{ asset('admin/js/plugins/fslightbox.js') }}"></script>

    <!-- Settings Script -->
    <script src="{{ asset('admin/js/plugins/setting.js') }}"></script>

    <!-- Slider-tab Script -->
    <script src="{{ asset('admin/js/plugins/slider-tabs.js') }}"></script>

    <!-- Form Wizard Script -->
    <script src="{{ asset('admin/js/plugins/form-wizard.js') }}"></script>

    <!-- AOS Animation Plugin-->

    <!-- App Script -->
    <script src="{{ asset('admin/js/hope-ui.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script>
        window.addEventListener('load', function() {
            $(".change_form").validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                    },
                    password: {
                        required: true,
                    },
                    c_password: {
                        required: true,
                        equalTo: "#password"
                    }
                },
                messages: {
                    email: {
                        required: "Email is required",
                        email: "Email must be a valid email address",
                        maxlength: "Email cannot be more than 30 characters",
                    },
                    password: {
                        required: "Password is required",
                    },
                    c_password: {
                        required: true,
                        required: "Confirm Password is required",
                        required: "Confirm Password and Password must be same.",
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).on("submit", "#change_password_form", function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    url: "{{ route('admin.password.change') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status == "true") {
                            $(".change_notify").html(
                                `<div class="alert alert-left alert-success alert-dismissible fade show mb-3" role="alert">
                                    <span> ` + response.msg + `!</span>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>`
                            ), setTimeout(function() {
                                $(".change_notify").html(``);
                                $("#change_password_form")[0].reset();
                                window.location =
                                    "{{ route('admin:login') }}";
                            }, 2000);
                        }
                        if (response.status == "false") {
                            $(".change_notify").html(
                                `<div class="alert alert-left alert-danger alert-dismissible fade show mb-3" role="alert">
                                        <span> ` + response.msg + `!</span>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>`), setTimeout(function() {
                                $(".change_notify").html(``);
                            }, 2000);
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>
