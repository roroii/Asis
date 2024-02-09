<!DOCTYPE html>
<html>

<head>

    <meta charset = "UTF-8">
    <title>{{ $agency_name->value }}</title>

    <style type = "text/css">
        /** Define the margins of your page **/
        @page {

            size: 21cm 29.7cm;
            margin: 20px 20px 20px 20px;

            /**
            margin: 10px 5px 15px 20px;
                top margin is 10px
                right margin is 5px
                bottom margin is 15px
                left margin is 20px
                **/

            /*margin: 5px 5px 5px 5px;*/
        }
        @media print {
            html, body {
                width: 21.59cm;
                height: 33.02cm;
            }
        }

        body {

            margin: 3px 3px 3px 3px;
            /*border-top:0.031rem solid;*/
            /*border-bottom:0.031rem solid;*/
            /*border-left:0.031rem solid;*/
            /*border-right:0.031rem solid;*/
        }

        a {
            color          : #fff;
            text-decoration: none;
        }

        table {
            font-size:13px;
            font-style: normal;
            src: url('/public/src/fonts/bookman-old-style/bookman-old-style.ttf');
            border: 2px single black;
        }
        td { border: thin single black collapse }

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
            bottom: -10px;
            left: 0px;
            right: 0px;
            height: 50px;
            /** Extra personal styles **/
            /* background-color: #03a8f400; */
            color: rgb(0, 0, 0);
            text-align: center;
            line-height: 35px;
        }

        .lg\:text-left{
            text-align: left;
        }
        .lg\:text-center{
            text-align: center;
        }
        .lg\:text-right{
            text-align: right;
        }
        .lg\:text-justify{
            text-align: justify;
        }
        .lg\:text-3xl{
            font-size: 1.875rem;
            line-height: 2.25rem;
        }
        .font-medium{
            font-weight: 500;
        }
        .font-normal{
            font-weight: 400;
        }
        .font-semibold{
            font-weight: 600;
        }
        .font-bold{
            font-weight: 700;
        }
        .font-extrabold{
            font-weight: 800;
        }

        .text-xl{
            font-size: 1.25rem;
            line-height: 1.75rem;
        }
        .text-3xl{
            font-size: 1.875rem;
            line-height: 2.25rem;
        }
        .text-2xl{
            font-size: 1.5rem;
            line-height: 2rem;
        }
        .text-sm{
            font-size: 0.875rem;
            line-height: 1.25rem;
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

        #my_data {
            border-collapse: collapse;
        }
        #my_data th {
            border: 0.006rem solid #000000;
            border-collapse: collapse;
        }
        #my_data td {
            border: 0.006rem solid #000000;
            border-collapse: collapse;
        }

        .tex-uppercase{
            text-transform: uppercase;
        }

        .text-6px-new {
            font-size: 50%;
            line-height: .6rem;
        }

        .text-7px-new {
            font-size: 60%;
            line-height: .6rem;
        }

        .text-7px {
            font-size: 7px;
            line-height: 1rem;
        }

        .text-8px {
            font-size: 70%;
            line-height: 1rem;
        }

        .text-8-new-px {
            font-size: 70%;
            line-height: .6rem;
        }

        .hidden{
            visibility: hidden;
        }
        .text-9px {
            font-size:  0.563rem;
            line-height: 1rem;
        }

        .text-10px {
            font-size: 0.625rem;
            line-height: 1rem;
        }

        .text-11px {
            font-size:  0.688rem;
            line-height: 1rem;
        }

        .text-11px-new {
            font-size:  0.688rem;
            line-height: 0.8rem;
        }

        .text-12px {
            font-size:  0.75rem;
            line-height: 0.8rem;
        }

        .text-lg{
            font-size: 1.125rem;
            line-height: 1.75rem;
        }

        .text-15px {
            font-size:  1rem;
            line-height: 1rem;
        }

        .text-22px {
            font-size:  1.5rem;
            line-height: 1.5rem;
        }

        .font-normal{
            font-weight: normal;
        }

        .font-bold{
            font-weight: bold;
        }

        .arial-black {
            font-family: Arial Black,Arial Bold,Gadget,sans-serif;
        }

        .calibri {
            font-family: Calibri, sans-serif;
        }

        .arial{
            font-family: Arial, sans-serif;
        }

        .underlined{

            text-decoration: underline;
        }

        .py-5px{

            padding-bottom: 5px;
            padding-top: 5px;
        }

        .text-italic{

            font-style: italic;
        }

        .border-top-bold{
            border-top: 0.090rem solid;
        }

        .border-right-bold{
            border-right: 0.090rem solid;
        }

        .border-left-bold{
            border-left: 0.090rem solid;
        }

        .border-bottom-bold{
            border-bottom: 0.090rem solid;
        }

        .border-box-bold {
            border-top: 0.090rem solid;
            border-bottom: 0.090rem solid;
            border-left: 0.090rem solid;
            border-right:0.090rem solid;
        }

        .border-top{
            border-top:0.031rem solid;
        }

        .border-left{
            border-left:0.031rem solid;
        }
        .border-right{
            border-right:0.031rem solid;
        }
        .border-bottom{
            border-bottom:0.031rem solid;
        }
        .border-box {
            border-top:0.031rem solid;
            border-bottom:0.031rem solid;
            border-left:0.031rem solid;
            border-right:0.031rem solid;
        }

        .border-bottom-custom{
            border-bottom:0.010rem solid;
        }

        .column-color{
            background:#eaeaea;
        }

        .collapse{
            border-collapse: collapse;
        }

        .my-table{
            border-collapse: collapse;
            width: 100%;
        }
        .my-table td{
            padding: 0.5rem;
            border-collapse: collapse;
        }

        .my-table th{
            padding: 0.5rem;
            border-collapse: collapse;
        }

        .my-table2{
            border-collapse: collapse;
            width: 100%;
        }
        .my-table2 td{
            padding: 0.25rem;
            border-collapse: collapse;
        }

        .reference-table{
            border-collapse: collapse;
            width: 100%;
        }
        .reference-table td{
            padding: 0.25rem;
            border-collapse: collapse;
        }

        .voluntary-work-table{
            border-collapse: collapse;
            width: 100%;
        }
        .voluntary-work-table th{
            height: 30px;
            border-collapse: collapse;
        }

        .voluntary-work-table td{
            height: 25px;
            border-collapse: collapse;
        }

        .ld-table{
            border-collapse: collapse;
            width: 100%;
        }
        .ld-table th{
            height: 30px;
            padding-left: 0.25rem;
            border-collapse: collapse;
        }

        .ld-table td{
            height: 25px;
            padding-left: 0.25rem;
            border-collapse: collapse;
        }

        .mt-1{
            margin-top: 0.25rem;
        }
        .-ml-5{
            margin-left: -1.25rem;
        }
        .mr-2{
            margin-right: 0.5rem;
        }
        .mr-3{
            margin-right: 0.75rem;
        }
        .mr-1{
            margin-right: 0.25rem;
        }
        .mt-2{
            margin-top: 0.5rem;
        }
        .mt-8{
            margin-top: 2rem;
        }
        .mr-auto{
            margin-right: auto;
        }
        .mt-5{
            margin-top: 1.25rem;
        }
        .mt-3{
            margin-top: 0.75rem;
        }
        .ml-0{
            margin-left: 0px;
        }
        .mr-0{
            margin-right: 0px;
        }
        .ml-3{
            margin-left: 0.75rem;
        }
        .mb-6{
            margin-bottom: 1.5rem;
        }
        .ml-1{
            margin-left: 0.25rem;
        }
        .ml-2{
            margin-left: 0.5rem;
        }
        .mt-10{
            margin-top: 2.5rem;
        }
        .-mr-2{
            margin-right: -0.5rem;
        }
        .-mt-2{
            margin-top: -0.5rem;
        }
        .mr-4{
            margin-right: 1rem;
        }
        .mt-4{
            margin-top: 1rem;
        }
        .-mt-0\.5{
            margin-top: -0.125rem;
        }
        .-mt-0{
            margin-top: -0px;
        }
        .mb-4{
            margin-bottom: 1rem;
        }
        .mb-2{
            margin-bottom: 0.5rem;
        }
        .mb-1{
            margin-bottom: 0.25rem;
        }
        .ml-auto{
            margin-left: auto;
        }
        .mt-0\.5{
            margin-top: 0.125rem;
        }
        .mt-0{
            margin-top: 0px;
        }

        .-mt-4{
            margin-top: -4px;
        }
        .-mt-5{
            margin-top: -5px;
        }
        .-mt-6{
            margin-top: -6px;
        }
        .-mt-7{
            margin-top: -7px;
        }
        .-mt-8{
            margin-top: -8px;
        }
        .-mt-9{
            margin-top: -9px;
        }
        .-mt-10{
            margin-top: -10px;
        }


        .-ml-4{
            margin-left: -1rem;
        }
        .mt-6{
            margin-top: 1.5rem;
        }
        .mt-7{
            margin-top: 1.7rem;
        }
        .-mt-12{
            margin-top: -3rem;
        }
        .mb-5{
            margin-bottom: 1.25rem;
        }
        .ml-6{
            margin-left: 1.5rem;
        }
        .ml-7{
            margin-left: 2.5rem;
        }
        .ml-4{
            margin-left: 1rem;
        }
        .-mt-1{
            margin-top: -0.25rem;
        }
        .-mr-1{
            margin-right: -0.25rem;
        }
        .ml-5{
            margin-left: 1.25rem;
        }
        .mr-5{
            margin-right: 1.25rem;
        }
        .mb-10{
            margin-bottom: 2.5rem;
        }
        .ml-0\.5{
            margin-left: 0.125rem;
        }
        .mt-12{
            margin-top: 3rem;
        }
        .-mb-6{
            margin-bottom: -1.5rem;
        }
        .mb-3{
            margin-bottom: 0.75rem;
        }
        .-ml-1{
            margin-left: -0.25rem;
        }
        .text-center{
            text-align: center;
        }
        .text-justify{
            text-align: justify;
        }
        .text-left{
            text-align: left;
        }
        .text-right{
            text-align: right;
        }
        .flex{
            display: flex;
        }
        .items-center{
            align-items: center;
        }

        .pl-1{
            padding-left: 0.25rem;
        }

        .px-1{
            padding-left: 0.25rem;
            padding-right: 0.25rem;
        }

        .px-2{
            padding-left: 0.50rem;
            padding-right: 0.50rem;
        }

        .pl-2{
            padding-left: 0.50rem;
        }


        .pr-2{
            padding-right: 0.50rem;
        }

        .p-2{

            padding-left: 0.50rem;
            padding-right: 0.50rem;
            padding-top: 0.50rem;
            padding-bottom: 0.50rem;
        }

        .h-20{
            height: 30px;
        }

        .h-15{
            height: 25px;
        }

        .personal-info-table{
            border-collapse: collapse;
            width: 100%;
        }
        .personal-info-table td{
            /*padding: 0.25rem;*/
            /*border-collapse: collapse;*/
            height: 20px;
        }

        .page_break { page-break-before: always; }

        .page-number:before {
            content: counter(page);
        }

    </style>

