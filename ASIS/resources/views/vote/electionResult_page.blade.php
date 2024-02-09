@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('Election Result') }}
@endsection

@section('content')


<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Election Results
    </h2>    
</div>


<div class="intro-y box p-5 mt-5">
    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
        <form id="tabulator-html-filter-form" class="xl:flex sm:mr-auto" >

            <input id="data_container" type="hidden">

            <div class="sm:flex items-center sm:mr-4">
                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Select Type</label>
                <select id="electType_resultSelect" name="electType_resultSelect" class="form-control">
                        <option></option>
                    @foreach(loadElectionType_result() as $elect_type)
                        <option value="{{ $elect_type->id }}">{{ $elect_type->vote_type }}</option>
                    @endforeach
                </select>
            </div>
        </form>
            @if(auth()->guard('employee_guard')->user() && auth()->guard('employee_guard')->user()->role_name === 'Admin')
            <div id="print_div" class="flex mt-5 sm:mt-0 ">
                {{-- <button id="tabulator-print" class="btn btn-outline-secondary w-1/2 sm:w-auto mr-2"> <i data-lucide="printer" class="w-4 h-4 mr-2"></i> Print </button> --}}
                <div class="dropdown w-1/2 sm:w-auto">
                    <button id="print_btn" class="dropdown-toggle btn btn-primary w-full sm:w-auto">
                        <i class="fa fa-print text-secondary mr-2" aria-hidden="true"></i>
                            Print
                    </button>
                </div>
            </div>
            @endif
    </div>

    <div class="overflow-x-auto scrollbar-hidden">

    </div>
</div>

<div class="grid grid-cols-12 gap-6">

    <div id="position_div" class="col-span-12 2xl:col-span-9">

    </div>

    <div class="col-span-12 2xl:col-span-3">
        <div class="2xl:border-l -mb-10 pb-10">
            <div class="2xl:pl-6 grid grid-cols-12 gap-x-6 2xl:gap-x-0 gap-y-6">
                <!-- BEGIN: Leading Board -->
                    <div class="col-span-12 md:col-span-6 xl:col-span-4 2xl:col-span-12 mt-3 2xl:mt-8">
                        <div class="intro-x flex items-center h-10">
                            <h2 class="text-lg text-primary font-medium truncate mr-5">
                                Leading Board
                            </h2>
                        </div>
                        <div id="leaderBoard_div">

                        </div>
                    </div>
                <!-- END: Leading Board -->

            </div>
        </div>
    </div>
</div>
<div id="position_div" class="intro-y col-span-12 lg:col-span-8 xl:col-span-9">

</div>



@include('vote.voteModals.choosePrint_Modal')
@include('vote.voteModals.noContain_data_modal')


@endsection

@section('scripts')

    {{-- @livewireScripts
    @powerGridScripts
    {{-- <script src="{{BASEPATH()}}/js/student/examinees_list.js{{GET_RES_TIMESTAMP()}}"></script> --}}
    {{-- <script src="{{BASEPATH()}}/js/dropdown.js{{GET_RES_TIMESTAMP()}}"></script> --}}
    <script src="{{ asset('/js/vote/election_result.js') }}"></script>
    <script src="{{ asset('/js/vote/vote_delete.js') }}"></script>

@endsection
