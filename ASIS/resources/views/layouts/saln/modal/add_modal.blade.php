 <!-- BEGIN: Super Large Modal Content -->
 <div id="add_saln_modal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form id="form_createDocs"  method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="alert alert-danger" style="display:none"></div>
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">SWORN STATEMENT OF ASSETS, LIABILITIES AND NET WORTH </h2>
                </div>
                <!-- END: Modal Header -->

                <!-- BEGIN: Modal Body -->
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                    <input hidden id="modal_update_saln_id" type="text" class="form-control" placeholder="id">

                    <div class="col-span-12 sm:col-span-12">

                        <div class="intro-y">
                            <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                                <div class="font-medium text-base flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5"> Personal Information </div>
                                <div class="mt-5">
                                    <div class="col-span-12 mt-4 sm:col-span-12">
                                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> As of</label>
                                        <input id="modal_as_of" type="date" class="form-control" placeholder="As of">
                                    </div>

                                    <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">


                                        <div class="w-full mt-3 xl:mt-0 flex-1">
                                            <div class="leading-relaxed text-slate-500 text-xs mt-3"> <strong>Note:</strong> Husband and wife who are both public officials and employees may file the required statements jointly or separately.</div>

                                            <div class="flex flex-col sm:flex-row">
                                                <div class="form-check mr-4">
                                                    <input id="modal_JointFiling" class="form-check-input" type="radio" name="modal_joint_filing" value="1">
                                                    <label class="form-check-label" for="shipping-service-standard">Joint Filing</label>
                                                </div>
                                                <div class="form-check mr-4 mt-2 sm:mt-0">
                                                    <input id="modal_SeparateFiling" class="form-check-input" type="radio" name="modal_joint_filing" value="2">
                                                    <label class="form-check-label" for="shipping-service-custom">Separate Filing</label>
                                                </div>
                                                <div class="form-check mr-4 mt-2 sm:mt-0">
                                                    <input id="modal_NotApplicable" class="form-check-input" type="radio" name="modal_joint_filing" value="3">
                                                    <label class="form-check-label" for="shipping-service-custom">Not Applicable</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-span-12 mt-4 sm:col-span-12">
                                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> <strong>DECLARANT</strong> </label>
                                        <div class="sm:grid grid-cols-3 gap-2">
                                            <div class="input-group">
                                                <input id="modal_declarant_firstname" type="text" class="form-control" placeholder="First Name" value="{{ Auth::user()->firstname }}">
                                            </div>
                                            <div class="input-group mt-2 sm:mt-0">
                                                <input id="modal_declarant_lastname" type="text" class="form-control" placeholder="Last Name" value="{{ Auth::user()->lastname }}">
                                            </div>
                                            <div class="input-group mt-2 sm:mt-0">
                                                <input id="modal_declarant_middlename" type="text" class="form-control" placeholder="Middle Name" value="{{ Auth::user()->middlename }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-span-12 mt-4 sm:col-span-12">
                                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> ADDRESS</label>
                                        <input id="modal_declarant_address" type="text" class="form-control" placeholder="ADDRESS">
                                    </div>


                                    <div class="col-span-12 mt-4  sm:col-span-12">
                                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> POSITION</label>
                                        <input id="modal_declarant_position" type="text" class="form-control" placeholder="POSITION">
                                    </div>
                                    <div class="col-span-12 mt-4  sm:col-span-12">
                                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> AGENCY/OFFICE</label>
                                        <input id="modal_declarant_agency_office" type="text" class="form-control" placeholder="AGENCY/OFFICE">
                                    </div>
                                    <div class="col-span-12 mt-4  sm:col-span-12">
                                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> OFFICE ADDRESS</label>
                                        <input id="modal_declarant_office_address" type="text" class="form-control" placeholder="OFFICE ADDRESS">
                                    </div>

                                    <div class="col-span-12 mt-4 sm:col-span-12">
                                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> Government Issued ID</label>
                                        <div class="sm:grid grid-cols-3 gap-2">
                                            <div class="input-group">
                                                <input id="modal_declarant_id" type="text" class="form-control" placeholder="Government Issued ID">
                                            </div>
                                            <div class="input-group mt-2 sm:mt-0">
                                                <input id="modal_declarant_id_no" type="text" class="form-control" placeholder="ID No.">
                                            </div>
                                            <div class="input-group mt-2 sm:mt-0">
                                                <input id="modal_declarant_date" type="date" class="form-control" placeholder="Date Issued">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-span-12 mt-4 sm:col-span-12">
                                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> <strong>SPOUSE</strong> </label>
                                        <div class="sm:grid grid-cols-3 gap-2">
                                            <div class="input-group">
                                                <input id="modal_spouse_firstname" type="text" class="form-control" placeholder="First Name">
                                            </div>
                                            <div class="input-group mt-2 sm:mt-0">
                                                <input id="modal_spouse_lastname" type="text" class="form-control" placeholder="Last Name">
                                            </div>
                                            <div class="input-group mt-2 sm:mt-0">
                                                <input id="modal_spouse_middlename" type="text" class="form-control" placeholder="Middle Name">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-span-12 mt-4  sm:col-span-12">
                                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> POSITION</label>
                                        <input id="modal_spouse_position" type="text" class="form-control" placeholder="POSITION">
                                    </div>
                                    <div class="col-span-12 mt-4  sm:col-span-12">
                                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> AGENCY/OFFICE</label>
                                        <input id="modal_spouse_agency_office" type="text" class="form-control" placeholder="AGENCY/OFFICE">
                                    </div>
                                    <div class="col-span-12 mt-4  sm:col-span-12">
                                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> OFFICE ADDRESS</label>
                                        <input id="modal_spouse_office_address" type="text" class="form-control" placeholder="OFFICE ADDRESS">
                                    </div>

                                    <div class="col-span-12 mt-4 sm:col-span-12">
                                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> Government Issued ID</label>
                                        <div class="sm:grid grid-cols-3 gap-2">
                                            <div class="input-group">
                                                <input id="modal_spouse_id" type="text" class="form-control" placeholder="Government Issued ID">
                                            </div>
                                            <div class="input-group mt-2 sm:mt-0">
                                                <input id="modal_spouse_no" type="text" class="form-control" placeholder="ID No.">
                                            </div>
                                            <div class="input-group mt-2 sm:mt-0">
                                                <input id="modal_spouse_date" type="date" class="form-control" placeholder="Date Issued">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>


                    <div class="col-span-12 sm:col-span-12">

                        <div class="intro-y">
                            <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                                <div class="font-medium text-base flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5">
                                    UNMARRIED CHILDREN BELOW EIGHTEEN (18) YEARS OF AGE LIVING IN DECLARANT’S  HOUSEHOLD
                                     </div>

                                <div class="mt-5">

                                    <div class="col-span-12 sm:col-span-12">
                                        <div class="flex">
                                            <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">  </label>
                                            <a href="javascript:;" id="add_row_un_chil_table_modal" class="ml-auto text-primary truncate flex items-center"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="plus" data-lucide="plus" class="lucide lucide-plus w-4 h-4 mr-1"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> Add </a>
                                        </div>
                                        <table class="table un_chil_table_modal">
                                            <thead>
                                                <tr>

                                                    <th >Name</th>
                                                    <th >Date of Birth</th>
                                                    <th >Age</th>
                                                    <th >Action</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>

                                        </table>
                                    </div>


                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="col-span-12 sm:col-span-12">

                        <div class="intro-y">
                            <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                                <div class="font-medium text-base flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5">
                                    ASSETS, LIABILITIES AND NETWORTH
                                     </div>

                                     <div class="leading-relaxed text-slate-500 text-xs mt-3"> (Including those of the spouse and unmarried children below eighteen (18)
                                        years of age living in declarant’s household)
                                        </div>

                                <div class="mt-5">

                                    <div class="col-span-12 sm:col-span-12">
                                        <div class="flex">
                                            <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> 1.  ASSETS </label>
                                            <a href="javascript:;" id="add_row_asset" class="ml-auto text-primary truncate flex items-center"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="plus" data-lucide="plus" class="lucide lucide-plus w-4 h-4 mr-1"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> Add </a>
                                        </div>
                                        <div class="flex">
                                            <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row pl-5">a. Real Properties*</label>
                                        </div>
                                        <div class="overflow-x-auto">


                                        <table style="min-width: 1500px" class="table asset_modal_table table-bordered">
                                            <thead>
                                                <tr>

                                                    <th rowspan="2">DESCRIPTION <div class="leading-relaxed text-slate-500 text-xs mt-3">(e.g. lot, house and lot, condominium and improvements)</div></th>
                                                    <th rowspan="2">KIND <div class="leading-relaxed text-slate-500 text-xs mt-3">(e.g. residential, commercial, industrial, agricultural and mixed use)</div></th>
                                                    <th rowspan="2">EXACT LOCATION </th>


                                                    <th >ASSESSED VALUE</th>
                                                    <th >CURRENT FAIR MARKET VALUE </th>



                                                    <th colspan="2">ACQUISITION</th>
                                                    <th >ACQUISITION COST</th>
                                                    <th >Action</th>

                                                </tr>

                                                <tr>

                                                    <td colspan="2"><div class="leading-relaxed text-slate-500 text-xs mt-3">(As found in the Tax Declaration of Real Property)</div> </td>
                                                    <td>Year</td>
                                                    <td>Mode</td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>

                                            </thead>
                                            <tbody>




                                            </tbody>
                                            <tfoot>


                                            </tfoot>

                                        </table>
                                    </div>
                                    </div>

                                    <div class="flex justify-end flex-col md:flex-row gap-2 mt-5">

                                        <label >Subtotal: </label>
                                        <label ><strong id="modal_real_prop_sub_total">0</strong></label>

                                    </div>

                                    <div class="col-span-12 pt-10 sm:col-span-12">
                                        <div class="flex">
                                            <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row pl-5">b. Personal Properties*</label>
                                            <a href="javascript:;" id="add_row_pp" class="ml-auto text-primary truncate flex items-center"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="plus" data-lucide="plus" class="lucide lucide-plus w-4 h-4 mr-1"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> Add </a>

                                        </div>
                                        <div class="overflow-x-auto">


                                        <table style="min-width: 1500px" class="table pp_modal_table table-bordered">
                                            <thead>

                                                <tr>
                                                    <th>DESCRIPTION</th>
                                                    <th>YEAR ACQUIRED</th>
                                                    <th>ACQUISITION COST/AMOUNT</th>
                                                    <th>Action</th>
                                                </tr>

                                            </thead>
                                            <tbody>


                                            </tbody>
                                            <tfoot>

                                            </tfoot>

                                        </table>
                                    </div>
                                    </div>

                                    <div class="flex justify-end flex-col md:flex-row gap-2 mt-5">

                                        <label >Subtotal: </label>
                                        <label ><strong id="modal_personal_pro_sub_total">0</strong></label>

                                    </div>

                                    <div class="flex justify-end flex-col md:flex-row gap-2 mt-5">

                                        <label >TOTAL ASSETS (a+b): </label>
                                        <label ><strong id="modal_total_assets">0</strong></label>

                                    </div>

                                    <div class="col-span-12  pt-10  sm:col-span-12">
                                        <div class="flex">
                                            <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">2.	LIABILITIES* </label>
                                            <a href="javascript:;" id="add_row_liab" class="ml-auto text-primary truncate flex items-center"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="plus" data-lucide="plus" class="lucide lucide-plus w-4 h-4 mr-1"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> Add </a>
                                        </div>

                                        <div class="overflow-x-auto">


                                        <table style="min-width: 1500px" class="table liab_modal_table table-bordered">
                                            <thead>

                                                <tr>
                                                    <th>NATURE</th>
                                                    <th>NAME OF CREDITORS</th>
                                                    <th>OUTSTANDING BALANCE</th>
                                                    <th>Action</th>
                                                </tr>

                                            </thead>
                                            <tbody>


                                            </tbody>
                                            <tfoot>

                                            </tfoot>

                                        </table>
                                    </div>
                                    </div>

                                    <div class="flex justify-end flex-col md:flex-row gap-2 mt-5">

                                        <label >TOTAL LIABILITIES: </label>
                                        <label ><strong id="modal_total_liabilities">0</strong></label>

                                    </div>
                                    <div class="flex justify-end flex-col md:flex-row gap-2 mt-5">

                                        <label >NET WORTH : Total Assets less Total Liabilities = </label>
                                        <label ><strong id="modal_total_net_worth">0</strong></label>

                                    </div>


                                </div>
                            </div>
                        </div>


                    </div>


                    <div class="col-span-12 sm:col-span-12">

                        <div class="intro-y">
                            <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                                <div class="font-medium text-base flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5">
                                    BUSINESS INTERESTS AND FINANCIAL CONNECTIONS
                                     </div>


                                     <div class="leading-relaxed text-slate-500 text-xs mt-3">
                                        (of Declarant /Declarant’s spouse/ Unmarried Children Below Eighteen (18) years of Age Living in Declarant’s Household)
                                        </div>

                                        <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                                            <div class="w-full mt-3 xl:mt-0 flex-1">
                                                <div class="form-check form-switch">
                                                    <input id="biafc_has_business_interest" class="form-check-input biafc_has_business_interest" type="checkbox">
                                                    <label class="form-check-label leading-relaxed text-slate-500 text-xs" for="preorder-active"> I/We do not have any business interest or financial connection.</label>
                                                </div>
                                            </div>
                                        </div>
                                <div class="mt-5">

                                    <div class="col-span-12 sm:col-span-12">
                                        <div class="flex">
                                            <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">  </label>
                                            <a href="javascript:;" id="add_row_buin" class="ml-auto text-primary truncate flex items-center"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="plus" data-lucide="plus" class="lucide lucide-plus w-4 h-4 mr-1"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> Add </a>
                                        </div>
                                            <div class="overflow-x-auto">
                                                <table style="min-width: 1500px" class="table buin_modal_table table-bordered">
                                                    <thead>
                                                        <tr>

                                                            <th >NAME OF ENTITY/BUSINESS ENTERPRISE</th>
                                                            <th >BUSINESS ADDRESS</th>
                                                            <th >NATURE OF BUSINESS INTEREST &/OR FINANCIAL CONNECTION</th>
                                                            <th >DATE OF ACQUISITION OF INTEREST OR CONNECTION</th>
                                                            <th >Action</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>

                                                </table>
                                            </div>
                                    </div>


                                </div>
                            </div>
                        </div>


                    </div>


                    <div class="col-span-12 sm:col-span-12">

                        <div class="intro-y">
                            <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                                <div class="font-medium text-base flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5">
                                    RELATIVES IN THE GOVERNMENT SERVICE
                                     </div>


                                     <div class="leading-relaxed text-slate-500 text-xs mt-3">
                                        (Within the Fourth Degree of Consanguinity or Affinity. Include also Bilas, Balae and Inso)
                                        </div>

                                        <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                                            <div class="w-full mt-3 xl:mt-0 flex-1">
                                                <div class="form-check form-switch">
                                                    <input id="ritgs_has_gov_serv_relative" class="form-check-input ritgs_has_gov_serv_relative" type="checkbox">
                                                    <label class="form-check-label leading-relaxed text-slate-500 text-xs" for="preorder-active"> I/We do not know of any relative/s in the government service</label>
                                                </div>
                                            </div>
                                        </div>
                                <div class="mt-5">

                                    <div class="col-span-12 sm:col-span-12">
                                        <div class="flex">
                                            <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> Included </label>
                                            <a href="javascript:;" id="add_row_regs" class="ml-auto text-primary truncate flex items-center"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="plus" data-lucide="plus" class="lucide lucide-plus w-4 h-4 mr-1"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> Add </a>
                                        </div>
                                            <div class="overflow-x-auto">
                                                <table style="min-width: 1500px" class="table regs_modal_table table-bordered">
                                                    <thead>
                                                        <tr>

                                                            <th >NAME OF RELATIVE</th>
                                                            <th >RELATIONSHIP</th>
                                                            <th >POSITION</th>
                                                            <th >NAME OF AGENCY/OFFICE AND ADDRESS</th>
                                                            <th >Action</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>

                                                </table>
                                            </div>
                                    </div>


                                </div>
                            </div>
                        </div>


                    </div>


                </div>

                <!-- END: Modal Body -->

                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button id="cancel_documents_btn" type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                    <a href="javascript:;" id="add_saln" class="btn btn-primary w-20 add_saln"> Save </a>

                </div>
                <!-- END: Modal Footer -->
            </div>
        </form>
    </div>
</div>
<!-- END: Super Large Modal Content -->