</head>

<header>

    @if ($agency_header)

        <img   class = "scale-down" src = "uploads/settings/{{ $agency_header->image }}" style = "width:100%">
    @else
        <img   class = "scale-down" src = "" style = "width:100%">
    @endif

</header>
<footer>

    @if ($agency_footer)

        <img   class = "scale-down" src = "uploads/settings/{{ $agency_footer->image }}" style = "width:100%">
    @else
        <img   class = "scale-down" src = "" style = "width:100%">
    @endif

</footer>

<body>
<table width="100%" style="margin-top: 3rem">
    <tr>
        <td width="60%">
            <div class="font-semibold text-primary text-3xl">{{ $agency_name->value }}</div>
        </td>
        <td class="40%">
            <div class="text-xl text-primary font-medium text-right">Davao del Sur State College</div>
{{--            <div class="mt-1 text-right text-11px-new">admission@dssc.edu.ph</div>--}}
            <div class="mt-1 text-right text-11px-new">Brgy. Matti, Digos City, Davao del Sur</div>
        </td>
    </tr>
</table>

<table width="100%" style="margin-top: 2rem">
    <tr>
        <td width="60%">
            <div>
                <div class="text-11px-new font-medium">Appointee Details:</div>
                <div class="text-12px font-medium mt-2">{{ $client_name }}</div>
                <div class="text-11px-new mt-1">{{ $email }}</div>
                <div class="text-11px-new mt-1">{{ $address }}</div>
            </div>
        </td>
        <td class="40%">
            <div class="text-right">
                <div class="text-11px-new font-medium">Transaction ID:</div>
                <div class="text-12px font-medium mt-2">#{{ $transactions_ID  }}</div>
                <div class="text-11px-new mt-1">{{ $transactions_Date }}</div>
            </div>
        </td>
    </tr>
