<!DOCTYPE html>
<html>

<head>

    <meta charset = "UTF-8">
    <title>{{ $system_agency_name->value }}</title>

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

        .page-number:before {
            content: counter(page);
        }

    </style>

</head>

<footer>
    <br>
    <div class="text-right px-1 mt-7"><label class="arial font-normal text-italic text-6px-new">Page <span class="page-number"></span></label></div>

</footer>

<body>

<main >

    <!-- BEGIN: HEADER -->
    <table class="my-table">
        <tr>
            <td colspan="3" style="padding-left: 5px">
                <div style="font-style: italic; font-weight: bold;" class="calibri text-11px">CS Form No. 7</div>
                <div style="font-style: italic; font-weight: bold; margin-top: -5px" class="calibri text-9px">Revised 2018</div>
            </td>
        </tr>

        <tr >
            <td colspan="3">
                <div style="margin-top: -10px" class="text-center"><label style="font-weight: bold; text-transform: uppercase" class="arial text-15px">@if($system_agency_name) {{ $system_agency_name->value }} @endif</label></div>
            </td>
        </tr>
        <tr >
            <td colspan="3">
                <div class="text-center"><label style="font-weight: bold" class="arial text-15px">CLEARANCE FORM</label></div>
            </td>
        </tr>
        <tr >
            <td colspan="3">
                <div class="text-center"><label style="font-weight: normal; font-style: italic" class="arial text-11px">(Instructions at the back)</label></div>
            </td>
        </tr>

    </table>
    <!-- END: HEADER -->



    <!-- BEGIN: I. PURPOSE -->
    <table class="my-table mt-1">
        <tr>
            <td width="20px" class="border-top-bold border-left-bold border-bottom border-right">
                <div class="text-left px-1"><label class="arial font-bold text-11px">I</label></div>
            </td>
            <td class="border-top-bold border-right-bold border-bottom">
                <div class="text-left px-1"><label class="arial font-bold text-11px">PURPOSE</label></div>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="border-left-bold border-right-bold">
                <div style="margin-top: -2px" class="text-right mr-5 mt-2"><label class="arial font-bold text-11px underlined">@if($get_clearance_csc_others) {{ Carbon\Carbon::parse($get_clearance_csc_others->date_filing)->isoFormat('MMMM DD, YYYY') }} @else {{ date("F j, Y") }} @endif</label></div>
                <div class="text-right" style="margin-right: 20px"><label class="arial font-normal text-11px">Date of filing</label></div>
            </td>
        </tr>
        <tr>
            <td width="20px" class="border-left-bold">
                <div style="margin-top: -37px" class="text-left px-1"><label class="arial font-bold text-11px">TO:</label></div>
            </td>
            <td style="padding-left: 50px" class="border-right-bold">
                <div style="margin-top: -15px" class="text-left px-1"><label style="text-transform: uppercase" class="arial font-bold text-11px underlined">@if($system_agency_name) {{ $system_agency_name->value }} @endif</label></div>
                <div class="text-left px-1"><label class="arial font-normal text-11px">I hereby request clearance from money, property and work-related accountabilities for:</label></div>

                <div class="text-left px-1 arial font-normal text-11px mt-2">
                    <label>Purpose:</label>

                    @if($get_clearance_csc_others)

                        @if($get_clearance_csc_others->purpose == 'Transfer')

                            <input type="checkbox" class="ml-5" style="margin-bottom: -7px" checked > <label class="ml-1">Transfer</label>
                            <input type="checkbox"              style="margin-bottom: -7px; margin-left: 30px" > <label class="ml-1">Resignation</label>
                            <input type="checkbox" class="ml-5" style="margin-bottom: -7px" > <label class="ml-1">Other Mode of Separation:</label>

                        @elseif($get_clearance_csc_others->purpose == 'Resignation')

                            <input type="checkbox" class="ml-5" style="margin-bottom: -7px"  > <label class="ml-1">Transfer</label>
                            <input type="checkbox"              style="margin-bottom: -7px; margin-left: 30px" checked> <label class="ml-1">Resignation</label>
                            <input type="checkbox" class="ml-5" style="margin-bottom: -7px" > <label class="ml-1">Other Mode of Separation:</label>

                        @elseif($get_clearance_csc_others->purpose == 'Others')

                            <input type="checkbox" class="ml-5" style="margin-bottom: -7px"  > <label class="ml-1">Transfer</label>
                            <input type="checkbox"              style="margin-bottom: -7px; margin-left: 30px"> <label class="ml-1">Resignation</label>
                            <input type="checkbox" class="ml-5" style="margin-bottom: -7px" checked> <label class="ml-1">Other Mode of Separation:</label>

                        @else
                            <input type="checkbox" class="ml-5" style="margin-bottom: -7px"  > <label class="ml-1">Transfer</label>
                            <input type="checkbox"              style="margin-bottom: -7px; margin-left: 30px"> <label class="ml-1">Resignation</label>
                            <input type="checkbox" class="ml-5" style="margin-bottom: -7px" > <label class="ml-1">Other Mode of Separation:</label>
                        @endif

                    @else

                        <input type="checkbox" class="ml-5" style="margin-bottom: -7px"  > <label class="ml-1">Transfer</label>
                        <input type="checkbox"              style="margin-bottom: -7px; margin-left: 30px"> <label class="ml-1">Resignation</label>
                        <input type="checkbox" class="ml-5" style="margin-bottom: -7px" > <label class="ml-1">Other Mode of Separation:</label>

                    @endif

                </div>
                <div class="text-left px-1 arial font-normal text-11px">
                    <label style="visibility: hidden">Purpose:</label>

                    @if($get_clearance_csc_others)

                        @if($get_clearance_csc_others->purpose == 'Retirement')

                        <input type="checkbox" class="ml-5" style="margin-bottom: -7px" checked > <label class="ml-1">Retirement</label>
                        <input type="checkbox" style="margin-bottom: -7px; margin-left: 17px"   > <label class="ml-1">Leave</label>
                        <label style="margin-left: 73px">Please specify:___________________________________</label>

                        @elseif($get_clearance_csc_others->purpose == 'Leave')

                            <input type="checkbox" class="ml-5" style="margin-bottom: -7px"  > <label class="ml-1">Retirement</label>
                            <input type="checkbox" style="margin-bottom: -7px; margin-left: 17px" checked> <label class="ml-1">Leave</label>
                            <label style="margin-left: 73px">Please specify:___________________________________</label>

                        @elseif($get_clearance_csc_others->purpose == 'Others')

                            <input type="checkbox" class="ml-5" style="margin-bottom: -7px"  > <label class="ml-1">Retirement</label>
                            <input type="checkbox" style="margin-bottom: -7px; margin-left: 17px"> <label class="ml-1">Leave</label>
                            <label style="margin-left: 73px">Please specify:<span class="underlined">{{ $get_clearance_csc_others->purpose_others }}</span></label>

                        @else

                            <input type="checkbox" class="ml-5" style="margin-bottom: -7px"  > <label class="ml-1">Retirement</label>
                            <input type="checkbox" style="margin-bottom: -7px; margin-left: 17px"> <label class="ml-1">Leave</label>
                            <label style="margin-left: 73px">Please specify:___________________________________</label>

                        @endif

                    @else

                        <input type="checkbox" class="ml-5" style="margin-bottom: -7px"  > <label class="ml-1">Retirement</label>
                        <input type="checkbox" style="margin-bottom: -7px; margin-left: 17px"> <label class="ml-1">Leave</label>
                        <label style="margin-left: 73px">Please specify:___________________________________</label>

                    @endif

                </div>

                <div class="text-left px-1 arial font-normal text-11px mt-2 mb-1">
                    @if($get_clearance_csc_others)

                        <label>Date of Effectivity: <span class="underlined">{{ Carbon\Carbon::parse($get_clearance_csc_others->date_effective)->isoFormat('MMMM DD, YYYY') }}</span> </label>

                    @else

                        <label>Date of Effectivity:_____________________________________________________________</label>

                    @endif

                </div>
            </td>
        </tr>
    </table>
    <table class="my-table">
        <tr>
            <td width="50%" height="60px" class="border-top border-bottom-bold border-left-bold border-right">
                <div class="text-left px-1"><label class="arial font-normal text-11px">Office Assignment: <span class="ml-1 underlined">{{ $office_assign }}</span></label></div>

                @if($get_clearance_csc_others)

                    @if($get_clearance_csc_others->get_Position && $get_clearance_csc_others->get_SG && $get_clearance_csc_others->get_Step)

                        <div class="text-left px-1 ml-1 mb-1"><label class="arial font-normal text-11px">Position/SG/Step: <span class="underlined ml-1">{{ $get_clearance_csc_others->get_Position->emp_position.'/ '.$get_clearance_csc_others->get_SG->code.'/ '.$get_clearance_csc_others->get_Step->stepname }}</span> </label></div>

                    @elseif($get_clearance_csc_others->get_Position)

                        <div class="text-left px-1 ml-1 mb-1"><label class="arial font-normal text-11px">Position/SG/Step: <span class="underlined ml-1">{{ $get_clearance_csc_others->get_Position->emp_position }}</span> </label></div>


                    @elseif($get_clearance_csc_others->get_SG)

                        <div class="text-left px-1 ml-1 mb-1"><label class="arial font-normal text-11px">Position/SG/Step: <span class="underlined ml-1">{{ $get_clearance_csc_others->get_SG->code }}</span> </label></div>

                    @elseif($get_clearance_csc_others->get_Step)

                        <div class="text-left px-1 ml-1 mb-1"><label class="arial font-normal text-11px">Position/SG/Step: <span class="underlined ml-1">{{ $get_clearance_csc_others->get_Step->stepname }}</span> </label></div>

                    @else

                        <div class="text-left px-1 ml-1 mb-1"><label class="arial font-normal text-11px">Position/SG/Step: _____________________________________</label></div>

                    @endif

                @else

                    <div class="text-left px-1 ml-1 mb-1"><label class="arial font-normal text-11px">Position/SG/Step: _____________________________________</label></div>

                @endif

            </td>
            <td width="50%" height="60px" class="border-top border-bottom-bold border-right-bold">
                <div style="margin-bottom: -25px" class="text-center px-1"><img src="{{ $my_signature }}" style="width: 100px; height: 50px"></div>
                <div class="text-center px-1"><label class="arial font-normal text-11px"><span class="ml-1 underlined">{{ $my_full_name }}</span></label></div>
                <div class="text-center px-1 mb-1"><label class="arial font-normal text-11px">Name and Signature of Employee</label></div>
            </td>
        </tr>
    </table>
    <!-- END: I. PURPOSE -->




    <!-- BEGIN: II. CLEARANCE FROM WORK-RELATED ACCOUNTABILITIES -->
    <table class="my-table">
        <tr>
            <td width="26px" class="border-left-bold border-right border-bottom border-top-bold">
                <div class="text-left px-1"><label class="arial font-bold text-11px">II</label></div>
            </td>
            <td class="border-right-bold border-bottom border-top-bold">
                <div class="text-left px-1"><label class="arial font-bold text-11px">CLEARANCE FROM WORK-RELATED ACCOUNTABILITIES</label></div>
            </td>
        </tr>
    </table>
    <table class="my-table">
        <tr>
            <td colspan="2" style="padding-left: 50px" class="border-left-bold border-right-bold">
                <div class="text-left px-1 arial font-normal text-11px mt-1">

                    @if($get_clearance_csc_others)

                        @if($get_clearance_csc_others->cleared == '0')

                            <label>We hereby that this employee is cleared </label> <input type="checkbox" class="ml-1" style="margin-bottom: -7px">
                            <label>/ not cleared</label> <input type="checkbox" checked class="ml-1" style="margin-bottom: -7px">
                            <label>of work-related accountabilities from this Unit/Office/Dept.</label>

                        @elseif($get_clearance_csc_others->cleared == '1')

                            <label>We hereby that this employee is cleared </label> <input type="checkbox" checked class="ml-1" style="margin-bottom: -7px">
                            <label>/ not cleared</label> <input type="checkbox" class="ml-1" style="margin-bottom: -7px">
                            <label>of work-related accountabilities from this Unit/Office/Dept.</label>

                        @else
                            <label>We hereby that this employee is cleared </label> <input type="checkbox" class="ml-1" style="margin-bottom: -7px" id="fil_check" value="Filipino">
                            <label>/ not cleared</label> <input type="checkbox" class="ml-1" style="margin-bottom: -7px" id="fil_check" value="Filipino">
                            <label>of work-related accountabilities from this Unit/Office/Dept.</label>
                        @endif

                    @else
                        <label>We hereby that this employee is cleared </label> <input type="checkbox" class="ml-1" style="margin-bottom: -7px" id="fil_check" value="Filipino">
                        <label>/ not cleared</label> <input type="checkbox" class="ml-1" style="margin-bottom: -7px" id="fil_check" value="Filipino">
                        <label>of work-related accountabilities from this Unit/Office/Dept.</label>
                    @endif

                </div>
            </td>
        </tr>
        <tr>
            <td width="50%" class="border-left-bold border-bottom-bold">

                @if($get_clearance_csc_others)
                    @if($get_clearance_csc_others->get_Immediate_Head)
                        <div class="text-center px-1 mt-2"><label class="arial font-normal text-11px"><span class="underlined">{{ $get_clearance_csc_others->get_Immediate_Head->firstname.' '.substr($get_clearance_csc_others->get_Immediate_Head->mi, 0, 1).'. '.$get_clearance_csc_others->get_Immediate_Head->lastname }}</span></label></div>
                        <div class="text-center px-1"><label class="arial font-normal text-11px">Immediate Supervisor</label></div>
                    @else
                    @endif
                @else
                    <div class="text-center px-1 mt-2"><label class="arial font-normal text-11px">______________________________________</label></div>
                    <div class="text-center px-1"><label class="arial font-normal text-11px">Immediate Supervisor</label></div>
                @endif
            </td>
            <td width="50%" class="border-right-bold border-bottom-bold">
                <div class="text-center px-1 mt-2"><label class="arial font-bold text-11px">{{ $agency_head_full_name }}</label></div>
                <div class="text-center px-1"><label class="arial font-normal text-11px">Head of Office</label></div>
            </td>
        </tr>
    </table>
    <!-- END: II. CLEARANCE FROM WORK-RELATED ACCOUNTABILITIES -->



    <!-- BEGIN: III. CLEARANCE FROM MONEY AND PROPERTY ACCOUNTABILITIES -->
    <table class="my-table">
        <tr>
            <td width="26px" class="border-left-bold border-right border-bottom">
                <div class="text-left px-1"><label class="arial font-bold text-11px">III</label></div>
            </td>
            <td class="border-right-bold border-bottom">
                <div class="text-left px-1"><label class="arial font-bold text-11px">CLEARANCE FROM MONEY AND PROPERTY ACCOUNTABILITIES</label></div>
            </td>
        </tr>
    </table>


    <!-- BEGIN: Administrative Services -->
        <table class="my-table">

            <thead>
            <tr>
                <td width="5%" height="30px" class="border-left-bold ">
                    <div class="text-right px-1"><label class="arial font-normal text-11px"></label></div>
                </td>

                <td width="35%" height="30px" class=" border-right">
                    <div class="text-left px-1"><label class="arial font-normal text-11px">Name of Unit/Office/Department</label></div>
                </td>
                <td width="10%" height="30px" class=" border-right">
                    <div class="text-center px-1 arial font-normal text-11px mt-1">
                        <label>Cleared</label>
                    </div>
                </td>
                <td width="10%" height="30px" class=" border-right">
                    <div class="text-center px-1 arial font-normal text-11px mt-1">
                        <label>Not Cleared</label>
                    </div>
                </td>
                <td width="30%" height="30px" class=" border-right">
                    <div class="text-center px-1 arial font-normal text-11px mt-1">
                        <label>Name of Clearing Officer/Official</label>
                    </div>
                </td>
                <td width="10%" height="30px" class="border-right-bold">
                    <div class="text-center px-1 arial font-normal text-11px mt-1">
                        <label>Signature</label>
                    </div>
                </td>
            </tr>
            </thead>

            <tbody>
                {!! $III_CLEARANCE_FROM_MONEY_AND_PROPERTY_ACCOUNTABILITIES !!}
            </tbody>

        </table>


    <!-- BEGIN: IV. CERTIFICATION OF NO PENDING ADMINISTRATIVE CASE: -->
    <table class="my-table">
        {!! $IV_CLEARANCE_FROM_MONEY_AND_PROPERTY_ACCOUNTABILITIES_TITLE !!}
    </table>

    <table class="my-table">
        <tbody>
        {!! $IV_CLEARANCE_FROM_MONEY_AND_PROPERTY_ACCOUNTABILITIES !!}
        </tbody>

    </table>
    <!-- END: IV. CERTIFICATION OF NO PENDING ADMINISTRATIVE CASE: -->


    <!-- BEGIN: PAGE BREAK -->
    <div class="page_break"></div>
    <!-- END:   PAGE BREAK -->

    <!-- BEGIN: IV. CERTIFICATION   -->
    <table class="my-table">
        <tr>
            <td width="26px" class="border-left-bold border-top-bold border-right border-bottom">
                <div class="text-left px-1"><label class="arial font-bold text-11px">V</label></div>
            </td>
            <td class="border-top-bold border-right-bold border-bottom">
                <div class="text-left px-1"><label class="arial font-bold text-11px">CERTIFICATION</label></div>
            </td>
        </tr>
    </table>
    <table class="my-table">

        <tr>
            <td style="padding-left: 30px" class="border-left-bold border-right-bold">
                <div class="text-left px-1 mt-2">
                    <label class="arial font-normal text-11px">
                        I hereby that this employee is cleared of work-related, money and property accountabilities from this agency. This
                    </label>
                </div>
                <div class="text-left px-1">
                    <label class="arial font-normal text-11px">
                        certification includes no pending administrative case from this agency.
                    </label>
                </div>
            </td>
        </tr>
        <tr>
            <td class="border-left-bold border-right-bold border-bottom-bold">
                <div class="text-center px-1 mt-4"><img src="{{ $agency_head_signature }}" style="width: 150px; height: 75px"></div>
                <div style="margin-top: -40px" class="text-center px-1"><label class="arial font-bold text-11px">{{ $agency_head_full_name }}</label></div>
                <div class="text-center px-1 mb-2"><label class="arial font-normal text-11px">Signature over Printed Name of Agency Head</label></div>
            </td>
        </tr>
    </table>
    <!-- END: IV. CERTIFICATION   -->

</main>

</body>
</html>
