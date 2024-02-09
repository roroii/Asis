<!DOCTYPE html>

<html lang="en" class="light">
<!-- BEGIN: Head -->
<head>
    @include('_partials.head')
</head>

<body>
<div class="content">

       <div class="intro-y grid grid-cols-12 gap-5 mt-5">

            <div class="col-span-12 lg:col-span-3">

                <!-- BEGIN: Document Details -->
                <div class="box p-5 rounded-md">
                    <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                        <div class="font-medium text-base truncate">Document Details</div>
        {{--                <a href="" class="flex items-center ml-auto text-primary"> <i data-lucide="edit" class="w-4 h-4 mr-2"></i> Change Status </a>--}}
                    </div>
                    <div class="flex items-center"> <i data-lucide="clipboard" class="w-4 h-4 text-slate-500 mr-2"></i> Track Number: <a href="" class="underline decoration-dotted ml-1">{{ $trackNumber }}</a> </div>
                    <div class="flex items-center mt-3"> <i data-lucide="calendar" class="w-4 h-4 text-slate-500 mr-2"></i> Created at: <div class="ml-2">{{ $createdAt }}</div> </div>
                    <div class="flex items-center mt-3"> <i data-lucide="clock" class="w-4 h-4 text-slate-500 mr-2"></i> Status: <span class="bg-{{ $class }}/20 text-{{ $class }} rounded px-2 ml-1">{{ $Status }}</span> </div>

                    <div class="flex items-center mt-4">

                        <div class="col-span-12 sm:col-span-12 mt-2">
                            <div class="flex items-center mt-3"> {{ $doc_name }} </div>

                            <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500 ">{{ $doc_desc }}</span>
                        </div>
                    </div>
                </div>
                <!-- END: Document Details -->

                <!-- BEGIN: Creator Details -->
                <div class="box p-5 rounded-md mt-5">
                    <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                        <div class="font-medium text-base truncate">Creator Details</div>
        {{--                <a href="" class="flex items-center ml-auto text-primary"> <i data-lucide="edit" class="w-4 h-4 mr-2"></i> View Details </a>--}}
                    </div>
                    <div class="flex items-center"> <i data-lucide="clipboard" class="w-4 h-4 text-slate-500 mr-2"></i> Name: <a href="" class="underline decoration-dotted ml-1">{{ $fullName }}</a> </div>
                    <div class="flex items-center mt-3"> <i data-lucide="calendar" class="w-4 h-4 text-slate-500 mr-2"></i> Phone Number: <span class="ml-2">{{ $contact }}</span> </div>
                </div>
                <!-- END: Creator Details -->

                <!-- BEGIN: Release Details -->
                <div class="box p-5 rounded-md mt-5">
                    <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                        <div class="font-medium text-base truncate">Release Details</div>
                    </div>
                    <div class="flex items-center">
                        <i data-lucide="clipboard" class="w-4 h-4 text-slate-500 mr-2"></i> Recipients:
                        <div class="ml-auto">@if($count_recipients >= 1) {{ $count_recipients }} <span class="ml-1"> @if($count_recipients >= 1) person @else persons @endif</span> @endif </div>
                    </div>
                    <div class="flex items-center mt-3">
                        <i data-lucide="credit-card" class="w-4 h-4 text-slate-500 mr-2"></i> Level ({{ $level_id }}):
                        <div class="ml-auto bg-{{ $level_class }}/20 rounded px-2 ml-1"><span class="text-{{$level_class}}">{{ $level_doc_level }}</span></div>
                    </div>
    {{--                <div class="flex items-center mt-3">--}}
    {{--                    <i data-lucide="credit-card" class="w-4 h-4 text-slate-500 mr-2"></i> Total Not Received (s):--}}
    {{--                    <div class="ml-auto">{{ $getTrackdetails->where('action_taken', false)->where('status', 3)->count() }}</div>--}}
    {{--                </div>--}}
    {{--                <div class="flex items-center border-t border-slate-200/60 dark:border-darkmode-400 pt-5 mt-5 font-medium">--}}
    {{--                    <i data-lucide="credit-card" class="w-4 h-4 text-slate-500 mr-2"></i> Total Received:--}}
    {{--                    <div class="ml-auto">{{ $getTrackdetails->where('for_status', 6)->count() }}</div>--}}
    {{--                </div>--}}


                </div>
                <!-- END: Release Details -->

                <!-- BEGIN: Attachments Information -->
                <div class="box p-5 rounded-md mt-5">
                    <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                        <div class="font-medium text-base truncate">Attachments Information</div>
        {{--                <a href="" class="flex items-center ml-auto text-primary"> <i data-lucide="map-pin" class="w-4 h-4 mr-2"></i> Tracking Info </a>--}}
                    </div>

                    <input id="tracking_number" class="hidden" value="{{ $trackNumber }}">
                    <div class="flex items-center"> <i data-lucide="clipboard" class="w-4 h-4 text-slate-500 mr-2"></i> Document Type: <span class="ml-1">{{ $getDocType }}</span> </div>

                    @if($count == 0)
                        <div class="flex items-center mt-3"> <i data-lucide="folder" class="w-4 h-4 text-slate-500 mr-2"></i> Total Attachment (s):
                            <span class="ml-1"> No Attachment available </span>
                        </div>
                            @else
                        <div class="flex items-center mt-3"> <i data-lucide="folder" class="w-4 h-4 text-slate-500 mr-2"></i> Total Attachment (s):
                            <span class="ml-1">{{ $count }}</span> <span class="ml-1">@if($count == 1) file @elseif($count > 1) files @endif</span>
                        </div>


                        <div id="track_file_attachments" class="flex items-center mt-3">

                        </div>


                        {{-- @forelse($getAttachments as $attachments)
                            <div class="flex items-center mt-3"> <i data-lucide="paperclip" class="w-4 h-4 text-slate-500 mr-2">
                                </i><a href="/documents/download-documents/{{ $attachments->path }}" target="_blank" class="underline decoration-dotted ml-1 text-toldok2">{{ $attachments->name }}</a>
                            </div>
                        @empty
                            <div class="flex items-center mt-3"> <i data-lucide="paperclip" class="w-4 h-4 text-slate-500 mr-2">No Data</i></div>
                        @endforelse --}}

                    @endif
                </div>
                <!-- BEGIN: Attachments Information -->

            </div>
            <!-- BEGIN: Document Details -->


            <!-- BEGIN: Transaction Details -->
            <div class="col-span-12 lg:col-span-6">
                <div class="box p-5 rounded-md">
                    <div class="pb-5 mb-5">
                        <div class="relative">
                            <input onkeyup="search_documents(this.value)" autocomplete="off" id="scan_document_track" onfocus="this.value='';" autofocus type="text" class="form-control h-100 w-full" placeholder="Scan Document...">
                            <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0 text-slate-500" data-lucide="Scan"></i>
                        </div>
                    </div>
                    <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                        <div class="font-medium text-base truncate">Track Records</div>
        {{--                <a href="" class="flex items-center ml-auto text-primary"> <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Add Notes </a>--}}
                    </div>
                    <div class="overflow-auto lg:overflow-visible -mt-3">
                        <div class="mt-5">

                            {{--               Load all Transaction Details here!               --}}
                            <div id="recipient_table" class="mt-5 relative before:block before:absolute before:w-px before:h-full before:mt-caloy-1 before:bg-slate-200 before:dark:bg-darkmode-400 before:ml-5 before:mt-b-6"></div>
    {{--                        <div id="recipient_table_single" class="mt-5 relative before:block before:absolute before:w-px before:bg-slate-200 before:dark:bg-darkmode-400 before:ml-5 before:mt-5"></div>--}}

                            {{--               Document Author               --}}
                            <div id="__author" class="intro-y"></div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Transaction Details -->


            <!-- BEGIN: Document Notes -->
            <div class="col-span-12 2xl:col-span-3">
               <div class="2xl:border-l -mb-10 pb-10">
                   <div class="2xl:pl-6 grid grid-cols-12 gap-x-6 2xl:gap-x-0 gap-y-6">
                       <!-- BEGIN: Important Notes -->
                       <div class="col-span-12 md:col-span-6 xl:col-span-12">
                           <div class="intro-x flex items-center h-10">
                               <h2 class="text-lg font-medium truncate mr-auto">
                                   Document Notes
                               </h2>

                               <button class="tiny-slider-navigator btn px-2 border-slate-300 text-slate-600 dark:text-slate-300 mr-2" data-tw-toggle="modal" data-tw-target="#add_docs_note"><i class="icofont-plus text-success w-4 h-4"></i> </button>
                               <button data-carousel="important-notes" data-target="prev" class="tiny-slider-navigator btn px-2 border-slate-300 text-slate-600 dark:text-slate-300 mr-2"> <i data-lucide="chevron-left" class="w-4 h-4"></i> </button>
                               <button data-carousel="important-notes" data-target="next" class="tiny-slider-navigator btn px-2 border-slate-300 text-slate-600 dark:text-slate-300 mr-2"> <i data-lucide="chevron-right" class="w-4 h-4"></i> </button>
                           </div>
                           <div class="mt-5 intro-x ">
                               <div class="box zoom-in ">
                                   <div class="tiny-slider load_important_notes" id="important-notes">

                                       @forelse (load_notes()->where('type','document_notes')->where('type_id',$trackNumber) as $note)
                                           <div class="p-5 overflow-y-auto ">
                                               <input id="document_note_id" name="note_id" type="text" class="form-control" value="{{ $note->id }}" hidden>
                                               <div class="text-base font-medium truncate">{{ $note->title }}</div>
                                               <div class="text-slate-400 mt-1">{{ $note->created_at->diffForHumans() }}</div>
                                               <div class="text-slate-500 text-justify mt-1 word-wrap overflow-wrap word-break">{{ $note->desc }}</div>
                                               <div class="font-medium flex mt-5 ">
                                                <span class=" py-1 px-2">{{ $note->getAuthor->firstname }} {{ $note->getAuthor->lastname }}</span>
                                                    @if ($note->created_by == Auth::user()->employee)
                                                        <button id="remove_document_note" type="button" data-nt-no="{{ $note->id }}" class="btn btn-outline-secondary py-1 px-2 ml-auto ml-auto">Dismiss</button>
                                                    @elseif (Auth::user()->role_name == 'Admin')
                                                        <button id="remove_document_note" type="button" data-nt-no="{{ $note->id }}" class="btn btn-outline-secondary py-1 px-2 ml-auto ml-auto">Dismiss</button>
                                                    @elseif ($doc_created_by == Auth::user()->employee)
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
            <!-- END: Document Notes -->
        </div>
    @include('track.modal.transaction_modal')
    @include('track.modal.add_docs_note')
</div>
</div>
@include('_partials.scripts')

<script src="{{  asset('/js/track.js') }}"></script>
<script>
    var __basepath = "{{url('')}}";
</script>
</body>
</html>

