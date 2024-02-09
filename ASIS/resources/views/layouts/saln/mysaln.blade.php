@extends('layouts.app')
@section('content')

    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            SWORN STATEMENT OF ASSETS, LIABILITIES AND NET WORTH
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <button id="make_saln" class="btn btn-primary shadow-md mr-2" href="javascript:;" data-tw-toggle="modal" data-tw-target="#add_saln_modal">Make SALN</button>
        </div>
    </div>
    <div class="intro-y box p-5 mt-5">

        <div class="overflow-x-auto scrollbar-hidden pb-10">
            <table id="dt__created_saln" class="table table-report -mt-2 table-hover">
                <thead>
                <tr>
                    <th style="display: none" class="text-center whitespace-nowrap ">#ID</th>
                    <th class="text-center whitespace-nowrap ">DECLARANT</th>
                    <th class="text-center whitespace-nowrap ">DATE</th>
                    <th class="text-center whitespace-nowrap ">TOTAL LIABILITIES</th>
                    <th class="text-center whitespace-nowrap ">TOTAL ASSESTS</th>
                    <th class="text-center whitespace-nowrap ">NET WORTH</th>
                    <th class="text-center whitespace-nowrap ">Action</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    @include('saln.modal.add_modal')
@endsection
@section('scripts')
<script src="{{ asset('/js/saln/saln.js') }}"></script>
@endsection

