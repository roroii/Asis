
@extends('layouts.app')



@section('content')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Payroll
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <button id="make_travel_order" class="btn btn-primary shadow-md mr-2" href="javascript:;" data-tw-toggle="modal" data-tw-target="#modal_create_new_payroll">Create Payroll</button>
            {{-- <a class='btn btn-info' href='{{url("travel/order/travelorder-export")}}'>Export Excel</a> --}}
        </div>
    </div>
    <div class="intro-y box p-5 mt-5">

        <div class="overflow-x-auto scrollbar-hidden pb-10">
            <table id="dt__created_travel_order" class="table table-report -mt-2 table-hover">
                <thead>
                <tr>
                    <th style="display: none" class="text-center whitespace-nowrap ">#ID</th>
                    <th class="text-center whitespace-nowrap ">Employee Type</th>
                    <th class="text-center whitespace-nowrap ">Payment Date Type</th>
                    <th class="text-center whitespace-nowrap ">Month & Year</th>
                    <th class="text-center whitespace-nowrap ">Total Employee</th>
                    <th class="text-center whitespace-nowrap ">Status</th>
                    <th class="text-center whitespace-nowrap ">Processed By</th>
                    <th class="text-center whitespace-nowrap ">Action</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    @include('payroll__.modal.create_payroll')
@endsection
@section('scripts')
@endsection

