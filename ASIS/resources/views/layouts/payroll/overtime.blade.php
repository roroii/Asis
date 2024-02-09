@extends('layouts.app')

@section('content')
    <h2 class="intro-y text-lg font-medium mt-10">
        Overtime Setup
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <button class="btn btn-primary shadow-md mr-2">Add New Overtime</button>
            <div class="dropdown">
                <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                    <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i> </span>
                </button>
                <div class="dropdown-menu w-40">
                    <ul class="dropdown-content">
                        <li>
                            <a href="" class="dropdown-item"> <i data-lucide="printer" class="w-4 h-4 mr-2"></i> Print </a>
                        </li>
                        <li>
                            <a href="" class="dropdown-item"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export to Excel </a>
                        </li>
                        <li>
                            <a href="" class="dropdown-item"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export to PDF </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto overflow-x-auto scrollbar-hidden lg:overflow-visible">
                <table id="dt_overtime" class="table table-report -mt-2 table-hover">
                    <thead>
                    <tr>
                        <th class="hidden">ID</th>
                        <th class="whitespace-nowrap">NAME</th>
                        <th class="whitespace-nowrap">DESC</th>
                        <th class="text-center whitespace-nowrap">MODE</th>
                        <th class="text-center whitespace-nowrap">VALUE</th>
                        <th class="text-center whitespace-nowrap w-40" style="text-align: center">ACTIONS</th>
                    </tr>
                    </thead>
                    <tbody>
{{--                    <tr class="intro-x">--}}
{{--                        <td class="w-40 !py-4"> <a href="" class="underline decoration-dotted whitespace-nowrap">#INV-62807556</a> </td>--}}
{{--                        <td>--}}
{{--                            <a href="" class="font-medium whitespace-nowrap">Nike Tanjun</a>--}}
{{--                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">Sport &amp; Outdoor</div>--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <a href="" class="font-medium whitespace-nowrap">Nike Tanjun</a>--}}
{{--                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">Sport &amp; Outdoor</div>--}}
{{--                        </td>--}}
{{--                        <td class="text-center">$46</td>--}}
{{--                        <td class="table-report__action w-56">--}}
{{--                            <div class="flex justify-center items-center">--}}
{{--                                <a class="flex items-center mr-3" href="javascript:;"> <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit </a>--}}
{{--                                <a class="flex items-center text-danger" href="javascript:;" data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal"> <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>--}}
{{--                            </div>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
                    </tbody>
                </table>
        </div>
        <!-- END: Data List -->
    </div>
@endsection

@section('scripts')
    <script src="../js/payroll/overtime.js"></script>
@endsection()
