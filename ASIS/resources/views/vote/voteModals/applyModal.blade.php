<!-- BEGIN: Modal Content -->
<div id="apply__modal" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
   <div class="modal-dialog modal-md">
       <div class="modal-content"><a class="cancel-apply" data-tw-dismiss="modal" href="javascript:;"><i class="fa-sharp fa-light fa-circle-xmark w-5 h-5 text-slate-400 zoom-in"></i> </a>
           <!-- BEGIN: Modal Header -->
           <div class="modal-header">
               <h2 id="apply_Header" class="font-bold text-base mr-auto">Be a Candidate</h2>

           </div> <!-- END: Modal Header -->

           <form id="applied_for_position_form" enctype="multipart/form-data">

               @csrf

                <!-- BEGIN: Modal Body -->
                    <div class="modal-body">
                        <div class="grid grid-cols-12 gap-6">
                            <input id="open_typeID" value="0" name="open_typeID" type="hidden">
                            <input id="vote_typeID" value="0" name="vote_typeID" type="hidden">
                            {{--  <input id="group_id" value="0" name="group_id" type="hidden">  --}}

                                <div class="col-span-12 sm:col-span-12">
                                    <div class="col-span-12 sm:col-span-6">
                                    <label for="modal-form-6" class="form-label">Applicant Name</label>
                                    <select id="applicant" name="applicant" class="form-control">
                                            <option></option>
                                        @foreach(loadEnrolled() as $applicant)
                                            <option value="{{ $applicant->studid }}">{{ $applicant->fullname }}</option>
                                        @endforeach

                                    </select>
                                    </div>

                                    <div class="col-span-12 sm:col-span-6 mt-3">
                                        <label for="applicant_parties" class="form-label">Applicant Parties</label>
                                        <select id="applicant_parties" name="applicant_parties" class="form-control">
                                            <option></option>

                                    </select>
                                    </div>
                            </div>

                            <div class="intro-y col-span-12">
                                <div class="box mt-2">
                                    <div class="px-4 pt-5 rounded-md overflow-y-auto font-medium">
                                        <h1 id="please_select">Select Position</h1>
                                    </div>

                                    <div class="border-t border-black/10 dark:border-darkmode-400 px-4 pb-3 overflow-y-auto h-half-screen">

                                        <table id="apply_position_modal_tbl" class="table table-report cursor-pointer table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="whitespace-nowrap"></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>


                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                <!-- END: Modal Body -->

                <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer form-control applying_modalFooter w-full">
                        <button id="cancel-apply" type="button" href="javascript:;" class="btn btn-secondary mr-1 cancel-apply" data-tw-dismiss="modal">Close</button>
                        <button id="submit_applyModal_btn" type="submit" href="javascript:;" class="btn btn-primary mr-1">Apply</button>
                <!-- END: Modal Footer -->

           </form>

       </div>
   </div>
</div>  <!-- END: Modal Content -->


