@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('Vote Type') }}
@endsection

@section('content')

<div class="intro-y flex items-center mb-5 mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Election Registration
    </h2>
</div>

<form id="electionRegistration_form" enctype="multipart/form-data">
    <div class="mt-3">
        <label for="electionName" class="form-label">Election Name </label>
        <input id="electionName" name="electionName" type="text" class="form-control form-control-rounded" placeholder="Election Name">
        <div class="form-help ml-5 text-danger hidden electionNameError">This Field is required</div>
    </div>
    <div class="mt-3">
        <label for="electionDescription" class="form-label">Description</label>
        <textarea id="electionDescription" name="electionDescription" class="form-control" name="comment" placeholder="Type your Description"></textarea>
        <div class="form-help ml-5 text-danger hidden electionDescriptionError">This Field is required</div>
    </div>
    <div class="mt-3"> <label>This Election is Intended To:</label>
        <div class="flex flex-col sm:flex-row mt-2">
            <div class="form-check mr-2">
                <input id="all" class="form-check-input intended_to" type="radio" name="intended_to" value="all">
                <label class="form-check-label" for="all">All</label>
            </div>
            <div class="form-check mr-2 mt-2 sm:mt-0">
                <input id="student" class="form-check-input intended_to" type="radio" name="intended_to" value="student">
                <label class="form-check-label" for="student">Student/s</label>
            </div>
            <div class="form-check mr-2 mt-2 sm:mt-0">
                <input id="agency" class="form-check-input intended_to" type="radio" name="intended_to" value="agency">
                <label class="form-check-label" for="agency">Agency</label>
            </div>
        </div>
        <div class="form-help ml-5 text-danger hidden intended_toError">Please Choose any one that you desire</div>
    </div>



    <!-- BEGIN: Dark Mode Switcher-->
    <div class="cursor-pointer shadow-md fixed bottom-0 right-0 box border rounded-full w-20 h-10 flex items-center justify-center z-50 mb-10 mr-10 bg-primary">
        <button type="submit" class="mr-4 text-white"> <i class="far fa-save fa-spin mr-2 text-white"></i> Save </button>
    </div>
    <!-- END: Dark Mode Switcher-->
</form>




    {{--  @include('vote.voteModals.voteType_modal')
    @include('vote.delete_modal.deleteModal')
    @include('vote.voteModals.votingDate_modal')  --}}

@endsection

@section('scripts')

    {{-- @livewireScripts
    @powerGridScripts
    {{-- <script src="{{BASEPATH()}}/js/student/examinees_list.js{{GET_RES_TIMESTAMP()}}"></script> --}}
    {{-- <script src="{{BASEPATH()}}/js/dropdown.js{{GET_RES_TIMESTAMP()}}"></script> --}}
    <script src="{{ asset('/js/vote/registration.js') }}"></script>
    <script src="{{ asset('/js/vote/vote_delete.js') }}"></script>

@endsection
