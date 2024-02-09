<!doctype html>
<html lang = "en">
    <head>
        <meta charset = "UTF-8">
        <title>{{ $filename }}</title>


        <style type = "text/css">
            /** Define the margins of your page **/
            @page {
                /**
                margin: 10px 5px 15px 20px;
                    top margin is 10px
                    right margin is 5px
                    bottom margin is 15px
                    left margin is 20px
                    **/

                    margin: 50px 0px 40px 0px;
                }
            body { margin: 0px 30px 60px 30px;
            }
            @font-face {
                    font-family: 'bookman-old-style';
                    font-style: bold;
                    font-weight: 1000;
                    src: url('/public/src/fonts/bookman-old-style/bookman-old-style.ttf');
                }

            * {

            }

            a {
                color          : #fff;
                text-decoration: none;
            }

            table {
                font-size:10px;
                font-style: normal;
                src: url('/public/src/fonts/bookman-old-style/bookman-old-style.ttf');
                border: 2px single black;
            }
            td { border: thin single black collapse }

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

            .invoice table {
                margin: 10px;
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
                border: 1px thin #000000;
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
                .pagenum2:before {
                    counter-increment: page;
                }

            #wrapper{
                    -moz-column-count: 3;
                    -moz-column-gap: 1em;
                    -webkit-column-count: 3;
                    -webkit-column-gap: 1em;
                    column-count: 3;
                    column-gap: 1em;
                    }

            .underline{
                border-bottom:1px solid #000000;
                width:200px;
                padding-bottom:5px;
            }

            .page_break { page-break-before: always; }





        </style>

        <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    </head>
        <!-- Define header and footer blocks before your content -->
    <body>

        <div style="margin-top: -40px"  class = "information">
            <table width="100%" >
                <tr style="text-align: justify">
                    <td></td>
                    <td style="padding-left:79.5%">

                        <div style="font-family:'Bookman Old'; font-size:90%;">Revised as of January 2015</div>
                        <div style="font-family:'Bookman Old'; font-size:90%;">Per CSC Resolution No. 1500088</div>
                        <div style="font-family:'Bookman Old'; font-size:90%;">Promulgated on January 23, 2015</div>
                    </td>
                </tr>
            </table>
        </div>

    </footer>

        <main>
                <div style="margin-top: -30px"   class = "information">
                    <table style="font-size: 10px"  width = "100%">
                            <tr>
                                <th ><h1 style="font-family:'Bookman Old'; font-size:165%;">SWORN STATEMENT OF ASSETS, LIABILITIES AND NET WORTH</h1> </th>
                            </tr>
                    </table>
                </div>
                <div style="text-align: center" class = "information">
                    <div style="font-family:'Bookman Old'; font-size:70%;margin-top: -20px"><label style="font-family:'Bookman Old';"> As of @if ($get_saln->as_of)
                        <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{  $get_saln->as_of }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                    @else
                    <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                    @endif   </label></div>
                    <div style="font-family:'Bookman Old'; font-size:70%;margin-top: 2px"><label style="font-family:'Bookman Old';">(Required by R.A. 6713)</label></div>
                    <div style="font-family:'Bookman Old'; font-size:70%;margin-top: 2px"><p style="font-family:'Bookman Old';"><strong style="font-family:'Bookman Old';">Note: </strong><em style="font-family:'Bookman Old';">Husband and wife who are both public officials and employees may file the required statements jointly or separately.</em> </p></div>
                    <div style="text-align:center">

                        <table width="500px" style="text-align: center ;font-size:65%;margin-left: 120px;margin-top: -18px">
                            <tr>
                                <td>

                                    <em style="font-family:'Bookman Old'; font-size:120%;"><input type="checkbox" style="margin-bottom: -7px" {{ ( $get_saln->joint_filing == 1 ? ' checked' : '') }}> Joint Filing</em>

                                </td>
                                <td>
                                    <em style="font-family:'Bookman Old'; font-size:120%;"><input type="checkbox" style="margin-bottom: -7px" {{ ( $get_saln->separate_filing == 1 ? ' checked' : '') }}> Separate Filing</em>

                                </td>
                                <td>
                                    <em style="font-family:'Bookman Old'; font-size:120%;"><input type="checkbox" style="margin-bottom: -7px" {{ ( $get_saln->not_applicable == 1 ? ' checked' : '') }}> Not Applicable </em>

                                </td>
                            </tr>
                        </table>

                    </div>

                    <table width="800px" style="text-align: center; margin: 0px 0px 0px -30px">
                        <tr>
                            <td>

                                <table style="font-family:'Bookman Old';">
                                    <tr>
                                        <td><strong>DECLARANT:</strong></td>
                                        <td style=" border-bottom: 1pt solid black;">
                                            <table width="350px" style="text-align: center; margin: -18px 0px -10px 0px; table-layout: fixed ; border-spacing: 20px 5px;">
                                            <tr>
                                                <td>
                                                    @if ($get_saln->declarant_lastname)
                                                        {{  $get_saln->declarant_lastname }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($get_saln->declarant_firstname)
                                                        {{  $get_saln->declarant_firstname }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($get_saln->declarant_middlename)
                                                        {{  ucfirst(Str::limit($get_saln->declarant_middlename, 1, '.')) }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="text-align: center">
                                            <table width="350px" style="text-align: center; margin: -15px 0px -10px 0px; table-layout: fixed ; border-spacing: 20px 5px;">
                                                <tr>
                                                    <td>(Family Name)</td>
                                                    <td>(First Name)</td>
                                                    <td>(M.I.)</td>
                                                </tr>
                                            </table>
                                            </td>
                                    </tr>
                                    <tr>
                                        <td><strong>ADDRESS:</strong></td>
                                        <td style=" border-bottom: 1pt solid black; text-align:center">
                                            @if ($get_saln->declarant_address)
                                                {{  $get_saln->declarant_address }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style=" border-bottom: 1pt solid black;"><strong style="color: white"> ________________________________________________________________</strong></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style=" border-bottom: 1pt solid black;">
                                            <table width="350px" style="text-align: center; margin: -13px 0px -15px 0px; table-layout: fixed ; border-spacing: 20px 5px;">
                                                <tr>
                                                    <td>
                                                        @if ($get_saln->spouse_lastname)
                                                            {{  $get_saln->spouse_lastname }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($get_saln->spouse_firstname)
                                                            {{  $get_saln->spouse_firstname }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($get_saln->spouse_middlename)
                                                            {{  ucfirst(Str::limit( $get_saln->spouse_middlename, 1, '.')) }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="text-align: center">
                                            <table width="350px" style="text-align: center; margin: -15px 0px 3px 2px;table-layout: fixed ; border-spacing: 20px 5px;">
                                                <tr>
                                                    <td>(Family Name)</td>
                                                    <td>(First Name)</td>
                                                    <td>(M.I.)</td>
                                                </tr>
                                            </table>
                                            </td>
                                    </tr>

                                </table>

                            </td>
                            <td>
                                <table >
                                    <tr>
                                        <td ><strong>POSITION:</strong></td>
                                        <td style=" border-bottom: 1pt solid black; text-align:center">
                                            @if ($get_saln->declarant_position)
                                                {{  $get_saln->declarant_position }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>AGENCY/OFFICE:</strong></td>
                                        <td style=" border-bottom: 1pt solid black; text-align:center">
                                            @if ($get_saln->declarant_agency_office)
                                                {{  $get_saln->declarant_agency_office }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>OFFICE ADDRESS:</strong></td>
                                        <td style=" border-bottom: 1pt solid black; text-align:center">
                                            @if ($get_saln->declarant_office_address)
                                                {{  $get_saln->declarant_office_address }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style=" border-bottom: 1pt solid black;"><strong style="color: white"> __________________________________________</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>POSITION:</strong></td>
                                        <td style=" border-bottom: 1pt solid black; text-align:center">
                                            @if ($get_saln->spouse_position)
                                                {{  $get_saln->spouse_position }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>AGENCY/OFFICE:</strong></td>
                                        <td style=" border-bottom: 1pt solid black; text-align:center">
                                            @if ($get_saln->spouse_agency_office)
                                                {{  $get_saln->spouse_agency_office }}
                                            @else
                                                N/A
                                            @endif
                                         </td>
                                    </tr>
                                    <tr>
                                        <td><strong>OFFICE ADDRESS:</strong></td>
                                        <td style=" border-bottom: 1pt solid black; text-align:center">
                                            @if ($get_saln->spouse_office_address)
                                                {{  $get_saln->spouse_office_address }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    </tr>

                                </table>

                            </td>
                        </tr>

                    </table>
                    <hr class="hr" />

                    <table style="font-size: 10px"  width = "100%">
                        <tr>
                            <th ><h1 style="font-family:'Bookman Old'; font-size:130%;"><u> UNMARRIED CHILDREN BELOW EIGHTEEN (18) YEARS OF AGE LIVING IN DECLARANT’S  HOUSEHOLD</u></h1> </th>
                        </tr>
                    </table>

                    <table width="100%" style="text-align: center;table-layout: fixed ; border-spacing: 20px 5px;">
                        <thead>
                            <tr>
                                <td><strong>NAME</strong> </td>
                                <td><strong>DATE OF BIRTH</strong></td>
                                <td><strong>AGE</strong></td>
                            </tr>
                        </thead>


                        @php
                            $child_row_max = 3;
                            $child_row_current = 0;
                        @endphp

                        @forelse ($get_saln->get_unm_chil as $child)
                            @php
                                $child_row_current++;
                            @endphp
                        <tr>
                            <td style=" border-bottom: 1pt solid black; text-align:center">
                                @if ($child->name)
                                    {{ $child->name }}
                                @else
                                    N/A
                                @endif

                            </td>
                            <td style=" border-bottom: 1pt solid black; text-align:center">
                                @if ($child->dateofbirth)
                                    {{ $child->dateofbirth }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td style=" border-bottom: 1pt solid black; text-align:center">
                                @if ($child->age)
                                    {{ $child->age }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        @empty
                        @php
                                $child_row_current = $child_row_max;
                        @endphp
                        <tr>
                            <td style=" border-bottom: 1pt solid black; text-align:center">N/A</td>
                            <td style=" border-bottom: 1pt solid black; text-align:center">N/A</td>
                            <td style=" border-bottom: 1pt solid black; text-align:center">N/A</td>
                        </tr>

                        @endforelse

                        @php
                            $child_row_added = $child_row_max - $child_row_current;
                        @endphp
                        @for ($i = 1; $i <= $child_row_added; $i++)
                            <tr>
                                <td style=" border-bottom: 1pt solid black;"><strong style="color: white">________________________________</strong></td>
                                <td style=" border-bottom: 1pt solid black; text-align:center"><strong style="color: white">________________________________</strong><</td>
                                <td style=" border-bottom: 1pt solid black; text-align:center"><strong style="color: white">________________________________</strong><</td>
                            </tr>
                        @endfor


                    </table>

                    <hr class="hr" />

                     <table style="font-size: 10px" width = "100%">
                        <tr>
                            <th ><h1 style="font-family:'Bookman Old'; font-size:130%;"><u>ASSETS, LIABILITIES AND NETWORTH</u> </h1> </th>

                        </tr>
                        <tr >
                            <td style="text-align: center">
                                <em style="font-family:'Bookman Old'; font-size:130%; padding-left:150px; padding-right:150px; text-align:center">(Including those of the spouse and unmarried children below eighteen (18)</em>
                                <em style="font-family:'Bookman Old'; font-size:130%; padding-left:150px; padding-right:150px; text-align:center">years of age living in declarant’s household)</em>

                            </td>
                        </tr>
                    </table>

                    <table width = "100%">
                        <tr>
                            <td><strong style="font-family:'Bookman Old'; font-size:130%;">1.  ASSETS</strong></td>

                        </tr>
                        <tr>

                            <td style=" padding-left: 20px"><strong style="font-family:'Bookman Old'; font-size:130%;"> a.	Real Properties*</strong></td>
                        </tr>
                    </table>

                    <table id="data" style="text-align: center" width = "100%" border="1">
                        <thead style="background: #c3c3c3">
                            <tr>

                                <td rowspan="2" style="width: 80px; padding:5px"><strong> DESCRIPTION </strong><div style="font-family:'Bookman Old'; font-size:90%;">(e.g. lot, house and lot, condominium and improvements)</div></td>
                                <td rowspan="2" style="width: 80px; padding:7px"><strong>KIND </strong><div style="font-family:'Bookman Old'; font-size:80%;">(e.g. residential, commercial, industrial, agricultural and mixed use)</div></td>
                                <td rowspan="2" style="width: 80px; padding:5px"><strong>EXACT LOCATION </strong></td>


                                <td style="width: 80px; padding:5px"><strong> ASSESSED VALUE</strong></td>
                                <td style="width: 80px; padding:5px"><strong>CURRENT FAIR MARKET VALUE </strong></td>



                                <td colspan="2" style="width: 80px; padding:5px"><strong>ACQUISITION</strong></td>
                                <td rowspan="2" style="width: 80px; padding:5px"><strong>ACQUISITION COST</strong></td>


                            </tr>

                            <tr>

                                <td colspan="2"><div style="font-family:'Bookman Old'; font-size:90%;">(As found in the Tax Declaration of Real Property)</div> </td>
                                <td style="width: 80px; padding:1px"><strong >Year</strong></td>
                                <td style="width: 80px; padding:1px"><strong>Mode</strong></td>

                            </tr>

                        </thead>
                        <tbody>

                            @php
                                $rp_row_max = 4;
                                $rp_row_current = 0;
                            @endphp

                            @forelse ($get_saln->get_real_prop as $rp)
                            @php
                                $rp_row_current++;
                            @endphp

                            <tr>
                                <td style="height: 40px">
                                    @if ($rp->description)
                                    <strong style="font-family:'Bookman Old'; font-size:130%;">{{ $rp->description }}</strong>
                                    @else
                                    <strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong>
                                    @endif

                                </td>
                                <td>
                                    @if ($rp->kind)
                                    <strong style="font-family:'Bookman Old'; font-size:130%;">{{ $rp->kind }}</strong>
                                    @else
                                    <strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong>
                                    @endif
                                </td>
                                <td>
                                    @if ($rp->exact_location)
                                    <strong style="font-family:'Bookman Old'; font-size:130%;">{{ $rp->exact_location }}</strong>
                                    @else
                                    <strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong>
                                    @endif
                                </td>
                                <td>
                                    @if ($rp->assessed_value)
                                    <strong style="font-family:'Bookman Old'; font-size:130%;">{{ $rp->assessed_value }}</strong>
                                    @else
                                    <strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong>
                                    @endif
                                </td>
                                <td>
                                    @if ($rp->market_value)
                                    <strong style="font-family:'Bookman Old'; font-size:130%;">{{ $rp->market_value }}</strong>
                                    @else
                                    <strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong>
                                    @endif
                                </td>
                                <td>
                                    @if ($rp->year)
                                    <strong style="font-family:'Bookman Old'; font-size:130%;">{{ $rp->year }}</strong>
                                    @else
                                    <strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong>
                                    @endif
                                </td>
                                <td>
                                    @if ($rp->mode)
                                    <strong style="font-family:'Bookman Old'; font-size:130%;">{{ $rp->mode }}</strong>
                                    @else
                                    <strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong>
                                    @endif
                                </td>
                                <td>
                                    @if ($rp->cost)
                                    <strong style="font-family:'Bookman Old'; font-size:130%;">{{ number_format($rp->cost, 2, '.', ',') }}</strong>
                                    @else
                                    <strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            @php
                                $rp_row_current = $rp_row_max;
                            @endphp
                            <tr>
                                <td style="height: 40px"><strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong></td>
                                <td><strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong></td>
                                <td><strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong></td>
                                <td><strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong></td>
                                <td><strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong></td>
                                <td><strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong></td>
                                <td><strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong></td>
                                <td><strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong></td>
                            </tr>
                            <tr>
                                <td style="height: 40px"><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                            </tr>
                            <tr>
                                <td style="height: 40px"><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                            </tr>
                            <tr>
                                <td style="height: 40px"><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                            </tr>
                            @endforelse

                            @php
                                $rp_row_added = $rp_row_max - $rp_row_current;
                            @endphp
                            @for ($i = 1; $i <= $rp_row_added; $i++)
                                <tr>
                                    <td style="height: 40px"><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                    <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                    <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                    <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                    <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                    <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                    <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                    <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                </tr>
                            @endfor

                        </tbody>

                    </table>



                    <table width = "100%">
                        <tr>
                            <td></td>
                            <td style="text-align: right"><strong style="font-family:'Bookman Old'; font-size:130%;">Subtotal: @if ($get_saln->acquisition_assets_total)
                                <u >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ number_format($get_saln->acquisition_assets_total, 2, '.', ',') }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                            @else
                                <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                            @endif</strong></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style=" padding-left: 5px"><strong style="font-family:'Bookman Old'; font-size:130%;"> b. Personal Properties*</strong></td>
                        </tr>
                    </table>


                        <table id="data" width = "100%" style="text-align: center;table-layout: fixed ;">
                            <thead style="background: #c3c3c3">

                                <tr>
                                    <td><strong>DESCRIPTION</strong></td>
                                    <td><strong>YEAR ACQUIRED</strong></td>
                                    <td><strong>ACQUISITION COST/AMOUNT</strong></td>
                                </tr>

                            </thead>
                            <tbody>

                                @php
                                    $pp_row_max = 2;
                                    $pp_row_current = 0;
                                @endphp
                                @forelse ($get_saln->get_personal_prop as $pp)
                                    @php
                                        $pp_row_current++;
                                    @endphp
                                    <tr >
                                        <td style="height: 20px">
                                            @if ($pp->description)
                                            <strong style="font-family:'Bookman Old'; font-size:130%;">{{ $pp->description }}</strong>
                                            @else
                                            <strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($pp->year_acquired)
                                            <strong style="font-family:'Bookman Old'; font-size:130%;">{{ $pp->year_acquired }}</strong>
                                            @else
                                            <strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($pp->cost)
                                            <strong style="font-family:'Bookman Old'; font-size:130%;">{{ number_format($pp->cost, 2, '.', ',') }}</strong>
                                            @else
                                            <strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    @php
                                        $pp_row_current = $pp_row_max;
                                    @endphp
                                    <tr >
                                        <td style="height: 20px"><strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong></td>
                                    </tr>
                                    <tr >
                                        <td style="height: 20px"><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                    </tr>

                                @endforelse
                                @php
                                $pp_row_added = $pp_row_max - $pp_row_current;
                                @endphp
                                @for ($i = 1; $i <= $pp_row_added; $i++)
                                    <tr >
                                        <td style="height: 20px"><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                    </tr>
                                @endfor

                            </tbody>

                        </table>



                        <table width = "100%">
                            <tr>
                                <td></td>
                                <td style="text-align: right"><strong style="font-family:'Bookman Old'; font-size:130%;">Subtotal: @if ($get_saln->acquisition_personal_prop_sub_total)
                                    <u >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ number_format($get_saln->acquisition_personal_prop_sub_total, 2, '.', ',') }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                                @else
                                    N/A
                                @endif</strong></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td style="text-align: right"><strong style="font-family:'Bookman Old'; font-size:130%;">TOTAL ASSETS (a+b): @if ($get_saln->acquisition_personal_prop_total)
                                    <u >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{  number_format($get_saln->acquisition_personal_prop_total, 2, '.', ',')  }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                                @else
                                    N/A
                                @endif </strong></td>
                            </tr>
                            <tr>

                                <td ><em style="font-family:'Bookman Old'; font-size:130%;">* Additional sheet/s may be used, if necessary.</em> </td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>



                        <table width = "100%">
                            <tr>
                                <td><strong style="font-family:'Bookman Old'; font-size:130%;">2.	LIABILITIES* </strong></td>

                            </tr>
                            <tr>

                                <td style=" padding-left: 20px"></td>
                            </tr>
                        </table>

                        <table id="data" width = "100%" style="text-align: center;table-layout: fixed ;">
                            <thead style="background: #c3c3c3">

                                <tr>
                                    <td><strong>NATURE</strong></td>
                                    <td><strong>NAME OF CREDITORS</strong></td>
                                    <td><strong>OUTSTANDING BALANCE</strong></td>
                                </tr>

                            </thead>
                            <tbody>

                                @php
                                    $liab_row_max = 1;
                                    $liab_row_current = 0;
                                @endphp

                                @forelse ($get_saln->get_liabilities as $liab)
                                @php
                                    $liab_row_current++;
                                @endphp
                                <tr>
                                    <td style="height: 20px">
                                        @if ($liab->nature)
                                        <strong style="font-family:'Bookman Old'; font-size:130%;">{{ $liab->nature }}</strong>
                                        @else
                                        <strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($liab->name_of_creditors)
                                        <strong style="font-family:'Bookman Old'; font-size:130%;">{{ $liab->name_of_creditors }}</strong>
                                        @else
                                        <strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($liab->out_standing_balance)
                                        <strong style="font-family:'Bookman Old'; font-size:130%;">{{ number_format($liab->out_standing_balance, 2, '.', ',') }}</strong>
                                        @else
                                        <strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                @php
                                    $liab_row_current = $liab_row_max;
                                @endphp
                                <tr>
                                    <td style="height: 20px"><strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong></td>
                                    <td><strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong></td>
                                    <td><strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong></td>
                                </tr>
                                @endforelse
                                @php
                                    $liab_row_added = $liab_row_max - $liab_row_current;
                                @endphp
                                @for ($i = 1; $i <= $liab_row_added; $i++)
                                    <tr>
                                        <td style="height: 20px"><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                    </tr>
                                @endfor


                            </tbody>

                        </table>


                        <table width = "100%" style="text-align: center">
                            <tr>
                                <td></td>
                                <td style="text-align: right"><strong style="font-family:'Bookman Old'; font-size:130%;">TOTAL LIABILITIES: @if ($get_saln->liabilities_total)
                                    <u style="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ number_format($get_saln->liabilities_total, 2, '.', ',') }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                                @else
                                    N/A
                                @endif </strong></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td style="text-align: right"><strong style="font-family:'Bookman Old'; font-size:130%;">NET WORTH : Total Assets less Total Liabilities = @if ($get_saln->net_worth)<u style="p">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ number_format($get_saln->net_worth, 2, '.', ',') }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> @else N/A @endif </strong></td>
                            </tr>
                            <tr>

                                <td ><em style="font-family:'Bookman Old'; font-size:130%;">* Additional sheet/s may be used, if necessary.</em> </td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>


                        <table style="font-size: 10px"  width = "100%">
                            <tr>
                                <th ><h1 style="font-family:'Bookman Old'; font-size:130%;"><u> BUSINESS INTERESTS AND FINANCIAL CONNECTIONS</u></h1> </th>

                            </tr>
                            <tr style="text-align: center">
                                <td >
                                    <em style="font-family:'Bookman Old'; font-size:120%;">(of Declarant /Declarant’s spouse/ Unmarried Children Below Eighteen (18) years of Age Living in Declarant’s Household)</em>
                                </td>
                            </tr>
                            <tr style="text-align: center">
                                <td >
                                    <div style="font-family:'Bookman Old'; font-size:130%;margin-top: 1px; display:flex ">
                                        <input type="checkbox" style="margin-bottom: -7px" {{ ( $get_saln->biafc_has_business_interest == 1 ? ' checked' : '') }}><i style="font-family:'Bookman Old'">I/We do not have any business interest or financial connection.</i>
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <table id="data" width = "100%" style="text-align: center;table-layout: fixed ;">
                            <thead style="background: #c3c3c3">
                                <tr>

                                    <td ><strong>NAME OF ENTITY/BUSINESS ENTERPRISE</strong></td>
                                    <td ><strong>BUSINESS ADDRESS</strong></td>
                                    <td ><strong>NATURE OF BUSINESS INTEREST &/OR FINANCIAL CONNECTION</strong></td>
                                    <td ><strong>DATE OF ACQUISITION OF INTEREST OR CONNECTION</strong></td>

                                </tr>
                            </thead>
                            <tbody>

                                @php
                                    $biafc_row_max = 4;
                                    $biafc_row_current = 0;
                                @endphp

                                @forelse ($get_saln->get_biafc as $biafc)
                                    @php
                                        $biafc_row_current++;
                                    @endphp
                                    <tr>
                                        <td style="height: 20px">
                                            @if ($biafc->name_of_entity)
                                            <strong style="font-family:'Bookman Old'; font-size:130%;">{{ $biafc->name_of_entity }}</strong>
                                            @else
                                            <strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($biafc->business_address)
                                            <strong style="font-family:'Bookman Old'; font-size:130%;">{{ $biafc->business_address }}</strong>
                                            @else
                                            <strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($biafc->nature_of_business_interest)
                                            <strong style="font-family:'Bookman Old'; font-size:130%;">{{ $biafc->nature_of_business_interest }}</strong>
                                            @else
                                            <strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($biafc->date_of_acquisistion)
                                            <strong style="font-family:'Bookman Old'; font-size:130%;">{{ $biafc->date_of_acquisistion }}</strong>
                                            @else
                                            <strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                @php
                                    $biafc_row_current = $biafc_row_max;
                                @endphp
                                    <tr>
                                        <td style="height: 20px"><strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong></td>
                                    </tr>
                                    <tr>
                                        <td style="height: 20px"><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                    </tr>
                                    <tr>
                                        <td style="height: 20px"><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                    </tr>
                                    <tr>
                                        <td style="height: 20px"><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                    </tr>
                                @endforelse

                                @php
                                    $biafc_row_added = $biafc_row_max - $biafc_row_current;
                                @endphp
                                @for ($i = 1; $i <= $biafc_row_added; $i++)
                                    <tr>
                                        <td style="height: 20px"><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                    </tr>
                                @endfor

                            </tbody>

                        </table>


                        <table style="font-size: 10px"  width = "100%">
                            <tr>
                                <th ><h1 style="font-family:'Bookman Old'; font-size:130%;"><u>RELATIVES IN THE GOVERNMENT SERVICE</u> </h1> </th>

                            </tr>
                            <tr style="text-align: center">
                                <td >
                                    <em style="font-family:'Bookman Old'; font-size:120%;">(Within the Fourth Degree of Consanguinity or Affinity. Include also Bilas, Balae and Inso)</em>
                                </td>
                            </tr>
                            <tr style="text-align: center">
                                <td >
                                    <div style="font-family:'Bookman Old'; font-size:130%;margin-top: 1px; display:flex ">
                                        <input type="checkbox" style="margin-bottom: -7px" {{ ( $get_saln->ritgs_has_gov_serv_relative == 1 ? ' checked' : '') }}><i style="font-family:'Bookman Old'">I/We do not know of any relative/s in the government service)</i>
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <table id="data" width = "100%" style="text-align: center; table-layout: fixed ;">
                            <thead style="background: #c3c3c3">
                                <tr>

                                    <td ><strong> NAME OF RELATIVE</strong></td>
                                    <td ><strong>RELATIONSHIP</strong></td>
                                    <td ><strong>POSITION</strong></td>
                                    <td ><strong>NAME OF AGENCY/OFFICE AND ADDRESS</strong></td>

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $ritgs_row_max = 5;
                                    $ritgs_row_current = 0;
                                @endphp

                                @forelse ($get_saln->get_ritgs as $ritgs)
                                    @php
                                        $ritgs_row_current++;
                                    @endphp
                                    <tr>
                                        <td>
                                            @if ($ritgs->name_of_relative)
                                            <strong style="font-family:'Bookman Old'; font-size:130%;">{{ $ritgs->name_of_relative }}</strong>
                                            @else
                                            <strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($ritgs->relationship)
                                            <strong style="font-family:'Bookman Old'; font-size:130%;">{{ $ritgs->relationship }}</strong>
                                            @else
                                            <strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($ritgs->position)
                                            <strong style="font-family:'Bookman Old'; font-size:130%;">{{ $ritgs->position }}</strong>
                                            @else
                                            <strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($ritgs->name_of_agency)
                                            <strong style="font-family:'Bookman Old'; font-size:130%;">{{ $ritgs->name_of_agency }}</strong>
                                            @else
                                            <strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    @php
                                        $ritgs_row_current = $ritgs_row_max;
                                    @endphp
                                    <tr>
                                        <td style="height: 20px"><strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;">N/A</strong></td>
                                    </tr>
                                    <tr>
                                        <td style="height: 20px"><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                    </tr>
                                    <tr>
                                        <td style="height: 20px"><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                    </tr>
                                    <tr>
                                        <td style="height: 20px"><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                    </tr>
                                    <tr>
                                        <td style="height: 20px"><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                    </tr>
                                @endforelse
                                @php
                                    $ritgs_row_added = $ritgs_row_max - $ritgs_row_current;
                                @endphp
                                @for ($i = 1; $i <= $ritgs_row_added; $i++)
                                    <tr>
                                        <td style="height: 20px"><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                        <td><strong style="font-family:'Bookman Old'; font-size:130%;"></strong></td>
                                    </tr>
                                @endfor

                            </tbody>

                        </table>

                        <div style="text-align: justify; text-indent: 2em;line-height: 2 ;font-family:'Bookman Old'; font-size:90%;margin-top: 2px; padding:10px">I hereby certify that these are true and correct statements of my assets, liabilities, net worth, business interests and financial connections, including those of my spouse and unmarried children below eighteen (18) years of age living in my household, and that to the best of my knowledge, the above-enumerated are names of my relatives in the government within the fourth civil degree of consanguinity or affinity. </div>

                        <div style="text-align: justify; text-indent: 2em;line-height: 2 ;font-family:'Bookman Old'; font-size:90%;margin-top: 2px; padding:10px">I hereby authorize the Ombudsman or his/her duly authorized representative to obtain and secure from all appropriate government agencies, including the Bureau of Internal Revenue such documents that may show my assets, liabilities, net worth, business interests and financial connections, to include those of my spouse and unmarried children below 18 years of age living with me in my household covering previous years to include the year I first assumed office in government.</div>


                        <table width = "100%" style="font-family:'Bookman Old'; text-align: left">
                            <tr>
                                <td style="font-family:'Bookman Old'; font-size:120%;">Date:</td>
                            </tr>
                        </table>


                        <table width = "100%" style="text-align: left;border-spacing: 60px 5px ;">
                            <tr>
                                <td width = "50%">
                                    <div style=" border-bottom: 1pt solid black; text-align:center">
                                        @if ($get_saln->declarant_lastname)
                                            {{  $get_saln->declarant_lastname }}
                                        @else
                                            N/A
                                        @endif
                                        @if ($get_saln->declarant_firstname)
                                            {{  $get_saln->declarant_firstname }}
                                        @else
                                            N/A
                                        @endif
                                        @if ($get_saln->declarant_middlename)
                                            {{  ucfirst(Str::limit($get_saln->declarant_middlename, 1, '.')) }}
                                        @else
                                            N/A
                                        @endif
                                    </div>
                                    <div style="text-align: center"> <em style="font-family:'Bookman Old'; font-size:120%;">(Signature of Declarant)</em></div>
                                </td>
                                <td width = "50%">
                                    <div style="  border-bottom: 1pt solid black; text-align:center; border-bottom-width: 50%">
                                            @if ($get_saln->spouse_lastname)
                                                {{  $get_saln->spouse_lastname }}
                                            @else

                                            @endif
                                            @if ($get_saln->spouse_firstname)
                                                {{  $get_saln->spouse_firstname }}
                                            @else
                                                N/A
                                            @endif
                                            @if ($get_saln->spouse_middlename)
                                                {{  ucfirst(Str::limit( $get_saln->spouse_middlename, 1, '.')) }}
                                            @else

                                            @endif
                                    </div>
                                    <div style="text-align: center"> <em style="font-family:'Bookman Old'; font-size:120%;">(Signature of Co-Declarant/Spouse)</em></div>
                                </td>
                            </tr>
                        </table>


                        <table width = "100%" style="text-align: left">
                            <tr>
                                <td width = "50%" >
                                    <table width = "100%" style="border-spacing: 10px 5px ;">
                                        <tr>
                                            <td width = "40%" style="font-family:'Bookman Old'; font-size:120%;">Government Issued ID: </td>
                                            <td width = "60%" style=" border-bottom: 1pt solid black;">
                                                @if ($get_saln->declarant_id)
                                                    {{  $get_saln->declarant_id }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-family:'Bookman Old'; font-size:120%;">ID No.:</td>
                                            <td style=" border-bottom: 1pt solid black;">
                                                @if ($get_saln->declarant_id_num)
                                                    {{  $get_saln->declarant_id_num }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-family:'Bookman Old'; font-size:120%;">Date Issued: </td>
                                            <td style=" border-bottom: 1pt solid black;">
                                                @if ($get_saln->declarant_id_date)
                                                    {{  $get_saln->declarant_id_date }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>

                                    </table>
                                </td>
                                <td width = "50%" >
                                    <table width = "100%" style="border-spacing: 10px 5px ;">

                                        <tr>
                                            <td width = "40%" style="font-family:'Bookman Old'; font-size:120%;">Government Issued ID: </td>
                                            <td width = "60%" style=" border-bottom: 1pt solid black;">
                                                @if ($get_saln->spouse_id)
                                                    {{  $get_saln->spouse_id }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-family:'Bookman Old'; font-size:120%;">ID No.:</td>
                                            <td style=" border-bottom: 1pt solid black;">
                                                @if ($get_saln->spouse_id_num)
                                                    {{  $get_saln->spouse_id_num }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-family:'Bookman Old'; font-size:120%;">Date Issued: </td>
                                            <td style=" border-bottom: 1pt solid black;">
                                                @if ($get_saln->spouse_id_date)
                                                    {{  $get_saln->spouse_id_date }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>

                                    </table>
                                </td>
                            </tr>
                        </table>


                        <div style="text-align: justify; text-indent: 2em;line-height: 2 ;font-family:'Bookman Old'; font-size:85%;margin-top: 2px; padding:10px"><strong>SUBSCRIBED AND SWORN</strong> to before me this ______________ day of ______________, affiant exhibiting to me the above-stated government issued identification card.</div>


                        <table width = "100%" style="text-align: left">
                            <tr>
                                <td  width = "500px">
                                    <div style="text-align: center"></div>
                                    <div style="text-align: center"></div>
                                </td>
                                <td >
                                    <div style=" border-bottom: 1pt solid black; text-align:center"></div>
                                    <div style="text-align: center"> <em style="font-family:'Bookman Old'; font-size:120%;">(Person Administering Oath)</em></div>
                                </td>
                            </tr>
                        </table>

                    </div>

                <div style="font-size: 10px" class = "information">
                    <div>

                    </div>
                </div>


        </main>


    </body>

    </html>
