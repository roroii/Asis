@php
use App\Models\Hiring\tblpanels;
use App\Models\rating\ratedCriteria_model;
@endphp
<!doctype html>
<html lang = "en">
    <head>
        <meta charset = "UTF-8">
        <title>{{ $filename }}</title>
        <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
        <style type = "text/css">
            /** Define the margins of your page **/

            @page {
                    margin: 30px 0px 30px 0px;
                }
            body { margin: 30px 30px 30px 30px;
            }

        * {
                font-family: Arial, Helvetica, sans-serif;
            }

            a {
                color          : #fff;
                text-decoration: none;
            }

            table {
                font-size: medium;
            }

            header {
                position: fixed;
                top: -40px;
                left: 0px;
                right: 0px;
                height: 20px;
                /** Extra personal styles **/
                color: white;
                text-align: center;
                line-height: 35px;
            }
            footer {
                position: fixed;
                bottom: 70px;
                left: 0px;
                right: 0px;
                height: 50px;
                /** Extra personal styles **/
                color: rgb(0, 0, 0);
                text-align: center;
                line-height: 35px;
            }

            .invoice table {
                margin: 15px;
            }
            .invoice h3 {
                margin-left: 5px;
            }

            .information .logo {
                margin: 30px;
            }
            .information table {
                padding-top: 80px;

            }
            .header_div table.header_table {
                border: 1px solid #ddd;

            }

            .main_tbl{
                border: 1px solid #ddd;
                border-collapse: collapse;
                width: 100%;
            }
            .main_tbl td{
                border: 1px solid #ddd;
                border-collapse: collapse;

        }

 
        </style>
    </head>
        <!-- Define header and footer blocks before your content -->
    <body>

        <header>
            @if ($system_image_header)

            <img   class = "scale-down" src = "uploads/settings/{{ $system_image_header->image }}" style = "width:100%">
            @else
            <img   class = "scale-down" src = "" style = "width:100%">
            @endif

        </header>

        <footer>
            <br>
                <table style="width: 100%">

                    <tr style="text-align: center">
                        <td>
                            <span> This is a (e-HRIS) generated report:</span> <strong>{{ $current_date }} </strong>
                        </td>
                        <td>
                            Page <span class="pagenum"></span>
                        </td>
                    </tr>
                </table>
                @if ($system_image_footer)

                    <img   class = "scale-down" src = "uploads/settings/{{ $system_image_footer->image }}" style = "width:100%">
                @else
                    <img   class = "scale-down" src = "" style = "width:100%">
                @endif
        </footer>
        <main>

                <div  class = "information">
                    <table style="margin-bottom: 20px" style="font-size: 10px"  width = "100%">
                        <tbody>
                            <tr>
                                <th class="summary" style="padding-bottom: 30px;" colspan="2"><h1>Summary of Rating</h1> </th>
                            </tr>
                            <tr>

                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="header_div">

                    <table class="header_table" style="width: 100%;" >
                        <tr>
                            <td style="width: 50%; padding-bottom: 5px">
                                <div>Ratee: </div>
                            </td>
                            <td style="width: 50%; padding-bottom: 5px">
                                <div>Position Applied: </div>
                            </td>
                        </tr>

                        <tr>
                            <td style="padding-bottom: 10px;font-size:large ; padding-left:30px">{{$details->get_applicant_profile->lastname }}, {{$details->get_applicant_profile->firstname}}</td>
                            <td style="padding-bottom: 10px;font-size:large ; padding-left:30px">{{$details->get_positionee->emp_position }}</td>
                        </tr>

                    </table>
                </div>

                <div class="panel_div">
                    <table class="main_tbl" style="width: 100%;">
                        <tr style="border: 1px solid #ddd; border-collapse: collapse;">
                          <th style=" height: 40px; border-right: 1px solid #ddd" colspan="2">Criteria/s</th>


                            <th colspan="{{ $rated_applicant_length }}">Rater</th>


                            <th style="border: 1px solid #ddd; border-collapse: collapse;" rowspan="2">TOTAL POINTS</th>
                        </tr>
                        <tr>
                            <th style="border: 1px solid #ddd; text-align:left">Criteria/s :</th>
                            <th style="text-align:center; border-right: 1px solid #ddd">Max Score</th>

                            @foreach($detailed as $applicant_detail)
                                {{-- {{ dd($applicant_detail) }} --}}

                                @php
                                    $check_panels = tblpanels::where('available_ref', $applicant_detail->applicant_job_ref)
                                                                ->where('panel_id', $applicant_detail->rater_agency_id);
                                            // dd($check_panels);
                                            $panel_name = '---';
                                            if($check_panels->exists()){
                                            //   dd($check_panels->get());
                                            $check_paneled = $check_panels->get();
                                                foreach($check_paneled as $panels){
                                                    // dd($panels);
                                                    if($panels != "" || $panels->active != null || $panels->active != 0){
                                                        // dd("naaa.x");
                                                        $panel_name = $panels->get_employee->lastname.', ' .$panels->get_employee->firstname.' ' .$panels->get_employee->mi;
                                                    }else{
                                                        $panel_name = 'Rater is No longer a Panel';
                                                    }

                                                }
                                            }else{
                                                $panel_name = $applicant_detail->get_rater_profile->lastname.', ' .$applicant_detail->get_rater_profile->firstname.' ' .$applicant_detail->get_rater_profile->middlename;
                                            }
                                            // dd($panel_name);
                                @endphp

                                <th>{{ $panel_name }}</th>

                            @endforeach

                        </tr>
                            @foreach($criterias as $criteria)
                                @php
                                    $criteria_content ='';
                                    if($criteria->competency_id != null){
                                        if($criteria->get_competency){
                                            $competency = $criteria->get_competency;
                                            $criteria_content = $competency->name;
                                        }
                                    }else{
                                        $criteria_content = $criteria->creteria;
                                    }

                                    

                                    //Get Percent

                                        $total_criteria_rates = ratedCriteria_model::where('criteria_id', $criteria->id)
                                                    ->where('applicant_id', $details->applicantID)
                                                    ->where('applicant_job_ref',$details->applicant_job_ref)
                                                    ->where('short_listID', $details->applicant_listID)
                                                    ->get();
                                        $total_criteria_rate = ratedCriteria_model::where('criteria_id', $criteria->id)
                                                ->where('applicant_id', $details->applicantID)
                                                ->where('applicant_job_ref',$details->applicant_job_ref)
                                                ->where('short_listID', $details->applicant_listID)
                                                ->sum('rated');

                                        $max_rate = number_format($criteria->maxrate);
                                        $max_percent = $max_rate / 100;
                                        $max_sum = $max_rate * $rated_applicant_length;
                                        // dd($max_percent);

                                        // $total_criteria_rate_length = $total_criteria_rates->count();

                                        $division_of_total = ($total_criteria_rate/$max_sum) * 100;
                                        // dd($division_of_total);
                                        $t_percent = round((float) $division_of_total * $max_percent );
                                        $all_percentages[] = $t_percent;

                                        $total_percent = 0;

                                        for($i = 0; $i < count($all_percentages); $i++){
                                            $total_percent += $all_percentages[$i];
                                        }
                                    //End of Get Percent
                                    $points = '';
                                    $points_percent = '';
                                    $final_points = '';
                                    $total_average = 0;
                                    $final_average = 0;
                                    //Get Average

                                     $average =  $total_criteria_rate/$rated_applicant_length;
                                        // dd( $average);
                                        
                                        $arrayAverage[] = $average;

                                        for ($i=0; $i < count($arrayAverage); $i++) { 
                                            $total_average += $arrayAverage[$i];
                                        }
                                      $final_average = $total_average/count($arrayAverage);
                                    //End of Get Average

                                    if($rated_check_in_value !=0){
                                        $points = $t_percent.'%';
                                        $final_points =  $total_percent.'%';
                                        $points_percent = '%';
                                    }else{
                                        $points = $average;
                                        $final_points =  $final_average;
                                        $points_percent = '';
                                    }
                                   
                                @endphp
                                {{-- Begin of Criteria Looping --}}
                                <tr>
                                    <td style="width:30%; height: 40px">{{$criteria_content}}</td>
                                    <td style=" text-align:center; height: 40px">{{$criteria->maxrate.''.$points_percent}}</td>

                                    {{-- Looping of the Rate --}}
                                    @foreach($detailed as $dtl)
                                        @php

                                            $criterias_rates = ratedCriteria_model::where('criteria_id', $criteria->id)
                                                                ->where('applicant_id', $dtl->applicantID)
                                                                ->where('rated_by', $dtl->rated_by)
                                                                ->where('applicant_job_ref',$dtl->applicant_job_ref)
                                                                ->get();


                                            foreach($criterias_rates as $criterias_rate){

                                                $rate = '';
                                                if($criterias_rate){
                                                    $yourRate = $criterias_rate->rated;
                                                    if($yourRate == 0 || $yourRate =='' ){
                                                    $rate = '--';
                                                    }else{
                                                        $rate = $criterias_rate->rated;
                                                    }
                                                }else{
                                                    $rate = '--';
                                                }
                                                // $output .= '<td>'.$rate.'</td>';


                                            }


                                        @endphp
                                        <td style="text-align: center">{{$rate.''.$points_percent}}</td>

                                    @endforeach
                                    <td style="text-align: center">{{ $points}} </td>
                                    {{--End of Looping the Rate --}}
                                </tr>
                            @endforeach
                        </tr>
                    <tr style="text-align:center">
                        <td style="width: 30%; height: 60px">Total Points </td>
                        <td style="width: 5%; height: 60px">{{ $maxPoints }}</td>

                            <td colspan ="{{ $rated_applicant_length }}" style=" text-align:right;"></td>

                        <td style=" height: 20px; text-align:center; text-bold: 1px solid"> {{$final_points}}</td>


                    </tr>
                    {{--End Begin of Criteria Looping --}}
                    </table>
                </div>

        </main>


    </body>

    </html>
