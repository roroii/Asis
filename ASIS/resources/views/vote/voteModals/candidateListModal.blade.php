<!-- BEGIN: Modal Content -->
<div id="applicant_list_modal" class="modal modal_z_index_edited" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content"><a class="cancel-apply" data-tw-dismiss="modal" href="javascript:;"><i class="fa-sharp fa-light fa-circle-xmark w-5 h-5 text-slate-400 zoom-in"></i> </a>
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 id="applicantList_modal_Header" class="font-bold text-base mr-auto">Vote Lang</h2>
 
            </div> <!-- END: Modal Header -->
 
            <form id="applicantList_modal_form" enctype="multipart/form-data">
 
                @csrf
 
                <input type="hidden" id="type-id" name="type_id">

                 <!-- BEGIN: Modal Body -->
                     <div class="modal-body">
                        <div id="candidate_list_div" class="col-span-12 lg:col-span-7 2xl:col-span-8">
                            {{-- <div class="box p-5 rounded-md">
                                
                                <div class="div_lang">
                                    

                                </div>
                               
                                <div class="overflow-auto lg:overflow-visible -mt-3">
                                    <table class="table table-striped">
                                        <thead>
                                           
                                                <th class="whitespace-nowrap !py-5">Candidate Name</th>
                                                <th class="whitespace-nowrap text-right">Position Applied</th>
                                                <th class="whitespace-nowrap text-right">Status</th>
                                            
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="!py-4">
                                                    <div class="flex items-center">
                                                        <div class="w-10 h-10 image-fit zoom-in">
                                                            <img alt="Midone - HTML Admin Template" class="rounded-lg border-2 border-white shadow-md tooltip" src="{{ asset('dist/images/preview-9.jpg') }}" title="Uploaded at 5 June 2020">
                                                        </div>
                                                        <a href="" class="font-medium whitespace-nowrap ml-4">Nike Tanjun</a> 
                                                    </div>
                                                </td>
                                                <td class="text-right">$43,000.00</td>
                                                <td class="text-right">2</td>
                                                
                                            </tr>
                                           
                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div> --}}
                        </div>
                     </div>
                 <!-- END: Modal Body -->
 
                <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer form-control applying_modalFooter w-full">
                        <button id="cancel-apply" type="button" href="javascript:;" class="btn btn-secondary mr-1 cancel-apply" data-tw-dismiss="modal">Close</button>
                        
                    </div>
                <!-- END: Modal Footer -->
 
            </form>
 
        </div>
    </div>
 </div>  <!-- END: Modal Content -->
 
 
 