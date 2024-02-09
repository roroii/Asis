<!doctype html>
<html lang = "en">

<head>
    <meta charset = "UTF-8">
    @if (system_settings())
        @php
            $system_title = system_settings()->where('key','agency_name')->first();
            $system_logo = system_settings()->where('key','agency_logo')->first();
        @endphp

        @if ($system_logo)

            <link style="border-radius: 50%" href="{{ asset('uploads/settings/'.$system_logo->image.'') }}" class=" rounded-full overflow-hidden shadow-lg image-fit zoom-in ml-5" rel="shortcut icon">

        @else
            <link href="" rel="shortcut icon">
        @endif

        @if ($system_title)
            <title>{{ $system_title->value }}</title>
        @else
            <title>{{ $system_title->value }}</title>
        @endif

    @else
        <link href="" rel="shortcut icon">
        <title>N/A</title>
    @endif


    @if (system_settings()->where('key','system_title')->first())
        @php
            $system_setting = system_settings()->where('key','system_title')->first();
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

            size: 21.59cm 33.02cm;
            margin: 5px 5px 5px 5px;

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
            font-size: 65%;
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
            /*padding: 0.25rem;*/
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

        .page_num:before {

            content: "Page " counter(page)  " of " counter(pages);

        }

        .page_num_total:before {
            counter-increment: page;
        }

    </style>

</head>

<body>

</footer>

