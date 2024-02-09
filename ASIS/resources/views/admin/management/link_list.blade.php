@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('Link List') }}
@endsection

@section('content')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Link List
        </h2>
    </div>
    <div class="intro-y box p-5 mt-5">
        <div class="overflow-x-auto scrollbar-hidden pb-10">
            <table id="dt__link_list" class="table table-report -mt-2 table-hover">
                <thead>
                <tr>
                    <th  class="text-center whitespace-nowrap ">#ID</th>
                    <th class="text-center whitespace-nowrap ">Module Name</th>
                    <th class="text-center whitespace-nowrap ">Link</th>
                    <th class="text-center whitespace-nowrap ">Action</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    @include('admin.management.mngmodal')
@endsection
@section('scripts')
    <script src="{{ asset('/js/link_list.js') }}"></script>
@endsection
