
 <!-- BEGIN: Modal Content -->
 <div id="rated_summary_modal" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
           <form action="{{ route('load_interview_summary_print') }}" method="post" target="_blank" enctype="multipart/form-data">
               @csrf
               <!-- BEGIN: Modal Header -->
               <input id="toggleCheck_value" type="hidden" name="toggleCheck_value">
               <div class="modal-header">
                   <h2 class="font-medium text-base mr-auto">Print Interview Summary</h2>
                   {{-- <button class="btn btn-outline-secondary hidden sm:flex"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Download Docs </button> --}}
                   {{-- <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i> </a>
                       <div class="dropdown-menu w-40">
                           <ul class="dropdown-content">
                               <li> <a href="javascript:;" class="dropdown-item"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Download Docs </a> </li>
                           </ul>
                       </div>
                   </div> --}}
               </div> <!-- END: Modal Header -->
               <!-- BEGIN: Modal Body -->
               <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

               
                <div class="col-span-12 sm:col-span-12">
                    <label for="modal-form-6" class="form-label">Postition</label>
                    <select id="interview_position" name="interview_position" class="form-select">
                        <option value="all">All</option>
                        {{-- {{dd(load_interview_position())}} --}}
                        @forelse (load_interview_position() as $interPosition)
                            <option value="{{ $interPosition->id }}">{{ $interPosition->emp_position }}</option>
                        @empty

                        @endforelse


                    </select>
                 </div>

                   {{-- <input hidden id="modal_summray_type" type="text" class="form-control" name="modal_summray_type" value="vw" placeholder="From"> --}}


                   <div class="col-span-12 sm:col-span-6">
                       <label for="modal-form-1" class="form-label">From</label>
                       <input id="interview_to" type="date" name="interview_from" class="form-control" placeholder="From">
                   </div>
                   <div class="col-span-12 sm:col-span-6">
                       <label for="modal-form-2" class="form-label">To</label>
                       <input id="interview_to" type="date" name="interview_to" class="form-control" placeholder="To">
                   </div>


                   <div class="col-span-12 sm:col-span-12">
                       <label for="modal-form-6" class="form-label">Status</label>
                       <select id="interview_status" name="interview_status" class="form-select">
                           <option value="all">All</option>
                           @forelse (load_interview_status() as $status)
                               <option value="{{ $status->id }}">{{ $status->name }}</option>
                           @empty

                           @endforelse


                       </select>
                    </div>
               </div> <!-- END: Modal Body -->
               <!-- BEGIN: Modal Footer -->
               <div class="modal-footer">
                   <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                   <button id="btn_modal_load_to_print" type="submit" class="btn btn-primary w-20">Generate</button>
               </div> <!-- END: Modal Footer -->
           </div>
           </form>
    </div>
</div> <!-- END: Modal Content -->
