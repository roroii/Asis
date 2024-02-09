@extends('layouts.app')

@section('content')
    <h2 class="intro-y text-lg font-medium mt-10">
        Overview
    </h2>



@endsection

@section('scripts')
    <script src="{{BASEPATH()}}/js/rr/rewards.js{{GET_RES_TIMESTAMP()}}"></script>
@endsection()
