@extends('layouts.app')
@section('breadcrumb')
    {{ Breadcrumbs::render('Dashboard') }}
@endsection
@section('content')

<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Final List Applicant
    </h2>
    {{-- <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
        <a  target="_blank" href="/rating/print-summary" class="btn btn-primary shadow-md mr-2">Print</a>

    </div> --}}
</div>

<form id="saveRate_form" enctype="multipart/form-data">
    @csrf


    <div class="intro-y flex flex-col sm:flex-row items-center mt-4">
        <div class="w-full mr-2">
            <label for="position">Select Position:</label>
            <select id="active_position" name="active_position" class="select2 form-control ">
                <option selected></option>
                <option value="all" selected>All</option>
                @foreach (get_position() as $position)

                    <option value="{{ $position->id }}">{{ $position->emp_position }}</option>

                @endforeach

            </select>

        </div>



    </div>


    <div class="intro-y box p-5 mt-5 form-control">

        <div id="select_Applicant_div">

        </div>



        </div>

    </div>

</form>
@include('ratingCriteria.rating_modal.listed_modal')
@include('ratingCriteria.rating_modal.notify_modal')
@include('ratingCriteria.rating_modal.selection_modal')

    {{-- @include('ratingCriteria.rating_modal.approve_modal') --}}
    {{-- @include('ratingCriteria.rating_modal.editCriteria_modal')  --}}
@endsection
@section('scripts')
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script> --}}
<script  src="{{ asset('/js/rating/ratedApplicant.js') }}"></script>

@endsection
