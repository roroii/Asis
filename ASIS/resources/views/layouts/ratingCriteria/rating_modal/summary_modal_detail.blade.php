 <!-- BEGIN: Modal Content -->
 <div id="SummaryDetail_Modal" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content"><a data-tw-dismiss="modal" href="javascript:;"><i class="fa-sharp fa-light fa-circle-xmark w-5 h-5 text-slate-400 zoom-in"></i> </a>
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-bold text-base mr-auto">Applicant Details</h2>
                <div class="dropdown sm:hidden"> <a type="button" class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i> </a>

                </div>
            </div> <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body p-2 text-center">
                {{-- <div class="grid grid-cols-12 gap-6">
                   
                    <div class="intro-y col-span-12 lg:col-span-4 xl:col-span-3">
                        <div class="box mt-5 ">
                            <div class="px-4 pb-3 pt-5 rounded-md overflow-y-auto font-medium">
                                <h1>Categories</h1>
                            </div>
            
                            <div class="border-t border-black/10 dark:border-darkmode-400 px-4 pb-3 pt-5 overflow-y-auto h-half-screen">
                                <a id="t_part" href="javascript:;" class="flex items-center px-3 py-2 rounded-md"> <i class="fa-sharp fa-solid fa-circles-overlap"></i> Test Part </a>
                                <a id="testQ_type" href="javascript:;" class="flex items-center px-3 py-2 mt-2 rounded-md"> <i class="fa-sharp fa-regular fa-text-width"></i> Test Question Types </a>
                                <a id="t_question" href="javascript:;" class="flex items-center px-3 py-2 mt-2 rounded-md"> <i class="fa-sharp fa-light fa-ballot-check"></i> Test Question </a>
                                <a id="t_choice" href="javascript:;" class="flex items-center px-3 py-2 mt-2 rounded-md"> <i class="fa-solid fa-camera-web"></i> Test Choices </a>
                                
                            </div>
                        </div>
            
                    </div>

                    <div class="intro-y col-span-12 lg:col-span-8 xl:col-span-9">
                        <div class="intro-y box lg:mt-5">
            
                            <div id="test_div" class="accordion accordion-boxed p-5">
                                
                            </div>
                        </div>
            
                    </div>
                </div> --}}

                    <div class="px-2">
                        <div id="summary_detail_div" class="overflow-x-auto">

                        </div>
                    </div>
        </div>


         <!-- BEGIN: Modal Footer -->
         <div class="modal-footer">
            <button id="cnl_area_rating" type="button" href="javascript:;" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
        </div>
        <!-- END: Modal Footer -->
    </div>
    </div>
</div>  <!-- END: Modal Content -->


