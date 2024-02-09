@extends('layouts.app')

@section('content')

    <div class="col-span-12 lg:col-span-9 2xl:col-span-10 mt-5">
        <!-- BEGIN: Inbox Filter -->
        <div class="intro-y flex flex-col-reverse sm:flex-row items-center">
            <div class="w-full sm:w-auto relative mr-auto mt-3 sm:mt-0">
                <i class="w-4 h-4 absolute my-auto inset-y-0 ml-3 left-0 z-10 text-slate-500" data-lucide="search"></i>
                <input id="search-input" type="text" class="form-control w-full sm:w-64 box px-10" placeholder="Search...">
            </div>

            <div class="dropdown inline-block ml-auto" data-tw-placement="bottom">
                <a href="javascript:;" class="dropdown-toggle flex items-center ml-auto text-primary" aria-expanded="false" data-tw-toggle="dropdown" id="programmatically-dropdown"> <i data-lucide="search" class="w-4 h-4 mr-2 fa-beat"></i>Select SY/SEM </a>
                <div class="inbox-filter__dropdown-menu dropdown-menu pt-2">
                    <div class="dropdown-content">
                        <div class="grid grid-cols-12 gap-4 gap-y-3 p-3">
                            <div class="col-span-6">
                                <label for="filter-year" class="form-label text-xs">Year</label>
                                 <select  name="filter-year" id="filter-year" class="btn shadow-md form-control flex-1">
                                    <option value="">All</option>
                                    @forelse (load_esms_year(auth()->user()->studid) as $i => $sy)
                                        <option value="{{ $sy }}">{{ $sy }}</option>
                                    @empty

                                    @endforelse
                                </select>
                            </div>
                            <div class="col-span-6">
                                <label for="filter-sem" class="form-label text-xs">Sem</label>
                                <select  name="filter-sem" id="filter-sem" class="btn shadow-md form-control flex-1">
                                    <option value="">All</option>
                                    @forelse (load_esms_sem(auth()->user()->studid) as $i => $sem)
                                        <option value="{{ $sem }}">{{ $sem }}</option>
                                    @empty

                                    @endforelse
                                </select>
                            </div>
                            <div class="col-span-6">
                                <label for="filter-subject-code" class="form-label text-xs">Subject Code</label>
                                <input id="filter-subject-code" type="text" class="form-control flex-1" placeholder="Subject Code">
                            </div>
                            <div class="col-span-6">
                                <label for="filter-has" class="form-label text-xs">Has the</label>
                                <input id="filter-has" type="text" class="form-control flex-1" placeholder="Has the">
                            </div>
                            <div class="col-span-6">
                                <label for="filter-doesnt-have" class="form-label text-xs">Doesn't Have</label>
                                <input id="filter-doesnt-have" type="text" class="form-control flex-1" placeholder="Doesn't Have">
                            </div>
                            <div class="col-span-6">
                                <label for="filter-min-grade" class="form-label text-xs">Min Grade</label>
                                <input id="filter-min-grade" type="number" class="form-control flex-1" placeholder="Min Grade">
                            </div>
                            <div class="col-span-6">
                                <label for="filter-max-grade" class="form-label text-xs">Max Grade</label>
                                <input id="filter-max-grade" type="number" class="form-control flex-1" placeholder="Max Grade">
                            </div>
                            <div class="col-span-6">
                                <label for="filter-size" class="form-label text-xs">Size</label>
                                <select id="filter-size" class="form-select flex-1">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="35">35</option>
                                    <option value="50">50</option>
                                    <option value="All">All</option>
                                </select>
                            </div>
                            <div class="col-span-6 flex items-center mt-3">
                                <button class="btn btn-primary w-32 ml-2" id="filter-search-button">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full sm:w-auto flex">
                {{-- <button class="btn btn-primary shadow-md mr-2">Start a Video Call</button> --}}
                <div style="display: none" class="dropdown">
                    <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                        <span class="w-5 h-5 flex items-center justify-center">
                            <i class="w-4 h-4" data-lucide="plus"></i>
                        </span>
                    </button>
                    <div class="dropdown-menu w-40">
                        <ul class="dropdown-content">
                            <li>
                                <a href="" class="dropdown-item">
                                    <i data-lucide="settings" class="w-4 h-4 mr-2"></i>
                                    Settings
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Inbox Filter -->

        <!-- BEGIN: Inbox Content -->
        <div class="intro-y inbox box mt-5">
            <div class="p-5 flex flex-col-reverse sm:flex-row text-slate-500 border-b border-slate-200/60">
                <div class="flex items-center mt-3 sm:mt-0 border-t sm:border-0 border-slate-200/60 pt-5 sm:pt-0 mt-5 sm:mt-0 -mx-5 sm:mx-0 px-5 sm:px-0">

                    <a href="javascript:location.reload();" class="w-5 h-5 ml-5 flex items-center justify-center">
                        <i class="w-4 h-4" data-lucide="refresh-cw"></i>
                    </a>
                    <a style="display: none" href="javascript:;" class="w-5 h-5 ml-5 flex items-center justify-center">
                        <i class="w-4 h-4" data-lucide="more-horizontal"></i>
                    </a>
                </div>
                <div class="flex items-center sm:ml-auto">
                    <div class="summary">Loading...</div>
                    <button class="previous-page w-5 h-5 ml-5 flex items-center justify-center">
                        <i class="w-4 h-4" data-lucide="chevron-left"></i>
                    </button>
                    <button class="next-page w-5 h-5 ml-5 flex items-center justify-center">
                        <i class="w-4 h-4" data-lucide="chevron-right"></i>
                    </button>
                </div>
            </div>
            <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                <table class="table table-report -mt-2">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">Code</th>
                            <th class="whitespace-nowrap">Year</th>
                            <th class="whitespace-nowrap">Sem</th>
                            {{-- <th class=" whitespace-nowrap">Mid-Term</th>
                            <th class=" whitespace-nowrap">Final Term</th> --}}
                            <th class=" whitespace-nowrap">Grade</th>
                        </tr>
                    </thead>
                    <tbody id="data-container">

                    </tbody>
                </table>
            </div>
            <div class="overflow-x-auto sm:overflow-x-visible">
                {{-- <div class="intro-y">
                    <div class="inbox__item--time inline-block sm:block text-slate-600 dark:text-slate-500 bg-slate-100 dark:bg-darkmode-400/70 border-b border-slate-200/60 dark:border-darkmode-400">
                        <div class="flex px-5 py-3">
                            <div class="w-24 flex-none flex items-center mr-5">
                                <div class="inbox__item--sender truncate ml-3 bold"><strong>Subject Code</strong></div>
                            </div>
                            <div class="inbox__item--time whitespace-nowrap ml-auto pl-10"><strong>Sem</strong></div>
                            <div class="inbox__item--time whitespace-nowrap ml-auto pl-10"><strong>Year</strong></div>
                            <div class="inbox__item--time whitespace-nowrap ml-auto pl-10"><strong>Mid-Term</strong></div>
                            <div class="inbox__item--time whitespace-nowrap ml-auto pl-10"><strong>Final Term</strong></div>
                            <div class="inbox__item--time whitespace-nowrap ml-auto pl-10"><strong>Final Grade</strong></div>
                            <div class="inbox__item--time whitespace-nowrap ml-auto pl-10"><strong>Remarks</strong></div>

                        </div>
                    </div>
                </div> --}}

                {{-- <div id="data-container" class="intro-y">
                    <!-- AJAX will populate this container with the paginated student data -->

                </div> --}}
            </div>
            <div class="p-5 flex flex-col sm:flex-row items-center text-center sm:text-left text-slate-500">
                <div>

                </div>
                <div class="sm:ml-auto mt-2 sm:mt-0">
                     <!-- Add the pagination links container -->

                    <ul style="display: none" class="pagination">
                        <!-- Pagination links will be added here dynamically -->

                    </ul>
                </div>
            </div>
        </div>
        <!-- END: Inbox Content -->
    </div>
