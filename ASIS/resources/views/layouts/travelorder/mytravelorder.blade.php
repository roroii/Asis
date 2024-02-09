@extends('layouts.app')



@section('content')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            My Travel Order
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            @if(Session::has('get_user_priv'))
                @if (Session::get('get_user_priv')[0]->create == 1 || Auth::user()->role_name == 'Admin')
                    <button id="make_travel_order" type="button" class="btn btn-primary shadow-md mr-2 user_priv_table_updated" data-tw-toggle="modal" data-tw-target="#make_travel_order_modal"> <i class="w-4 h-4 mr-2" data-lucide="plus"></i> Make Travel Order </button>
                @else
                    <button  type="button" class="not_allowed_to_take_action btn btn-primary shadow-md mr-2" > <i class="w-4 h-4 mr-2" data-lucide="minus"></i> Make Travel Order </button>
                @endif
            @else
                <button id="make_travel_order" type="button" class="btn btn-primary shadow-md mr-2 user_priv_table_updated" data-tw-toggle="modal" data-tw-target="#make_travel_order_modal"> <i class="w-4 h-4 mr-2" data-lucide="plus"></i> Make Travel Order </button>
            @endif
            <div class="dropdown" style="position: relative;">
                <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                    <span class="w-5 h-5 flex items-center justify-center"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="plus" class="lucide lucide-plus w-4 h-4" data-lucide="plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> </span>
                </button>
                <div class="dropdown-menu w-40" id="_gwv3kf5we">
                    <ul class="dropdown-content">
                        <li>
                            @if(Session::has('get_user_priv'))

                                @if (Session::get('get_user_priv')[0]->export == 1 || Auth::user()->role_name == 'Admin')
                                    <a  href='{{url("travel/order/travelorder-export")}}' class="dropdown-item"> <i class="w-4 h-4 mr-2" data-lucide="download"></i> Export Data </a>
                                @else
                                    <a href="javascript:;"class="no_user_priv dropdown-item not_allowed_to_take_action"> <i class="w-4 h-4 mr-2" data-lucide="rotate-cw"></i> Export Data </a>
                                @endif
                            @else
                                <a  href='{{url("travel/order/travelorder-export")}}' class="dropdown-item"> <i class="w-4 h-4 mr-2" data-lucide="download"></i> Export Data </a>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="intro-y box p-5 mt-5">

        <div class="overflow-x-auto scrollbar-hidden pb-10">
            <table id="dt__created_travel_order" class="table table-report -mt-2 table-hover">
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

