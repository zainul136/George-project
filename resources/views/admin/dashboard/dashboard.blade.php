@include('admin.layouts.head')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
            <div class="iq-navbar-header" style="height: 215px;">
                <div class="container-fluid iq-container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="flex-wrap d-flex justify-content-between align-items-center">
                                <div>
                                    <h1>Hello {{ Str::title(session()->get('name')) }}!</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="iq-header-img">
                    <img src="{{ asset('admin/images/dashboard/top-header.png') }}" alt="header"
                        class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
                    <img src="{{ asset('admin/images/dashboard/top-header1.png') }}" alt="header"
                        class="theme-color-purple-img img-fluid w-100 h-100 animated-scaleX">
                    <img src="{{ asset('admin/images/dashboard/top-header2.png') }}" alt="header"
                        class="theme-color-blue-img img-fluid w-100 h-100 animated-scaleX">
                    <img src="{{ asset('admin/images/dashboard/top-header3.png') }}" alt="header"
                        class="theme-color-green-img img-fluid w-100 h-100 animated-scaleX">
                    <img src="{{ asset('admin/images/dashboard/top-header4.png') }}" alt="header"
                        class="theme-color-yellow-img img-fluid w-100 h-100 animated-scaleX">
                    <img src="{{ asset('admin/images/dashboard/top-header5.png') }}" alt="header"
                        class="theme-color-pink-img img-fluid w-100 h-100 animated-scaleX">
                </div>
            </div> <!-- Nav Header Component End -->
            <!--Nav End-->
        </div>
        <div class="conatiner-fluid content-inner mt-n5 py-0">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="row row-cols-1">
                        <div class="overflow-hidden d-slider1 ">
                            <ul class="p-0 m-0 mb-2 swiper-wrapper list-inline">
                                @foreach ($data as $key => $val)
                                    <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="700">
                                        <div class="card-body">
                                            <div class="progress-widget">
                                                <div id="circle-progress-0{{ $key }}"
                                                    class="text-center circle-progress-01 circle-progress circle-progress-primary"
                                                    data-min-value="0" data-max-value="100" data-value="90"
                                                    data-type="percent">
                                                    <svg class="card-slie-arrow icon-24" width="24"
                                                        viewBox="0 0 24 24">
                                                        <path fill="currentColor"
                                                            d="M5,17.59L15.59,7H9V5H19V15H17V8.41L6.41,19L5,17.59Z" />
                                                    </svg>
                                                </div>
                                                <div class="progress-detail">
                                                    <p class="mb-2">{{ ucfirst($key) }}</p>
                                                    <h4 class="counter">{{ $val ?? 0 }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                                {{-- <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="800">
                                    <div class="card-body">
                                        <div class="progress-widget">
                                            <div id="circle-progress-02"
                                                class="text-center circle-progress-01 circle-progress circle-progress-info"
                                                data-min-value="0" data-max-value="100" data-value="80"
                                                data-type="percent">
                                                <svg class="card-slie-arrow icon-24" width="24" viewBox="0 0 24 24">
                                                    <path fill="currentColor"
                                                        d="M19,6.41L17.59,5L7,15.59V9H5V19H15V17H8.41L19,6.41Z" />
                                                </svg>
                                            </div>
                                            <div class="progress-detail">
                                                <p class="mb-2">Total Contractors</p>
                                                <h4 class="counter">{{ $contractors ?? 0 }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="900">
                                    <div class="card-body">
                                        <div class="progress-widget">
                                            <div id="circle-progress-03"
                                                class="text-center circle-progress-01 circle-progress circle-progress-primary"
                                                data-min-value="0" data-max-value="100" data-value="70"
                                                data-type="percent">
                                                <svg class="card-slie-arrow icon-24" width="24" viewBox="0 0 24 24">
                                                    <path fill="currentColor"
                                                        d="M19,6.41L17.59,5L7,15.59V9H5V19H15V17H8.41L19,6.41Z" />
                                                </svg>
                                            </div>
                                            <div class="progress-detail">
                                                <p class="mb-2">Total Employees</p>
                                                <h4 class="counter">{{ $employees ?? 0 }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="1000">
                                    <div class="card-body">
                                        <div class="progress-widget">
                                            <div id="circle-progress-04"
                                                class="text-center circle-progress-01 circle-progress circle-progress-info"
                                                data-min-value="0" data-max-value="100" data-value="60"
                                                data-type="percent">
                                                <svg class="card-slie-arrow icon-24" width="24px"
                                                    viewBox="0 0 24 24">
                                                    <path fill="currentColor"
                                                        d="M5,17.59L15.59,7H9V5H19V15H17V8.41L6.41,19L5,17.59Z" />
                                                </svg>
                                            </div>
                                            <div class="progress-detail">
                                                <p class="mb-2">Total Clients</p>
                                                <h4 class="counter">{{ $clients ?? 0 }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="1100">
                                    <div class="card-body">
                                        <div class="progress-widget">
                                            <div id="circle-progress-05"
                                                class="text-center circle-progress-01 circle-progress circle-progress-primary"
                                                data-min-value="0" data-max-value="100" data-value="50"
                                                data-type="percent">
                                                <svg class="card-slie-arrow icon-24" width="24px"
                                                    viewBox="0 0 24 24">
                                                    <path fill="currentColor"
                                                        d="M5,17.59L15.59,7H9V5H19V15H17V8.41L6.41,19L5,17.59Z" />
                                                </svg>
                                            </div>
                                            <div class="progress-detail">
                                                <p class="mb-2">Total Projects</p>
                                                <h4 class="counter">{{ $projects ?? 0 }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </li> --}}
                            </ul>
                            <div class="swiper-button swiper-button-next"></div>
                            <div class="swiper-button swiper-button-prev"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                @if (session()->get('type') == 'admin')
                    <div class="col-md-6">
                        <div class="card p-3">

                            <div class="row">
                                {{-- <div style="width: 300px; height: 200px">
                            <canvas id="myChart"></canvas>
                                </div> --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">From Date</label>
                                        <input class="form-control" type="date" name="from_date" id="from_date">
                                    </div>
                                    {{-- <div class="form-group">
                                        <label for="">Year</label>
                                        <select class="form-control" name="yearSelect" id="yearSelect">
                                            <!-- JavaScript will populate options -->
                                        </select>
                                    </div> --}}

                                </div>
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="">To Date</label>
                                        <input class="form-control" type="date" name="to_date" id="to_date">
                                    </div>
                                    {{-- <div class="form-group">

                                        <label for="">Month</label>
                                        <select class="form-control" name="monthSelect" id="monthSelect">
                                            <option value="all">All</option>
                                            <option value="Jan">Jan</option>
                                            <option value="Feb">Feb</option>
                                            <option value="Mar">Mar</option>
                                            <option value="Apr">Apr</option>
                                            <option value="May">May</option>
                                            <option value="Jun">Jun</option>
                                            <option value="Jul">Jul</option>
                                            <option value="Aug">Aug</option>
                                            <option value="Sep">Sep</option>
                                            <option value="Oct">Oct</option>
                                            <option value="Nov">Nov</option>
                                            <option value="Dec">Dec</option>
                                        </select>
                                    </div> --}}
                                </div>
                                <div style="width:100%;height:250px">
                                    <canvas width="200px" id="IncomeExpenseChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card p-3">

                            <div class="row">
                                {{-- <div style="width: 300px; height: 200px">
                            <canvas id="myChart"></canvas>
                        </div> --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Year</label>
                                        <select class="form-control" name="currentYear" id="currentYear">
                                            <!-- JavaScript will populate options -->
                                        </select>
                                    </div>
                                </div>

                                <div style="width:100%;height: 248px;">
                                    <canvas id="profitChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="card">

                @if (session()->get('type') != 'contractor')

                    <div class="card-header">
                        <div class="header-title">
                            <h4 class="card-title">Contractors Invitation</h4>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase" width="60%">Contractor</th>
                                        <th class="text-uppercase" width="20%">Cost</th>
                                        <th class="text-uppercase" width="20%">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($contractorInvitation) > 0)
                                        @foreach ($contractorInvitation as $contractor)
                                            <tr>
                                                <td>{{ $contractor->contractor }}</td>
                                                <td>€{{ $contractor->price }}</td>
                                                <td>
                                                    @if ($contractor->status == 0)
                                                        <span class="badge bg-secondary">Pending</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                <div class="card-body">
                    <div class="row">

                        <div class="col-sm-12">
                            <!-- <h3>Calendar</h3> -->
                            <div id="projects_calendar"></div>
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
    <script>
        $(document).ready(function() {
            // Call the function to populate the "Year" dropdown on page load
            populateYearDropdown();
            get_income_expense_chart();

            fetchProfitDataAndUpdateChart();
            var profitChart;

            var IncomeExpenseChart = document.getElementById("IncomeExpenseChart").getContext("2d");
            // Function to fetch data from the controller through AJAX and add event
            // Event listener for the "Year" and "Month" dropdowns change event
            $('input[name="to_date"], input[name="from_date"]').change(function() {
                get_income_expense_chart();
            });

            // Event listener for the "Year" and "Month" dropdowns change event
            $('select[name="currentYear"]').change(function() {
                fetchProfitDataAndUpdateChart();
            });

            // Function to fetch data from the controller through AJAX and add event
            function get_income_expense_chart() {
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();
                var year = $('#yearSelect').val();
                var month = $('#monthSelect').val();

                // AJAX call to the API endpoint on the controller
                $.ajax({
                    url: "{{ route('admin:get_income_expense_chart') }}",
                    type: 'POST',
                    data: {
                        '_token': "{{ csrf_token() }}",
                        from_date: from_date,
                        to_date: to_date,
                    },
                    success: function(response) {
                        if (myChart) {
                            myChart.data.datasets[0].data = [response.income, response.expense];
                            myChart.update();
                        } else {
                            myChart = new Chart(IncomeExpenseChart, {
                                type: "pie",
                                data: {
                                    labels: ["Income", "Expense"],
                                    datasets: [{
                                        backgroundColor: ["#2ecc71", "#3498db"],
                                        data: [response.income, response.expense],
                                    }],
                                },
                            });
                        }
                    },
                });
            }


            // Function to fetch profit data from the server through AJAX and update the chart
            function fetchProfitDataAndUpdateChart() {
                var year = $('#currentYear').val();

                // AJAX call to the API endpoint on the controller
                $.ajax({
                    url: "{{ route('admin:get_profit_data') }}",
                    type: 'POST',
                    data: {
                        year: year,
                        '_token': "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        // Update the chart data and re-render it
                        if (profitChart) {
                            profitChart.data.labels = response.months;
                            profitChart.data.datasets[0].data = response.profit;
                            profitChart.data.datasets[0].label = 'Profit ' + response.year;
                            profitChart.data.datasets[1].data = response.previous_year_profit;
                            profitChart.data.datasets[1].label = 'Profit ' + (response.year - 1);
                            profitChart.update();
                        } else {
                            profitChart = new Chart(document.getElementById("profitChart").getContext(
                                "2d"), {
                                type: 'bar',
                                data: {
                                    labels: response.months,
                                    datasets: [{
                                        label: 'Profit ' + response.year,
                                        data: response.profit,
                                        backgroundColor: "rgba(0, 0, 255, 1)"
                                    }, {
                                        label: 'Profit ' + (response.year - 1),
                                        data: response.previous_year_profit,
                                        backgroundColor: "rgba(255, 0, 0, 1)"

                                    }]
                                }
                            });
                        }
                    }
                });
            }


            myChart = new Chart(IncomeExpenseChart, {
                type: "pie",
                data: {
                    labels: ["Income", "Expense"],
                    datasets: [{
                        backgroundColor: ["#2ecc71", "#3498db"],
                        data: [0, 0],
                    }],
                },
            });

        })
        // Function to populate the "Year" dropdown with the current year and past 5 years
        function populateYearDropdown() {
            const currentYear = new Date().getFullYear();
            // const yearSelect = document.getElementById("yearSelect");
            const currentYearForBar = document.getElementById("currentYear");
            // for (let year = currentYear; year >= currentYear - 5; year--) {
            //     const option = document.createElement("option");
            //     option.value = year;
            //     option.text = year;
            //     yearSelect.appendChild(option);
            // }
            for (let year = currentYear; year >= currentYear - 5; year--) {
                const option = document.createElement("option");
                option.value = year;
                option.text = year;
                currentYearForBar.appendChild(option);
            }
        }
    </script>
