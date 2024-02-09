@php
    use App\Models\IDP\activity_plan;
@endphp
<!doctype html>
<html lang = "en">
    <head>
        <meta charset = "UTF-8">
        <title>{{ $filename }}</title>
        <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
        <style type = "text/css">
            /** Define the margins of your page **/
            /**
                margin: 10px 5px 15px 20px;
                    top margin is 10px
                    right margin is 5px
                    bottom margin is 15px
                    left margin is 20px
                    **/
            @page {
                    margin: 30px 0px 30px 0px;
                }
            body { margin: 75px 30px 50px 30px;
            }

            @font-face {
                font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
                    font-style: normal;
                    font-weight: normal;
                    src: url('/public/src/fonts/calibre/CalibreRegular.otf');
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
                top: -38px;
                left: 0px;
                right: 0px;
                height: 50px;
                /** Extra personal styles **/
                /* background-color: #03a9f4; */
                color: white;
                text-align: center;
                line-height: 35px;

            }
            footer {
                position: fixed;
                bottom: 55px;
                left: 0px;
                right: 0px;
                height: 50px;
                /** Extra personal styles **/
                /* background-color: #03a8f400; */
                color: rgb(0, 0, 0);
                text-align: center;
                line-height: 35px;
            }

        
            img {
                object-fit: cover;
                }
            .scale-down {
                object-fit: scale-down;

            }
            .grid-container {
                display: grid;
            }
            .grid-container {
                display: inline-grid;
                }
          
          
                
            .no-border-right {
                border-right: none;
                }
            .no-border {
                border-right: none;
            }
            .pagenum:before {
                    content: counter(page);
                }

            #wrapper{
                    -moz-column-count: 3;
                    -moz-column-gap: 1em;
                    -webkit-column-count: 3;
                    -webkit-column-gap: 1em;
                    column-count: 3;
                    column-gap: 1em;
                    }
            .itm{
                display:inline-block;
                width:100%;
                border-top:1px solid red;
                border-bottom:1px solid red;
                margin-bottom:1em;
            }
            .itm:nth-child(3n+1){
                clear:left;
            }
            .equ {

                display: inline-block;
                width: 40px;
                height: 180px;
                border-radius: 5px 5px 0 0;
                background:
                linear-gradient(transparent 80%, #333333 20%)0 0/100% 40px,
                linear-gradient(orange, yellow);
                }

                .info-table{
                    border-collapse: collapse;
                    width: 100%;
                }
                .info-table td{
                    /*padding: 0.25rem;*/
                    border-collapse: collapse;
                }

                .development-priorities-table{
                    border-collapse: collapse;
                    width: 100%;
                }
                .development-priorities-table td{
                    /*padding: 0.25rem;*/
                    border-collapse: collapse;

                }                

                .development-activity-table{
                    border-collapse: collapse;
                    width: 100%;
                }
                .development-activity-table td{
                    /*padding: 0.25rem;*/
                    border-collapse: collapse:inherit;

                }

                .activity-plan-table{
                    border-collapse: collapse;
                    width: 100%;
                }
                .activity-plan-table td{
                    /*padding: 0.25rem;*/
                    border-collapse: collapse:inherit;

                }
                .page_break { page-break-before: always; }
        </style>
    </head>

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
                            <span>(e-HRIS) generated report:</span> <strong>{{ $current_date }}</strong>
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
    <body>

                <main>

                <div  class = "information">
                    <table class="info-table" style="margin-top: -10px; margin-bottom: 10px; font-size: 10px; width: 100%;">
                        <tbody>
                            <tr>
                                <td colspan="2" >
                                    <h4 style="padding: 5px">SPMS Form 10 - Individual Development Plan </h4>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="5" style="padding-top: 30px" ><h3>INDIVIDUAL DEVELOPMENT PLAN  (IDP) </h3> </th>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black" width="5%">1. Name (Last, First, MI) </td>
                                <td style="border: 1px solid black" width="45%">{{ $emp_name }}</td>
                                <td style="border: 1px solid black" width="25%">6. Three-Year Period</td>
                                <td colspan="2" style="border: 1px solid black" width="25%">{{ $getIdp->three_y_period }}</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black" width="25%">2. Current Position </td>
                                <td style="border: 1px solid black" width="25%">{{ $position }}</td>
                                <td style="border: 1px solid black" width="25%">7. Division </td>
                                <td colspan="2" style="border: 1px solid black" width="25%">{{ $getIdp->division }}</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black" width="25%">3. Salary Grade  </td>
                                <td style="border: 1px solid black" width="25%">{{ $salaryGrade }}</td>
                                <td style="border: 1px solid black" width="25%">8. Office/Staff</td>
                                <td colspan="2" style="border: 1px solid black" width="25%">{{ $getIdp->office }}</td>
                            </tr>

                            {{-- Start --}}
                            <tr>
                                <td rowspan="4" style="border: 1px solid black" width="25%">4. Years in the Position  </td>
                                <td rowspan="4" style="border: 1px solid black" width="25%">{{ $getIdp->year_n_position }}</td>
                                <td colspan="3" style="border: 0px solid black; border-buttom: 0px; border-right: 1px solid black;" width="25%">9. No further development is desired or required for this year/s </td>
                            </tr>
                            <tr>
                                <td style="border: 0px solid black; border-top:0px" width="25%">(Please check box here)</td>
                                <td colspan="2" style="border: 0px solid black; border-right: 1px solid black;" width="25%"></td>
                            </tr>
                            <tr>
                                <td style="border: 0px solid black; border-top: 1px solid black; border-right: 1px solid black;" width="25%"><label style="margin-left: 20px">Year 1</label> </td>
                                <td style="border: 0px solid black; border-right: 1px solid black; border-top: 1px solid black;" width="25%"><label style="margin-left: 20px">Year 2</label></td>
                                <td style="border: 0px solid black; border-right: 1px solid black; border-top: 1px solid black;" width="25%"><label style="margin-left: 20px">Year 3</label></td>
                            </tr>
                            @if($getIdp->develop_year == 1)
                            <tr>
                                <td style="border: 0px solid black; border-right: 1px solid black;" width="25%"><input type="checkbox" checked></td>
                                <td style="border: 0px solid black; border-right: 1px solid black;" width="25%"><input type="checkbox" ></td>
                                <td style="border: 0px solid black; border-right: 1px solid black;" width="25%"><input type="checkbox" ></td>
                            </tr>
                            
                            @elseif($getIdp->develop_year == 2)

                            <tr>
                                <td style="border: 0px solid black; border-right: 1px solid black;" width="25%"><input type="checkbox" ></td>
                                <td style="border: 0px solid black; border-right: 1px solid black;" width="25%"><input type="checkbox" checked></td>
                                <td style="border: 0px solid black; border-right: 1px solid black;" width="25%"><input type="checkbox" ></td>
                            </tr>

                            @elseif($getIdp->develop_year == 3)
                            <tr>
                                <td style="border: 0px solid black; border-right: 1px solid black;" width="25%"><input type="checkbox" ></td>
                                <td style="border: 0px solid black; border-right: 1px solid black;" width="25%"><input type="checkbox" ></td>
                                <td style="border: 0px solid black; border-right: 1px solid black;" width="25%"><input type="checkbox" checked></td>
                            </tr>
                            @endif
                            

                            {{-- back --}}
                            <tr>
                                <td style="border: 1px solid black; padding: 10px; padding-left: 0px; text-align:left" width="25%">5. Years in NEDA </td>
                                <td style="border: 1px solid black" width="25%"></td>
                                <td style="border: 0px; border-top: 1px solid black; border-bottom: 1px solid black; padding: 10px; padding-top:0px;  padding-left:0px" width="25%">10. Name of Superior (Last, First, MI) </td>
                                <td colspan="2" style="border: 0px; border-top: 1px solid black; border-bottom: 1px solid black; border-right: 1px solid black" width="25%">{{ $supervisor_name }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="development-priorities">
                    <table style="width: 100%">
                        <tbody>
                            <tr>
                                <td style="font-size: 10px; padding-top: 5px; padding-left:5px; font-weight: 500">PART A: COMPETENCY ASSESSMENT AND DEVELOPMENT PRIORITIES </td>
                            </tr>

                            <tr>
                                <td style="font-size: 12px; font-style: italic;">(Based on the competency assessment conducted and/or the review of performance review results, please identify the top gaps or weaknesses among the competencies assessed </td>
                                {{-- <td colspan="2" style="padding-left: 30px; padding-top:10px"><div style="text-align: justify; text-indent: 2em;line-height:2;">{{ $get_to->purpose }}</div></td> --}}
                            </tr>

                            <tr>
                                <td style="font-size: 12px; font-style: italic;">that the employee needs to focus on for development, improvement or enhancement. As a rule-of-thumb, it would be best to prioritize three (3) developmental areas over a two-year period)  </td>
                                <td></td>
                            </tr>

                        </tbody>
                    </table>

                </div>

                <div class="development-priorities">
                    <table class="development-priorities-table" style="width: 100%; padding-top: 20px">
                        <tbody>
                            <tr>
                                <td class="text-white" width="30%" style="color: white; text-align: center; border: 1px solid black; background-color: rgb(162, 164, 164);">Development Target </td>
                                <td width="35%" style="color: white; text-align: center; border: 1px solid black; background-color: rgb(162, 164, 164);">Performance Goal this Supports</td>
                                <td width="35%" style="color: white; text-align: center; border: 1px solid black; background-color: rgb(162, 164, 164);">Objective</td>
                            </tr>
                            @if($getTarget->count() > 0)

                                @foreach($getTarget as $target)
                                <tr>
                                    <td style="border: 1px solid black; padding-left:0px; padding: 5px; text-align:justify">{{ $target->dev_target }}</td>
                                    <td style="border: 1px solid black; padding: 5px; text-align:justify">{{ $target->pg_support }}</td>
                                    <td style="border: 1px solid black; padding: 5px; text-align:justify">{{ $target->objective }}</td>
                                   
                                </tr>

                                @endforeach
                            
                            @else
                            <tr>
                                <td style="border: 1px solid black; padding: 20px"></td>
                                <td style="border: 1px solid black; padding: 20px"></td>
                                <td style="border: 1px solid black; padding: 20px"></td>
                               
                            </tr>

                            @endif

                        </tbody>
                    </table>

                </div>
                {{-- Page Break --}}
                <div class="page_break"></div>
                {{-- Page Break --}}
                <div class="development-plan">                   

                    <table style="width: 100%; padding-top: 10px">
                        <tbody>
                            <tr>
                                <td style="font-size: 10px; padding-top: 3px; padding-left:5px; font-weight: 500">PART B: DEVELOPMENT PLAN </td>
                            </tr>

                            <tr>
                                <td style="font-size: 12px; font-style: italic;">(This covers the employee's development actions which are learning and development activities and interventions for the year.) </td>
                                {{-- <td colspan="2" style="padding-left: 30px; padding-top:10px"><div style="text-align: justify; text-indent: 2em;line-height:2;">{{ $get_to->purpose }}</div></td> --}}
                            </tr>

                            
                        </tbody>
                    </table>                    

                </div>

                <div class="development-plan">
                    <table class="development-activity-table" style="width: 100%; padding-top: 5px">
                        <thead>
                            <tr>
                                <td rowspan="2" width="30%" style="text-align: center; border: 1px solid black; background-color: rgb(178, 247, 193);"> Development Activity  </td>
                                <td rowspan="2" width="35%" style="text-align: center; border: 1px solid black; background-color: rgb(178, 247, 193);">Support Needed/Involvement of Others</td>
                                <td colspan="3" width="35%" style="text-align: center; border: 1px solid black; background-color: rgb(178, 247, 193);">Tracking Method/Completion Date </td>
                            </tr>
                            <tr>
                                <td width="30%" style="text-align: center; border: 1px solid black; background-color: rgb(178, 247, 193);"> Planned </td>
                                <td width="35%" style="text-align: center; border: 1px solid black; background-color: rgb(178, 247, 193);"> Accomplished Mid Year</td>
                                <td width="35%" style="text-align: top; border: 1px solid black; background-color: rgb(178, 247, 193);"> Accomplished Year End </td>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @if($getActivity->count() > 0)
                                @foreach($getActivity as $activity)
                                    <tr>
                                        <td style="border: 1px solid black; padding: 5px; margin-top:-700px">{{ $activity->dev_activity }}</td>
                                        <td style="border: 1px solid black; padding: 5px; text-align:justify">{{ $activity->support_needed }}</td>
                                        <td colspan="3" style="border: 1px solid black">
                                            <div style="margin: -2px;">
                                                <table class="activity-plan-table hover">
                                                    @php
                                                        $plannnn = activity_plan::where('idp_id', $idp_id)->where('activity_id', $activity->id)->where('active', 1)->get();
                                                    @endphp
                                                    @foreach($plannnn as $key => $plan)
                                                        <tr>
                                                            <td width="30%" style="border: 1px solid black; padding: 15px; padding-top:5px; text-align:justify">{{ $plan->planned }}</td>
                                                            <td width="35%" style="border: 1px solid black; padding: 15px; padding-top:0px; text-align:justify">{{ $plan->accom_mid_year }}</td>
                                                            <td width="35%" style="border: 1px solid black; padding: 15px; padding-top:0px; text-align:justify">{{ $plan->accom_year_end }}</td>                                                                                                            
                                                        </tr>
                                                    @endforeach 
                                                </table>
                                            </div>
                                        </td>
                                        {{-- <td colspan="2" style="padding-left: 30px; padding-top:10px"><div style="text-align: justify; text-indent: 2em;line-height:2;">{{ $get_to->purpose }}</div></td> --}}
                                    </tr>
                                @endforeach
                            @else
                            <tr>
                                <td style="border: 1px solid black; padding: 20px"></td>
                                <td style="border: 1px solid black"></td>
                                <td style="border: 1px solid black"></td>
                                <td style="border: 1px solid black"></td>
                                <td style="border: 1px solid black"></td>
                                {{-- <td colspan="2" style="padding-left: 30px; padding-top:10px"><div style="text-align: justify; text-indent: 2em;line-height:2;">{{ $get_to->purpose }}</div></td> --}}
                            </tr>

                            <tr>
                                <td style="border: 1px solid black; padding: 20px"></td>
                                <td style="border: 1px solid black"></td>
                                <td style="border: 1px solid black"></td>
                                <td style="border: 1px solid black"></td>
                                <td style="border: 1px solid black"></td>
                            </tr>
                            @endif                           

                        </tbody>
                    </table>

                </div>
                {{-- Page Break --}}
                <div class="page_break"></div>
                {{-- Page Break --}}
                <div class="signaturies">
                    <table class="development-priorities-table" style="width: 100%; padding-top: 5px">
                        <tbody>
                            <tr>
                                <td class="text-white" width="20%" style="text-align: left; border: 1px solid black">11. Employee Signature </td>
                                <td width="10%" style="text-align: left; border: 1px solid black">Date</td>
                                <td width="20%" style="text-align: left; border: 1px solid black">12. Supervisor's Signature</td>
                                <td width="10%" style="text-align: left; border: 1px solid black">Date</td>
                                <td width="20%" style="text-align: left; border: 1px solid black">13. Head/ Assistant Head of Office Signature</td>
                                <td width="10%" style="text-align: left; border: 1px solid black">Date</td>
                            </tr>

                            <tr>
                                <td style="border: 1px solid black; padding: 30px"></td>
                                <td style="border: 1px solid black"></td>
                                <td style="border: 1px solid black"></td>
                                <td style="border: 1px solid black"></td>
                                <td style="border: 1px solid black"></td>
                                <td style="border: 1px solid black"></td>
                               
                            </tr>

                            <tr>
                                <td class="text-white" width="20%" style="text-align: left; border: 1px solid black">14A. Updated (Initials) </td>
                                <td width="10%" style="text-align: left; border: 1px solid black">Date</td>
                                <td width="20%" style="text-align: left; border: 1px solid black">14B. Updated (Initials)</td>
                                <td width="10%" style="text-align: left; border: 1px solid black">Date</td>
                                <td width="20%" style="text-align: left; border: 1px solid black">14C. Updated (Initials)</td>
                                <td width="10%" style="text-align: left; border: 1px solid black">Date</td>
                            </tr>

                            <tr>
                                <td style="border: 1px solid black; padding: 30px"></td>
                                <td style="border: 1px solid black"></td>
                                <td style="border: 1px solid black"></td>
                                <td style="border: 1px solid black"></td>
                                <td style="border: 1px solid black"></td>
                                <td style="border: 1px solid black"></td>
                               
                            </tr>
                           
                            <tr>
                                <td rowspan="3" style="border: 1px solid black">15. Check applicable copy designation as shown</td>
                                <td style="text-align: center; border: 0px; border-right: 1px solid black">
                                    <input type="checkbox" checked>
                                </td>
                                <td colspan="4" style="border: 0px; border-right: 1px solid black">Employee's Copy</td>
                            </tr>
                            <tr>
                                <td style="text-align: center; border: 0px; border-right: 1px solid black"><input type="checkbox"></td>
                                <td colspan="4" style="border: 0px; border-right: 1px solid black">Supervisor's Copy</td>
                            </tr>
                            <tr>
                                <td style="text-align: center; border: 0px; border-bottom: 1px solid black; border-right: 1px solid black">
                                    <input type="checkbox" >
                                </td>
                                <td colspan="4" style="border: 0px; border-bottom: 1px solid black; border-right: 1px solid black">HRDD</td>
                            </tr>

                        </tbody>
                    </table>

                </div>

        </main>

    </body>

    </html>
