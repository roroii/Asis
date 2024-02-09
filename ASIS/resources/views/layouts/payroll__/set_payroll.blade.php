
@extends('layouts.app')



@section('content')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Set Payroll
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            {{-- <button id="make_travel_order" class="btn btn-primary shadow-md mr-2" href="javascript:;" data-tw-toggle="modal" data-tw-target="#modal_set_payroll">Employee</button> --}}
            {{-- <a class='btn btn-info' href='{{url("travel/order/travelorder-export")}}'>Export Excel</a> --}}
            <div class="w-full sm:w-auto flex">
                <button type="button" class="btn btn-primary shadow-md mr-2 user_priv_table_updated" data-tw-toggle="modal" data-tw-target="#modal_payroll_info"> <i class="w-4 h-4 mr-2" data-lucide="settings"></i> Employee </button>

                <div class="dropdown" style="position: relative;">
                    <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                        <span class="w-5 h-5 flex items-center justify-center"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="plus" class="lucide lucide-plus w-4 h-4" data-lucide="plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> </span>
                    </button>
                    <div class="dropdown-menu w-40" id="_gwv3kf5we">
                        <ul class="dropdown-content">
                            <li>
                                <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#modal_con_ded_rev_payroll" class="dropdown-item"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="user" data-lucide="user" class="lucide lucide-user w-4 h-4 mr-2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>Con, Ded & Rev</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="intro-y box p-5 mt-5">

        <div class="overflow-x-auto scrollbar-hidden pb-10">
            <table id="dt__created_travel_order" class="table table-report -mt-2 table-hover">
                <thead>
                <tr>
                    <th class="text-center whitespace-nowrap">Name</th>
                    <th class="text-center whitespace-nowrap">Salary</th>
                    <th class="text-center whitespace-nowrap">Deduction</th>
                    <th class="text-center whitespace-nowrap">Contribution</th>
                    <th class="text-center whitespace-nowrap">Status</th>
                    <th class="text-center whitespace-nowrap">Processed By</th>
                    <th class="text-center whitespace-nowrap">Action</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    @include('payroll__.modal.set_payroll_mdl')
    @include('payroll__.modal.con_ded_rev')
@endsection
@section('scripts')
    <script src="{{ asset('/js/__payroll/set_payroll.js') }}"></script>
@endsection

