var _token = $('meta[name="csrf-token"]').attr('content');
var tbl_students_list;

$(document).ready(function () {

    fetchMyStudentListData(); // Fetch and populate the curriculum data in the table using AJAX
    viewStudentInfo();
    // infiniteScrolling();


});

// Function to fetch curriculum data from the server using AJAX
function fetchMyStudentListData(page, filters) {
    $.ajax({
        url: '/ASIS/admin/load/list?page=' + page,
        type: 'POST',
        data: filters,
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': _token,
        },
        success: function (data) {

            // Update the table with the received data
            const tableBody = $('#student_list_table tbody');

            tableBody.empty(); // Clear the table body first
            let count = 1;

            if(data.search_query)
            {
                data.search_query.forEach(function (students_data) {

                    // Create the HTML structure for each curriculum row
                    const transactionList = `
                     <tr class="intro-x">

                        <td class="w-40 !py-4"> <a href="javascript:;" class="underline decoration-dotted whitespace-nowrap">${ students_data.student_id }</a> </td>
                        <td class="text-left">
                            <a href="" class="font-medium whitespace-nowrap">${ students_data.lastname } ${ students_data.firstname }, ${ students_data.middlename }</a>
                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">${ students_data.address }</div>
                        </td>
                        <td class="text-left">
                            <a href="" class="font-medium text-${ students_data.email_class  } whitespace-nowrap">${ students_data.email }</a>
                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">${ students_data.contact }</div>
                        </td>

                        <td class="table-report__action">
                            <div class="flex justify-center items-center">
                                <a data-student-id="${ students_data.student_id }" data-firstname="${ students_data.firstname }" data-midname="${ students_data.middlename }" data-lastname="${ students_data.lastname }" data-address="${ students_data.address }" data-email="${ students_data.email }" data-contact="${ students_data.contact }"
                                 class="flex items-center text-primary whitespace-nowrap mr-5 btn_view_student_info" href="javascript:;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="check-square" data-lucide="check-square" class="lucide lucide-check-square w-4 h-4 mr-1"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"></path></svg> View Details </a>
                            </div>
                        </td>
                     </tr>`;
                    tableBody.append(transactionList); // Append curriculum row to the table
                });
            }
            else if(data.students_data)
            {
                data.students_data.forEach(function (students_data) {

                    // Create the HTML structure for each curriculum row
                    const transactionList = `
                     <tr class="intro-x">

                        <td class="w-40 !py-4"> <a href="javascript:;" class="underline decoration-dotted whitespace-nowrap">${ students_data.student_id }</a> </td>
                        <td class="text-left">
                            <a href="" class="font-medium whitespace-nowrap">${ students_data.lastname } ${ students_data.firstname }, ${ students_data.middlename }</a>
                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">${ students_data.address }</div>
                        </td>
                        <td class="text-left">
                            <a href="" class="font-medium text-${ students_data.email_class  } whitespace-nowrap">${ students_data.email }</a>
                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">${ students_data.contact }</div>
                        </td>

                        <td class="table-report__action">
                            <div class="flex justify-center items-center">
                                <a data-student-id="${ students_data.student_id }" data-firstname="${ students_data.firstname }" data-midname="${ students_data.middlename }" data-lastname="${ students_data.lastname }" data-address="${ students_data.address }" data-email="${ students_data.email }" data-contact="${ students_data.contact }"
                                 class="flex items-center text-primary whitespace-nowrap mr-5 btn_view_student_info" href="javascript:;">
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

    fetchMyStudentListData(page, '');
});

// Event handler for "Items per page" select box
$('#filter-size').on('change', function () {
    currentFilterSize = parseInt($(this).val());
    // console.log("", currentFilterSize);
    const filters = {
        limit: currentFilterSize
    };
    fetchMyStudentListData(1, filters); // Fetch the first page of data with the applied filters and updated size
});


// Event handler for filter search input
let typingTimer;
const doneTypingInterval = 1500; // 1.5 second

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

    fetchMyStudentListData(1, filters);
}


function viewStudentInfo(){

    $('body').on('click', '.btn_view_student_info', function(){

        let student_id = $(this).data('student-id');
        let firstname = $(this).data('firstname');
        let midname = $(this).data('midname');
        let lastname = $(this).data('lastname');
        let address = $(this).data('address');
        let email = $(this).data('email');
        let contact = $(this).data('contact');

        $('#student_id').val(student_id);
        $('#student_firstname').val(firstname);
        $('#student_midname').val(midname);
        $('#student_lastname').val(lastname);
        $('#student_address').val(address);
        $('#student_email').val(email);
        $('#student_contact').val(contact);


        __modal_toggle('student_info_modal');

    });

}

function infiniteScrolling(){

    let currentPage = 1; // Initial page number
    let totalLoads = 0; // Counter for the number of times data is loaded


    $(window).scroll(function () {
        // If the user has scrolled to the bottom of the page
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
            // Increment the page number
            currentPage++;

            // Fetch more data using AJAX
            $.ajax({
                url: '/students/load/list?page=' + currentPage,
                type: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': _token,
                },
                success: function (data) {

                    // Update the table with the received data
                    const tableBody = $('#student_list_table tbody');

                    tableBody.empty(); // Clear the table body first
                    let count = 1;

                    if(data.search_query)
                    {
                        data.search_query.forEach(function (students_data) {

                            // Create the HTML structure for each curriculum row
                            const transactionList = `
                     <tr class="intro-x">

                        <td class="w-40 !py-4"> <a href="javascript:;" class="underline decoration-dotted whitespace-nowrap">${ students_data.student_id }</a> </td>
                        <td class="text-left">
                            <a href="" class="font-medium whitespace-nowrap">${ students_data.lastname } ${ students_data.firstname }, ${ students_data.middlename }</a>
                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">${ students_data.address }</div>
                        </td>
                        <td class="text-left">
                            <a href="" class="font-medium whitespace-nowrap">${ students_data.email }</a>
                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">${ students_data.contact }</div>
                        </td>

                        <td class="table-report__action">
                            <div class="flex justify-center items-center">
                                <a class="flex items-center text-primary whitespace-nowrap mr-5 btn_view_student_info" href="javascript:;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="check-square" data-lucide="check-square" class="lucide lucide-check-square w-4 h-4 mr-1"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"></path></svg> View Details </a>
                            </div>
                        </td>
                     </tr>`;
                            tableBody.append(transactionList); // Append curriculum row to the table
                        });
                    }
                    else if(data.students_data)
                    {
                        data.students_data.forEach(function (students_data) {

                            // Create the HTML structure for each curriculum row
                            const transactionList = `
                     <tr class="intro-x">

                        <td class="w-40 !py-4"> <a href="javascript:;" class="underline decoration-dotted whitespace-nowrap">${ students_data.student_id }</a> </td>
                        <td class="text-left">
                            <a href="" class="font-medium whitespace-nowrap">${ students_data.lastname } ${ students_data.firstname }, ${ students_data.middlename }</a>
                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">${ students_data.address }</div>
                        </td>
                        <td class="text-left">
                            <a href="" class="font-medium whitespace-nowrap">${ students_data.email }</a>
                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">${ students_data.contact }</div>
                        </td>

                        <td class="table-report__action">
                            <div class="flex justify-center items-center">
                                <a class="flex items-center text-primary whitespace-nowrap mr-5 btn_view_student_info" href="javascript:;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="check-square" data-lucide="check-square" class="lucide lucide-check-square w-4 h-4 mr-1"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"></path></svg> View Details </a>
                            </div>
                        </td>
                     </tr>`;
                            tableBody.append(transactionList); // Append curriculum row to the table
                        });
                    }


                    // Increment the current page for the next request
                    currentPage++;
                    totalLoads++;

                    // Update the pagination links
                    updatePaginationLinks(data);

                    // Show the summary message
                    const paginationSummary = $('#pagination-summary');
                    paginationSummary.text(data.summary);
                }

            });
        }
    });

}

