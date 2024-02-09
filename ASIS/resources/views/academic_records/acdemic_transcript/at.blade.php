@extends('layouts.app')

@section('content')

    <div class="col-span-12 lg:col-span-9 2xl:col-span-10 mt-5">
        <!-- BEGIN: Inbox Filter -->
        <div class="intro-y flex flex-col-reverse sm:flex-row items-center">
            <div class="w-full sm:w-auto relative mr-auto mt-3 sm:mt-0">
                <h2 class="text-lg font-medium mr-auto">
                    Transcript of Records
                </h2>
            </div>
            <div class="w-full sm:w-auto flex">
                {{-- <button class="btn btn-primary shadow-md mr-2">Start a Video Call</button> --}}
                <div class="dropdown">
                    <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                        <span class="w-5 h-5 flex items-center justify-center">
                            <i class="w-4 h-4" data-lucide="printer"></i>
                        </span>
                    </button>
                    <div class="dropdown-menu w-40">
                        <ul class="dropdown-content">
                            <li>
                                <a href="" class="dropdown-item">
                                    <i data-lucide="clipboard" class="w-4 h-4 mr-2"></i>
                                    Print PDF
                                </a>
                                <a href="" class="dropdown-item">
                                    <i data-lucide="clipboard" class="w-4 h-4 mr-2"></i>
                                    Download PDF
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Inbox Filter -->
        
            @foreach ($groupedData as $year => $yearData)
                <!-- BEGIN: Transcript of Records -->
                <div class="intro-y box p-5 mt-5">
                    <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                        <div class="font-medium text-base flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5">
                            <i data-lucide="clipboard" class="w-4 h-4 mr-2"></i>SY: {{ $year }}
                        </div>
                        <div class="mt-5">
                            @foreach ($yearData as $sem => $semData)
                                <!-- Semester {{ $sem }} -->
                                <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr >
                                                <th class="input-group-text ">
                                                    <span class="font-medium text-base">{{ $sem }}</span>
                                                    @if (!is_numeric($sem))
                                                        Summer
                                                    @else
                                                        Semester
                                                    @endif
                                                </th>
                                                <th class="input-group-text"></th>
                                                <th class="input-group-text"></th>
                                                <th class="input-group-text"></th>
                                            </tr>
                                            
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th class="input-group-text " style="width: 50%;">
                                                    Subject Code/Description
                                                </th>
                                                <th class="input-group-text" style="width: 20%;">Final Grade</th>
                                                <th class="input-group-text" style="width: 20%;">Complied</th>
                                                <th class="input-group-text" style="width: 10%;">Remarks</th>
                                            </tr>
                                            @foreach ($semData as $record)
                                                <tr>
                                                    <td class="input-group-text" style="width: 50%;">
                                                        <div class="font-medium">{{ $record->subjcode }}</div>
                                                        <div class="text-slate-500 text-xs">{{ $record->subject_description }}</div>
                                                    </td>
                                                    <td class="input-group-text" style="width: 20%;">
                                                        {{ $record->grade ?? 'N/A' }}
                                                    </td>
                                                    <td class="input-group-text" style="width: 20%;">
                                                        {{ $record->gcompl ?? 'N/A' }}
                                                    </td>
                                                    <td class="input-group-text" style="width: 10%;">
                                                        {{ $record->remarks ?? 'N/A' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- END: Transcript of Records -->
            @endforeach

    </div>
</div>

@endsection
