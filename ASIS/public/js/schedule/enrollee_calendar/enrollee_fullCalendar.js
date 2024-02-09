// Define the calendar variable in the global scope
var _token = $('meta[name="csrf-token"]').attr('content');

var selectedResource;
var selectedYear;
var selectedMonth;


$(document).ready(function () {


    enrolleesFullCalendarInstance();


    submitAppointment();

});

function enrolleesFullCalendarInstance() {

    var enrolleesCalendar;
    var calendarEl = document.getElementById('enrollees_calendar');
    if (selectedYear >= 0 && selectedMonth >= 0) {

        var initialYear = selectedYear
        var initialMonth = selectedMonth

    } else{

        var initialYear = new Date().getFullYear();
        var initialMonth = new Date().getMonth();


    }

    enrolleesCalendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'multiMonthYear,dayGridMonth'
        },
        aspectRatio: 1.5, // Adjust the aspect ratio for better display on small screens
        initialView: 'dayGridMonth',
        initialDate: new Date(initialYear, initialMonth, 1),
        editable: false,

        droppable: false,
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
                url: bpath + 'enrollees/load/enrollees/schedule',
                method: 'POST',
                type: "POST",
                data: {
                    _token,
                },
                dataType: 'json',
                success: function (response) {

                    if (response) {
                        var events = response.map(function (item) {

                            return {
                                id: item.id,
                                title: item.title,
                                description: item.slots + ' Slots',
                                className: "bg-primary",
                                start: new Date(item.date), // Use the correct timezone here
                                // editable: true, // You can make individual events draggable as well
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

            const formattedDate = formatDate(eventStart);
            let campus = 'Davao del Sur State College - Main Campus';
            let address = 'Brgy. Matti, Digos City, Davao del Sur';


            $('.scheduled_date').text(formattedDate +' - '+ event.title);
            $('.scheduled_date_text').val(formattedDate +' - '+ event.title);
            $('.scheduled_date_value').val(isoDate);
            $('.scheduled_date_id').val(event.id);
            $('.scheduled_campus').text(campus);
            $('.campus_address').text(address);

            $('#btn_submit_appointment').addClass('fa-beat');


            setTimeout(function () {
                $('#btn_submit_appointment').removeClass('fa-beat');
            }, 2000);

        },

        eventContent: function (arg) {
            return {

                html: '' +
                    '<a class="fc-daygrid-event fc-daygrid-block-event fc-h-event fc-event fc-event-draggable fc-event-resizable fc-event-start fc-event-end fc-event-past">' +
                    '   <div class="fc-event-main">' +
                    '       <div class="fc-event-main-frame">' +
                    '           <div class="fc-event-title-container">' +
                    '               <div class="fc-event-title fc-sticky">' + arg.event.title + ' - ' + arg.event.extendedProps.description + '</div>' +
                    '           </div>' +
                    '       </div>' +
                    '   </div>' +
                    '</a>',
            };
        }

    });

    var mediaQuery = window.matchMedia('(max-width: 300px)');
    if (mediaQuery.matches) {
        enrolleesCalendar.setOption('dayHeaderContent', function (info) {
            return '<span class="custom-day-header">' + info.dayNumberText + '</span>';
        });

        enrolleesCalendar.setOption('dayCellContent', function (info) {
            return '<span class="custom-day-cell">' + info.dayNumberText + '</span>';
        });
    }

    enrolleesCalendar.render();


}


function formatDate(inputDate) {
    const options = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    };
    const date = new Date(inputDate);
    return date.toLocaleDateString('en-US', options);
}

function submitAppointment(){

    $('body').on('click', '#btn_submit_appointment', function(){

        let appointment_date = $('.scheduled_date_text').val();
        let appointment_id = $('.scheduled_date_id').val();
        let campus = 'Davao del Sur State College - Main Campus';
        let address = 'Brgy. Matti, Digos City, Davao del Sur';

        if(appointment_id)
        {
            $('.confirm_scheduled_date_id').val(appointment_id);

            $('.confirm_scheduled_date').text(appointment_date);
            $('.confirm_scheduled_campus').text(campus);
            $('.confirm_campus_address').text(address);

            __modal_toggle('appointment_confirmation_mdl');
        }else
        {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Please please click on the AM or PM button',
            });

            // __notif_show(-1,'Warning', 'Please please click on the AM or PM button');
        }
    });

    $('body').on('click', '#btn_confirm_appointment', function(){

        let form_data = {
            _token,
            confirm_scheduled_date_id :  $('.confirm_scheduled_date_id').val(),
        }

        showLoading();
        $.ajax({
            url: bpath + 'enrollees/submit/appointment',
            type: "POST",
            data: form_data,
            success: function (response) {

                if(response)
                {
                    let data = JSON.parse(response);
                    let status = data['status'];
                    let title = data['title'];
                    let status_code = data['status_code'];
                    let message = data['message'];

                    // __notif_show(status_code , status, message);
                    __modal_hide('appointment_confirmation_mdl');
                    hideLoading();

                    Swal.fire({
                        icon: status,
                        title: title,
                        text: message,
                    });
                }

            }
        });

    });

}
