@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('Vote Type') }}
@endsection

@section('content')



@include('vote.voteModals.voters_modal')


@endsection
@section('scripts')
<script src="{{BASEPATH()}}/js/ASIS_student_ledger/student_ledger.js{{GET_RES_TIMESTAMP()}}"></script>
@endsection
