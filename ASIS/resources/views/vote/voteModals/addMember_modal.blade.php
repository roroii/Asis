<!-- BEGIN: Modal Content -->
<div id="addMember_modal" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
   <div class="modal-dialog modal-xl">
       <div class="modal-content"><a data-tw-dismiss="modal" href="javascript:;"><i class="fa-sharp fa-light fa-circle-xmark w-5 h-5 text-slate-400 zoom-in"></i> </a>
           <!-- BEGIN: Modal Header -->
           <div class="modal-header">
               <h2 id="member_Header" class="font-bold text-base mr-auto">Be a Candidate</h2>

           </div> <!-- END: Modal Header -->

           <form id="addMember_form" enctype="multipart/form-data">

               @csrf

               <!-- BEGIN: Modal Body -->
           <div class="modal-body">
               <div class="grid grid-cols-12 gap-6">
                <input id="partiesss_id" name="partiesss_id" type="hidden">

                <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">


                    <div class="col-span-12 sm:col-span-12">
                        <div class="col-span-12 sm:col-span-9">
                           <label for="modal-form-6" class="form-label">Add Member</label>
                           <select id="member_select" name="member_select" class="form-control">
                                   <option></option>
                               @foreach(loadUsers() as $member)
                                   <option value="{{ $member->studid }}">{{ $member->fullname }}</option>
                               @endforeach

                           </select>
                           <label id="member_lbl" class="text-danger hidden">This Member is Already Exist</label>
                        </div>


                   </div>


                    <div class="ml-2">
                        <button id="addMember" type="button" class=" btn px-2 box" href="javascript:;" style="border-color: rgb(33, 218, 33)">
                            <span class="w-5 h-5 flex items-center justify-center"> <i class="fas fa-plus text-success w-4 h-4 add_icon"></i> </span>
                        </button>

                    </div>
                </div>







                   <div class="intro-y col-span-12">
                       <div class="box mt-2">
                           <div class="px-4 pt-2 rounded-md overflow-y-auto font-medium">
                               <h1 id="please_select">Member/s</h1>
                           </div>

                           <div class="border-t border-black/10 dark:border-darkmode-400 px-4 pb-3 overflow-y-auto h-half-screen">

                               <table id="members_modal_tbl" class="table table-report cursor-pointer table-hover">
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


           <!-- BEGIN: Modal Footer -->
           <div class="modal-footer applying_modalFooter">
               <button id="cancel-apply" type="button" href="javascript:;" class="btn btn-secondary w-20 mr-1" data-tw-dismiss="modal">Close</button>
               <button id="submit_applyModal_btn" type="submit" href="javascript:;" class="btn btn-primary w-20 mr-1">Apply</button>
           </div>
           <!-- END: Modal Footer -->

           </form>

       </div>
   </div>
</div>  <!-- END: Modal Content -->