<main >

    <!-- BEGIN: HEADER -->
    <table class="my-table">
        <tr class="border-left-bold border-right-bold border-top-bold">
            <td colspan="3" style="padding-left: 5px">
                <div style="font-style: italic; font-weight: bold;" class="calibri text-11px">CS Form No. 212</div>
                <div style="font-style: italic; font-weight: bold" class="calibri text-9px">Revised 2017</div>
            </td>
        </tr>

        <tr class="border-left-bold border-right-bold">
            <td colspan="3">
                <div class="text-center"><label style="font-weight: bold" class="arial text-22px">PERSONAL DATA SHEET</label></div>
            </td>
        </tr>

        <tr class="border-left-bold border-right-bold">
            <td colspan="3">
                <div style="text-align: left;"><label class="arial text-9px" style="font-weight: bold; font-style: italic;">WARNING: Any misrepresentation made in the Personal Data Sheet and the Work Experience Sheet shall cause the filing of administrative/criminal case/s against the person concerned.</label></div>
            </td>
        </tr>

        <tr class="border-left-bold border-right-bold">
            <td colspan="3">
                <div style="margin-top: 1px; text-align: left"><label class="arial text-8px" style="font-weight: bold; font-style: italic;">READ THE ATTACHED GUIDE TO FILLING OUT THE PERSONAL DATA SHEET (PDS) BEFORE ACCOMPLISHING THE PDS FORM.</label></div>
            </td>
        </tr>

        <!-- BEGIN: NUMBER 1. CS ID NO. -->
        <tr class="border-left-bold border-right-bold border-bottom">
            <td style="width: 70%">
                <div style="text-align: left" class="arial text-8px"><label>Print legibly. Tick appropriate boxes ( </label><label class="ml-2">) and use separate sheet if necessary. Indicate N/A if not applicable.</label><label style="font-weight: bold" class="arial text-10px ml-1">DO NOT ABBREVIATE.</label></div>
            </td>

            <td colspan="2">
                <div style="margin: -1px">
                    <table class="my-table">
                        <td bgcolor="#a9a9a9" style="width: 7%" class="border-top border-left border-right">
                            <div style=" text-align: left" class="arial text-8px">1. CS ID No.</div>
                        </td>
                        <td style="width: 23%" class="border-top">
                            <div style=" text-align: right" class="arial text-8px">(Do not fill up. For CSC use only)</div>
                        </td>
                    </table>
                </div>
            </td>
        </tr>
        <!-- END: NUMBER 1. CS ID NO. -->

    </table>
    <!-- END: HEADER -->



    <!-- BEGIN: I PERSONAL INFO -->
    <table  class="my-table">
        <tr>
            <td rowspan="2"  bgcolor="#a9a9a9" style="width: 100%;" class="border-bottom-bold border-top-bold border-left-bold border-right-bold pl-1">
                <div style="text-align: left"><label class="arial text-11px" style="font-weight: bold; font-style: italic; color: white">I. PERSONAL INFORMATION</label></div>
            </td>
        </tr>
    </table>
    <table class="personal-info-table">
        <tr>
            <td class="border-left-bold border-right border-top-bold column-color pl-1" style="width: 20%;">
                <div style="font-size:70%;margin-top: 1px; text-align: left" class="arial font-normal"><label>2.<label class="arial ml-2">SURNAME</label></label></div>
            </td>
            <td colspan="2" class="border-left border-right-bold border-bottom border-top-bold pl-1" style="width: 80%">
                <div style="margin-top: 1px; text-align: left"><label class="arial tex-uppercase text-8px" style="font-weight: bold;">@if($pds->lastname){{ $pds->lastname }} @else N/A @endif</label></div>
            </td>
        </tr>

        <tr>
            <td class="border-left-bold border-right column-color pl-1" style="width: 20%">
                <div style="font-size:70%;margin-top: 1px; text-align: left"><label class="arial ml-4" style="font-weight: normal;">FIRST NAME</label></div>
            </td>
            <td class="border-box pl-1" style="width: 50%">
                <div style="margin-top: 1px; text-align: left"><label class="arial tex-uppercase text-8px" style="font-weight: bold;">@if($pds->firstname){{ $pds->firstname }} @else N/A @endif</label></div>
            </td>
            <td class="border-right-bold pl-1 column-color" style="
            width: 30%">
                <div style="margin-top: 1px; text-align: left"><label class="arial tex-uppercase text-8px" style="font-weight: bold;"><label class="arial font-normal tex-uppercase">NAME EXTENSION(JR.SR.)</label><label class="ml-1 arial font-bold">@if($pds->extension){{ $pds->extension }} @else N/A @endif</label></div>
            </td>
        </tr>

        <tr>
            <td class="border-left-bold pl-1 border-right border-bottom-bold column-color" style="width: 20%">
                <div style="font-size:70%;margin-top: 1px; text-align: left"><label class="arial ml-4" style="font-weight: normal;">MIDDLE NAME</label></div>
            </td>
            <td colspan="2" class="border-bottom-bold border-left border-right-bold border-top pl-1" style="width: 80%">
                <div style="margin-top: 1px; text-align: left"><label class="arial tex-uppercase text-8px" style="font-weight: bold;">@if($pds->mi){{ $pds->mi }} @else N/A @endif</label></div>
            </td>
        </tr>

    </table>
    <table class="my-table">
        <tr>
            <td style="width: 100%;">
                <div style="margin: -1px">
                    <table class="my-table">

                        <!-- BEGIN: 3. DATE OF BIRTH HERE -->
                        <tr>
                            <td style="width: 20%; height: 12px;" class="border-right border-left-bold border-bottom arial column-color pl-1">
                                <div class="arial font-normal text-8px">3. DATE OF BIRTH<</div>
                                <div style="font-size: 7px; margin-top: -1px; margin-left: 10px" class="arial font-normal">(mm/dd/yyyy)</div>
                            </td>

                            <td class="border-right-bold border-bottom pl-1" style="width: 25%">
                                <div style="margin-top: 1px; text-align: left"><label class="arial text-8px tex-uppercase" style="font-weight: bold;">@if($pds->dateofbirth){{ Carbon\Carbon::parse($pds->dateofbirth)->format('m/d/Y') }} @else N/A @endif</label></div>
                            </td>

                            <td class="border-left border-right column-color pl-1" style="width: 20%">
                                <div style="margin-top: 1px; text-align: left"><label class="arial text-8px" style="font-weight: normal;">16. CITIZENSHIP</label></div>
                            </td>

                            <td style="width: 35%" class="border-left border-right-bold pl-1">
                                <div class="arial font-normal text-8px">

                                    @if($pds->citizenship == "Filipino")
                                        <input checked type="checkbox" class="ml-2" style="margin-bottom: -7px" id="fil_check" value="Filipino"> <label class="ml-1">Filipino</label>
                                        <input  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check" value="Dual Citizenship"><label class="ml-1">Dual Citizenship</label>
                                    @elseif($pds->citizenship == "DUAL_CITIZENSHIP")
                                        <input type="checkbox" class="ml-2" style="margin-bottom: -7px" id="fil_check" value="Filipino"> <label class="ml-1">Filipino</label>
                                        <input checked  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check" value="Dual Citizenship"><label class="ml-1">Dual Citizenship</label>
                                    @else
                                        <input type="checkbox" class="ml-2" style="margin-bottom: -7px" id="fil_check" value="Filipino"> <label class="ml-1">Filipino</label>
                                        <input type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check" value="Dual Citizenship"><label class="ml-1">Dual Citizenship</label>
                                    @endif

                                </div>
                            </td>

                        </tr>
                        <!-- END: 3. DATE OF BIRTH HERE -->

                        <!-- BEGIN: 4. PLACE OF BIRTH HERE -->
                        <tr>
                            <td style="width: 20%; height: 12px;" class="border-right border-left-bold border-bottom arial column-color pl-1">
                                <div class="arial font-normal text-8px">4. PLACE OF BIRTH </div>
                            </td>

                            <td class="border-right-bold border-bottom pl-1" style="width: 25%">
                                <div style="margin-top: 1px; text-align: left"><label class="arial text-8-new-px tex-uppercase" style="font-weight: bold;">@if($pds->placeofbirth){{ $pds->placeofbirth }} @else N/A @endif</label></div>
                            </td>

                            <td class="border-left border-right column-color pl-1" style="width: 20%">
                                <div class="text-center" style="margin-top: 1px;"><label class="arial text-8px" style="font-weight: normal;">If holder of  dual citizenship, </label></div>
                            </td>

                            <td style="width: 35%" class="border-left border-right-bold pl-1">
                                <div style="margin-left: 95px" class="arial font-normal text-8px">

                                    @if($pds->dual_citizenship_type == "BY_BIRTH")
                                            <input checked type="checkbox" class="ml-2" style="margin-bottom: -7px" id="fil_check" value="Filipino"> <label class="ml-1">by birth</label>
                                            <input  type="checkbox" style="margin-bottom: -7px; margin-left: 5px" id="dual_check" value="Dual Citizenship"><label class="ml-1">by naturalization</label>
                                        @elseif($pds->dual_citizenship_type == "BY_NATURALIZATION")
                                            <input type="checkbox" class="ml-2" style="margin-bottom: -7px" id="fil_check" value="Filipino"> <label class="ml-1">by birth</label>
                                            <input checked  type="checkbox" style="margin-bottom: -7px; margin-left: 5px" id="dual_check" value="Dual Citizenship"><label class="ml-1">by naturalization</label>
                                        @else
                                            <input type="checkbox" class="ml-2" style="margin-bottom: -7px" id="fil_check" value="Filipino"> <label class="ml-1">by birth</label>
                                            <input type="checkbox" style="margin-bottom: -7px; margin-left: 5px" id="dual_check" value="Dual Citizenship"><label class="ml-1">by naturalization</label>
                                    @endif

                                </div>

                                <div style="margin-left: 110px" class="arial font-normal text-8px">Pls. indicate country:</div>

                            </td>
                        </tr>
                        <!-- END: 4. PLACE OF BIRTH HERE -->

                        <!-- BEGIN: 5. SEX -->
                        <tr>
                            <td style="width: 20%; height: 12px;" class="border-right border-left-bold border-bottom arial column-color pl-1">
                                <div class="arial font-normal text-8px">5. SEX </div>
                            </td>

                            <td class="border-right-bold border-bottom pl-1" style="width: 25%">
                                <div class="arial font-normal text-8px">
                                    @if($pds->sex == "Male")
                                        <input checked type="checkbox" class="ml-2" style="margin-bottom: -7px" id="fil_check" value="Filipino"> <label class="ml-1">Male</label>
                                        <input  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check" value="Dual Citizenship"><label class="ml-1">Female</label>
                                    @elseif($pds->sex == "Female")
                                        <input type="checkbox" class="ml-2" style="margin-bottom: -7px" id="fil_check" value="Filipino"> <label class="ml-1">Male</label>
                                        <input checked  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check" value="Dual Citizenship"><label class="ml-1">Female</label>
                                    @else
                                        <input type="checkbox" class="ml-2" style="margin-bottom: -7px" id="fil_check" value="Filipino"> <label class="ml-1">Male</label>
                                        <input type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check" value="Dual Citizenship"><label class="ml-1">Female</label>
                                    @endif
                                </div>
                            </td>

                            <td class="border-left border-right column-color pl-1" style="width: 20%">
                                <div class="text-center" style="margin-top: 1px;"><label class="arial text-8px" style="font-weight: normal;">please indicate the details. </label></div>
                            </td>

                            <td style="width: 35%" class="border-left border-top border-right-bold pl-1">
                                <div class="arial font-normal text-8px text-center font-bold">@if($pds->dual_citizenship_country){{ $pds->dual_citizenship_country }} @else N/A @endif</div>
                            </td>

                        </tr>
                        <!-- END: 5. SEX -->

                    </table>
                </div>
            </td>
        </tr>

        <!-- BEGIN: 6. CIVIL STATUS -->
        <tr>
            <td style="width: 100%;">
                <div style="margin: -1px">
                    <table class="my-table">

                        <!-- BEGIN: 6. CIVIL STATUS -->
                        <tr>
                            <td style="width: 20%; height: 12px;" class="border-right border-left-bold border-bottom arial column-color pl-1">
                                <div class="arial font-normal text-8px">6. CIVIL STATUS </div>
                            </td>

                            <td class="border-right-bold border-bottom pl-1" style="width: 25%">
                                <div class="arial font-normal text-8px ml-2">
                                    @if($pds->civilstatus == "Single")
                                        <div><input checked type="checkbox" style="margin-bottom: -7px" id="dual_check"><label class="ml-1">Single</label>  <input  type="checkbox" style="margin-bottom: -7px; margin-left: 18px" id="dual_check"><label class="ml-1">Married</label></div>
                                        <div><input         type="checkbox" style="margin-bottom: -6px" id="dual_check"><label class="ml-1">Widowed</label> <input  type="checkbox" style="margin-bottom: -6px; margin-left: 6px" id="dual_check"><label class="ml-1">Separated</label></div>
                                        <div><input         type="checkbox" style="margin-bottom: -6px" id="dual_check"><label class="ml-1">Other/s:</label></div>
                                    @elseif($pds->civilstatus == "Married")
                                        <div><input         type="checkbox" style="margin-bottom: -7px" id="dual_check"><label class="ml-1">Single</label>  <input checked type="checkbox" style="margin-bottom: -7px; margin-left: 18px" id="dual_check"><label class="ml-1">Married</label></div>
                                        <div><input         type="checkbox" style="margin-bottom: -6px" id="dual_check"><label class="ml-1">Widowed</label> <input  type="checkbox" style="margin-bottom: -6px; margin-left: 6px" id="dual_check"><label class="ml-1">Separated</label></div>
                                        <div><input         type="checkbox" style="margin-bottom: -6px" id="dual_check"><label class="ml-1">Other/s:</label></div>
                                    @elseif($pds->civilstatus == "Widowed")
                                        <div><input         type="checkbox" style="margin-bottom: -7px" id="dual_check"><label class="ml-1">Single</label>  <input  type="checkbox" style="margin-bottom: -7px; margin-left: 18px" id="dual_check"><label class="ml-1">Married</label></div>
                                        <div><input checked type="checkbox" style="margin-bottom: -6px" id="dual_check"><label class="ml-1">Widowed</label> <input  type="checkbox" style="margin-bottom: -6px; margin-left: 6px" id="dual_check"><label class="ml-1">Separated</label></div>
                                        <div><input         type="checkbox" style="margin-bottom: -6px" id="dual_check"><label class="ml-1">Other/s:</label></div>
                                    @elseif($pds->civilstatus == "Separated")
                                        <div><input         ype="checkbox"  style="margin-bottom: -7px" id="dual_check"><label class="ml-1">Single</label>  <input  type="checkbox" style="margin-bottom: -7px; margin-left: 18px" id="dual_check"><label class="ml-1">Married</label></div>
                                        <div><input         type="checkbox" style="margin-bottom: -6px" id="dual_check"><label class="ml-1">Widowed</label> <input checked type="checkbox" style="margin-bottom: -6px; margin-left: 6px" id="dual_check"><label class="ml-1">Separated</label></div>
                                        <div><input         type="checkbox" style="margin-bottom: -6px" id="dual_check"><label class="ml-1">Other/s:</label></div>
                                    @elseif($pds->civilstatus == "Others")
                                        <div><input         type="checkbox" style="margin-bottom: -7px" id="dual_check"><label class="ml-1">Single</label>  <input  type="checkbox" style="margin-bottom: -7px; margin-left: 18px" id="dual_check"><label class="ml-1">Married</label></div>
                                        <div><input         type="checkbox" style="margin-bottom: -6px" id="dual_check"><label class="ml-1">Widowed</label> <input  type="checkbox" style="margin-bottom: -6px; margin-left: 6px" id="dual_check"><label class="ml-1">Separated</label></div>
                                        <div><input checked type="checkbox" style="margin-bottom: -6px" id="dual_check"><label class="ml-1">Other/s:</label></div>
                                    @else
                                        <div><input         type="checkbox" style="margin-bottom: -7px" id="dual_check"><label class="ml-1">Single</label>  <input  type="checkbox" style="margin-bottom: -7px; margin-left: 18px" id="dual_check"><label class="ml-1">Married</label></div>
                                        <div><input         type="checkbox" style="margin-bottom: -6px" id="dual_check"><label class="ml-1">Widowed</label> <input  type="checkbox" style="margin-bottom: -6px; margin-left: 6px" id="dual_check"><label class="ml-1">Separated</label></div>
                                        <div><input         type="checkbox" style="margin-bottom: -6px" id="dual_check"><label class="ml-1">Other/s:</label></div>
                                    @endif
                                </div>

                            </td>

                            <td class="border-left border-top border-right column-color pl-1" style="width: 15%">
                                <div style="margin-top: -20px; font-size: 8px" class="arial font-normal">17. RESIDENTIAL ADDRESS</div>
                            </td>

                            <td style="width: 40%" class="border-left border-top border-right-bold">
                                <div style="margin: -1px">
                                    <table class="my-table" style="text-align:center">
                                        <tr >
                                            @if($res_address)
                                                <td class="border-bottom-custom" style="width:50%"><small style="font-weight:bold;font-size:9px" class="arial tex-uppercase"> @if($res_address->house_block_no){{ $res_address->house_block_no }} @else N/A @endif</small></td>
                                                <td class="border-bottom-custom" style="width:50%"><small style="font-weight:bold;font-size:9px" class="arial tex-uppercase">@if($res_address->street){{ $res_address->street }} @else N/A @endif</small></td>
                                            @else
                                                <td class="border-bottom-custom" style="width:50%"><small style="font-weight:bold;font-size:9px" class="arial tex-uppercase"> N/A </small></td>
                                                <td class="border-bottom-custom" style="width:50%"><small style="font-weight:bold;font-size:9px" class="arial tex-uppercase">N/A </small></td>
                                            @endif
                                        </tr>
                                        <tr class="border-bottom">
                                            <td class="border-bottom" style="width:50%"><small style="font-weight:normal;font-size:8px" class="arial">House/Block/Lot No.</small></td>
                                            <td class="border-bottom" style="width:50%"><small style="font-weight:normal;font-size:8px" class="arial">Street</small></td>
                                        </tr>
                                        <tr>
                                            @if($res_address)
                                                <td class="border-bottom-custom" style="width:50%"><small style="font-weight:bold;font-size:9px" class="arial tex-uppercase">@if($res_address->subdivision_village){{ $res_address->subdivision_village }} @else N/A @endif</small></td>
                                                <td class="border-bottom-custom" style="width:50%"><small style="font-weight:bold;font-size:9px" class="arial tex-uppercase">@if($res_address->get_brgy) @if($res_address->get_brgy->brgyDesc){{ $res_address->get_brgy->brgyDesc }} @else N/A @endif @else N/A @endif</small></td>
                                            @else
                                                <td class="border-bottom-custom" style="width:50%"><small style="font-weight:bold;font-size:9px" class="arial tex-uppercase">N/A</small></td>
                                                <td class="border-bottom-custom" style="width:50%"><small style="font-weight:bold;font-size:9px" class="arial tex-uppercase">N/A</small></td>
                                            @endif
                                        </tr>
                                        <tr style="">
                                            <td style="width:50%"><small style="font-weight:normal;font-size:8px" class="arial">Subdivision/Village</small></td>
                                            <td style="width:50%"><small style="font-weight:normal;font-size:8px" class="arial">Barangay</small></td>
                                        </tr>
                                    </table>
                                </div>
                            </td>

                        </tr>
                        <!-- END: 6. CIVIL STATUS -->

                        <!-- BEGIN: 7. HEIGHT (m) -->
                        <tr>
                            <td style="width: 20%; height: 12px;" class="border-right border-left-bold border-bottom arial column-color pl-1">
                                <div class="arial font-normal text-8px">7. HEIGHT (m) </div>
                            </td>

                            <td class="border-right-bold border-bottom pl-1" style="width: 25%">
                                <div class="arial font-normal text-8px font-bold">@if($pds->height){{ $pds->height }} @else N/A @endif</div>
                            </td>

                            <td class="border-left border-right column-color pl-1" style="width: 15%">
                                <div style="margin-top: 1px; font-size: 8px" class="arial font-normal"></div>
                            </td>

                            <td style="width: 40%" class="border-left border-top border-right-bold">
                                <div style="margin: -1px">
                                    <table class="my-table" style="text-align:center">
                                        <tr >
                                            @if($res_address)
                                                <td class="border-bottom-custom" style="width:50%"><small style="font-weight:bold;font-size:9px" class="arial tex-uppercase">@if($res_address->get_city_mun) @if($res_address->get_city_mun->citymunDesc){{ $res_address->get_city_mun->citymunDesc }} @else N/A @endif @else N/A @endif</small></td>
                                                <td class="border-bottom-custom" style="width:50%"><small style="font-weight:bold;font-size:9px" class="arial tex-uppercase">@if($res_address->get_province) @if($res_address->get_province->provDesc){{ $res_address->get_province->provDesc }} @else N/A @endif @else N/A @endif</small></td>
                                            @else
                                                <td class="border-bottom-custom" style="width:50%"><small style="font-weight:bold;font-size:9px" class="arial tex-uppercase">N/A</small></td>
                                                <td class="border-bottom-custom" style="width:50%"><small style="font-weight:bold;font-size:9px" class="arial tex-uppercase">N/A</small></td>
                                            @endif
                                        </tr>
                                        <tr class="border-bottom">
                                            <td class="border-bottom" style="width:50%"><small style="font-weight:normal;font-size:8px" class="arial">City/Municipality</small></td>
                                            <td class="border-bottom" style="width:50%"><small style="font-weight:normal;font-size:8px" class="arial">Province</small></td>
                                        </tr>
                                    </table>
                                </div>
                            </td>

                        </tr>
                        <!-- END: 7. HEIGHT (m) -->

                        <!-- BEGIN: 8. WEIGHT (kg) -->
                        <tr>
                            <td style="width: 20%; height: 12px;" class="border-right border-left-bold border-bottom arial column-color pl-1">
                                <div class="arial font-normal text-8px">8. WEIGHT (kg)</div>
                            </td>

                            <td class="border-right-bold border-left border-bottom pl-1" style="width: 25%">
                                <div class="arial font-normal text-8px font-bold">@if($pds->weight){{ $pds->weight }} @else N/A @endif</div>
                            </td>

                            <td class="border-left border-right column-color pl-1 text-center" style="width: 15%">
                                <div style="margin-top: 1px; font-size: 8px" class="arial font-normal">ZIP CODE</div>
                            </td>

                            <td style="width: 40%" class="border-left border-right-bold text-center">
                                <div class="arial font-normal text-8px font-bold">@if($res_address) @if($res_address->zip_code){{ $res_address->zip_code }} @else N/A @endif @else N/A @endif</div>
                            </td>
                        </tr>
                        <!-- END: 8. WEIGHT (kg) -->

                        <!-- BEGIN: 9. BLOOD TYPE -->
                        <tr>
                            <td style="width: 20%; height: 12px;" class="border-right border-left-bold border-bottom arial column-color pl-1">
                                <div class="arial font-normal text-8px">9. BLOOD TYPE</div>
                            </td>

                            <td class="border-right-bold border-bottom pl-1" style="width: 25%">
                                <div class="arial font-normal text-8px font-bold">@if($pds->bloodtype){{ $pds->bloodtype }} @else N/A @endif</div>
                            </td>

                            <td class="border-left border-top border-right column-color pl-1" style="width: 15%">
                                <div style="font-size: 8px; margin-top: -10px" class="arial font-normal">18. PERMANENT ADDRESS</div>
                            </td>

                            <td style="width: 40%" class="border-left border-top border-right-bold">
                                <div style="margin: -1px">
                                    <table class="my-table" style="text-align:center">
                                        <tr >
                                            @if($per_address)
                                                <td class="border-bottom-custom" style="width:50%"><small style="font-weight:bold;font-size:9px" class="arial tex-uppercase"> @if($per_address->house_block_no){{ $per_address->house_block_no }} @else N/A @endif</small></td>
                                                <td class="border-bottom-custom" style="width:50%"><small style="font-weight:bold;font-size:9px" class="arial tex-uppercase">@if($per_address->street){{ $per_address->street }} @else N/A @endif</small></td>
                                            @else
                                                <td class="border-bottom-custom" style="width:50%"><small style="font-weight:bold;font-size:9px" class="arial tex-uppercase"> N/A </small></td>
                                                <td class="border-bottom-custom" style="width:50%"><small style="font-weight:bold;font-size:9px" class="arial tex-uppercase">N/A </small></td>
                                            @endif
                                        </tr>
                                        <tr class="border-bottom">
                                            <td class="border-bottom" style="width:50%"><small style="font-weight:normal;font-size:8px" class="arial">House/Block/Lot No.</small></td>
                                            <td class="border-bottom" style="width:50%"><small style="font-weight:normal;font-size:8px" class="arial">Street</small></td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <!-- END: 9. BLOOD TYPE -->

                        <!-- BEGIN: 10. GSIS ID NO. -->
                        <tr>
                            <td style="width: 20%; height: 12px;" class="border-right border-left-bold border-bottom arial column-color pl-1">
                                <div class="arial font-normal text-8px">10. GSIS ID NO.</div>
                            </td>

                            <td class="border-right-bold border-bottom pl-1" style="width: 25%">
                                <div class="arial font-normal text-8px font-bold">@if($pds->gsis){{ $pds->gsis }} @else N/A @endif</div>
                            </td>

                            <td class="border-left border-right column-color pl-1" style="width: 15%">
                                <div style="font-size: 8px" class="arial font-normal"></div>
                            </td>

                            <td style="width: 40%" class="border-left border-right-bold">
                                <div style="margin: -1px">
                                    <table class="my-table" style="text-align:center">
                                        <tr>
                                            @if($per_address)
                                                <td class="border-bottom-custom" style="width:50%"><small style="font-weight:bold;font-size:9px" class="arial tex-uppercase">@if($per_address->subdivision_village){{ $per_address->subdivision_village }} @else N/A @endif</small></td>
                                                <td class="border-bottom-custom" style="width:50%"><small style="font-weight:bold;font-size:9px" class="arial tex-uppercase">@if($per_address->get_brgy) @if($per_address->get_brgy->brgyDesc){{ $per_address->get_brgy->brgyDesc }} @else N/A @endif @else N/A @endif</small></td>
                                            @else
                                                <td class="border-bottom-custom" style="width:50%"><small style="font-weight:bold;font-size:9px" class="arial tex-uppercase">N/A</small></td>
                                                <td class="border-bottom-custom" style="width:50%"><small style="font-weight:bold;font-size:9px" class="arial tex-uppercase">N/A</small></td>
                                            @endif
                                        </tr>
                                        <tr style="">
                                            <td style="width:50%"><small style="font-weight:normal;font-size:8px" class="arial">Subdivision/Village</small></td>
                                            <td style="width:50%"><small style="font-weight:normal;font-size:8px" class="arial">Barangay</small></td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <!-- END:   10. GSIS ID NO. -->

                        <!-- BEGIN: 11. PAG-IBIG ID NO. -->
                        <tr>
                            <td style="width: 20%; height: 12px;" class="border-right border-left-bold border-bottom arial column-color pl-1">
                                <div class="arial font-normal text-8px">11. PAG-IBIG ID NO.</div>
                            </td>

                            <td class="border-right-bold border-bottom pl-1" style="width: 25%">
                                <div class="arial font-normal text-8px font-bold">@if($pds->pagibig){{ $pds->pagibig }} @else N/A @endif</div>
                            </td>

                            <td class="border-left border-right column-color pl-1" style="width: 15%">
                                <div style="font-size: 8px" class="arial font-normal"></div>
                            </td>

                            <td style="width: 40%" class="border-left border-top border-right-bold">
                                <div style="margin: -1px">
                                    <table class="my-table" style="text-align:center">
                                        <tr>
                                            @if($per_address)
                                                <td class="border-bottom-custom" style="width:50%"><small style="font-weight:bold;font-size:9px" class="arial tex-uppercase">@if($per_address->get_city_mun) @if($per_address->get_city_mun->citymunDesc){{ $per_address->get_city_mun->citymunDesc }} @else N/A @endif @else N/A @endif</small></td>
                                                <td class="border-bottom-custom" style="width:50%"><small style="font-weight:bold;font-size:9px" class="arial tex-uppercase">@if($per_address->get_province) @if($per_address->get_province->provDesc){{ $per_address->get_province->provDesc }} @else N/A @endif @else N/A @endif</small></td>
                                            @else
                                                <td class="border-bottom-custom" style="width:50%"><small style="font-weight:bold;font-size:9px" class="arial tex-uppercase">N/A</small></td>
                                                <td class="border-bottom-custom" style="width:50%"><small style="font-weight:bold;font-size:9px" class="arial tex-uppercase">N/A</small></td>
                                            @endif
                                        </tr>
                                        <tr style="">
                                            <td style="width:50%"><small style="font-weight:normal;font-size:8px" class="arial">City/Municipality</small></td>
                                            <td style="width:50%"><small style="font-weight:normal;font-size:8px" class="arial">Province</small></td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <!-- END:   11. PAG-IBIG ID NO. -->


                        <!-- BEGIN: 12. PHILHEALTH NO. -->
                        <tr>
                            <td style="width: 20%; height: 12px;" class="border-right border-left-bold border-bottom arial column-color pl-1">
                                <div class="arial font-normal text-8px">12. PHILHEALTH NO.</div>
                            </td>

                            <td class="border-right-bold border-bottom pl-1" style="width: 25%">
                                <div class="arial font-normal text-8px font-bold">@if($pds->philhealth){{ $pds->philhealth }} @else N/A @endif</div>
                            </td>

                            <td class="border-left border-right border-bottom column-color pl-1" style="width: 15%">
                                <div style="font-size: 8px" class="arial font-normal text-center">ZIP CODE</div>
                            </td>

                            <td style="width: 40%" class="border-left border-top border-right-bold text-center">
                                <div class="arial font-normal text-8px font-bold">@if($per_address) @if($per_address->zip_code){{ $per_address->zip_code }} @else N/A @endif @endif</div>
                            </td>
                        </tr>
                        <!-- END:   12. PHILHEALTH NO. -->

                        <!-- BEGIN: 13. SSS NO. -->
                        <tr>
                            <td style="width: 20%; height: 12px;" class="border-right border-left-bold border-bottom arial column-color pl-1">
                                <div class="arial font-normal text-8px">13. SSS NO.</div>
                            </td>

                            <td class="border-right-bold border-bottom pl-1" style="width: 25%">
                                <div class="arial font-normal text-8px font-bold">@if($pds->sss){{ $pds->sss }} @else N/A @endif</div>
                            </td>

                            <td class="border-left border-right border-bottom column-color pl-1" style="width: 15%">
                                <div style="font-size: 8px" class="arial font-normal">19. TELEPHONE NO.</div>
                            </td>

                            <td style="width: 40%" class="border-left border-top border-right-bold text-center">
                                <div class="arial font-normal text-8px font-bold">@if($pds->telephone){{ $pds->telephone }} @else N/A @endif</div>
                            </td>
                        </tr>
                        <!-- END:   13. SSS NO. -->


                        <!-- BEGIN: 14. TIN NO. -->
                        <tr>
                            <td style="width: 20%; height: 12px;" class="border-right border-left-bold border-bottom arial column-color pl-1">
                                <div class="arial font-normal text-8px">14. TIN NO.</div>
                            </td>

                            <td class="border-right-bold border-bottom pl-1" style="width: 25%">
                                <div class="arial font-normal text-8px font-bold">@if($pds->tin){{ $pds->tin }} @else N/A @endif</div>
                            </td>

                            <td class="border-left border-right column-color pl-1" style="width: 15%">
                                <div style="font-size: 8px" class="arial font-normal">20. MOBILE NO.</div>
                            </td>

                            <td style="width: 40%" class="border-left border-top border-right-bold text-center">
                                <div class="arial font-normal text-8px font-bold">@if($pds->mobile_number){{ $pds->mobile_number }} @else N/A @endif</div>
                            </td>
                        </tr>
                        <!-- END:   14. TIN NO. -->

                        <!-- BEGIN: 15. AGENCY EMPLOYEE NO. -->
                        <tr>
                            <td style="width: 20%; height: 12px;" class="border-right border-left-bold arial column-color pl-1">
                                <div class="arial font-normal text-8px">15. AGENCY EMPLOYEE NO.</div>
                            </td>

                            <td class="border-right-bold pl-1" style="width: 25%">
                                <div class="arial font-normal text-8px font-bold">@if($pds->govissueid){{ $pds->govissueid }} @else N/A @endif</div>
                            </td>

                            <td class="border-left border-right border-top column-color pl-1" style="width: 15%">
                                <div style="font-size: 8px" class="arial font-normal">21. E-MAIL ADDRESS (if any)</div>
                            </td>

                            <td style="width: 40%" class="border-left border-top border-right-bold text-center">
                                <div class="arial font-normal text-8px font-bold">@if($pds->email){{ $pds->email }} @else N/A @endif</div>
                            </td>
                        </tr>
                        <!-- END:   15. AGENCY EMPLOYEE NO. -->

                    </table>
                </div>
            </td>
        </tr>
        <!-- BEGIN: 6. CIVIL STATUS -->

    </table>
    <!-- END: I PERSONAL INFO -->


    <!-- BEGIN: II FAMILY BACKGROUND -->
    <table  class="my-table">
        <tr>
            <td rowspan="2"  bgcolor="#a9a9a9" style="width: 100%" class="border-top-bold border-right-bold border-left-bold pl-1">
                <div style="text-align: left"><label class="arial text-11px" style="font-weight: bold; font-style: italic; color: white">II.  FAMILY BACKGROUND</label></div>
            </td>
        </tr>
    </table>
    <table class="my-table border-box">
        <tr>
            <td style="width: 60%;" class="border-top-bold border-left-bold border-right">
                <div style="margin-top: -2px; margin-left: -1px; margin-right: -1px; margin-bottom: -3px">
                    <table class="my-table">

                        <!-- BEGIN: SPOUSE -->
                        <tr>
                            <td style="width: 33%; height: 20px;" class="border-bottom border-right arial column-color">
                                <div class="arial text-8px font-normal px-1">22. SPOUSE'S SURNAME</div>
                            </td>
                            <td colspan="2" style="height: 20px" class="border-bottom px-1 arial">
                                <div class="arial text-8px font-bold">@if($pds->family_bg) @if($pds->family_bg->spouse_surname) {{ $pds->family_bg->spouse_surname }}@else N/A @endif @else N/A @endif</div>
                            </td>
                        </tr>

                        <tr>
                            <td style="width: 33%; height: 20px" class="border-bottom border-right px-1 arial column-color">
                                <div class="arial text-8px font-normal px-1" style="margin-left: 13px">FIRST NAME</div>
                            </td>

                            <td style="width: 42%; height: 20px;" class="border-bottom arial px-1">
                                <div class="arial text-8px font-bold">@if($pds->family_bg) @if($pds->family_bg->spouse_firstname) {{ $pds->family_bg->spouse_firstname }}@else N/A @endif @else N/A @endif </div>
                            </td>

                            <td style="width: 25%; height: 20px; font-size: 7px" class="border-bottom border-left arial column-color">
                                <div style="font-size: 7px" class="text-center arial font-normal ">NAME EXTENSION (JR., SR)</div>
                                <div style="font-size: 7px; margin-top: -1px" class="text-center arial font-bold">@if($pds->family_bg) @if($pds->family_bg->spouse_ext) {{ $pds->family_bg->spouse_ext }}@else N/A @endif @else N/A @endif </div>
                            </td>
                        </tr>

                        <tr>
                            <td style="width: 33%; height: 20px" class="border-bottom border-right px-1 arial column-color">
                                <div class="arial text-8px font-normal px-1" style="margin-left: 13px">MIDDLE NAME</div>
                            </td>

                            <td colspan="2" style="height: 20px;" class="border-bottom border-top arial px-1">
                                <div class="arial text-8px font-bold">@if($pds->family_bg) @if($pds->family_bg->spouse_mi) {{ $pds->family_bg->spouse_mi }}@else N/A @endif @else N/A @endif</div>
                            </td>
                        </tr>

                        <tr>
                            <td style="width: 33%; height: 20px" class="border-bottom border-right px-1 arial column-color">
                                <div class="arial text-8px font-normal px-1" style="margin-left: 13px">OCCUPATION</div>
                            </td>

                            <td colspan="2" style="height: 20px;" class="border-bottom border-top arial px-1">
                                <div class="arial text-8px font-bold">@if($pds->family_bg) @if($pds->family_bg->occupation) {{ $pds->family_bg->occupation }}@else N/A @endif @else N/A @endif</div>
                            </td>

                        </tr>

                        <tr>
                            <td style="width: 33%; height: 20px" class="border-bottom border-right px-1 arial column-color">
                                <div class="arial text-8px font-normal px-1" style="margin-left: 13px">EMPLOYER/BUSINESS NAME</div>
                            </td>

                            <td colspan="2" style="height: 20px;" class="border-bottom border-top arial px-1">
                                <div class="arial text-8-new-px font-bold">@if($pds->family_bg) @if($pds->family_bg->employer_name) {{ $pds->family_bg->employer_name }}@else N/A @endif @else N/A @endif</div>
                            </td>

                        </tr>

                        <tr>
                            <td style="width: 33%; height: 20px" class="border-bottom border-right px-1 arial column-color">
                                <div class="arial text-8px font-normal px-1" style="margin-left: 13px">BUSINESS ADDRESS</div>
                            </td>

                            <td colspan="2" style="height: 20px;" class="border-bottom border-top arial px-1">
                                <div class="arial text-8-new-px font-bold">@if($pds->family_bg) @if($pds->family_bg->business_address) {{ $pds->family_bg->business_address }}@else N/A @endif @else N/A @endif</div>
                            </td>
                        </tr>

                        <tr>
                            <td style="width: 33%; height: 20px" class="border-bottom border-right px-1 arial column-color">
                                <div class="arial text-8px font-normal px-1" style="margin-left: 13px">TELEPHONE NO.</div>
                            </td>

                            <td colspan="2" style="height: 20px;" class="border-bottom border-top arial px-1">
                                <div class="arial text-8px font-bold">@if($pds->family_bg) @if($pds->family_bg->tel_no) {{ $pds->family_bg->tel_no }}@else N/A @endif @else N/A @endif</div>
                            </td>
                        </tr>
                        <!-- END: SPOUSE -->

                        <!-- BEGIN: FATHER -->

                        <tr>
                            <td style="width: 33%; height: 20px;" class="border-bottom border-right arial column-color">
                                <div class="arial text-8px font-normal px-1">24. FATHER'S SURNAME</div>
                            </td>
                            <td colspan="2" style="height: 20px" class="border-bottom px-1 arial">
                                <div class="arial text-8px font-bold">@if($pds->family_bg) @if($pds->family_bg->father_surname) {{ $pds->family_bg->father_surname }}@else N/A @endif @else N/A @endif</div>
                            </td>
                        </tr>

                        <tr>
                            <td style="width: 33%; height: 20px" class="border-bottom border-right px-1 arial column-color">
                                <div class="arial text-8px font-normal px-1" style="margin-left: 13px"> FIRST NAME</div>
                            </td>

                            <td style="width: 42%; height: 20px;" class="border-bottom arial px-1">
                                <div class="arial text-8px font-bold">@if($pds->family_bg) @if($pds->family_bg->father_firstname) {{ $pds->family_bg->father_firstname }}@else N/A @endif @else N/A @endif</div>
                            </td>
                            <td style="width: 25%; height: 20px; font-size: 7px" class="border-bottom border-left arial column-color">
                                <div style="font-size: 7px" class="text-center arial font-normal">NAME EXTENSION (JR., SR)</div>
                                <div style="font-size: 7px; margin-top: -1px" class="text-center arial font-bold">@if($pds->family_bg) @if($pds->family_bg->father_ext) {{ $pds->family_bg->father_ext }}@else N/A @endif @else N/A @endif</div>
                            </td>
                        </tr>

                        <tr>
                            <td style="width: 33%; height: 20px" class="border-bottom border-right px-1 arial column-color">
                                <div class="arial text-8px font-normal px-1" style="margin-left: 13px"> MIDDLE NAME</div>
                            </td>

                            <td colspan="2" style="height: 20px;" class="border-bottom border-top arial px-1">
                                <div class="arial text-8px font-bold">@if($pds->family_bg) @if($pds->family_bg->father_mi) {{ $pds->family_bg->father_mi }}@else N/A @endif @else N/A @endif</div>
                            </td>

                        </tr>
                        <!-- END: FATHER -->

                        <!-- BEGIN: MOTHER -->

                        <tr>
                            <td style="width: 33%; height: 20px;" class="border-bottom border-right arial column-color">
                                <div class="arial text-8px font-normal px-1">25. MOTHER'S MAIDEN NAME</div>
                            </td>
                            <td colspan="2" style="height: 20px" class="border-bottom px-1 arial">
                                <div class="arial text-8px font-bold">@if($pds->family_bg) @if($pds->family_bg->mother_maidenname) {{ $pds->family_bg->mother_maidenname }}@else N/A @endif @else N/A @endif</div>
                            </td>
                        </tr>

                        <tr>
                            <td style="width: 33%; height: 20px" class="border-bottom border-right arial column-color">
                                <div class="arial text-8px font-normal px-1" style="margin-left: 13px"> SURNAME</div>
                            </td>
                            <td colspan="2" style="height: 20px" class="border-bottom px-1 arial">
                                <div class="arial text-8px font-bold">@if($pds->family_bg) @if($pds->family_bg->mother_surname) {{ $pds->family_bg->mother_surname }}@else N/A @endif @else N/A @endif</div>
                            </td>
                        </tr>

                        <tr>
                            <td style="width: 33%; height: 20px" class="border-bottom border-right arial column-color">
                                <div class="arial text-8px font-normal px-1" style="margin-left: 13px"> FIRST NAME</div>
                            </td>
                            <td colspan="2" style="height: 20px" class="border-bottom px-1 arial">
                                <div class="arial text-8px font-bold">@if($pds->family_bg) @if($pds->family_bg->mother_firstname) {{ $pds->family_bg->mother_firstname }}@else N/A @endif @else N/A @endif</div>
                            </td>
                        </tr>


                        <tr>
                            <td style="width: 33%; height: 20px" class="border-right arial column-color">
                                <div class="arial text-8px font-normal px-1" style="margin-left: 13px"> MIDDLE NAME</div>
                            </td>
                            <td colspan="2" style="height: 20px" class="px-1 arial">
                                <div class="arial text-8px font-bold">@if($pds->family_bg) @if($pds->family_bg->mother_mi) {{ $pds->family_bg->mother_mi }}@else N/A @endif @else N/A @endif</div>
                            </td>
                        </tr>
                        <!-- END: MOTHER -->

                    </table>
                </div>
            </td>

            <!-- BEGIN: NAME OF CHILDREN -->
                <td style="width: 40%;" class="border-top-bold border-left border-right-bold">
                <div style="margin-top: -1px; margin-left: -1px; margin-right: -1px; margin-bottom: -3px">
                    <table class="my-table">
                        <tr>
                            <td style="width: 70%; height: 17px" class="border-bottom border-right border-left column-color">
                                <div style="font-size: 8px" class="text-center arial font-normal"> 23. NAME of CHILDREN  (Write full name and list all)</div>
                            </td>
                            <td style="width: 30%; height: 17px" class="border-bottom column-color">
                                <div>
                                    <div style="font-size: 7px" class="text-center arial font-normal">DATE OF BIRTH</div>
                                    <div style="font-size: 7px" class="text-center arial font-normal">(mm/dd/yyyy) </div>
                                </div>
                            </td>
                        </tr>

                        @php
                            $child_row_max = 11;
                            $child_row_current = 0;
                        @endphp

                        @if($child)

                            @foreach($child as $ch)
                                @php
                                    $child_row_current++;
                                @endphp
                                <tr>
                                    <td style="width: 70%; height: 20px" class="border-right border-bottom">
                                        <div class="text-center arial text-8-new-px font-bold">{{ $ch->name }}</div>
                                    </td>
                                    <td style="width: 30%; height: 20px" class="border-bottom">
                                        <div class="text-center arial text-8px font-bold">{{ Carbon\Carbon::parse($ch->birth_date)->format('m/d/Y') }}</div>
                                    </td>
                                </tr>
                            @endforeach


                            @php
                                $child_row_added = $child_row_max - $child_row_current;
                            @endphp

                            @if($count_child > 0 )
                                @for ($ch_ = 1; $ch_ <= $child_row_max; $ch_++)
                                    <tr>
                                        <td style="width: 70%; height: 20px" class="border-right border-bottom">
                                            <div style="visibility: hidden" class="text-center arial text-8px font-bold">N/A</div>
                                        </td>
                                        <td style="width: 30%; height: 20px" class="border-bottom">
                                            <div style="visibility: hidden" class="text-center arial text-8px font-bold">N/A</div>
                                        </td>
                                    </tr>
                                @endfor
                            @elseif($count_child == 0)
                                @for ($ch_ = 1; $ch_ <= $child_row_max; $ch_++)
                                    @if($ch_ == 1)
                                        <tr>
                                            <td style="width: 70%; height: 20px" class="border-right border-bottom">
                                                <div class="text-center arial text-8px font-bold">N/A</div>
                                            </td>
                                            <td style="width: 30%; height: 20px" class="border-bottom">
                                                <div class="text-center arial text-8px font-bold">N/A</div>
                                            </td>
                                        </tr>
                                        @else
                                            <tr>
                                                <td style="width: 70%; height: 20px" class="border-right border-bottom">
                                                    <div style="visibility: hidden" class="text-center arial text-8px font-bold">N/A</div>
                                                </td>
                                                <td style="width: 30%; height: 20px" class="border-bottom">
                                                    <div style="visibility: hidden" class="text-center arial text-8px font-bold">N/A</div>
                                                </td>
                                            </tr>
                                    @endif
                                @endfor
                            @endif
                        @endif


                        <tr class="column-color">
                            <td colspan="2" style="height: 12px">
                                <div style="color: red; font-style: italic; font-size: 8px; margin-top: 3px; margin-bottom: 5px" class="text-center arial font-normal">(Continue on separate sheet if necessary)</div>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
            <!-- END: NAME OF CHILDREN -->
        </tr>
    </table>
    <!-- END: II FAMILY BACKGROUND -->


    <!-- BEGIN: III EDUCATIONAL BACKGROUND -->
    <table  class="my-table">
        <tr>
            <td rowspan="2"  bgcolor="#a9a9a9" style="width: 100%;" class="border-top-bold border-left-bold border-right-bold px-1">
                <div style="text-align: left"><label class="arial text-11px" style="font-weight: bold; font-style: italic; color: white">III.  EDUCATIONAL BACKGROUND</label></div>
            </td>
        </tr>
    </table>
    <table id="_this_table" class="my-table">
        <thead >
        <tr class="column-color border-top-bold">
            <th rowspan="2" class="arial text-8px border-left-bold border-bottom border-right font-normal px-1"             style="width: 20%; text-align: left"><div >26. LEVEL</div></th>
            <th rowspan="2" class="text-center arial text-8px border-right font-normal" style="width: 25%"><div > NAME OF SCHOOL <div class="mt-1 text-7px">(Write in full)</div></div></th>
            <th rowspan="2" class="text-center arial text-8px border-right font-normal" style="width: 15%"><div> <div> BASIC EDUCATION/</div> <div>DEGREE/COURSE</div> <div style="margin-top: -5px" class="text-7px">(Write in full)</div></div></th>
            <th colspan="2" class="text-center arial text-8-new-px border-right font-normal" style="width: 15%"><div > PERIOD OF ATTENDANCE</div></th>
            <th rowspan="2" class="text-center arial text-8-new-px border-right font-normal" style="width: 10%">
                <div > HIGHEST LEVELS/UNITS EARNED </div>
                <div class="mt-1 text-7px">(if not graduated)</div>
            </th>
            <th rowspan="2" class="text-center arial text-8-new-px border-box font-normal" style="width:  5%"><div > YEAR GRADUATED</div></th>
            <th rowspan="2" class="text-center arial text-8-new-px border-right-bold border-bottom font-normal" style="width: 10%"><div > SCHOLARSHIP/ ACADEMIC HONORS RECEIVED</div></th>
        </tr>
        <tr>
            <td class="text-center arial text-9px border-box column-color font-normal" style="width:  5%"><div >FROM</div></td>
            <td class="text-center arial text-9px border-box column-color font-normal" style="width:  5%"><div >TO</div></td>
        </tr>
        </thead>
        <tbody>

        @php
            $educ_row_max = 6;
            $educ_row_current = 0;
        @endphp

        @if($educational_background)

            @foreach($educational_background as $educ)
                @php
                    $educ_row_current++;
                @endphp

                <tr>
                    <td style="width: 20%; height: 30px" class="px-1 border-left-bold border-bottom arial text-8-new-px font-normal column-color">@if($educ->level) {{ $educ->level }} @else N/A @endif</td>
                    <td style="width: 25%; height: 30px" class="px-1 border-box arial text-8-new-px font-normal">@if($educ->school_name) {{ $educ->school_name }} @else N/A @endif </td>
                    <td style="width: 15%; height: 30px" class="px-1 border-box arial text-8-new-px font-normal">@if($educ->degreee_course) {{ $educ->degreee_course }} @else N/A @endif </td>
                    <td style="width: 5%;  height: 30px" class="px-1 border-box arial text-8-new-px font-normal text-center">@if($educ->attendance_from) {{ Carbon\Carbon::parse($educ->attendance_from)->format('m/d/Y') }} @else N/A @endif </td>
                    <td style="width: 5%;  height: 30px" class="px-1 border-box arial text-8-new-px font-normal text-center">@if($educ->attendance_to) {{ Carbon\Carbon::parse($educ->attendance_to  )->format('m/d/Y') }} @else N/A @endif </td>
                    <td style="width: 10%; height: 30px" class="px-1 border-box arial text-8-new-px font-normal text-center">@if($educ->units_earned) {{ $educ->units_earned }} @else N/A @endif </td>
                    <td style="width: 5%;  height: 30px" class="px-1 border-box arial text-8-new-px font-normal text-center">@if($educ->year_graduated) {{ $educ->year_graduated }} @else N/A @endif</td>
                    <td style="width: 15%; height: 30px" class="px-1 border-right-bold border-bottom arial text-8-new-px font-normal text-center">@if($educ->acad_honors) {{ $educ->acad_honors }} @else N/A @endif </td>
                </tr>
            @endforeach

            @php
                $educ_row_added = $educ_row_max - $educ_row_current;
            @endphp

            @if($count_educ_bg > 0 )

                @for ($educ_ = 1; $educ_ <= $educ_row_added; $educ_++)
                    <tr>
                        <td style="width: 20%; height: 30px" class="px-1 border-left-bold border-bottom arial text-8-new-px font-normal column-color"></td>
                        <td style="width: 25%; height: 30px" class="px-1 border-box arial text-8-new-px font-normal"></td>
                        <td style="width: 15%; height: 30px" class="px-1 border-box arial text-8-new-px font-normal"></td>
                        <td style="width: 5%;  height: 30px" class="px-1 border-box arial text-8-new-px font-normal"></td>
                        <td style="width: 5%;  height: 30px" class="px-1 border-box arial text-8-new-px font-normal"></td>
                        <td style="width: 10%; height: 30px" class="px-1 border-box arial text-8-new-px font-normal"></td>
                        <td style="width: 5%;  height: 30px" class="px-1 border-box arial text-8-new-px font-normal"></td>
                        <td style="width: 15%; height: 30px" class="px-1 border-right-bold border-bottom arial text-8-new-px font-normal"></td>
                    </tr>
                @endfor

            @elseif($count_educ_bg == 0)
                @for ($educ_1 = 1; $educ_1 <= $educ_row_max; $educ_1++)
                    <tr>
                        <td style="width: 20%; height: 30px" class="px-1 border-left-bold border-bottom arial text-8-new-px font-normal column-color text-center">@if($educ_1 == 1) N/A @endif</td>
                        <td style="width: 25%; height: 30px" class="px-1 border-box arial text-8-new-px font-normal text-center">@if($educ_1 == 1) N/A @endif</td>
                        <td style="width: 15%; height: 30px" class="px-1 border-box arial text-8-new-px font-normal text-center">@if($educ_1 == 1) N/A @endif</td>
                        <td style="width: 5%;  height: 30px" class="px-1 border-box arial text-8-new-px font-normal text-center">@if($educ_1 == 1) N/A @endif</td>
                        <td style="width: 5%;  height: 30px" class="px-1 border-box arial text-8-new-px font-normal text-center">@if($educ_1 == 1) N/A @endif</td>
                        <td style="width: 10%; height: 30px" class="px-1 border-box arial text-8-new-px font-normal text-center">@if($educ_1 == 1) N/A @endif</td>
                        <td style="width: 5%;  height: 30px" class="px-1 border-box arial text-8-new-px font-normal text-center">@if($educ_1 == 1) N/A @endif</td>
                        <td style="width: 15%; height: 30px" class="px-1 border-right-bold border-bottom arial text-8-new-px font-normal text-center">@if($educ_1 == 1) N/A @endif</td>
                    </tr>
                @endfor
            @endif

        @endif

        <tr>
            <td colspan="8" style="height: 15px" class="border-top-bold border-bottom-bold border-right-bold border-left-bold column-color text-center"><label style="font-style: italic; color: red" class="arial text-8-new-px">(Continue on separate sheet if necessary)</label></td>
        </tr>

        <tr>
            <td colspan="" style="height: 24px" class="border-right-bold border-left-bold arial text-9px font-bold text-center column-color ">SIGNATURE</td>
            <td colspan="2" style="height: 24px" class="border-right-bold arial text-9px "></td>
            <td colspan="2"  style="height: 24px" class="border-right-bold arial text-9px  font-bold text-center column-color">DATE</td>
            <td colspan="3" style="height: 24px" class="border-right-bold arial text-9px "></td>
        </tr>
        <tr>
            <td colspan="8" style="text-align: right" class="arial text-8px border-top-bold border-bottom-bold border-left-bold border-right-bold">CS FORM 212 (Revised 2017), Page 1 of 4</td>
        </tr>

        </tbody>
    </table>
    <!-- END: III EDUCATIONAL BACKGROUND -->


    <!-- BEGIN: PAGE BREAK -->
    <div class="page_break"></div>
    <!-- END:   PAGE BREAK -->


    <!-- BEGIN: IV CIVIL SERVICE ELIGIBILITY -->
    <table  class="my-table">
        <tr>
            <td rowspan="2"  bgcolor="#a9a9a9" style="width: 100%" class="border-right-bold border-left-bold border-bottom-bold border-top-bold px-1">
                <div style="text-align: left"><label class="arial text-11px" style="font-weight: bold; font-style: italic; color: white">IV.  CIVIL SERVICE ELIGIBILITY</label></div>
            </td>
        </tr>
    </table>
    <table class="my-table">

        <thead class="column-color">
            <tr>
                <td rowspan="2" colspan="2" class="px-1 border-left-bold border-bottom border-top-bold border-right">
                    <div style="text-align: left" class="arial text-8px font-normal">27.CAREER SERVICE/ RA 1080 (BOARD/ BAR) UNDER</div>
                    <div class="arial text-8px font-normal text-center">SPECIAL LAWS/ CES/ CSEE</div>
                    <div class="arial text-8px font-normal text-center">BARANGAY ELIGIBILITY / DRIVER'S LICENSE</div>
                </td>

                <td rowspan="2" colspan="1" class="border-top-bold border-right" >
                    <div class="arial text-8px font-normal text-center">RATING</div>
                    <div class="arial text-8px font-normal text-center">(If Applicable)</div>
                </td>
                <td rowspan="2" class="border-top-bold border-right">
                    <div class="arial text-8px font-normal text-center">DATE OF </div>
                    <div class="arial text-8px font-normal text-center">EXAMINATION/</div>
                    <div class="arial text-8px font-normal text-center">CONFERMENT</div>
                </td>
                <td rowspan="2" class="border-top-bold border-right text-center"><div class="arial text-8px font-normal">PLACE OF EXAMINATION / CONFERMENT</div></td>
                <td colspan="2" class="border-top-bold border-left border-bottom border-right-bold"><div class="arial text-8px font-normal text-center">LICENSE (if applicable)</div></td>
            </tr>

            <tr>
                <td class="text-center arial text-9px border-box column-color font-normal">NUMBER</td>
                <td class="text-center arial text-9px border-left border-right-bold border-bottom column-color font-normal">
                    <div>Date of</div>
                    <div>Validity</div>
                </td>
            </tr>

        </thead>

        <tbody>

        <!-- BEGIN: CIVIL SERVICE DATA -->
        @php
            $cs_row_max = 8;
            $cs_row_current = 0;
        @endphp

        @if($civil_service)

            @foreach($civil_service as $cs)
                @php
                    $cs_row_current++;
                @endphp

                <tr>
                    <td colspan="2" class="border-left-bold border-bottom h-20"><label class="px-1 arial text-8-new-px font-normal">@if($cs->eligibility_type) {{ $cs->eligibility_type }} @else N/A @endif</label></td>
                    <td             class="border-box h-20 text-center"><label class="px-1 arial text-8-new-px font-normal">@if($cs->rating) {{ $cs->rating }} @else N/A @endif</label></td>
                    <td             class="border-box h-20 text-center"><label class="px-1 arial text-8-new-px font-normal">@if($cs->date_examination) {{ $cs->date_examination }} @else N/A @endif</label></td>
                    <td             class="border-box h-20 text-center"><label class="px-1 arial text-8-new-px font-normal">@if($cs->place_examination) {{ $cs->place_examination }} @else N/A @endif</label></td>
                    <td             class="border-box h-20 text-center"><label class="px-1 arial text-8-new-px font-normal">@if($cs->license_number) {{ $cs->license_number }} @else N/A @endif</label></td>
                    <td             class="border-right-bold border-bottom h-20 text-center" style="text-transform:uppercase"><label class="px-1 arial text-8-new-px font-normal">@if($cs->license_validity) {{ $cs->license_validity }} @else N/A @endif</label></td>

                </tr>
            @endforeach

            @php
                $cs_row_added = $cs_row_max - $cs_row_current;
            @endphp

            @if($count_cs > 0 )
                @for ($cs = 1; $cs <= $cs_row_added; $cs++)

                    <tr>
                        <td colspan="2" class="border-left-bold border-bottom h-20"><label class="px-1 arial text-8-new-px font-normal"></label></td>
                        <td             class="border-box h-20 text-center"><label class="px-1 arial text-8-new-px font-normal"></label></td>
                        <td             class="border-box h-20 text-center"><label class="px-1 arial text-8-new-px font-normal"></label></td>
                        <td             class="border-box h-20 text-center"><label class="px-1 arial text-8-new-px font-normal"></label></td>
                        <td             class="border-box h-20 text-center"><label class="px-1 arial text-8-new-px font-normal"></label></td>
                        <td             class="border-right-bold border-bottom h-20 text-center" style="text-transform:uppercase"><label class="px-1 arial text-8-new-px font-normal"></label></td>
                    </tr>
                @endfor

            @elseif($count_cs == 0)
                @for ($cs = 1; $cs <= $cs_row_max; $cs++)

                    <tr>
                        <td colspan="2" class="border-left-bold border-bottom h-20"><label class="px-1 arial text-8-new-px font-normal">@if($cs == 1) N/A @endif</label></td>
                        <td             class="border-box h-20 text-center"><label class="px-1 arial text-8-new-px font-normal">@if($cs == 1) N/A @endif</label></td>
                        <td             class="border-box h-20 text-center"><label class="px-1 arial text-8-new-px font-normal">@if($cs == 1) N/A @endif</label></td>
                        <td             class="border-box h-20 text-center"><label class="px-1 arial text-8-new-px font-normal">@if($cs == 1) N/A @endif</label></td>
                        <td             class="border-box h-20 text-center"><label class="px-1 arial text-8-new-px font-normal">@if($cs == 1) N/A @endif</label></td>
                        <td             class="border-right-bold border-bottom h-20 text-center" style="text-transform:uppercase"><label class="px-1 arial text-8-new-px font-normal">@if($cs == 1) N/A @endif</label></td>
                    </tr>
                @endfor
            @endif

        @endif
        <!-- END: CIVIL SERVICE DATA -->

        <tr>
            <td colspan="7" style="text-align: center" class="border-top-bold border-bottom-bold border-right-bold border-left-bold column-color"><label style="font-style: italic; color: red" class="arial text-10px">(Continue on separate sheet if necessary)</label></td>
        </tr>

        </tbody>

    </tbody>

    </table>
    <!-- END: IV CIVIL SERVICE ELIGIBILITY -->


    <!-- BEGIN: V WORK EXPERIENCE -->
    <table  class="my-table">
        <tr>
            <td bgcolor="#a9a9a9" style="width: 100%; height: 40px" class="border-right-bold border-left-bold border-bottom-bold">
                <div style="text-align: left"><label class="arial text-11px" style="font-weight: bold; font-style: italic; color: white">V. WORK EXPERIENCE</label></div>
                <div style="font-size:70%; text-align: left; margin-top: 1px"><label class="arial" style="font-weight: bold; font-style: italic; color: white">(Include private employment.  Start from your recent work) Description of duties should be indicated in the attached Work Experience sheet.</label></div>

            </td>
        </tr>
    </table>
    <table class="my-table">
        <thead>
            <tr class="column-color">

                <td class="border-left-bold border-bottom" colspan="2" style="width: 12%">
                    <div class="arial text-8px font-normal">28. INCLUSIVE DATES</div>
                    <div style="margin-top: -8px" class="arial text-7px font-normal text-center">(mm/dd/yyyy)</div>
                </td>

                <td class="border-box text-center" rowspan="2" style="width: 30%">
                    <div class="arial text-8px font-normal text-center">POSITION TITLE</div>
                    <div class="arial text-7px font-normal text-center">(Write in full/Do not abbreviate)</div>
                </td>

                <td class="border-box text-center" rowspan="2" style="width: 25%">
                    <div class="arial text-8px font-normal text-center">DEPARTMENT / AGENCY / OFFICE / COMPANY</div>
                    <div class="arial text-7px font-normal text-center">(Write in full/Do not abbreviate)</div>
                </td>

                <td class="border-box text-center" rowspan="2" style="width: 10%">
                    <div class="arial text-8px font-normal text-center">MONTHLY</div>
                    <div class="arial text-8px font-normal text-center">SALARY</div>
                </td>

                <td class="border-box text-center" rowspan="2" style="width: 8%">
                    <div class="arial text-6px-new font-normal text-center">SALARY/ JOB/</div>
                    <div class="arial text-6px-new font-normal text-center">PAY GRADE (if</div>
                    <div class="arial text-6px-new font-normal text-center">applicable)&</div>
                    <div class="arial text-6px-new font-normal text-center">STEP (Format</div>
                    <div class="arial text-6px-new font-normal text-center">"00-0")/</div>
                    <div class="arial text-6px-new font-normal text-center">INCREMENT</div>
                </td>

                <td class="border-box text-center" rowspan="2" style="width: 10%">
                    <div class="arial text-8px font-normal text-center">STATUS OF</div>
                    <div class="arial text-8px font-normal text-center">APPOINTMENT</div>
                </td>

                <td class="border-right-bold border-bottom text-center" rowspan="2" style="width: 5%">
                    <div class="arial text-8px font-normal text-center">GOV'T</div>
                    <div class="arial text-8px font-normal text-center">SERVICE</div>
                    <div class="arial text-8px font-normal text-center">(Y/ N)</div>
            </tr>

            <tr class="column-color">
                <td style="width: 6%" class="border-left-bold border-bottom"><div class="arial text-8px font-normal text-center">From</td>
                <td style="width: 6%" class="border-box"><div class="arial text-8px font-normal text-center">To</td>
            </tr>
        </thead>

        <tbody>
            @php
                $work_exp_row_max = 14;
                $work_exp_current = 0;
            @endphp

            @if($work_experience)

                @foreach($work_experience as $exp)
                    @php
                        $work_exp_current++;
                    @endphp

                    <tr>
                        <td style="height: 45px; width: 6%"  class="border-left-bold border-bottom h-20 px-1 arial text-8-new-px font-normal text-center">{{ Carbon\Carbon::parse($exp->from)->format('m/d/Y') }}</td>
                        <td style="height: 45px; width: 6%"  class="border-box h-20 px-1 arial text-8-new-px font-normal text-center">{{ Carbon\Carbon::parse($exp->to  )->format('m/d/Y') }}</td>
                        <td style="height: 45px; width: 30%" class="border-box h-20 px-1 arial text-8-new-px font-normal">{{ $exp->position_title }}</td>
                        <td style="height: 45px; width: 25%" class="border-box h-20 px-1 arial text-8-new-px font-normal">{{ $exp->dept_agency_office }}</td>
                        <td style="height: 45px; width: 10%" class="border-box h-20 px-1 arial text-8-new-px font-normal text-center">{{ $exp->monthly_sal }}</td>
                        <td style="height: 45px; width: 8%"  class="border-box h-20 px-1 arial text-8-new-px font-normal text-center">{{ $exp->sal_grade }}</td>
                        <td style="height: 45px; width: 10%" class="border-box h-20 px-1 arial text-8-new-px font-normal text-center">{{ $exp->appointment_status }}</td>
                        <td style="height: 45px; width: 5%"  class="border-right-bold border-bottom h-20 px-1 arial text-8-new-px font-normal text-center">{{ $exp->gvt_service }}</td>
                    </tr>
                @endforeach

                @php
                    $work_exp_row_added = $work_exp_row_max - $work_exp_current;
                @endphp

                @if($count_work_exp > 0)

                    @for ($work_exp = 1; $work_exp <= $work_exp_row_added; $work_exp++)
                        <tr>
                            <td style="height: 45px; width: 6%"  class="border-left-bold border-bottom h-20 px-1 arial text-8-new-px font-normal"></td>
                            <td style="height: 45px; width: 6%"  class="border-box h-20 px-1 arial text-8-new-px font-normal"></td>
                            <td style="height: 45px; width: 30%" class="border-box h-20 px-1 arial text-8-new-px font-normal"></td>
                            <td style="height: 45px; width: 25%" class="border-box h-20 px-1 arial text-8-new-px font-normal"></td>
                            <td style="height: 45px; width: 10%" class="border-box h-20 px-1 arial text-8-new-px font-normal"></td>
                            <td style="height: 45px; width: 8%"  class="border-box h-20 px-1 arial text-8-new-px font-normal"></td>
                            <td style="height: 45px; width: 10%" class="border-box h-20 px-1 arial text-8-new-px font-normal"></td>
                            <td style="height: 45px; width: 5%"  class="border-right-bold border-bottom h-20 px-1 arial text-8-new-px font-normal"></td>
                        </tr>
                    @endfor

                @elseif($count_work_exp == 0)
                    @for ($work_exp_1 = 1; $work_exp_1 <= $work_exp_row_max; $work_exp_1++)
                        <tr>
                            <td style="height: 45px; width: 6%"  class="border-left-bold border-bottom h-20 px-1 arial text-8-new-px font-normal text-center">@if($work_exp_1 == 1) N/A @endif</td>
                            <td style="height: 45px; width: 6%"  class="border-box h-20 px-1 arial text-8-new-px font-normal text-center">@if($work_exp_1 == 1) N/A @endif</td>
                            <td style="height: 45px; width: 30%" class="border-box h-20 px-1 arial text-8-new-px font-normal text-center">@if($work_exp_1 == 1) N/A @endif</td>
                            <td style="height: 45px; width: 25%" class="border-box h-20 px-1 arial text-8-new-px font-normal text-center">@if($work_exp_1 == 1) N/A @endif</td>
                            <td style="height: 45px; width: 10%" class="border-box h-20 px-1 arial text-8-new-px font-normal text-center">@if($work_exp_1 == 1) N/A @endif</td>
                            <td style="height: 45px; width: 8%"  class="border-box h-20 px-1 arial text-8-new-px font-normal text-center">@if($work_exp_1 == 1) N/A @endif</td>
                            <td style="height: 45px; width: 10%" class="border-box h-20 px-1 arial text-8-new-px font-normal text-center">@if($work_exp_1 == 1) N/A @endif</td>
                            <td style="height: 45px; width: 5%"  class="border-right-bold border-bottom h-20 px-1 arial text-8-new-px font-normal text-center">@if($work_exp_1 == 1) N/A @endif</td>
                        </tr>
                    @endfor
                @endif

            @endif

            <tr>
                <td colspan="8" style="text-align: center" class="border-top-bold border-bottom-bold border-right-bold border-left-bold column-color"><label style="font-style: italic; color: red" class="arial text-10px">(Continue on separate sheet if necessary)</label></td>
            </tr>

            <tr>
                <td colspan="" style="height: 24px" class="border-right-bold border-left-bold arial text-9px font-bold text-center column-color ">SIGNATURE</td>
                <td colspan="2" style="height: 24px" class="border-right-bold arial text-9px "></td>
                <td colspan="2"  style="height: 24px" class="border-right-bold arial text-9px  font-bold text-center column-color">DATE</td>
                <td colspan="3" style="height: 24px" class="border-right-bold arial text-9px "></td>
            </tr>
            <tr>
                <td colspan="8" style="text-align: right" class="arial text-8px border-top-bold border-bottom-bold border-left-bold border-right-bold">CS FORM 212 (Revised 2017), Page 2 of 4</td>
        </tbody>
    </table>
    <!-- END: V WORK EXPERIENCE -->

    <!-- BEGIN: PAGE BREAK -->
    <div class="page_break"></div>
    <!-- END:   PAGE BREAK -->


    <!-- BEGIN: VI VOLUNTARY WORK -->
    <table  class="my-table">
        <tr>
            <td bgcolor="#a9a9a9" style="width: 100%; height: 20px" class="border-left-bold border-right-bold border-bottom-bold border-top-bold">
                <div style="text-align: left"><label class="arial text-11px" style="font-weight: bold; font-style: italic; color: white">VI. VOLUNTARY WORK OR INVOLVEMENT IN CIVIC / NON-GOVERNMENT / PEOPLE / VOLUNTARY ORGANIZATION/S</label></div>
            </td>
        </tr>
    </table>
    <table class="voluntary-work-table">
        <tr class="column-color">

            <td class="border-left-bold border-bottom px-1" rowspan="2" style="width: 35%"  >
                <div class="arial text-8px font-normal">29. NAME & ADDRESS OF ORGANIZATION </div>
                <div class="arial text-8-new-px font-normal" style="margin-left: 80px">(Write in full)</div>
            </td>

            <td class="border-box text-center" colspan="2" style="width: 25%" >
                <div class="arial text-8px font-normal">INCLUSIVE DATES</div>
                <div class="arial text-8-new-px font-normal">(mm/dd/yyyy)</div>
            </td>

            <td class="border-box text-center" rowspan="2" style="width: 10%" >
                <div class="arial text-8px font-normal">NUMBER OF</div>
                <div class="arial text-8px font-normal">HOURS</div>
            </td>

            <td class="border-right-bold border-bottom text-center" rowspan="2" style="width: 30%" >
                <div class="arial text-8px font-normal">POSITION / NATURE OF WORK</div>
            </td>

        </tr>

        <tr class="column-color text-center">
            <td  class="border-box" style="width: 7%"><div class="arial text-8px font-normal">From</div></td>
            <td  class="border-box" style="width: 7%"><div class="arial text-8px font-normal">To</div></td>
        </tr>

        <tbody>

        @php
            $vol_row_max = 6;
            $vol_row_current = 0;
        @endphp

        @if($voluntary_work)

            @foreach($voluntary_work as $vol_work)

                @php
                    $vol_row_current++;
                @endphp

                <tr>
                    <td style="height: 30px" class="border-left-bold border-bottom px-1"><div class="arial text-8-new-px font-normal">@if($vol_work->org_name_address) {{ $vol_work->org_name_address }} @else N/A @endif</div></td>
                    <td style="height: 30px" class="border-box px-1 text-center"><div class="arial text-8-new-px font-normal">@if($vol_work->from) {{ Carbon\Carbon::parse($vol_work->from)->format('m/d/Y') }} @else N/A @endif</div></td>
                    <td style="height: 30px" class="border-box px-1 text-center"><div class="arial text-8-new-px font-normal">@if($vol_work->to) {{ Carbon\Carbon::parse($vol_work->to  )->format('m/d/Y') }} @else N/A @endif</div></td>
                    <td style="height: 30px" class="border-box px-1 text-center"><div class="arial text-8-new-px font-normal text-center"> @if($vol_work->hours_number) {{ $vol_work->hours_number }} @else N/A @endif</div></td>
                    <td style="height: 30px" class="border-right-bold border-bottom px-1"><div class="arial text-8-new-px font-normal"> @if($vol_work->work_position_nature) {{ $vol_work->work_position_nature }} @else N/A @endif</div></td>
                </tr>
            @endforeach

            @php
                $vol_row_added = $vol_row_max - $vol_row_current;
            @endphp

            @if($count_vol_work > 0)
                @for ($vol = 1; $vol <= $vol_row_added; $vol++)
                    <tr>
                        <td style="height: 30px" class="border-left-bold border-bottom px-1"><div class="arial text-10px font-normal"></div></td>
                        <td style="height: 30px" class="border-box px-1"><div class="arial text-10px font-normal"></div></td>
                        <td style="height: 30px" class="border-box px-1"><div class="arial text-10px font-normal"></div></td>
                        <td style="height: 30px" class="border-box px-1"><div class="arial text-10px font-normal"></div></td>
                        <td style="height: 30px" class="border-right-bold border-bottom px-1"><div class="arial text-10px font-normal"></div></td>
                    </tr>
                @endfor
            @elseif($count_vol_work == 0)
                @for ($vol_1 = 1; $vol_1 <= $vol_row_max; $vol_1++)
                    <tr>
                        <td style="height: 30px" class="border-left-bold border-bottom px-1 text-center"><div class="arial text-10px font-normal">@if($vol_1 == 1) N/A @endif</div></td>
                        <td style="height: 30px" class="border-box px-1 text-center"><div class="arial text-10px font-normal">@if($vol_1 == 1) N/A @endif</div></td>
                        <td style="height: 30px" class="border-box px-1 text-center"><div class="arial text-10px font-normal">@if($vol_1 == 1) N/A @endif</div></td>
                        <td style="height: 30px" class="border-box px-1 text-center"><div class="arial text-10px font-normal">@if($vol_1 == 1) N/A @endif</div></td>
                        <td style="height: 30px" class="border-right-bold border-bottom px-1 text-center"><div class="arial text-10px font-normal">@if($vol_1 == 1) N/A @endif</div></td>
                    </tr>
                @endfor
            @endif
        @endif

            <tr>
                <td colspan="5" class="border-left-bold border-bottom-bold border-top-bold border-right-bold column-color" style="text-align: center; height: 10px"><label style="font-style: italic; color: red" class="arial text-10px">(Continue on separate sheet if necessary)</label></td>
            </tr>

        </tbody>

    </table>
    <!-- EMD: VI VOLUNTARY WORK -->


    <!-- BEGIN: VII  LEARNING AND DEVELOPMENT (L&D) INTERVENTIONS/TRAINING PROGRAMS ATTENDED -->
    <table  class="my-table">
        <tr>
            <td bgcolor="#a9a9a9" style="width: 100%; height: 40px" class="border-left border-right border-bottom-bold border-top-bold">
                <div style="text-align: left"><label class="arial text-11px" style="font-weight: bold; font-style: italic; color: white">VII.  LEARNING AND DEVELOPMENT (L&D) INTERVENTIONS/TRAINING PROGRAMS ATTENDED</label></div>
                <div style="font-size:70%; text-align: left; margin-top: 1px"><label class="arial" style="font-weight: bold; font-style: italic; color: white">(Start from the most recent L&D/training program and include only the relevant L&D/training taken for the last five (5) years for Division Chief/Executive/Managerial positions)</label></div>
            </td>
        </tr>
    </table>
    <table class="ld-table">

        <thead>
            <tr class="column-color">

                <td class="border-box" rowspan="2" style="width: 35%">
                    <div class="arial text-8px font-normal">30. TITLE OF LEARNING AND DEVELOPMENT</div>
                    <div class="arial text-8px font-normal" style="margin-left: 15px">INTERVENTIONS/TRAINING PROGRAMS</div>
                    <div class="arial text-8-new-px font-normal" style="margin-left: 70px">(Write in full)</div>
                </td>

                <td colspan="2" class="border-box text-center" style="width: 25%">
                    <div class="arial text-8px font-normal text-center">INCLUSIVE DATES</div>
                    <div class="arial text-8px font-normal text-center">OF ATTENDANCE</div>
                    <div class="arial text-8-new-px font-normal text-center">(mm/dd/yyyy)</div>
               </td>

                <td class="border-box text-center" rowspan="2" style="width: 10%">
                    <div class="arial text-8px font-normal">NUMBER OF</div>
                    <div class="arial text-8px font-normal">HOURS</div>
                </td>

                <td class="border-box text-center" rowspan="2" style="width: 10%">
                    <div class="arial text-8px font-normal">Type of LD</div>
                    <div class="arial text-8px font-normal">( Managerial/</div>
                    <div class="arial text-8px font-normal">Supervisory/</div>
                    <div class="arial text-8px font-normal">Technical/etc)</div>
                </td>

                <td class="border-box text-center" rowspan="2" style="width: 20%">
                    <div class="arial text-8px font-normal">CONDUCTED/ SPONSORED BY </div>
                    <div class="arial text-8-new-px font-normal">(Write in full)</div>
                </td>
            </tr>

            <tr class="column-color">
                <td  class="border-box" style="width: 7%"><div class="arial text-8px font-normal text-center"><label>From</label></div></td>
                <td  class="border-box" style="width: 7%"><div class="arial text-8px font-normal text-center"><label>To</label></div></td>
            </tr>

        </thead>

        <tbody>
        @php
            $ld_row_max = 12;
            $ld_row_current = 0;
        @endphp

        @if($learning_dev)
            @foreach($learning_dev as $l_dev)

                @php
                    $ld_row_current++;
                @endphp
                <tr>
                    <td style="height: 40px"  class="border-box px-1"><label class="text-8-new-px arial font-normal"> @if($l_dev->learning_dev_title) {{ $l_dev->learning_dev_title }} @else N/A @endif </label></td>
                    <td style="height: 40px" class="border-box px-1 text-center"><label class="text-8-new-px arial font-normal">@if($l_dev->from) {{ Carbon\Carbon::parse($l_dev->from)->format('m/d/Y') }} @else N/A @endif </label></td>
                    <td style="height: 40px" class="border-box px-1 text-center"><label class="text-8-new-px arial font-normal">@if($l_dev->to) {{ Carbon\Carbon::parse($l_dev->to  )->format('m/d/Y') }} @else N/A @endif </label></td>
                    <td style="height: 40px" class="border-box px-1 text-center"><label class="text-8-new-px arial font-normal">@if($l_dev->hours_number) {{ $l_dev->hours_number }} @else N/A @endif </label></td>
                    <td style="height: 40px" class="border-box px-1 text-center"><label class="text-8-new-px arial font-normal">@if($l_dev->learning_dev_type) {{ $l_dev->learning_dev_type }} @else N/A @endif </label></td>
                    <td style="height: 40px" class="border-box px-1"><label class="text-8-new-px arial font-normal">@if($l_dev->conducted_sponsored) {{ $l_dev->conducted_sponsored }} @else N/A @endif </label></td>
                </tr>
            @endforeach

            @php
                $ld_row_added = $ld_row_max - $ld_row_current;
            @endphp

            @if($count_ld > 0)
                @for ($ld_kulang = 1; $ld_kulang <= $ld_row_added; $ld_kulang++)
                    <tr>
                        <td style="height: 40px" class="border-box px-1"><label class="text-10px arial font-normal"></label></td>
                        <td style="height: 40px" class="border-box px-1"><label class="text-10px arial font-normal"></label></td>
                        <td style="height: 40px" class="border-box px-1"><label class="text-10px arial font-normal"></label></td>
                        <td style="height: 40px" class="border-box px-1"><label class="text-10px arial font-normal"></label></td>
                        <td style="height: 40px" class="border-box px-1"><label class="text-10px arial font-normal"></label></td>
                        <td style="height: 40px" class="border-box px-1"><label class="text-10px arial font-normal"></label></td>
                    </tr>
                @endfor
            @elseif($count_ld == 0)
                @for ($ld_empty = 1; $ld_empty <= $ld_row_max; $ld_empty++)
                    <tr>
                        <td style="height: 40px" class="border-box px-1 text-center"><label class="text-10px arial font-normal">@if($ld_empty == 1) N/A @endif</label></td>
                        <td style="height: 40px" class="border-box px-1 text-center"><label class="text-10px arial font-normal">@if($ld_empty == 1) N/A @endif</label></td>
                        <td style="height: 40px" class="border-box px-1 text-center"><label class="text-10px arial font-normal">@if($ld_empty == 1) N/A @endif</label></td>
                        <td style="height: 40px" class="border-box px-1 text-center"><label class="text-10px arial font-normal">@if($ld_empty == 1) N/A @endif</label></td>
                        <td style="height: 40px" class="border-box px-1 text-center"><label class="text-10px arial font-normal">@if($ld_empty == 1) N/A @endif</label></td>
                        <td style="height: 40px" class="border-box px-1 text-center"><label class="text-10px arial font-normal">@if($ld_empty == 1) N/A @endif</label></td>
                    </tr>
                @endfor
            @endif

        @endif

            <tr>
                <td colspan="6" class="border-top-bold border-right border-left column-color" style="text-align: center; height: 10px"><label style="font-style: italic; color: red" class="arial text-10px">(Continue on separate sheet if necessary)</label></td>
            </tr>

        </tbody>

    </table>
    <!-- BEGIN: VII  LEARNING AND DEVELOPMENT (L&D) INTERVENTIONS/TRAINING PROGRAMS ATTENDED -->


    <!-- BEGIN: VIII OTHER INFORMATION -->
    <table  class="my-table">
        <tr>
            <td rowspan="2"  bgcolor="#a9a9a9" style="width: 100%" class="border-bottom-bold border-top-bold  border-right border-left">
                <div style="text-align: left"><label class="arial text-11px" style="font-weight: bold; font-style: italic; color: white">VIII.  OTHER INFORMATION</label></div>
            </td>
        </tr>
    </table>
    <table class="ld-table">
        <thead>
            <tr class="column-color">
                <td style="height: 20px" colspan="3" class="border-left border-right border-top-bold" ><div class="arial text-8px font-normal">31. <label style="padding-left: 20px; text-align:center">SPECIAL SKILLS and HOBBIES</label></div></td>
                <td style="height: 20px" colspan="3" class="border-right border-top-bold" ><div class="arial text-8px font-normal">32. <label style="padding-left: 20px; text-align:center">NON-ACADEMIC DISTINCTIONS / RECOGNITION (Write in full)</label></div></td>
                <td style="height: 20px" colspan="2" class="border-right border-top-bold"><div class="arial text-8px font-normal">33. <label style="padding-left: 20px; text-align:center">MEMBERSHIP IN ASSOCIATION/ORGANIZATION (Write in full)</label></div></td>
            </tr>
        </thead>

        <tbody>

        @php
            $skills_row_max = 5;
            $skills_row_current = 0;
        @endphp

        @if($special_skills)
            @foreach($special_skills as $skills)

                @php
                    $skills_row_current++;
                @endphp

                <tr>
                    <td style="height: 30px" colspan="3"  class="border-box"><label class="text-8-new-px arial ">@if($skills->special_skills) {{ $skills->special_skills }} @else N/A @endif</label></td>
                    <td style="height: 30px" colspan="3"  class="border-box"><label class="text-8-new-px arial ">@if($skills->distinctions) {{ $skills->distinctions }} @else N/A @endif</label></td>
                    <td style="height: 30px" colspan="2"  class="border-box"><label class="text-8-new-px arial ">@if($skills->org_membership) {{ $skills->org_membership }} @else N/A @endif</label></td>
                </tr>
            @endforeach

            @php
                $skills_row_added = $skills_row_max - $skills_row_current;
            @endphp

            @if($count_special_skills > 0)
                @for ($i = 1; $i <= $skills_row_added; $i++)
                    <tr>
                        <td colspan="3"  class="border-box h-15"><label class="text-10px arial "></label></td>
                        <td colspan="3"  class="border-box h-15"><label class="text-10px arial "></label></td>
                        <td colspan="2"  class="border-box h-15"><label class="text-10px arial "></label></td>
                    </tr>
                @endfor
            @elseif($count_special_skills == 0)
                @for ($skill_empty = 1; $skill_empty <= $skills_row_max; $skill_empty++)
                    <tr>
                        <td colspan="3"  class="border-box h-15"><label class="text-10px arial ">@if($skill_empty == 1) N/A @endif</label></td>
                        <td colspan="3"  class="border-box h-15"><label class="text-10px arial ">@if($skill_empty == 1) N/A @endif</label></td>
                        <td colspan="2"  class="border-box h-15"><label class="text-10px arial ">@if($skill_empty == 1) N/A @endif</label></td>
                    </tr>
                @endfor
            @endif
        @endif

        </tbody>


        <tr>
            <td colspan="8" class="border-top-bold border-bottom-bold border-right border-left column-color" style="text-align: center; height: 10px"><label style="font-style: italic; color: red" class="arial text-10px">(Continue on separate sheet if necessary)</label></td>
        </tr>

        <tr>
            <td             class="border-left border-right-bold border-bottom-bold arial text-9px font-bold text-center column-color">SIGNATURE</td>
            <td colspan="4" class="border-right-bold border-bottom-bold arial text-9px"></td>
            <td             class="border-right-bold border-bottom-bold arial text-9px font-bold text-center column-color">DATE</td>
            <td colspan="2" class="border-bottom-bold border-right arial text-9px"></td>
        </tr>

        <tr>
            <td colspan="8" style="text-align: right; height: 10px" class="border-bottom-bold border-right border-left arial text-8px">CS FORM 212 (Revised 2017), Page 3 of 4</td>
        </tr>
    </table>
    <!-- END: VIII OTHER INFORMATION -->

    <!-- BEGIN: PAGE BREAK -->
    <div class="page_break"></div>
    <!-- END:   PAGE BREAK -->


    <!-- BEGIN: LAST PART -->
    <!-- BEGIN: NUMBER 34 -->
    <table style="max-height: 1000px" class="my-table2 arial text-8px font-normal">

        <!-- BEGIN: NUMBER 34 -->
        <tr>
            <td style="width: 70%" class="border-top border-left border-right column-color">
                <div>34.</div>
                <div style="padding-left: 20px; margin-top:-20px">
                    <div>Are you related by consanguinity or affinity to the appointing or recommending authority, or to the</div>
                    <div>chief of bureau or office or to the person who has immediate supervision over you in the Office, </div>
                    <div>Bureau or Department where you will be appointed,</div>
                </div>
            </td>
            <td style="width: 30%" class="border-top border-left border-right">

            </td>
        </tr>

            <!-- BEGIN: NUMBER 34.a -->
            <tr>
               <td style="width: 70%" class="border-left border-right column-color">
                   <div style="padding-left: 20px; margin-top:-15px">
                       <div>a. within the third degree?</div>
                   </div>
                </td>

                <td style="padding:10px; width: 30%" class="border-left border-right">

                    @if($other_info)
                        @if($other_info->other_info_34_a == "1")
                            <div style="margin-top:-15px">
                                <input checked  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                                <input  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                            </div>
                        @elseif($other_info->other_info_34_a == "0")
                            <div style="margin-top:-15px">
                                <input  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                                <input checked type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                            </div>
                        @endif
                    @else
                        <div style="margin-top:-15px">
                            <input  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                            <input  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                        </div>
                    @endif
                </td>
            </tr>
            <!-- END: NUMBER 34.a -->

            <!-- BEGIN: NUMBER 34.b -->
            <tr>
                <td style="width: 70%" class="border-left border-right column-color">
                    <div style="padding-left: 20px; margin-top:-20px">
                        <div>b. within the fourth degree (for Local Government Unit - Career Employees)?</div>
                    </div>
                </td>

                <td style="padding:10px; width: 30%" class="border-left border-right">

                    @if($other_info)
                        @if($other_info->other_info_34_b == "1")
                            <div style="margin-top:-15px">
                                <input checked  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                                <input  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                            </div>
                        @elseif($other_info->other_info_34_b == "0")
                            <div style="margin-top:-15px">
                                <input  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                                <input checked type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                            </div>
                        @endif
                    @else
                            <div style="margin-top:-15px">
                                <input  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                                <input  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                            </div>
                    @endif
                </td>
            </tr>
            <tr>
                @if($other_info)
                    @if($other_info->other_info_34_b == "1")
                        <td style="width: 70%" class="border-left border-bottom border-right column-color">

                        </td>

                        <td style="padding:10px;  width: 30%" class="border-left border-bottom border-right">
                            <div style="margin-top:-20px">If YES, give details:<span style="text-decoration: underline;" class="ml-1">{{ $other_info->other_info_34_b_details }}</span></div>
                        </td>
                    @else
                        <td style="width: 70%" class="border-left border-right column-color">

                        </td>

                        <td style="padding:10px;  width: 30%" class="border-left  border-right">
                            <div style="margin-top:-20px">If YES, give details:__________________</div>
                        </td>
                    @endif
                    @else
                        <td style="width: 70%" class="border-left border-right column-color">

                        </td>

                        <td style="padding:10px;  width: 30%" class="border-left  border-right">
                            <div style="margin-top:-20px">If YES, give details:__________________</div>
                        </td>
                @endif
            </tr>

            @if($other_info)
                @if($other_info->other_info_34_b == "0")
                <tr>
                    <td style="width: 70%" class="border-left border-right column-color">

                    </td>

                    <td style="padding:10px;  width: 30%" class="border-left border-bottom border-right">
                        <div style="margin-top:-20px">_________________________________</div>
                    </td>
                </tr>
                @endif
            @else
            <tr>
                <td style="width: 70%" class="border-left border-right column-color">

                </td>

                <td style="padding:10px;  width: 30%" class="border-left border-bottom border-right">
                    <div style="margin-top:-20px">_________________________________</div>
                </td>
            </tr>
            @endif

        <!-- END: NUMBER 34 -->


        <!-- BEGIN: NUMBER 35.a -->
        <tr>
            <td style="width: 70%" class="border-top border-left border-right column-color">
                <div>35.</div>
                <div style="padding-left: 20px; margin-top:-20px">
                    <div>a. Have you ever been found guilty of any administrative offense?</div>
                </div>
            </td>
            <td style="padding:10px; width: 30%" class="border-left border-right">

                @if($other_info)
                    @if($other_info->other_info_35_a == "1")
                        <input checked  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                        <input  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                    @elseif($other_info->other_info_35_a == "0")
                        <input  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                        <input checked type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                    @else
                        <input  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                        <input  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                    @endif
                @else
                    <input  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                    <input  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                @endif
            </td>
        </tr>
        <tr>
            <td style="width: 70%" class="border-left border-right column-color">

            </td>
            <td style="padding:10px;  width: 30%" class="border-left border-bottom border-right">
                @if($other_info)
                    @if($other_info->other_info_35_a == "1")
                        <div style="margin-top:-20px">If YES, give details:<span style="text-decoration: underline" class="ml-1">{{ $other_info->other_info_35_a_details }}</span></div>
                    @else
                        <div style="margin-top:-20px">If YES, give details:__________________</div>
                    @endif
                @else
                    <div style="margin-top:-20px">If YES, give details:__________________</div>
                @endif
            </td>
        </tr>

        <!-- BEGIN: NUMBER 35.b -->
        <tr>
            <td style="width: 70%" class="border-left border-right column-color">
                <div style="padding-left: 20px;">
                    <div>b. Have you been criminally charged before any court?</div>
                </div>
            </td>

            <td style="padding:10px; width: 30%" class="border-right border-left ">

                @if($other_info)
                    @if($other_info->other_info_35_b == "1")
                        <div>
                            <input checked  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                            <input  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                        </div>
                    @elseif($other_info->other_info_35_b == "0")
                        <div>
                            <input  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                            <input checked type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                        </div>
                    @else
                        <div>
                            <input  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                            <input  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                        </div>
                    @endif
                @else
                    <div>
                        <input  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                        <input  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                    </div>
                @endif
            </td>
        </tr>
        <tr>
            <td style="width: 70%" class="border-left border-right column-color">

            </td>

            <td style="padding:10px;  width: 30%" class="border-left border-right">
                @if($other_info)
                    @if($other_info->other_info_35_b == "1")
                        <div style="margin-top:-20px">If YES, give details:<span style="text-decoration: underline" class="ml-1">{{ $other_info->other_info_35_b_details }}</span></div>
                    @else
                        <div style="margin-top:-20px">If YES, give details:__________________</div>
                    @endif
                @else
                    <div style="margin-top:-20px">If YES, give details:__________________</div>
                @endif
            </td>
        </tr>
        <tr>
            <td style="width: 70%" class="border-left border-right column-color">

            </td>

            <td style="padding:10px;  width: 30%" class="border-left border-right">
                @if($other_info)
                @if($other_info->other_info_35_b == "1")
                    <div style="margin-top:-20px; padding-left: 50px;">Date Filed:<span style="text-decoration: underline" class="ml-1">{{ $other_info->other_info_35_b_date_filed }}</span></div>
                @else
                    <div style="margin-top:-20px; padding-left: 50px;">Date Filed:_________________</div>
                @endif
                @else
                    <div style="margin-top:-20px; padding-left: 50px;">Date Filed:_________________</div>
                @endif
            </td>
        </tr>
        <tr>
            <td style="width: 70%" class="border-left border-bottom border-right column-color">

            </td>

            <td style="padding:10px;  width: 30%" class="border-left border-bottom border-right">
                @if($other_info)
                    @if($other_info->other_info_35_b == "1")
                        <div style="margin-top:-20px; padding-left: 50px;">Status of Case/s:<span style="text-decoration: underline" class="ml-1">{{ $other_info->other_info_35_b_status }}</span></div>
                    @else
                        <div style="margin-top:-20px; padding-left: 20px;">Status of Case/s:_________________</div>
                    @endif
                @else
                    <div style="margin-top:-20px; padding-left: 20px;">Status of Case/s:_________________</div>
                @endif
            </td>
        </tr>
        <!-- END: NUMBER 35.b -->


        <!-- BEGIN: NUMBER 36 -->
        <tr>
            <td style="width: 70%" class="border-top border-left border-right column-color">
                <div>36.</div>
                <div style="padding-left: 20px; margin-top:-20px">
                    <div>Have you ever been convicted of any crime or violation of any law, decree, ordinance or regulation by any court or tribunal?</div>
                </div>
            </td>
            <td style="padding:10px; width: 30%" class="border-left border-right">
                @if($other_info)
                    @if($other_info->other_info_36 == "1")
                        <div style="margin-top:-15px">
                            <input checked  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                            <input  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                        </div>
                    @elseif($other_info->other_info_36 == "0")
                        <div style="margin-top:-15px">
                            <input  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                            <input checked type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                        </div>
                    @else
                        <div style="margin-top:-15px">
                            <input  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                            <input  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                        </div>
                @endif
                @else
                    <div style="margin-top:-15px">
                        <input  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                        <input  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                    </div>
                @endif
            </td>
        </tr>
        <tr>
            <td style="width: 70%" class="border-left border-bottom border-right column-color">

            </td>

            <td style="padding:10px;  width: 30%" class="border-left border-bottom border-right">
                @if($other_info)
                    @if($other_info->other_info_36 == "1")
                        <div style="margin-top:-20px">If YES, give details:<span style="text-decoration: underline" class="ml-1">{{ $other_info->other_info_36_details }}</span></div>
                    @else
                        <div style="margin-top:-20px">If YES, give details:__________________</div>
                @endif
                @else
                    <div style="margin-top:-20px">If YES, give details:__________________</div>
                @endif
            </td>
        </tr>
        <!-- END: NUMBER 36 -->



        <!-- BEGIN: NUMBER 37 -->
        <tr>
            <td style="width: 70%" class="border-top border-left border-right column-color">
                <div>37.</div>
                <div style="padding-left: 20px; margin-top:-20px">
                    <div>Have you ever been separated from the service in any of the following modes: resignation, retirement, dropped from the rolls, dismissal, termination, end of term, finished contract or phased out (abolition) in the public or private sector?</div>
                </div>
            </td>
            <td style="padding:10px; width: 30%" class="border-left border-bottom border-right">
                @if($other_info)
                    @if($other_info->other_info_37 == "1")
                        <div >
                            <input checked  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                            <input  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                            <div style="margin-top: 5px">If YES, give details: <span style="text-decoration: underline" class="ml-1">{{ $other_info->other_info_37_details }}</span></div>
                        </div>
                    @elseif($other_info->other_info_37 == "0")
                        <div >
                            <input  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                            <input checked type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                            <div style="margin-top: 5px">If YES, give details:__________________</div>
                            <div>__________________________________</div>
                        </div>
                    @else
                        <div >
                            <input  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                            <input  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                            <div style="margin-top: 5px">If YES, give details:__________________</div>
                                        <div>__________________________________</div>
                        </div>
                    @endif
                @else
                    <div >
                        <input  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                        <input  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                        <div style="margin-top: 5px">If YES, give details:__________________</div>
                        <div>__________________________________</div>
                    </div>
                @endif

            </td>
        </tr>
        <!-- END: NUMBER 37 -->


        <!-- BEGIN: NUMBER 38.a -->
        <tr>
            <td style="width: 70%" class="border-top border-left border-right column-color">
                <div>38.</div>
                <div style="padding-left: 20px; margin-top:-20px">
                    <div>a. Have you ever been a candidate in a national or local election held within the last year (except Barangay election)?</div>
                </div>
            </td>
            <td style="padding:10px; width: 30%" class="border-left border-right">
                @if($other_info)
                    @if($other_info->other_info_38_a == "1")
                        <input checked  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                        <input  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                    @elseif($other_info->other_info_38_a == "0")
                        <input  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                        <input checked type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                @else
                    <input  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                    <input  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                @endif
                @else
                    <input  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                    <input  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                @endif
            </td>
        </tr>
        <tr>
            <td style="width: 70%" class="border-left border-right column-color">

            </td>

            <td style="padding:10px;  width: 30%" class="border-left border-right">
                @if($other_info)
                    @if($other_info->other_info_38_a == "1")
                        <div style="margin-top:-20px">If YES, give details:<span style="text-decoration: underline" class="ml-1">{{ $other_info->other_info_38_a_details }}</span></div>
                    @else
                        <div style="margin-top:-20px">If YES, give details:__________________</div>
                @endif
                @else
                    <div style="margin-top:-20px">If YES, give details:__________________</div>
                @endif
            </td>
        </tr>
        <!-- END: NUMBER 38.a -->

        <!-- BEGIN: NUMBER 38.b -->
        <tr>
            <td style="width: 70%" class="border-left border-right column-color">
                <div style="padding-left: 20px; margin-top: -20px">
                    <div>b. Have you resigned from the government service during the three (3)-month period before the last election to promote/actively campaign for a national or local candidate?</div>
                </div>
            </td>

            <td style="padding:10px; width: 30%" class="border-right border-left ">
                @if($other_info)
                    @if($other_info->other_info_38_b == "1")
                        <div style="margin-top: -20px">
                            <input checked  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                            <input  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                        </div>
                    @elseif($other_info->other_info_38_b == "0")
                        <div style="margin-top: -20px">
                            <input  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                            <input checked type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                        </div>
                    @else
                        <div style="margin-top: -20px">
                            <input  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                            <input  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                        </div>
                @endif
                @else
                    <div style="margin-top: -20px">
                        <input  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                        <input  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                    </div>
                @endif
            </td>
        </tr>
        <tr>
            <td style="width: 70%" class="border-left border-bottom border-right column-color">

            </td>

            <td style="padding:10px;  width: 30%" class="border-left border-bottom border-right">
                @if($other_info)
                    @if($other_info->other_info_38_b == "1")
                        <div style="margin-top:-20px">If YES, give details:<span style="text-decoration: underline" class="ml-1">{{ $other_info->other_info_38_b_details }}</span></div>
                    @else
                        <div style="margin-top:-20px">If YES, give details:__________________</div>
                    @endif
                @else
                    <div style="margin-top:-20px">If YES, give details:__________________</div>
                @endif
            </td>
        </tr>
        <!-- END: NUMBER 38.b -->

        <!-- BEGIN: NUMBER 39 -->
        <tr>
            <td style="width: 70%" class="border-top border-left border-right column-color">
                <div>39.</div>
                <div style="padding-left: 20px; margin-top:-20px">
                    <div>Have you acquired the status of an immigrant or permanent resident of another country?</div>
                </div>
            </td>
            <td style="padding:10px; width: 30%" class="border-left border-right">
                @if($other_info)
                    @if($other_info->other_info_39 == "1")
                        <div >
                            <input checked  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                            <input  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                        </div>
                    @elseif($other_info->other_info_39 == "0")
                        <div >
                            <input  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                            <input checked type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                        </div>
                    @else
                        <div >
                            <input  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                            <input  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                        </div>
                    @endif
                @else
                    <div >
                        <input  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                        <input  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                    </div>
                @endif
            </td>
        </tr>
        <tr>
            <td style="width: 70%" class="border-left border-right column-color">

            </td>

            <td style="padding:10px;  width: 30%" class="border-left border-right">
                @if($other_info)
                    @if($other_info->other_info_39 == "1")
                        <div style="margin-top: -15px">If YES, give details (country):
                            <span style="text-decoration: underline;" class="ml-1">{{ $other_info->other_info_39_details }}</span>
                        </div>
                    @else
                        <div style="margin-top: -15px">If YES, give details (country):__________</div>
                    @endif
                @else
                    <div style="margin-top: -15px">If YES, give details (country):__________</div>
                @endif
            </td>
        </tr>

        @if($other_info)
            @if($other_info->other_info_39 == "0")
                <tr>
                    <td style="width: 70%" class="border-left border-right column-color">

                    </td>

                    <td style="padding:10px;  width: 30%" class="border-left border-right">
                        <div style="margin-top: -15px">_________________________________</div>
                    </td>
                </tr>
            @endif
        @else
            <tr>
                <td style="width: 70%" class="border-left border-right column-color">

                </td>

                <td style="padding:10px;  width: 30%" class="border-left border-right">
                    <div style="margin-top: -15px">_________________________________</div>
                </td>
            </tr>
        @endif
        <!-- END: NUMBER 39 -->

        <!-- BEGIN: NUMBER 40 -->
        <tr>
            <td style="width: 70%" class="border-top border-left border-right column-color">
                <div>40.</div>
                <div style="padding-left: 20px; margin-top:-20px">
                    <div>Pursuant to: (a) Indigenous People's Act (RA 8371); (b) Magna Carta for Disabled Persons (RA</div>
                    <div>7277); and (c) Solo Parents Welfare Act of 2000 (RA 8972), please answer the following items:</div>
                </div>
            </td>
            <td style="width: 30%" class="border-top border-left border-right">

            </td>
        </tr>

            <!-- BEGIN: NUMBER 40.a -->
            <tr>
                <td style="width: 70%" class="border-left border-right column-color">
                    <div style="padding-left: 20px; margin-top: -10px">
                        <div>a. Are you a member of any indigenous group?</div>
                    </div>
                </td>

                <td style="padding:10px; width: 30%" class="border-right border-left ">

                    @if($other_info)
                        @if($other_info->other_info_40_a == "1")
                            <div style="margin-top: -10px">
                                <input checked  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                                <input  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                            </div>
                        @elseif($other_info->other_info_40_a == "0")
                            <div style="margin-top: -10px">
                                <input  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                                <input checked type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                            </div>
                        @else
                            <div style="margin-top: -10px">
                                <input  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                                <input  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                            </div>
                        @endif
                    @else
                        <div style="margin-top: -10px">
                            <input  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                            <input  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                        </div>
                    @endif
                </td>
            </tr>

            <tr>
                <td style="width: 70%" class="border-left border-right column-color">

                </td>

                <td style="padding:10px;  width: 30%" class="border-left border-right">
                    @if($other_info)
                        @if($other_info->other_info_40_a == "1")
                            <div style="margin-top:-20px">If YES, give details:<span style="text-decoration: underline" class="ml-1">{{ $other_info->other_info_40_a_details }}</span></div>
                        @else
                            <div style="margin-top:-20px">If YES, give details:__________________</div>
                        @endif
                    @else
                        <div style="margin-top:-20px">If YES, give details:__________________</div>
                    @endif
                </td>
            </tr>

        @if($other_info)
            @if($other_info->other_info_40_a == "0")
            <tr>
                <td style="width: 70%" class="border-left border-right column-color">

                </td>

                <td style="padding:10px;  width: 30%" class="border-left border-right">
                    <div style="margin-top:-20px">__________________________________</div>
                </td>
            </tr>
            @endif
        @else
            <tr>
                <td style="width: 70%" class="border-left border-right column-color">

                </td>

                <td style="padding:10px;  width: 30%" class="border-left border-right">
                    <div style="margin-top:-20px">__________________________________</div>
                </td>
            </tr>
        @endif
            <!-- END: NUMBER 40.a -->

            <!-- BEGIN: NUMBER 40.b -->
            <tr>
                <td style="width: 70%" class="border-left border-right column-color">
                    <div style="padding-left: 20px; margin-top: -20px">
                        <div>b. Are you a person with disability?</div>
                    </div>
                </td>

                <td style="padding:10px; width: 30%" class="border-right border-left ">

                    @if($other_info)
                        @if($other_info->other_info_40_b == "1")
                            <div style="margin-top: -20px">
                                <input checked  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                                <input  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                            </div>
                        @elseif($other_info->other_info_40_b == "0")
                            <div style="margin-top: -20px">
                                <input  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                                <input checked type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                            </div>
                        @else
                            <div style="margin-top: -20px">
                                <input  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                                <input  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                            </div>
                        @endif
                    @else
                        <div style="margin-top: -20px">
                            <input  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                            <input  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                        </div>
                    @endif
                </td>
            </tr>

        @if($other_info)
                @if($other_info->other_info_40_b == "1")
                    <tr>
                        <td style="width: 70%" class="border-left border-right column-color">

                        </td>
                        <td style="padding:10px;  width: 30%" class="border-left border-right te">
                            <div style="margin-top:-20px">If YES, please Specify ID No:<span style="text-decoration: underline" class="ml-1">{{ $other_info->other_info_40_b_details }}</span></div>
                        </td>
                    </tr>
                @else
                    <tr>
                        <td style="width: 70%" class="border-left border-right column-color">

                        </td>
                        <td style="padding:10px;  width: 30%" class="border-left border-right">
                            <div style="margin-top:-20px">If YES, please Specify ID No:___________</div>
                        </td>
                    </tr>

                    <tr>
                        <td style="width: 70%" class="border-left border-right column-color">

                        </td>
                        <td style="padding:10px;  width: 30%" class="border-left border-right">
                            <div style="margin-top:-20px; margin-bottom: -10px">__________________________________</div>
                        </td>
                    </tr>
                @endif
            @else
                <tr>
                    <td style="width: 70%" class="border-left border-right column-color">

                    </td>
                    <td style="padding:10px;  width: 30%" class="border-left border-right">
                        <div style="margin-top:-20px">If YES, please Specify ID No:___________</div>
                    </td>
                </tr>

                <tr>
                    <td style="width: 70%" class="border-left border-right column-color">

                    </td>
                    <td style="padding:10px;  width: 30%" class="border-left border-right">
                        <div style="margin-top:-20px; margin-bottom: -10px">__________________________________</div>
                    </td>
                </tr>
            @endif

            <!-- END: NUMBER 40.b -->

            <!-- BEGIN: NUMBER 40.c -->
            <tr>
                <td style="width: 70%" class="border-left border-right column-color">
                    <div style="padding-left: 20px; margin-top: -15px">
                        <div>c. Are you a solo parent?</div>
                    </div>
                </td>

                <td style="padding:10px; width: 30%" class="border-right border-left ">
                    @if($other_info)
                        @if($other_info->other_info_40_c == "1")
                            <div style="margin-top: -20px">
                                <input checked  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                                <input  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                            </div>
                        @elseif($other_info->other_info_40_c == "0")
                            <div style="margin-top: -20px">
                                <input  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                                <input checked type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                            </div>
                        @else
                            <div style="margin-top: -20px">
                                <input  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                                <input  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                            </div>
                    @endif
                    @else
                        <div style="margin-top: -20px">
                            <input  type="checkbox" style="margin-bottom: -7px" id="dual_check"> <label class="ml-1">YES</label>
                            <input  type="checkbox" style="margin-bottom: -7px; margin-left: 21px" id="dual_check"><label class="ml-1">NO</label>
                        </div>
                    @endif
                </td>
            </tr>

        @if($other_info)
            @if($other_info->other_info_40_c == "1")
                <tr>
                    <td style="width: 70%" class="border-left border-right column-color">

                    </td>
                    <td style="padding:10px;  width: 30%" class="border-left border-right">
                        <div style="margin-top:-20px">If YES, please Specify ID No:<span style="text-decoration: underline" class="ml-1">{{ $other_info->other_info_40_c_details }}</span></div>
                    </td>
                </tr>
            @else
                <tr>
                    <td style="width: 70%" class="border-left border-right column-color">

                    </td>
                    <td style="padding:10px;  width: 30%" class="border-left border-right">
                        <div style="margin-top:-20px">If YES, please Specify ID No:___________</div>
                    </td>
                </tr>

                <tr>
                    <td style="width: 70%" class="border-left border-right column-color">

                    </td>
                    <td style="padding:10px;  width: 30%" class="border-left border-right">
                        <div style="margin-top:-20px; margin-bottom: -10px">__________________________________</div>
                    </td>
                </tr>
            @endif
        @else
            <tr>
            <td style="width: 70%" class="border-left border-right column-color">

            </td>
            <td style="padding:10px;  width: 30%" class="border-left border-right">
                <div style="margin-top:-20px">If YES, please Specify ID No:___________</div>
            </td>
            </tr>

            <tr>
                <td style="width: 70%" class="border-left border-right column-color">

                </td>
                <td style="padding:10px;  width: 30%" class="border-left border-right">
                    <div style="margin-top:-20px; margin-bottom: -10px">__________________________________</div>
                </td>
            </tr>
        @endif

            <!-- END: NUMBER 40.c -->

        <!-- END: NUMBER 40 -->

    </table>

    <!-- BEGIN: REFERENCES -->
    <table class="my-table arial font-normal text-8px">

        <!-- BEGIN: NUMBER 41. -->
        <tr>
            <td style="width: 80%" class="border-box column-color">
                <div style="padding-left: 0.25rem; margin-top: -10px height: 5px">41. REFERENCES <label style="font-style: italic; color: red; font-size: 10px">(Person not related by consanguinity or affinity to applicant /appointee)</label></div>
            </td>
            <td style="width: 20%" class="border-top border-left border-right">

            </td>
        </tr>

        <!-- BEGIN: REFREENCES. -->
        <tr>
            <td style="width: 80%" class="border-box">
                <div style="margin: -1px">
                    <table class="my-table">
                        <tr>
                            <td style="width: 25%" class="border-right border-bottom column-color">
                                <div class="text-center font-normal text-8px">Name </div>
                            </td>
                            <td style="width: 25%" class="border-right border-bottom column-color">
                                <div class="text-center font-normal text-8px">Address </div>
                            </td>
                            <td style="width: 20%" class="border-bottom column-color">
                                <div class="text-center font-normal text-8px">TEL NO. </div>
                            </td>
                        </tr>

                        @php
                            $_row_max = 3;
                            $row_current = 0;
                        @endphp

                        @forelse($references as $ref)
                            @php
                                $row_current++;
                            @endphp
                            <tr>
                                <td style="width: 25%" class="border-right border-bottom">
                                    <div class="text-center font-normal text-8px"> {{ $ref->name }} </div>
                                </td>
                                <td style="width: 25%" class="border-right border-bottom">
                                    <div class="text-center font-normal text-8px"> {{ $ref->address }} </div>
                                </td>
                                <td style="width: 20%" class="border-bottom">
                                    <div class="text-center font-normal text-8px"> {{ $ref->tel_no }} </div>
                                </td>
                            </tr>
                        @empty
                            @for ($i = 1; $i <= $row_current; $i++)
                                <tr>
                                    <td style="width: 25%" class="border-right border-bottom">
                                        <div class="text-center font-normal text-8px">N/A</div>
                                    </td>
                                    <td style="width: 25%" class="border-right border-bottom">
                                        <div class="text-center font-normal text-8px">N/A</div>
                                    </td>
                                    <td style="width: 20%" class="border-bottom">
                                        <div class="text-center font-normal text-8px">N/A</div>
                                    </td>
                                </tr>
                            @endfor
                        @endforelse

                        @php
                            $child_row_added = $_row_max - $row_current;
                        @endphp

                        @for ($i = 1; $i <= $child_row_added; $i++)

                            <tr>
                                <td style="width: 25%" class="border-right border-bottom">
                                    <div class="text-center font-normal text-8px">N/A</div>
                                </td>
                                <td style="width: 25%" class="border-right border-bottom">
                                    <div class="text-center font-normal text-8px">N/A</div>
                                </td>
                                <td style="width: 20%" class="border-bottom">
                                    <div class="text-center font-normal text-8px">N/A</div>
                                </td>
                            </tr>
                    @endfor


                    <!-- END: NUMBER 41. -->

                        <!-- BEGIN: NUMBER 42. -->
                        <tr>
                            <td  colspan="3" class="column-color px-1">
                                <div class="arial text-8px font-normal">42.</div>
                                <div style="padding-left: 20px; margin-top: -20px" class="arial text-8px font-normal">I declare under oath that I have personally accomplished this Personal Data Sheet which is a true, correct and complete statement pursuant to the provisions of pertinent laws, rules and regulations of the Republic of the Philippines. I authorize the agency head / authorized representative to verify/validate the contents stated herein. I  agree that any misrepresentation made in this document and its attachments shall cause the filing of administrative/criminal case/s against me.</div>
                            </td>
                        </tr>
                        <!-- BEGIN: NUMBER 42. -->
                    </table>
                </div>
            </td>

            <td style="width: 20%; padding: 10px" class="border-right border-left">
                <div style="margin-left: 15px">

                    @if($pds)
                        <div style="height: 110px; width: 110px; padding: 2px; font-size: 7px"  class="border-box text-center">
                            @if($pds->image)
                                <div >ID picture taken within</div>
                                <div class="-mt-7">the last  6 months</div>
                                <div class="-mt-7">3.5 cm. X 4.5 cm</div>
                                <div class="-mt-7">(passport size)</div>

                                <div class="-mt-5">With full and handwritten</div>
                                <div class="-mt-7">name tag and signature over</div>
                                <div class="-mt-7">printed name</div>

                                <div class="-mt-5">Computer generated</div>
                                <div class="-mt-7">or photocopied picture</div>
                                <div class="-mt-7">is not acceptable</div>
                            @else
                                <div >ID picture taken within</div>
                                <div class="-mt-7">the last  6 months</div>
                                <div class="-mt-7">3.5 cm. X 4.5 cm</div>
                                <div class="-mt-7">(passport size)</div>

                                <div class="-mt-5">With full and handwritten</div>
                                <div class="-mt-7">name tag and signature over</div>
                                <div class="-mt-7">printed name</div>

                                <div class="-mt-5">Computer generated</div>
                                <div class="-mt-7">or photocopied picture</div>
                                <div class="-mt-7">is not acceptable</div>
                            @endif
                        </div>
                    @endif
                </div>
            </td>
        </tr>
        <!-- END: REFERENCES. -->

    </table>

    <table class="my-table arial font-normal text-8px">
        <tr>
            <!-- BEGIN: Government Issued ID -->
            <td style="width: 40%" class="border-bottom border-top border-left">
                <table style="padding: 5px" class="reference-table border-box">
                    <tr>
                        <td colspan="2" class="column-color border-box">
                            <div style="height: 15px; font-size: 8px; margin-top: -5px" class="font-normal">
                                Government Issued ID (i.e.Passport, GSIS, SSS, PRC, Driver's License, etc.)
                            </div>
                            <div style="height: 15px; font-size: 8px; margin-top: -5px" class="font-normal">PLEASE INDICATE ID Number and Date of Issuance</div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 40%" class="border-bottom">
                            <div style="height: 10px" class="text-8px font-normal">Government Issued ID:</div>
                        </td>
                        <td style="width: 60%" class="border-bottom">
                            <div style="height: 10px" class="text-8px font-normal">@if($government_id) {{ $government_id->gvt_issued_id }} @else N/A @endif</div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 40%" class="border-bottom">
                            <div style="height: 10px" class="text-8px font-normal">ID/License/Passport No.: </div>
                        </td>
                        <td style="width: 60%" class="border-bottom">
                            <div style="height: 10px" class="text-8px font-normal">@if($government_id) {{ $government_id->id_license_passport_no }} @else N/A @endif </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 40%">
                            <div class="text-8px font-normal items-center"><label>Date/Place of Issuance:</label></div>
                        </td>
                        <td style="width: 60%; height: 30px">
                            <div class="text-8px font-normal items-center"><label>@if($government_id){{ $government_id->date_place_issuance }} @else N/A @endif</label></div>
                        </td>
                    </tr>
                </table>
            </td>
            <!-- END: Government Issued ID -->

            <td style="width: 40%" class="border-bottom border-top">
              <div style="margin-right: -6px">
                  <table style="padding: 5px" class="reference-table border-box">
                      <tr>
                          <td >
                              <div style="height: 50px"></div>
                          </td>
                      </tr>
                      <tr>
                          <td class="column-color text-center border-top">
                              <div style="font-size: 5px; margin-top: -8px; height: 15px" >Signature (Sign inside the box)</div>
                          </td>
                      </tr>
                      <tr>
                          <td class="border-top">
                              <div style="font-size: 5px; margin-top: -8px; height: 15px" ></div>
                          </td>
                      </tr>
                      <tr>
                          <td class="column-color text-center border-top">
                              <div style="font-size: 5px; margin-top: -8px; height: 15px" >Date Accomplished</div>
                          </td>
                      </tr>
                  </table>
              </div>
            </td>

            <td style="width: 20%" class="border-right border-bottom">
                <table style="padding: 5px" class="reference-table border-box">
                    <tr>
                        <td >
                            <div style="height: 80px"></div>
                        </td>
                    </tr>
                    <tr>
                        <td class="column-color text-center border-top">
                            <div style="font-size: 5px; margin-top: -8px; height: 15px" >Right Thumbmark</div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>



    <!-- BEGIN: SUBSCRIBED AND SWORN. -->
    <table class="my-table arial font-normal text-8px">
        <tr>
            <td colspan="3" class="text-center border-left border-right border-top">
                <div class="arial text-8px font-normal">SUBSCRIBED AND SWORN to before me this ___________________________________________________________, affiant exhibiting his/her validly issued government ID as indicated above.</div>
            </td>
        </tr>

        <tr>
            <td style="width: 38%" class="border-left border-bottom"></td>

            <td style="width: 25%" class="text-center border-bottom">
                <table style="padding: 5px" class="reference-table">
                    <tr>
                        <td class="border-box">
                            <div style="height: 37px"></div>
                        </td>
                    </tr>
                    <tr>
                        <td class="column-color text-center border-box">
                            <div style="font-size: 5px; margin-top: -8px; height: 15px" >Person Administering Oath</div>
                        </td>
                    </tr>
                </table>
            </td>

            <td style="width: 37%" class="border-right border-bottom"></td>
        </tr>
    </table>
    <!-- END: SUBSCRIBED AND SWORN. -->

    <!-- BEGIN: CS FORM 212 LAST PAGE. -->
    <table class="my-table">
        <tr>
            <td colspan="8" style="text-align: right; height: 7px" class="border-box arial text-8px">CS FORM 212 (Revised 2017), Page 4 of 4</td>
        </tr>
    </table>
    <!-- END: CS FORM 212 LAST PAGE. -->
</main>

</body>
</html>
