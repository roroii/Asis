@extends('layouts.app')

@section('content')
    <!-- Tabulator CSS -->
    <link href="https://unpkg.com/tabulator-tables@4.9.3/dist/css/tabulator.min.css" rel="stylesheet">

    <div class="col-span-12 lg:col-span-9 2xl:col-span-10 mt-5">
        <!-- BEGIN: Inbox Filter -->
        <div class="intro-y flex flex-col-reverse sm:flex-row items-center">
            <div class="w-full sm:w-auto relative mr-auto mt-3 sm:mt-0">
                <h2 class="text-lg font-medium mr-auto">
                    My Curriculum
                </h2>
            </div>
        </div>
        <!-- END: Inbox Filter -->

        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">

                <div class="w-full xl:w-auto flex items-center mt-3 xl:mt-0">
                <select id="filter-sy" name="sy" class="form-select box mr-2 btn shadow-md w-48">
                    <option value="">School Year</option>
                    @foreach($get_year as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                </select>
                <select id="filter-major" name="major" class="form-select box mr-2 shadow-md w-48">
                    <option value="">Major</option>
                     @foreach($get_major as $major)
                                <option value="{{ $major }}">{{ $major }}</option>
                            @endforeach
                </select>


            </div>

                <div class="hidden md:block mx-auto text-slate-500" id="pagination-summary"></div>
                <a target="_blank" href="/curriculum/print/curriculum/vw" class="btn btn-outline-secondary w-1/2 sm:w-auto mr-2" > <i data-lucide="printer" class="w-4 h-4"></i> </a>
            </div>

        </div>
        <div id="curriculum-container">
             @if ($curriculum)
                @forelse ($curriculum->schoolYears as $year => $yearData)
                    <!-- BEGIN: Transcript of Records -->
                    <div class="intro-y box p-5 mt-5 year-container">
                        <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                            <div class="font-medium text-base flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5">
                                <i data-lucide="chevron-down" class="w-4 h-4 mr-2"></i>
                                <div id="curriculum_year_name_div">
                                    {{ $yearData->name }}
                                </div>
                            </div>

                            <div class="mt-5">
                                <div class="mt-5" id="semester-container">
                                    @foreach ($yearData->semesters as $semester)
                                        <div class="pt-5 sem-container" data-semester-div-id="{{ $semester->semesterDivId }}" id="{{ $semester->semesterDivId }}">
                                            <div class="form-label xl:w-64 xl:!mr-10">
                                                <div class="text-left">
                                                    <div class="flex items-center">
                                                        <div class="font-">
                                                            {{ $semester->name }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="w-full mt-3 xl:mt-0 flex-1 bg-slate-50 dark:bg-transparent dark:border rounded-md">
                                                <div class="overflow-x-auto">
                                                    <table class="table border">
                                                        <thead>
                                                            <tr>
                                                                <th class="bg-slate-50 dark:bg-darkmode-800">Grade</th>
                                                                <th class="bg-slate-50 dark:bg-darkmode-800">Course No.</th>
                                                                <th class="bg-slate-50 dark:bg-darkmode-800">Descriptive Title</th>
                                                                <th class="bg-slate-50 dark:bg-darkmode-800">Credits</th>
                                                                <th class="bg-slate-50 dark:bg-darkmode-800">Lecture</th>
                                                                <th class="bg-slate-50 dark:bg-darkmode-800">Laboratory</th>
                                                                <th class="bg-slate-50 dark:bg-darkmode-800">Pre-Requisite</th>
                                                                <th class="bg-slate-50 dark:bg-darkmode-800">Remarks</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($semester->subjects as $record)
                                                                <tr>
                                                                    <td class="!pr-2 {{ $record->grade !== null ? 'text-primary' : 'text-secondary' }}"><strong>{{ $record->grade ?? 'N/A' }}</strong></td>
                                                                    <td class="whitespace-nowrap">{{ $record->subject_code }}</td>
                                                                    <td class="!px-2">{{ $record->subject_description }}</td>
                                                                    <td class="!px-2">{{ $record->subject_credits }}</td>
                                                                    <td class="!px-2">{{ $record->subject_lec }}</td>
                                                                    <td class="!px-2">{{ $record->subject_lab }}</td>
                                                                    <td class="!px-2 pre-requisite_td">{{ $record->subject_prereq }}</td>
                                                                    <td class="!px-2">{{ $record->remarks }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mb-2 mt-2 pt-2 first:mt-0 first:pt-0 w-full"></div>
                            </div>
                        </div>
                    </div>
                    <!-- END: Transcript of Records -->
                @empty
                    <!-- Handle case where $curriculum->schoolYears is empty -->
                @endforelse
            @else
                <!-- Handle case where $curriculum is not set -->
            @endif

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            // Function to fetch and load curriculum based on selected filters
            function loadCurriculum() {
                var selectedYear = $('#filter-sy').val();
                var selectedMajor = $('#filter-major').val();

                // Make an AJAX request to fetch the dynamic content
                $.ajax({
                    url: '/curriculum/load/fetch/data', // Replace with your actual endpoint
                    method: 'GET',
                    data: {
                        year: selectedYear,
                        major: selectedMajor,
                    },
                    success: function (data) {
                        console.log(data);
                        if (data.curriculum) {
                            // Before making the AJAX request
                            $('#curriculum-container').html('<p>Loading curriculum data...</p>');

                            // After successfully fetching the data
                            $('#curriculum-container').html(appendData(data));
                        } else {
                            // Handle case where no curriculum data is found
                            $('#curriculum-container').html('<p>No curriculum data found.</p>');
                        }
                    },
                    error: function (error) {
                        console.error('Error fetching curriculum:', error);
                    },
                });
            }

            // Event listener for changes in the dropdowns
            $('#filter-sy, #filter-major').on('change', function () {
                loadCurriculum();
            });

            // Function to append curriculum data to the HTML
            function appendData(data) {
                var curriculum = '';

                if (data.curriculum) {
                    data.curriculum.school_years.forEach(function (yearData, year) {
                        // Build HTML for each year
                        curriculum += `
                            <div class="intro-y box p-5 mt-5 year-container">
                                <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                                    <div class="font-medium text-base flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5">
                                        <i data-lucide="chevron-down" class="w-4 h-4 mr-2"></i>
                                        <div id="curriculum_year_name_div">
                                            ${yearData.name}
                                        </div>
                                    </div>

                                    <div class="mt-5">
                                        <div class="mt-5" id="semester-container">`;

                        // Iterate through semesters
                        yearData.semesters.forEach(function (semester) {
                            curriculum += `
                                <div class="pt-5 sem-container" data-semester-div-id="${semester.semesterDivId}" id="${semester.semesterDivId}">
                                    <div class="form-label xl:w-64 xl:!mr-10">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-">
                                                    ${semester.name}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-full mt-3 xl:mt-0 flex-1 bg-slate-50 dark:bg-transparent dark:border rounded-md">
                                        <div class="overflow-x-auto">
                                            <table class="table border">
                                                <thead>
                                                    <tr>
                                                        <th class="bg-slate-50 dark:bg-darkmode-800">Grade</th>
                                                        <th class="bg-slate-50 dark:bg-darkmode-800">Course No.</th>
                                                        <th class="bg-slate-50 dark:bg-darkmode-800">Descriptive Title</th>
                                                        <th class="bg-slate-50 dark:bg-darkmode-800">Credits</th>
                                                        <th class="bg-slate-50 dark:bg-darkmode-800">Lecture</th>
                                                        <th class="bg-slate-50 dark:bg-darkmode-800">Laboratory</th>
                                                        <th class="bg-slate-50 dark:bg-darkmode-800">Pre-Requisite</th>
                                                        <th class="bg-slate-50 dark:bg-darkmode-800">Remarks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>`;

                            // Iterate through subjects
                            semester.subjects.forEach(function (record) {
                                curriculum += `
                                    <tr>
                                        <td class="!pr-2 ${record.grade !== null ? 'text-primary' : 'text-secondary'}"><strong>${record.grade ?? 'N/A'}</strong></td>
                                        <td class="whitespace-nowrap">${record.subject_code}</td>
                                        <td class="!px-2">${record.subject_description}</td>
                                        <td class="!px-2">${record.subject_credits}</td>
                                        <td class="!px-2">${record.subject_lec}</td>
                                        <td class="!px-2">${record.subject_lab}</td>
                                        <td class="!px-2 pre-requisite_td">${record.subject_prereq}</td>
                                        <td class="!px-2">${record.remarks}</td>
                                    </tr>`;
                            });

                            curriculum += `
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>`;
                        });

                        curriculum += `
                                        </div>
                                        <div class="mb-2 mt-2 pt-2 first:mt-0 first:pt-0 w-full"></div>
                                    </div>
                                </div>
                            </div>`;
                    });
                } else {
                    curriculum = '<p>No curriculum data found.</p>';
                }

                return curriculum;
            }

        });
    </script>
@endsection
