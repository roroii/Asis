var _token = $('meta[name="csrf-token"]').attr('content');
var filterDate;
var page_number;
var is_note_for_all = false;


$(document).ready(function () {

    fetchCreatedClearance();        // Fetch and populate the CREATED CLEARANCE data in the table using AJAX
    // fetchEmployeeData();        // Fetch and populate the EMPLOYEES data in the table using AJAX


    createClearance();
    deleteClearance();
    viewClearanceSignatories();
    editClearance();
    $('.btn_admin_view_more_signatories').hide();

    fetchEmployeeSignatoriesData();

    viewSignatory();
    viewMoreSignatories();
    modalPaginationEventHandler();
    createImportantNotes();
    toggleButtonNoteForAll();

    bindSelect2();

});

function bindSelect2(){

    $('#note_for_program').select2({

        placeholder: "Course/Program",

    });

    $('#clearance_program').select2({

        placeholder: "Course/Program",

    });

}

// Function to fetch SIGNATORIES data from the server using AJAX
function fetchCreatedClearance(page, filters) {

    const createdClearanceTableBody = $('#clearance_list_tbl tbody');

    createdClearanceTableBody.empty(); // Clear the table body first

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
                    noResult(createdClearanceTableBody, message);
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
                    createdClearanceTableBody.append(transactionList); // Append curriculum row to the table

                });
            }else
            {
                if(data.transactions == '')
                {
                    let message = 'No Clearance Available.';
                    noResult(createdClearanceTableBody, message);
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
                            <a href="javascript:;" class="font-medium whitespace-nowrap text-toldok tooltip" title="${ transaction.clearance_name }">${ transaction.clearance_name }</a>
                        </td>
                        <td class="w-40">
                            <a href="javascript:;" class="text-slate-500 font-medium whitespace-nowrap">${ transaction.clearance_type }</a>
                        </td>
                        <td class="w-40">
                            <a href="javascript:;" class="text-slate-500 font-medium whitespace-nowrap">${ transaction.course }</a>
                        </td>
                        <td>
                            <a href="javascript:;" class="text-slate-500 font-medium whitespace-nowrap">School Year: <span class="font-medium whitespace-nowrap">${ transaction.year }</span></a>
                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">Semester: ${ transaction.sem }</div>
                        </td>
                         <td class="text-center">
                            <div data-clearance-id="${ transaction.clearance_id }" class="${ transaction.signatory_class } bnt_clearance_signatories">
                                <a href="javascript:;" data-clearance-id="${ transaction.clearance_id }" class="box flex items-center px-3 py-2 rounded-md bg-white/10 dark:bg-darkmode-700 font-medium">
                                    <i class="fa-solid fa-users w-4 h-4 mr-1"></i>
                                    <span class="text-${ transaction.counter_class }">${ transaction.counted_signatories }</span>
                                </a>
                            </div>
                        </td>
                        <td class="text-center">

                            <div class="form-check form-switch">
                                    ${  checkbox_   }
                                    <label class="switch_label form-check-label text-${ transaction.status_class }" for="clearance_status">${ transaction.status }</label>
                                </div>
                            </div>

                        </td>
                        <td class="table-report__action">
                            <div class="flex justify-center items-center">


                                <a class="flex items-center text-success whitespace-nowrap mr-5 btn_edit_clearance" href="javascript:;"
                                data-clearance-id="${ transaction.clearance_id }"
                                data-clearance-type="${ transaction.raw_clearance_type }"
                                data-clearance-name="${ transaction.clearance_name }"
                                data-clearance-course="${ transaction.course }"
                                >
                                <i class="fa-regular fa-pen-to-square mr-2"></i>Edit</a>

                                <a class="flex items-center text-danger whitespace-nowrap mr-5 btn_remove_clearance" href="javascript:;"
                                data-clearance-id="${ transaction.clearance_id }"
                                >
                                <i class="fa-solid fa-delete-left mr-2"></i>Remove</a>

                            </div>
                        </td>
                     </tr>`;
                    createdClearanceTableBody.append(transactionList); // Append curriculum row to the table

                });
            }

            // Update the pagination links
            updatePaginationLinks(data);

        },
        complete: function () {


        }
    });
}
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
function noResult(tableBody, message){

    const transactionList = `
                     <tr class="intro-x">
                        <td colspan="7" class="w-full text-center">

                            <div style="visibility: hidden" class="text-slate-500 text-xs whitespace-nowrap mt-0.5">No Data</div>
                            <a href="javascript:;" class=" text-slate-500 text-xs whitespace-nowrap">${  message }</a>
                            <div style="visibility: hidden" class="text-slate-500 text-xs whitespace-nowrap mt-0.5">No Data</div>
                        </td>
                     </tr>`;

    return tableBody.append(transactionList); // Append curriculum row to the table

}




function createClearance(){

    $('body').on('click', '#btn_create_clearance', function(){

        $('.input_clearance_id_mdl').val(null);
        $('#clearance_name').val(null);
        $('#clearance_program').val(null);
        $('#clearance_type').val('NON_GRADUATING').trigger('change');
        $('.label_clearance_modal').text('Create Clearance')
        __modal_toggle('create_clearance_mdl');

        $('.mdl_btn_edit_signatories').hide();


    });

    $('body').on('click', '.btn_save_clearance', function(){

        let clearance_id = $('.input_clearance_id_mdl').val();
        let clearance_name = $('#clearance_name').val();
        let clearance_type = $('#clearance_type').val();
        let clearance_schoolYear = $('#clearance_schoolYear').val();
        let clearance_schoolSem = $('#clearance_schoolSem').val();
        let clearance_program = $('#clearance_program').val();

        let data = {

            clearance_id,
            clearance_name,
            clearance_type,
            clearance_schoolYear,
            clearance_schoolSem,
            clearance_program,

        };

        if(clearance_name == '' || clearance_program == '')
        {
            $('#clearance_name').addClass('border-danger');
            __notif_show(-1, 'Warning', 'Please fill up the required fields!');

        }else {

            $.ajax({
                url: '/student/clearance/create',
                type: 'POST',
                data: data,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': _token,
                },
                beforeSend: function () {

                    $('.btn_save_clearance').html('Saving <svg width="25" viewBox="-2 -2 42 42" xmlns="http://www.w3.org/2000/svg" stroke="white" class="w-4 h-4 ml-2"> <g fill="none" fill-rule="evenodd"> <g transform="translate(1 1)" stroke-width="4"> <circle stroke-opacity=".5" cx="18" cy="18" r="18"></circle><path d="M36 18c0-9.94-8.06-18-18-18"><animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="1s" repeatCount="indefinite"></animateTransform></path> </g></g> </svg>');
                    $('.btn_save_clearance').prop('disabled', true);
                },
                success: function (data) {

                    __notif_show(1, 'Success', data['message']);
                    fetchCreatedClearance();

                    $('.input_clearance_id_mdl').val();
                    $('#clearance_name').val();
                    $('#clearance_type').val();
                    $('#clearance_schoolYear').val();
                    $('#clearance_schoolSem').val();
                    $('#clearance_program').val(null).trigger('change');

                },
                complete: function () {

                    $('.btn_save_clearance').html('Save');
                    $('.btn_save_clearance').prop('disabled', false);

                    __modal_hide('create_clearance_mdl');
                    $('.mdl_btn_edit_signatories').show();

                },
            });
        }

    });

}
function deleteClearance(){

    $('body').on('click', '.btn_remove_clearance', function(){

        let this_button = $(this);
        let clearance_id = $(this).data('clearance-id');

        $.ajax({
            url: '/student/clearance/delete',
            type: 'POST',
            data: { clearance_id  },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': _token,
            },
            beforeSend: function () {

                this_button.prop('disabled', true);
            },
            success: function (data) {

                __notif_show(1, 'Success', data['message']);
                fetchCreatedClearance();
            },
            complete: function(){

                this_button.prop('disabled', false);

            },
        });

    });

}
function viewClearanceSignatories(){

    $('body').on('click', '.bnt_clearance_signatories', function(){

        let clearance_id = $(this).data('clearance-id');
        let this_button = $(this);

        const filters = {

            clearanceId: clearance_id,

        };

        __modal_toggle('clearance_signatories_mdl');
        $('.mdl_input_clearance_id').val(clearance_id);
        fetchSignatoriesData(1, filters);

    });


    $('body').on('click', '.btn_close_signatory_modal', function(){

        fetchCreatedClearance();

    });

}
function editClearance(){

    $('body').on('click', '.btn_edit_clearance', function(){

        let clearance_id = $(this).data('clearance-id');
        let clearance_type = $(this).data('clearance-type');
        let clearance_name = $(this).data('clearance-name');
        let clearance_course = $(this).data('clearance-course');

        $('.label_clearance_modal').text('Update Clearance')
        __modal_toggle('create_clearance_mdl');
        $('.mdl_btn_edit_signatories').show();

        $('.input_clearance_id_mdl').val(clearance_id);
        $('#clearance_type').val(clearance_type).trigger('change');
        $('#clearance_program').val(clearance_course).trigger('change');
        $('#clearance_name').val(clearance_name);

    });


    $('body').on('click', '.mdl_btn_edit_signatories', function(){



        let clearance_id = $('.input_clearance_id_mdl').val();

        const filters = {

            clearanceId: clearance_id,

        };

        $('.mdl_input_clearance_id').val(clearance_id);

        __modal_toggle('clearance_signatories_mdl');
        fetchSignatoriesData(1, filters);


    });


    /** UPDATE CLEARANCE STATUS */

    let clearance_status_checkbox = '';

    $('body').on('change', '.clearance_status', function(){

        /** STATUS CODES
         *
         * 13   -   OPEN
         * 14   -   CLOSE
         *
         * */
        let clearance_id = $(this).data('clearance-id');
        let this_checkbox = $(this);

        if ($(this).is(':checked')) {

            clearance_status_checkbox = 13;
            changeClearanceStatus(clearance_id, clearance_status_checkbox, this_checkbox);

        }else
        {
            clearance_status_checkbox = 14;
            changeClearanceStatus(clearance_id, clearance_status_checkbox, this_checkbox);

        }

    });


}

function changeClearanceStatus(clearance_id, clearance_status_checkbox, this_checkbox){

    $.ajax({
        url: '/student/clearance/update/status',
        type: 'POST',
        data: { clearance_id, clearance_status_checkbox  },
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': _token,
        },
        beforeSend: function () {

            this_checkbox.prop('disabled', true);

        },
        success: function (data) {

            __notif_show(1, 'Success', data['message']);
            fetchCreatedClearance();
            fetchEmployeeSignatoriesData();
        },
        complete: function(){

            this_checkbox.prop('disabled', false);

        },
    });

}


function fetchEmployeeSignatoriesData(){

    $.ajax({
        url: '/student/clearance/load/my/signatories',
        type: 'POST',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': _token,
        },
        beforeSend: function () {


        },
        success: function (data) {

            /**  Update the table with the received data */

            let count = 0;
            let signatory_div = $('#signatory_div');

            signatory_div.empty();

            let action_button ='';

            if(data.result == '')
            {
                let message = 'No Signatories yet!.';
                noSignatoryResult(signatory_div, message)
            }
            data.result.forEach(function (data) {

                count++

                if (count <= 10) {
                    // Create the HTML structure for each curriculum row
                    const signatoryList = `
                        <div class="intro-x btn_view_signatory"

                            data-tracking-id="${data.clearance_tracking_id}"
                            data-clearance-id="${data.clearance_id}"
                            data-date="${data.date_requested}"
                            data-student-id="${ data.student_id } "
                            data-student-name="${data.student_fullName}"

                        >
                            <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                                <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                    <img alt="Midone - HTML Admin Template" src="/uploads/settings/DSSC/global_logo.png">
                                </div>
                                <div class="ml-4 mr-auto">
                                    <div class="font-medium">${data.student_fullName}</div>
                                    <div class="text-slate-500 text-xs mt-0.5">${data.student_course}</div>
                                    <div class="text-slate-500 text-xs mt-0.5">${data.date_requested}</div>
                                </div>
                               <div class="py-1 px-2 rounded-full text-xs bg-${data.activity_status_class} text-white cursor-pointer font-medium">${data.activity_status}</div>
                            </div>
                        </div>
                     `;
                    signatory_div.append(signatoryList); // Append curriculum row to the table

                }

                if (count >= 10) {

                    $('.btn_admin_view_more_signatories').show();
                }

            });

        },
        complete: function () {


        }
    });

}

function noSignatoryResult(signatory_div, message){

    const signatoryList = `
                     <div class="intro-x">
                            <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                                <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                    <img alt="Midone - HTML Admin Template" src="/dist/images/empty.webp">
                                </div>
                                <div class="ml-4 mr-auto">
                                    <div class="font-medium">${message}</div>
                                </div>
                            </div>
                        </div>`;

    return signatory_div.append(signatoryList); // Append curriculum row to the table

}

function fetchEmployeeSignatories(page, filters){

    const mySignatoriesTableBody = $('#my_signatories_list_tbl tbody');

    mySignatoriesTableBody.empty(); // Clear the table body first

    $.ajax({
        url: '/student/clearance/load/my/signatories?page=' + page,
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
                    let message = 'No Clearance available.';
                    noResult(createdClearanceTableBody, message);
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
                    createdClearanceTableBody.append(transactionList); // Append curriculum row to the table

                });
            }else
            {
                if(data.transactions == '')
                {
                    let message = 'No Clearance available.';
                    noResult(mySignatoriesTableBody, message);
                }

                let checkbox_ = '';
                let action_button = '';

                data.result.forEach(function (transaction) {


                    // Create the HTML structure for each curriculum row
                    const signatoryList = `
                     <tr class="intro-x">
                        <td class="w-40 !py-4"> <a href="javascript:;" class="underline decoration-dotted whitespace-nowrap">${ transaction.student_id }</a> </td>
                        <td class="w-40">
                            <a href="javascript:;" class="font-medium whitespace-nowrap">${ transaction.student_fullName }</a>
                        </td>
                        <td class="w-40">
                            <a href="javascript:;" class="text-slate-500 whitespace-nowrap">${ transaction.student_course }</a>
                        </td>
                        <td class="text-center">
                            <div class="flex justify-center items-center">
                                <a href="javascript:;" class="box flex items-center px-3 py-2 rounded-md bg-white/10 dark:bg-darkmode-700 font-medium btn_status">
                                    <div class="w-2 h-2 bg-${ transaction.status_class } rounded-full mr-3"></div> <span class="text-${ transaction.status_class }">${ transaction.clearance_status }</span>
                                </a>
                            </div>
                        </td>
                        <td class="table-report__action">
                            <div class="flex justify-center items-center">
                                <a class="flex items-center text-primary whitespace-nowrap mr-5 btn_add_approve_clearance" href="javascript:;"
                                data-student-id="${ transaction.student_id }"
                                >
                                <i class="fa-regular fa-thumbs-up mr-1"></i> Approve </a>

                            </div>
                        </td>
                     </tr>`;
                    mySignatoriesTableBody.append(signatoryList); // Append curriculum row to the table

                });
            }

            // Update the pagination links
            updatePaginationLinks(data);

        },
        complete: function () {


        }
    });

}


function viewSignatory(){

    $('body').on('click', '.btn_view_signatory', function(){

        let tracking_id = $(this).data('tracking-id');
        let clearance_id = $(this).data('clearance-id');
        let student_id = $(this).data('student-id');
        let student_name = $(this).data('student-name');
        let date = $(this).data('date');

        // Display a Swal modal with an input field
        swal.fire({
            icon: 'info',
            title: 'Approval Form',

            html:
                `<div class="validate-form">

                     <div class="input-form text-left">
                         <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Tracking ID:</span>
                         <span class="sm:ml-auto mt-1 sm:mt-0 text-xs underline txt_student_id">${    tracking_id  }</span>
                     </div>
                     <div class="input-form text-left">
                         <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Student ID:</span>
                         <span class="sm:ml-auto mt-1 sm:mt-0 text-xs underline txt_student_id">${    student_id  }</span>
                     </div>
                     <div class="input-form text-left">
                         <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Clearance ID:</span>
                         <span class="sm:ml-auto mt-1 sm:mt-0 text-xs underline txt_student_id">${    clearance_id  }</span>
                     </div>
                     <div class="input-form text-left">
                         <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Student Name:</span>
                         <span class="sm:ml-auto mt-1 sm:mt-0 text-xs txt_student_name">${    student_name  }</span>
                     </div>
                     <div class="input-form text-left">
                         <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Date Requested:</span>
                         <span class="sm:ml-auto mt-1 sm:mt-0 text-xs txt_student_name">${    date  }</span>
                     </div>
                     <div class="input-form mt-5"> <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> Comment
                     <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Add at least 10 characters</span> </label>
                     <textarea id="comments" class="form-control" name="comments" placeholder="Type your comments" minlength="10"></textarea> </div>

                        <button id="approveBtn" type="button" class="btn btn-primary mt-5 mr-2">Approve</button>
                        <button id="returnBtn" type="button" class="btn btn-danger mt-5 mr-2">Return</button>
                        <button id="cancelBtn" type="button" class="btn btn-secondary mt-5 mr-2">Cancel</button>
                 </div>`,
            showCancelButton: false,
            showConfirmButton: false,
            allowOutsideClick: false, // Prevent closing when clicking outside

            didOpen: () => {

                // Attach event listeners to custom buttons
                $("#approveBtn").on("click", function() {

                    let isApproved = 11;

                    let data = {
                        isApproved,
                        tracking_id,
                        clearance_id,
                        student_id,
                        comments : $("#comments").val(),
                    };

                    ajaxRequest(data);

                });

                $("#returnBtn").on("click", function() {

                    let isApproved = 4;

                    let data = {
                        isApproved,
                        tracking_id,
                        clearance_id,
                        student_id,
                        comments : $("#comments").val(),
                    };

                    ajaxRequest(data);

                });

                $("#cancelBtn").on("click", function() {
                    swal.close();
                });
            },
            willClose: () => {

                // Remove event listeners when the modal is closed
                $("#approveBtn").off("click");
                $("#returnBtn").off("click");
                $("#cancelBtn").off("click");
                $("#comments").val(null);
            },
        });

    });

}

function ajaxRequest(data){

    $.ajax({
        url: '/student/clearance/approve/clearance',
        type: 'POST',
        data: data,
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': _token,
        },
        beforeSend: function () {


        },
        success: function (data) {

            Swal.fire({
                icon: 'success',
                title:  data['status'],

                showConfirmButton: false,
                timer: 1000  // Close the alert after 2 seconds
            });

            fetchEmployeeSignatoriesData();
            adminFetchMySignatories();

        },
        complete: function () {


        }
    });

}




function viewMoreSignatories(){

    $('body').on('click', '.btn_admin_view_more_signatories', function(){

        $('#filter-search-students-clearance').val('');
        const filters = {

            is_ViewingMore: true,

        };
        adminFetchMySignatories(1, filters);

        __modal_toggle('view_more_signatory_mdl');

    });

}
function adminFetchMySignatories(page, filters){

    const mySignatoriesTableBody = $('#my_signatories_list_tbl');
    mySignatoriesTableBody.empty(); // Clear the table body first

    $.ajax({
        url: '/student/clearance/load/my/signatories?page=' + page,
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
                    let message = 'No Clearance available.';
                    noResult(mySignatoriesTableBody, message);
                }

                data.search_query.forEach(function (data) {


                    const signatoryList = `
                     <div class="intro-x btn_view_signatory"
                            data-tracking-id="${data.clearance_tracking_id}"
                            data-clearance-id="${data.clearance_id}"
                            data-date="${data.date_requested}"
                            data-student-id="${ data.student_id } "
                            data-student-name="${data.student_fullName}"
                            >
                        <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                            <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                <img alt="Midone - HTML Admin Template" src="/uploads/settings/DSSC/global_logo.png">
                            </div>
                            <div class="ml-4 mr-auto">
                                <div class="font-medium">${data.student_fullName}</div>
                                <div class="text-slate-500 text-xs mt-0.5">${data.student_course}</div>
                                <div class="text-slate-500 text-xs mt-0.5">${data.date_requested}</div>
                            </div>
                           <div class="py-1 px-2 rounded-full text-xs bg-${data.activity_status_class} text-white cursor-pointer font-medium">${data.activity_status}</div>
                        </div>
                    </div>`;
                    mySignatoriesTableBody.append(signatoryList); // Append curriculum row to the table

                });
            }else
            {
                if(data.result == '')
                {
                    let message = 'No Clearance available.';
                    noResult(mySignatoriesTableBody, message);
                }

                data.result.forEach(function (data) {

                    // Create the HTML structure for each curriculum row
                    const signatoryList = `
                     <div class="intro-x btn_view_signatory"
                            data-tracking-id="${data.clearance_tracking_id}"
                            data-clearance-id="${data.clearance_id}"
                            data-date="${data.date_requested}"
                            data-student-id="${ data.student_id } "
                            data-student-name="${data.student_fullName}"
                            >
                        <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                            <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                <img alt="Midone - HTML Admin Template" src="/uploads/settings/DSSC/global_logo.png">
                            </div>
                            <div class="ml-4 mr-auto">
                                <div class="font-medium">${data.student_fullName}</div>
                                <div class="text-slate-500 text-xs mt-0.5">${data.student_course}</div>
                                <div class="text-slate-500 text-xs mt-0.5">${data.date_requested}</div>
                            </div>
                           <div class="py-1 px-2 rounded-full text-xs bg-${data.activity_status_class} text-white cursor-pointer font-medium">${data.activity_status}</div>
                        </div>
                    </div>`;
                    mySignatoriesTableBody.append(signatoryList); // Append curriculum row to the table

                });
            }

            // Update the pagination links
            updateSignatoryListPaginationLinks(data);

        },
        complete: function () {


        }
    });

}
function updateSignatoryListPaginationLinks(data) {

    const signatoryPaginationLinks = $('.signatory_list_pagination');
    signatoryPaginationLinks.empty(); // Clear the pagination links container

    const currentPage = data.current_page;
    const lastPage = data.last_page;
    const perPage = data.per_page;
    const totalEntries = data.total;

    // Add "Chevrons Left" link
    if (currentPage > 1) {
        signatoryPaginationLinks.append('<li class="page-item"><a class="page-link" href="#" data-page="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="chevrons-left" class="lucide lucide-chevrons-left w-4 h-4" data-lucide="chevrons-left"><polyline points="11 17 6 12 11 7"></polyline><polyline points="18 17 13 12 18 7"></polyline></svg></a></li>');
    }

    // Add "Chevron Left" link
    if (currentPage > 1) {
        signatoryPaginationLinks.append(`<li class="page-item"><a class="page-link" href="#" data-page="${currentPage - 1}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="chevron-left" class="lucide lucide-chevron-left w-4 h-4" data-lucide="chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>`);
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

    // Add "Single Chevron Right " link
    if (currentPage < lastPage) {
        signatoryPaginationLinks.append(`<li class="page-item"><a class="page-link" href="#" data-page="${currentPage + 1}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="chevron-right" class="lucide lucide-chevron-right w-4 h-4" data-lucide="chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>`);
    }

    // Add "Double Chevrons Right" link
    if (currentPage < lastPage) {
        signatoryPaginationLinks.append(`<li class="page-item"><a class="page-link" href="#" data-page="${lastPage}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="chevrons-right" class="lucide lucide-chevrons-right w-4 h-4" data-lucide="chevrons-right"><polyline points="13 17 18 12 13 7"></polyline><polyline points="6 17 11 12 6 7"></polyline></svg></a></li>`);
    }
}
function modalPaginationEventHandler(){


    /** SIGNATORY TABLE Event handler for pagination links  */
    $(document).on('click', '.signatory_list_pagination a', function (event) {
        event.preventDefault();
        const page = $(this).data('page');

        let searchKeyword = $('#filter-search-students-clearance').val();
        let page_limit = $('#filter-size-signatory-list').val();

        const filters = {

            search: searchKeyword,
            is_ViewingMore: true,
            page_limit: page_limit,
        };

        adminFetchMySignatories(page, filters);
    });



    /** STUDENTS LIST Event handler for Items per page select box */
    $('body').on('change','#filter-size-signatory-list', function () {

        currentFilterSize = parseInt($(this).val());
        const filters = {

            is_ViewingMore: true,
            page_limit: currentFilterSize,
        };

        adminFetchMySignatories(1, filters);
    });



    /** FILTER SEARCH STUDENTS LIST */
    $('body').on('keyup','#filter-search-students-clearance', function (event) {

        // Event handler for filter search input
        let currentFilterSize = $('#filter-size-signatory-list').val();

        clearTimeout(typingTimer);
        const searchKeyword = $(this).val();

        if (event.keyCode === 13) {
            // If the Enter key is pressed, fetch immediately without delay
            fetchFilteredSignatoriesData(searchKeyword, currentFilterSize);
        } else {
            // Otherwise, set the timer to fetch after the doneTypingInterval
            typingTimer = setTimeout(function () {
                fetchFilteredSignatoriesData(searchKeyword, currentFilterSize);
            }, doneTypingInterval);
        }
    });


}
function fetchFilteredSignatoriesData(searchKeyword, currentFilterSize) {

    const filters = {

        is_ViewingMore: true,
        search: searchKeyword,
        page_limit: currentFilterSize,
    };

    adminFetchMySignatories(1, filters);
}


