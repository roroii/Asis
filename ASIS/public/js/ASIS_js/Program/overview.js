var _token = $('meta[name="csrf-token"]').attr('content');
var filterDate;
var page_number;

$(document).ready(function () {

    let active_year = $('#filter-year').val();
    let active_sem = $('#filter-sem').val();

    const filters = {
        active_year: active_year,
        active_sem: active_sem,
    };

    fetchTransactionsData(1, filters); // Fetch and populate the curriculum data in the table using AJAX

    // programListtActions();

    // filterByDate();

    programListtActions();

});

// Function to fetch curriculum data from the server using AJAX
function fetchTransactionsData(page, filters) {

    const tableBody = $('#program-list-table tbody');

    tableBody.empty(); // Clear the table body first

    $.ajax({
        url: '/program/list-load?page=' + page,
        type: 'POST',
        data: filters,
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': _token,
        },
        beforeSend: function () {

            // showLoading();
            loadingSpinner(tableBody);
        },
        success: function (data) {


            /**  Update the table with the received data */

            let count = 0;

            let slots ='';


            if(data.search_query)
            {
                if(data.search_query == '')
                {
                    let message = 'No Data Available';
                    noResult(tableBody, message);
                }

                data.search_query.forEach(function (transaction) {

                    if(transaction.slots === 0)
                    {
                        slots = 'No Slot Available';
                    }else
                    {
                        slots = transaction.slots+'  Slot/s Available';
                    }
                    count++;
                    // Create the HTML structure for each curriculum row
                    const transactionList = `
                     <tr class="intro-x">

                        <td class="w-40 !py-4"> <a href="javascript:;" class="font-medium whitespace-nowrap">${ transaction.program_code }</a> </td>
                        <td class="w-40 !py-4"> <a href="javascript:;" class="font-medium whitespace-nowrap">${ transaction.program_desc }</a> </td>

                        <td class="w-40 !py-4 ">
                            <a href="javascript:;" class="font-medium whitespace-nowrap">${ transaction.program_department }</a>
                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">${ transaction.program_college }</div>
                        </td>
                        <td class="text-center">
                            <div class="flex justify-center items-center">
                                <a href="javascript:;" class="box flex items-center px-3 py-2 rounded-md bg-white/10 dark:bg-darkmode-700 font-medium">
                                    <div class="w-2 h-2 bg-${ transaction.class  } rounded-full mr-3"></div> <span class="text-${ transaction.class  }">${ slots }</span>
                                </a>
                            </div>
                        </td>

                        <td class="table-report__action">
                            <div class="flex justify-center items-center">
                                <a class="flex items-center text-primary whitespace-nowrap mr-5 btn_edit_program" href="javascript:;"
                                data-program-id="${ transaction.program_id  }"
                                data-program-code="${ transaction.program_code  }"
                                data-program-desc="${ transaction.program_desc  }"
                                data-program-dept="${ transaction.program_department  }"
                                data-program-college="${ transaction.program_college  }"
                                data-program-slots="${ transaction.slots  }"
                                >

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
                    let message = 'No Data Available';
                    noResult(tableBody, message);
                }

                data.transactions.forEach(function (transaction) {

                    if(transaction.slots === 0)
                    {
                        slots = 'No Slot Available';
                    }else
                    {
                        slots = transaction.slots+'  Slot/s Available';
                    }

                    count++;
                    // Create the HTML structure for each curriculum row
                    const transactionList = `
                     <tr class="intro-x">

                        <td class="w-40 !py-4"> <a href="javascript:;" class="font-medium whitespace-nowrap">${ transaction.program_code }</a> </td>
                        <td class="w-40 !py-4"> <a href="javascript:;" class="font-medium whitespace-nowrap">${ transaction.program_desc }</a> </td>

                        <td class="w-40 !py-4 ">
                            <a href="javascript:;" class="font-medium whitespace-nowrap">${ transaction.program_department }</a>
                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">${ transaction.program_college }</div>
                        </td>
                        <td class="text-center">
                            <div class="flex justify-center items-center">
                                <a href="javascript:;" class="box flex items-center px-3 py-2 rounded-md bg-white/10 dark:bg-darkmode-700 font-medium">
                                    <div class="w-2 h-2 bg-${ transaction.class  } rounded-full mr-3"></div> <span class="text-${ transaction.class  }">${ slots }</span>
                                </a>
                            </div>
                        </td>

                        <td class="table-report__action">
                            <div class="flex justify-center items-center">
                                <a class="flex items-center text-primary whitespace-nowrap mr-5 btn_edit_program" href="javascript:;"
                                data-program-id="${ transaction.program_id  }"
                                data-program-code="${ transaction.program_code  }"
                                data-program-desc="${ transaction.program_desc  }"
                                data-program-dept="${ transaction.program_department  }"
                                data-program-college="${ transaction.program_college  }"
                                data-program-slots="${ transaction.slots  }"
                                >

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

            // hideLoading();
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


// Event handler for "Items per YEAR" select box
$('#filter-year').on('change', function () {

    currentFilterYear = parseInt($(this).val());
    // console.log("", currentFilterSize);
    let sem = $('#filter-sem').val();

    const filters = {
        limitYear: currentFilterYear,
        sem: sem
    };

    fetchTransactionsData(1, filters); // Fetch the first page of data with the applied filters and updated size
});


// Event handler for "Items per SEM" select box
$('#filter-sem').on('change', function () {

    currentFilterSem = parseInt($(this).val());
    // console.log("", currentFilterSize);
    let active_year = $('#filter-year').val();

    const filters = {
        limitSem: currentFilterSem,
        year: active_year
    };

    fetchTransactionsData(1, filters); // Fetch the first page of data with the applied filters and updated size
});


function filterByDate(){

    let element_id = 'date_filter';

    let picker = new Litepicker({
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
    picker.on('selected', function (date) {

        // Access different parts of the selected date
        var selectedDay = date.getDate().toString().padStart(2, '0');
        var selectedMonth = date.getMonth() + 1; // Months are zero-based, so add 1
        var selectedYear = date.getFullYear();





        filterDate = selectedYear+'-'+selectedMonth+'-'+selectedDay;
        let page_number = $('#filter-size').val();

        const filters = {
            filterDate: filterDate,
            page_number: page_number
        };

        fetchTransactionsData(1, filters);
    });


    $('body').on('click', '.btn_clear_date_selection', function(){

        $('#date_filter').val(null);
        fetchTransactionsData();

    });
}



// Event handler for filter search input
let typingTimer;
const doneTypingInterval = 1000; // 1 second

$('#filter-search').on('keyup', function (event) {

    clearTimeout(typingTimer);
    const searchKeyword = $(this).val();
    if (event.keyCode === 13) {
        // If the Enter key is pressed, fetch immediately without delay
        fetchFilteredExamineesData(searchKeyword);
    } else {
        // Otherwise, set the timer to fetch after the doneTypingInterval
        typingTimer = setTimeout(function () {
            fetchFilteredExamineesData(searchKeyword);
        }, doneTypingInterval);
    }
});

// Function to fetch filtered student data from the server using AJAX
function fetchFilteredExamineesData(searchKeyword) {

    let page_number = $('#filter-size').val();

    const filters = {
        search: searchKeyword,
        filterDate: filterDate,
        page_number: page_number,
    };

    fetchTransactionsData(1, filters);
}


function updateStatus(){

    $('body').on('click', '.btn_status', function(){

        let exam_id = $(this).data('exam-id');
        let status_id = $(this).data('status-id');

        $('.exam_id').val(exam_id);
        __modal_toggle('examination_status_mdl');

        $('.select2_exam_status').val(status_id).trigger('change');

    });

    /** UPDATE EXAMINATION  STATUS  */
    $('body').on('click', '.btn_update_exam_status', function(){

        let form_data = {
            _token,
            exam_id : $('.exam_id').val(),
            status_code : $('.select2_exam_status').val(),
        }

        page_number = $('#filter-size').val();

        $.ajax({
            url: bpath + 'exam/update/status',
            type: "POST",
            data: form_data,
            beforeSend: function () {

                showLoading();
                __modal_hide('examination_status_mdl');

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

                    const filters = {
                        filterDate: filterDate,
                        page_number: page_number
                    };

                    fetchTransactionsData(1, filters);

                }
            },
            complete: function () {

                hideLoading();
            }
        });

    });

}


function noResult(tableBody, message){

    const transactionList = `
                     <tr class="intro-x">
                        <td colspan="6" class="w-full text-center">

                            <div style="visibility: hidden" class="text-slate-500 text-xs whitespace-nowrap mt-0.5">No Data</div>
                            <a href="javascript:;" class=" text-slate-500 text-xs whitespace-nowrap">${  message }</a>
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


function programListtActions(){

    $('body').on('click', '.btn_edit_program', function(){

        let program_id = $(this).data('program-id');
        let program_code = $(this).data('program-code');
        let program_desc = $(this).data('program-desc');
        let program_dept = $(this).data('program-dept');
        let program_college = $(this).data('program-college');
        let program_slots = $(this).data('program-slots');


        $('.program_id').val(program_id);
        $('.program_code').val(program_code);
        $('.program_desc').val(program_desc);
        $('.program_dept').val(program_dept);
        $('.program_college').val(program_college);
        $('.program_slots').val(program_slots);

        __modal_toggle('program_details_mdl');


        $('.program_slots').on('input', function() {

            var inputValue = $(this).val();

            // Remove leading zeros
            inputValue = inputValue.replace(/^0+/, '');

            // Check if the input is a positive number
            if (isNaN(inputValue) || inputValue < 1) {
                inputValue = 1;
            }

            // Update the input value
            $(this).val(inputValue);
        });


    });


    $('body').on('click', '.btn_update_program_slots', function(){

        let this_button = $(this);
        let form_data = {
            _token,
            program_id : $('.program_id').val(),
            program_slots : $('.program_slots').val(),

        }

        page_number = $('#filter-size').val();

        $.ajax({
            url: bpath + 'program/update/program/slots',
            type: "POST",
            data: form_data,
            beforeSend: function () {

                this_button.html('Saving <svg width="25" viewBox="-2 -2 42 42" xmlns="http://www.w3.org/2000/svg" stroke="white" class="w-4 h-4 ml-2"> <g fill="none" fill-rule="evenodd"> <g transform="translate(1 1)" stroke-width="4"> <circle stroke-opacity=".5" cx="18" cy="18" r="18"></circle><path d="M36 18c0-9.94-8.06-18-18-18"><animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="1s" repeatCount="indefinite"></animateTransform></path> </g></g> </svg>');
                this_button.prop('disabled', true);
            },
            success: function (response) {
                if(response)
                {
                    let data = JSON.parse(response);
                    let title = data['title'];
                    let status = data['status'];
                    let status_code = data['status_code'];
                    let message = data['message'];

                    Swal.fire({
                        icon: status,
                        title: title,
                        text: message,
                    });

                    fetchTransactionsData();

                }
            },
            complete: function(){

                this_button.html('Save');
                this_button.prop('disabled', false);

                __modal_hide('program_details_mdl');

            },
        });

    });

}
