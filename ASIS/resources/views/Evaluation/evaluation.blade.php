@extends('layouts.app')

@section('content')

<!-- BEGIN: Content -->
<div class="content">
    <div class="intro-y grid grid-cols-12 gap-5 mt-5">
        <!-- BEGIN: Left -->      
        <div class="intro-y box col-span-12 lg:col-span-8 p-3">
            <style>
                .select_ins select {
                    border: none;
                    background: none;
                    width: 100%;
                    border-bottom: 1px solid black;
                }
                .select_ins select:focus {
                    outline: none;
                    border: none;
                    background: none;
                }
            </style>
            <img src="uploads/settings/DSSC/Header - Landscape.png" alt="">
            @if ( auth()->user()->role === 'Admin')
                <div class="flex mt-3 mb-4">
                    <button class="btn w-44 border-slate-300 dark:border-darkmode-400 text-slate-500" id="create_ques_btn" data-tw-toggle="modal" data-tw-target="#modal_to_create_ques">Create Questionnaire</button>
                    <button class="btn btn-primary w-32 shadow-md ml-auto" id="modal_to_change_ques_id" data-tw-toggle="modal" data-tw-target="#modal_to_change_ques"> <i class="fa-solid fa-arrows-rotate mr-3"></i> Change</button>
                </div>
                <hr>
            @endif
            <form action="{{ route('save_evaluation') }}" method="POST" id="form_ques">
                @csrf
                <div style="padding: 10px 40px; margin-bottom: 30px;" id="ques_tab_content">
                </div>
            </form>
            <img src="uploads/settings/DSSC/Footer - Landscape.png" alt="">
            {{-- =========== End : Questionnaire Display =========== --}}



            {{-- =========== Begin : Questionnaire Modals =========== --}}
            <div id="modal_to_create_ques" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- BEGIN: Modal Header -->
                        <div class="modal-header">
                            <h2 class="font-medium text-base mr-auto">Create Questionnaire</h2>
                        </div> 
                        <!-- END: Modal Header -->
                        <!-- BEGIN: Modal Body -->
                        <div class="modal-body">
                            <div class="scale_name">
                                <label for="ques_name_val" class="form-label">Questionnaire Name</label> 
                                <input type="text" id="ques_name_val" class="form-control" placeholder="Input text">
                            </div>
                            <div class="scale_name mt-3">
                                <label for="ques_title_val" class="form-label">Title</label> 
                                <input id="ques_title_val" type="text" class="form-control" placeholder="Input text">
                            </div>
                            <div class="scale_name mt-2">
                                <label for="ques_sub_val" class="form-label">Subtitle</label> 
                                <input id="ques_sub_val" type="text" class="form-control" placeholder="Input text">
                            </div>
                            <div class="scale_name mt-2">
                                <label for="ques_direc_val" class="form-label">Direction</label> 
                                <input id="ques_direc_val" type="text" class="form-control" placeholder="Input text">
                            </div>
                            <hr class="mt-3">
                            <div class="scale_name mt-3">
                                <label class="form-label">Questions / Title</label> 
                                <select class="form-select" id="ques_type">
                                    <option selected disabled value="">Select type</option>
                                    <option value="t">Title</option>
                                    <option value="q">Question</option>
                                </select>
                                <input id="ques_ques" type="text" class="form-control mt-1" placeholder="Input text">
                            </div>
                            <div class="mt-4 flex justify-end mb-2 items-center">
                                <div class="mr-4" id="loading_ques"></div>
                                <button class="btn btn-outline-secondary mr-2" data-tw-toggle="modal" data-tw-target="#modal_sure_clear">Clear</button>
                                <button id="add_ques_btn" class="btn btn-outline-primary">Add</button>
                            </div>
                            <div class="w-full flex justify-center border-t border-slate-200/60 dark:border-darkmode-400 mt-4">
                                <div class="bg-white dark:bg-darkmode-600 px-5 -mt-3 text-slate-500">Display</div>
                            </div>
                            <div class="overflow-x-auto mt-5">
                                <table class="table table-bordered table-hover">
                                    <tbody id="tbody_for_ques">
                                    </tbody>
                                </table>
                            </div>
                        </div> 
                        <!-- END: Modal Body -->
                        <!-- BEGIN: Modal Footer -->
                        <div class="modal-footer"> 
                            <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20">Close</button> 
                            <button type="button" id="save_ques_ques" class="btn btn-primary w-20">Save</button>
                        </div> 
                        <!-- END: Modal Footer -->
                    </div>
                </div>
            </div>
            <div id="modal_to_change_ques" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- BEGIN: Modal Header -->
                        <div class="modal-header">
                            <h2 class="font-medium text-base mr-auto">Change Questionnaire</h2>
                        </div> 
                        <!-- END: Modal Header -->
                        <!-- BEGIN: Modal Body -->
                        <div class="modal-body">
                            <div class="scale_name mb-2">
                                <label for="select_ques_name" class="form-label">Questionnaire</label> 
                                <select class="form-select" id="select_ques_name">
                                </select>
                                <label for="select_scale_name" class="form-label mt-4">Rating Scale</label> 
                                <select class="form-select" id="select_scale_name">
                                </select>
                                <div class="grid grid-cols-12 gap-4 gap-y-3 mt-3">
                                    <div class="col-span-12 sm:col-span-6"> 
                                        <label for="ques_date_from" class="form-label">From</label> 
                                        <input id="ques_date_from" type="date" class="form-control"> 
                                    </div>
                                    <div class="col-span-12 sm:col-span-6"> 
                                        <label for="ques_date_to" class="form-label">To</label>
                                        <input id="ques_date_to" type="date" class="form-control"> 
                                    </div>
                                </div>
                                <div class="grid grid-cols-12 gap-4 gap-y-3 mt-3">
                                    <div class="col-span-12 sm:col-span-6"> 
                                        <label for="sy_select" class="form-label">School Year</label> 
                                        <select class="form-select" id="sy_select">
                                            <option value="" disabled selected>Please select</option>
                                            @foreach (load_school_year() as $user)
                                                <option value="{{ $user->sy }}">{{ $user->sy }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-span-12 sm:col-span-6"> 
                                        <label for="sem_select" class="form-label">Semester</label>
                                        <select class="form-select" id="sem_select">
                                            <option value="" disabled selected>Please select</option>
                                            <option>1</option>
                                            <option>2</option>
                                            <option>S</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <!-- END: Modal Body -->
                        <!-- BEGIN: Modal Footer -->
                        <div class="modal-footer"> 
                            <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20">Close</button> 
                            <button type="button" id="change_ques_btn_change" class="btn btn-primary w-20">Change</button>
                        </div> 
                        <!-- END: Modal Footer -->
                    </div>
                </div>
            </div>
            <div id="dlt_notif_ques" class="modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="p-5 text-center"> <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                                <div class="text-3xl mt-5">Are you sure?</div>
                                <input type="text" id="dlt_this_ques" hidden>
                                <div class="text-slate-500 mt-2">Do you really want to delete these records? <br>This process cannot be undone.</div>
                            </div>
                            <div class="px-5 pb-8 text-center"> 
                                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button> 
                                <button type="button" id="dlt_btn_ques" class="btn btn-danger w-24">Delete</button> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="modal_sure_clear" class="modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="p-5 text-center"> <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                                <div class="text-3xl mt-5">Are you sure?</div>
                                <div class="text-slate-500 mt-2">Do you really want to clear these records? <br>This process cannot be undone.</div>
                            </div>
                            <div class="px-5 pb-8 text-center"> 
                                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button> 
                                <button type="button" class="btn btn-secondary w-24" id="clear_ques_btn">Clear</button> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- =========== End : Questionnaire Modals =========== --}}

        </div>
        <!-- END: Left -->
        <!-- BEGIN: Right -->
        <div class="col-span-12 lg:col-span-4">
            <div class="tab-content">
                <div id="ticket" class="tab-pane active" role="tabpanel" aria-labelledby="ticket-tab">
                    <div class="box relative right_eval">
                        <div class="font-bold border-b-2 border-blue-300 text-lg py-4 px-5">
                            Rating Scale:
                        </div>
                        <div class="overflow-x-auto p-3">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="whitespace-nowrap text-center">Numerical <br> Rating</th>
                                        <th class="whitespace-nowrap text-center">Descriptive <br> Rating</th>
                                        <th class="whitespace-nowrap text-center">Qualitative <br> Description</th>
                                    </tr>
                                </thead>
                                <tbody id="load_actived_scale">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if ( auth()->user()->role === 'Admin')
                        <div class="flex mt-5">
                            <button class="btn w-32 border-slate-300 dark:border-darkmode-400 text-slate-500" id="create_scale_btn" data-tw-toggle="modal" data-tw-target="#modal_to_add_scale">Create Scale</button>
                            {{-- <button class="btn btn-primary w-32 shadow-md ml-auto" id="change_scale_btn" data-tw-toggle="modal" data-tw-target="#modal_to_change_scale"> <i class="fa-solid fa-arrows-rotate mr-3"></i> Change</button> --}}
                        </div>
                    @endif

                    {{-- =========== Begin : Rating Scale Display =========== --}}
                    <div id="modal_to_add_scale" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- BEGIN: Modal Header -->
                                <div class="modal-header">
                                    <h2 class="font-medium text-base mr-auto">Create Rating Scale</h2>
                                </div> 
                                <!-- END: Modal Header -->
                                <!-- BEGIN: Modal Body -->
                                <div class="modal-body">
                                    <div class="scale_name">
                                        <label for="scale_name_val" class="form-label">Scale name</label> 
                                        <input id="scale_name_val" type="text" class="form-control" placeholder="Input text">
                                    </div>
                                    <hr class="mt-3">
                                    <div class="scale_name mt-3">
                                        <label class="form-label">Scale rating</label> 
                                        <input id="numerical_val" type="number" class="form-control mt-1" placeholder="Numerical Rating">
                                        <input id="descriptive_val" type="text" class="form-control mt-1" placeholder="Descriptive Rating">
                                        <input id="qualitative_val" type="text" class="form-control mt-1" placeholder="Qualitative Description">
                                    </div>
                                    <div class="mt-4 flex justify-end mb-2">
                                        <div class="mr-4" id="loading_scale"></div>
                                        <button data-tw-toggle="modal" data-tw-target="#modal_sure_clear_scale" class="btn btn-outline-secondary mr-2">Clear</button>
                                        <button id="add_scale_rating_btn" class="btn btn-outline-primary">Add</button>
                                    </div>
                                    <div class="w-full flex justify-center border-t border-slate-200/60 dark:border-darkmode-400 mt-4">
                                        <div class="bg-white dark:bg-darkmode-600 px-5 -mt-3 text-slate-500">Display</div>
                                    </div>
                                    <div class="overflow-x-auto p-3">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="whitespace-nowrap text-center">Numerical <br> Rating</th>
                                                    <th class="whitespace-nowrap text-center">Descriptive <br> Rating</th>
                                                    <th class="whitespace-nowrap text-center">Qualitative <br> Description</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="modal_tbody_scale">
                                            </tbody>
                                        </table>
                                    </div>
                                </div> 
                                <!-- END: Modal Body -->
                                <!-- BEGIN: Modal Footer -->
                                <div class="modal-footer"> 
                                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20">Close</button> 
                                    <button type="button" id="save_scale_btn" class="btn btn-primary w-20">Save</button>
                                </div> 
                                <!-- END: Modal Footer -->
                            </div>
                        </div>
                    </div>
                    <div id="modal_sure_clear_scale" class="modal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body p-0">
                                    <div class="p-5 text-center"> <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                                        <div class="text-3xl mt-5">Are you sure?</div>
                                        <div class="text-slate-500 mt-2">Do you really want to clear these records? <br>This process cannot be undone.</div>
                                    </div>
                                    <div class="px-5 pb-8 text-center"> 
                                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button> 
                                        <button type="button" class="btn btn-secondary w-24" id="clear_scale_btn">Clear</button> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="modal_dlt_scale" class="modal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body p-0">
                                    <div class="p-5 text-center"> 
                                        <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3 fa-bounce"></i>
                                        <input type="text" id="id_to_dlt" hidden>
                                        <div class="text-3xl mt-5">Are you sure?</div>
                                        <div class="text-slate-500 mt-2">Do you really want to delete these records? <br>This process cannot be undone.</div>
                                    </div>
                                    <div class="px-5 pb-8 text-center"> 
                                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button> 
                                        <button type="button" id="dlt_scale_btn" class="btn btn-danger w-24">Delete</button> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- =========== End : Rating Scale Display =========== --}}
                   
                </div>
            </div>
        </div>
        <!-- END: Right -->
    </div>
</div>
<!-- END: Content -->



@endsection


@section('scripts')
    <script src="{{ asset('/js/evaluation/evaluation.js') }}"></script>
@endsection

