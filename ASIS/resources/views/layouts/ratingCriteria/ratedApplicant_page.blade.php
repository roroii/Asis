@extends('layouts.app')
@section('breadcrumb')
    {{ Breadcrumbs::render('Dashboard') }}
@endsection
@section('content')

<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Rated Applicant/s
    </h2>
    @if((isCurrentUserAdmin() == 1))
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            {{-- <a  target="_blank" href="/rating/print-summary" class="btn btn-primary shadow-md mr-2">Print</a> --}}
            <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#rated_summary_modal"  class="btn btn-primary shadow-md mr-2 printSummary_btn">Print Summary</a>
        </div>
    @endif
   
</div>

<form id="saveRate_form" enctype="multipart/form-data">
    @csrf


    <div class="intro-y flex flex-col sm:flex-row items-center mt-4">
        <div class="w-full mr-2">
            <label for="position">Select Position:</label>
            <select id="position" name="position" class="select2 form-control ">
                <option selected></option>
                <option value="all" selected>All</option>
                @foreach (get_position() as $position)

                    <option value="{{ $position->id }}">{{ $position->emp_position }}</option>

                @endforeach

            </select>

        </div>
        <div class="w-full mr-2">
            <label for="status">Select Status:</label>
            <select id="status_rated" name="status_rated" class="select2 form-control ">
                <option selected></option>
                <option value="all" selected>All</option>
                @foreach (rate_status() as $status)

                    <option value="{{ $status->id }}">{{ $status->name }}</option>

                @endforeach

            </select>

        </div>
        <div id="positionApplied_div" class="w-full ml-2">


        </div>


    </div>


    <div class="intro-y box p-5 mt-5 form-control">

        <div id="ratedApplicant_div">

        </div>



        </div>

    </div>

</form>

<div class="cursor-pointer shadow-md fixed bottom-0 right-0 box flex items-center justify-center z-50 mb-10 mr-10 btn_save_PDS_div">
    <div class="flex items-center px-5 py-8 sm:py-3 border-t border-slate-200/60 dark:border-darkmode-400">
        <div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0">
            <label class="form-check-label ml-0" for="show-example-5">Show in Percent</label>
            <input id="rated_check" name="rated_check" class="show-code form-check-input mr-0 ml-3" type="checkbox">
            <input id="rated_check_in" name="rated_check_in" type="hidden">
        </div>
    </div>
</div>
{{-- @include('ratingCriteria.rating_modal.summary_modal_detail') --}}
@include('ratingCriteria.rating_modal.notify_modal')

    @include('ratingCriteria.rating_modal.rated_summary_modal')
    
    {{-- @include('ratingCriteria.rating_modal.editCriteria_modal')  --}}
@endsection
@section('scripts')
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script> --}}
<script  src="{{ asset('/js/rating/ratedApplicant.js') }}"></script>

@endsection
