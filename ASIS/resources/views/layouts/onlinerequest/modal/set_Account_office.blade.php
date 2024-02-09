

<!-- BEGIN: Modal Content -->
<div id="set_Account_office" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header" style="background-color:rgb(30, 64, 175)">
              <h2 class="font-medium text-base mr-auto text-white">Set Account Office</h2> 
               
            </div> <!-- END: Modal Header -->

            <form method="POST"  enctype="multipart/form-data">
               @csrf
            <!-- BEGIN: Modal Body -->

            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-6"> 
                   <label for="modal-form-2" class="form-label">User</label>
                    <div class="mt-2"> <select data-placeholder="Select User" class="tom-select w-full" name="User_ID" id="User_ID">

                    @foreach($get_user_account as $user)

                      <option value="{{$user->id}}">{{$user->firstname}} {{substr($user->middlename, 0, 1)}}. {{$user->lastname}}</option>

                    @endforeach

             </select> </div>
               </div>


               <div class="col-span-12 sm:col-span-6"> 
                   <label for="modal-form-4" class="form-label">Office</label> 
                   <div class="mt-2"> <select data-placeholder="Select Office" class="tom-select w-full" id="office" name="office">
                    @foreach($get_offfice as $office)

                      <option value="{{$office->id}}">{{$office->office_name}}</option>

                   @endforeach
    
             </select> </div>
               </div>
           
            </div> <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            </form>

            <div class="modal-footer"> 
               <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <button type="button" id="userAccount_update_btn" href="javascript:;" class="btn btn-primary w-20"><i class="fa-solid fa-plus"></i></i>Save</button> </div>
           <!-- END: Modal Footer -->
        </div>
    </div>
</div> <!-- END: Modal Content -->//