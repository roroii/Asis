@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('Vote Position') }}
@endsection

@section('content')

<h2 class="intro-y text-lg font-medium mt-10">
    Voting Position
</h2>
<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
        <button class="btn btn-primary shadow-md mr-2 ml-auto" data-tw-toggle="modal" data-tw-target="#assignPosition_modal">Manage Position</button>
        <div class="dropdown">
            <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i> </span>
            </button>
            <div class="dropdown-menu" style="width: 200px">
                <ul class="dropdown-content">
                    <li>
                        <a href="javascript:;" class="dropdown-item" data-tw-toggle="modal" data-tw-target="#votePosition_modal"> <i data-lucide="printer" class="w-4 h-4 mr-2"></i> Create New Position </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>



    {{--  <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
        <button class="btn btn-primary shadow-md mr-2 ml-auto" data-tw-toggle="modal" data-tw-target="#assignPosition_modal">Manage Position</button>
        <div class="dropdown">
            <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i> </span>
            </button>
            <div class="dropdown-menu w-40">
                <ul class="dropdown-content">
                    <li>
                        <a href="" class="dropdown-item"> <i data-lucide="printer" class="w-4 h-4 mr-2"></i> Print </a>
                    </li>
                    <li>
                        <a href="" class="dropdown-item"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export to Excel </a>
                    </li>
                    <li>
                        <a href="" class="dropdown-item"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export to PDF </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>  --}}


    <!-- BEGIN: Data List -->
    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
        <table id="votePosition_tbl" class="table table-report -mt-2">
            <thead>
                <tr>
                    <th class="text-center whitespace-nowrap">#</th>
                    <th class="text-center whitespace-nowrap">POSITION</th>
                    <th class="text-center whitespace-nowrap">ACTION</th>
                </tr>
            </thead>
            <tbody>


            </tbody>
        </table>
    </div>
    <!-- END: Data List -->

</div>

{{-- @include('vote.voteModals.voteType_modal') --}}
@include('vote.voteModals.assignPosition_modal')
@include('vote.voteModals.voteposition_modal')
@include('vote.delete_modal.deleteModal')

@endsection

@section('scripts')

    {{-- @livewireScripts
    @powerGridScripts
    {{-- <script src="{{BASEPATH()}}/js/student/examinees_list.js{{GET_RES_TIMESTAMP()}}"></script> --}}
    {{-- <script src="{{BASEPATH()}}/js/dropdown.js{{GET_RES_TIMESTAMP()}}"></script> --}}
    <script src="{{ asset('/js/vote/voteType.js') }}"></script>
    <script src="{{ asset('/js/vote/vote_delete.js') }}"></script>

@endsection
