var _token = $('meta[name="csrf-token"]').attr('content');
var checkedValues = [];
$(document).ready(function () {

    $('#approve_appointment_div').hide();

    fetchTransactionsData(); // Fetch and populate the curriculum data in the table using AJAX

    updateStatus();


});

// Function to fetch curriculum data from the server using AJAX
function fetchTransactionsData(page, filters) {

    const tableBody = $('#transaction-list-table tbody');
    tableBody.empty(); // Clear the table body first
    let count = 1;

    $.ajax({
        url: '/transaction/list-load?page=' + page,
        type: 'POST',
        data: filters,
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': _token,
        },
        beforeSend: function () {

            loadingSpinner(tableBody);
        },
        success: function (data) {

            // Update the table with the received data

            if(data.search_query)
            {
                if(data.search_query == '')
                {
                    noResult(tableBody);
                }
                data.search_query.forEach(function (transaction) {

                    // Create the HTML structure for each curriculum row
                    const transactionList = `
                     <tr class="intro-x">

                        <td class="w-40 !py-4"> <a href="javascript:;" class="underline decoration-dotted whitespace-nowrap">${ transaction.transaction_id }</a> </td>
                        <td class="w-40 !py-4"> <a href="javascript:;" class="underline decoration-dotted whitespace-nowrap">${ transaction.enrollees_id }</a> </td>
                        <td class="w-40">
                            <a href="" class="font-medium whitespace-nowrap">${ transaction.fullName }</a>
                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">${ transaction.province }, ${ transaction.city_mun }, ${ transaction.barangay }</div>
                        </td>
                        <td class="text-center">
                            <div class="flex justify-center items-center">
                                <a href="javascript:;" data-appointment-id="${ transaction.appointment_id }" data-schedule-id="${ transaction.schedule_id }" class="box flex items-center px-3 py-2 rounded-md bg-white/10 dark:bg-darkmode-700 font-medium btn_status">
                                    <div class="w-2 h-2 bg-${ transaction.status_class } rounded-full mr-3"></div> <span class="text-${ transaction.status_class }">${ transaction.status }</span>
                                </a>
                            </div>

                        </td>
                        <td>
                            <div class="whitespace-nowrap">${ transaction.school }</div>
                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">${ transaction.date } - ${ transaction.date_desc }</div>
                        </td>
                        <td class="table-report__action">
                            <div class="flex justify-center items-center">
                                <a class="flex items-center text-primary whitespace-nowrap mr-5" href="/transaction/list/details/${ transaction.encrypted_appointment_id }">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="check-square" data-lucide="check-square" class="lucide lucide-check-square w-4 h-4 mr-1"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"></path></svg> View Details </a>
                            </div>
                        </td>
                     </tr>`;
                    tableBody.append(transactionList); // Append curriculum row to the table
                });
            }else
            {
                if(data.transactions == '')
                {
                    noResult(tableBody);
                }

                // <td className="w-10">
                //     <input
                //         data-enrolees-id="${ transaction.enrollees_id }"
                //         data-appointment-id="${ transaction.appointment_id }"
                //         data-schedule-id="${ transaction.schedule_id }"
                //         className="form-check-input checkbox_transaction" type="checkbox">
                // </td>

                data.transactions.forEach(function (transaction) {

                    // Create the HTML structure for each curriculum row
                    const transactionList = `
                     <tr class="intro-x">

                        <td class="w-40 !py-4"> <a href="javascript:;" class="underline decoration-dotted whitespace-nowrap">${ transaction.transaction_id }</a> </td>
                        <td class="w-40 !py-4"> <a href="javascript:;" class="underline decoration-dotted whitespace-nowrap">${ transaction.enrollees_id }</a> </td>
                        <td class="w-40">
                            <a href="" class="font-medium whitespace-nowrap">${ transaction.fullName }</a>
                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">${ transaction.province }, ${ transaction.city_mun }, ${ transaction.barangay }</div>
                        </td>
                        <td class="text-center">
                            <div class="flex justify-center items-center">
                                <a href="javascript:;" data-appointment-id="${ transaction.appointment_id }" data-schedule-id="${ transaction.schedule_id }" data-status="${ transaction.status }" class="box flex items-center px-3 py-2 rounded-md bg-white/10 dark:bg-darkmode-700 font-medium btn_status">
                                    <div class="w-2 h-2 bg-${ transaction.status_class } rounded-full mr-3"></div> <span class="text-${ transaction.status_class }">${ transaction.status }</span>
                                </a>
                            </div>

                        </td>
                        <td>
                            <div class="whitespace-nowrap">${ transaction.school }</div>
                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">${ transaction.date } - ${ transaction.date_desc }</div>
                        </td>
                        <td class="table-report__action">
                            <div class="flex justify-center items-center">
                                <a class="flex items-center text-primary whitespace-nowrap mr-5" href="/transaction/list/details/${ transaction.encrypted_appointment_id }">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="check-square" data-lucide="check-square" class="lucide lucide-check-square w-4 h-4 mr-1"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"></path></svg> View Details </a>
                            </div>
                        </td>
                     </tr>`;
                    tableBody.append(transactionList); // Append curriculum row to the table
                });
            }


            // Update the pagination links
            updatePaginationLinks(data);

            // Show the summary message
            const paginationSummary = $('#pagination-summary');
            paginationSummary.text(data.summary);


        },
        complete: function () {

            $('#loading-row').remove();

        }
    });
}

