<!-- Library Bundle Script -->
<script src="{{ asset('admin/js/core/libs.min.js') }}"></script>
<!-- Include jQuery UI library -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

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
<script src="{{ asset('admin/vendor/aos/dist/aos.js') }}"></script>

<!-- App Script -->
<script src="{{ asset('admin/js/hope-ui.js') }}" defer></script>

{{-- calendar script --}}
<script src="{{ asset('admin/js/calendar/calendar.js') }}"></script>

<script>
    // to initialize calendar

    var eventsUrl = "{{ route('admin:dashboard_calendar') }}";

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('projects_calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            events: eventsUrl,
            eventDidMount: function(info) {
                if (info.event.allDay) {
                    var allDayEl = info.el.querySelector('.fc-daygrid-day-top');
                    allDayEl.style.height = '50px';
                }
            },
            themeSystem: 'bootstrap',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek,dayGridDay'
            },

            eventClick: function(calEvent) {

                let info = calEvent.event
                let data = info.extendedProps
                let link = data.details.link;
                window.location.href = link;
            },

            // contentHeight: '300px',
            eventDidMount: function(info) {
                var eventEl = info.el;
                // add margin
                eventEl.style.margin = '2px';
            }
        });
        calendar.render();

    });
</script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    @endif

    @if (session('success'))
        toastr.success('{{ session('success') }}');
    @endif
</script>

</body>

</html>
