@extends('layouts.app')
@section('content')

    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Travel Order List
        </h2>
    </div>
    <div class="intro-y box p-5 mt-5">

        <div class="overflow-x-auto scrollbar-hidden pb-10">
            <table id="dt__created_travel_order_list" class="table table-report -mt-2 table-hover">
                <thead>
                <tr>
                    <th style="display: none" class="text-center whitespace-nowrap ">#ID</th>
                    <th class="text-center whitespace-nowrap ">Status</th>
                    <th class="text-center whitespace-nowrap ">Purpose</th>
                    <th class="text-center whitespace-nowrap ">Day(s)</th>
                    <th class="text-center whitespace-nowrap ">Departure Date</th>
                    <th class="text-center whitespace-nowrap ">Return Date</th>
                    <th class="text-center whitespace-nowrap ">Station</th>
                    <th class="text-center whitespace-nowrap ">Destination</th>
                    <th class="text-center whitespace-nowrap ">Action</th>
                </tr>
                </thead>
                <tbody>


                </tbody>
            </table>
        </div>
    </div>
    @include('travelorder.modal.make_travel_order')
    @include('travelorder.modal.release_travel_order')
    @include('Documents.Modals.receive.action_signatories')

@endsection
@section('scripts')
<script src="{{ asset('/js/travelorder/travel_order.js') }}"></script>
<script src="{{ asset('/js/global_signatories/load_action_signatories.js') }}"></script>
@endsection

