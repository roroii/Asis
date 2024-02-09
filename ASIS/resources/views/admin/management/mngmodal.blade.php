{{--modal for create new sched--}}
<div id="update_rc_modal_members_head" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">
                    Update Responsibility Center
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
                    <div hidden class="col-span-12 sm:col-span-6">
                        <label for="modal-form-1" class="form-label">Head</label>
                        <input hidden id="rc_id_modal" name="rc_id_modal" type="text" class="form-control" placeholder="rc id" >
                        {{--                        <select id="rc_modal_head" data-placeholder="Select User" class=" w-full">--}}
                        {{--                            <option value="">Select Head</option>--}}
                        {{--                            @forelse (loaduser('') as $users)--}}
                        {{--                                @if ($users->getUserinfo)--}}
                        {{--                                    <option value="{{ $users->employee }}">{{ $users->getUserinfo->firstname }} {{ $users->getUserinfo->lastname }}</option>--}}
                        {{--                                @else--}}
                        {{--                                @endif--}}
                        {{--                            @empty--}}
                        {{--                            @endforelse--}}
                        {{--                        </select>--}}

                    </div>

                    <div class="col-span-12 sm:col-span-12">

                        <div style="position: relative">
                            <select class="select2-multiple w-full rc_modal_members" multiple="multiple" id="rc_modal_members">
                                @forelse (loaduser('') as $users)
                                    @if ($users->getUserinfo)
                                        <option value="{{ $users->employee }}">{{ $users->getUserinfo->firstname }} {{ $users->getUserinfo->lastname }}</option>
                                    @else
                                    @endif
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <div class="overflow-x-auto scrollbar-hidden pb-10">
                            <table id="dt__rc_members" class="table table-report  table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center whitespace-nowrap ">#ID</th>
                                    <th class="text-center whitespace-nowrap ">Name</th>
                                    <th class="text-center whitespace-nowrap ">Action</th>
                                </tr>
                                </thead>
                                <tbody>


                                </tbody>
                            </table>
                        </div>

                    </div>

                </div> <!-- END: Modal Body -->
                <!-- END: Modal Body -->
                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button id="btn_cancel_rc_update" type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                    <button id="save_rc_head_members" type="button" class="btn btn-primary w-20">Save <i data-lucide="save" style="color: rgb(255, 255, 255)" class="w-4 h-4 text-slate-500 ml-auto"></i></button>
                </div>
            </form>
            <!-- END: Modal Footer -->
        </div>
    </div>
</div>

{{--modal for create new group--}}
<div id="create_group_modal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-s">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">
                    Create Group
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
                        <label for="number" class="form-label">Title</label>
                        <input id="modal_group_title" name="modal_group_title" type="text" class="form-control" placeholder="Title" required>
                    </div>

                    <div class="col-span-12 sm:col-span-12">
                        <label for="modal-form-3" class="form-label">Description</label>
                        <textarea class="form-control" name="modal_group_desc" id="modal_group_desc"rows="3" placeholder="Description" ></textarea>
                    </div>

                    <div class="col-span-12 sm:col-span-12">
                        <label for="modal-form-2" class="form-label">Add Members</label>
                        <select id="group_modal_member_list" data-placeholder="Select Users" class="tom-select w-full" multiple>
                            <option value="">Select Members</option>
                            @forelse (loaduser('') as $users)

                                @if ($users->getUserinfo)
                                    <option value="{{ $users->employee }}">{{ $users->getUserinfo->firstname }} {{ $users->getUserinfo->lastname }}</option>
                                @else

                                @endif

                            @empty

                            @endforelse
                        </select>
                    </div>

                </div> <!-- END: Modal Body -->
                <!-- END: Modal Body -->
                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                    <a id="create_group_modal_save" href="javascript:;" class="btn btn-primary w-20">Save <i data-lucide="save" style="color: rgb(255, 255, 255)" class="w-4 h-4 text-slate-500 ml-auto"></i></a>
                </div>
            </form>
            <!-- END: Modal Footer -->
        </div>
    </div>
</div>

{{--modal for create new update Group--}}
<div id="update_group_modal_members_head" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">
                    Update Group
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
                    <div class="col-span-12 sm:col-span-6">
                        <label for="modal-form-1" class="form-label">Head</label>
                        <input hidden id="group_id_modal" name="group_id_modal" type="text" class="form-control" placeholder="group id" >
                        <div style="position: relative">
                            <select class="select2-multiple w-full update_group_modal_head" id="update_group_modal_head">
                                <option></option>
                                @forelse (loaduser('') as $users)
                                    @if ($users->getUserinfo)
                                        <option value="{{ $users->employee }}">{{ $users->getUserinfo->firstname }} {{ $users->getUserinfo->lastname }}</option>
                                    @else
                                    @endif
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>

                    <div class="col-span-12 sm:col-span-6">
                        <label for="modal-form-2" class="form-label">Add Members</label>
                        <div style="position: relative">
                            <select class="select2-multiple w-full" multiple="multiple" id="update_group_modal_member_list">
                                @forelse (loaduser('') as $users)
                                    @if ($users->getUserinfo)
                                        <option value="{{ $users->employee }}">{{ $users->getUserinfo->firstname }} {{ $users->getUserinfo->lastname }}</option>
                                    @else
                                    @endif
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>

                    <div class="col-span-12 sm:col-span-6">
                        <label for="modal-form-1" class="form-label">Group Name</label>
                        <input id="group_title" name="group_title" type="text" class="form-control" placeholder="Title" required>
                    </div>

                    <div class="col-span-12 sm:col-span-6">
                        <label for="modal-form-2" class="form-label">Description</label>
                        <textarea class="form-control" name="group_desc" id="group_desc"rows="3" placeholder="Description" ></textarea>
                    </div>
                    <div class="col-span-12 sm:col-span-12">
                        <div class="overflow-x-auto scrollbar-hidden pb-10">
                            <table id="dt__group_members" class="table table-report  table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center whitespace-nowrap ">#ID</th>
                                    <th class="text-center whitespace-nowrap ">Name</th>
                                    <th class="text-center whitespace-nowrap ">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                    </div>

                </div> <!-- END: Modal Body -->
                <!-- END: Modal Body -->
                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button id="btn_update_group_cancel" type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                    <a id="group_modal_table_updated_group" href="javascript:;" class="btn btn-primary w-20">Save <i data-lucide="save" style="color: rgb(255, 255, 255)" class="w-4 h-4 text-slate-500 ml-auto"></i></a>
                </div>
            </form>
            <!-- END: Modal Footer -->
        </div>
    </div>
