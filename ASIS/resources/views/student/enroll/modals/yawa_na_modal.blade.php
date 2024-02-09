<div id="update_phoneNumber_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto modal_title">Update Phone Number</h2>
            </div>

            <div class="modal-body p-0">

                <div class="p-5 grid grid-cols-12 gap-6">


                    <input id="student_id" value="{{ $studid }}"  class="hidden student_id">

                    <div class="input-form col-span-12 lg:col-span-12">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Phone Number </label>
                        <input id="contact_Number" type="number" class="form-control" placeholder="Phone Number...." maxlength="11">
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <button type="submit" class="btn btn-primary w-20 btn_update_phoneNumber">Update</button>
                {{--                <button id="edit_ld" type="submit" class="btn btn-primary w-20">Update</button>--}}
            </div>
        </div>
    </div>
</div>
