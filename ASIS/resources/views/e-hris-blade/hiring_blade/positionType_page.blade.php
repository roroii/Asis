@extends('layouts.app')
@section('breadcrumb')
    {{ Breadcrumbs::render('Dashboard') }}
@endsection
@section('content')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Position Type
        </h2>
        <div class="relative text-slate-500 pr-1 pt-1 mt-4">
            <button id="btn_posType_modal" class="btn btn-primary shadow-md mr-2"  data-tw-toggle="modal" data-tw-target="#add_Pos_type_modal" >Add Type</button>
        </div>
    </div>
    <div class="intro-y box p-5 mt-5">
        <div id="positioType_div" class="overflow-x-auto scrollbar-hidden pb-10">
           
        </div>
    </div>
    @include('hiring_blade.hiring_modal.add_positionType_modal')
    {{-- @include('hiring_blade.hiring_modal.delete_modal') --}}
@endsection

@section('scripts')
<script src="{{ asset('js/hiring_js/positionType.js') }}"></script>
@endsection

