var _token = $('meta[name="csrf-token"]').attr('content');

var filterDate;
var bdayPicker;
var currentStep = 1;

$(document).ready(function () {

    addEmailFindAccount();

    birthDatePicker();

    find_my_bDate();

    sendEmailVerification();

    $('.label_instructions').text('To start off, please enter your birthdate!')

});

function addEmailFindAccount(){

    $('body').on('click', '.btn_add_email', function (){

        __modal_toggle('find_my_account_mdl');
        $(this).removeClass('fa-beat');
        let student_id = $(this).data('student-id');

        $.ajax({
            url: '/get/my/attempts',
            type: 'POST',
            data: { student_id  },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': _token,
            },
            beforeSend: function () {


            },
            success: function (data) {

                let attempts = data['attempts'];

                let global_attempts = data['global_attempts'];

                // if(attempts > global_attempts)
                // {
                //     $('.label_attempts').text(global_attempts);
                //     $('#input_attempt_count').val(attempts);
                // }else
                // {
                //     $('.label_attempts').text(0);
                //     $('#input_attempt_count').val(0);
                // }

                $('.label_attempts').text(attempts);
                $('#input_attempt_count').val(attempts);

            },
            complete: function () {




            }
        });

    });


}


/*  FOR MODALS HERE */
function __modal_toggle(modal_id){

    const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#'+modal_id));
    mdl.toggle();

}

function __modal_hide(modal_id){

    const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#'+modal_id));
    mdl.hide();

}

function birthDatePicker(){

    let element_id = 'auth_bday';

    bdayPicker = new Litepicker({
        element: document.getElementById(element_id),
        autoApply: false,
        singleMode: true,
        numberOfColumns: 1,
        numberOfMonths: 1,
        showWeekNumbers: false,
        startDate: new Date(),
        format: 'DD MMM, YYYY',
        allowRepick: true,
        dropdowns: {
            minYear: 1950,
            maxYear: 2100,
            months: true,
            years: true
        }
    });


    // Add an event listener for the "selected" event
    bdayPicker.on('selected', function (date) {

        // Access different parts of the selected date
        var selectedDay = date.getDate().toString().padStart(2, '0');
        var selectedMonth = pad(date.getMonth() + 1); // Months are zero-based, so add 1
        var selectedYear = date.getFullYear();


        filterDate = selectedYear+'-'+selectedMonth+'-'+selectedDay;


    });


}

function find_my_bDate(){

    let count = 0;
    let new_attempts;

    $('body').on('click', '.btn_search_my_bdate', function(){

        let is_enabled = $(this).data('is-enabled');

        if(!filterDate)
        {
            var currentDate = new Date();
            filterDate = formatDate(currentDate);

        }

        count++;


        let my_attempts = $('#input_attempt_count').val();

        let count_attempts = parseInt(my_attempts)+count;

        let data = {
            _token,
            birtDate  :  filterDate,
            student_id : $('.student_id_email').val(),
            attempt_count : count_attempts,
        };


        $.ajax({
            url: '/find/my/birthDate',
            type: 'POST',
            data: data,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': _token,
            },
            beforeSend: function () {


            },
            success: function (data) {

                let has_valid_birthDate = data['has_valid_birthDate'];
                let attempts = data['attempt_counter'];
                let email_input_html = data['email_input_html'];
                let modal_footer = data['modal_footer'];
                let students_id = data['students_id'];
                let status = data['status'];
                let is_attempts_activated = data['is_attempts_activated'];
                let global_total_attempt_count = parseInt(data['global_total_attempt_count']);

                let attempt_counter;

                if(attempts)
                {
                    attempt_counter = parseInt(data['attempt_counter']);
                }

                if(has_valid_birthDate)
                {
                    $('.auth_bday').addClass('border-success');
                    $('.input_group_bdate').hide();
                    $('.modal_footer_div').html(modal_footer);
                    $('#input_students_id').val(students_id);
                    $('#email_div').html(email_input_html);

                    __notif_show(1, 'Success', 'Birthdate Match!');

                    $('.label_instructions').text('Please provide an ACTIVE EMAIL!')
                    currentStep++;
                    updateButtonHighlights();

                }else
                {
                    $('.auth_bday').addClass('border-danger');
                    __notif_show(-1, 'Warning', 'Birthdate not Match!');

                    $('.label_attempts').text(attempts);
                }

                console.log(attempt_counter);
                if(attempt_counter > 2)
                {
                    $('.b_date_alert_div').show();
                }

                if(is_attempts_activated)
                {
                    if(attempt_counter > global_total_attempt_count) {
                        $('.label_attempts').text(global_total_attempt_count);

                        __modal_hide('find_my_account_mdl');

                        Swal.fire({
                            icon: 'warning',
                            title: 'Ooops!',
                            text: 'You have reached the maximum attempts! Retry after 24 hours!',
                        }).then((result) => {
                            // Check if the user clicked the "OK" button
                            if (result.isConfirmed) {
                                // Reload the page
                                location.reload();
                            }
                        });
                    }
                }

            },
            complete: function () {




            }
        });


    });

}

function formatDate(date) {

    const month = pad(date.getMonth() + 1);
    const day = pad(date.getDate());
    const year = date.getFullYear();

    return year+'-'+month+'-'+day;
}

function pad(number) {

    return number < 10 ? '0' + number : number;
}

function sendEmailVerification(){

    $('body').on('click', '.btn_update_send_email', function(){

        let this_button = $(this);

        if($('#my_email').val() === null || $('#my_email').val() === '')
        {
            $('#my_email').addClass('border-danger');
            __notif_show(-1, 'Warning', 'Please provide your email!');

        }else
        {
            let url = '/send/email/verification';
            let data = {
                _token,
                email : $('#my_email').val(),
                students_id : $('#input_students_id').val(),
            };

            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': _token,
                },
                beforeSend: function () {

                    this_button.html('Sending <svg width="25" viewBox="-2 -2 42 42" xmlns="http://www.w3.org/2000/svg" stroke="white" class="w-4 h-4 ml-2"> <g fill="none" fill-rule="evenodd"> <g transform="translate(1 1)" stroke-width="4"> <circle stroke-opacity=".5" cx="18" cy="18" r="18"></circle><path d="M36 18c0-9.94-8.06-18-18-18"><animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="1s" repeatCount="indefinite"></animateTransform></path> </g></g> </svg>');
                    this_button.prop('disabled', true);

                },
                success: function (data) {

                    let message = data['message'];
                    let status = data['status'];
                    let title = data['title'];
                    let status_code = data['status_code'];


                    if(status_code == -1)
                    {
                        __notif_show(status_code, 'Warning', 'Email provided already exist!');
                        $('#my_email').addClass("border-danger")
                    }else
                    {
                        __modal_hide('find_my_account_mdl');
                        Swal.fire({
                            icon: status,
                            title: title,
                            text: message,
                        });
                    }

                },
                complete: function () {

                    this_button.html('Send');
                    this_button.prop('disabled', false);

                }
            });
        }

    });

}


function updateButtonHighlights() {

    $(".btn_selected_div").removeClass("btn-primary bg-slate-100 dark:bg-darkmode-400 dark:border-darkmode-400 text-slate-500");
    $(".btn_selected_div:nth-child(" + currentStep + ")").addClass("btn-primary");
}
