 <!-- BEGIN: Modal Content -->
 <div id="create_reminder" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Event Reminder</h2>
                <i class="fa-regular fa-bell fa-shake fa-xl"></i>
                <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i> </a>
                    <div class="dropdown-menu w-40">
                        <ul class="dropdown-content">
                            <li> <a href="javascript:;" class="dropdown-item"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Download Docs </a> </li>
                        </ul>
                    </div>
                </div>
            </div> <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <form id="reminder_form">
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-12">
                        <label for="modal-form-1" class="form-label font-semibold">Event Title</label>
                        <input id="event_title" type="text" class="form-control" placeholder="Title of the event">
                    </div>
                    <div class="col-span-12 sm:col-span-6"> <label for="modal-form-1" class="form-label font-semibold">Title Icon</label>
                        <div >
                            <select id="title_emoji"  style="width:100%">
                                <option></option>
                                <option value="&#x1F514;">&#x1F514;</option>
                                <option value="&#x1F389;">&#x1F389;</option>
                                <option value="&#128512;">&#128512;</option>
                                <option value="&#128526;">&#128526;</option>
                                <option value="&#129395;">&#129395;</option>
                                <option value="&#128187;">&#128187;</option>
                                <option value="&#128197;">&#128197;</option>
                                <option value="&#128389;">&#128389;</option>
                                <option value="&#128198;">&#128198;</option>
                                <option value="&#128203;">&#128203;</option>
                                <option value="&#128204;">&#128204;</option>
                                <option value="&#128206;">&#128206;</option>
                                <option value="&#128221;">&#128221;</option>
                                <option value="&#128157;">&#128157;</option>
                                <option value="&#128159;">&#128159;</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6"> <label for="modal-form-1" class="form-label font-semibold">Message Icon</label>
                        <div >
                            <select id="message_emoji"  style="width:100%">
                                <option></option>
                                <option value="&#x1F514;">&#x1F514;</option>
                                <option value="&#x1F389;">&#x1F389;</option>
                                <option value="&#128512;">&#128512;</option>
                                <option value="&#128526;">&#128526;</option>
                                <option value="&#129395;">&#129395;</option>
                                <option value="&#128187;">&#128187;</option>
                                <option value="&#128197;">&#128197;</option>
                                <option value="&#128198;">&#128198;</option>
                                <option value="&#128203;">&#128203;</option>
                                <option value="&#128204;">&#128204;</option>
                                <option value="&#128206;">&#128206;</option>
                                <option value="&#128221;">&#128221;</option>
                                <option value="&#128157;">&#128157;</option>
                                <option value="&#128159;">&#128159;</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-span-12 sm:col-span-12"> <label for="modal-form-1" class="form-label font-semibold">Remind to</label>
                        <div >
                            <select id="event_department" class="select2-multiple w-full" multiple="multiple" style="width:100%">
                                    <option value="all">All</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-12">
                        <label for="modal-form-1" class="form-label font-semibold">Event Description</label>
                        <div class="w-full mt-3 xl:mt-0 flex-1">
                            <div id="editor">
                                <div id="chk_editor" class="preview">
                                    <textarea name="content" id="desc" class="desc" placeholder="Enter your content here">
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-12 mt-4 fa-lg text-success">
                        <button id="btn_add_event" type="button" class="btn btn-sm btn-secondary">
                            <i class="fa-solid fa-plus"  class="w-5 h-5"></i>
                        </button>
                    </div>
                    <div class="col-span-12 sm:col-span-12 mt-2">
                        <div>
                            <table id="tb_list_events" class="table w-full overflow-x-auto scrollbar-hidden">
                                <thead>
                                    <th class="text-center whitespace-nowrap" hidden>ID</th>
                                    <th class="text-center whitespace-nowrap" hidden>Group Id</th>
                                    <th class="text-center whitespace-nowrap">Event</th>
                                    <th class="text-center whitespace-nowrap">Description</th>
                                    <th class="text-center whitespace-nowrap" hidden>Title icon</th>
                                    <th class="text-center whitespace-nowrap" hidden>Message icon</th>
                                    <th class="text-center whitespace-nowrap" hidden>Group</th>
                                    <th class="text-center whitespace-nowrap" hidden>CheckEditorData</th>
                                    <th class="text-center whitespace-nowrap">Action</th>
                                </thead>
                            </table>
                            <tbody id="tbdy_list_event" class="tbdy_list_event">
                            </tbody>
                        </div>
                    </div>
                </div>
            </form>
            <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button id="cancel_reminder_modal" type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <button id="btn_saved_event" type="button" class="btn btn-primary w-20">Saved</button>
            </div> <!-- END: Modal Footer -->
        </div>
    </div>
</div> <!-- END: Modal Content -->
