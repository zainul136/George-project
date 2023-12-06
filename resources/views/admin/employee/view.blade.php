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
                                            <h4 class="card-title">View Employee Information</h4>
                                        </div>
                                        <div class="col-md-6 text-end"><a href="{{ route('employee:list') }}"
                                                class="btn btn-primary">Back</a></div>
                                    </div>

                                    <div class="card-header d-flex justify-content-center">
                                        <div class="card-body px-0">
                                            <div class="row justify-content-center">
                                                <div class="col-md-2 justify-content-center">
                                                    <div class="mb-2">
                                                        <div>
                                                            <img class="w-100"
                                                                src="{{ isset($employee->image) && !empty($employee->image) ? asset('project_images/employee/' . $employee->image) : asset('admin/images/avatars/blank.jpg') }}"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row gy-3 mt-3 pt-75">
                                                <div class="col-12 col-md-4">
                                                    <label class="form-label" for="jobTitle">Name</label>
                                                    <div class="fw-bolder">{{ $employee->name ?? '' }}</div>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <label class="form-label" for="jobType">Email</label>
                                                    <div class="fw-bolder">{{ $employee->email ?? '' }}</div>
                                                </div>
                                                <div class="col-4">
                                                    <label class="form-label" for="jobPlace">Contact</label>
                                                    <div class="fw-bolder">{{ $employee->contact ?? '' }}
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <label class="form-label" for="jobPlace">Date Of Birth</label>
                                                    <div class="fw-bolder">
                                                        {{ changeDateFormatToUS($employee->dob) ?? '' }}
                                                    </div>
                                                </div>


                                                <div class="col-12 col-md-4">
                                                    <label class="form-label" for="jobDescription">Companies</label>
                                                    @if (count($companies) > 0)
                                                        @php
                                                            $selectedCompany = $employee->company_name ?? '';
                                                        @endphp
                                                        @if (!empty($selectedCompany))
                                                            <p class="fw-bolder">{{ $selectedCompany }}</p>
                                                        @else
                                                            <p>Select Company</p>
                                                        @endif
                                                    @else
                                                        <p>Company not Available</p>
                                                    @endif
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <label class="form-label" for="location">Status</label>
                                                    <div class="fw-bolder">
                                                        {{ $employee->status == 1 ? 'Active' : 'Deactivate' }}
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="form-label" for="location">Description</label>
                                                    <div class="fw-bolder">
                                                        {{ $employee->description ?? '' }}
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if (session()->get('type') == 'admin')
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4 class="">Payment/ Salary Logs
                                                    </h4>
                                                </div>
                                                <div class="col-md-6">
                                                    <button type="button" id="add_payment_"
                                                        class="btn btn-sm btn-primary " style="float: right;">
                                                        Add Payment
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">

                                                @if (!empty($payment_logs))
                                                    <table id="payment_logs" class="table table-striped"
                                                        data-toggle="data-table">
                                                        <thead>
                                                            <tr>
                                                                <th>Price</th>
                                                                <th>Payment Type</th>
                                                                <th>Message</th>
                                                                <th>Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($payment_logs as $log)
                                                                <tr>
                                                                    <td>€{{ $log->payment }}</td>
                                                                    <td>{{ ucwords(str_replace('_', ' ', $log->payment_type)) ?? '' }}
                                                                    </td>
                                                                    <td>{{ $log->message ?? '' }}</td>
                                                                    <td>{{ changeDateFormatToUS($log->date) }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                @else
                                                    <p>No Payment available.</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="viewEventModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    {{-- <form action="javascript:void(0)" method="post" id="saveNewEvent" data-parsley-validate
                    enctype="multipart/form-data"> --}}
                    <form id="add_salary">
                        @csrf
                        <div class="modal-body">
                            <div class="container-fluid">

                                <h3>Add Payment</h3>
                                <hr />
                                <div class="add_payment_notify"></div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <input type="hidden" name="employee_id" value="{{ $employee->user_id }}">
                                            <label class="control-label mb-0 text-end">Payment</label>
                                            <input type="number" step="0.1" class="form-control form-contol-sm"
                                                id="modal_action_name" name="payment" required />
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label mb-0 text-end">Date</label>
                                            <input type="date" class="form-control form-contol-sm"
                                                id="modal_action_date" name="date" required />
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
                                                <option value="cheque"> Cheque </option>
                                                <option value="bank_transfer"> Bank Transfer</option>
                                            </select>
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
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-primary">Add Payment</button>
                            <button type="button" class="btn btn-sm btn-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                        </div>

                    </form>
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
    <script>
        $(document).ready(function() {
            $('#payment_logs').dataTable({
                destroy: true,
                pageLength: 10,
                ordering: false
            });
        });
        $('#add_payment_').click(function() {
            $('#viewEventModal').modal('show')
        })

        $(document).on("submit", "#add_salary", function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: "{{ route('employee:add_payment') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status == true) {
                        $(".add_payment_notify").html(
                            `
                            <div class="alert alert-left alert-success alert-dismissible fade show mb-3" role="alert">
                                <span> ` + response.msg + `!</span>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            `
                        ), setTimeout(function() {
                            $(".add_payment_notify").html(``);
                            $("#add_salary")[0].reset();
                            location.reload();
                        }, 2000);
                    }
                    if (response.status == false) {
                        $(".add_payment_notify").html(
                            `<div class="alert alert-left alert-danger alert-dismissible fade show mb-3" role="alert">
                                <span> ` + response.msg + `!</span>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`), setTimeout(function() {
                            $(".add_payment_notify").html(``);
                        }, 2000);
                    }
                }
            });
        });
    </script>
