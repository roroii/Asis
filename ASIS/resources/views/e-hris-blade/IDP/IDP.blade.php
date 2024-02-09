@extends('layouts.app')
@section('breadcrumb')
    {{ Breadcrumbs::render('Dashboard') }}
@endsection
@section('content')

@php
    use App\Models\agency\agency_employees;

    $my_info = agency_employees::with('get_user_profile')->where('agency_id', auth()->user()->employee)->where('active', 1)->first();

    $position_id = '';
    $salary_grade = '';
    $no_y_position = '';
    $name = '';
    // dd( $my_info);
        if( $my_info){
            $start_date = $my_info->start_date;
            $today = date('Y-m-d');
            $date1=date_create($start_date);
            $date2=date_create($today);
            $diff=date_diff($date1,$date2);
            $year = $diff->format("%Y");
            $month = $diff->format("%M");
            $day = $diff->format("%D");

            if( $year != 00){
                
                $no_y_position =  $year;
            }else{
                // if($month != 00){
                //     $no_y_position = $month;
                // }else{
                //     if( $day != 00){
                //         $no_y_position = $day;
                //     }else{
                //         $no_y_position =  'Newly Employed';
                //     }
                    
                // }
                $no_y_position =  'Less Than a Year';
            }
            $profile = $my_info->get_user_profile;
            if( $profile){
               $name = $profile->lastname.', '.$profile->mi.' '.$profile->firstname.' '.$profile->extension;
            }
           

            // dd( $year, $month, $day );
            $position_id = $my_info->position_id;
            $salary_grade = $my_info->tranch_id;
        }else{
            $position_id = 'I am not employed to this agency';

        }
    // dd( $my_info);
@endphp

<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Individual Development Plan
    </h2>
    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
        <button class="btn btn-primary shadow-md mr-2 createIDP_class" data-name="{{ $name }}" data-year="{{  $no_y_position }}" data-salary-grade="{{ $salary_grade }}" data-position-id="{{ $position_id }}" data-tw-toggle="modal" data-tw-target="#createIDP_modal">Create IDP</button>

    </div>
</div>


<div class="intro-y box p-5 mt-5">

    <div class="overflow-x-auto scrollbar-hidden pb-10">
        <table id="idp_table" class="table table-report -mt-2 table-hover">
            <thead>
            <tr>
                <th class="text-center whitespace-nowrap">#</th>
                <th class="text-center whitespace-nowrap">Year</th>
                <th class="text-center whitespace-nowrap">Development Target</th>
                <th class="text-center whitespace-nowrap">Development Activity</th>
                {{-- <th class="text-center whitespace-nowrap">Approving Officer/s</th> --}}
                <th class="text-center whitespace-nowrap">Action</th>
            </tr>
            </thead>
            <tbody>

            </tbody>

        </table>
    </div>
</div>

    @include('IDP.idp_modal.createIDP_modal')
    @include('IDP.idp_modal.addDev_priorities_modal')
    @include('IDP.idp_modal.addDevelopment_activity_modal')
    @include('IDP.idp_modal.activityPlan_modal')
@endsection
@section('scripts')
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script> --}}

<script  src="{{ asset('/js/IDP/idp_page.js') }}"></script>

@endsection
