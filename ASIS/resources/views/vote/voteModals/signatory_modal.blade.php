{{--modal for create new conversation--}}
<div id="signatory_modal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content"><a id="cancel_signature_modal" data-tw-dismiss="modal" href="javascript:;"><i class="fa-sharp fa-light fa-circle-xmark w-5 h-5 text-danger zoom-in"></i> </a>
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 id="signatory_ModalHeader" class="font-medium text-base mr-auto">
                    
                </h2>
                <div class="dropdown sm:hidden">

                </div>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <form id="signatory_form" enctype="multipart/form-data">
                    @csrf
                <div class="modal-body">

                        {{ csrf_field() }}

                        
                            <input id="typeID" value="0" name="typeID" type="hidden">

                            <div class="mb-5" >

                                <label for="modal-form-6" class="form-label">Select Signatory</label>
                                <select id="signatory_select" name="signatory_select" class="form-control">
                                    <option></option>
                                    @foreach(loadUsers() as $signatory)
                                        <option value="{{ $signatory->studid }}">{{ $signatory->fullname }}</option>
                                    @endforeach
                                    <label id="signatory_selectlbl" for="signatory_selectlbl" class="hidden text-danger">This field is required</label>
                                </select>
                            </div>


                            <div class="mb-3">
                                <label for="typeDescription"> Description</label>
                                <textarea class="form-control" name="sig_description" id="sig_description" rows="3" placeholder="ex. Approved By:"></textarea>
                                <label id="sig_descriptionlbl" for="sig_descriptionlbl" class="hidden text-danger">This field is required</label>
                            </div>
                        
                        <!-- BEGIN: Modal Footer -->
                            <div class="modal-footer">
                                {{-- <button type="button" id="btn_voteType_cancel" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button> --}}
                                <button id="add_voteType_btn" type="submit" class="btn btn-primary w-20">Save</button>
                            </div>
                        <!-- END: Modal Footer -->
                            
                            <div id="signatory_div" class="grid grid-cols-12 gap-6 mt-5">

                                
                            </div>
                    
                </div>
            </form>
            <!-- END: Modal Body -->
        </div>
    </div>
</div>
