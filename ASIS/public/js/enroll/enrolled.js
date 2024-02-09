var _token = $('meta[name="csrf-token"]').attr("content");
var currentSearchKeyword = "";
var schoolYear = "";
var semester = "";
var yearLevel = "";
var courseProgram = "";
var _status = "";
var currentFilterSize = 10; // Default filter size value

$(document).ready(function () {
    fetchEnrollmentData();
});



function fetchEnrollmentData(page, filters) {
    $.ajax({
        url: "enrollment-list-load?page=" + page,
        type: "GET",
        data: filters,
        dataType: "json",
        success: function (data) {
            console.log(data);
            const tableBody = $("#enrollment-list-table tbody");
            tableBody.empty();
            let count = 1;
            data.data.forEach(function (student) {
                const studentRow = `
                    <tr class="intro-x">
                        <td>${count++}</td>
                        <td>${student.studid}</td>
                        <td>${student.fullname}</td>
                        <td>${student.studmajor}</td>
                        <td>${student.year_level}</td>
                        <td>${student.number}</td>
                        <td>
                            <div class="flex items-center justify-center whitespace-nowrap text-success status-div"
                                data-app-id="${student.id}" data-status="${student.status}">
                                <div class="flex items-center justify-center whitespace-nowrap inner-status ${
                                    student.status == 1 ? "text-success" : "text-warning"
                                }" style="cursor: pointer;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="check-square" data-lucide="check-square" class="lucide lucide-check-square w-4 h-4 mr-2">
                                        <polyline points="9 11 12 14 22 4"></polyline>
                                        <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"></path>
                                    </svg>
                                    <span class="status-text">${
                                        student.status == 1 ? "Approved" : "Pending"
                                    }</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="flex items-center">
                                <div class="w-10 h-10 image-fit zoom-in">
                                    <img alt="Clearance" class="rounded-lg border-2 border-white shadow-md tooltip" src="" title="Uploaded at 5 July 1996">
                                </div>
                                <a href="" class="font-medium whitespace-nowrap ml-4"></a> 
                            </div>
                        </td>
                    </tr>`;

                tableBody.append(studentRow);
            });

            // Attach click event to the status div
            $(".status-div").on("click", function () {
                const statusDiv = $(this);
                const appId = statusDiv.data("app-id");
                const currentStatus = statusDiv.data("status");
                const newStatus = currentStatus == 1 ? 0 : 1;

                console.log(appId, newStatus);

                // Make an AJAX request to change the status
                $.ajax({
                    url: "/enroll/change-student-status",
                    type: "POST",
                    data: {
                        appId: appId,
                        new_status: newStatus,
                        _token: _token,
                    },
                    dataType: "json",
                    success: function (response) {
                        // Handle the response, e.g., update the UI or reload data
                        console.log(response);

                        // Update the class and text content in the UI
                        const innerDiv = statusDiv.find(".inner-status");
                        innerDiv
                            .removeClass("text-success text-warning")
                            .addClass(
                                newStatus == 1 ? "text-success" : "text-warning"
                            );
                        innerDiv
                            .find(".status-text")
                            .text(newStatus == 1 ? "Approved" : "Pending");

                        // Update data attributes
                        statusDiv.data("app-id", appId);
                        statusDiv.data("status", newStatus);

                        // If you want to append a status update, you can do something like this:
                        // const statusUpdate = `<div>Status updated to: ${statusText}</div>`;
                        // statusDiv.append(statusUpdate);
                    },
                    error: function (error) {
                        console.error("Error changing status:", error);
                    },
                });
            });

            updatePaginationLinks(data);

            const summaryContainer = $("#pagination-summary");
            summaryContainer.text(data.summary);
        },
    });
}



