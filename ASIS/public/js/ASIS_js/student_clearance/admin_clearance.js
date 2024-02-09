var _token = $('meta[name="csrf-token"]').attr('content');
var filterDate;
var page_number;


$(document).ready(function () {

    page_number = $('#filter-size').val();

    fetchStudentsData();        // Fetch and populate the STUDENTS data in the table using AJAX
    //fetchSignatoriesData();     // Fetch and populate the SIGNATORIES data in the table using AJAX
    fetchEmployeeData();        // Fetch and populate the EMPLOYEES data in the table using AJAX

    addSignatoriesFromTemplate();
    useTemplate();
    addSignatories();
    addDesignation();
    removeSignatory();

    paginationEventHandler();


});

// Function to fetch SIGNATORIES data from the server using AJAX
function fetchSignatoriesData(page, filters) {

    const signatorytableBody = $('#signatories_list_tbl tbody');

    signatorytableBody.empty(); // Clear the table body first

    $.ajax({
        url: '/student/clearance/signatory/list-load?page=' + page,
        type: 'POST',
        data: filters,
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': _token,
        },
        beforeSend: function () {

            // showLoading();
            loadingSpinner(signatorytableBody);
        },
        success: function (data) {


            /**  Update the table with the received data */

            let count = 0;

            let action_button ='';


            if(data.search_query)
            {
                if(data.search_query == '')
                {
                    let message = 'No Signatories yet!';
                    noResult(signatorytableBody, message);
                }

                data.search_query.forEach(function (transaction) {

                    // Create the HTML structure for each curriculum row
                    const transactionList = `
                     <tr class="intro-x">

                        <td class="w-40">
                            <a href="javascript:;" class="font-medium whitespace-nowrap">${ count }</a>
                        </td>
                        <td class="w-40">
                            <a href="javascript:;" class="font-medium whitespace-nowrap">${ transaction.fullName }</a>
                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">${ transaction.designation }</div>
                        </td>
                         <td class="w-40">
                            <a href="javascript:;" class="font-medium whitespace-nowrap">${ transaction.type }</a>
                        </td>
                         <td class="text-center w-40">
                            <input data-signatory-id="${ transaction.signatory_id }" type="text" class="form-control input_signatory_desig" placeholder="Designation...." value="${ transaction.designation }">
                        </td>
                        <td class="text-center">
                            <div class="flex justify-center items-center">
                                <a href="javascript:;" class="box flex items-center px-3 py-2 rounded-md bg-white/10 dark:bg-darkmode-700 font-medium btn_status">
                                    <div class="w-2 h-2 bg-${ transaction.active_class } rounded-full mr-3"></div> <span class="text-${ transaction.active_class }">${ transaction.active_status }</span>
                                </a>
                            </div>
                        </td>
                        <td class="table-report__action">
                            <div class="flex justify-center items-center">
                                <a class="flex items-center text-danger whitespace-nowrap mr-5 btn_remove_signatory" href="javascript:;"
                                data-signatory-id="${ transaction.signatory_id }"
                                >
                                <i class="fa-solid fa-user-minus mr-3"></i>Remove</a>

                            </div>
                        </td>
                     </tr>`;
                    signatorytableBody.append(transactionList); // Append curriculum row to the table

                });
            }else
            {
                if(data.transactions == '')
                {
                    let message = 'No Signatories yet!';
                    noResult(signatorytableBody, message);
                }

                data.transactions.forEach(function (transaction) {

                    count++;
                    // Create the HTML structure for each curriculum row
                    const transactionList = `
                     <tr class="intro-x">

                        <td class="w-40">
                            <a href="javascript:;" class="font-medium whitespace-nowrap">${ count }</a>
                        </td>
                        <td class="w-40">
                            <a href="javascript:;" class="font-medium whitespace-nowrap">${ transaction.fullName }</a>
                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">${ transaction.designation }</div>
                        </td>
                         <td class="w-40">
                            <a href="javascript:;" class="font-medium whitespace-nowrap">${ transaction.type }</a>
                        </td>
                         <td class="text-center w-40">
                            <input data-signatory-id="${ transaction.signatory_id }" type="text" class="form-control input_signatory_desig" placeholder="Designation...." value="${ transaction.designation }">
                        </td>
                        <td class="text-center">
                            <div class="flex justify-center items-center">
                                <a href="javascript:;" class="box flex items-center px-3 py-2 rounded-md bg-white/10 dark:bg-darkmode-700 font-medium btn_status">
                                    <div class="w-2 h-2 bg-${ transaction.active_class } rounded-full mr-3"></div> <span class="text-${ transaction.active_class }">${ transaction.active_status }</span>
                                </a>
                            </div>
                        </td>
                        <td class="table-report__action">
                            <div class="flex justify-center items-center">
                                <a class="flex items-center text-danger whitespace-nowrap mr-5 btn_remove_signatory" href="javascript:;"
                                data-signatory-id="${ transaction.signatory_id }"
                                >
                                <i class="fa-solid fa-user-minus mr-3"></i>Remove</a>

                            </div>
                        </td>
                     </tr>`;
                    signatorytableBody.append(transactionList); // Append curriculum row to the table

                });
            }

            // Update the pagination links
            updateSignatoriesPaginationLinks(data);

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


// Function to fetch STUDENTS DATA from the server using AJAX
function fetchStudentsData(page, filters) {

    const tableBody = $('#student_list_tbl tbody');

    tableBody.empty(); // Clear the table body first

    $.ajax({
        url: '/student/clearance/student/list-load?page=' + page,
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

            let action_button ='';


            if(data.search_query)
            {
                if(data.search_query == '')
                {
                    let message = 'No Data Available';
                    noResult(tableBody, message);
                }

                data.search_query.forEach(function (transaction) {

                    // Create the HTML structure for each curriculum row
                    const transactionList = `
                     <tr class="intro-x">
                        <td class="w-40 !py-4"> <a href="javascript:;" class="underline decoration-dotted whitespace-nowrap">${ transaction.student_id }</a> </td>
                        <td class="w-40">
                            <a href="javascript:;" class="font-medium whitespace-nowrap">${ transaction.fullName }</a>
                            <div class="${ transaction.class }">${ transaction.email }</div>
                        </td>
                        <td class="w-40">
                            <a href="javascript:;" class="text-slate-500 whitespace-nowrap">${ transaction.course }</a>
                        </td>
                        <td class="text-center">
                            <div class="flex justify-center items-center">
                                <a href="javascript:;" class="box flex items-center px-3 py-2 rounded-md bg-white/10 dark:bg-darkmode-700 font-medium btn_status">
                                    <div class="w-2 h-2 bg-${ transaction.active_class } rounded-full mr-3"></div> <span class="text-${ transaction.active_class }">${ transaction.active_status }</span>
                                </a>
                            </div>
                        </td>
                        <td class="table-report__action">
                            <div class="flex justify-center items-center">
                                <a class="flex items-center text-primary whitespace-nowrap mr-5 btn_add_signatory" href="javascript:;"
                                data-student-id="${ transaction.student_id }"
                                >
                                <i class="fa-solid fa-user-plus mr-3"></i> Add to signatories</a>

                            </div>
                        </td>
                     </tr>`;
                    tableBody.append(transactionList); // Append curriculum row to the table

                });
            }else
            {
                if(data.transactions == '')
                {
                    let message = 'There is no data available on this date.';
                    noResult(tableBody, message);
                }

                data.transactions.forEach(function (transaction) {

                    // Create the HTML structure for each curriculum row
                    const transactionList = `
                     <tr class="intro-x">
                        <td class="w-40 !py-4"> <a href="javascript:;" class="underline decoration-dotted whitespace-nowrap">${ transaction.student_id }</a> </td>
                        <td class="w-40">
                            <a href="javascript:;" class="font-medium whitespace-nowrap">${ transaction.fullName }</a>
                            <div class="${ transaction.class }">${ transaction.email }</div>
                        </td>
                        <td class="w-40">
                            <a href="javascript:;" class="text-slate-500 whitespace-nowrap">${ transaction.course }</a>
                        </td>
                        <td class="text-center">
                            <div class="flex justify-center items-center">
                                <a href="javascript:;" class="box flex items-center px-3 py-2 rounded-md bg-white/10 dark:bg-darkmode-700 font-medium btn_status">
                                    <div class="w-2 h-2 bg-${ transaction.active_class } rounded-full mr-3"></div> <span class="text-${ transaction.active_class }">${ transaction.active_status }</span>
                                </a>
                            </div>
                        </td>
                        <td class="table-report__action">
                            <div class="flex justify-center items-center">
                                <a class="flex items-center text-primary whitespace-nowrap mr-5 btn_add_signatory" href="javascript:;"
                                data-student-id="${ transaction.student_id }"
                                >
                                <i class="fa-solid fa-user-plus mr-3"></i> Add to signatories</a>

                            </div>
                        </td>
                     </tr>`;
                    tableBody.append(transactionList); // Append curriculum row to the table

                });
            }


            // Update the pagination links
            updateStudentListPaginationLinks(data);

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


// Function to fetch EMPLOYEE DATA from the server using AJAX
function fetchEmployeeData(page, filters) {

    const employeetableBody = $('#faculty_list_tbl tbody');

    employeetableBody.empty(); // Clear the table body first

    $.ajax({
        url: '/student/clearance/employee/list-load?page=' + page,
        type: 'POST',
        data: filters,
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': _token,
        },
        beforeSend: function () {

            // showLoading();
            loadingSpinner(employeetableBody);
        },
        success: function (data) {


            /**  Update the table with the received data */

            let count = 0;

            let action_button ='';


            if(data.search_query)
            {
                if(data.search_query == '')
                {
                    let message = 'No Data Available';
                    noResult(employeetableBody, message);
                }

                data.search_query.forEach(function (transaction) {

                    // Create the HTML structure for each curriculum row
                    const transactionList = `
                     <tr class="intro-x">
                        <td class="w-40 !py-4"> <a href="javascript:;" class="underline decoration-dotted whitespace-nowrap">${ transaction.employee_id }</a> </td>
                        <td class="w-40">
                            <a href="javascript:;" class="font-medium whitespace-nowrap">${ transaction.fullName }</a>
                            <div class="${ transaction.class }">${ transaction.email }</div>
                        </td>
                        <td class="text-center">
                            <div class="flex justify-center items-center">
                                <a href="javascript:;" class="box flex items-center px-3 py-2 rounded-md bg-white/10 dark:bg-darkmode-700 font-medium btn_status">
                                    <div class="w-2 h-2 bg-${ transaction.active_class } rounded-full mr-3"></div> <span class="text-${ transaction.active_class }">${ transaction.active_status }</span>
                                </a>
                            </div>
                        </td>
                        <td class="table-report__action">
                            <div class="flex justify-center items-center">
                                <a class="flex items-center text-primary whitespace-nowrap mr-5 btn_add_employee_signatory" href="javascript:;"
                                data-employee-id="${ transaction.employee_id }"
                                >
                                <i class="fa-solid fa-user-plus mr-3"></i> Add to signatories</a>

                            </div>
                        </td>
                     </tr>`;
                    employeetableBody.append(transactionList); // Append curriculum row to the table

                });
            }else
            {
                if(data.transactions == '')
                {
                    let message = 'There is no data available on this date.';
                    noResult(employeetableBody, message);
                }

                data.transactions.forEach(function (transaction) {

                    // Create the HTML structure for each curriculum row
                    const transactionList = `
                     <tr class="intro-x">
                        <td class="w-40 !py-4"> <a href="javascript:;" class="underline decoration-dotted whitespace-nowrap">${ transaction.employee_id }</a> </td>
                        <td class="w-40">
                            <a href="javascript:;" class="font-medium whitespace-nowrap">${ transaction.fullName }</a>
                            <div class="${ transaction.class }">${ transaction.email }</div>
                        </td>
                        <td class="text-center">
                            <div class="flex justify-center items-center">
                                <a href="javascript:;" class="box flex items-center px-3 py-2 rounded-md bg-white/10 dark:bg-darkmode-700 font-medium btn_status">
                                    <div class="w-2 h-2 bg-${ transaction.active_class } rounded-full mr-3"></div> <span class="text-${ transaction.active_class }">${ transaction.active_status }</span>
                                </a>
                            </div>
                        </td>
                        <td class="table-report__action">
                            <div class="flex justify-center items-center">
                                <a class="flex items-center text-primary whitespace-nowrap mr-5 btn_add_employee_signatory" href="javascript:;"
                                data-employee-id="${ transaction.employee_id }"
                                >
                                <i class="fa-solid fa-user-plus mr-3"></i> Add to signatories</a>

                            </div>
                        </td>
                     </tr>`;
                    employeetableBody.append(transactionList); // Append curriculum row to the table

                });
            }

            // Update the pagination links
            updateEmployeeListPaginationLinks(data);

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



// Function to fetch SIGNATORIES FROM TEMPLATE data from the server using AJAX
function fetchTemplateSignatorytableBody(page, filters) {

    const templateSignatorytableBody = $('#template_list_tbl tbody');

    templateSignatorytableBody.empty(); // Clear the table body first

    $.ajax({
        url: '/student/clearance/load/created/clearance?page=' + page,
        type: 'POST',
        data: filters,
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': _token,
        },
        beforeSend: function () {


        },
        success: function (data) {


            /**  Update the table with the received data */

            let count = 0;

            let action_button ='';


            if(data.search_query)
            {
                if(data.search_query == '')
                {
                    let message = 'There is no data available.';
                    noResult(templateSignatorytableBody, message);
                }

                data.search_query.forEach(function (transaction) {

                    // Create the HTML structure for each curriculum row
                    const transactionList = `
                     <tr class="intro-x">

                        <td class="w-40">
                            <a href="javascript:;" class="font-medium whitespace-nowrap">${ transaction.clearance_name }</a>
                        </td>
                         <td class="w-40">
                            <a href="javascript:;" class="text-slate-500 font-medium whitespace-nowrap">${ transaction.clearance_type }</a>
                        </td>
                        <td>
                            <a href="javascript:;" class="text-slate-500 font-medium whitespace-nowrap">School Year: <span class="font-medium whitespace-nowrap">${ transaction.year }</span></a>
                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">Semester: ${ transaction.sem }</div>
                        </td>
                         <td class="text-center">
                            <div data-clearance-id="${ transaction.clearance_id }" class="flex justify-center items-center fa-beat bnt_clearance_signatories">
                                <a href="javascript:;" data-clearance-id="${ transaction.clearance_id }" class="box flex items-center px-3 py-2 rounded-md bg-white/10 dark:bg-darkmode-700 font-medium">
                                    <i class="fa-solid fa-users w-4 h-4 mr-1"></i>
                                    <span class="text-${ transaction.counter_class }">${ transaction.counted_signatories }</span>
                                </a>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="flex justify-center items-center">
                                <a href="javascript:;" class="box flex items-center px-3 py-2 rounded-md bg-white/10 dark:bg-darkmode-700 font-medium">
                                    <div class="w-2 h-2 bg-${ transaction.status_class } rounded-full mr-3"></div> <span class="text-${ transaction.status_class }">${ transaction.status }</span>
                                </a>
                            </div>
                        </td>
                        <td class="table-report__action">
                            <div class="flex justify-center items-center">

                                <a href="/student/clearance/print/clearance/${ transaction.clearance_id }" target="_blank" class="flex items-center text-primary whitespace-nowrap mr-5"
                                    data-clearance-id="${ transaction.clearance_id }"
                                >
                                <i class="fa-solid fa-print mr-2"></i></i>Print</a>


                                <a class="flex items-center text-danger whitespace-nowrap mr-5 btn_remove_clearance" href="javascript:;"
                                data-clearance-id="${ transaction.clearance_id }"
                                >
                                <i class="fa-solid fa-delete-left mr-2"></i>Remove</a>

                            </div>
                        </td>
                     </tr>`;
                    templateSignatorytableBody.append(transactionList); // Append curriculum row to the table

                });
            }else
            {
                if(data.transactions == '')
                {
                    let message = 'No Clearance Available.';
                    noResult(templateSignatorytableBody, message);
                }

                let checkbox_ = '';

                data.transactions.forEach(function (transaction) {

                    if(transaction.status == 'Open')
                    {
                        checkbox_ = `<input data-clearance-id="${ transaction.clearance_id }" class="form-check-input clearance_status" type="checkbox" checked>`;

                    }else
                    {
                        checkbox_ = `<input data-clearance-id="${ transaction.clearance_id }" class="form-check-input clearance_status" type="checkbox">`;
                    }

                    // Create the HTML structure for each curriculum row
                    const transactionList = `
                     <tr class="intro-x">

                        <td class="w-40">
                            <a href="javascript:;" class="font-medium whitespace-nowrap text-toldok3 tooltip" title="${ transaction.clearance_name }">${ transaction.clearance_name }</a>
                        </td>
                        <td class="w-40">
                            <a href="javascript:;" class="text-slate-500 font-medium whitespace-nowrap">${ transaction.clearance_type }</a>
                        </td>
                        <td class="w-40">
                            <a href="javascript:;" class="text-slate-500 font-medium whitespace-nowrap">${ transaction.course }</a>
                        </td>
                        <td class="table-report__action">
                            <div class="flex justify-center items-center">

                                <a class="flex items-center text-primary whitespace-nowrap mr-5 btn_use_template" href="javascript:;"
                                data-clearance-id="${ transaction.clearance_id }"
                                >
                                <i class="fa-solid fa-plus mr-2"></i>Use</a>

                            </div>
                        </td>
                     </tr>`;
                    templateSignatorytableBody.append(transactionList); // Append curriculum row to the table

                });
            }

            // Update the pagination links
            updatePaginationLinks(data);

        },
        complete: function () {


        }
    });
}


function addSignatoriesFromTemplate(){

    $('body').on('click', '.mdl_btn_from_template', function(){

        let clearance_id = $('.mdl_input_clearance_id').val();

        $('.template_mdl_clearance_id').val(clearance_id);

        const filters = {

            request_from_template: true,

        };

        fetchTemplateSignatorytableBody(1, filters);

    });

}

function useTemplate(){

    $('body').on('click', '.btn_use_template', function(){

        let this_button = $(this);

       let created_clearance_template_id = $(this).data('clearance-id');
       let to_update_clearance_id =  $('.template_mdl_clearance_id').val();

        $.ajax({
            url: '/student/clearance/use/template',
            type: 'POST',
            data: { created_clearance_template_id, to_update_clearance_id},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': _token,
            },
            beforeSend: function () {

                this_button.prop('disabled', true);

            },
            success: function (data) {

                __notif_show(1, 'Success', data['message']);
                const filters = {

                    clearanceId: to_update_clearance_id,

                };
                fetchSignatoriesData(1, filters);
            },

            complete: function () {

                this_button.prop('disabled', false);
                // __modal_hide('template_list_mdl');
            }
        });

    });

}






























// Event handler for filter search input
let typingTimer;
const doneTypingInterval = 1000; // 1 second

function updateSignatoriesPaginationLinks(data) {

    const signatoryPaginationLinks = $('#signatories_pagination');
    signatoryPaginationLinks.empty(); // Clear the pagination links container

    const currentPage = data.current_page;
    const lastPage = data.last_page;
    const perPage = data.per_page;
    const totalEntries = data.total;
    const startEntry = (currentPage - 1) * perPage + 1;
    const endEntry = Math.min(currentPage * perPage, totalEntries);
    const summaryMessage = `Showing ${startEntry} to ${endEntry} of ${totalEntries} entries`;

    // Add "Chevrons Left" link
    if (currentPage > 1) {
        signatoryPaginationLinks.append('<li class="page-item"><a class="page-link" href="#" data-page="1"><i class="fa fa-angle-double-left w-4 h-4"></i></a></li>');
    }

    // Add "Chevron Left" link
    if (currentPage > 1) {
        signatoryPaginationLinks.append(`<li class="page-item"><a class="page-link" href="#" data-page="${currentPage - 1}"><i class="fa fa-angle-left w-4 h-4"></i></a></li>`);
    }

    // Add ellipsis link for skipped pages
    if (currentPage > 3) {
        signatoryPaginationLinks.append('<li class="page-item"><a class="page-link" href="#">...</a></li>');
    }

    // Add page links
    for (let i = Math.max(1, currentPage - 2); i <= Math.min(currentPage + 2, lastPage); i++) {
        const activeClass = i === currentPage ? 'active' : '';
        signatoryPaginationLinks.append(`<li class="page-item ${activeClass}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`);
    }

    // Add ellipsis link for skipped pages
    if (currentPage < lastPage - 2) {
        signatoryPaginationLinks.append('<li class="page-item"><a class="page-link" href="#">...</a></li>');
    }

    // Add "Chevron Right" link
    if (currentPage < lastPage) {
        signatoryPaginationLinks.append(`<li class="page-item"><a class="page-link" href="#" data-page="${currentPage + 1}"><i class="fa fa-angle-right w-4 h-4"></i></a></li>`);
    }

    // Add "Chevrons Right" link
    if (currentPage < lastPage) {
        signatoryPaginationLinks.append(`<li class="page-item"><a class="page-link" href="#" data-page="${lastPage}"><i class="fa fa-angle-double-right w-4 h-4" ></i></a></li>`);
    }

    // Add the summary message
    const summaryContainer = $('.summary');
    summaryContainer.text(summaryMessage);
}

function paginationEventHandler(){

    /** EMPLOYEE TABLE Event handler for pagination links  */
    $('body').on('click', '#employee_pagination a', function (event) {
        event.preventDefault();
        const page = $(this).data('page');
        fetchEmployeeData(page);
    });

    /** STUDENTS TABLE Event handler for pagination links  */
    $('body').on('click', '#students_pagination a', function (event) {
        event.preventDefault();
        const page = $(this).data('page');

        let searchKeyword = $('#filter-search-students').val();

        const filters = {
            search: searchKeyword,
        };

        fetchStudentsData(page, filters);
    });


    /** SIGNATORIES TABLE Event handler for pagination links  */
    $('body').on('click', '#signatories_pagination a', function (event) {


        event.preventDefault();
        const page = $(this).data('page');

        let clearance_id = $('.mdl_input_clearance_id').val();

        if(clearance_id)
        {
            const filters = {

                clearanceId: clearance_id,

            };
            fetchSignatoriesData(page, filters);
        }else
        {
            fetchSignatoriesData(page);
        }



    });

}


/** STUDENTS LIST Event handler for Items per page select box */
$('body').on('change','#filter-size-students', function () {
    currentFilterSize = parseInt($(this).val());
    // console.log("", currentFilterSize);
    const filters = {
        limit: currentFilterSize
    };
    fetchStudentsData(1, filters); // Fetch the first page of data with the applied filters and updated size
});

function updateStudentListPaginationLinks(data) {

    const StudentspaginationLinks = $('#students_pagination');
    StudentspaginationLinks.empty(); // Clear the pagination links container

    const currentPage = data.current_page;
    const lastPage = data.last_page;
    const perPage = data.per_page;
    const totalEntries = data.total;
    const startEntry = (currentPage - 1) * perPage + 1;
    const endEntry = Math.min(currentPage * perPage, totalEntries);
    const summaryMessage = `Showing ${startEntry} to ${endEntry} of ${totalEntries} entries`;


    // Add "Chevrons Left" link
    if (currentPage > 1) {
        StudentspaginationLinks.append('<li class="page-item"><a class="page-link" href="#" data-page="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="chevrons-left" class="lucide lucide-chevrons-left w-4 h-4" data-lucide="chevrons-left"><polyline points="11 17 6 12 11 7"></polyline><polyline points="18 17 13 12 18 7"></polyline></svg></a></li>');
    }

    // Add "Chevron Left" link
    if (currentPage > 1) {
        StudentspaginationLinks.append(`<li class="page-item"><a class="page-link" href="#" data-page="${currentPage - 1}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="chevron-left" class="lucide lucide-chevron-left w-4 h-4" data-lucide="chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>`);
    }

    // Add ellipsis link for skipped pages
    if (currentPage > 3) {
        StudentspaginationLinks.append('<li class="page-item"><a class="page-link" href="#">...</a></li>');
    }

    // Add page links
    for (let i = Math.max(1, currentPage - 2); i <= Math.min(currentPage + 2, lastPage); i++) {
        const activeClass = i === currentPage ? 'active' : '';
        StudentspaginationLinks.append(`<li class="page-item ${activeClass}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`);
    }

    // Add ellipsis link for skipped pages
    if (currentPage < lastPage - 2) {
        StudentspaginationLinks.append('<li class="page-item"><a class="page-link" href="#">...</a></li>');
    }

    // Add "Chevron Right" link
    if (currentPage < lastPage) {
        StudentspaginationLinks.append(`<li class="page-item"><a class="page-link" href="#" data-page="${currentPage + 1}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="chevron-right" class="lucide lucide-chevron-right w-4 h-4" data-lucide="chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>`);
    }

    // Add "Chevrons Right" link
    if (currentPage < lastPage) {
        StudentspaginationLinks.append(`<li class="page-item"><a class="page-link" href="#" data-page="${lastPage}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="chevrons-right" class="lucide lucide-chevrons-right w-4 h-4" data-lucide="chevrons-right"><polyline points="13 17 18 12 13 7"></polyline><polyline points="6 17 11 12 6 7"></polyline></svg></a></li>`);
    }

    // Add the summary message
    const summaryContainer = $('.summary');
    summaryContainer.text(summaryMessage);
}

/** FILTER SEARCH STUDENTS LIST */
$('body').on('keyup','#filter-search-students', function (event) {

    clearTimeout(typingTimer);
    const searchKeyword = $(this).val();

    if (event.keyCode === 13) {
        // If the Enter key is pressed, fetch immediately without delay
        fetchFilteredStudentsData(searchKeyword);
    } else {
        // Otherwise, set the timer to fetch after the doneTypingInterval
        typingTimer = setTimeout(function () {
            fetchFilteredStudentsData(searchKeyword);
        }, doneTypingInterval);
    }
});
// Function to fetch filtered STUDENTS DATA from the server using AJAX
function fetchFilteredStudentsData(searchKeyword) {

    let page_number = $('#filter-size').val();

    const filters = {
        search: searchKeyword,
        filterDate: filterDate,
        page_number: page_number,
    };

    fetchStudentsData(1, filters);
}






/** FACULTY LIST Event handler for Items per page select box */
$('body').on('change','#filter-size-faculty', function () {
    currentFilterSize = parseInt($(this).val());
    // console.log("", currentFilterSize);
    const filters = {
        limit: currentFilterSize
    };
    fetchEmployeeData(1, filters); // Fetch the first page of data with the applied filters and updated size
});

function updateEmployeeListPaginationLinks(data) {

    const EmployeepaginationLinks = $('#employee_pagination');
    EmployeepaginationLinks.empty(); // Clear the pagination links container

    const currentPage = data.current_page;
    const lastPage = data.last_page;
    const perPage = data.per_page;
    const totalEntries = data.total;
    const startEntry = (currentPage - 1) * perPage + 1;
    const endEntry = Math.min(currentPage * perPage, totalEntries);
    const summaryMessage = `Showing ${startEntry} to ${endEntry} of ${totalEntries} entries`;

    // Add "Chevrons Left" link
    if (currentPage > 1) {
        EmployeepaginationLinks.append('<li class="page-item"><a class="page-link" href="#" data-page="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="chevrons-left" class="lucide lucide-chevrons-left w-4 h-4" data-lucide="chevrons-left"><polyline points="11 17 6 12 11 7"></polyline><polyline points="18 17 13 12 18 7"></polyline></svg></a></li>');
    }

    // Add "Chevron Left" link
    if (currentPage > 1) {
        EmployeepaginationLinks.append(`<li class="page-item"><a class="page-link" href="#" data-page="${currentPage - 1}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="chevron-left" class="lucide lucide-chevron-left w-4 h-4" data-lucide="chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>`);
    }

    // Add ellipsis link for skipped pages
    if (currentPage > 3) {
        EmployeepaginationLinks.append('<li class="page-item"><a class="page-link" href="#">...</a></li>');
    }

    // Add page links
    for (let i = Math.max(1, currentPage - 2); i <= Math.min(currentPage + 2, lastPage); i++) {
        const activeClass = i === currentPage ? 'active' : '';
        EmployeepaginationLinks.append(`<li class="page-item ${activeClass}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`);
    }

    // Add ellipsis link for skipped pages
    if (currentPage < lastPage - 2) {
        EmployeepaginationLinks.append('<li class="page-item"><a class="page-link" href="#">...</a></li>');
    }

    // Add "Chevron Right" link
    if (currentPage < lastPage) {
        EmployeepaginationLinks.append(`<li class="page-item"><a class="page-link" href="#" data-page="${currentPage + 1}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="chevron-right" class="lucide lucide-chevron-right w-4 h-4" data-lucide="chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>`);
    }

    // Add "Chevrons Right" link
    if (currentPage < lastPage) {
        EmployeepaginationLinks.append(`<li class="page-item"><a class="page-link" href="#" data-page="${lastPage}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="chevrons-right" class="lucide lucide-chevrons-right w-4 h-4" data-lucide="chevrons-right"><polyline points="13 17 18 12 13 7"></polyline><polyline points="6 17 11 12 6 7"></polyline></svg></a></li>`);
    }

    // Add the summary message
    const summaryContainer = $('.summary');
    summaryContainer.text(summaryMessage);
}

/** FILTER SEARCH FACULTY LIST */
$('body').on('keyup','#filter-search-faculty', function (event) {

    clearTimeout(typingTimer);
    const searchKeyword = $(this).val();
    if (event.keyCode === 13) {
        // If the Enter key is pressed, fetch immediately without delay
        fetchFilteredEmployeeData(searchKeyword);
    } else {
        // Otherwise, set the timer to fetch after the doneTypingInterval
        typingTimer = setTimeout(function () {
            fetchFilteredEmployeeData(searchKeyword);
        }, doneTypingInterval);
    }
});
// Function to fetch filtered STUDENTS DATA from the server using AJAX
function fetchFilteredEmployeeData(searchKeyword) {

    let page_number = $('#filter-size').val();

    const filters = {
        search: searchKeyword,
        filterDate: filterDate,
        page_number: page_number,
    };

    fetchEmployeeData(1, filters);
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

function addSignatories(){

    /** ADD STUDENT AFFAIRS SIGNATORY */
    $('body').on('click', '.btn_add_signatory', function(){

        let clearance_id = $('.mdl_input_clearance_id').val();
        let student_id = $(this).data('student-id');


        /** RESPONSIBLE FOR REMOVING TABLE ROW AFTER CLICK  */
        $(this).closest('tr').remove();


        $.ajax({
            url: '/student/clearance/student/add-to/signatories',
            type: 'POST',
            data: { student_id, clearance_id},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': _token,
            },
            beforeSend: function () {


            },
            success: function (data) {

                __notif_show(1, 'Success', data['message']);

                // const filters = {
                //
                //     clearanceId: clearance_id,
                //
                // };
                // fetchSignatoriesData(1, filters);

            },

            complete: function () {


            }
        });

    });


    /** ADD ACADEMIC AFFAIRS SIGNATORY */
    $('body').on('click', '.btn_add_employee_signatory', function(){

        let clearance_id = $('.mdl_input_clearance_id').val();
        let employee_id = $(this).data('employee-id');


        /** RESPONSIBLE FOR REMOVING TABLE ROW AFTER CLICK  */
        $(this).closest('tr').remove();


        $.ajax({
            url: '/student/clearance/employee/add-to/signatories',
            type: 'POST',
            data: { employee_id, clearance_id},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': _token,
            },
            beforeSend: function () {


            },
            success: function (data) {

                __notif_show(1, 'Success', data['message']);

                // const filters = {
                //
                //     clearanceId: clearance_id,
                //
                // };
                // fetchSignatoriesData(1, filters);

            },

            complete: function () {


            }
        });

    });


    /** CLOSE MODAL */
    $('body').on('click', '.btn_close_modal', function(){

        let clearance_id = $('.mdl_input_clearance_id').val();

        const filters = {

            clearanceId: clearance_id,

        };
        fetchSignatoriesData(1, filters);

    });

}

function addDesignation(){

    // Use event delegation to handle "Enter" key press for dynamically added input fields
    $('#signatories_list_tbl').on('keypress', '.input_signatory_desig', function(event) {
        // Check if the pressed key is "Enter" (keyCode 13)
        if (event.keyCode === 13) {

            // Prevent the default form submission
            event.preventDefault();

            // Get the input value
            let signatory_id = $(this).data('signatory-id');
            let designation = $(this).val();


            let clearance_id = $('.mdl_input_clearance_id').val();

            // Make an AJAX request
            $.ajax({
                url: '/student/clearance/add/designation',
                type: 'POST',
                data: { signatory_id, designation},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': _token,
                },
                beforeSend: function () {


                },
                success: function (data) {

                    __notif_show(1, 'Success', data['message']);

                    const filters = {

                        clearanceId: clearance_id,

                    };
                    fetchSignatoriesData(1, filters);

                },

                complete: function () {


                }
            });
        }
    });

}

function removeSignatory(){

    $('body').on('click', '.btn_remove_signatory', function(){

        let clearance_id = $('.mdl_input_clearance_id').val();
        let signatory_id = $(this).data('signatory-id');

        // Make an AJAX request
        $.ajax({
            url: '/student/clearance/remove/from/signatories',
            type: 'POST',
            data: { signatory_id, clearance_id },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': _token,
            },
            beforeSend: function () {


            },
            success: function (data) {

                __notif_show(1, 'Success', data['message']);

                const filters = {

                    clearanceId: clearance_id,

                };
                fetchSignatoriesData(1, filters);

            },

            complete: function () {


            }
        });

    });

}










