@extends('layouts.app')

@section('content')

<style>


.chart-container {
    position: relative;
}

.report-pie-chart {
    width: 200px;
    height: 200px;
    cursor: pointer;
    transition: transform 0.3s;
}

.enlarged {
    transform: scale(2); /* Change the scale factor as needed */
}

</style>

  <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12 2xl:col-span-9">
                        <div class="grid grid-cols-12 gap-6">
                            <!-- BEGIN: General Report -->
                            <div class="col-span-12 mt-8">
                                <div class="intro-y flex items-center h-10">
                                    <h2 class="text-lg font-medium truncate mr-5">
                                        Online Request Dashboard
                                    </h2>

                                </div>
                                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-lucide="user" class="report-box__icon text-primary"></i>
                                    <div class="ml-auto">
                                        <div data-theme="light" class="report-box__indicator bg-primary tooltip cursor-pointer"  title="List of Request">View<i data-lucide="chevron-up" class="w-4 h-4 ml-0.5"></i> </div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">{{ $student_requested_count }}</div>
                                <div class="text-base text-slate-500 mt-1">List of Request(Count)</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-lucide="gauge" class="report-box__icon text-warning"></i>
                                    <div class="ml-auto">
                                        <div data-theme="light" class="report-box__indicator bg-warning tooltip cursor-pointer" title="Pending">View<i data-lucide="chevron-down" class="w-4 h-4 ml-0.5"></i> </div>
                                    </div>
                                </div>
                                <div data-theme="light" class="text-3xl font-medium leading-8 mt-6">{{ $pending_student_request }}</div>
                                <div class="text-base text-slate-500 mt-1">Pending</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-lucide="user-check" class="report-box__icon text-success"></i>
                                    <div class="ml-auto">
                                        <div data-theme="light" class="report-box__indicator bg-success tooltip cursor-pointer" title="Approved">View<i data-lucide="chevron-up" class="w-4 h-4 ml-0.5"></i> </div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">{{ $approved_student_request }}</div>
                                <div class="text-base text-slate-500 mt-1">Approved</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-lucide="slash" class="report-box__icon text-danger"></i>
                                    <div class="ml-auto">
                                        <div data-theme="light" class="report-box__indicator bg-danger tooltip cursor-pointer" title="Disapproved">View<i data-lucide="chevron-up" class="w-4 h-4 ml-0.5"></i> </div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">{{ $disapproved_student_request }}</div>
                                <div class="text-base text-slate-500 mt-1">Disapproved</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<!-- BEGIN: Weekly Top Products -->
        <div class="col-span-12 mt-6">
            <div class="box p-10">
            <div class="intro-y block sm:flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">
                  Requested List
                </h2>

            <div class="w-full sm:w-auto relative mr-auto mt-3 sm:mt-0">
                    <i class="w-4 h-4 absolute my-auto inset-y-0 ml-3 left-0 z-10 text-slate-500" data-lucide="search"></i>
                    <input type="text" class="form-control w-full sm:w-64 box px-10" placeholder="Search/Generate Request">
                    <div class="inbox-filter dropdown absolute inset-y-0 mr-3 right-0 flex items-center" data-tw-placement="bottom-start">
                        <i class="dropdown-toggle w-4 h-4 cursor-pointer text-slate-500" role="button" aria-expanded="false" data-tw-toggle="dropdown" data-lucide="chevron-down"></i>
                        <div class="inbox-filter__dropdown-menu dropdown-menu pt-2">
                            <div class="dropdown-content">
                                <div class="grid grid-cols-12 gap-4 gap-y-3 p-3">
                                    <div class="col-span-6">
                                        <label for="input-filter-1" class="form-label text-xs">From</label>
                                        <input id="date_from_req" name="date_from_req" type="date" class="form-control flex-1">
                                    </div>
                                    <div class="col-span-6">
                                        <label for="input-filter-2" class="form-label text-xs">To</label>
                                        <input id="date_to_req" name="date_to_req" type="date" class="form-control flex-1">
                                    </div>
                                    <div class="col-span-6">
                                        <label for="input-filter-4" class="form-label text-xs">Program</label>
                                        <select id="programCourse" name="programCourse" class="form-control" data-placeholder="Select program">

                                            @forelse($get_StudentCourse as $course)

                                            <option value="{{$course->studmajor}}">{{$course->

                                            studmajor}}</option>

                                            @empty

                                            <p>No Data Available</p>

                                            @endforelse

                                        </select>
                                    </div>
                                    <div class="col-span-12 flex items-center mt-3">

                                        <button class="btn btn-primary w-32 ml-auto" id="program_Course_btn">Search<span class="ml-2"><i data-lucide="search" class="w-5 h-5"></i></span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                        <div class="flex items-center sm:ml-auto mt-3 sm:mt-0">
                            <button class="btn box flex items-center text-slate-600 dark:text-slate-300"  data-tw-toggle="modal" data-tw-target="#request_transaction_modal"> <i data-lucide="file" class="hidden sm:block w-4 h-4 mr-2"></i>Report </button>
                        </div>
                    </div>
                    <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                   <table class="table table-bordered table-striped" id="requested_dashboard_table" style="font-size: 12px;">
                    <thead >
                    <tr>
                    <th>Name(Complete Name) &nbsp&nbsp</th>
                    <th>Type</th>
                    <th>Purpose</th>
                    <th>Copies</th>
                    <th>Requested</th>
                    <th>Approved</th>
                    <th>Claimed</th>
                    <th>Status</th>
                    <td>Action</th>
                    </tr>
                    </thead>
                    </table>

                    </div>

                </div>
                <!-- END: Weekly Top Products -->
            </div>
        </div>
    </div>



        <div class="col-span-12 2xl:col-span-3">
            <div class="2xl:border-l -mb-10 pb-10">
                <div class="2xl:pl-6 grid grid-cols-12 gap-x-6 2xl:gap-x-0 gap-y-6">
                    <!-- BEGIN: Transactions -->
                <div class="col-span-12 md:col-span-6 xl:col-span-4 2xl:col-span-12 mt-3 2xl:mt-8">
                        <div class="intro-x flex items-center h-10">

                </div>

                <div class="intro-y box p-5 mt-5">
     <h2 class="text-lg font-medium truncate mr-5">
                                Student Online Request Chart
                        </h2>
                    <div class="mt-10">
                       <span> <div  class="mt-3 chartjs-render-monitor" id="victiti"></div></span>
                    </div>

                </div>

                <div class="w-52 sm:w-auto mx-auto mt-8">

                      </div>
                 </div>
            <!-- END: Transactions -->

    <script>

const pieChart = document.getElementById('victiti');

// Add a click event listener to the pie chart element
pieChart.addEventListener('click', () => {
    // Toggle the "enlarged" class on click
    pieChart.classList.toggle('enlarged');
});

    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Task', 'Hours per Day'],
    <?php echo $chartData ?>
    ]);

    var options = {
      title: 'Requested Data',
      is3D: false,
    };

        var chart = new google.visualization.PieChart(document.getElementById('victiti'));
        chart.draw(data, options);
      }
    </script>


            <!-- END: Important Notes -->

@include('layouts.onlinerequest.modal.approval_action_modal')
@include('layouts.onlinerequest.modal.request_transaction_modal')
@endsection

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@section('scripts')
     <script src={{ asset('js/ASIS_js/OnlineRequest.js') }}></script>
     <script src={{ asset('js/ASIS_js/attachment_for_request.js') }}></script>

@endsection()
