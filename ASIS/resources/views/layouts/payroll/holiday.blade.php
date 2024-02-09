
@extends('layouts.app')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
@section('content')

    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Holidays
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            {{-- <button id="make_travel_order" class="btn btn-primary shadow-md mr-2" href="javascript:;" data-tw-toggle="modal" data-tw-target="#modal_set_payroll">Employee</button> --}}
            {{-- <a class='btn btn-info' href='{{url("travel/order/travelorder-export")}}'>Export Excel</a> --}}
            <div class="w-full sm:w-auto flex">
                <button type="button" class="btn btn-primary shadow-md mr-2 user_priv_table_updated" data-tw-toggle="modal" data-tw-target="#modal_payroll_info"> <i class="w-4 h-4 mr-2" data-lucide="settings"></i> Add Holiday </button>

            </div>
        </div>
    </div>
    <div class="intro-y box p-5 mt-5">

        <div class="overflow-x-auto scrollbar-hidden pb-10">
            <table id="dt__created_holiday_date" class="table table-report -mt-2 table-hover">
                <thead>
                <tr>
                    <th style="display: none" class="text-center whitespace-nowrap ">#ID</th>
                    <th class="text-center whitespace-nowrap">Date</th>
                    <th class="text-center whitespace-nowrap">Description</th>
                    <th class="text-center whitespace-nowrap">Type</th>
                    <th class="text-center whitespace-nowrap">Action</th>
                </tr>
                </thead>
                <tbody></tbody>

                </tbody>
            </table>
        </div>
        <div class="full-calendar fc fc-media-screen fc-direction-ltr fc-theme-standard" >
            <div class="full-calendar fc fc-media-screen fc-direction-ltr fc-theme-standard" id='full_calendar_events'></div>
        </div>
    </div>

@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
<script>
    $(document).ready(function () {
        var SITEURL = "{{ url('/') }}";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var calendar = $('#full_calendar_events').fullCalendar({
            editable: true,
            editable: true,

            events: SITEURL + "/calendar-event",
            displayEventTime: true,
            eventRender: function (event, element, view) {
                if (event.allDay === 'true') {
                    event.allDay = true;
                } else {
                    event.allDay = false;
                }
            },
            selectable: true,
            selectHelper: true,
            select: function (event_start, event_end, allDay) {
                var event_name = prompt('Event Name:');
                if (event_name) {
                    var holiday_date = $.fullCalendar.formatDate(event_start, "Y-MM-DD");
                    var event_start = $.fullCalendar.formatDate(event_start, "Y-MM-DD HH:mm:ss");
                    var event_end = $.fullCalendar.formatDate(event_end, "Y-MM-DD HH:mm:ss");
                    $.ajax({
                        url: SITEURL + "/calendar-crud-ajax",
                        data: {
                            event_name: event_name,
                            date: holiday_date,
                            event_start: event_start,
                            event_end: event_end,
                            type: 'create'
                        },
                        type: "POST",
                        success: function (data) {
                            displayMessage("Event created.");
                            calendar.fullCalendar('renderEvent', {
                                id: data.id,
                                title: event_name,
                                date: holiday_date,
                                start: event_start,
                                end: event_end,
                                allDay: allDay
                            }, true);
                            calendar.fullCalendar('unselect');
                        }
                    });
                }
            },
            eventDrop: function (event, delta) {
                var holiday_date = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                var event_start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                var event_end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
                $.ajax({
                    url: SITEURL + '/calendar-crud-ajax',
                    data: {
                        title: event.event_name,
                        date: holiday_date,
                        start: event_start,
                        end: event_end,
                        id: event.id,
                        type: 'edit'
                    },
                    type: "POST",
                    success: function (response) {
                        displayMessage("Event updated");
                    }
                });
            },
            eventClick: function (event) {
                var eventDelete = confirm("Are you sure?");
                if (eventDelete) {
                    $.ajax({
                        type: "POST",
                        url: SITEURL + '/calendar-crud-ajax',
                        data: {
                            id: event.id,
                            type: 'delete'
                        },
                        success: function (response) {
                            calendar.fullCalendar('removeEvents', event.id);
                            displayMessage("Event removed");
                        }
                    });
                }
            }
        });
    });
    function displayMessage(message) {
        toastr.success(message, 'Event');
    }


</script>

@endsection

