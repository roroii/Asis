@extends('layouts.app')

@section('content')

<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
   Manage Offices and Services
    </h2>
    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
        <div class="dropdown ml-auto sm:ml-0">
           Add Office <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i> </span>
            </button>
            <div class="dropdown-menu w-40">
                <ul class="dropdown-content">
                    <li>
                        <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#add_new_office_modal" class="dropdown-item"> <i data-lucide="plus" class="w-4 h-4 mr-2"></i>Add Office</a>
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
                <div class="font-medium text-base truncate">List of Offices and Services </div>
            </div>
      <div class="intro-y col-span-12 overflow-auto 2xl:overflow-visible">
                <table class="table table-report -mt-2" id="offices_and_services_table">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap !py-5">Office/Department</th>
                            <th class="whitespace-nowrap text-right">Available Services</th>
                            <th class="whitespace-nowrap text-right">Added by</th>
                            <th class="whitespace-nowrap text-right">Date Added</th>
                            <th class="whitespace-nowrap text-right">Action</th>
                        </tr>
                    
                </table>
<div class="font-medium text-base truncate">Set Account office 
            <button class="dropdown-toggle btn px-2 box" data-tw-toggle="modal" data-tw-target="#set_Account_office">
                <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i> </span></div>
            </button>
          
         
                  <table class="table table-report -mt-2" id="set_account_offices_table">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap !py-5">Name</th>
                            <th class="whitespace-nowrap !py-5">Email</th>
                            <th class="whitespace-nowrap !py-5">Role</th>
                            <th class="whitespace-nowrap text-right">Office</th>
                        </tr>
                    
                </table>

            </div>
        </div> 
    </div>

    <!-- Start Manage Offices and Services-->

    <div class="col-span-12 lg:col-span-4 2xl:col-span-3">
        <div class="box p-5 rounded-md">
            <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                <div class="font-medium text-base truncate">Manage Office and Services</div>
              
            </div>

            <div class="intro-y col-span-12 overflow-auto 2xl:overflow-visible">
                <table class="table table-report -mt-2" id="office_departmentlist_table">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">Office/Department</th>
                            <th class="text-center whitespace-nowrap">Action</th>
                        </tr>
                    </thead>
                </table>
            
            </div>
            <!-- END:  -->            
        
</div>


</div>

@include('layouts.onlinerequest.modal.set_Account_office')
@include('layouts.onlinerequest.modal.add_office_services')
@include('layouts.onlinerequest.modal.add_new_office')
@endsection


@section('scripts')
     <script src={{ asset('js/ASIS_js/OnlineRequest.js') }}></script>

@endsection()


