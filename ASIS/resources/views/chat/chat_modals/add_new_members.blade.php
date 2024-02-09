{{--modal for create new conversation--}}
<div id="chat_modal_add_members_conversation" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">
                    Add New Members
                </h2>
                <div class="dropdown sm:hidden">

                </div>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <form method="POST" enctype="multipart/form-data">
                @csrf
            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">


                <div class="col-span-12 sm:col-span-12">
                    <label for="modal-form-4" class="form-label">Person</label>
                    <select id="add_conversation_modal_add_person" name="new_conversation_modal_add_person[]" data-placeholder="Select Profile" class=" w-full form-control"  multiple>
                        @forelse (load_profile('') as $profile)
                            @if ($profile)
                                <option value="{{ $profile->agencyid }}">{{ $profile->firstname }} {{ $profile->lastname }}</option>
                            @else

                            @endif
                        @empty

                        @endforelse
                    </select>
                </div>
            </div>
            <!-- END: Modal Body -->

            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <button id="add_new_members" href="javascript:;" class="btn btn-primary w-20">Save <i data-lucide="save" style="color: rgb(255, 255, 255)" class="w-4 h-4 text-slate-500 ml-auto"></i></button>
            </div>
            </form>
            <!-- END: Modal Footer -->
        </div>
    </div>
</div>