</div>

@endsection
@section('scripts')
<script>
    let currentFilterSize = 10; // Set the default filter size here
    let currentPage = 1; // Track the current page number
    let currentFilters = {}; // Track the current filter values

    // Function to fetch paginated and filtered data from the server using AJAX
    function fetchPaginatedData(page, filters) {
        // If filters are not provided, use the currentFilters
        filters = filters || currentFilters;
        filters.per_page = filters.per_page || currentFilterSize; // Set default value for 'per_page'

        $.ajax({
            url: 'my-portal/load-student-data?page=' + page,
            type: 'GET',
            data: filters,
            dataType: 'json',
            success: function (data) {
                // Store the received data in the 'studentData' variable
                const studentData = data.data;
                // console.log(studentData);

                // Update the data container with the new data
                const dataContainer = $('#data-container');
                dataContainer.empty(); // Clear the container first

                studentData.forEach(function (student) {
                    // Determine the text color based on the status
                    let textColor = '';
                    let gradeText = student.grade; // Default grade text

                    if (student.remarks === 'Passed') {
                        textColor = 'text-primary';
                    } else if (student.remarks === 'Dropped' || student.remarks === 'Failed') {
                        textColor = 'text-danger';
                    } else if (student.remarks === 'Incomplete') {
                        textColor = 'text-pending';
                        // Check if there's a complied grade, and add it with a "/" separator
                        if (student.gcompl) {
                            gradeText = student.grade + ' <strong class="text-primary"> / </strong> <strong class="text-primary">' + student.gcompl + '</strong>';
                        }
                    }

                    // Determine the text color for remarks based on the status
                    let remarksTextColor = '';
                    if (student.remarks === 'Passed') {
                        remarksTextColor = 'text-primary';
                    } else if (student.remarks === 'Dropped' || student.remarks === 'Failed') {
                        remarksTextColor = 'text-danger';
                    } else if (student.remarks === 'Incomplete') {
                        remarksTextColor = 'text-pending';
                    }

                    // Create the HTML structure for each student item
                    const studentRow = `
                        <tr class="inbox__item intro-x bg-white hover:bg-gray-100 transition duration-150 ease-in-out">
                            <td class="inbox__item--time py-3 px-4 whitespace-nowrap">
                                <strong class="text-gray-800">${student.subjcode}</strong>
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap">
                                ${student.sy}
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap">
                                ${student.sem}
                            </td>
                            <td class="${remarksTextColor} py-3 px-4 whitespace-nowrap">
                                <strong>${gradeText || 'No data'}</strong>
                            </td>
                        </tr>
                    `;
                    dataContainer.append(studentRow); // Append student item to the container
                });

                // Update the summary of data
                $('.summary').text(data.summary);

                // Enable or disable previous page and next page buttons based on current page number
                const previousPageButton = $('.previous-page');
                const nextPageButton = $('.next-page');
                if (data.current_page === 1) {
                    previousPageButton.prop('disabled', true);
                } else {
                    previousPageButton.prop('disabled', false);
                }

                if (data.current_page === data.last_page) {
                    nextPageButton.prop('disabled', true);
                } else {
                    nextPageButton.prop('disabled', false);
                }

                // Update the pagination links
                const paginationLinks = $('.pagination');
                paginationLinks.empty(); // Clear the pagination links container

                for (let i = 1; i <= data.last_page; i++) {
                    const activeClass = i === data.current_page ? 'active' : '';
                    const pageLink = `<li class="page-item ${activeClass}"><a class="page-link" href="#">${i}</a></li>`;
                    paginationLinks.append(pageLink);
                }

                // Update the currentPage and currentFilters variables
                currentPage = data.current_page;
                currentFilters = filters;
            }
        });
    }

    // Initial data loading when the page loads
    $(document).ready(function () {
        fetchPaginatedData(1, {}); // Fetch the first page of data without any filters
    });

    // Event handler for pagination links
    $(document).on('click', '.pagination a', function (event) {
        event.preventDefault();
        const page = $(this).attr('href').split('page=')[1];
        fetchPaginatedData(page);
    });

    // Event handler for previous page button
    $(document).on('click', '.previous-page', function () {
        if (currentPage > 1) {
            const prevPage = currentPage - 1;
            fetchPaginatedData(prevPage);
        }
    });

    // Event handler for next page button
    $(document).on('click', '.next-page', function () {
        const lastPage = parseInt($('.pagination li:last-child .page-link').text());
        if (currentPage < lastPage) {
            const nextPage = currentPage + 1;
            fetchPaginatedData(nextPage);
        }
    });

    // Update the currentFilterSize and fetch data when the filter size is changed
    $('#filter-size').on('change', function () {
        currentFilterSize = parseInt($(this).val());
        fetchPaginatedData(1, currentFilters);
    });

    // Function to prepare the filters object
    function prepareFilters() {
        return {
            year: $('#filter-year').val(),
            sem: $('#filter-sem').val(),
            subject_code: $('#filter-subject-code').val(),
            has: $('#filter-has').val(),
            doesnt_have: $('#filter-doesnt-have').val(),
            size: $('#filter-size').val(),
            searchinput: $('#search-input').val(),
            minGrade: $('#filter-min-grade').val(),
            maxGrade: $('#filter-max-grade').val()
        };
    }

    // Event handler for filter search button
    $(document).on('click', '#filter-search-button', function () {
        const filters = prepareFilters();
        const el = document.querySelector("#filter-search-button");
        const dropdown = tailwind.Dropdown.getOrCreateInstance(el); dropdown.hide();
        fetchPaginatedData(1, filters); // Fetch the first page of data with the applied filters

    });

    // Bind the Enter key press event to the search input field
    $('#search-input').on('keydown', function (event) {
        if (event.keyCode === 13) {
            // Prevent the default Enter key behavior (e.g., form submission)
            event.preventDefault();
            // Perform the filter search when Enter key is pressed
            const filters = prepareFilters();
            fetchPaginatedData(1, filters);
        }
    });
</script>
@endsection