</div>

{{--modal for user priv--}}
<div id="user_priv_modal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">
                    Update Privileges
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
                    <input hidden id="user_priv_id_modal" name="user_priv_id_modal" type="text" class="form-control" placeholder="user id" >
                    <div class="col-span-12 sm:col-span-12">
                        <div class="overflow-x-auto">
                            <table id="dt__user_priv" class="table table-report  table-hover">
                                <thead>
                                <tr>
                                    <th>Link Permission</th>
                                    <th class="text-center"><div class="flex"><input class="form-check-input selectall_Read w-5 h-5" id="selectall_Read" type="checkbox" value="" > <label for="selectall_Read">Read</label></div></th>
                                    <th class="text-center"><div class="flex"><input class="form-check-input selectall_Write w-5 h-5" id="selectall_Write" type="checkbox" value="" ><label for="selectall_Write">Write</label></div></th>
                                    <th class="text-center"><div class="flex"><input class="form-check-input selectall_Create w-5 h-5" id="selectall_Create" type="checkbox" value="" ><label for="selectall_Create">Create</label></div></th>
                                    <th class="text-center"><div class="flex"><input class="form-check-input selectall_Delete w-5 h-5" id="selectall_Delete" type="checkbox" value="" ><label for="selectall_Delete">Delete</label></div></th>
                                    <th class="text-center"><div class="flex"><input class="form-check-input selectall_Import w-5 h-5" id="selectall_Import" type="checkbox" value="" ><label for="selectall_Import">Import</label></div></th>
                                    <th class="text-center"><div class="flex"><input class="form-check-input selectall_Export w-5 h-5" id="selectall_Export" type="checkbox" value="" ><label for="selectall_Export">Export</label></div></th>
                                    <th class="text-center"><div class="flex"><input class="form-check-input selectall_Print w-5 h-5" id="selectall_Print" type="checkbox" value="" ><label for="selectall_Print">Print</label></div></th>
                                </tr>
                                </thead>
                                <tbody>



                                </tbody>
                            </table>
                        </div>
                    </div>

                </div> <!-- END: Modal Body -->
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

{{--modal for user priv--}}
<div id="user_priv_modal_reload_priv" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">
                    Update Privileges Modules
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
                    <input hidden id="user_priv_id_modal_reload_priv" name="user_priv_id_modal_reload_priv" type="text" class="form-control" placeholder="" >
                    <div class="col-span-12 sm:col-span-12">
                        <div class="table-responsive">
                            <table id="dt__user_priv_modal_reload_priv" class="table table-report  table-hover">
                                <thead>
                                <tr>
                                    <th>Links</th>
                                    <th class="text-center">Include</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse (getModule() as $module)
                                    <tr>
                                        <td class="fw-bold">{{ $module->link }}</td>
                                        <td class="text-center">
                                            <input class="form-check-input cb_important w-5 h-5" name="cb_important" type="checkbox" value="{{ $module->id }}" id="cb_important" {{ ( $module->important == 1 ? ' checked' : '') }}>
                                        </td>

                                    </tr>
                                @empty

                                @endforelse


                                </tbody>
                            </table>
                        </div>
                    </div>

                </div> <!-- END: Modal Body -->
                <!-- END: Modal Body -->
                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                    <a id="update_user_priv_modal_save_reload_priv" href="javascript:;" class="btn btn-primary w-20">Save <i data-lucide="save" style="color: rgb(255, 255, 255)" class="w-4 h-4 text-slate-500 ml-auto"></i></a>
                </div>
            </form>
            <!-- END: Modal Footer -->
        </div>
    </div>
</div>

{{--modal for link list--}}
<div id="update_link_list_modal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">
                    Update Link List
                </h2>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <form class="modal-body" method="POST"  enctype="multipart/form-data">
                @csrf

                <input id="up_link_id" name="up_link_id" class="hidden">
                <div class="mb-2">
                    <label for="modal-form-1" class="form-label">Link</label>
                    <input disabled id="up_link" name="up_link" type="text" class="form-control">
                </div>
                <div class="mb-2">
                    <label for="modal-form-1" class="form-label">Module Name</label>
                    <input id="up_module_name" name="up_module_name" type="text" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-auto mr-1">Cancel</button>
                    <a id="update_links" href="javascript:;" class="btn btn-primary w-20">Update
                        <i data-lucide="save" style="color: rgb(255, 255, 255)" class="w-4 h-4 text-slate-500 ml-auto"></i></a>
                </div>
            </form>
            <!-- END: Modal Footer -->
        </div>
    </div>
</div>
