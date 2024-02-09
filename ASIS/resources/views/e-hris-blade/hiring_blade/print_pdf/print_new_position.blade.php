<!doctype html>
<html lang = "en">
    <head>
        <meta charset = "UTF-8">
        @if (system_settings()->where('key','agency_name')->first())
        @php
            $system_setting = system_settings()->where('key','agency_name')->first();
        @endphp

            @if ($system_setting->value)
                <title>{{ $system_setting->value }}</title>
            @else
                <title>N/A</title>
            @endif

            @else
                <title>N/A</title>
            @endif
        <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">

        <style type = "text/css">
            /** Define the margins of your page **/
            @page {
                    margin: 0px 0px 0px 10px;
                  }
            body { margin: 10px 30px;
            }

            * {
                font-family: Arial, Helvetica, sans-serif;
            }

            a {
                color          : #fff;
                text-decoration: none;
            }

            table {
                font-size: x-small;
            }

            header {
                position: fixed;
                top: -53px;
                left: 0px;
                right: 0px;
                height: 50px;
                /** Extra personal styles **/
                background-color: #03a9f4;
                color: white;
                text-align: center;
                line-height: 35px;
            }
            footer {
                position: fixed;
                bottom: 20px;
                left: 0px;
                right: 0px;
                height: 50px;
                /** Extra personal styles **/
                background-color: #03a8f400;
                color: rgb(0, 0, 0);
                text-align: center;
                line-height: 35px;
            }
            .my-table
            {
            border-collapse: collapse;
            width: 100%;
            }
            .my-table td
            {
            padding: 0.5rem;
            border-collapse: collapse;
             }
             .new_table
             {
                border-collapse: collapse;
                border: 1px solid black;
                width: 100%;
             }
             .new_table td
             {
                border-collapse: collapse;
                border: 1px solid black;
                width: 500%;
             }
           .text-center
            {
                text-align: center;
            }
            .text-left
            {
                text-align: left;
            }
            .border
            {
                border: 1px solid black
            }
            .bold
            {
                font-weight: bold;
            }
            .italic
            {
                font-style: italic;
            }
            .new_table
            {
                border: 1px solid black;
                border-collapse: collapse;
            }
            .new_table th
            {
                border-collapse: collapse;
            }
            .new_table td
            {
                border-collapse: collapse;
            }

            .header_div table.header_table {
                border: 1px solid #ddd;
            }

        </style>
    </head>
        <!-- Define header and footer blocks before your content -->
    <body>
            <table class="my-table" >
                <tr class="border-left border-right border-top">
                    <td style="padding-left: 5px">
                        <div class="bold" style="font-style: italic; font-size: 13px">CS Form No. 9</div>
                        <div class="bold" style="font-style: italic; font-size: 11px; padding">Revised 2018</div>
                    </td>
                    <td>
                        <div class="italic text-center" style="font-size: 10px; padding-left: 60%;" > Electronic copy to be submitted to the CSC FO must be in MS Excel Format</div>
                    </td>
                </tr>
            </table>

            <div class="text-center" style="margin-top: 0%">
                    <div class="text-center" style="font-size: 11px">
                            Republic of the Philippines
                </div>
                    <div class="text-center italic" style="font-size: 14px; margin">
                        @if(system_settings())
                        @php
                            $system_title = system_settings()->where('key','agency_name')->first();
                        @endphp
                        @endif

                        @if($system_title)
                        <span style="text-transform: uppercase;">{{ $system_title->value }}</span>
                        @else
                        No title added
                        @endif
                    </div>
                <div>
                    <div class="text-center" style="font-size: 11px">
                        Request for Publication of Vacant Positions
                    </div>
                </div>
            </div>

                <div style="margin-top: 2%">
                        <div style="font-size: 11px">
                            To: CIVIL SERVICE COMMISSION (CSC)
                        </div>
                        <div style="font-size: 12px; margin-top: 1%;text-align: justify;text-justify: inter-word;">
                            @if(system_settings())
                            @php
                                $system_title = system_settings()->where('key','agency_name')->first();
                            @endphp
                            @endif

                            @if($system_title)
                            We hereby request the publication of the following vacant positions, which are authorized to be filled, at the <span style="text-transform: uppercase;">{{ $system_title->value }}</span> in the CSC website:
                            @else
                            No title added
                            @endif
                        </div>
                </div>

            <div style="margin-top:2%; margin-left: 68%">
                    <div style="font-size: 12px" class="text-center">
                        @if( strtoupper(get_HRMO($get_job_info_custom->email_through)))
                        {{ strtoupper(get_HRMO($get_job_info_custom->email_through)->firstname)}}
                        {{ strtoupper(get_HRMO($get_job_info_custom->email_through)->mi)}}
                        {{ strtoupper(get_HRMO($get_job_info_custom->email_through)->lastname)}}
                        @else
                        N/A
                        @endif
                    </div>
                    <div style="margin-top: -2%;margin-left: 20%">
                        <div style="width: 80%;"><hr style="height:1px;border-width:0;color:black;background-color:black;"></div>
                    </div>
                        <div style="font-size: 13px;margin-top: -2%" class="text-center bold">
                            {{ get_HRMO_Position($get_job_info_custom->email_through) }}
                        </div>
                    <div id="date" style="font-size: 13px;margin-top: 3%">
                        Date: <span style="margin-left: 30%">
                            {{-- @if($get_job_info_custom->post_date)
                            <span style="font-weight: bold">{{ $get_job_info_custom->post_date }}</span>
                           @else
                           No Posting date posted
                           @endif --}}
                           @if($date)
                           <span style="font-weight: bold">{{ $date }}</span>
                          @else
                          No Posting date posted
                          @endif
                        </span>
                    </div>
                        <div style="margin-top: -2%; margin-left: 4%">
                            <div style="width: 80%;"><hr style="height:1px;border-width:0;color:black;background-color:black; margin-left: 20%;"></div>
                        </div>
            </div>

            <table class="new_table" style="margin-top: 1%;width:100%" border="1">
                <thead>
                    <tr>
                        <td rowspan="2" class="text-center" style="width: 10%">
                            <div>
                                No
                            </div>
                        </td>
                         <td rowspan="2" style="width:">
                            <div class="text-center"> Position Title</div>
                            <div class="bold text-center">(Parenthetical Title, if applicable)</div>
                        </td>
                        <td rowspan="2" style="">
                            <div class="text-center">Plantilla Item No.</div>
                        </td>
                        <td rowspan="2" style="width:%">
                            <div class="text-center">Salary/ Job/ Pay Grade</div>
                        </td>
                        <td rowspan="2" style="width:%">
                            <div class="bold text-center">Monthly Salary</div>
                        </td>
                        <td style="width:%" colspan="5" >
                            <div class="text-center">Qualification Standards</div>
                        </td>
                        <td rowspan="2" style="width:%">
                            <div class="text-center">Place of Assignment</div>
                        </td>
                    </tr>

                    <tr>
                        <td style="width:%">
                            <div class="text-center">Education</div>
                        </td>
                        <td style="width:%">
                            <div class="text-center">Training</div>
                        </td>
                        <td style="width:%">
                            <div class="text-center">Experience</div>
                        </td>
                        <td style="width:%">
                            <div class="text-center">Eligibility</div>
                        </td>
                        <td style="width:%">
                            <div class="text-center">Competency (if applicable)</div>
                        </td>

                    </tr>
                </thead>


                <tbody>
                    <tr>
                        <td style="width: 10%">
                            1
                        </td>
                        <td style="width: 3%;text-align: justify;text-justify: inter-word;" class="">
                            @if($get_job_info_custom->pos_title)
                            {{get_position_title($get_job_info_custom->pos_title)->emp_position}}
                            @else
                            N/A
                            @endif
                        </td>
                        <td style="width: 3%" class="text-center">
                            @if($get_educ_rec_custom->item_no)
                            {{ $get_educ_rec_custom->item_no}}
                            @else
                            N/A
                            @endif
                        </td>
                        <td style="width: 8%" class="text-center">
                            @if($get_job_info_custom->sg)
                            {{ get_SG($get_job_info_custom->sg)->code}}
                            @else
                            N/A
                            @endif
                        </td>
                        <td class="text-center">
                            @if($get_job_info_custom->salary)
                            Php {{ $get_job_info_custom->salary }}
                            @else
                            N/A
                            @endif
                        </td>
                        <td class="text-center" style="text-align: justify;text-justify: inter-word;">
                            @if($get_educ_rec_custom->educ)
                            {{ $get_educ_rec_custom->educ }}
                            @else
                            N/A
                            @endif
                        </td>
                        <td class="text-center">
                            @if($get_educ_rec_custom->training)
                            {{ $get_educ_rec_custom->training }}
                            @else
                            N/A
                            @endif
                        </td>
                        <td >
                            @if($get_educ_rec_custom->work_ex)
                            {{ $get_educ_rec_custom->work_ex }}
                            @else
                            N/A
                            @endif
                        </td>
                        <td>
                            @if($get_educ_rec_custom->eligibility)
                            {{ $get_educ_rec_custom->eligibility }}
                            @else
                            N/A
                            @endif
                        </td>
                        <td>
                            @forelse (get_competency($get_job_info_custom->jobref_no) as $competency )
                            {{$competency->comp_list}}
                            @empty
                                N/A
                            @endforelse
                        </td>
                        <td class="text-center">
                            @if($get_job_info_custom->assign_agency)
                            {{ $get_job_info_custom->assign_agency }}
                            @else
                            N/A
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>


         <div style="margin-top: 2%">
            <div style="font-size: 12px;text-align: justify;text-justify: inter-word;">
                @if($get_doc_req_custom->remarks )
                {{ $get_doc_req_custom->remarks }}
                @else
                N/A
                @endif
                {{-- @if($get_job_info_custom->close_date)
                <u class="" style="font-weight: bold;">{{ $get_job_info_custom->close_date }}</u>
               @else
               No Closing date posted
               @endif --}}
            </div>
         </div>

        <div style="margin-top: 2%; margin-left: 2%; text-align: justify;text-justify: inter-word;" >
            @php($num=1)
            @forelse (get_Documents_requirements($get_job_info_custom->jobref_no) as $docs)
                <div style="font-size: 12px">
                     {{ $num++ }}. <span class="ml-2">{{$docs->doc_requirements }}</span>
                </div>
            @empty
            @endforelse
        </div>

        <div style="margin-top: 2%;font-size: 12px">
            <div><span style="font-weight: bold">QUALIFIED APPLICANTS</span> are advised to hand in or send through courier/email their application to:</div>
        </div>

        <div>
            <div style="margin-left: 3%;margin-top: 2%">
                <div style="margin-left: 3%;font-size: 12px; font-weight: bold;">
                    {{ $get_org_head }}
                </div>
                <div style="width: 25%; margin-top: -0.5%">
                    <hr style="height:1px;border-width:0;color:black;background-color:black;">
                </div>
            </div>
            <div style="margin-left: 3%;margin-top: -0%">
                <div style="margin-left: 3%;font-size: 13px;font-wieght: bold">
                    {{ $get_org_head_pos }}
                </div>
                <div style="width: 25%; margin-top: -0.5%">
                    <hr style="height:1px;border-width:0;color:black;background-color:black;">
                </div>
            </div>
            <div style="margin-left: 3%;margin-top: -0%">
                <div style="margin-left: 3%;font-size: 13px;font-wieght: bold">
                    @if($get_job_info_custom->address)
                    {{ $get_job_info_custom->address }}
                   @else
                   N/A
                   @endif
                </div>
                <div style="width: 25%; margin-top: -0.5%">
                    <hr style="height:1px;border-width:0;color:black;background-color:black;">
                </div>
            </div>
            <div style="margin-left: 3%;margin-top: -0%">
                <div style="margin-left: 3%;font-size: 13px;font-wieght: bold;color:blue">
                    @if($get_job_info_custom->email_add)
                    {{ $get_job_info_custom->email_add }}
                   @else
                   No email address attached
                   @endif
                </div>
                <div style="width: 25%; margin-top: -0.5%">
                    <hr style="height:1px;border-width:0;color:black;background-color:black;">
                </div>
            </div>
        </div>

        <div style="margin-top: 2%;font-size: 12px;font-weight:bold">
            APPLICATIONS WITH INCOMPLETE DOCUMENTS SHALL NOT BE ENTERTAINED.
        </div>

        </body>
    </html>
