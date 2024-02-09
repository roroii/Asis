var  _token = $('meta[name="csrf-token"]').attr('content');
var bpath;



$(document).ready(function (){

    bpath = __basepath + "/";

    validateInputSchedule();

    // loadCreatedSchedule();
    AddSchedule();
    saveAddedSchedule();
    loadAppointments();

    ApproveAppointment();
    DisapproveAppointment();
    searchNameRecentActivities();

});

function AddSchedule(){

    $('body').on('click', '.btn_add_enrollees_schedule', function(){

        __modal_toggle('add_schedule_mdl');

    });

}

function validateInputSchedule(){

    $('.input_slots').on('input', function() {

        var input = $(this);
        var value = input.val();

        // Remove leading minus sign
        if (value.startsWith('-')) {
            value = value.slice(1);
            input.val(value);
        }

        // Ensure the input is a valid number and greater than or equal to 1
        if (isNaN(value) || parseFloat(value) < 1) {
            input.val('');
        }
    });

}

function loadCreatedSchedule(){

    $.ajax({
        url: bpath + 'enrollees/load/schedule',
        type: "POST",
        data: {
            _token: _token,
        },
        success: function (response) {
            if(response)
            {
                let data = JSON.parse(response);
                let status = data['status'];
                let html_data = data['html_data'];

                if (status === 200)
                {
                    // console.log(html_data);

                    $('#calendar-events').html(html_data);
                }
            }
        }
    });

}

function saveAddedSchedule()    {

    $('body').on('click', '#save_schedule', function(){

        let button_state = $(this).text();

        let form_data = {
            _token,
            button_state : button_state,
            schedule_id : $('.schedule_id').val(),
            schedule_date : $('.schedule_date').val(),
            slot_type   : $('.slot_type').val(),
            input_slots : $('.input_slots').val(),
        }

        showLoading();

        $.ajax({
            url: bpath + 'enrollees/save/schedule',
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
                        clearInputs();
                        FullCalendarInstance();
                        __modal_hide('add_schedule_mdl');
                        hideLoading();
                    }
                }
            }
        });
    });

}

function clearInputs(){

    $('.schedule_id').val('');
    $('.input_slots').val('');
    $('.slot_type').val('A.M').trigger('change');

}

function loadAppointments(){

    $.ajax({
        url: bpath + 'enrollees/load/appointments',
        type: "POST",
        data: {_token},
        success: function (response) {

            if (response) {
                let data = JSON.parse(response);
                let default_photo = data['default_photo'];
                let status = data['status'];
                let html_data = data['html_data'];


                let default_html = '' +
                    '<div class="intro-x card_activity">' +
                    '   <div class="box px-5 py-3 mb-3 flex items-center zoom-in">' +
                    '       <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">' +
                    '           <img alt="Profile_Pic" src="'+default_photo+'">' +
                    '       </div>' +
                    '       <div class="ml-4 mr-auto">' +
                    '           <div class="font-medium">No Available Data!</div>' +
                    '        </div>' +
                    '        </div>' +
                    '</div>'+
                    '';


                if (status === 200) {

                    if(html_data)
                    {
                        $('.transaction_list_div').html(html_data);
                    }else
                    {
                        $('.transaction_list_div').html(default_html);
                    }

                }
            }

        }
    });

}

function ApproveAppointment(){

    $('body').on('click', '.card_activity', function(){

        let appointment_id = $(this).data('appointment-id');
        let schedule_id = $(this).data('schedule-id');
        let enrollees_id = $(this).data('enrollees-id');

        $('.appointment_schedule_id').val(appointment_id);
        $('.schedule_id').val(schedule_id);
        __modal_toggle('appointment_approve_mdl');

    });


    $('body').on('click', '#btn_approve_appointment', function(){

        showLoading();

        let button_state = 'APPROVE';

        let form_data = {
            _token,
            button_state,
            appointment_id : $('.appointment_schedule_id').val(),
            schedule_id : $('.schedule_id').val(),
        }

        $.ajax({
            url: bpath + 'enrollees/approve/disapprove/appointments',
            type: "POST",
            data: form_data,
            beforeSend: function () {

                showLoading();
                __modal_hide('appointment_approve_mdl');

            },
            success: function (response) {
                if(response)
                {
                    let data = JSON.parse(response);
                    let title = data['title'];
                    let status = data['status'];
                    let status_code = data['status_code'];
                    let message = data['message'];

                    // __notif_show(status, status_code, message);


                    Swal.fire({
                        icon: status,
                        title: title,
                        text: message,
                    });

                    FullCalendarInstance();
                    loadAppointments();

                }
            },
            complete: function () {

                hideLoading();
            }
        });
    });
}

function DisapproveAppointment(){

    $('body').on('click', '#btn_disapprove_appointment', function(){

        showLoading();

        let button_state = 'DISAPPROVE';

        let form_data = {
            _token,
            button_state,
            appointment_id : $('.appointment_schedule_id').val(),
            schedule_id : $('.schedule_id').val(),
        }

        $.ajax({
            url: bpath + 'enrollees/approve/disapprove/appointments',
            type: "POST",
            data: form_data,
            beforeSend: function () {

                showLoading();
            },
            success: function (response) {
                if(response)
                {
                    let data = JSON.parse(response);
                    let title = data['title'];
                    let status = data['status'];
                    let status_code = data['status_code'];
                    let message = data['message'];

                    // __notif_show(status, status_code, message);


                    Swal.fire({
                        icon: status,
                        title: title,
                        text: message,
                    });

                    FullCalendarInstance();
                    loadAppointments();

                }
            },
            complete: function () {

                hideLoading();
            }
        });


    });

}

function searchNameRecentActivities(){

    var searchTimeout;


    // Attach an event listener to the input field
    $('.input_search_name').on('input', function() {

        var searchTerm = $(this).val();
        clearTimeout(searchTimeout);

        searchTimeout = setTimeout(function () {
            // Make an Ajax request to your server or model
            $.ajax({
                url: bpath + 'enrollees/search/name/appointments',
                type: "POST",
                data: {_token, searchTerm},
                success: function (response) {
                    // Update the search results container with the received data
                    if (response) {
                        let data = JSON.parse(response);
                        let default_photo = data['default_photo'];
                        let status = data['status'];
                        let html_data = data['html_data'];

                        let default_html = '' +
                            '<div class="intro-x card_activity">' +
                            '   <div class="box px-5 py-3 mb-3 flex items-center zoom-in">' +
                            '       <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">' +
                            '           <img alt="Profile_Pic" src="'+default_photo+'">' +
                            '       </div>' +
                            '       <div class="ml-4 mr-auto">' +
                            '           <div class="font-medium">No Available Data!</div>' +
                            '        </div>' +
                            '        </div>' +
                            '</div>'+
                            '';

                        if(html_data)
                        {
                            $('.transaction_list_div').html(html_data);
                        }else
                        {
                            $('.transaction_list_div').html(default_html);
                        }



                    }
                },
                error: function (error) {
                    console.error('Error:', error);
                }
            });
        }, 500); // Adjust the delay time (in milliseconds) as needed
    });
}
