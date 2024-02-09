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
            body { margin: 50px 30px 90px 30px;
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
                bottom: 32px;
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

        {{-- <div style="margin-top: -60px ;display:none"  class = "information">
            <table >
                <tr style="text-align: justify">
                    <td><img src="uploads\1_theG1651067472.png" width="100px" alt=""></td>
                    <td>
                        <div><strong>Republic of the Philippines</strong></div>
                        <div><strong>DSSC</strong></div>
                        <div><strong>DAVAO DEL SUR STATE COLLEGE</strong></div>
                        <div>Office of the President</div>
                        <div>Telephone No. </div>
                        <div>E-mail</div>
                    </td>
                </tr>
            </table>
        </div> --}}

        <main>

                <div   class = "information">
                    <table  style="font-size: 10px; "  width = "100%">
                        <tbody>
                            <tr>
                                <th style="padding-bottom: 30px" colspan="2">
                                    <div>
                                        <p><h1>Document Summary</h1></p>
                                            <strong>From:{{ $from }} - To:{{ $to }}</strong>
                                    </div>
                                </th>
                            </tr>

                            <tr>

                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class = "information">
                    <table style="width: 100%; " id="data" border="1" class="export-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                {{-- <th>Tracking #</th> --}}
                                <th>Document</th>
                                <th>Recipient(s)</th>
                                <th>Receive</th>
                                <th>Date Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($get_documents as $i => $doc)
                                <tr>
                                    <td style="width: 20px; text-align:center">{{  $i+1 }}</td>
                                    {{-- <td style="width: 60px; text-align:center">{{  $doc->track_number }}</td> --}}
                                    <td style="width: 150px; text-align:center">{{  $doc->name }}</td>
                                    <td>
                                        @forelse ($doc->get_track_sent_to->unique('target_user_id') as $row => $incoming)

                                           <small>{{ Str::title( fullname($incoming->target_user_id)) }},</small>
                                        @empty
                                            N/A
                                        @endforelse

                                    </td>

                                    <td style="width: 150px; text-align:center">
                                        @forelse ($doc->get_track_received_by->unique('target_user_id') as $incoming)
                                            <small>{{Str::title( fullname($incoming->target_user_id)) }},</small>
                                        @empty
                                            N/A
                                        @endforelse

                                    </td>
                                    <td style="width: 80px;text-align: center">{{  $doc->created_at->format('Y-m-d') }}</td>
                                </tr>
                            @empty

                            @endforelse

                        </tbody>
                    </table>

                </div>

                <div style="font-size: 10px" class = "information">
                    <div>


                    </div>
                </div>

        </main>


    </body>

    </html>
