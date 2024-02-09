@extends('layouts.app')

@section('content')

<h2 class="intro-y text-lg font-medium mt-10">
    {{ $pageTitle }}
</h2>
<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
        <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
            <div class="w-56 relative text-slate-500">
                <select id="filter-dropdown" class="form-select w-56 box pr-10">
                    <option value="">All</option>
                    <option value="ongoing" {{ request()->get('filter') === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                    <option value="ended" {{ request()->get('filter') === 'ended' ? 'selected' : '' }}>Ended</option>
                </select>
                <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="filter"></i>
            </div>
        </div>
        <div id="page-entry-count" class="hidden md:block mx-auto text-slate-500">Showing 1 to {{ min(intval($data->count()), intval($data->perPage())) }} of {{ intval($data->total()) }} sessions</div>
        <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
            <div class="w-56 relative text-slate-500">
                <input id="search-input" type="text" class="form-control w-56 box pr-10" placeholder="Search..." value="{{ request()->input('search') }}">
                <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
            </div>
        </div>

    </div>
    <!-- Display your data -->
    <div id="data-container" class="grid grid-cols-12 gap-6 col-span-12 md:col-span-12 lg:col-span-12 mt-5">
        <!-- Data will be appended here -->
    </div>

    <!-- Pagination -->
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center mt-4">
        <nav class="w-full sm:w-auto sm:mr-auto">
            <ul id="pagination" class="pagination">
                <!-- Pagination links will be appended here -->
            </ul>
        </nav>
        <select id="page-limit" class="w-20 form-select box mt-3 sm:mt-0">
            <option value="8" {{ request()->get('limit') == 8 ? 'selected' : '' }}>8</option>
            <option value="10" {{ request()->get('limit') == 10 ? 'selected' : '' }}>10</option>
            <option value="25" {{ request()->get('limit') == 25 ? 'selected' : '' }}>25</option>
            <option value="35" {{ request()->get('limit') == 35 ? 'selected' : '' }}>35</option>
            <option value="50" {{ request()->get('limit') == 50 ? 'selected' : '' }}>50</option>
        </select>
    </div>
</div>

@endsection

@section('scripts')

    <script>
        // Fetch the data from the controller and assign it to a JavaScript variable
        var data = @json($data);

        // Function to render the data
        function renderData() {
            var content = '';
            data.data.forEach(function (item) {
                // Generate the HTML content for each item
                content += '<div class="intro-y col-span-12 md:col-span-6 lg:col-span-4 xl:col-span-3 zoom-in">';
                content += '<div class="box">';
                content += '<div class="p-5">';
                content += '<div class="h-40 2xl:h-56 image-fit rounded-md overflow-hidden before:block before:absolute before:w-full before:h-full before:top-0 before:left-0 before:z-10 before:bg-gradient-to-t before:from-black before:to-black/10">';
                content += '<img alt="profile-picture" class="rounded-md profile-picture" data-action="zoom" src="' + item.profile_pic + '">'; // Empty src attribute
                content += '<span class="absolute top-0 ' + (item.ended_at_diff ? 'bg-pending/80' : 'bg-primary/80') + ' text-white text-xs m-5 px-2 py-1 rounded z-10">' + (item.ended_at_diff ? 'Ended' : 'Ongoing') + '</span>';
                content += '<div class="absolute bottom-0 text-white px-5 pb-6 z-10"> <a href="" class="block font-medium text-base">' + ((item.semsubject_details && item.semsubject_details.section) ? item.semsubject_details.section : 'None') + '</a> <span class="text-white/90 text-xs mt-3">' + item.profile_name + '</span> </div>';
                content += '</div>';
                content += '<div class="text-slate-600 dark:text-slate-500 mt-5">';
                content += '<div class="flex items-center"> <i class="fa-regular fa-bookmark w-4 h-4 mr-1"></i> Subject code: ' + (item.semsubject_details && item.semsubject_details.subjcode ? item.semsubject_details.subjcode : 'N/A') + ' </div>';
                content += '<div class="flex items-center mt-2"> <i class="fa-regular fa-building w-4 h-4 mr-2"></i> Department: ' + (item.semsubject_details && item.semsubject_details.forcoll ? item.semsubject_details.forcoll : 'N/A') + ' </div>';
                if (item.ended_at_diff) {
                    content += '<div class="flex items-center mt-2 text-danger"><i class="fa-regular fa-square-check w-4 h-4 mr-2"></i> Ended: ' + item.ended_at_diff + ' </div>';
                } else {
                    content += '<div class="flex items-center mt-2 text-primary"><i class="fa-regular fa-square-check w-4 h-4 mr-2"></i> Started: ' + item.started_at_diff + ' </div>';
                }
                content += '</div>';
                content += '</div>';
                content += '<div class="flex justify-center lg:justify-end items-center p-5 border-t border-slate-200/60 dark:border-darkmode-400">';
                content += '<a class="flex items-center text-primary mr-auto" target="blank" href="' + item.meeting_link + '"> <i class="fas fa-link w-4 h-4 mr-2"></i> <span class="text">' + item.meeting_link + '</span> </a>';
                content += '<a class="flex items-center mr-3 text-success" href="javascript:;"> <i class="fa-regular fa-pen-to-square w-4 h-4 mr-1"></i> Edit </a>';
                content += '<a class="flex items-center text-danger" href="javascript:;" data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal"> <i class="fa-regular fa-circle-stop w-4 h-4 mr-1"></i> End </a>';
                content += '</div>';
                content += '</div>';
                content += '</div>';

                // Call the function to update the profile picture for this item
                // updateProfilePicture(item.created_by);
            });

            // Append the content to the data-container element
            var container = document.getElementById('data-container');
            container.innerHTML = content;
        }

        // Function to render the pagination
        function renderPagination() {
            var pagination = document.querySelector('#pagination');
            var pageLinks = '';

            // First Page Button
            pageLinks += '<li class="page-item' + (data.current_page === 1 ? ' disabled' : '') + '">';
            pageLinks += '<a class="page-link" href="#" onclick="handlePageNavigation(1)">';
            pageLinks += '<i class="fas fa-angle-double-left w-4 h-4"></i>';
            pageLinks += '</a>';
            pageLinks += '</li>';

            // Previous Page Button
            pageLinks += '<li class="page-item' + (data.current_page === 1 ? ' disabled' : '') + '">';
            pageLinks += '<a class="page-link" href="#" onclick="handlePageNavigation(' + (data.current_page - 1) + ')">';
            pageLinks += '<i class="fas fa-angle-left w-4 h-4"></i>';
            pageLinks += '</a>';
            pageLinks += '</li>';

            // Page Buttons
            for (var i = data.current_page - 2; i <= data.current_page + 2; i++) {
                if (i >= 1 && i <= data.last_page) {
                    pageLinks += '<li class="page-item' + (i === data.current_page ? ' active' : '') + '">';
                    pageLinks += '<a class="page-link" href="#" onclick="handlePageNavigation(' + i + ')">' + i + '</a>';
                    pageLinks += '</li>';
                }
            }

            // Next Page Button
            pageLinks += '<li class="page-item' + (data.current_page === data.last_page ? ' disabled' : '') + '">';
            pageLinks += '<a class="page-link" href="#" onclick="handlePageNavigation(' + (data.current_page + 1) + ')">';
            pageLinks += '<i class="fas fa-angle-right w-4 h-4"></i>';
            pageLinks += '</a>';
            pageLinks += '</li>';

            // Last Page Button
            pageLinks += '<li class="page-item' + (data.current_page === data.last_page ? ' disabled' : '') + '">';
            pageLinks += '<a class="page-link" href="#" onclick="handlePageNavigation(' + data.last_page + ')">';
            pageLinks += '<i class="fas fa-angle-double-right w-4 h-4"></i>';
            pageLinks += '</a>';
            pageLinks += '</li>';

            pagination.innerHTML = pageLinks;
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Call the renderData and renderPagination functions here
            renderData();
            renderPagination();
        });
    </script>
    <script src="{{ asset('/js/faculty_monitoring/monitoring.js') }}"></script>
@endsection
