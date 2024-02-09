{{--modal for user priv--}}
<div id="modal_con_ded_rev_payroll" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">
                    Contribution, Deduction & Revenue
                </h2>
                <div class="dropdown sm:hidden">

                </div>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <form method="POST"  enctype="multipart/form-data">
            @csrf
            <!-- BEGIN: Modal Body -->
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">


                    <div class="col-span-12 sm:col-span-12">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Payment Type</label>
                        <select class="w-full"id="pos_des">



                        </select>
                    </div>

                    <div class="col-span-12 sm:col-span-12">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Employee </label>
                        <select class="w-full"id="pos_des">



                        </select>
                    </div>



                </div>
                <!-- END: Modal Body -->
                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                    <a id="update_user_priv_modal_save" href="javascript:;" class="btn btn-primary w-20">Save <i data-lucide="save" style="color: rgb(255, 255, 255)" class="w-4 h-4 text-slate-500 ml-auto"></i></a>
                </div>
            </form>
            <!-- END: Modal Footer -->
        </div>
    </div>
</div>
