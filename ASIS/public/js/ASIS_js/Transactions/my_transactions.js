var _token = $('meta[name="csrf-token"]').attr('content');

$(document).ready(function () {

    fetchMyTransactionsData(); // Fetch and populate the curriculum data in the table using AJAX


});

// Function to fetch curriculum data from the server using AJAX
function fetchMyTransactionsData(page, filters) {

    // Update the table with the received data
    const tableBody = $('#my-transaction-list-table tbody');

    tableBody.empty(); // Clear the table body first
    let count = 1;


    $.ajax({
        url: '/transaction/my/list-load?page=' + page,
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
            }
            else if(data.transactions)
            {
                if(data.transactions == '')
                {
                    noResult(tableBody);
                }
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
    fetchMyTransactionsData(page);
});

// Event handler for "Items per page" select box
$('#filter-size').on('change', function () {
    currentFilterSize = parseInt($(this).val());
    // console.log("", currentFilterSize);
    const filters = {
        limit: currentFilterSize
    };
    fetchMyTransactionsData(1, filters); // Fetch the first page of data with the applied filters and updated size
});



// Event handler for "Items per status" select box
$('#filter-status').on('change', function () {
    currentFilterStatus = parseInt($(this).val());
    // console.log("", currentFilterSize);
    const filters = {
        limitStatus: currentFilterStatus
    };
    fetchMyTransactionsData(1, filters); // Fetch the first page of data with the applied filters and updated size
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

    fetchMyTransactionsData(1, filters);
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
