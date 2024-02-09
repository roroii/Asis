@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('Document Scanner') }}
@endsection

@section('content')

<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 2xl:col-span-9">
        <div class="grid grid-cols-12 gap-6">


            <!-- BEGIN: Notification -->
            <div class="box col-span-12 mt-6 -mb-6 intro-y p-5 mt-5">

                <input onkeyup="doDelayedSearch(this.value)" autocomplete="off" id="search_scan_document" onfocus="this.value='';" autofocus type="text" class="form-control py-3 px-4 w-full bg-slate-100 border-slate-200/60 pr-10" placeholder="Document Scanner">

             </div>
            <!-- BEGIN: Notification -->


            <!-- BEGIN: General Report -->
            <div class="col-span-12 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Actions
                    </h2>
                    <a href="" class="ml-auto flex items-center text-primary"> <i data-lucide="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Page </a>
                </div>
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div id="div_scanner_receive" class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-lucide="import" class="report-box__icon text-primary"></i>
                                    <div class="ml-auto">
                                        <div class="report-box__indicator bg-primary tooltip cursor-pointer" title="Documents scanner"><i data-lucide="chevron-down" class="w-4 h-4 ml-0.5"></i> </div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">Receive</div>
                                <div class="text-base text-slate-500 mt-1">Click to Receive files.</div>
                            </div>
                        </div>
                    </div>
                    <div id="div_scanner_release" class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-lucide="upload" class="report-box__icon text-pending"></i>
                                    <div class="ml-auto">
                                        <div class="report-box__indicator bg-pending tooltip cursor-pointer" title="Release documents"> <i data-lucide="chevron-up" class="w-4 h-4 ml-0.5"></i> </div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">Release</div>
                                <div class="text-base text-slate-500 mt-1">Click to Release files.</div>
                            </div>
                        </div>
                    </div>
                    <div id="div_scanner_hold" class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-lucide="slash" class="report-box__icon text-warning"></i>
                                    <div class="ml-auto">
                                        <div class="report-box__indicator bg-warning tooltip cursor-pointer" title="Hold documents"> <i data-lucide="chevron-left" class="w-4 h-4 ml-0.5"></i> </div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">Hold</div>
                                <div class="text-base text-slate-500 mt-1">Click to Hold files.</div>
                            </div>
                        </div>
                    </div>
                    <div id="div_scanner_return" class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-lucide="info" class="report-box__icon text-danger"></i>
                                    <div class="ml-auto">
                                        <div class="report-box__indicator bg-danger tooltip cursor-pointer" title="Return documents"><i data-lucide="chevron-right" class="w-4 h-4 ml-0.5"></i> </div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">Return</div>
                                <div class="text-base text-slate-500 mt-1">Click to Return files.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: General Report -->



            <!-- BEGIN: Weekly Best Sellers -->
            <div class="col-span-12 xl:col-span-12 mt-6">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Recent Notifications
                    </h2>
                </div>
                <div class="mt-5">
                    @forelse (loadNotification() as $notification)
                        @if($notification->getDocDetails)
                            <div id="btn_openDocument_Notification"
                                 data-notif-type="{{ $notification->subject }}"
                                 data-notif-id="{{ $notification->id }}"
                                 data-fullname="{{ $notification->getUserDetails->firstname." ".$notification->getUserDetails->lastname }}"
                                 data-notif-title="{{ $notification->getDocDetails->name }}"
                                 data-notif-content="{{ $notification->notif_content }}"
                                 data-date-created="{{ $notification->created_at->diffForHumans() }}"
                                 class="cursor-pointer relative flex items-center mt-5">

                            <div class="items-center w-12 h-12 image-fit">
                                <i class="fa fa-bell rounded-full notification__icon dark:text-slate-500"></i>
                            </div>
                               <div class="ml-2 overflow-hidden">
                                   <div class="font-medium truncate mr-5">{{ $notification->getUserDetails->firstname." ".$notification->getUserDetails->lastname }}</div>
                                   <div class="flex items-center">
                                       <a id="document_id" data-notif-id="{{ $notification->id }}" data-doc-id="{{$notification->getDocDetails->track_number}}" href="javascript:;" class="mr-5">{{ $notification->getDocDetails->name }}</a>
                                       <div class="text-xs text-slate-400 ml-auto whitespace-nowrap">{{ $notification->created_at->diffForHumans() }}</div>
                                   </div>
                                   <div class="w-full truncate text-slate-500 mt-0.5">{{ $notification->notif_content }}</div>
                               </div>
                            </div>
                        @elseif($notification->getGroupDetails)
                            <div id="btn_openGroup_Notification"
                                 data-notif-type="{{ $notification->subject }}"
                                 data-notif-id="{{ $notification->id }}"
                                 data-fullname="{{ $notification->getUserDetails->firstname." ".$notification->getUserDetails->lastname }}"
                                 data-notif-title="{{ $notification->getGroupDetails->name }}"
                                 data-notif-content="{{ $notification->notif_content }}"
                                 data-date-created="{{ $notification->created_at->diffForHumans() }}"
                                 class="cursor-pointer relative flex items-center mt-5">

                                <div class="items-center h-12 image-fit">
                                    <i class="fa fa-bell rounded-full notification__icon dark:text-slate-500"></i>
                                </div>
                                <div class="ml-6 overflow-hidden">
                                    <div class="font-medium truncate mr-5">{{ $notification->getUserDetails->firstname." ".$notification->getUserDetails->lastname }}</div>
                                    <div class="flex items-center">
                                        <a id="group_id" data-grp-id="{{$notification->getGroupDetails->id}}" href="javascript:;" class="mr-5">{{ $notification->getGroupDetails->name }}</a>
                                        <div class="text-xs text-slate-400 ml-auto whitespace-nowrap">{{ $notification->created_at->diffForHumans() }}</div>
                                    </div>
                                    <div class="w-full truncate text-slate-500 mt-0.5">{{ $notification->notif_content }}</div>
                                </div>
                            </div>
                        @endif

                    @empty
                        <div class="w-full truncate text-slate-500 mt-0.5">No notification yet</div>
                    @endforelse
                </div>
            </div>
            <!-- END: Weekly Best Sellers -->


        </div>
    </div>

    <div class="col-span-12 2xl:col-span-3">
        <div class="2xl:border-l -mb-10 pb-10">
            <div class="2xl:pl-6 grid grid-cols-12 gap-x-6 2xl:gap-x-0 gap-y-6">
                <!-- BEGIN: Important Notes -->
                <div class="col-span-12 md:col-span-6 xl:col-span-12 mt-3 2xl:mt-8 ">
                    <div class="intro-x flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-auto">
                            Important Notes
                        </h2>

                        <button class="tiny-slider-navigator btn px-2 border-slate-300 text-slate-600 dark:text-slate-300 mr-2" data-tw-toggle="modal" data-tw-target="#add_new_note"><i class="icofont-plus text-success w-4 h-4"></i> </button>
                        <button data-carousel="important-notes" data-target="prev" class="tiny-slider-navigator btn px-2 border-slate-300 text-slate-600 dark:text-slate-300 mr-2"> <i data-lucide="chevron-left" class="w-4 h-4"></i> </button>
                        <button data-carousel="important-notes" data-target="next" class="tiny-slider-navigator btn px-2 border-slate-300 text-slate-600 dark:text-slate-300 mr-2"> <i data-lucide="chevron-right" class="w-4 h-4"></i> </button>
                    </div>
                    <div class="mt-5 intro-x ">
                        <div class="box zoom-in ">
                            <div class="tiny-slider load_important_notes" id="important-notes">

                                @forelse (load_notes()->where('type','') as $note)
                                <div class="p-5 overflow-y-auto ">
                                    <input id="note_id" name="note_id" type="text" class="form-control" value="{{ $note->id }}" hidden>
                                    <div class="text-base font-medium truncate">{{ $note->title }}</div>
                                    <div class="text-slate-400 mt-1">{{ $note->created_at->diffForHumans() }}</div>
                                    <div class="text-slate-500 text-justify mt-1 word-wrap overflow-wrap word-break">{{ $note->desc }}</div>
                                    <div class="font-medium flex mt-5 ">
                                        <span class=" py-1 px-2">{{ $note->getAuthor->firstname }} {{ $note->getAuthor->lastname }}</span>
                                            @if ($note->created_by == Auth::user()->employee)
                                                <button id="remove_document_note" type="button" data-nt-no="{{ $note->id }}" class="btn btn-outline-secondary py-1 px-2 ml-auto ml-auto">Dismiss</button>
                                            @elseif (Auth::user()->role_name == 'Admin')
                                                <button id="remove_document_note" type="button" data-nt-no="{{ $note->id }}" class="btn btn-outline-secondary py-1 px-2 ml-auto ml-auto">Dismiss</button>
                                            @endif
                                    </div>
                                </div>
                                @empty
                                <div class="p-5 overflow-y-auto ">

                                    <div class="text-slate-500 text-justify mt-1">No Notes Found!</div>

                                </div>
                                @endforelse

                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Important Notes -->


            </div>
        </div>
    </div>
</div>
@include('scanner.modal.add_note')
@include('scanner.modal.scan_modal')
@endsection


@section('scripts')
    <script src="{{ asset('/js/document_swal.js') }}"></script>
    <script src="{{ asset('/js/scan_Doc.js') }}"></script>

@endsection
