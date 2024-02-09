<div id="add_child_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Add Child</h2>
            </div>

            <div class="modal-body p-5">
                <div class="grid grid-cols-12 gap-6">
                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="modal-form-2" class="form-label">Name of Children</label>
                        <input id="input_child_name" type="text" class="form-control" placeholder="Name of Children">
                    </div>
                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="modal-form-2" class="form-label">Date of Birth</label>
                        <div class="relative w-auto mx-auto">
                            <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400"><i data-lucide="calendar" class="w-4 h-4"></i></div>
                            <input id="input_date_of_birth" type="text" class="form-control pl-12 ">
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-2 mb-2"> Cancel</button>
                <button id="save_children" type="button" class="btn btn-primary w-25 "> Add </button>

            </div>
        </div>
    </div>
</div>