function createImportantNotes(){

    $('body').on('click', '#btn_create_notes', function(){

        __modal_toggle('create_important_notes_mdl');

    });


    $('body').on('click', '.btn_mdl_save_notes', function(){

        let this_button = $(this);

        let note_for_program    = $('#note_for_program').val();
        let admin_note_title    = $('#admin_note_title').val();
        let admin_notes         = $('#admin_notes').val();

        let data = {

            note_for_program,
            admin_note_title,
            admin_notes,
            is_note_for_all,

        };

        $.ajax({
            url: '/student/clearance/create/important/notes',
            type: 'POST',
            data: data,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': _token,
            },
            beforeSend: function () {

                this_button.html('Saving <svg width="25" viewBox="-2 -2 42 42" xmlns="http://www.w3.org/2000/svg" stroke="white" class="w-4 h-4 ml-2"> <g fill="none" fill-rule="evenodd"> <g transform="translate(1 1)" stroke-width="4"> <circle stroke-opacity=".5" cx="18" cy="18" r="18"></circle><path d="M36 18c0-9.94-8.06-18-18-18"><animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="1s" repeatCount="indefinite"></animateTransform></path> </g></g> </svg>');
                this_button.prop('disabled', true);

            },
            success: function (data) {

                __notif_show(1, 'Success', data['message']);
                location.reload();

            },
            complete: function () {

                this_button.html('Save');
                this_button.prop('disabled', false);
                __modal_hide('create_important_notes_mdl');


            }
        });

    });



    $('body').on('click', '.btn_dismiss_notes', function(){

        let note_id = $(this).data('note-id');
        $.ajax({
            url: '/student/clearance/dismiss/important/notes',
            type: 'POST',
            data: { note_id },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': _token,
            },
            beforeSend: function () {


            },
            success: function (data) {

                location.reload();

            },
            complete: function () {



            }
        });

    });

}
function toggleButtonNoteForAll(){

    $('body').on('change', '.btn_switch_note_for_all', function(){

        if ($(this).is(':checked')) {

            $('.note_for_program_div').hide();
             is_note_for_all = true;

        }else
        {
            $('.note_for_program_div').show();
             is_note_for_all = false;
        }

    });


}
