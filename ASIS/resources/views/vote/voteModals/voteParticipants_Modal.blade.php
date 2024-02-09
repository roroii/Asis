 <!-- BEGIN: Modal Content -->
 <div id="voteApplicant_modal" class="modal modal_z_index_edited" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content"><a data-tw-dismiss="modal" href="javascript:;"><i class="fa-sharp fa-light fa-circle-xmark w-5 h-5 text-danger zoom-in"></i> </a>
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 id="vote-header_title" class="font-bold text-base mr-auto">Assign Position</h2>

            </div> <!-- END: Modal Header -->

            <form id="voteApplicant_modal_form" enctype="multipart/form-data">

                @csrf

                <!-- BEGIN: Modal Body -->
            <div class="modal-body">
                <div class="grid grid-cols-12 gap-12">
                    <input id="voteTypeID" value="0" name="voteTypeID" type="hidden">

                    <div class="intro-y col-span-12 2xl:col-span-12">
                        <div id="openType_positio_div" class="intro-y box p-5 mt-5 overflow-y-auto h-full-screen">
                            
                        </div>

                         <!-- Selected Candidates Section -->
                         <div id="selectedCandidates" class="mt-4 hidden">
                            <h3 class="font-bold text-lg">Selected Candidates:</h3>
                            <ul id="selectedCandidatesList" class="list-disc ml-6 text-right">
                                <!-- Selected candidates will be displayed here as list items -->
                            </ul>
                        </div>
                        <!-- End of Selected Candidates Section -->
                    </div>

                </div>
            </div>


            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" href="javascript:;" class="btn btn-primary w-full mr-1 hidden voteApplicant_modal_cancelBtn" data-tw-dismiss="modal">OK</button>
                {{-- <button type="submit" href="javascript:;" class="btn btn-primary w-20 mr-1 voteApplicant_modal_saveBtn">Vote</button> --}}
                
                {{-- <button type="submit" href="javascript:;" class="btn btn-primary w-full voteApplicant_modal_saveBtn"> <i class="fas fa-vote-yea text-white mr-2"></i> Vote </button> --}}
                <button type="submit" href="javascript:;" class="btn btn-primary w-full voteApplicant_modal_saveBtn"> <i class="fas fa-vote-yea text-white mr-2"></i> Vote </button>
            </div>
            <!-- END: Modal Footer -->

            </form>

        </div>
    </div>
</div>  <!-- END: Modal Content -->


