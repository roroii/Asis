@extends('layouts.app')

@section('content')

<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
       Leave Settings
    </h2>
    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
        <button class="btn btn btn-primary  shadow-sm mr-2">ADD</button>
        <div class="dropdown ml-auto sm:ml-0">
            <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i> </span>
            </button>
            <div class="dropdown-menu w-40">
                <ul class="dropdown-content">
                    <li>
                        <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#add_newleave_type_modal" class="dropdown-item"data-tw-toggle="modal" data-tw-target="#add_newleave_type_modal"> <i data-lucide="plus" class="w-4 h-4 mr-2"></i>Add Leave Type</a>
                    </li>
                    <li>
                        <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#add_leave_categoryform"  class="dropdown-item"> <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Add Category </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- BEGIN: Transaction Details -->
<div class="intro-y grid grid-cols-11 gap-5 mt-5">
    
    <div class="col-span-12 lg:col-span-7 2xl:col-span-8">
        <div class="box p-5 rounded-md">
            <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                <div class="font-medium text-base truncate">Leave Type</div>
            </div>
            <div class="overflow-auto lg:overflow-visible -mt-3">
                <table class="table table-striped" id="list_of_leave_type">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap !py-5">Type Name</th>
                            <th class="whitespace-nowrap text-right">Category</th>
                            <th class="whitespace-nowrap text-right">Qualified Gender</th>
                            <th class="whitespace-nowrap text-right">Number of Leave</th>
                            <th class="whitespace-nowrap text-right">Leave Category Type</th>
                            <th class="whitespace-nowrap text-right">Ascending</th>
                            <th class="whitespace-nowrap text-right">Action</th>
                        </tr>
                    
                    </tbody>
                </table>
            </div>
        </div> 
    </div>

    <!-- Start Category-->

    <div class="col-span-12 lg:col-span-4 2xl:col-span-3">
        <div class="box p-5 rounded-md">
            <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                <div class="font-medium text-base truncate">Category</div>
              
            </div>
            <div class="intro-y col-span-12 overflow-auto 2xl:overflow-visible">
                <table class="table table-report -mt-2">
                    <thead>
                        <tr>
     
                            <th class="whitespace-nowrap">Category Name</th>
                            <th class="text-center whitespace-nowrap">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ( $leave_category as $index => $item )
                            
                
                    <tr class="intro-x">
                            <td class="text-center"> <a class="flex items-center justify-center decoration-dotted">{{ $item->name }}</a> </td>
                     
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <a class="flex items-center mr-3" href="javascript:;"> <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                    <a id=" {{ $item->id }} " class="flex items-center text-danger delete_leave_category_btn" href="javascript:;"> <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                </div>
                      
                            </td>

                            @empty
                    
                            <p>No Data</p>

                        </tr>
                    </tbody>
                    
                 

                    @endforelse

                </table>
            </div>
            <!-- END: Data List -->
            
        
</div>

<!-- END: Catergory Details -->
</div>

   
@include('leave.modal.addnewleavetype')
@include('leave.modal.edit_leave_type_modal')
@include('leave.modal.add_leave_categoryform')
@endsection


@section('scripts')
    <script src="../js/leave/leave_module.js"></script>
    <script src="../js/leave/leave_category.js"></script>
@endsection()