// Function to update the pagination links and summary message
function updatePaginationLinks(data) {
    const paginationLinks = $(".pagination");
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
        paginationLinks.append(
            '<li class="page-item"><a class="page-link" href="#" data-page="1"><i class="fa fa-angle-double-left w-4 h-4"></i></a></li>'
        );
    }

    // Add "Chevron Left" link
    if (currentPage > 1) {
        paginationLinks.append(
            `<li class="page-item"><a class="page-link" href="#" data-page="${
                currentPage - 1
            }"><i class="fa fa-angle-left w-4 h-4"></i></a></li>`
        );
    }

    // Add ellipsis link for skipped pages
    if (currentPage > 3) {
        paginationLinks.append(
            '<li class="page-item"><a class="page-link" href="#">...</a></li>'
        );
    }

    // Add page links
    for (
        let i = Math.max(1, currentPage - 2);
        i <= Math.min(currentPage + 2, lastPage);
        i++
    ) {
        const activeClass = i === currentPage ? "active" : "";
        paginationLinks.append(
            `<li class="page-item ${activeClass}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`
        );
    }

    // Add ellipsis link for skipped pages
    if (currentPage < lastPage - 2) {
        paginationLinks.append(
            '<li class="page-item"><a class="page-link" href="#">...</a></li>'
        );
    }

    // Add "Chevron Right" link
    if (currentPage < lastPage) {
        paginationLinks.append(
            `<li class="page-item"><a class="page-link" href="#" data-page="${
                currentPage + 1
            }"><i class="fa fa-angle-right w-4 h-4"></i></a></li>`
        );
    }

    // Add "Chevrons Right" link
    if (currentPage < lastPage) {
        paginationLinks.append(
            `<li class="page-item"><a class="page-link" href="#" data-page="${lastPage}"><i class="fa fa-angle-double-right w-4 h-4" ></i></a></li>`
        );
    }

    // Add the summary message
    const summaryContainer = $(".summary");
    summaryContainer.text(summaryMessage);
}

$(document).on("click", ".pagination a", function (event) {
    event.preventDefault();
    const page = $(this).data("page");
    fetchEnrollmentData(page, {
        search: currentSearchKeyword,
        limit: currentFilterSize,
        school_year: schoolYear,
        semester: semester,
        year_level: yearLevel,
        course_program: courseProgram,
        status: _status,
    });
});

// Event handler for "Items per page" select box
$('#filter-size').on('change', function () {
    currentFilterSize = parseInt($(this).val());
    console.log(currentFilterSize);
    const filters = {
        limit: currentFilterSize,
        search: currentSearchKeyword,
        school_year: schoolYear,
        semester: semester,
        year_level: yearLevel,
        course_program: courseProgram,
        status: _status, // Include the status filter
    };
    fetchEnrollmentData(1, filters); // Fetch the first page of data with the applied filters and updated size
});

let typingTimer;
const doneTypingInterval = 1000;

$("#filter-search").on("keyup", function (event) {
    clearTimeout(typingTimer);
    const searchKeyword = $(this).val();
    currentSearchKeyword = searchKeyword;
    if (event.keyCode === 13) {
        fetchFilteredEnrollmentData();
    } else {
        typingTimer = setTimeout(function () {
            fetchFilteredEnrollmentData();
        }, doneTypingInterval);
    }
});

function fetchFilteredEnrollmentData() {
    const searchKeyword = $("#filter-search").val();
    const filters = {
        limit: currentFilterSize,
        search: searchKeyword,
        school_year: schoolYear,
        semester: semester,
        year_level: yearLevel,
        course_program: courseProgram,
        status: _status, // Include the status filter
    };
    console.log(filters);
    fetchEnrollmentData(1, filters);
}

$("#load-button").on("click", function () {
    const searchKeyword = $("#filter-search").val();
    schoolYear = $("#input-filter-6-school-year").val();
    semester = $("#input-filter-6-semester").val();
    yearLevel = $("#input-filter-6-year-level").val();
    courseProgram = $("#input-filter-6-course-program").val();
    _status = $("#input-filter-6-status").val();
    console.log(_status);
    fetchFilteredEnrollmentData();
});

function downloadExcel(
    baseUrl,
    filterYear,
    filterSem,
    filterYearLevel,
    filterProgram,
    filterStatus
) {
    const encodedFilterYear = encodeURIComponent(filterYear);
    const encodedFilterSem = encodeURIComponent(filterSem);
    const encodedFilterYearLevel = encodeURIComponent(filterYearLevel);
    const encodedFilterProgram = encodeURIComponent(filterProgram);
    const encodedFilterStatus = encodeURIComponent(filterStatus);

    const downloadUrl =
        baseUrl +
        "?filter_year=" +
        encodedFilterYear +
        "&filter_sem=" +
        encodedFilterSem +
        "&filter_year_level=" +
        encodedFilterYearLevel +
        "&filter_program=" +
        encodedFilterProgram +
        "&filter_status=" +
        encodedFilterStatus;

    window.open(downloadUrl, "_blank");
}
