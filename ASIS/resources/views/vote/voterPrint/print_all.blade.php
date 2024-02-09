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
            body { margin: 60px 30px 90px 30px;
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
                top: -25px;
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
                bottom: 52px;
                left: 0px;
                right: 0px;
                height: 50px;
                /** Extra personal styles **/
                /* background-color: #03a8f400; */
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
            .information {
                color: rgb(0, 0, 0);
            }
            .information .logo {
                margin: 30px;
            }
            .information table {
                padding: 10px;
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
            #data {
                border-collapse: collapse;
            }
            #data th {
                border: 1px solid #000000;
                border-collapse: collapse;
            }
            #data td {
                border: 1px solid #000000;
                border-collapse: collapse;
            }
            #logo {
                height: auto;
                width: auto;
                max-width: 100px;
                max-height: 100px;
            }
            table.print-friendly tr td, table.print-friendly tr th {
                    page-break-inside: avoid;
                    border-right: none;
                }
            table.print-friendly {
                width: 100%;
                font-size: 14px;
                }
            table.print-friendly,
            th.print-friendly,
            td.print-friendly {
                    border-collapse: collapse;
                    }
            th.print-friendly,
            td.print-friendly {
                    padding: 5px;
                    text-align: left;
                    }
            table.print-friendly tr:nth-child(even) {
                background-color: rgba(0, 176, 240, 0.1);
                }
            table.print-friendly tr:nth-child(odd) {
                background-color: #fff;
                }
            table.print-friendly th {
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


                @media print
                    {
                    table { page-break-after:auto }
                    tr    { page-break-inside:avoid; page-break-after:auto }
                    td    { page-break-inside:avoid; page-break-after:auto }
                    thead { display:table-header-group }
                    tfoot { display:table-footer-group }

                    }
                    .pagebreak { page-break-before: always; } /* page-break-after works, as well */
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
                            <span>(e-HRIS) generated report:</span> <strong>{{ $current_date }} {{$status_text}}</strong>
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

                <div class = "information">
                    <table  style="font-size: 10px; "  width = "100%">
                        <tbody>
                            <tr>
                                <th style="padding-bottom: 30px" colspan="2">
                                    <div>
                                        <p><h1>{{$election_name}} - Voters</h1></p>
                                    </div>
                                </th>
                            </tr>

                            <tr>

                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- @if ($to_print == 1) --}}

                    @if($voter_assign->count() > 0)

                       
                        
                           
                            
                            <div class = "position-container to-print-1 mb-5">
                                <div>
                                    
                                </div>
                                
                                <table style="width: 100%; " id="data" border="1" class="export-table">
                                    <thead>
                                       
                                            <th>#</th>
                                            <th>Students Name</th>                                                               
                                            <th>Course</th>
                                            
                                        
                                    </thead>
                                    <tbody>
                                        @forelse($voter_assign as $index => $voter_course)
                                            <tr> <td colspan="3" style="width: 20px; text-align:center"><h5>{{ $voter_course->prog_code }}</h5></td></tr>

                                            @if($voter_course->get_enrolledList->count() > 0)
                                                @forelse($voter_course->get_enrolledList as $i => $get_enrolledList)
                                                
                                                <tr>
                                                    <td style="width: 20px; text-align:center">{{  $i+1 }}</td>
                                                
                                                    <td style="width: 150px; text-align:left">{{  $get_enrolledList->fullname }}</td>
                                                    <td style="width: 150px; text-align:left">{{  $get_enrolledList->studmajor }}</td>
                                                </tr>
                                                @empty
                                                @endforelse
                                            
                                            @endif

                                        @empty

                                        @endforelse                                                                     
                                    </tbody>
                                </table>
                            </div>
                       
                    
                    @endif
                {{-- @else

                    <div class = "position-container to-print-1 mb-5">

                        <table style="width: 100%; " id="data" border="1" class="export-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Position</th> 
                                    <th>Candidate Name</th>                                                               
                                    <th>Votes</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($assign_postions->count() > 0)
                                @forelse ($assign_postions as $index => $assign_postion)
                                    @php
                                        $position_name = '';
                                        $votes = 200;
                                        if($assign_postion->getElect_position){
                                            $position_name = $assign_postion->getElect_position->vote_position;
                                        }
                            
                                        $participants = App\Models\ASIS_Models\vote\elect_participants_model::with('get_student_applicants', 'get_position')
                                                                                                                ->where('type_id', $type_id)
                                                                                                                ->where('position_id', $assign_postion->positionID)
                                                                                                                ->where('active', 1)
                                                                                                                ->get();
                            
                                        $highestVoteCount = 0;
                                        $participantWithHighestVotes = null;
                                        $tiedParticipants = [];
                            
                                        foreach($participants as $participant) {
                                            $voting_result = App\Models\ASIS_Models\vote\supported_candidate_model::where('type_id', $type_id)
                                                                                                ->where('candidates',  $participant->participant_id)
                                                                                                ->get();
                            
                                            $vote_count = $voting_result->count();
                            
                                            if ($vote_count > $highestVoteCount) {
                                                $highestVoteCount = $vote_count;
                                                $participantWithHighestVotes = $participant->get_student_applicants->fullname;
                                                $tiedParticipants = []; // Reset tied participants if a new highest vote count is found
                                            } elseif ($vote_count === $highestVoteCount) {
                                                $tiedParticipants[] = $participant->get_student_applicants->fullname;
                                            }
                                        }
                            
                                        // Determine the participants' names based on the vote count and tie status
                                        if ($participantWithHighestVotes !== null && empty($tiedParticipants)) {
                                            $participants_name = $participantWithHighestVotes; 
                                        } else {
                                            if ($highestVoteCount === 0) {
                                                $participants_name = 'No Applicant Found';
                                            } else {
                                                $participants_name = 'Tie Between: ' . implode(', ', $tiedParticipants);
                                            }
                                        }
                                    @endphp
                            
                                    <tr>
                                        <td style="width: 20px; text-align:center">{{  $index+1 }}</td>
                                        <td style="width: 150px; text-align:center">{{  $position_name }}</td>
                                        <td style="width: 150px; text-align:center">{{  $participants_name }}</td>
                                        <td style="width: 150px; text-align:center">{{  $highestVoteCount }}</td>
                                    </tr>
                                @empty
                                @endforelse
                            @endif
                            
                                                                        
                            </tbody>
                        </table>
                    </div> --}}
                
                {{-- @endif --}}
                
                
                <div style="font-size: 10px; padding-top: 40px" class = "information">
                    <div style="padding-top:20px">
                        
                        @if($signatoryDatas->count() > 0)

                        @foreach ($signatoryDatas as $key => $signatoryData) 
                            @php
                                 $signature_name = '';
            
                                    $signatory_id =  $signatoryData->signatory;
                                    $image = get_profile_image($signatory_id);
    
                                    if($signatoryData->get_signatory){
                                        $signature_name = $signatoryData->get_signatory->fullname;
                                    }
                                    $sig_divs = '';

                                    if ($key % 2 == 0){
                                        //echo "even";
                                        $sig_divs .= '<div style="float: left; width: 50%; font-size:x-small ; padding-left:20px">
                                            <div style="padding-bottom: 10px; "><strong>'.$signatoryData->sig_description.':</strong></div>
                                            <div style="margin-bottom: -20px; "></div>
                                            <div style="padding-top:20px"><u class="block mt-1">'.$signature_name.'</u></div>
                                            <div> </div>
                                        </div>';
                                        } else{
                                        //echo "odd";
                                        $sig_divs .='<div style="float: right; margin-left: 35%; width: 50%;  font-size:x-small ">
                                                <div>
                                                    <div style="padding-bottom: 10px;"><strong>'.$signatoryData->sig_description.':</strong></div>
                                                    <div style="margin-bottom: -20px;"></div>
                                                    <div style="padding-top:20px"><u class="block mt-1">'.$signature_name.'</u></div>
                                                    <div> </div>
                                                </div>

                                            </div>

                                            <br>
                                            <br>
                                            <br>
                                            <br>
                                            <br>
                                            <br>
                                            <br>
                                            <br>
                                            <br>
                                            <br>';
                                            }
                            @endphp
                                                                   
                           {!! $sig_divs !!}
                            
                        @endforeach
                    @endif

                    </div>
                </div>
                

        </main>


    </body>

    </html>
