<!-- BEGIN: Super Large Modal Content -->
<div id="createIDP_modal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x" class="w-8 h-8 text-slate-500"></i> </a>
            <!-- BEGIN: Modal Header -->
            <div class="alert alert-danger" style="display:none"></div>

            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">CREATE IDP</h2>
            </div>
            <!-- END: Modal Header -->

            <!-- BEGIN: Modal Body -->
            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                <div class="col-span-12 sm:col-span-12">
                    <div class="intro-y">

                        <form id="idp_form" enctype="multipart/form-data">
                            @csrf
                            <!--Begin Exclusive-->
                            <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5 mb-5">

                                <div class="input-form">
                                    <h2 id="exclusive_year" class="block font-medium text-base mb-5">
                                        Exclusive Year <span id="from_year_label"></span><span id="to_year_label"></span>
                                    </h2> 
                                        <div class="grid grid-cols-12 gap-4 gap-y-3">
                                            

                                            <div class="input-form col-span-12 lg:col-span-3">
                                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> From Year </label>
                                                <select id="from_year" name="from_year" style="width: 100%">
                                                    <option></option>
                                                    @forelse(loadYears() as $year)
                                                        <option value="{{ $year}}">{{ $year }}</option>
                                                    @empty
                                                    @endforelse
                                                </select>
                                            </div>
                                            <div class="input-form col-span-12 lg:col-span-3">
                                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> To Year </label>
                                                <select id="to_year" name="to_year" style="width: 100%">
                                                    <option></option>
                                                    <option value="0">Blank</option>
                                                    @forelse(loadYears() as $year)
                                                        <option value="{{ $year}}">{{ $year }}</option>
                                                    @empty
                                                    @endforelse
                                                </select>
                                            </div>

                                        </div>
                                    
                                </div>

                            </div>
                            <!--Begin Exclusive-->

                            <!--Begin personal Information-->
                            <div id="faq-accordion-2" class="accordion accordion-boxed">
                                <div class="accordion-item">
                                    


                                    <div class="accordion-item">
                                        <div id="faq-accordion-content-8" class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-tw-toggle="collapse" data-tw-target="#faq-accordion-collapse-8" aria-expanded="false" aria-controls="faq-accordion-collapse-8"> Verify Your Info </button>
                                        </div>
                                        <div id="faq-accordion-collapse-8" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-8" data-tw-parent="#faq-accordion-2">
                                            <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">

                                                <div class="input-form">
                                                   
                                                        <div class="grid grid-cols-12 gap-4 gap-y-3">
                    
                                                            <input id="idp_id" name="idp_id" class="hidden">           
                                                                        
                                                        
                                                            <div class="col-span-12 lg:col-span-6">
                                                                <label for="my_position" class="form-label w-full flex flex-col sm:flex-row"> Current Position </label>
                                                                <select id="my_position" name="my_position" style="width: 100%">
                                                                    <option></option>
                                                                    @forelse(get_position() as $my_position)
                                                                        <option value="{{ $my_position->id }}">{{ $my_position->emp_position }}</option>
                                                                    @empty
                                                                    @endforelse
                                                                </select>
                                                            </div>                                    
                    
                                                            <div class="input-form col-span-12 lg:col-span-6">
                                                                <label for="year_n_postision" class="form-label w-full flex flex-col sm:flex-row"> Years in the Position </label>
                                                                <input id="year_n_postision" name="year_n_postision" type="text" class="form-control" minlength="2" required autocomplete="on">
                                                            </div>
                    
                                                            <div class="input-form col-span-12 lg:col-span-6">
                                                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Salary Grade </label>
                                                                <select id="my_sg" name="my_sg" style="width: 100%">
                                                                    <option></option>
                                                                    @forelse(load_salary_grade() as $my_sg)
                                                                        <option value="{{ $my_sg->id }}">{{ $my_sg->name.'  ('.$my_sg->code.')' }}</option>
                                                                    @empty
                                                                    @endforelse
                                                                </select>
                                                            </div>
                    
                                                            <div class="input-form col-span-12 lg:col-span-6">
                                                                <label for="year_n_agency" class="form-label w-full flex flex-col sm:flex-row">Years in Agency </label>
                                                                <input id="year_n_agency" name="year_n_agency" type="text" class="form-control" required autocomplete="on">
                                                            </div>
                    
                                                            <div class="input-form col-span-12 lg:col-span-6">
                                                                <label for="period" class="form-label w-full flex flex-col sm:flex-row">Three-Year Period </label>
                                                                <input id="period" name="period" type="text" class="form-control" required autocomplete="on">
                                                            </div>
                    
                                                            <div class="input-form col-span-12 lg:col-span-6">
                                                                <label for="division" class="form-label w-full flex flex-col sm:flex-row">Division </label>
                                                                <input id="division" name="division" type="text" class="form-control" required autocomplete="on">
                                                            </div>
                    
                                                            <div class="input-form col-span-12 lg:col-span-6">
                                                                <label for="office" class="form-label w-full flex flex-col sm:flex-row">Office </label>
                                                                <input id="office" name="office" type="text" class="form-control" required autocomplete="on">
                                                            </div>
                    
                                                            <div class="input-form col-span-12 lg:col-span-12">
                                                                <label for="check_year" class="form-label w-full flex flex-col sm:flex-row"> No further development is desired or required for this year/s (Please check box here)  </label>
                                                                <input id="check_year" name="check_year" value="1" type="radio" class="ml-5 form-check-input ">
                                                                <label for="check1">Year 1</label> 
                                                                <input id="check_year" name="check_year" value="2" type="radio" class="ml-5 form-check-input">
                                                                <label for="check2">Year 2</label>
                                                                <input id="check_year" name="check_year" value="2" type="radio" class="ml-5 form-check-input">
                                                                <label for="check2">Year 3</label>
                                                            </div>
                    
                                                            <div class="input-form col-span-12 lg:col-span-6">
                                                                <label for="my_supervisor" class="form-label w-full flex flex-col sm:flex-row">  Name of Superior (Last, First, MI)  </label>
                                                                <select id="my_supervisor" name="my_supervisor" style="width: 100%">
                                                                    <option></option>
                                                                    @forelse(load_employee() as $my_supervisor)
                                                                        <option value="{{ $my_supervisor->agencyid }}">{{ $my_supervisor->lastname.', '.$my_supervisor->firstname.' '.$my_supervisor->mi.' '.$my_supervisor->extension}}</option>
                                                                    @empty
                                                                    @endforelse
                                                                </select>
                                                            </div>
                    
                                                            <div class="col-span-12 lg:col-span-12">
                                                                <button type="submit" class="btn btn-outline-primary border-dashed w-full"> <i class="w-4 h-4 mr-2" data-lucide="plus"></i> Create</button>
                                                            </div>
                    
                                                        </div>
                                                    
                                                </div>
                    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <!--End personal Information-->
                        </form>
                    </div>
                </div>

            </div>
            <!-- END: Modal Body -->

        </div>
    </div>
</div>
<!-- END: Super Large Modal Content -->

