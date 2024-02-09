@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('Vote') }}
@endsection

@section('content')

<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12">
        <div class="grid grid-cols-12">

            <!-- BEGIN: Weekly Top Products -->
            <div class="col-span-12 mt-6">
                <h2 class="intro-y text-lg font-medium mt-10">
                    Election Participants
                </h2>
                <div class="grid grid-cols-12 gap-6 mt-5">

                    <!-- BEGIN: Data List -->
                    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                        <table id="participants_tbl" class="table table-report -mt-2">
                            <thead>
                                <tr>
                                    <th class="text-center whitespace-nowrap">#</th>
                                    <th class="text-center whitespace-nowrap">VOTING TYPE</th>
                                    <th class="text-center whitespace-nowrap">STATUS</th>
                                    <th class="text-center whitespace-nowrap">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <!-- END: Data List -->

                </div>
                 @include('vote.voteModals.voteParticipants_Modal')
            {{--    @include('vote.delete_modal.deleteModal') --}}
            </div>
            <!-- END: Weekly Top Products -->
        </div>
    </div>
</div>

@endsection

@section('scripts')

    {{-- @livewireScripts
    @powerGridScripts
    {{-- <script src="{{BASEPATH()}}/js/student/examinees_list.js{{GET_RES_TIMESTAMP()}}"></script> --}}
    {{-- <script src="{{BASEPATH()}}/js/dropdown.js{{GET_RES_TIMESTAMP()}}"></script> --}}
    <script src="{{ asset('/js/vote/vote_participants.js') }}"></script>
    <script src="{{ asset('/js/vote/vote_delete.js') }}"></script>

@endsection
