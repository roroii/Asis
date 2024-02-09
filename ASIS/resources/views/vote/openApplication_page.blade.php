@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('Election Application') }}
@endsection

@section('content')

<h2 class="intro-y text-lg font-medium mt-10">
    Open Application
</h2>
<div class="grid grid-cols-12 gap-6 mt-5">

    <!-- BEGIN: Data List -->
    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
        <table id="openClose_tbl" class="table table-report -mt-2">
            <thead>
                <tr>
                    <th class="text-center whitespace-nowrap">#</th>
                    <th class="text-center whitespace-nowrap">VOTING TYPE</th>
                    <th class="text-center whitespace-nowrap">STATUS</th>
                    {{-- @if(auth()->user()->role == 'Admin') --}}
                    <th class="text-center whitespace-nowrap">ACTION</th>
                    
                    {{-- @endif --}}

                </tr>
            </thead>
            <tbody>
                {{-- <tr class="intro-x">
                    <td class="w-40">
                        #
                    </td>
                    <td>
                        <a href="" class="font-medium whitespace-nowrap">Samsung Galaxy S20 Ultra</a>
                        <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5"> &nbsp; Smartphone &amp; Tablet</div>
                    </td>
                    <td class="text-center">50</td>
                </tr> --}}
            </tbody>
        </table>
    </div>
    <!-- END: Data List -->    
</div>

@include('vote.voteModals.applyModal')
@include('vote.voteModals.candidateListModal')
@include('vote.voteModals.openVoting')
@include('vote.delete_modal.deleteModal')

@endsection

@section('scripts')

    {{-- @livewireScripts
    @powerGridScripts
    {{-- <script src="{{BASEPATH()}}/js/student/examinees_list.js{{GET_RES_TIMESTAMP()}}"></script> --}}
    {{-- <script src="{{BASEPATH()}}/js/dropdown.js{{GET_RES_TIMESTAMP()}}"></script> --}}
    {{-- <script src="{{ asset('/js/vote/voteType.js') }}"></script> --}}
    <script src="{{ asset('/js/vote/application.js') }}"></script>
    <script src="{{ asset('/js/vote/vote_delete.js') }}"></script>
    {{--  <script src="{{ asset('js/medium-zoom-master/medium-zoom.js') }}"></script>  --}}

@endsection
