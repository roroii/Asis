
@extends('layouts.app')
<link rel="stylesheet" ref="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
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
                <tbody>

                </tbody>
            </table>
        </div>
        <div class="full-calendar fc fc-media-screen fc-direction-ltr fc-theme-standard" >
            <div id='calendar'></div>
        </div>
    </div>

@endsection
@section('scripts')
<script>
    $(document).ready(function () {
        var calendar = $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,basicWeek,basicDay'
            },
            navLinks: true,
            editable: true,
            events: "getevent",
            displayEventTime: false,
            eventRender: function (event, element, view) {
                if (event.allDay === 'true') {
                    event.allDay = true;
                } else {
                    event.allDay = false;
                }
            },
        selectable: true,
        selectHelper: true,
        select: function (start, end, allDay) {
            var title = prompt('Event Title:');
            if (title) {
                var start = moment(start, 'DD.MM.YYYY').format('YYYY-MM-DD');
                var end = moment(end, 'DD.MM.YYYY').format('YYYY-MM-DD');
                $.ajax({
                    url: 'createevent',
                    data: 'title=' + title + '&start=' + start + '&end=' + end +'&_token=' +"{{ csrf_token() }}",
                    type: "post",
                    success: function (data) {
                        alert("Added Successfully");
                    }
                });
                calendar.fullCalendar('renderEvent',
                        {
                            title: title,
                            start: start,
                            end: end,
                            allDay: allDay
                        },
                true
                        );
            }
            calendar.fullCalendar('unselect');
        },
        eventClick: function (event) {
            var deleteMsg = confirm("Do you really want to delete?");
            if (deleteMsg) {
                $.ajax({
                    type: "POST",
                    url: "delete",
                    data: "&id=" + event.id+'&_token=' +"{{ csrf_token() }}",
                    success: function (response) {
                        if(parseInt(response) > 0) {
                            $('#calendar').fullCalendar('removeEvents', event.id);
                            alert("Deleted Successfully");
                        }
                    }
                });
            }
        }
        });
    });
</script>
@endsection

