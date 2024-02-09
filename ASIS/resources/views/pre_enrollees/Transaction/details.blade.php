@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('Transaction Details', $decrypted_transactionId) }}
@endsection

@section('content')

    <style>
        @media print {

            body * {
                display: none;
            }
            #contentToPrint {
                display: block !important;

            }
        }

    </style>

    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Transaction Details
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            @if($can_print)
                <a href="/transaction/print/details/{{ $encrypted_transactionId }}" id="btn_print_transaction" target="_blank" class="btn btn-primary shadow-md mr-2">Print</a>
            @endif
        </div>
    </div>

    <!-- BEGIN: DETAILS -->
    <div id="contentToPrint" class="intro-y box overflow-hidden mt-5">

        <!-- BEGIN: HEADER -->
        <div class="px-5 sm:px-16 py-2 sm:py-4">
            <div class="overflow-x-auto">
                <table class="">
                    <tr>
                        <td>
                            <img src = "{{ $header }}" style = "width:100%">
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row pt-6 px-5 sm:px-20 sm:pt-6 lg:pb-20 text-center sm:text-left">
            <div class="font-semibold text-primary text-3xl">{{ $agency_name->value }}</div>
            <div class="mt-20 lg:mt-0 lg:ml-auto lg:text-right">
                <div class="text-xl text-primary font-medium">Davao del Sur State College</div>
                <div class="mt-1">admission@dssc.edu.ph</div>
                <div class="mt-1">Brgy. Matti, Digos City, Davao del Sur</div>
            </div>
        </div>
        <!-- END: HEADER -->


        <!-- BEGIN: APPOINTEE DETAILS -->
        <div class="flex flex-col lg:flex-row border-b px-5 sm:px-20 pt-10 pb-10 sm:pb-20 text-center sm:text-left">
            <div>
                <div class="text-base text-slate-500">Appointee Details</div>
                <div class="text-lg font-medium text-primary mt-2">{{ $client_name }}</div>
                <div class="mt-1">{{ $email }}</div>
                <div class="mt-1">{{ $address }}</div>
            </div>
            <div class="mt-10 lg:mt-0 lg:ml-auto lg:text-right">
                <div class="text-base text-slate-500">Transaction ID</div>
                <div class="text-lg text-primary font-medium mt-2">#{{ $transactions_ID  }}</div>
                <div class="mt-1">{{ $transactions_Date }}</div>
            </div>
        </div>
        <!-- END: APPOINTEE DETAILS -->


        <div class="px-5 sm:px-16 py-10 sm:py-20">
            <div id="table_id" class="overflow-x-auto">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="border-b-2 dark:border-darkmode-400 whitespace-nowrap">DESCRIPTION</th>
                        <th class="border-b-2 dark:border-darkmode-400 whitespace-nowrap">DATE/TIME</th>
                        <th class="border-b-2 dark:border-darkmode-400 whitespace-nowrap">ADDRESS</th>
                        <th class="border-b-2 dark:border-darkmode-400 whitespace-nowrap text-center">STATUS</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="border-b dark:border-darkmode-400">
                            <div class="font-medium whitespace-nowrap">ENTRANCE EXAM FOR THE SCHOOL YEAR: {{ $active_schoolYear->key_value }}, {{ $active_sem }} </div>
                        </td>
                        <td class="border-b dark:border-darkmode-400">
                            <div class="font-medium whitespace-nowrap">{{ $scheduled_date }} - <span class="text-primary">{{ $date_desc }}</span></div>
                        </td>
                        <td class="border-b dark:border-darkmode-400">
                            <div class="font-medium text-slate-500">Davao del Sur State College - Main Campus</div>
                        </td>
                        <td class="border-b dark:border-darkmode-400 text-center">
                            <div class="flex justify-center items-center">
                                <a href="javascript:;" class="box flex items-center px-3 py-2 rounded-md bg-white/10 dark:bg-darkmode-700 font-medium">
                                    <div class="w-2 h-2 bg-{{ $status_class  }} rounded-full mr-3"></div>
                                    <span class="text-{{ $status_class  }}">{{ $status }}</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        @if($is_approved)
            <div class="px-5 sm:px-20 pb-10 sm:pb-20 flex flex-col-reverse sm:flex-row">
                <div class="text-center sm:text-left mt-2 sm:mt-0">
                    <div class="text-base text-slate-500">Approved By:</div>
                    <div class="text-lg text-primary font-medium mt-2">{{ $approved_by }}</div>
                    <div class="mt-1 text-slate-500">{{ $position_designation }}</div>
                    <div class="mt-1">admission@dssc.edu.ph</div>

                    <div class="text-center sm:text-left sm:ml-auto mt-10">
                        <div class="text-base text-slate-500">Important Note:</div>
                        <div class="mt-1 text-slate-400">Please print this Transaction Details, this served as official receipt and submit to the officer in-charge.</div>
                    </div>
                </div>
            </div>

        @endif


        <!-- BEGIN: FOOTER -->
        <div class="px-5 sm:px-16 py-2 sm:py-4">
            <div class="overflow-x-auto">
                <table class="">
                    <tr>
                        <td>
                            <img src = "{{ $footer }}" style = "width:100%">
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- BEGIN: FOOTER -->
    </div>
    <!-- END: DETAILS -->



@endsection
@section('scripts')
{{--    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>--}}
{{--    <script src="{{BASEPATH()}}/js/ASIS_js/Transactions/details.js{{GET_RES_TIMESTAMP()}}"></script>--}}

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

@if($can_print)
    <script>

        // Function to show SweetAlert with the returned message
        function showMessage() {
            Swal.fire({
                title: 'Attention!',
                text: 'Certificate can be printed!',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Print',
                cancelButtonText: 'Close'
            }).then((result) => {
                if (result.isConfirmed) {

                    var newTab = window.open('/transaction/print/details/{{ $encrypted_transactionId }}', '_blank');
                    newTab.focus();
                }
            });
        }

        // Call the function when the document is ready
        $(document).ready(function() {
            showMessage();
        });

    </script>
@endif

@endsection