</table>


<table width="100%" style="margin-top: 2rem" class="border-box my-table">
    <thead>
    <tr>
        <th class="text-left text-12px border-bottom border-right">DESCRIPTION</th>
        <th class="text-center text-12px border-bottom border-right">DATE / TIME</th>
        <th class="text-center text-12px border-bottom border-right">ADDRESS</th>
        <th class="text-center text-12px border-bottom ">STATUS</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td width="40%" class="border-right">
            <div class="text-11px-new pr-2">ENTRANCE EXAM FOR THE SCHOOL YEAR: {{ $active_schoolYear->key_value }}, {{ $active_sem }} </div>
        </td>
        <td width="20%" class="border-right">
            <div class="text-11px-new text-center">{{ $scheduled_date }} - <span class="font-bold underlined">{{ $date_desc }}</span></div>
        </td>
        <td width="30%" class="border-right">
            <div class="text-11px-new ">Davao del Sur State College - Main Campus</div>
        </td>
        <td width="10%" class="text-center">
            <div class="text-11px-new text-primary" style="{{ $status_class }}">{{ $status }}</div>
        </td>
    </tr>
    </tbody>

</table>

<table width="100%" style="margin-top: 2rem">
    <tr>
        <td width="60%">
            <div>
                <div class="text-11px-new font-medium">Approved By:</div>
                <div class="text-12px font-medium mt-2">{{ $approved_by }}</div>
                <div class="text-11px-new mt-1">{{ $position_designation }}</div>
                <div class="text-11px-new mt-1">{{ $approving_email }}</div>
            </div>
        </td>
        <td class="40%">
            <div class="text-right">
                <div class="text-11px-new font-medium">This is a System Generated Report (ASIS-Student Portal)</div>
                <div class="text-11px-new font-medium">Date Printed:</div>
                <div class="text-11px-new mt-1" >{{ $current_date }}</div>
            </div>
        </td>
    </tr>
</table>

</body>
</html>
