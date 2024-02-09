<!doctype html>
<html lang = "en">
    <head>
        <meta charset = "UTF-8">
        {{-- @if (system_settings()->where('key','agency_name')->first())
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
            @endif --}}
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
            .font
            {
                font-family: Arial, Helvetica, sans-serif;
            }

        </style>
    </head>
        <!-- Define header and footer blocks before your content -->
    <body>
            <table class="my-table">
                <tr>
                    <td colspan="2" style="font-size: 9px; font-style: italic;font-family:Arial, Helvetica, sans-serif">
                        CS Form No. 9
                    </td><td>
                    </td><td>
                    </td><td>
                    </td><td>
                    </td><td>
                    </td>
                    <td colspan="5" style="font-size: 8px;font-style:italic;font-family:Arial, Helvetica, sans-serif;border: 10px solid #000000;font-align:center">
                        Electronic copy to be submitted to the CSC FO must be in MS Excel Format
                    </td>
                </tr>
                <tr>
                    <td style="font-style: italic">Revised 2018</td>
                </tr>
            </table>

            <table>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="6" style="text-align: center;font-size: 11px;font-family:Arial, Helvetica, sans-serif">
                        <div>Republic of the Philippines</div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="6" style="text-align: center;font-weight: bold;font-size: 14px;font-style: italic;font-family:Arial, Helvetica, sans-serif;text-transform:uppercase;">
                        @if(system_settings())
                        @php
                            $system_title = system_settings()->where('key','agency_name')->first();
                        @endphp
                        @endif

                        @if($system_title)
                       {{ $system_title->value}}
                        @else
                        No added title can be found
                        @endif
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="6" style="text-align: center;font-size: 11px;font-family:Arial, Helvetica, sans-serif">
                        <div>Request for Publication of Vacant Positions</div>
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td colspan="4" style="font-size: 11px;font-family:Arial, Helvetica, sans-serif">
                        To: CIVIL SERVICE COMMISSION (CSC)
                    </td>
                </tr>
                <tr>

                </tr>
                <tr>
                    <td></td>
                    <td colspan = "12" rowspan="2" style="font-size: 11px;font-family:Arial, Helvetica, sans-serif;vertical-align: top">
                        @if(system_settings())
                        @php
                            $system_title = system_settings()->where('key','agency_name')->first();
                        @endphp
                        @endif
                        @if($system_title)
                        We hereby request the publication of the following vacant positions, which are authorized to be filled, at the
                        {{ $system_title->value }}
                        in the CSC website:
                        @else
                        No title added
                        @endif
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="3" style="font-size: 11px;font-family:Arial, Helvetica, sans-serif;border-bottom: 10px solid #000000;text-align:center">
                        @if( strtoupper(get_HRMO($get_job_info_custom->email_through)))
                        {{ strtoupper(get_HRMO($get_job_info_custom->email_through)->firstname)}}
                        {{ strtoupper(get_HRMO($get_job_info_custom->email_through)->mi)}}
                        {{ strtoupper(get_HRMO($get_job_info_custom->email_through)->lastname)}}
                        @else
                        HR is not set
                        @endif
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="3" style="text-align: center"><strong>
                        @if(get_HRMO_Position($get_job_info_custom->email_through))

                            {{ get_HRMO_Position($get_job_info_custom->email_through) }}
                        @else

                            HR position is not set
                        @endif
                    </strong>
                    </td>
                </tr>
                <tr></tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right">Date:</td>
                    <td colspan="3" style="border-bottom: 10px solid #000000;text-align: center">
                        @if($date)
                        <strong>{{ $date }}</strong>
                       @else
                       No date available
                       @endif
                    </td>
                </tr>
            </table>

            <table style="height: 40px">
                <thead>
                    <tr>
                        <td rowspan="2" style="width:5px;text-align:center;border: 5px solid #000000;vertical-align: top;">
                            No
                        </td>
                         <td rowspan="2" style="width:100px;border: 10px solid #000000;text-align:  center;font-size: 11px;font-family:Arial, Helvetica;vertical-align: top;word-wrap:break-word;">
                            <div class="text-center"> Position Title</div>
                            {{-- <div class="bold text-center" style="font-weight: bold">(Parenthetical Title, if applicable)</div> --}}
                        </td>
                        <td rowspan="2" style="width:100px; text-align: center;border: 10px solid #000000;font-size: 11px;font-family:Arial, Helvetica;vertical-align: top;word-wrap:break-word">
                            <div class="text-center">Plantilla Item No.</div>
                        </td>
                        <td rowspan="2" style="width:100px; text-align: center;border: 10px solid #000000;font-size: 11px;font-family:Arial, Helvetica;vertical-align: top;word-wrap:break-word">
                            <div class="text-center">Salary/ Job/ Pay Grade</div>
                        </td>
                        <td rowspan="2" style="width:100px; text-align: center;border: 10px solid #000000;font-weight:bold;font-size: 11px;font-family:Arial, Helvetica;vertical-align: top;word-wrap:break-word">
                            <div>Monthly Salary</div>
                        </td>
                        <td style="width:100px; text-align: center;border: 10px solid #000000;font-size: 11px;font-family:Arial, Helvetica" colspan="5" >
                            <div class="text-center">Qualification Standards</div>
                        </td>
                        <td rowspan="2" style="width:100px; text-align: center;border: 10px solid #000000;font-size: 11px;font-family:Arial, Helvetica;vertical-align: top;word-wrap:break-word">
                            <div class="text-center">Place of Assignment</div>
                        </td>
                    </tr>

                    <tr>
                        <td style="width:100px; text-align: center;border: 10px solid #000000;font-size: 11px;font-family:Arial, Helvetica;vertical-align: top;word-wrap:break-word">
                            <div class="text-center">Education</div>
                        </td>
                        <td style="width:100px; text-align: center;border: 10px solid #000000;font-size: 11px;font-family:Arial, Helvetica;vertical-align: top;word-wrap:break-word">
                            <div class="text-center">Training</div>
                        </td>
                        <td style="width:100px; text-align: center;border: 10px solid #000000;font-size: 11px;font-family:Arial, Helvetica;vertical-align: top;word-wrap:break-word">
                            <div class="text-center">Experience</div>
                        </td>
                        <td style="width:100px; text-align: center;border: 10px solid #000000;font-size: 11px;font-family:Arial, Helvetica;vertical-align: top;word-wrap:break-word">
                            <div class="text-center">Eligibility</div>
                        </td>
                        <td style="width:100px; text-align: center;border: 10px solid #000000;font-size: 11px;font-family:Arial, Helvetica;vertical-align: top;word-wrap:break-word">
                            <div class="text-center">Competency (if applicable)</div>
                        </td>

                    </tr>
                </thead>


                <tbody>
                    <tr>
                        <td style="width: 5px;border: 10px solid #000000;text-align:center;font-size: 11px;font-family:Arial, Helvetica;word-wrap:break-word;vertical-align: top">
                            1
                        </td>
                        <td style="width: 100px;border: 10px solid #000000;font-size: 11px;font-family:Arial, Helvetica;vertical-align: top;word-wrap:break-word">
                            @if($get_job_info_custom->pos_title)
                            {{get_position_title($get_job_info_custom->pos_title)->emp_position}}
                            @else
                            N/A
                            @endif
                        </td>
                        <td style="width: 100px;border: 10px solid #000000;font-size: 11px;font-family:Arial, Helvetica;vertical-align: top;word-wrap:break-word" >
                            @if($get_educ_rec_custom->item_no)
                            {{ $get_educ_rec_custom->item_no}}
                            @else
                            N/A
                            @endif
                        </td>
                        <td style="width: 100px;border: 10px solid #000000;text-align:center;font-size: 11px;font-family:Arial, Helvetica;vertical-align: top;word-wrap:break-word">
                            @if($get_job_info_custom->sg)
                            {{ get_SG($get_job_info_custom->sg)->code}}
                            @else
                            N/A
                            @endif
                        </td>
                        <td style="width: 100px;border: 10px solid #000000;text-align:center;font-size: 11px;font-family:Arial, Helvetica;vertical-align: top;word-wrap:break-word">
                            @if($get_job_info_custom->salary)
                            Php {{ $get_job_info_custom->salary }}
                            @else
                            N/A
                            @endif
                        </td>
                        <td style="width: 100px;border: 10px solid #000000;font-size: 11px;font-family:Arial, Helvetica;vertical-align: top;word-wrap:break-word">
                            @if($get_educ_rec_custom->educ)
                            {{ $get_educ_rec_custom->educ }}
                            @else
                            N/A
                            @endif
                        </td>
                        <td style="width: 100px;border: 10px solid #000000;font-size: 11px;font-family:Arial, Helvetica;vertical-align: top;word-wrap:break-word">
                            @if($get_educ_rec_custom->training)
                            {{ $get_educ_rec_custom->training }}
                            @else
                            N/A
                            @endif
                        </td>
                        <td   style="width: 100px;border: 10px solid #000000;font-size: 11px;font-family:Arial, Helvetica;vertical-align: top;word-wrap:break-word">
                            @if($get_educ_rec_custom->work_ex)
                            {{ $get_educ_rec_custom->work_ex }}
                            @else
                            N/A
                            @endif
                        </td>
                        <td  style="width: 100px;border: 10px solid #000000;font-size: 11px;font-family:Arial, Helvetica;vertical-align: top;word-wrap:break-word">
                            @if($get_educ_rec_custom->eligibility)
                            {{ $get_educ_rec_custom->eligibility }}
                            @else
                            N/A
                            @endif
                        </td>
                        <td  style="width: 100px;border: 10px solid #000000;font-size: 11px;font-family:Arial, Helvetica;vertical-align: top;word-wrap:break-word">
                            @forelse (get_competency($get_job_info_custom->jobref_no) as $competency )
                            {{$competency->comp_list}}
                            @empty
                                N/A
                            @endforelse
                        </td>
                        <td  style="width: 100px;border: 10px solid #000000;font-size: 11px;font-family:Arial, Helvetica;vertical-align: top;word-wrap:break-word">
                            @if($get_job_info_custom->assign_agency)
                            {{ $get_job_info_custom->assign_agency }}
                            @else
                            N/A
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>



            <table>
                <tr>
                    <td colspan="10" rowspan="3" style="text-align: justify;text-justify: inter-word;font-family:Arial, Helvetica, sans-serif;font-size: 11px;vertical-align: top">
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
                    </td>
                </tr>

            </table>

        <table class="mt-2">
                <tr></tr>
                <tr></tr>
                @php($num=1)
                @forelse (get_Documents_requirements($get_job_info_custom->jobref_no) as $docs)
                    <tr>
                        <td style="width: 5px"> </td>
                        <td style="font-size: 11px;font-family:Arial, Helvetica">
                             {{ $num++ }}.{{$docs->doc_requirements }}
                        </td>
                    </tr>
                    @empty
                    @endforelse
        </table>


        <table>
            <tr>
                <td  colspan="7" style="width:120px;font-weight: bold;font-family:Arial, Helvetica, sans-serif;font-size: 10px">
                    {{ 'QUALIFIED APPLICANTS' .' '. 'are advised to hand in or send through courier/email their application to:'}}
                </td>
                {{-- <td>
                    are advised to hand in or send through courier/email their application to:
                </td> --}}
            </tr>
        </table>

        <table>
            <tr>
                <td></td>
                <td colspan="3" style="border-bottom: 10px solid #000000;font-weight:bold;text-align:center">
                    {{ $get_org_head }}
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="3"style="border-bottom: 10px solid #000000;text-align:center">{{ $get_org_head_pos }}</td>
            </tr>
            <tr>
                <td></td>
                    <td colspan="3"style="border-bottom: 10px solid #000000;text-align:center">
                         @if($get_job_info_custom->address)
                        {{ $get_job_info_custom->address }}
                       @else
                       N/A
                       @endif
                    </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="3"style="border-bottom: 10px solid #000000;text-align:center;color:blue;text-decoration: underline">
                    @if($get_job_info_custom->email_add)
                    {{ $get_job_info_custom->email_add }}
                        @else
                        No email address attached
                        @endif
                </td>
            </tr>
        </table>

        <table>
            <tr>
                <td style="font-weight: bold;font-family:Arial, Helvetica, sans-serif;font-size: 10px">
                    APPLICATIONS WITH INCOMPLETE DOCUMENTS SHALL NOT BE ENTERTAINED.
                </td>
            </tr>
        </table>
        </body>
    </html>
