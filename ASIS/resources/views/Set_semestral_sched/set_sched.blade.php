@extends('layouts.app')
@section('breadcrumb')
    {{ Breadcrumbs::render('Dashboard') }}
@endsection
@section('content')

<div class="intro-y grid grid-cols-12 gap-5 mt-5">
    <!-- BEGIN: Item List -->
    <div class="intro-y col-span-12 lg:col-span-8">

         <!-- BEGIN: header button design -->
                        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                            <button id="btn_set_semestral_sched" class="btn btn-primary shadow-md mr-2"  data-tw-toggle="modal" data-tw-target="#btn_set_sem_sched" >Set Schedule</button>
                            {{-- <div class="dropdown mr-4">
                                <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                                    <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i> </span>
                                </button>
                            </div> --}}
                            {{-- <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                                <div class="w-56 relative text-slate-500">
                                    <div class="col-span-12 sm:col-span-6"></label>
                                        <div class="ml-10">
                                            <select id="filter_status" class="select2 w-full">
                                                <option></option>
                                                <option value="13">available status</option>
                                                <option value="1">pending status</option>
                                                <option value="14">closed status</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            {{-- <div class="w-56 relative text-slate-500">
                                <div class="col-span-12 sm:col-span-6"></label>
                                    <div class="ml-auto p-5">
                                        <button id="refresh" class="btn btn-secondary mr-2">Refresh<i class="fa-solid fa-arrows-rotate  ml-2 text-success"></i> </button>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
         <!-- END: header button design -->
                        <div class="intro-y inbox box mt-7 px-3">
                            <div class="p-5 flex flex-col-reverse sm:flex-row text-slate-500 border-b border-slate-200/60">
                                <div class="flex items-center mt-3 sm:mt-0 border-t sm:border-0 border-slate-200/60 pt-5 sm:pt-0 mt-5 sm:mt-0 -mx-5 sm:mx-0 px-5 sm:px-0">
                                    <input class="form-check-input" type="checkbox">
                                    <div class="dropdown ml-1" data-tw-placement="bottom-start">
                                        <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="chevron-down" class="w-5 h-5"></i> </a>
                                        <div class="dropdown-menu w-32">
                                            <ul class="dropdown-content">
                                                <li> <a href="" class="dropdown-item">All</a> </li>
                                                <li> <a href="" class="dropdown-item">None</a> </li>
                                                <li> <a href="" class="dropdown-item">Read</a> </li>
                                                <li> <a href="" class="dropdown-item">Unread</a> </li>
                                                <li> <a href="" class="dropdown-item">Starred</a> </li>
                                                <li> <a href="" class="dropdown-item">Unstarred</a> </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <a href="javascript:;" class="w-5 h-5 ml-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="refresh-cw"></i> </a>
                                    <a href="javascript:;" class="w-5 h-5 ml-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="more-horizontal"></i> </a>
                                </div>
                                <div class="flex items-center sm:ml-auto">
                                    <div class="">1 - 50 of 5,238</div>
                                    <a href="javascript:;" class="w-5 h-5 ml-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="chevron-left"></i> </a>
                                    <a href="javascript:;" class="w-5 h-5 ml-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="chevron-right"></i> </a>
                                    <a href="javascript:;" class="w-5 h-5 ml-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="settings"></i> </a>
                                </div>
                            </div>
                            <div class="overflow-x-auto sm:overflow-x-visible">
                                <div class="overflow-x-auto sm:overflow-x-visible">
                                    <div class="overflow-x-auto scrollbar-hidden pb-10">
                                        <table id="semestral_sched_dt" class="table table-report bordered table-hover dt-responsive nowrap">
                                            <thead class="">
                                                <tr>
                                                    <th class="text-center whitespace-nowrap">Department</th>
                                                    <th class="text-center whitespace-nowrap">Date open</th>
                                                    <th class="text-center whitespace-nowrap">Date close</th>
                                                    <th class="text-center whitespace-nowrap">Active</th>
                                                    <th class="text-center whitespace-nowrap">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="p-5 flex flex-col sm:flex-row items-center text-center sm:text-left text-slate-500">
                                <div>4.41 GB (25%) of 17 GB used Manage</div>
                                <div class="sm:ml-auto mt-2 sm:mt-0">Last account activity: 36 minutes ago</div>
                            </div>
                        </div>
    </div>
    <!-- END: Item List -->
    <!-- BEGIN: Ticket -->
    <div class="col-span-12 lg:col-span-4">
        <div class="intro-y pr-1">
            <div class="box p-2">
                <ul class="nav nav-pills" role="tablist">
                    <li id="ticket-tab" class="nav-item flex-1" role="presentation">
                        <button class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#ticket" type="button" role="tab" aria-controls="ticket" aria-selected="true" > Ticket </button>
                    </li>
                    <li id="details-tab" class="nav-item flex-1" role="presentation">
                        <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#details" type="button" role="tab" aria-controls="details" aria-selected="false" > Details </button>
                    </li>
                </ul>
            </div>
        </div>
        <div class="tab-content">
            <div id="ticket" class="tab-pane active" role="tabpanel" aria-labelledby="ticket-tab">
                <div class="box p-2 mt-5">
                    <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#add-item-modal" class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md">
                        <div class="max-w-[50%] truncate mr-1">Root Beer</div>
                        <div class="text-slate-500">x 1</div>
                        <i data-lucide="edit" class="w-4 h-4 text-slate-500 ml-2"></i>
                        <div class="ml-auto font-medium">$139</div>
                    </a>
                    <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#add-item-modal" class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md">
                        <div class="max-w-[50%] truncate mr-1">Spaghetti Fettucine Aglio with Smoked Salmon</div>
                        <div class="text-slate-500">x 1</div>
                        <i data-lucide="edit" class="w-4 h-4 text-slate-500 ml-2"></i>
                        <div class="ml-auto font-medium">$44</div>
                    </a>
                    <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#add-item-modal" class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md">
                        <div class="max-w-[50%] truncate mr-1">Fried/Grilled Banana</div>
                        <div class="text-slate-500">x 1</div>
                        <i data-lucide="edit" class="w-4 h-4 text-slate-500 ml-2"></i>
                        <div class="ml-auto font-medium">$79</div>
                    </a>
                    <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#add-item-modal" class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md">
                        <div class="max-w-[50%] truncate mr-1">Spaghetti Fettucine Aglio with Smoked Salmon</div>
                        <div class="text-slate-500">x 1</div>
                        <i data-lucide="edit" class="w-4 h-4 text-slate-500 ml-2"></i>
                        <div class="ml-auto font-medium">$47</div>
                    </a>
                    <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#add-item-modal" class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md">
                        <div class="max-w-[50%] truncate mr-1">Soft Drink</div>
                        <div class="text-slate-500">x 1</div>
                        <i data-lucide="edit" class="w-4 h-4 text-slate-500 ml-2"></i>
                        <div class="ml-auto font-medium">$33</div>
                    </a>
                </div>
                <div class="box flex p-5 mt-5">
                    <input type="text" class="form-control py-3 px-4 w-full bg-slate-100 border-slate-200/60 pr-10" placeholder="Use coupon code...">
                    <button class="btn btn-primary ml-2">Apply</button>
                </div>
                <div class="box p-5 mt-5">
                    <div class="flex">
                        <div class="mr-auto">Subtotal</div>
                        <div class="font-medium">$250</div>
                    </div>
                    <div class="flex mt-4">
                        <div class="mr-auto">Discount</div>
                        <div class="font-medium text-danger">-$20</div>
                    </div>
                    <div class="flex mt-4">
                        <div class="mr-auto">Tax</div>
                        <div class="font-medium">15%</div>
                    </div>
                    <div class="flex mt-4 pt-4 border-t border-slate-200/60 dark:border-darkmode-400">
                        <div class="mr-auto font-medium text-base">Total Charge</div>
                        <div class="font-medium text-base">$220</div>
                    </div>
                </div>
                <div class="flex mt-5">
                    <button class="btn w-32 border-slate-300 dark:border-darkmode-400 text-slate-500">Clear Items</button>
                    <button class="btn btn-primary w-32 shadow-md ml-auto">Charge</button>
                </div>
            </div>
            <div id="details" class="tab-pane" role="tabpanel" aria-labelledby="details-tab">
                <div class="box p-5 mt-5">
                    <div class="flex items-center border-b border-slate-200 dark:border-darkmode-400 pb-5">
                        <div>
                            <div class="text-slate-500">Time</div>
                            <div class="mt-1">02/06/20 02:10 PM</div>
                        </div>
                        <i data-lucide="clock" class="w-4 h-4 text-slate-500 ml-auto"></i>
                    </div>
                    <div class="flex items-center border-b border-slate-200 dark:border-darkmode-400 py-5">
                        <div>
                            <div class="text-slate-500">Customer</div>
                            <div class="mt-1">Kate Winslet</div>
                        </div>
                        <i data-lucide="user" class="w-4 h-4 text-slate-500 ml-auto"></i>
                    </div>
                    <div class="flex items-center border-b border-slate-200 dark:border-darkmode-400 py-5">
                        <div>
                            <div class="text-slate-500">People</div>
                            <div class="mt-1">3</div>
                        </div>
                        <i data-lucide="users" class="w-4 h-4 text-slate-500 ml-auto"></i>
                    </div>
                    <div class="flex items-center pt-5">
                        <div>
                            <div class="text-slate-500">Table</div>
                            <div class="mt-1">21</div>
                        </div>
                        <i data-lucide="mic" class="w-4 h-4 text-slate-500 ml-auto"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Ticket -->
</div>
<!-- BEGIN: New Order Modal -->
<div id="new-order-modal" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">
                    New Order
                </h2>
            </div>
            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12">
                    <label for="pos-form-1" class="form-label">Name</label>
                    <input id="pos-form-1" type="text" class="form-control flex-1" placeholder="Customer name">
                </div>
                <div class="col-span-12">
                    <label for="pos-form-2" class="form-label">Table</label>
                    <input id="pos-form-2" type="text" class="form-control flex-1" placeholder="Customer table">
                </div>
                <div class="col-span-12">
                    <label for="pos-form-3" class="form-label">Number of People</label>
                    <input id="pos-form-3" type="text" class="form-control flex-1" placeholder="People">
                </div>
            </div>
            <div class="modal-footer text-right">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-32 mr-1">Cancel</button>
                <button type="button" class="btn btn-primary w-32">Create Ticket</button>
            </div>
        </div>
    </div>
</div>
<!-- END: New Order Modal -->
<!-- BEGIN: Add Item Modal -->
<div id="add-item-modal" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">
                    Root Beer
                </h2>
            </div>
            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12">
                    <label for="pos-form-4" class="form-label">Quantity</label>
                    <div class="flex mt-2 flex-1">
                        <button type="button" class="btn w-12 border-slate-200 bg-slate-100 dark:bg-darkmode-700 dark:border-darkmode-500 text-slate-500 mr-1">-</button>
                        <input id="pos-form-4" type="text" class="form-control w-24 text-center" placeholder="Item quantity" value="2">
                        <button type="button" class="btn w-12 border-slate-200 bg-slate-100 dark:bg-darkmode-700 dark:border-darkmode-500 text-slate-500 ml-1">+</button>
                    </div>
                </div>
                <div class="col-span-12">
                    <label for="pos-form-5" class="form-label">Notes</label>
                    <textarea id="pos-form-5" class="form-control w-full mt-2" placeholder="Item notes"></textarea>
                </div>
            </div>
            <div class="modal-footer text-right">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                <button type="button" class="btn btn-primary w-24">Add Item</button>
            </div>
        </div>
    </div>
</div>

@include('Set_semestral_sched.set_sched_modal.create_sched_modal')
@endsection

@section('scripts')
<script src={{ asset('js/ASIS_js/Semsched.js') }}></script>
@endsection
