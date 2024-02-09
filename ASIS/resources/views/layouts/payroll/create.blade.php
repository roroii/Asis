@extends('layouts.app')

@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Create Payroll
    </h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-8 lg:col-span-8">
        <!-- BEGIN: Form Layout -->
        <div class="intro-y box p-5">
            <div>
                <label for="pr_groupname" class="form-label">Group Name</label>
                <input id="pr_groupname" type="text" class="form-control w-full" placeholder="">
            </div>

            <div class="mt-3">
                <label for="pr_date_desc" class="form-label">Date Description</label>
                <input id="pr_date_desc" type="text" class="form-control w-full" placeholder="">
            </div>

            <div class="mt-3">
                <label class="form-label">Month & Year</label>
                <div class="sm:grid grid-cols-3 gap-2">
                    <div class="input-group mt-2 sm:mt-0">
                        <div id="input-group-4" class="input-group-text">Month</div>
                           <select id="pr_date_month" class="form-control" aria-describedby="input-group-4" data-placeholder="Select your favorite actors" class="tom-select w-full">
                               <option value="January">January</option>
                               <option value="February">February</option>
                               <option value="March">March</option>
                               <option value="April">April</option>
                               <option value="May">May</option>
                               <option value="June">June</option>
                               <option value="July">July</option>
                               <option value="August">August</option>
                               <option value="September">September</option>
                               <option value="October">October</option>
                               <option value="November">November</option>
                               <option value="December">December</option>
                           </select>

                    </div>
                    <div class="input-group mt-2 sm:mt-0">
                        <div class="input-group-text">Year</div>
                        <input id="pr_date_year" type="text" class="form-control" placeholder="20xx" aria-describedby="input-group-5">
                    </div>
                    <div class="input-group mt-2 sm:mt-0">
                        <div class="input-group-text">Date</div>
                        <input id="pr_date_days" type="text" data-daterange="true" class="datepicker form-control block mx-auto w-full">
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Form Layout -->

    </div>
    <div class="intro-y col-span-4 lg:col-span-4">
        <!-- BEGIN: Form Layout -->
        <div class="intro-y">
            <div class="box sm:flex">
                <div class="px-8 py-6 flex flex-col justify-center flex-1 border-t sm:border-t-0 sm:border-l border-slate-200 dark:border-darkmode-300 border-dashed">
                    <div class="text-slate-500 text-xs">TOTAL # OF EMPLOYEES ENROLLED</div>
                    <div class="mt-1.5 flex items-center">
                        <div class="text-base">
                            <label id="total_emp_count"></label>
                        </div>
                    </div>
                    <div class="text-slate-500 text-xs mt-5">OVERALL SALARY AMOUNT</div>
                    <div class="mt-1.5 flex items-center">
                        <div class="text-base">
                            <label id="total_salary_amount"></label>
                        </div>
                    </div>
                    <div class="text-slate-500 text-xs mt-5">INCENTIVE TOTAL AMOUNT</div>
                    <div class="mt-1.5 flex items-center">
                        <div class="text-base">
                            <label id="total_incentive_amount"></label>
                        </div>
                    </div>
                    <div class="text-slate-500 text-xs mt-5">DEDUCTION TOTAL VALUE</div>
                    <div class="mt-1.5 flex items-center">
                        <div class="text-base">
                            <label id="total_contribution_amount"></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Form Layout -->
    </div>



    <div class="cursor-pointer shadow-md fixed bottom-0 right-0 box flex items-center justify-center z-50 mb-10 mr-10">
        <div class="flex items-center px-5 py-8 sm:py-3 border-t border-slate-200/60 dark:border-darkmode-400">
            <a href="javascript:;" id="save_pr" class="ml-auto btn btn-primary truncate flex items-center"> <i class="w-4 h-4 mr-2" data-lucide="save"></i> Save </a>
        </div>
    </div>
</div>
<div class="intro-y box p-5 mt-5">
    <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
        <div class="font-medium text-base flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5"> <i data-lucide="chevron-down" class="w-4 h-4 mr-2"></i> Payroll Setup </div>
        <div class="mt-5">
            <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                <div class="w-full mt-3 xl:mt-0 flex-1">
                    <div class="overflow-x-auto">
                        <table id="dt_pr_emp" class="table border">
                            <thead>
                            <tr>
                                <th class="bg-slate-50 dark:bg-darkmode-800">ID</th>
                                <th class="bg-slate-50 dark:bg-darkmode-800">Name</th>
                                <th class="bg-slate-50 dark:bg-darkmode-800">Position</th>
                                <th class="bg-slate-50 dark:bg-darkmode-800">Hrs</th>
                                <th class="bg-slate-50 dark:bg-darkmode-800 " style="text-align: right">Salary</th>
                                <th class="bg-slate-50 dark:bg-darkmode-800" style="text-align: right">Incentive</th>
                                <th class="bg-slate-50 dark:bg-darkmode-800" style="text-align: right">Deduction</th>
                                <th class="bg-slate-50 dark:bg-darkmode-800" style="text-align: right">Loan</th>
                                <th class="bg-slate-50 dark:bg-darkmode-800" style="text-align: right">Tax</th>
                                <th class="bg-slate-50 dark:bg-darkmode-800" style="text-align: right">Net Salary</th>
                                <th class="!px-2 bg-slate-50 dark:bg-darkmode-800"></th>
                            </tr>
                            </thead>
                            <tbody>
{{--                            <tr>--}}
{{--                                <td class="!pr-2">1.</td>--}}
{{--                                <td class="whitespace-nowrap">Wholesale Price 1</td>--}}
{{--                                <td class="!px-2">--}}
{{--                                    <input type="text" class="form-control min-w-[6rem]" placeholder="Min Qty">--}}
{{--                                </td>--}}
{{--                                <td class="!px-2">--}}
{{--                                    <input type="text" class="form-control min-w-[6rem]" placeholder="Max Qty">--}}
{{--                                </td>--}}
{{--                                <td class="!px-2">--}}
{{--                                    <div class="input-group">--}}
{{--                                        <div class="input-group-text">$</div>--}}
{{--                                        <input type="text" class="form-control min-w-[6rem]" placeholder="Price">--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                                <td class="!pl-4 text-slate-500">--}}
{{--                                    <a href=""> <i data-lucide="trash-2" class="w-4 h-4"></i> </a>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
                            </tbody>
                        </table>
                    </div>
                    <button  id="pr_add_emp" data-tw-toggle="modal" data-tw-target="#emp_list" class="btn btn-outline-primary border-dashed w-full mt-4"> <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Add New Employee </button>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="emp_list" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x" class="w-8 h-8 text-slate-400 reload_emp"></i> </a>
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Select Employee</h2>
            </div>
            <div class="modal-body px-5 py-10">
                <div class="intro-y box p-5 mt-5">
                    <a href="javascript:;" id="reload_emp" class="ml-auto flex items-center text-primary float-right"> <i data-lucide="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data </a>
                    <div class="overflow-x-hidden scrollbar-hidden pb-10 pt-5">
                        <table id="dt__emp_list" class="table table-report -mt-2 table-hover">
                            <thead>
                            <tr>
                                <th style="display: none" class="text-center whitespace-nowrap ">#ID</th>
                                <th class="text-center whitespace-nowrap ">Name</th>
                                <th class="w-20 text-center whitespace-nowrap">Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script src="{{BASEPATH()}}/js/payroll/payroll.js{{GET_RES_TIMESTAMP()}}"></script>
@endsection()
