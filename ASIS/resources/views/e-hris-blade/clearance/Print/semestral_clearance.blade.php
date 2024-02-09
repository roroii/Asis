<!DOCTYPE html>
<html>
<head>
    <meta charset = "UTF-8">
    <title>{{ $filename }}</title>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">

    <style type = "text/css">
        @page {
            margin: 30px 0px 45px 0px;
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
            margin-bottom:1em;
        }
        .itm:nth-child(3n+1){
            clear:left;
        }
        .equ {
            display: inline-block;
            width: 40px;
            height: 180px;
            background:
                linear-gradient(transparent 80%, #333333 20%)0 0/100% 40px,
                linear-gradient(orange, yellow);
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            text-align: left;
            padding: 8px;
        }
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

<body>

<h2 style="text-align: center">SEMESTRAL CLEARANCE</h2>

<table>
    <tr>
        <th colspan="6">TO WHOM IT MAY CONCERN:</th>
    </tr>
    <tr>
        <td style="text-align: center">This</td>
        <td>is</td>
        <td>to</td>
        <td>certify</td>
        <td>that</td>
        <td style="text-align: right">Mr/Mrs/Miss</td>
    </tr>
    <tr>
        <td colspan="6">_____________________________________________________________________ of ___________________________________</td>
    </tr>
    <tr>
        <td colspan="6">Department of <span style="font-weight: bold">@if($system_agency_name) {{ $system_agency_name->value }} @endif</span> has submitted the</td>
    </tr>
    <tr>
        <td colspan="6">following documents this <span style="text-decoration: underline; font-weight: bold">1st</span> Semester, <span style="text-decoration: underline; font-weight: bold">SY 2022-2023.</span> </td>
    </tr>

    <tr>
        <td colspan="6"><span style="visibility: hidden">SPACE</span></td>
    </tr>

    <tr>
        <td colspan="2"><strong>DOCUMENTS</strong></td>
        <td></td>
        <td></td>
        <td colspan="2"><strong>SIGNATURE</strong></td>
    </tr>

    <tr>
        <td colspan="6"><span style="visibility: hidden">SPACE</span></td>
    </tr>

    @if($clearance)
        @foreach($clearance as $cl)
            <tr>
                <td colspan="2">{{ $cl->documents }}</td>
                <td></td>
                <td></td>
                <td colspan="2">
                    <div style="text-decoration: underline">
                        @if($cl->get_User_Details) {{  $cl->get_User_Details->firstname.' '.$cl->get_User_Details->lastname }} @else @endif
                    </div>
                    <div>
                        @if($cl->office) {{  $cl->office }} @else @endif
                    </div>
                    <div>
                        Date:_____________
                    </div>
                </td>
            </tr>
        @endforeach
    @else
    @endif

    <tr>
        <td colspan="6"><span style="visibility: hidden">SPACE</span></td>
    </tr>

    @if($signatories)
        @foreach($signatories as $sign)
            <tr>
                <td colspan="6">
                    <div style="text-decoration: underline">{{ $sign->name }}</div>
                    <div >{{ $sign->for }}</div>
                    <div>
                        Date:_____________
                    </div>
                </td>
            </tr>
        @endforeach
    @else
    @endif


</table>

</body>
</html>
