// Define the calendar variable in the global scope
var _token = $('meta[name="csrf-token"]').attr('content');

var selectedResource;
var selectedYear;
var selectedMonth;

var Draggable = FullCalendar.Draggable;

$(document).ready(function () {


    FullCalendarInstance();

    deleteSchedule();

    updateSchedule();

});

function FullCalendarInstance() {

    var selectedResourceValue = selectedResource;

    var calendar;
    var calendarEl = document.getElementById('admin_calendar');
    if (selectedYear >= 0 && selectedMonth >= 0) {

        var initialYear = selectedYear
        var initialMonth = selectedMonth

    } else{

        var initialYear = new Date().getFullYear();
        var initialMonth = new Date().getMonth();


    }

    calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'multiMonthYear,dayGridMonth'
        },
        aspectRatio: 1.5, // Adjust the aspect ratio for better display on small screens
        initialView: 'dayGridMonth',
        initialDate: new Date(initialYear, initialMonth, 1),
        editable: false,

        droppable: true,
        selectable: true,
        eventMaxStack: 4,
        dayMaxEvents: true,
        dayMaxEventRows: 10,
        multiMonthMinWidth: 250,
        multiMonthMaxColumns: 3,
        eventDisplay: 'list-item',
        eventOverlap: false,
        events: function (fetchInfo, successCallback, failureCallback) {
            $.ajax({
                url: bpath + 'enrollees/load/schedule',
                method: 'POST',
                type: "POST",
                data: {
                    _token,
                },
                dataType: 'json',
                success: function (response) {

                    if(response)
                    {
                        var events = response.map(function (item) {

                            return {
                                id: item.id,
                                title: item.title,
                                description: item.slots + ' Slots',
                                className: "bg-primary",
                                start: new Date(item.date), // Use the correct timezone here

                            };
                        });

                        successCallback(events);
                    }


                },
                error: function (xhr, status, error) {
                    failureCallback(error);
                }
            });
        },

        eventClick: function (info) {
            // Handle the click event here
            var event = info.event;
            var description = event.extendedProps.description; // Get the description
            var eventStart = info.event.start; // This is the start date of the clicked event

            var isoDate = eventStart.toISOString().split('T')[0];

            var numericString = description.replace(/\D/g, '');

            // Convert the numeric string to an integer
            var numericValue = parseInt(numericString, 10);


            $('.modal_title').text('Update Schedule')
            $('#save_schedule').text('Update')


            // __modal_toggle('add_schedule_mdl');


            $('.schedule_up_id').val(event.id);
            $('.schedule_up_date').val(isoDate);
            $('.input_up_slots').val(numericValue);
            $('.slot_up_type').val(event.title);

            __modal_toggle('delete_update_mdl');

        },

        dateClick: function (info) {

            if (info.dateStr !== null) {

                clearInputFields();

                $('.modal_title').text('Add Schedule')
                $('#save_schedule').text('Add')

                let date_selected = info['dateStr'];

                $('#schedule_date').val(date_selected);
                __modal_toggle('add_schedule_mdl');


            }
        },

        eventContent: function (arg) {

            return {

                html: '' +
                    '<a class="fc-h-event fc-event fc-event-draggable">' +
                    '   <div class="fc-event-main">' +
                    '       <div class="fc-event-main-frame">' +
                    '           <div class="fc-event-title-container">' +
                    '               <div class="fc-event-title fc-sticky">'+ arg.event.title + ' - ' + arg.event.extendedProps.description+'</div>' +
                    '           </div>' +
                    '       </div>' +
                    '   </div>' +
                    '</a>',
            };
        }

    });

    var mediaQuery = window.matchMedia('(max-width: 300px)');
    if (mediaQuery.matches) {
        calendar.setOption('dayHeaderContent', function (info) {
            return '<span class="custom-day-header">' + info.dayNumberText + '</span>';
        });

        calendar.setOption('dayCellContent', function (info) {
            return '<span class="custom-day-cell">' + info.dayNumberText + '</span>';
        });
    }

    calendar.render();

    myDraggable();

}


function getEventsOnDay(date) {
    var events = calendar.getEvents();
    var eventsOnDay = [];

    events.forEach(event => {
        if (event.start.toDateString() === date.toDateString()) {
            eventsOnDay.push(event);
        }
    });

    return eventsOnDay;
}

function handleWindowResize() {
    calendar.windowResize();
}

function myDraggable(){

    if ($("#admin_calendar").length) {
        if ($("#calendar-events").length) {
            new Draggable($("#calendar-events")[0], {
                itemSelector: ".fc-event",
                eventData: function eventData(eventEl) {
                    return {
                        title: $(eventEl).find(".event__title").html(),
                        duration: {
                            days: parseInt($(eventEl).find(".event__days").text())
                        }
                    };
                }
            });
        }
    }

}

function clearInputFields(){

    $('.slot_type').val('AM').trigger('change');
    $('.input_slots').val(null);
    $('.schedule_id').val(null);

}

function deleteSchedule(){

    $('body').on('click', '#mdl_btn_delete_schedule', function() {

        let schedule_id =  $('.schedule_up_id').val();

        $('.delete_schedule_id').val(schedule_id);

        __modal_toggle('delete_mdl');
        __modal_hide('delete_update_mdl');

    });

    $('body').on('click', '#btn_final_delete', function(){

        let form_data = {
            _token,
            delete_schedule_id : $('.delete_schedule_id').val(),
        }

        showLoading();

        $.ajax({
            url: bpath + 'enrollees/delete/schedule',
            type: "POST",
            data: form_data,
            success: function (response) {
                if(response)
                {
                    let data = JSON.parse(response);
                    let status = data['status'];
                    let message = data['message'];

                    if (status === 200)
                    {
                        __notif_show(1, 'Success', message);
                        $('.delete_schedule_id').val(null);
                        FullCalendarInstance();
                        __modal_hide('delete_mdl');
                        hideLoading();
                    }
                }
            }
        });
    });

}

function updateSchedule(){

    $('body').on('click', '#mdl_btn_update_schedule', function(){


        let schedule_id =  $('.schedule_up_id').val();
        let schedule_date =  $('.schedule_up_date').val();
        let input_slots =  $('.input_up_slots').val();
        let slot_type =  $('.slot_up_type').val();

        $('.schedule_id').val(schedule_id);
        $('.schedule_date').val(schedule_date);
        $('.input_slots').val(input_slots);
        $('.slot_type').val(slot_type);

        __modal_toggle('add_schedule_mdl');
        __modal_hide('delete_update_mdl');


    });

}