// Function to update the pagination links and summary message
function updatePaginationLinks(data) {
    const paginationLinks = $('.pagination');
    paginationLinks.empty(); // Clear the pagination links container

    const currentPage = data.current_page;
    const lastPage = data.last_page;
    const perPage = data.per_page;
    const totalEntries = data.total;
    const startEntry = (currentPage - 1) * perPage + 1;
    const endEntry = Math.min(currentPage * perPage, totalEntries);
    const summaryMessage = `Showing ${startEntry} to ${endEntry} of ${totalEntries} entries`;

    // Add "Chevrons Left" link
    if (currentPage > 1) {
        paginationLinks.append('<li class="page-item"><a class="page-link" href="#" data-page="1"><i class="fa fa-angle-double-left w-4 h-4"></i></a></li>');
    }

    // Add "Chevron Left" link
    if (currentPage > 1) {
        paginationLinks.append(`<li class="page-item"><a class="page-link" href="#" data-page="${currentPage - 1}"><i class="fa fa-angle-left w-4 h-4"></i></a></li>`);
    }

    // Add ellipsis link for skipped pages
    if (currentPage > 3) {
        paginationLinks.append('<li class="page-item"><a class="page-link" href="#">...</a></li>');
    }

    // Add page links
    for (let i = Math.max(1, currentPage - 2); i <= Math.min(currentPage + 2, lastPage); i++) {
        const activeClass = i === currentPage ? 'active' : '';
        paginationLinks.append(`<li class="page-item ${activeClass}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`);
    }

    // Add ellipsis link for skipped pages
    if (currentPage < lastPage - 2) {
        paginationLinks.append('<li class="page-item"><a class="page-link" href="#">...</a></li>');
    }

    // Add "Chevron Right" link
    if (currentPage < lastPage) {
        paginationLinks.append(`<li class="page-item"><a class="page-link" href="#" data-page="${currentPage + 1}"><i class="fa fa-angle-right w-4 h-4"></i></a></li>`);
    }

    // Add "Chevrons Right" link
    if (currentPage < lastPage) {
        paginationLinks.append(`<li class="page-item"><a class="page-link" href="#" data-page="${lastPage}"><i class="fa fa-angle-double-right w-4 h-4" ></i></a></li>`);
    }

    // Add the summary message
    const summaryContainer = $('.summary');
    summaryContainer.text(summaryMessage);
}


// Event handler for pagination links
$(document).on('click', '.pagination a', function (event) {
    event.preventDefault();
    const page = $(this).data('page');
    fetchTransactionsData(page);
});

// Event handler for "Items per page" select box
$('#filter-size').on('change', function () {
    currentFilterSize = parseInt($(this).val());
    // console.log("", currentFilterSize);
    const filters = {
        limit: currentFilterSize
    };
    fetchTransactionsData(1, filters); // Fetch the first page of data with the applied filters and updated size
});


// Event handler for "Items per status" select box
$('#filter-status').on('change', function () {
    currentFilterStatus = parseInt($(this).val());
    // console.log("", currentFilterSize);
    const filters = {
        limitStatus: currentFilterStatus
    };
    fetchTransactionsData(1, filters); // Fetch the first page of data with the applied filters and updated size
});


// Event handler for filter search input
let typingTimer;
const doneTypingInterval = 1000; // 1 second

$('#filter-search').on('keyup', function (event) {
    clearTimeout(typingTimer);
    const searchKeyword = $(this).val();
    if (event.keyCode === 13) {
        // If the Enter key is pressed, fetch immediately without delay
        fetchFilteredEnrollmentData(searchKeyword);
    } else {
        // Otherwise, set the timer to fetch after the doneTypingInterval
        typingTimer = setTimeout(function () {
            fetchFilteredEnrollmentData(searchKeyword);
        }, doneTypingInterval);
    }
});

// Function to fetch filtered student data from the server using AJAX
function fetchFilteredEnrollmentData(searchKeyword) {
    const filters = {
        search: searchKeyword
    };

    fetchTransactionsData(1, filters);
}


function updateStatus(){

    $('body').on('click', '.btn_status', function(){

        let status = $(this).data('status');

        if(status == 'Completed')
        {
            Swal.fire({
                icon: 'info',
                title: 'Information',
                text: 'Appointment completed!',
            });
        }else
        {
            let appointment_id = $(this).data('appointment-id');
            let schedule_id = $(this).data('schedule-id');
            let enrollees_id = $(this).data('enrollees-id');

            $('.appointment_schedule_id').val(appointment_id);
            $('.schedule_id').val(schedule_id);
            __modal_toggle('appointment_approve_mdl');
        }

    });

    /** APPROVE APPOINTMENT  */
    $('body').on('click', '#btn_approve_appointment', function(){

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

                    fetchTransactionsData();

                }
            },
            complete: function () {

                hideLoading();
            }
        });

    });


    /** DISAPPROVE APPOINTMENT  */
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

                    fetchTransactionsData();
                    __modal_hide('appointment_approve_mdl');

                }
            },
            complete: function () {

                hideLoading();
            }
        });

    });
}


