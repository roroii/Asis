<!DOCTYPE html>

<html lang="en" class="light">
<!-- BEGIN: Head -->
<head>
    @include('_partials.head')

    <style type="text/css">

    </style>

</head>
<!-- END: Head -->
<body class="py-5 att-body" style="">



    <div class="flex mt-[4.7rem] md:mt-0">

    <!-- BEGIN: Content -->
    <div class="content">

        <div class="att-div-main" style="">
            
            <div class="att-div-content-h">

                <div class="att-div-content-1 p-5">
                    
                    <div class="att-title p-3 mt-3 mb-5" style="font-size: 1rem;" id="">Electronic Daily Time Record</div>

                    <div class="att-time p-3 mt-3" id="h-time"></div>

                    <div id="att-btns" class="" style="margin-top: 4rem;">
                        
                        

                    </div>

                </div>

                <div class="mt-7" style="">
                    <img class="att-logo" src="{{SETTING_AGENCY_LOGO()}}" />
                    <img class="att-logo" src="{{SETTING_ICTC_LOGO()}}" />
                </div>

            </div>

        </div>
        
        
        <!-- BEGIN: Modal Content -->
        <div id="mdl__fp_verify" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <!-- BEGIN: Modal Header -->
                    <div class="modal-header">
                        <h2 id="ttl-verify" class="font-bold text-base mr-auto capitalize"></h2>
                        
                    </div> <!-- END: Modal Header -->
                    <!-- BEGIN: Modal Body -->

                    <div class="modal-body px-5 py-10">
                        <div>

                            <div id="fp-verify-features-ui" class="mb-5" align="center">

                            </div>

                            <div id="fp-verify-msg" class="" style="min-width: 20px;" align="center">
                                Put your finger on the fingerprint device.
                            </div>

                        </div>
                    </div>
                        <!-- END: Modal Body -->

                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" href="javascript:;" class="btn btn-outline-secondary w-20 mr-1 b_action" data-type="action" data-target="fp-verify-cancel">Close</button>
                    </div>
                    <!-- END: Modal Footer -->

                </div>
            </div>
        </div>  <!-- END: Modal Content -->

        <!-- BEGIN: Modal Content -->
        <div id="mdl__fp_verify_success" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-body p-0">

                        <input type="hidden" id="del_id" name="id" value="" hidden readonly />

                        <div class="p-5 text-center"> <i class="fas fa-check-double w-16 h-16 text-success mx-auto mt-3"></i>
                            <div id="ttl-verify-success" class="text-3xl mt-5 capitalize">Juan Dela Cruz</div>
                            <div id="lbl-verify-success-details" class="text-slate-500 mt-2 capitalize">Time-In</div>
                        </div>
                        <div class="px-5 pb-8 text-center"> <button type="button" href="javascript:;" class="btn btn-outline-secondary w-24 mr-1 b_action" data-type="action" data-target="fp-verify-success-cancel">Close</button> </div>
                    </div>

                </div>
            </div>
        </div>  <!-- END: Modal Content -->


    </div>
    <!-- END: Content -->
    <div id="loader-wrapper" class="loader-wrapper">
        <span class="loader">
            <div class=" col-span-6 sm:col-span-3 xl:col-span-2 flex flex-col justify-end items-center">
                <i data-loading-icon="oval" class="w-100 w-100" ></i>
            </div>
        </span>
    </div>

    <section id="loading">
        <div id="loading-content"></div>
      </section>
    <!--<div id="__notif_content_src" style="display: none;"></div>-->


</div>


<!-- BEGIN: JS Assets-->

@include('_partials.scripts')




<script>
    var __basepath = "{{url('')}}";
    var timeout = null;

    $(window).on("load",function(){


    $(".loader-wrapper").fadeOut("slow");



    });

    function showLoading() {
      document.querySelector('#loading').classList.add('loading');
      document.querySelector('#loading-content').classList.add('loading-content');
    }

    function hideLoading() {
      document.querySelector('#loading').classList.remove('loading');
      document.querySelector('#loading-content').classList.remove('loading-content');
    }

</script>

    <script src="{{ asset('/js/open_notification.js') }}"></script>
    <script src="{{ asset('/js/logout.js') }}"></script>

    <script src="{{BASEPATH()}}/js/bioengine/bioengine.js{{GET_RES_TIMESTAMP()}}"></script>
    <script src="{{BASEPATH()}}/js/dtr/attendance.js{{GET_RES_TIMESTAMP()}}"></script>

<!-- END: JS Assets-->
</body>
</html>
