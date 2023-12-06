@include('admin.layouts.head')

<head>
    <style>
        td.index {
            cursor: move;
        }

        td:hover {
            cursor: move;
        }
    </style>
</head>

<body>
    @include('admin.layouts.sidebar')
    <main class="main-content">

        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif

        <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="event_status">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Project Status</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="event_id" id="event_id">
                            <label for="" class="mb-2">Status</label>
                            <select name="status" class="form-control" id="status">
                                <option value="pending">Pending</option>
                                <option value="in-progress">In Progress</option>
                                <option value="complete">Completed</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="close">Close
                            </button>
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="position-relative iq-banner">
            <!--Nav Start-->
            @include('admin.layouts.nav')
            <div class="iq-navbar-header" style="height: 80px;"></div>
            <!--Nav End-->
        </div>
        <div class="conatiner-fluid content-inner mt-n5 py-0">
            <div>
                <div id="successMessage" class="alert alert-success" style="display: none;"></div>

                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-md-6 text-start">
                                        <h4 class="card-title">{{$project->name}}'s Events Details</h4>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="eventsTable" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-uppercase">Action</th>
                                                <th scope="col" class="text-uppercase">Status</th>
                                                <th scope="col" class="text-uppercase">Date</th>
                                                <th scope="col" class="text-uppercase">Old Date</th>
                                                <th scope="col" class="text-center text-uppercase">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $currentDate = null;
                                            @endphp
                                            @foreach ($events as $event)
                                                @php
                                                    $eventDate = $event->action_date;
                                                @endphp

                                                @if ($eventDate != $currentDate)
                                                    @php
                                                        $currentDate = $eventDate;
                                                    @endphp

                                                    <tr class="groupEventDate bg-light" row-date="{{ $currentDate }}"
                                                        id="date-row-{{ $currentDate }}">
                                                        <td colspan="5">{{ $currentDate }}</td>
                                                    </tr>
                                                @endif

                                                <!-- Update your HTML to include a data attribute on the date td element -->
                                                <tr class="draggable-row" id="{{ $event->id }}">
                                                    <input type="text" value="{{ $event->id }}" name="event_id"
                                                        hidden="">
                                                    <td> {{ $event->action ?? 'N/A' }} </td>
                                                    <td> {{ $event->status ?? 'N/A' }} </td>
                                                    <td data-date="{{ $eventDate }}"
                                                        class=" @if ($event->action_date < now() && $event->status !== 'completed') text-danger font-weight-bold @endif">
                                                        {{ $eventDate }}
                                                    </td>
                                                    <!-- Add data-date attribute -->
                                                    <td
                                                        class=" @if ($event->old_date < now() && $event->status !== 'completed') text-danger font-weight-bold @endif">
                                                        {{ $event->old_date ?? '' }}
                                                    </td>

                                                    <td>
                                                        <a href="javascript:void(0)" class="change_status py-1 px-2"
                                                            data-bs-toggle="modal" data-bs-target="#exampleModal1"
                                                            data-id="{{ $event->id }}">
                                                            <i class="fa fa-arrow-up text-primary"></i>
                                                        </a>
                                                        <a href="javascript:void(0)" class="text-primary edit_event_"
                                                            data-id="{{ $event->id }}">
                                                            <i class="fa fa-edit"></i>
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
        </div>

        <div class="modal fade" id="viewEditEventModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    {{-- <form action="javascript:void(0)" method="post" id="saveNewEvent" data-parsley-validate
                enctype="multipart/form-data"> --}}
                    <form id="edit_event">
                        @csrf
                        <div class="modal-body">
                            <div class="container-fluid">

                                <h3>Edit Event</h3>
                                <hr />
                                <div class="edit_event_notify"></div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <input type="hidden" name="event_id" class="event_id">
                                            <input type="hidden" name="project_id"
                                                value="{{ $project->project_id }}">
                                            <label class="control-label mb-0 text-end">Action</label>
                                            <input type="text" class="form-control form-contol-sm act_name"
                                                id="modal_action_name" name="act_name" required />
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label mb-0 text-end">Date</label>
                                            <input type="date" class="form-control form-contol-sm act_date"
                                                id="modal_action_date" name="act_date" required />
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label mb-0 text-end">Old Date</label>
                                            <input type="date" class="form-control form-contol-sm old_date"
                                                id="modal_old_date" name="old_date" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-primary">Update Event</button>
                            <button type="button" class="btn btn-sm btn-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        @include('admin.layouts.footer')

    </main>
    @include('admin.layouts.script')

    <script>
        $(function() {
            $('.edit_event_').click(function() {
                var event_id = $(this).attr('data-id');
                var modal = $('#viewEditEventModal');
                $.ajax({
                    url: "{{ route('Event:find') }}",
                    type: 'POST',
                    cache: false,
                    data: {
                        _token: '{{ csrf_token() }}',
                        'id': event_id,
                    },
                    success: function(response) {
                        console.log(response);
                        modal.find('.event_id').val(response.id);
                        modal.find('.act_name').val(response.action);
                        modal.find('.act_date').val(response.action_date);
                        modal.find('.old_date').val(response.old_date);
                    }
                });
                $('#viewEditEventModal').modal('show')
            })

            $("#eventsTable tbody").sortable({
                items: "tr.draggable-row",
                stop: function(event, ui) {
                    var reorderedIds = $("#eventsTable tbody tr").map(function() {
                        return this.id;
                    }).get();

                    var draggedRowId = ui.item.attr("id");
                    var droppedRowIndex = reorderedIds.indexOf(draggedRowId);

                    // Find the next row after the dragged row
                    var nextRow = ui.item.next();

                    // Fetch the date of the dragged row
                    var draggedRowDate = ui.item.find("td[data-date]").data("date");

                    var droppedRowId = ui.item.next("tr").attr("id"); // Assuming IDs are on the rows

                    var droppedRowDate = ui.item.prevAll("tr.groupEventDate:first").attr('row-date');

                    // Attempt to fetch the date of the dropped row
                    // var droppedRowDate = nextRow.find("td[data-date]").data("date");

                    // If the droppedRowDate is still undefined, try finding it in the next row with class "draggable-row"
                    // if (typeof groupEventRowDate === "undefined") {
                    //     var droppedRow = nextRow.nextAll(".draggable-row:first");
                    //     droppedRowDate = droppedRow.find("td[data-date]").data("date");
                    // }

                    // when date change then update it on db
                    if (droppedRowDate != draggedRowDate) {
                        // Send AJAX request to update the dragged row's date
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('project:updateEventDates') }}',
                            data: {
                                'dragged_row_id': draggedRowId,
                                'dragged_row_date': draggedRowDate, // Include the dragged row's date
                                'dropped_row_id': droppedRowId, // Include the ID of the dropped row
                                'dropped_row_date': droppedRowDate, // Include the dropped row's date
                                '_token': '{{ csrf_token() }}'
                            },
                            success: function(data) {
                                // Handle the success response    
                                // Display a success message
                                toastr.success(data.message);
                                location.reload();
                            },
                            error: function(error) {
                                // Handle errors
                                console.log('Error:', error);
                            }
                        });

                    }

                }
            }).disableSelection();
        });


        $(document).ready(function() {
            // Function to retrieve event details
            function getEventDetails(eventId) {
                $.ajax({
                    url: "{{ route('Event:find') }}",
                    type: 'post',
                    data: {
                        _token: '{{ csrf_token() }}',
                        'id': eventId
                    },
                    success: function(response) {
                        console.log(response);
                        let event_id = response.id;
                        let status = response.status;
                        $("#event_id").val(event_id);
                        $("#status").val(status);
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            }

            // Handle click on "Status" button
            $(".change_status").click(function() {
                let code = $(this).attr("data-id");
                getEventDetails(code);

                // Submit the form when the modal's "Update" button is clicked
                $('#event_status').submit(function(e) {
                    e.preventDefault();

                    var event_id = $('#event_id').val();
                    var status = $('#status').val();

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('project:event.updateStatus') }}',
                        data: {
                            event_id: event_id,
                            status: status,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            // Handle success response
                            $('#exampleModal1').modal('hide'); // Hide the modal
                            location.reload();

                        },
                        error: function(error) {
                            // Handle error
                            console.error('Error:', error);
                        }
                    });
                });
            });
        });

        $(document).on("submit", "#edit_event", function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: "{{ route('project:edit_event') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status == "true") {
                        $(".edit_event_notify").html(
                            `
                            <div class="alert alert-left alert-success alert-dismissible fade show mb-3" role="alert">
                                <span> ` + response.msg + `!</span>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            `
                        ), setTimeout(function() {
                            $(".edit_event_notify").html(``);
                            location.reload();
                        }, 2000);
                    }
                    if (response.status == "false") {
                        $(".edit_event_notify").html(
                            `<div class="alert alert-left alert-danger alert-dismissible fade show mb-3" role="alert">
                                <span> ` + response.msg + `!</span>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`), setTimeout(function() {
                            $(".edit_event_notify").html(``);
                        }, 2000);
                    }
                }
            });
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
