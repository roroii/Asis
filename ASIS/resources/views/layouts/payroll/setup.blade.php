@extends('layouts.app')

@section('content')
    <h2 class="intro-y text-lg font-medium mt-10">
        Setup Payroll
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <button class="btn btn-primary shadow-md mr-2">Add New Contribution</button>
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
                <table id="dt_pr_setup" class="table table-report -mt-2 table-hover">
                    <thead>
                    <tr>
                        <th class="hidden">ID</th>
                        <th class="whitespace-nowrap">NAME</th>
                        <th class="whitespace-nowrap" style="text-align: right">SALARY</th>
                        <th class="whitespace-nowrap" style="text-align: right">INCENTIVE</th>
                        <th class="whitespace-nowrap" style="text-align: right">CONTRIBUTION</th>
                        <th class="whitespace-nowrap" style="text-align: right">DEDUCTION</th>
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

    <div id="set_salary" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="form_set_salary"  method="post" enctype="multipart/form-data">

                <div class="modal-content">
                    <!-- BEGIN: Modal Header -->
                    <div class="alert alert-danger" style="display:none"></div>
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Set Salary</h2>
                    </div>
                    <!-- END: Modal Header -->
                    <!-- BEGIN: Modal Body -->


                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <input hidden id="modal_update_to_id" class="form-control" type="text" style="width: max-content">
                        <input hidden id="modal_update_to_sal_id" class="form-control" type="text" style="width: max-content">

                        <div class="col-span-12 sm:col-span-12">
                            <div> <label>Classification</label>
                                <div class="mt-2"> <select id="emp_class" data-placeholder="Select Classification" class="w-full">
                                        <option value="1">Salary Grade</option>
                                        <option value="2">Hourly Rate</option>
                                        <option value="3">Fixed Amount</option>
                                    </select> </div>
                            </div>
                        </div>


                        <div class="col-span-12 sm:col-span-3 Div1">
                                <div> <label for="regular-form-1" class="form-label">Salary Grade</label> <input id="sg" type="text" class="form-control" placeholder="Input SG"> </div>
                        </div>
                        <div class="col-span-12 sm:col-span-3 Div1">
                                <div> <label for="regular-form-1" class="form-label">Step</label> <input id="step" type="text" class="form-control" placeholder="Input Step"> </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 Div1">
                            <label for="regular-form-1" class="form-label">Salary Amount</label>
                            <div class="input-group"> <input id="amount1" type="text" class="form-control text-right" placeholder="0.00" aria-label="Amount" aria-describedby="input-group-price">
                            </div>
                        </div>


                        <div class="col-span-12 sm:col-span-6 Div2">
                            <div> <label>Hourly Rate</label>
                                <div class="mt-2">
                                    <select class="js-example-theme-multiple form-control w-full" id="rate_class">
                                        @foreach(load_rate() as $f)
                                            <option value="{{ $f->id }}">{{ $f->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>

                        <div class="col-span-12 sm:col-span-6 Div2">
                            <label for="regular-form-1" class="form-label">Salary Amount</label>
                            <div class="input-group"> <input id="amount2" type="text" class="form-control text-right" placeholder="0.00" aria-label="Amount" aria-describedby="input-group-price">
                            </div>
                        </div>

                        <div class="col-span-12 sm:col-span-6 Div3">

                        </div>

                        <div class="col-span-12 sm:col-span-6 Div3">
                            <label for="regular-form-1" class="form-label">Salary Amount</label>
                            <div class="input-group"> <input id="amount3" type="text" class="form-control text-right" placeholder="0.00" aria-label="Amount" aria-describedby="input-group-price">
                            </div>
                        </div>




                    </div>



                    <!-- END: Modal Body -->

                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer">
                        <button id="cancel_documents_btn" type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                        <a  href="javascript:;"  class="btn btn-primary w-20 add_salary"> Save </a>
                        {{-- <button id="add_travel_order" class="btn btn-primary w-20 add_travel_order">Save</button> --}}
                    </div>
                    <!-- END: Modal Footer -->
                </div>
            </form>
        </div>
    </div>

    <div id="set_incentive" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">


            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="alert alert-danger" style="display:none"></div>
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Set Incentive</h2>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->


                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <input hidden id="inc_emp_id" type="text" class="form-control" placeholder="id">

                    <div class="col-span-12 sm:col-span-12">
                        <div id="add_incentive_div" class="w-full mt-3 xl:mt-0 flex-1">
                            <div class="relative pl-5 pr-5 xl:pr-10 py-10 bg-slate-50 dark:bg-transparent dark:border rounded-md">
                                <a href="javascript:;" class="text-slate-500 absolute top-0 right-0 mr-4 mt-4">
                                    {{--                                        <i data-lucide="x" class="w-5 h-5"></i> --}}
                                </a>
                                <div>
                                    <div class="form-inline mt-5 first:mt-0">
                                        <label class="form-label sm:w-20">Incentive</label>


                                        <div class="flex-1">
                                            <div class="xl:flex items-center mt-5 first:mt-0">
                                                <div class="input-group flex-1">
                                                    <select id="incentive_id" data-placeholder="Select Contribution" class="form-control">
                                                        @foreach(load_incentive() as $i)
                                                            <option value="{{ $i->id }}">{{ $i->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="w-20 flex text-slate-500 mt-3 xl:mt-0 ">
                                                    <a href="" class="xl:ml-5"> <i class="fa-solid fa-plus w-4 h-4"></i></a>
                                                    <a href="" class="ml-3 xl:ml-5"> <i class="fa-solid fa-arrow-rotate-right w-4 h-4"></i> </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-inline mt-5 items-start first:mt-0">
                                        <label class="form-label mt-2 sm:w-20">Amount</label>
                                        <div class="flex-1">
                                            <div class="xl:flex items-center mt-5 first:mt-0">
                                                <div class="input-group flex-1">
                                                    <input id="incentive_amount" type="number" class="form-control contr_amount" placeholder="Enter Amount">
                                                </div>
                                                <div class="w-20 flex text-slate-500 mt-3 xl:mt-0 " style="visibility: hidden">
                                                    <a href="" class="xl:ml-5"> <i data-lucide="move" class="w-4 h-4"></i> </a>
                                                    <a href="" class="ml-3 xl:ml-5"> <i data-lucide="trash-2" class="w-4 h-4"></i> </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="xl:ml-20 xl:pl-5 xl:pr-20 mt-5 first:mt-0">
                                        <button id="add_new_incentive" class="btn btn-outline-primary border-dashed w-full"> <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Add New</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 sm:col-span-12">
                        <div class="intro-y col-span-12 overflow-auto overflow-x-auto scrollbar-hidden lg:overflow-visible">
                            <table id="dt_emp_incentives" class="table table-report -mt-2 table-hover">
                                <thead>
                                <tr>
                                    <th class="hidden">ID</th>
                                    <th class="whitespace-nowrap">INCENTIVE</th>
                                    <th class="whitespace-nowrap">AMOUNT</th>
                                    <th class="text-center whitespace-nowrap w-20" style="text-align: right">ACTIONS</th>
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
                    </div>
                </div>



                <!-- END: Modal Body -->

                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">

                    <button id="cancel_documents_btn" type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Close</button>
                    {{-- <button id="add_travel_order" class="btn btn-primary w-20 add_travel_order">Save</button> --}}
                </div>
                <!-- END: Modal Footer -->
            </div>
        </div>
    </div>

    <div id="set_contribution" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">


                <div class="modal-content">
                    <!-- BEGIN: Modal Header -->
                    <div class="alert alert-danger" style="display:none"></div>
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Set Contribution</h2>
                    </div>
                    <!-- END: Modal Header -->
                    <!-- BEGIN: Modal Body -->


                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <input hidden id="cont_emp_id" type="text" class="form-control" placeholder="id">

                        <div class="col-span-12 sm:col-span-12">
                            <div id="add_contribution_div" class="w-full mt-3 xl:mt-0 flex-1">
                                <div class="relative pl-5 pr-5 xl:pr-10 py-10 bg-slate-50 dark:bg-transparent dark:border rounded-md">
                                    <a href="javascript:;" class="text-slate-500 absolute top-0 right-0 mr-4 mt-4">
{{--                                        <i data-lucide="x" class="w-5 h-5"></i> --}}
                                    </a>
                                    <div>
                                        <div class="form-inline mt-5 first:mt-0">
                                            <label class="form-label sm:w-20">Contribution</label>


                                            <div class="flex-1">
                                                <div class="xl:flex items-center mt-5 first:mt-0">
                                                    <div class="input-group flex-1">
                                                        <select id="contribution_id" data-placeholder="Select Contribution" class="form-control">
                                                            @foreach(load_contribution() as $c)
                                                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="w-20 flex text-slate-500 mt-3 xl:mt-0 ">
                                                        <a href="" class="xl:ml-5"> <i class="fa-solid fa-plus w-4 h-4"></i></a>
                                                        <a href="" class="ml-3 xl:ml-5"> <i class="fa-solid fa-arrow-rotate-right w-4 h-4"></i> </a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="form-inline mt-5 items-start first:mt-0">
                                            <label class="form-label mt-2 sm:w-20">Amount</label>
                                            <div class="flex-1">
                                                <div class="xl:flex items-center mt-5 first:mt-0">
                                                    <div class="input-group flex-1">
                                                        <input id="contribution_amount" type="number" class="form-control contr_amount" placeholder="Enter Amount">
                                                    </div>
                                                    <div class="w-20 flex text-slate-500 mt-3 xl:mt-0 " style="visibility: hidden">
                                                        <a href="" class="xl:ml-5"> <i data-lucide="move" class="w-4 h-4"></i> </a>
                                                        <a href="" class="ml-3 xl:ml-5"> <i data-lucide="trash-2" class="w-4 h-4"></i> </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="xl:ml-20 xl:pl-5 xl:pr-20 mt-5 first:mt-0">
                                            <button id="add_new_contribution" class="btn btn-outline-primary border-dashed w-full"> <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Add New</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-span-12 sm:col-span-12">
                            <div class="intro-y col-span-12 overflow-auto overflow-x-auto scrollbar-hidden lg:overflow-visible">
                                <table id="dt_emp_contribution" class="table table-report -mt-2 table-hover">
                                    <thead>
                                    <tr>
                                        <th class="hidden">ID</th>
                                        <th class="whitespace-nowrap">CONTRIBUTION</th>
                                        <th class="whitespace-nowrap">AMOUNT</th>
                                        <th class="text-center whitespace-nowrap w-20" style="text-align: right">ACTIONS</th>
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
                        </div>
                    </div>



                    <!-- END: Modal Body -->

                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer">

                        <button id="cancel_documents_btn" type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Close</button>
                        {{-- <button id="add_travel_order" class="btn btn-primary w-20 add_travel_order">Save</button> --}}
                    </div>
                    <!-- END: Modal Footer -->
                </div>
        </div>
    </div>

    <div id="set_deduction" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="form_set_deduction"  method="post" enctype="multipart/form-data">

                <div class="modal-content">
                    <!-- BEGIN: Modal Header -->
                    <div class="alert alert-danger" style="display:none"></div>
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Set Deduction Rate</h2>
                    </div>
                    <!-- END: Modal Header -->
                    <!-- BEGIN: Modal Body -->


                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <input hidden id="modal_ded_emp_id" class="form-control" type="text" style="width: max-content">

                        <div class="col-span-12 sm:col-span-12">
                            <div> <label>Deduction</label>
                                <div class="mt-2"> <select id="deduction_select" data-placeholder="Select Classification" class="w-full">
                                        @foreach(load_deduction() as $d)
                                            <option value="{{ $d->id }}">{{ $d->name }}</option>
                                        @endforeach
                                    </select> </div>
                            </div>
                        </div>


                        <div class="col-span-12 sm:col-span-6">
                            <label for="regular-form-1" class="form-label">Salary Amount</label>
                            <div class="input-group"> <input id="deduction_amount" type="text" class="form-control text-right" placeholder="0.00" aria-label="Amount" aria-describedby="input-group-price">
                            </div>
                        </div>


                    </div>



                    <!-- END: Modal Body -->

                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer">
                        <button id="cancel_documents_btn" type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                        <a  href="javascript:;"  class="btn btn-primary w-20 add_deduction"> Save </a>
                        {{-- <button id="add_travel_order" class="btn btn-primary w-20 add_travel_order">Save</button> --}}
                    </div>
                    <!-- END: Modal Footer -->
                </div>
            </form>
        </div>
    </div>

    <div id="emp_contribution_confirm" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center"> <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">Are you sure?</div>
                        <div class="text-slate-500 mt-2">Do you really want to delete these records? <br>This process cannot be undone.</div>
                    </div>
                    <div class="px-5 pb-8 text-center"> <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1 ">Cancel</button> <button type="button" class="btn btn-danger w-24 confirm_contribution_delete">Delete</button> </div>
                </div>
            </div>
        </div>
    </div>

    <div id="emp_incentive_confirm" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center"> <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">Are you sure?</div>
                        <div class="text-slate-500 mt-2">Do you really want to delete these records? <br>This process cannot be undone.</div>
                    </div>
                    <div class="px-5 pb-8 text-center"> <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1 ">Cancel</button> <button type="button" class="btn btn-danger w-24 confirm_incentive_delete">Delete</button> </div>
                </div>
            </div>
        </div>
    </div>

    <div id="emp_loan_confirm" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center"> <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">Are you sure?</div>
                        <div class="text-slate-500 mt-2">Do you really want to delete these records? <br>This process cannot be undone.</div>
                    </div>
                    <div class="px-5 pb-8 text-center"> <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1 ">Cancel</button> <button type="button" class="btn btn-danger w-24 confirm_loan_delete">Delete</button> </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="../js/payroll/setup.js"></script>
@endsection()
