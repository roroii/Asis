var _token = $('meta[name="csrf-token"]').attr('content');
var filterDate;
var page_number;


$(document).ready(function () {

    fetchCreatedClearance();        // Fetch and populate the CREATED CLEARANCE data in the table using AJAX
    requestClearance();

    fetchSignatoriesData();

    $('.btn_view_more').hide();

    viewMoreSignatories();



    fetchMyClearanceRecentActivities();

    viewRecentActivity();
    viewMoreRecentActivity();

    viewMyClearanceSigned();
    modalPaginationEventHandler();

    viewMySignatory();

    a_tag_print_clearance();

});

// Function to fetch SIGNATORIES data from the server using AJAX
function fetchCreatedClearance(page, filters) {

    const createdClearanceTableBody = $('#my_clearance_list_tbl tbody');

    createdClearanceTableBody.empty(); // Clear the table body first

    $.ajax({
        url: '/student/clearance/load/my/clearance?page=' + page,
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
                    noResult(createdClearanceTableBody, message);
                }

                let checkbox_ = '';
                let action_button = '';

                data.transactions.forEach(function (transaction) {

                    if(transaction.status == 'Open')
                    {
                        checkbox_ = `<input data-clearance-id="${ transaction.clearance_id }" class="form-check-input clearance_status" type="checkbox" checked>`;

                    }else
                    {
                        checkbox_ = `<input data-clearance-id="${ transaction.clearance_id }" class="form-check-input clearance_status" type="checkbox">`;
                    }

                    if(transaction.has_requested)
                    {
                        action_button = `

                                <a href="/student/clearance/print/clearance/${ transaction.clearance_id }" target="_blank" class="flex items-center text-primary whitespace-nowrap mr-5"
                                    data-clearance-id="${ transaction.clearance_id }"
                                >
                                <i class="fa-solid fa-print mr-2"></i></i>Print</a>`;
                    }else
                    {
                        action_button = `
                                <a class="flex items-center text-primary whitespace-nowrap mr-5 btn_request_clearance" href="javascript:;"
                                data-clearance-id="${ transaction.clearance_id }"
                                >
                                <i class="fa-regular fa-paper-plane mr-2"></i></i>Request</a>`;
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
                        <td>
                            <a href="javascript:;" class="text-slate-500 font-medium whitespace-nowrap">School Year: <span class="font-medium whitespace-nowrap">${ transaction.year }</span></a>
                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">Semester: ${ transaction.sem }</div>
                        </td>
                        <td class="text-center">
                            <div class="${ transaction.signatory_class } "
                                data-clearance-id="${ transaction.clearance_id }"
                                >
                                <a href="javascript:;" class="box flex items-center px-3 py-2 rounded-md bg-white/10 dark:bg-darkmode-700 font-medium">
                                    <i class="fa-solid fa-users w-4 h-4 mr-1"></i>
                                    <span class="text-${ transaction.counter_class }">${ transaction.counted_signatories }</span>
                                </a>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="${ transaction.signatory_class } btn_view_signedMyClearance"
                                data-clearance-id="${ transaction.clearance_id }"
                                data-tracking-id="${ transaction.tracking_id }"
                                data-student-id="${ transaction.student_id }">

                                <a href="javascript:;" class="box flex items-center px-3 py-2 rounded-md bg-white/10 dark:bg-darkmode-700 font-medium">
                                    <i class="fa-solid fa-users w-4 h-4 mr-1"></i>
                                    <span class="text-${ transaction.counter_class }">${ transaction.clearance_students_count }</span>
                                </a>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="flex justify-center items-center">
                                <a href="javascript:;" class="box flex items-center px-3 py-2 rounded-md bg-white/10 dark:bg-darkmode-700 font-medium btn_status">
                                    <div class="w-2 h-2 bg-${ transaction.status_class } rounded-full mr-3"></div> <span class="text-${ transaction.status_class }">${ transaction.status }</span>
                                </a>
                            </div>
                        </td>
                        <td class="table-report__action">
                            <div class="flex justify-center items-center">

                                ${ action_button }

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



function requestClearance(){

    $('body').on('click', '.btn_request_clearance', function(){

        let this_button = $(this);

        let encrypted_clearance_id = $(this).data('clearance-id');

        $.ajax({
            url: '/student/clearance/request/clearance',
            type: 'POST',
            data: { encrypted_clearance_id },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': _token,
            },
            beforeSend: function () {

                this_button.html('<svg width="25" viewBox="-2 -2 42 42" xmlns="http://www.w3.org/2000/svg" stroke="rgb(30, 41, 59)" class="w-4 h-4 mr-2"><g fill="none" fill-rule="evenodd"><g transform="translate(1 1)" stroke-width="4"><circle stroke-opacity=".5" cx="18" cy="18" r="18"></circle><path d="M36 18c0-9.94-8.06-18-18-18"><animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="1s" repeatCount="indefinite"></animateTransform></path></g></g></svg> Requesting');
                this_button.prop('disabled', true);

            },
            success: function (data) {

                Swal.fire({
                    icon: data['status'],
                    title: data['title'],
                    text: data['message'],
                });

                fetchCreatedClearance();

            },
            complete: function () {

                this_button.html('<i class="fa-regular fa-paper-plane mr-2"></i></i>Request</a>');
                this_button.prop('disabled', false);

            }
        });
    });

}




function fetchSignatoriesData(){

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

            const signatory_div = $('#signatory_div');
            signatory_div.empty(); // Clear the table body first


            let action_button ='';
            if(data.result == '')
            {
                let message = 'No Clearance Found yet!';
                noSignatoryResult(signatory_div, message)
            }
            data.result.forEach(function (data) {

                count++

                if (count <= 5) {
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
                                    <img alt="Midone - HTML Admin Template" src="/dist/images/profile-9.jpg">
                                </div>
                                <div class="ml-4 mr-auto">
                                    <div class="font-medium">${data.student_fullName}</div>
                                    <div class="text-slate-500 text-xs mt-0.5">${data.date_requested}</div>
                                </div>
                               <div class="py-1 px-2 rounded-full text-xs bg-${data.activity_status_class} text-white cursor-pointer font-medium">${data.activity_status}</div>
                            </div>
                        </div>
                     `;
                    signatory_div.append(signatoryList); // Append curriculum row to the table

                }

                if (count >= 5) {

                    $('.btn_view_more').show();
                }

            });

        },
        complete: function () {


        }
    });

}


function viewMoreSignatories(){

    $('body').on('click', '.btn_view_more', function(){

        const filters = {

            is_ViewingMore: true,

        };
        fetchMySignatories(1, filters);

        __modal_toggle('view_more_signatory_mdl');

    });

}
function fetchMySignatories(page, filters){

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

                    // Create the HTML structure for each curriculum row
                    // Create the HTML structure for each curriculum row
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
                                <img alt="Midone - HTML Admin Template" src="/dist/images/profile-9.jpg">
                            </div>
                            <div class="ml-4 mr-auto">
                                <div class="font-medium">${data.student_fullName}</div>
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
                                <img alt="Midone - HTML Admin Template" src="/dist/images/profile-9.jpg">
                            </div>
                            <div class="ml-4 mr-auto">
                                <div class="font-medium">${data.student_fullName}</div>
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


let typingTimer;
const doneTypingInterval = 1000; // 1 second
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

        fetchMySignatories(page, filters);
    });



    /** STUDENTS LIST Event handler for Items per page select box */
    $('body').on('change','#filter-size-signatory-list', function () {

        currentFilterSize = parseInt($(this).val());
        const filters = {

            is_ViewingMore: true,
            page_limit: currentFilterSize,
        };

        fetchMySignatories(1, filters);
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

// Function to fetch filtered STUDENTS DATA from the server using AJAX
function fetchFilteredSignatoriesData(searchKeyword, currentFilterSize) {

    const filters = {

        is_ViewingMore: true,
        search: searchKeyword,
        page_limit: currentFilterSize,
    };

    fetchMySignatories(1, filters);
}



function fetchMyClearanceRecentActivities(){

    $('.btn_view_more_recents').hide();

    $.ajax({
        url: '/student/clearance/load/my/recent/activities',
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
            let recent_activities_div = $('#recent_activities_div');

            recent_activities_div.empty();

            let action_button ='';

            if(data.result == '')
            {
                let message = 'No Recent Activities yet!';
                noSignatoryResult(recent_activities_div, message)
            }
            data.result.forEach(function (data) {

                count++

                if (count <= 5) {
                    // Create the HTML structure for each curriculum row
                    const recent_activities_list = `
                        <div class="intro-x btn_view_recentActivity"

                        data-activity-id="${ data.clearance_activity_id }"
                        data-signatory-id="${ data.signatory_id }"
                        data-remarks="${ data.remarks }"
                        data-tracking-id="${data.clearance_tracking_id}"
                        data-clearance-id="${data.clearance_id}"
                        data-date="${data.date_requested}"
                        data-signatory-name="${data.signatory_fullName}"
                        data-status="${data.activity_status}"
                        data-status-class="${data.activity_status_class}"

                        >
                            <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                                <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                    <img alt="Midone - HTML Admin Template" src="/uploads/settings/DSSC/global_logo.png">
                                </div>
                                <div class="ml-4 mr-auto">
                                    <div class="font-medium">${data.signatory_fullName}</div>
                                    <div class="text-slate-500 text-xs mt-0.5">${data.date_requested}</div>
                                </div>
                               <div class="py-1 px-2 rounded-full text-xs bg-${data.activity_status_class} text-white cursor-pointer font-medium">${data.activity_status}</div>
                            </div>
                        </div>
                     `;
                    recent_activities_div.append(recent_activities_list); // Append curriculum row to the table

                }

                if (count >= 5) {

                    $('.btn_view_more_recents').show();
                }
            });

        },
        complete: function () {


        }
    });

}
function viewRecentActivity(){

    $('body').on('click', '.btn_view_recentActivity', function(){

        let activity_id = $(this).data('activity-id');
        let tracking_id = $(this).data('tracking-id');
        let clearance_id = $(this).data('clearance-id');
        let signatory_id = $(this).data('signatory-id');
        let signatory_name = $(this).data('signatory-name');
        let date = $(this).data('date');
        let remarks = $(this).data('remarks');
        let status = $(this).data('status');
        let status_class = $(this).data('status-class');

        if(status == 'Returned')
        {
            // Display a Swal modal with an input field
            swal.fire({
                icon: 'info',
                title: 'Clearance Information',

                html:
                    `<div class="validate-form">

                     <div class="input-form text-left">
                         <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Returned by:</span>
                         <span class="sm:ml-auto mt-1 sm:mt-0 text-xs txt_student_name">${    signatory_name  }</span>
                     </div>
                     <div class="input-form text-left">
                         <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Date Returned:</span>
                         <span class="sm:ml-auto mt-1 sm:mt-0 text-xs txt_student_name">${    date  }</span>
                     </div>
                      <div class="input-form text-left">
                         <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Status:</span>
                         <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-${status_class} txt_student_name">${    status  }</span>
                     </div>
                     <div class="input-form text-left">
                         <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Remarks:</span>
                         <span class="sm:ml-auto mt-1 sm:mt-0 text-xs txt_student_name">${ remarks }</span>
                     </div>

                        <button id="approveBtn" type="button" class="btn btn-primary mt-5 mr-2">Resubmit</button>
                        <button id="cancelBtn" type="button" class="btn btn-secondary mt-5 mr-2">Close</button>

                 </div>`,
                showCancelButton: false,
                showConfirmButton: false,
                allowOutsideClick: false, // Prevent closing when clicking outside

                didOpen: () => {

                    // Attach event listeners to custom buttons
                    $("#approveBtn").on("click", function() {

                        let isApproved = 11;

                        let data = {

                            activity_id,
                        };

                        ClearanceResubmitAjaxRequest(data);

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

        }else if(status == 'Approved')
        {
            // Display a Swal modal with an input field
            swal.fire({
                icon: 'info',
                title: 'Clearance Information',

                html:
                    `<div class="validate-form">

                     <div class="input-form text-left">
                         <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Approved by:</span>
                         <span class="sm:ml-auto mt-1 sm:mt-0 text-xs txt_student_name">${    signatory_name  }</span>
                     </div>
                     <div class="input-form text-left">
                         <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Date Approved:</span>
                         <span class="sm:ml-auto mt-1 sm:mt-0 text-xs txt_student_name">${    date  }</span>
                     </div>
                      <div class="input-form text-left">
                         <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Status:</span>
                         <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-${status_class} txt_student_name">${    status  }</span>
                     </div>
                     <div class="input-form text-left">
                         <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Remarks:</span>
                         <span class="sm:ml-auto mt-1 sm:mt-0 text-xs txt_student_name">${ remarks }</span>
                     </div>

                 </div>`,
                showCancelButton: true,
                showConfirmButton: false,
                cancelButtonText: 'Close',
            });
        }
        else if(status == 'Resubmitted')
        {
            // Display a Swal modal with an input field
            swal.fire({
                icon: 'info',
                title: 'Clearance Information',

                html:
                    `<div class="validate-form">

                     <div class="input-form text-left">
                         <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Resubmitted to:</span>
                         <span class="sm:ml-auto mt-1 sm:mt-0 text-xs txt_student_name">${    signatory_name  }</span>
                     </div>
                     <div class="input-form text-left">
                         <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Date Resubmitted:</span>
                         <span class="sm:ml-auto mt-1 sm:mt-0 text-xs txt_student_name">${    date  }</span>
                     </div>
                      <div class="input-form text-left">
                         <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Status:</span>
                         <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-${status_class} txt_student_name">${    status  }</span>
                     </div>

                 </div>`,
                showCancelButton: true,
                showConfirmButton: false,
                cancelButtonText: 'Close',
            });
        }



    });

}
function viewMoreRecentActivity(){

    $('body').on('click', '.btn_view_more_recents', function(){

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
function ClearanceResubmitAjaxRequest(data){

    $.ajax({
        url: '/student/clearance/resubmit/clearance',
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

            fetchMyClearanceRecentActivities();

        },
        complete: function () {


        }
    });

}


function viewMyClearanceSigned(){

    $('body').on('click', '.btn_view_signedMyClearance', function(){

        let clearance_id = $(this).data('clearance-id');
        let tracking_id = $(this).data('tracking-id');
        let student_id = $(this).data('student-id');

        const tableBody = $('#my_clearance_signed_list_tbl tbody');
        tableBody.empty(); // Clear the table body first

        __modal_toggle('view_my_clearance_signed_mdl');

        let data = {

            clearance_id,
            tracking_id,
            student_id
        };



        $.ajax({
            url: '/student/clearance/view/signed/data',
            type: 'POST',
            data: data,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': _token,
            },
            beforeSend: function () {


            },
            success: function (response) {

                let my_clearance_signed_list_tbl = $('#my_clearance_signed_list_tbl tbody');
                my_clearance_signed_list_tbl.empty();

                if(response.result == '')
                {
                    const transactionList = `
                     <tr class="intro-x">
                        <td colspan="2" class="w-full text-center">

                            <div style="visibility: hidden" class="text-slate-500 text-xs whitespace-nowrap mt-0.5">No Data</div>
                            <a href="javascript:;" class=" text-slate-500 text-xs whitespace-nowrap">No Data!</a>
                            <div style="visibility: hidden" class="text-slate-500 text-xs whitespace-nowrap mt-0.5">No Data</div>
                        </td>
                     </tr>`;

                    my_clearance_signed_list_tbl.append(transactionList); // Append curriculum row to the table
                }

                response.result.forEach(function (data) {

                    const transactionList = `
                     <tr class="intro-x">

                        <td>
                            <a href="javascript:;" class="font-medium whitespace-nowrap">${ data.signatory_fullName }</a>
                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">${ data.designation }</div>
                        </td>
                        <td >
                            <a href="javascript:;" class="text-${ data.activity_status_class  } font-medium whitespace-nowrap">${ data.activity_status }</a>
                        </td>
                     </tr>`;
                    my_clearance_signed_list_tbl.append(transactionList); // Append curriculum row to the table

                });

            },
            complete: function () {



            }
        });

    });

}
function loadingSpinner(tableBody){

    let loadingRow = `
                     <tr id="loading-row" class="intro-x">
                        <td colspan="4" class="w-full text-center">
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



function viewMySignatory(){

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

                    ClearanceApprovalAjaxSendRequest(data);

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

                    ClearanceApprovalAjaxSendRequest(data);

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
function ClearanceApprovalAjaxSendRequest(data){

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

            fetchSignatoriesData();
            fetchMySignatories();

        },
        complete: function () {


        }
    });

}
function a_tag_print_clearance(){

    // var printUrl = "https://example.com/print";
    // $('body').on('click', '#btn_a_tag_print', function(){
    //
    //     window.open(printUrl, "_blank");
    //
    // });

}
