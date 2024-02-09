@extends('layouts.app')
@section('breadcrumb')
    {{ Breadcrumbs::render('Dashboard') }}
@endsection
@section('content')

<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Applicable Aplicant
    </h2>
    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
        {{-- <button class="btn btn-primary shadow-md mr-2 addCriteria" data-tw-toggle="modal" data-tw-target="#addCriteria_modal">Add Criteria</button> --}}

    </div>
</div>
<div class="intro-y flex flex-col sm:flex-row items-center mt-5">

    {{-- <div class="w-full sm:w-auto flex mt-4 sm:mt-0 mr-auto">
        <button id="refresh" class="btn btn-secondary mr-2">Refresh<i class="fa-solid fa-arrows-rotate text-success"></i> </button>

    </div> --}}

    {{-- <select class="form-control" id="positioncritPage" name="positioncrit" class="select2 w-full">
        <option selected></option>
        @foreach ($positionCategories as $positionCategory)


            <option value="{{ $positionCategory->id }}">{{ $positionCategory->positiontype }}</option>


        @endforeach
    </select> --}}

</div>

<div class="intro-y box p-5 mt-5">

    <div id="tbl_applicant_rated_div" class="overflow-x-auto scrollbar-hidden pb-10">

    </div>
</div>

 <!-- BEGIN: Modal Toggle -->
 {{-- <div class="text-center"> <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#warning-modal-preview" class="btn btn-primary">Show Modal</a> </div> <!-- END: Modal Toggle --> --}}
 <!-- BEGIN: Modal Content -->
 <div id="warning_Modal" class="modal" tabindex="-1" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-body p-0">
                 <div class="p-5 text-center"> <i data-lucide="x-circle" class="w-16 h-16 text-warning mx-auto mt-3"></i>
                     <div id="ops_id" class="text-3xl mt-5">Oops...</div>
                     <div id="warning_text" class="text-slate-500 mt-2">This Criteria Don't Have Any  Area's!</div>
                 </div>
                 <div class="px-5 pb-8 text-center"> <button type="button" data-tw-dismiss="modal" class="btn w-24 btn-primary">Ok</button> </div>
             </div>
         </div>
     </div>
 </div> <!-- END: Modal Content -->


@include('ratingCriteria.rating_modal.ratingAreas_modal')
@include('ratingCriteria.rating_modal.rateModal')

@endsection
@section('scripts')

<script  src="{{ asset('/js/rating/rating.js') }}"></script>

@endsection
