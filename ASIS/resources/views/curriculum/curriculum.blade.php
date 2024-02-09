@extends('layouts.app')

@section('content')
    <!-- Tabulator CSS -->
    <link href="https://unpkg.com/tabulator-tables@4.9.3/dist/css/tabulator.min.css" rel="stylesheet">

    <div class="col-span-12 lg:col-span-9 2xl:col-span-10 mt-5">
        <!-- BEGIN: Inbox Filter -->
        <div class="intro-y flex flex-col-reverse sm:flex-row items-center">
            <div class="w-full sm:w-auto relative mr-auto mt-3 sm:mt-0">
                <h2 class="text-lg font-medium mr-auto">
                    Curriculum
                </h2>
            </div>
        </div>
        <!-- END: Inbox Filter -->

    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">

            <div class="flex mt-5 sm:mt-0">
                <button id="clearModalButton" class="btn btn-primary shadow-md mr-2" data-tw-toggle="modal" data-tw-target="#curriculum_modal">Curriculumn</button>

                <div class="dropdown w-1/2 sm:w-auto">
                    <button class="dropdown-toggle btn btn-outline-secondary w-full sm:w-auto" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export <i data-lucide="chevron-down" class="w-4 h-4 ml-auto sm:ml-2"></i> </button>
                    <div class="dropdown-menu w-40">
                        <ul class="dropdown-content">
                            <li>
                                <a id="tabulator-export-csv" href="javascript:;" class="dropdown-item"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export CSV </a>
                            </li>
                            <li>
                                <a id="tabulator-export-json" href="javascript:;" class="dropdown-item"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export JSON </a>
                            </li>
                            <li>
                                <a id="tabulator-export-xlsx" href="javascript:;" class="dropdown-item"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export XLSX </a>
                            </li>
                            <li>
                                <a id="tabulator-export-html" href="javascript:;" class="dropdown-item"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export HTML </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="hidden md:block mx-auto text-slate-500" id="pagination-summary"></div>
            <button class="btn btn-outline-secondary w-1/2 sm:w-auto mr-2"> <i data-lucide="printer" class="w-4 h-4"></i></button>
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                <div class="w-56 relative text-slate-500">
                    <input type="text" class="form-control w-56 box pr-10" id="filter-search" placeholder="Search...">
                    <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                </div>
            </div>

        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2" id="enrollment-list-table">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">#</th>
                        <th class="whitespace-nowrap">Program Code</th>
                        <th class="whitespace-nowrap">Effective Year</th>
                        <th class="whitespace-nowrap">Status</th>
                        <th class="whitespace-nowrap">Author</th>
                        <th class="whitespace-nowrap">Action</th>
                    </tr>
                </thead>
                <tbody >

                </tbody>
            </table>
        </div>
        <!-- END: Data List -->
        <!-- BEGIN: Pagination -->
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
            <nav class="w-full sm:w-auto sm:mr-auto">
                <ul class="pagination">
                    <!-- Pagination links will be added here dynamically -->
                </ul>
            </nav>
            <select id="filter-size" class="w-20 form-select box mt-3 sm:mt-0">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="35">35</option>
                <option value="50">50</option>
                <option value="999999">All</option>
            </select>
        </div>
        <!-- END: Pagination -->
    </div>

        </div>
    </div>

@include('curriculum.modals.curriculumn_modal')
<!-- Tabulator JS -->
<script type="text/javascript" src="https://unpkg.com/tabulator-tables@4.9.3/dist/js/tabulator.min.js"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script src="{{BASEPATH()}}/js/curriculum/curriculum.js{{GET_RES_TIMESTAMP()}}"></script>
<script>
var _token = $('meta[name="csrf-token"]').attr('content');

$(document).ready(function () {
    fetchCurriculumData(); // Fetch and populate the curriculum data in the table using AJAX
});

// Function to fetch curriculum data from the server using AJAX
function fetchCurriculumData(page, filters) {
    $.ajax({
        url: 'curriculum/curriculum-list-load?page=' + page,
        type: 'GET',
        data: filters,
        dataType: 'json',
        success: function (data) {
            // console.log(data);
            // Update the table with the received data
            const tableBody = $('#enrollment-list-table tbody');
            tableBody.empty(); // Clear the table body first
            let count = 1;
            data.data.forEach(function (curriculum) {
                // Create the HTML structure for each curriculum row
                const curriculumRow = `
                    <tr class="intro-x">
                        <td>${count++}</td>
                        <td>${curriculum.name}</td>
                        <td>${curriculum.sy}</td>
                        <td>${curriculum.status}</td>
                        <td>${curriculum.created_by}</td>
                        <td>
                            <button onclick="updateCurriculum(this)" data-curriculum-id="${curriculum.id}" class="border-primary border-2 text-primary bg-white hover:bg-blue-600 text-blue-500 w-8 h-8 rounded-full flex items-center justify-center zoom-in" data-tw-toggle="modal" data-tw-target="#curriculum_modal">
                                <i class="fa fa-edit w-3 h-3"></i>
                            </button>
                        </td>
                    </tr>`;
                tableBody.append(curriculumRow); // Append curriculum row to the table
            });

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
    fetchCurriculumData(page);
});

// Event handler for "Items per page" select box
$('#filter-size').on('change', function () {
    currentFilterSize = parseInt($(this).val());
    // console.log("", currentFilterSize);
    const filters = {
        limit: currentFilterSize
    };
    fetchCurriculumData(1, filters); // Fetch the first page of data with the applied filters and updated size
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

    fetchCurriculumData(1, filters);
}
</script>
@endsection
