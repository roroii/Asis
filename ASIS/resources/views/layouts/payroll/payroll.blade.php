@extends('layouts.app')

@section('content')
    <h2 class="intro-y text-lg font-medium mt-10">
        Payroll
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <button class="btn btn-primary shadow-md mr-2" href="javascript:;" data-tw-toggle="modal" data-tw-target="#open_payroll_modal">Add New Payroll</button>
            <div class="dropdown">
                <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                    <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i> </span>
                </button>
                <div class="dropdown-menu w-40">
                    <ul class="dropdown-content">
                        <li>
                            <a href="" class="dropdown-item"> <i data-lucide="printer" class="w-4 h-4 mr-2"></i> Print </a>
                        </li>
                        <li>
                            <a href="" class="dropdown-item"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export to Excel </a>
                        </li>
                        <li>
                            <a href="" class="dropdown-item"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export to PDF </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto overflow-x-auto scrollbar-hidden lg:overflow-visible">
            <table id="dt_payroll" class="table table-report -mt-2 table-hover">
                <thead>
                <tr>
                    <th class="hidden">ID</th>
                    <th class="whitespace-nowrap">NAME</th>
                    <th class="whitespace-nowrap">MODE</th>
                    <th class="text-center whitespace-nowrap">MONTH</th>
                    <th class="text-center whitespace-nowrap">YEAR</th>
                    <th class="text-center whitespace-nowrap">EMPLOYEES</th>
                    <th class="text-center whitespace-nowrap">PROCESSED BY</th>
                    <th class="text-center whitespace-nowrap">STATUS</th>
                    <th class="text-center whitespace-nowrap w-40" style="text-align: center">ACTIONS</th>
                </tr>
                </thead>
                <tbody>
                {{--                    <tr class="intro-x">--}}
                {{--                        <td class="w-40 !py-4"> <a href="" class="underline decoration-dotted whitespace-nowrap">#INV-62807556</a> </td>--}}
                {{--                        <td>--}}
                {{--                            <a href="" class="font-medium whitespace-nowrap">Nike Tanjun</a>--}}
                {{--                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">Sport &amp; Outdoor</div>--}}
                {{--                        </td>--}}
                {{--                        <td>--}}
                {{--                            <a href="" class="font-medium whitespace-nowrap">Nike Tanjun</a>--}}
                {{--                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">Sport &amp; Outdoor</div>--}}
                {{--                        </td>--}}
                {{--                        <td class="text-center">$46</td>--}}
                {{--                        <td class="table-report__action w-56">--}}
                {{--                            <div class="flex justify-center items-center">--}}
                {{--                                <a class="flex items-center mr-3" href="javascript:;"> <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit </a>--}}
                {{--                                <a class="flex items-center text-danger" href="javascript:;" data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal"> <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>--}}
                {{--                            </div>--}}
                {{--                        </td>--}}
                {{--                    </tr>--}}
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->
    </div>

    <div id="open_payroll_modal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto"></h2> <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x" class="w-8 h-8 text-slate-400"></i> </a>
                </div> <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-6"> <label for="modal-form-1" class="form-label">From</label> <input id="modal-form-1" type="text" class="form-control" placeholder="example@gmail.com"> </div>
                    <div class="col-span-12 sm:col-span-6"> <label for="modal-form-2" class="form-label">To</label> <input id="modal-form-2" type="text" class="form-control" placeholder="example@gmail.com"> </div>
                    <div class="col-span-12 sm:col-span-6"> <label for="modal-form-3" class="form-label">Subject</label> <input id="modal-form-3" type="text" class="form-control" placeholder="Important Meeting"> </div>
                    <div class="col-span-12 sm:col-span-6"> <label for="modal-form-4" class="form-label">Has the Words</label> <input id="modal-form-4" type="text" class="form-control" placeholder="Job, Work, Documentation"> </div>
                    <div class="col-span-12 sm:col-span-6"> <label for="modal-form-5" class="form-label">Doesn't Have</label> <input id="modal-form-5" type="text" class="form-control" placeholder="Job, Work, Documentation"> </div>
                    <div class="col-span-12 sm:col-span-6"> <label for="modal-form-6" class="form-label">Size</label> <select id="modal-form-6" class="form-select">
                            <option>10</option>
                            <option>25</option>
                            <option>35</option>
                            <option>50</option>
                        </select> </div>
                </div> <!-- END: Modal Body -->
                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer"> <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button> <button type="button" class="btn btn-primary w-20">Send</button> </div> <!-- END: Modal Footer -->
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="../js/payroll/payroll.js"></script>
@endsection()