function noResult(tableBody){

    const transactionList = `
                     <tr class="intro-x">
                        <td colspan="6" class="w-full text-center">

                            <div style="visibility: hidden" class="text-slate-500 text-xs whitespace-nowrap mt-0.5">No Data</div>
                            <a href="javascript:;" class=" text-slate-500 text-xs whitespace-nowrap">There is no data available.</a>
                            <div style="visibility: hidden" class="text-slate-500 text-xs whitespace-nowrap mt-0.5">No Data</div>
                        </td>
                     </tr>`;

    return tableBody.append(transactionList); // Append curriculum row to the table

}

function loadingSpinner(tableBody){

    let loadingRow = `
                     <tr id="loading-row" class="intro-x">
                        <td colspan="6" class="w-full text-center">
                            <div class="col-span-6 sm:col-span-3 xl:col-span-2 flex flex-col justify-end items-center py-1">
                                <svg width="25" viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg" stroke="rgb(30, 41, 59)" class="w-8 h-8">
                                    <g fill="none" fill-rule="evenodd" stroke-width="4">
                                        <circle cx="22" cy="22" r="1">
                                            <animate attributeName="r" begin="0s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"></animate>
                                            <animate attributeName="stroke-opacity" begin="0s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"></animate>
                                        </circle>
                                        <circle cx="22" cy="22" r="1">
                                            <animate attributeName="r" begin="-0.9s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"></animate>
                                            <animate attributeName="stroke-opacity" begin="-0.9s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"></animate>
                                        </circle>
                                    </g>
                                </svg>
                            </div>
                        </td>
                     </tr>`;
    tableBody.append(loadingRow);

}


function checkAllRows() {


    var enrollees_id_array = [];
    var appointment_id_array = [];



    $("#checkAll_transactions").on("change", function() {


        let enrollees_id = $(".checkbox_transaction").data('enrolees-id');

        if ($(this).prop("checked")) {

            // Checkbox is checked
            $(".checkbox_transaction").prop("checked", true);
            $('#approve_appointment_div').show();

            var checkboxTransaction = $(".checkbox_transaction");

            for(var i = 0; i<checkboxTransaction.length; i++){

                if($(".checkbox_transaction")[i].checked === true){

                   let enrollees_id = $(".checkbox_transaction").eq(i).data('enrolees-id');
                   let appointment_id = $(".checkbox_transaction").eq(i).data('appointment-id');
                   let schedule_id = $(".checkbox_transaction").eq(i).data('schedule-id');

                    enrollees_id_array.push(enrollees_id);
                    appointment_id_array.push(appointment_id);
                }
            }

        }
        else {

            // Checkbox is unchecked
            $(".checkbox_transaction").prop("checked", false);
            $('#approve_appointment_div').hide();
            enrollees_id_array = [];
            appointment_id_array = [];
        }

    });

    $(".checkbox_transaction").on("change", function() {


        let selected_enrollees_id = $(this).data('enrolees-id');
        let appointment_id = $(this).data('appointment-id');

        if ($(this).prop("checked")) {

            // Checkbox is checked
            $('#approve_appointment_div').show();
            enrollees_id_array.push(selected_enrollees_id);
            appointment_id_array.push(appointment_id);

        }else
        {
            // $('#approve_appointment_div').hide();


            // Find the index of the value
            let indexToRemove = enrollees_id_array.indexOf(selected_enrollees_id);
            let indexToRemove_1 = appointment_id_array.indexOf(appointment_id);


            // Check if the value is in the array before attempting to remove it
            if (indexToRemove !== -1) {
                // Use splice to remove the element at the specified index
                enrollees_id_array.splice(indexToRemove, 1);
            }

            if (indexToRemove_1 !== -1) {
                // Use splice to remove the element at the specified index
                appointment_id_array.splice(indexToRemove_1, 1);
            }

            if (areCheckboxesChecked() === false) {

                $('#approve_appointment_div').hide();
                $("#checkAll_transactions").prop("checked", false);

            }

        }

    });



    $('body').on('click', '#btn_approved_appointments', function(){

        let form_data = {

            _token,
            enrollees_id :  enrollees_id_array,
            appointment_id  :   appointment_id_array,
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

                    fetchTransactionsData();

                }
            },
            complete: function () {

                hideLoading();
            }
        });

    });

    $('body').on('click', '#btn_disapproved_appointments', function(){


        console.log(enrollees_id_array);

    });

}

function areCheckboxesChecked() {
    var isChecked = false;

    // Iterate through checkboxes with class "checkbox_transaction"
    $('#transaction-list-table .checkbox_transaction').each(function () {
        if ($(this).prop('checked')) {
            isChecked = true;
            // Exit the loop if at least one checkbox is checked
            return false;
        }
    });

    return isChecked;
}
