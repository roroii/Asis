var  _token = $('meta[name="csrf-token"]').attr('content');
var tbl_data_sem_clearance;
var tbl_data_new_sem_clearance;
var tbl_data_csc_clearance;
var tbl_data_csc_clearance_III;

var tbl_data_my_csc_clearance_III;
var tbl_data_my_csc_clearance_IV;

var tbl_data_created_clearance;

var cleared_checkbox;
var signature_checkbox;

var clearance_status_checkbox;

var state_clearance_id;

$(document).ready(function (){

    bpath = __basepath + "/";

    toggle_create_clearance_modal();

    load_clearance_DataTable();

    load_my_clearance();
    load_clearance_requests();
    create_CSC_Clearance();

    load_admin_created_clearance();


    select2_Instance();

    add_semestral_clearance();
    delete_sem_clearance_table_row();

        // save_created_clearance();

    edit_my_clearance();


    load_Responsibility_Center();
    load_Agency();

    add_csc_clearance_III_tr();
    delete_csc_clearance_iii();

    add_csc_clearance_IV_tr();
    update_csc_clearance_IV();

    create_my_csc_Clearance();

    request_csc_clearance();

    delete_csc_clearance_IV();


    update_my_requested_csc_clearance();


    Clearance_Request_Info();

    admin_approve_dis_approved_Clearance_Request();

    load_my_signatories();

    Signatories_Sign();

    bind_checkbox();


    Recent_Activities('');
    Click_My_Clearance_Table_Row();


    Admin_Update_Clearance_Status();

    Resubmit_My_Clearance_to_Clearing_Officer();

    Load_Important_Notes();
    Add_Important_Notes();
    Remove_Clearance_Important_Notes();
    toggle_modal_Important_Notes();
});

function select2_Instance(){

    $('#recent_clearance_name').select2({
       placeholder: 'Select Clearance',
        allowClear: true,
    });

    $('#created_clearance_select').select2({
       placeholder: 'Select Clearance',
        allowClear: true,
    });

    $('#sem_clearance_signatory_om').select2({
       placeholder: 'Select Signatory',
    });

    $('#clearance_rc').select2({
       placeholder: 'Select Responsibility Center',
    });

    $('#csc_clearance_rc').select2({
       placeholder: 'Select Responsibility Center',
    });

    $('.csc_clearance_pos').select2({
       placeholder: 'Select Position',
    });

    $('#csc_clearance_sg').select2({
       placeholder: 'Select Salary Grade',
    });

    $('#csc_clearance_step').select2({
       placeholder: 'Select Step',
    });

    $('#clearance_type').select2({
       placeholder: 'Select Clearance Type',
    });

    $('#csc_clearance_agency_head').select2({
       placeholder: 'Select Agency Head',
    });

    $('#sem_clearance_rc_om').select2({
       placeholder: 'Select Responsibility Center',
    });

    $('#sem_clearance__approval_signatory_om').select2({
       placeholder: 'Select Employees',
    });

    $('#csc_immediate_supervisor').select2({
       placeholder: 'Select Immediate Supervisor',
    });

    $('#csc_clearance_employees').select2({
        placeholder: 'Select Officers/Officials',
        allowClear: true,
    });

    $('#emp_List').select2({
       placeholder: 'Select Employees',
    });

    $('#grp_List').select2({
       placeholder: 'Select Groups',
    });

    $('#rc__list').select2({
       placeholder: 'Select Responsibility Center',
    });

    $('#csc_clearance_agency_head_V').select2({
    });

    $('#clearance_note_rc').select2({
        placeholder: 'Select Responsibility Center',
        allowClear: true,
    });

    $('#clearance_note_employees').select2({
        placeholder: 'Select Employee',
        allowClear: true,
    });


    $('#clearance_title').hide();
    $('#sem_clearance').hide();
    $('#sem_clearance_approval_signatories').hide();
    $('#csc_clearance_div').hide();

    // $('#clearance_type').on('select2:select', function (e) {
    //
    //     let data =  e.params.data;
    //     let clearance_title =  data['text']
    //
    //
    //     if(clearance_title == 'Semestral Clearance')
    //     {
    //         $('#clearance_title').text(clearance_title);
    //         $('#sem_clearance').show();
    //         $('#sem_clearance_approval_signatories').show();
    //         $('#clearance_title').show();
    //
    //         $('#sem_clearance_div').show();
    //         $('#csc_clearance_div').hide();
    //
    //     }else
    //     {
    //         // $('#clearance_title').text(clearance_title);
    //         $('#sem_clearance').hide();
    //         $('#sem_clearance_approval_signatories').hide();
    //         // $('#clearance_title').show();
    //
    //
    //         $('#sem_clearance_div').hide();
    //         $('#csc_clearance_div').show();
    //     }
    //
    // });

    $('#csc_clearance_sg').on('select2:select', function (e) {

        let sg_id = $(this).val();

        $.ajax({
            url: bpath + 'clearance/get/sg/step',
            type: "POST",
            data: { _token, sg_id },
            success: function (response) {
                if(response)
                {
                    let data = JSON.parse(response);

                    let sg_step_options = data['sg_step_options'];

                    $('#csc_clearance_step').html(sg_step_options);
                }
            }
        });

    });

}




function load_Responsibility_Center(){

    $.ajax({
        url: bpath + 'clearance/get/rc',
        type: "POST",
        data: {
            _token: _token,
        },
        success: function (response) {
            if(response)
            {
                let data = JSON.parse(response);

                let rc_id = data['rc_id'];
                let immediate_head = data['immediate_head'];
                let position_option = data['position_option'];

                $('#clearance_rc').val(rc_id).trigger('change');
                $('#csc_clearance_rc').val(rc_id).trigger('change');

                $('#csc_immediate_supervisor').html(immediate_head);

                $('.csc_clearance_pos').html(position_option);

            }
        }
    });
}
function load_Agency(){

    $.ajax({
        url: bpath + 'clearance/get/agency',
        type: "POST",
        data: {
            _token: _token,
        },
        success: function (response) {
            if(response)
            {
                let data = JSON.parse(response);

                let agency = data['agency'];

                $('.title_div').text(agency+' Clearance Form');
                $('.agency_id').text(agency);

            }
        }
    });
}




function load_clearance_DataTable(){

    try{
        /***/
        tbl_data_sem_clearance = $('#dt__sem_clearance').DataTable({
            dom:
                "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-6 text_left_1'l><'intro-y col-span-6 text_left_1'f>>" +
                "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-12'tr>>" +
                "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-12'<'datatable_paging_1'p>>>",
            renderer: 'bootstrap',
            "info": false,
            "bInfo":true,
            "bJQueryUI": true,
            "bProcessing": true,
            "bPaginate" : true,
            "aLengthMenu": [[10,25,50,100,150,200,250,300,-1], [10,25,50,100,150,200,250,300,"All"]],
            "iDisplayLength": 10,
            "aaSorting": [],

            columnDefs:
                [
                    { className: "dt-head-center", targets: [ 2 ] },
                ],
        });

        /***/
    }catch(err){  }

    try{
        /***/
        tbl_data_csc_clearance_III = $('#dt__csc_clearance_III').DataTable({
            dom:
                "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-6 text_left_1'l><'intro-y col-span-6 text_left_1'f>>" +
                "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-12'tr>>" +
                "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-12'<'datatable_paging_1'p>>>",
            renderer: 'bootstrap',
            "info": false,
            "bInfo":true,
            "bJQueryUI": true,
            "bProcessing": true,
            "bPaginate" : true,
            "aLengthMenu": [[10,25,50,100,150,200,250,300,-1], [10,25,50,100,150,200,250,300,"All"]],
            "iDisplayLength": 10,
            "aaSorting": [],

            columnDefs:
                [
                    { className: "dt-head-center", targets: [ 0, 1, 2, 3, 4 ] },
                ],
        });

        /***/
    }catch(err){  }


    //My CSC III Clearance DataTable
    try{
        /***/
        tbl_data_my_csc_clearance_III = $('#dt_my_csc_clearance_III').DataTable({
            dom:
                "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-6 text_left_1'l><'intro-y col-span-6 text_left_1'f>>" +
                "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-12'tr>>" +
                "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-12'<'datatable_paging_1'p>>>",
            renderer: 'bootstrap',
            "info": false,
            "bInfo":true,
            "bJQueryUI": true,
            "bProcessing": true,
            "bPaginate" : true,
            "aLengthMenu": [[10,25,50,100,150,200,250,300,-1], [10,25,50,100,150,200,250,300,"All"]],
            "iDisplayLength": 10,
            "aaSorting": [],

            columnDefs:
                [
                    { className: "dt-head-center", targets: [ 1, 2, 3 ] },
                ],
        });

        /***/
    }catch(err){  }
    //My CSC III Clearance DataTable



    //My CSC IV Clearance DataTable
    try{
        /***/
        tbl_data_my_csc_clearance_IV = $('#dt_my_csc_clearance_IV').DataTable({
            dom:
                "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-6 text_left_1'l><'intro-y col-span-6 text_left_1'f>>" +
                "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-12'tr>>" +
                "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-12'<'datatable_paging_1'p>>>",
            renderer: 'bootstrap',
            "info": false,
            "bInfo":true,
            "bJQueryUI": true,
            "bProcessing": true,
            "bPaginate" : true,
            "aLengthMenu": [[10,25,50,100,150,200,250,300,-1], [10,25,50,100,150,200,250,300,"All"]],
            "iDisplayLength": 10,
            "aaSorting": [],

            columnDefs:
                [
                    { className: "dt-head-center", targets: [ 1, 2, 3 ] },
                ],
        });

        /***/
    }catch(err){  }
    //My CSC IV Clearance DataTable


    //Civil Service Clearance DataTable
    try{
        /***/
        tbl_data_csc_clearance = $('#dt_csc_clearance').DataTable({
            dom:
                "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-6 text_left_1'l><'intro-y col-span-6 text_left_1'f>>" +
                "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-12'tr>>" +
                "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-12'<'datatable_paging_1'p>>>",
            renderer: 'bootstrap',
            "info": false,
            "bInfo":true,
            "bJQueryUI": true,
            "bProcessing": true,
            "bPaginate" : true,
            "aLengthMenu": [[10,25,50,100,150,200,250,300,-1], [10,25,50,100,150,200,250,300,"All"]],
            "iDisplayLength": 10,
            "aaSorting": [],

            columnDefs:
                [
                    { className: "dt-head-center", targets: [ 2, 3 ] },
                ],
        });

        /***/
    }catch(err){  }
    //Civil Service Clearance DataTable


    //ADMIN Created Clearance DataTable
    try{
        /***/
        tbl_data_created_clearance = $('#dt_created_csc_clearance').DataTable({
            dom:
                "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-6 text_left_1'l><'intro-y col-span-6 text_left_1'f>>" +
                "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-12'tr>>" +
                "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-12'<'datatable_paging_1'p>>>",
            renderer: 'bootstrap',
            "info": false,
            "bInfo":true,
            "bJQueryUI": true,
            "bProcessing": true,
            "bPaginate" : true,
            "aLengthMenu": [[10,25,50,100,150,200,250,300,-1], [10,25,50,100,150,200,250,300,"All"]],
            "iDisplayLength": 10,
            "aaSorting": [],

            columnDefs:
                [
                    { className: "dt-head-center", targets: [ 2, 3 ] },
                ],
        });

        /***/
    }catch(err){  }

    //Semestral Clearance DataTable
    try{
        /***/
        tbl_data_new_sem_clearance = $('#dt_sem_clearance').DataTable({
            dom:
                "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-6 text_left_1'l><'intro-y col-span-6 text_left_1'f>>" +
                "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-12'tr>>" +
                "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-12'<'datatable_paging_1'p>>>",
            renderer: 'bootstrap',
            "info": false,
            "bInfo":true,
            "bJQueryUI": true,
            "bProcessing": true,
            "bPaginate" : true,
            "aLengthMenu": [[10,25,50,100,150,200,250,300,-1], [10,25,50,100,150,200,250,300,"All"]],
            "iDisplayLength": 10,
            "aaSorting": [],

            columnDefs:
                [
                    { className: "dt-head-center", targets: [ 2, 3 ] },
                ],
        });

        /***/
    }catch(err){  }
    //Semestral Clearance DataTable

}
function load_my_clearance(){

    $.ajax({
        url: bpath + 'clearance/load/my/clearance',
        type: "POST",
        data: {
            _token: _token,
        },
        success: function (response) {

            tbl_data_csc_clearance.clear().draw();
            /***/

            var data = JSON.parse(response);

            if (data.length > 0) {
                for (var i = 0; i < data.length; i++) {

                    let clearance_id = data[i]['clearance_id'];
                    let clearance_name = data[i]['clearance_name'];
                    let clearance_description = data[i]['clearance_description'];
                    let clearance_created_by = data[i]['clearance_created_by'];
                    let my_rc = data[i]['my_rc'];
                    let rc = data[i]['rc'];
                    let clearance_type = data[i]['clearance_type'];
                    let clearance_type_id = data[i]['clearance_type_id'];
                    let can_print = data[i]['can_print'];
                    let can_write = data[i]['can_write'];
                    let can_create = data[i]['can_create'];
                    let can_delete = data[i]['can_delete'];
                    let has_requested = data[i]['has_requested'];
                    let is_approved = data[i]['is_approved'];
                    let is_admin = data[i]['is_admin'];
                    let active_clearance = data[i]['active_clearance'];
                    let print_button = '';
                    let admin_edit_csc_button = '';
                    let edit_my_csc_button = '';
                    let delete_button = '';
                    let request_button = '';
                    let action_done = '';
                    let status = '';


                    if (can_print) {
                        print_button += '<a id="btn_print_clearance" href="/clearanceSignatories/csc/print/' + clearance_id + '" target="_blank" class="dropdown-item"><i class="fa-solid fa-print w-4 h-4 mr-2 text-success"></i> Print </a>';
                    } else {
                        print_button = '';
                    }

                    if (can_write) {
                        edit_my_csc_button += '<a id="btn_edit_my_csc_clearance" data-clearanceSignatories-id="' + clearance_id + '" href="javascript:;" class="dropdown-item"><i class="fa fa-pen-to-square w-4 h-4 mr-2 text-success"></i> Edit</a>';
                    } else {
                        edit_my_csc_button = '';
                    }

                    if (is_admin && active_clearance == '0') {
                        admin_edit_csc_button += '<a id="btn_unable_edit_my_clearance" ' +
                            '   data-clearanceSignatories-type     = "' + clearance_type + '"' +
                            '   data-clearanceSignatories-type-id  = "' + clearance_type_id + '" ' +
                            '   data-clearanceSignatories-id       = "' + clearance_id + '" ' +
                            '   data-clearanceSignatories-my-rc    = "' + my_rc + '" ' +
                            '   data-clearanceSignatories-rc       = "' + rc + '"' +
                            '   data-clearanceSignatories-name     = "' + clearance_name + '"' +
                            '   data-clearanceSignatories-desc     = "' + clearance_description + '"' +
                            '   href="javascript:;" class="dropdown-item">' +
                            '   <i class="fa fa-pen-to-square w-4 h-4 mr-2 text-secondary"></i> Admin Edit  </a>';

                    }
                    else  if (is_admin && active_clearance == '1') {
                        admin_edit_csc_button += '<a id="btn_edit_my_clearance" ' +
                            '   data-clearanceSignatories-type     = "' + clearance_type + '"' +
                            '   data-clearanceSignatories-type-id  = "' + clearance_type_id + '" ' +
                            '   data-clearanceSignatories-id       = "' + clearance_id + '" ' +
                            '   data-clearanceSignatories-my-rc    = "' + my_rc + '" ' +
                            '   data-clearanceSignatories-rc       = "' + rc + '"' +
                            '   data-clearanceSignatories-name     = "' + clearance_name + '"' +
                            '   data-clearanceSignatories-desc     = "' + clearance_description + '"' +
                            '   href="javascript:;" class="dropdown-item">' +
                            '   <i class="fa fa-pen-to-square w-4 h-4 mr-2 text-success"></i> Admin Edit  </a>';

                    } else {
                        admin_edit_csc_button = '';
                    }

                    if (has_requested == true && is_approved == 'Pending') {

                        request_button += '<a id="btn_csc_request_info" data-clearanceSignatories-id="' + clearance_id + '" href="javascript:;" class="dropdown-item"> <i class="fa-solid fa-circle-info w-4 h-4 mr-2 text-warning"></i> Info </a>';

                    }
                    else if (has_requested == true && is_approved == false) {

                        request_button += '<a id="btn_csc_request_info_disapproved" data-clearanceSignatories-id="' + clearance_id + '" href="javascript:;" class="dropdown-item"> <i class="fa-solid fa-circle-info w-4 h-4 mr-2 text-danger"></i> Info </a>';

                    }
                    else if (has_requested == true && is_approved == true) {

                        edit_my_csc_button += '<a id="btn_edit_my_csc_clearance" data-clearanceSignatories-id="' + clearance_id + '" href="javascript:;" class="dropdown-item"><i class="fa fa-pen-to-square w-4 h-4 mr-2 text-success"></i> Edit</a>';
                        print_button += '<a id="btn_print_clearance" href="/clearanceSignatories/csc/print/' + clearance_id + '" target="_blank" class="dropdown-item"><i class="fa-solid fa-print w-4 h-4 mr-2 text-success"></i> Print </a>';

                    }
                    else if (has_requested == false)
                    {
                        request_button += '<a id="btn_request_csc_clearance" data-clearanceSignatories-id="' + clearance_id + '" href="javascript:;" class="dropdown-item"> <i class="fa-solid fa-paper-plane w-4 h-4 mr-2 text-primary"></i> Request </a>';

                    }

                    if(active_clearance == '1')
                    {
                        clearance_status_checkbox = 1;
                        action_done = '<div  class="w-2 h-2 flex items-center justify-center text-xs text-white rounded-full bg-success font-medium"></div>';
                        status +=
                            '<div class="flex justify-center items-center btn_clearance_status" data-privilege="'+is_admin+'" data-status="1" data-clearanceSignatories-id="'+ clearance_id +'">' +
                            '   <div class="flex items-center text-center whitespace-nowrap text-success">' +
                            '       <div class="w-2 h-2 bg-success rounded-full mr-3"></div>' +
                            '       <a id="btn_my_docs_status" href="javascript:;" class="">Active</a>' +
                            '   </div>' +
                            '</div>';



                    }else if(active_clearance == '0')
                    {
                        clearance_status_checkbox = 0;
                        action_done = '<div  class="w-2 h-2 flex items-center justify-center text-xs text-white rounded-full bg-danger font-medium"></div>';
                        status +=
                            '<div class="flex justify-center items-center btn_clearance_status" data-privilege="'+is_admin+'" data-status="0" data-clearanceSignatories-id="'+ clearance_id +'">' +
                            '   <div class="flex items-center text-center whitespace-nowrap text-danger">' +
                            '       <div class="w-2 h-2 bg-danger rounded-full mr-3"></div>' +
                            '       <a id="btn_my_docs_status" href="javascript:;" class="">In-Active</a>' +
                            '   </div>' +
                            '</div>';

                    }

                    var cd = "";
                    /***/

                    cd = '' +
                        '<tr data-clearanceSignatories-id="'+clearance_id+'" class="cursor-pointer intro-x">' +
                        '   <td class="text-justify my_clearance_tr">'+clearance_name+'</td>' +
                        '   <td class="text-justify my_clearance_tr">'+clearance_description+'</td>' +
                        '   <td >'+status+'</td>' +
                        '   <td>' +
                        '       <section>'+
                        '           <div style="float: right;">'+action_done +'</div>'+
                        '               <div class="flex justify-center items-center">'+
                        '                   <div id="csc_clearance_list_dd" class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 text-slate-400 zoom-in tooltip dropdown" title="More Action">'+
                        '                   <a class="flex justify-center items-center" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h items-center text-center text-primary"></i> </a>'+
                        '                   <div class="dropdown-menu w-40">'+
                        '                       <div class="dropdown-content">'+
                                                    edit_my_csc_button+
                                                    request_button+
                                                    print_button+
                        '                       </div>'+
                        '                   </div>'+
                        '            </div>'+
                        '       </div>'+
                        '   </td>' +
                        '</tr>'+
                        '';

                    tbl_data_csc_clearance.row.add($(cd)).draw();
                    /***/

                }
            }
        }
    });
}
function create_CSC_Clearance(){

    $('body').on('click', '#btn_create_csc_clearance', function (){

        let form_data = {
            _token,
            clearance_name : $('#clearance_name').val(),
            clearance_desc : $('#clearance_desc').val(),
            clearance_id : $('#clearance_id').val(),
        }

        $.ajax({
            url: bpath + 'clearance/update/created/csc',
            type: "POST",
            data: form_data,
            success: function (response) {
                if (response) {

                    let data = JSON.parse(response);
                    let status = data['status'];

                    if (status == 200) {

                        __modal_hide('add_clearance_modal');
                        __notif_show(1, 'Success', 'Clearance Saved Successfully!');
                    }
                }
            }
        });

    });

}

//For Admin - LOAD CREATED CLEARANCE
function load_admin_created_clearance(){

    $.ajax({
        url: bpath + 'clearance/load/my/clearance',
        type: "POST",
        data: {
            _token: _token,
        },
        success: function (response) {

            tbl_data_created_clearance.clear().draw();
            /***/

            var data = JSON.parse(response);

            if (data.length > 0) {
                for (var i = 0; i < data.length; i++) {

                    let clearance_id = data[i]['clearance_id'];
                    let clearance_name = data[i]['clearance_name'];
                    let clearance_description = data[i]['clearance_description'];
                    let clearance_created_by = data[i]['clearance_created_by'];
                    let my_rc = data[i]['my_rc'];
                    let rc = data[i]['rc'];
                    let clearance_type = data[i]['clearance_type'];
                    let clearance_type_id = data[i]['clearance_type_id'];
                    let can_print = data[i]['can_print'];
                    let can_write = data[i]['can_write'];
                    let can_create = data[i]['can_create'];
                    let can_delete = data[i]['can_delete'];
                    let has_requested = data[i]['has_requested'];
                    let is_approved = data[i]['is_approved'];
                    let is_admin = data[i]['is_admin'];
                    let active_clearance = data[i]['active_clearance'];
                    let print_button = '';
                    let admin_edit_csc_button = '';
                    let edit_my_csc_button = '';
                    let delete_button = '';
                    let request_button = '';
                    let action_done = '';
                    let status = '';
                    let state = '';


                    if (can_print) {
                        print_button += '<a id="btn_print_clearance" href="/clearanceSignatories/csc/print/' + clearance_id + '" target="_blank" class="dropdown-item"><i class="fa-solid fa-print w-4 h-4 mr-2 text-success"></i> Print </a>';
                    } else {
                        print_button = '';
                    }

                    if (can_write) {
                        edit_my_csc_button += '<a id="btn_edit_my_csc_clearance" data-clearanceSignatories-id="' + clearance_id + '" href="javascript:;" class="dropdown-item"><i class="fa fa-pen-to-square w-4 h-4 mr-2 text-success"></i> Edit</a>';
                    } else {
                        edit_my_csc_button = '';
                    }

                    if (is_admin && active_clearance == '0') {
                        admin_edit_csc_button += '<a id="btn_unable_edit_my_clearance" ' +
                            '   data-clearanceSignatories-type     = "' + clearance_type + '"' +
                            '   data-clearanceSignatories-type-id  = "' + clearance_type_id + '" ' +
                            '   data-clearanceSignatories-id       = "' + clearance_id + '" ' +
                            '   data-clearanceSignatories-my-rc    = "' + my_rc + '" ' +
                            '   data-clearanceSignatories-rc       = "' + rc + '"' +
                            '   data-clearanceSignatories-name     = "' + clearance_name + '"' +
                            '   data-clearanceSignatories-desc     = "' + clearance_description + '"' +
                            '   href="javascript:;" class="dropdown-item">' +
                            '   <i class="fa fa-pen-to-square w-4 h-4 mr-2 text-secondary"></i> Edit  </a>';

                    } else  if (is_admin && active_clearance == '1') {
                        admin_edit_csc_button += '<a id="btn_edit_my_clearance" ' +
                            '   data-clearanceSignatories-type     = "' + clearance_type + '"' +
                            '   data-clearanceSignatories-type-id  = "' + clearance_type_id + '" ' +
                            '   data-clearanceSignatories-id       = "' + clearance_id + '" ' +
                            '   data-clearanceSignatories-my-rc    = "' + my_rc + '" ' +
                            '   data-clearanceSignatories-rc       = "' + rc + '"' +
                            '   data-clearanceSignatories-name     = "' + clearance_name + '"' +
                            '   data-clearanceSignatories-desc     = "' + clearance_description + '"' +
                            '   href="javascript:;" class="dropdown-item">' +
                            '   <i class="fa fa-pen-to-square w-4 h-4 mr-2 text-success"></i> Edit  </a>';

                    } else {
                        admin_edit_csc_button = '';
                    }

                    if (has_requested == true && is_approved == 'Pending') {

                        request_button += '<a id="btn_csc_request_info" data-clearanceSignatories-id="' + clearance_id + '" href="javascript:;" class="dropdown-item"> <i class="fa-solid fa-circle-info w-4 h-4 mr-2 text-warning"></i> Info </a>';

                    } else if (has_requested == true && is_approved == false) {

                        request_button += '<a id="btn_csc_request_info_disapproved" data-clearanceSignatories-id="' + clearance_id + '" href="javascript:;" class="dropdown-item"> <i class="fa-solid fa-circle-info w-4 h-4 mr-2 text-danger"></i> Info </a>';

                    }else if (has_requested == true && is_approved == true) {

                        edit_my_csc_button += '<a id="btn_edit_my_csc_clearance" data-clearanceSignatories-id="' + clearance_id + '" href="javascript:;" class="dropdown-item"><i class="fa fa-pen-to-square w-4 h-4 mr-2 text-success"></i> Edit</a>';
                        print_button += '<a id="btn_print_clearance" href="/clearanceSignatories/csc/print/' + clearance_id + '" target="_blank" class="dropdown-item"><i class="fa-solid fa-print w-4 h-4 mr-2 text-success"></i> Print </a>';

                    }else if (has_requested == false)
                    {
                        request_button += '<a id="btn_request_csc_clearance" data-clearanceSignatories-id="' + clearance_id + '" href="javascript:;" class="dropdown-item"> <i class="fa-solid fa-paper-plane w-4 h-4 mr-2 text-primary"></i> Request </a>';

                    }

                    if(active_clearance == '1')
                    {
                        clearance_status_checkbox = 1;
                        action_done = '<div  class="w-2 h-2 flex items-center justify-center text-xs text-white rounded-full bg-success font-medium"></div>';
                        status +=
                            '<div class="flex justify-center items-center btn_clearance_status" data-privilege="'+is_admin+'" data-status="1" data-clearanceSignatories-id="'+ clearance_id +'">' +
                            '   <div class="flex items-center text-center whitespace-nowrap text-success">' +
                            '       <div class="w-2 h-2 bg-success rounded-full mr-3"></div>' +
                            '       <a id="btn_my_docs_status" href="javascript:;" class="">Active</a>' +
                            '   </div>' +
                            '</div>';

                        state +=
                            ' <div class="form-check form-switch justify-center" data-privilege="'+is_admin+'" data-status="1" data-clearanceSignatories-id="'+ clearance_id +'">' +
                            '   <input class="form-check-input btn_check_state" data-clearanceSignatories-id="'+ clearance_id +'" checked type="checkbox">' +
                            '   <label class="form-check-label ml-3 state_switch_label" for="checkbox-switch-7">Open</label>' +
                            ' </div>';



                    }else if(active_clearance == '0')
                    {
                        clearance_status_checkbox = 0;
                        action_done = '<div  class="w-2 h-2 flex items-center justify-center text-xs text-white rounded-full bg-danger font-medium"></div>';
                        status +=
                            '<div class="flex justify-center items-center btn_clearance_status" data-privilege="'+is_admin+'" data-status="0" data-clearanceSignatories-id="'+ clearance_id +'">' +
                            '   <div class="flex items-center text-center whitespace-nowrap text-danger">' +
                            '       <div class="w-2 h-2 bg-danger rounded-full mr-3"></div>' +
                            '       <a id="btn_my_docs_status" href="javascript:;" class="">In-Active</a>' +
                            '   </div>' +
                            '</div>';

                        state +=
                            ' <div class="form-check form-switch justify-center" data-privilege="'+is_admin+'" data-status="1" data-clearanceSignatories-id="'+ clearance_id +'">' +
                            '   <input class="form-check-input btn_check_state" data-clearanceSignatories-id="'+ clearance_id +'" type="checkbox">' +
                            '   <label class="form-check-label ml-3 state_switch_label" for="checkbox-switch-7">Closed</label>' +
                            ' </div>';
                    }

                    var cd = "";
                    /***/

                    cd = '' +
                        '<tr data-clearanceSignatories-id="'+clearance_id+'" class="cursor-pointer intro-x">' +
                        '   <td class="text-justify my_clearance_tr">'+clearance_name+'</td>' +
                        '   <td class="text-justify my_clearance_tr">'+clearance_description+'</td>' +
                        '   <td >'+status+'</td>' +
                        '   <td >'+state+'</td>' +
                        '   <td>' +
                        '       <section>'+
                        '           <div style="float: right;">'+action_done +'</div>'+
                        '               <div class="flex justify-center items-center">'+
                        '                   <div id="csc_clearance_list_dd" class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 text-slate-400 zoom-in tooltip dropdown" title="More Action">'+
                        '                   <a class="flex justify-center items-center" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h items-center text-center text-primary"></i> </a>'+
                        '                   <div class="dropdown-menu w-40">'+
                        '                       <div class="dropdown-content">'+
                                                    admin_edit_csc_button+
                        '                       </div>'+
                        '                   </div>'+
                        '            </div>'+
                        '       </div>'+
                        '   </td>' +
                        '</tr>'+
                        '';

                    tbl_data_created_clearance.row.add($(cd)).draw();
                    /***/

                }
            }
        }
    });
}
//For Admin - LOAD CREATED CLEARANCE


function load_clearance_requests(){

    $.ajax({
        url: bpath + 'clearance/load/admin/requests',
        type: "POST",
        data: {
            _token: _token,
        },
        success: function (response) {
            if(response)
            {
                let data = JSON.parse(response);
                let request_html_data = data['request_html_data'];
                let default_html_data = '';

                if(request_html_data)
                {
                    $('.clearance_request_list_div').html(request_html_data);
                }else
                {
                    default_html_data =
                        '<div class="intro-x">' +
                        '       <div class="box px-5 py-3 mb-3 flex items-center zoom-in">' +
                        '           <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">' +
                        '               <img alt="Profile Picture" src="/dist/images/empty.webp">' +
                        '           </div>' +
                        '           <div class="ml-4 mr-auto">' +
                        '           <div class="font-medium">No Request Found!</div>' +
                        '               <div class="text-slate-500 text-xs mt-0.5"></div>' +
                        '           </div>' +
                        '   </div>' +
                        '</div>';

                    $('.clearance_request_list_div').html(default_html_data);

                }

            }
        }
    });
}






function toggle_create_clearance_modal(){

    $('body').on('click', '#btn_toggle_create_clearance_mdl', function (){

        const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#add_clearance_modal'));
        mdl.toggle();

        $('#btn_create_clearance').hide();
        $('.clearance_mdl_footer').hide();

        $('.csc_clearance_div').hide();

        $('#mdl_btn_create_new_clearance').show();

        $('#clearance_name').val('');
        $('#clearance_desc').val('');
        $('#clearance_type').val('').trigger('change');
        $('#clearance_type').prop('disabled', false);

    });

    $('#clearance_type').on('keydown', function() {

        $('#clearance_type').removeClass('border-danger');
    });

    $('#clearance_rc').on('keydown', function() {

        $('#clearance_rc').removeClass('border-danger');
    });

    $('#clearance_name').on('keydown', function() {

        $('#clearance_name').removeClass('border-danger');
    });

    $('#clearance_desc').on('keydown', function() {

        $('#clearance_desc').removeClass('border-danger');
    });


    $('body').on('click', '#btn_toggle_add_signatory_mdl', function (){

        const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#add_signatory_mdl'));
        mdl.toggle();

    });

    $('body').on('click', '#mdl_btn_create_new_clearance', function (){

        if($('#clearance_type').val() == '' || $('#clearance_type').val()== null)
        {
            $('#clearance_type').addClass('border-danger');
            __notif_show(-1, 'Warning', 'Please dont leave blank, N/A if not applicable!');

        }else if($('#clearance_name').val() == '' || $('#clearance_name').val()== null)
        {
            $('#clearance_name').addClass('border-danger');
            __notif_show(-1, 'Warning', 'Please dont leave blank, N/A if not applicable!');

        }else if($('#clearance_desc').val() == '' || $('#clearance_desc').val()== null)
        {
            $('#clearance_desc').addClass('border-danger');
            __notif_show(-1, 'Warning', 'Please dont leave blank, N/A if not applicable!');

        }else
        {
            save_to_db_created_clearance();
        }

    });


    $('body').on('click', '.btn_cancel_edit_modal', function (){

        $('#csc_clearance_div').hide();
    });


}
function save_to_db_created_clearance(){

    let form_data = {
        _token,

        clearance_type  : $('#clearance_type').val(),
        clearance_rc    : $('#clearance_rc').val(),
        clearance_name  : $('#clearance_name').val(),
        clearance_desc  : $('#clearance_desc').val(),

    }
    $.ajax({
        url: bpath + 'clearance/create/new/updated',
        type: "POST",
        data: form_data,
        success: function (response) {
            if(response)
            {
                let data = JSON.parse(response);
                let status = data['status'];
                let clearance_id = data['clearance_id'];

                if(status == 200)
                {
                    __notif_show(1, 'Success', 'Created successfully!');
                    load_my_clearance();

                    $('#clearance_id').val(clearance_id);
                    $('.csc_clearance_div').show();
                    $('#btn_create_clearance').show();
                    $('#mdl_btn_create_new_clearance').hide();
                    $('.clearance_mdl_footer').show();

                    load_admin_created_clearance();

                }else
                {
                    __notif_show(-1, 'Warning', 'Something went wrong!');
                }
            }
        }
    });

}
function clear_clearance_header_inputs(){

    $('#clearance_type').val('');
    $('#clearance_rc').val('');
    $('#clearance_name').val('');
    $('#clearance_desc').val('');

}






function edit_my_clearance(){

    $('body').on('click', '#btn_edit_my_clearance', function (){



        let clearance_type_id = $(this).data('clearanceSignatories-type-id');
        let clearance_type = $(this).data('clearanceSignatories-type');
        let clearance_id = $(this).data('clearanceSignatories-id');
        let clearance_rc = $(this).data('clearanceSignatories-rc');
        let clearance_my_rc = $(this).data('clearanceSignatories-my-rc');
        let clearance_name = $(this).data('clearanceSignatories-name');
        let clearance_desc = $(this).data('clearanceSignatories-desc');

        const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#add_clearance_modal'));
        mdl.toggle();

        __dropdown_close('#csc_clearance_list_dd');

        $('#mdl_btn_create_new_clearance').hide();
        $('#clearance_type').prop("disabled", true);
        $('#clearance_type').val(clearance_type_id).trigger('change');
        $('#clearance_rc').val(clearance_my_rc).trigger('change');
        $('#clearance_name').val(clearance_name);
        $('#clearance_desc').val(clearance_desc);
        $('#clearance_id').val(clearance_id);


        if(clearance_type == 'Civil Service Clearance Form')
        {
            $('#sem_clearance_div').hide();
            $('.csc_clearance_div').show();
            load_csc_clearance_III();
            load_csc_clearance_IV();

            $('.clearance_mdl_footer').show();

        }else if(clearance_type == 'Semestral Clearance Form')
        {
            $('#sem_clearance_div').show();
            $('.csc_clearance_div').hide();
        }



        $.ajax({
            url: bpath + 'clearance/load/csc/information',
            type: "POST",
            data: { _token, clearance_id},
            success: function (response) {
                if(response)
                {
                    let data = JSON.parse(response);

                    let purpose = data['purpose'];
                    let purpose_others = data['purpose_others'];
                    let date_filing = data['date_filing'];
                    let date_effective = data['date_effective'];
                    let rc = data['rc'];
                    let position = data['position'];
                    let sg = data['sg'];
                    let step = data['step'];
                    let cleared = data['cleared'];
                    let immediate_supervisor = data['immediate_supervisor'];

                    let emp_case = data['emp_case'];

                   if(purpose == 'Transfer')
                   {
                       $('#modal_Transfer').prop('checked', true);

                   }else if(purpose == 'Resignation')
                   {
                       $('#modal_Resignation').prop('checked', true);

                   }else if(purpose == 'Retirement')
                   {
                       $('#modal_Retirement').prop('checked', true);

                   }else if(purpose == 'Leave')
                   {
                       $('#modal_Leave').prop('checked', true);

                   }else if(purpose == 'Others')
                   {
                       $('#modal_others').prop('checked', true);
                       $('#others_mode_sep_div').show();
                       $('#others_mode_sep').val(purpose_others);
                   }

                    $('#csc_clearance_rc').val(rc).trigger('change');

                    $('#csc_clearance_sg').val(sg).trigger('change');
                    $('#csc_clearance_step').val(step).trigger('change');


                    if(cleared == '0')
                    {
                        $('#radio_switch_un_cleared').prop('checked', true);

                    }else if(cleared == '1')
                    {
                        $('#radio_switch_cleared').prop('checked', true);

                    }

                    if(emp_case == '0')
                    {
                        $('#radio_switch_ongoing_case').prop('checked', true);

                    }else if(emp_case == '1')
                    {
                        $('#radio_switch_pending_case').prop('checked', true);

                    }

                    $('#date_filing').val(date_filing);
                    $('#date_effective').val(date_effective);

                }
            }
        });
    });

    $('body').on('click', '.update_III_clearance', function (){

        let csc_iii_id          = $(this).data('iii-clearanceSignatories-id');
        let csc_iii_type        = $(this).data('iii-clearanceSignatories-type');
        let csc_iii_office      = $(this).data('iii-unit-office');
        let csc_iii_cleared     = $(this).data('iii-cleared');
        let csc_iii_not_cleared = $(this).data('iii-not-cleared');
        let csc_iii_officer_id  = $(this).data('iii-officer-id');


        __modal_toggle('add_csc_clearance_III_modal');

        $('.csc_iii_recent_setup_div').hide();
        $('.csc_iv_recent_setup_div').hide();
        $('.csc_name_recent_setup_div').hide();

        $('#mdl_btn_save_csc_clearance_III_tr').hide();
        $('#mdl_btn_update_csc_clearance_III_tr').show();

        $('#csc_iii_input_id').val(csc_iii_id);
        $('#csc_clearance_office_type').val(csc_iii_type);
        $('#csc_clearance_unit_office_name').val(csc_iii_office);
        $('#csc_clearance_employees').val(csc_iii_officer_id).trigger('change');

        $('#csc_clearance_iii_div').show();
        $('#csc_clearance_iv_div').hide();
        $('#mdl_btn_save_csc_clearance_IV_tr').hide();
        $('#mdl_btn_update_csc_clearance_IV_tr').show();

        $('.add_csc_clearance_signatories').text('III. CLEARANCE FROM MONEY AND PROPERTY ACCOUNTABILITIES');


    });

    $('body').on('click', '#mdl_btn_update_csc_clearance_III_tr', function (){


        let form_data = {

            _token,
            csc_iii_id                      : $('#csc_iii_input_id').val(),
            csc_clearance_office_type       : $('#csc_clearance_office_type').val(),
            csc_clearance_unit_office_name  : $('#csc_clearance_unit_office_name').val(),
            csc_clearance_employees         : $('#csc_clearance_employees').val(),

        }

        $.ajax({
            url: bpath + 'clearance/update/csc/iii',
            type: "POST",
            data: form_data,
            success: function (response) {
                if (response)
                {
                    let data = JSON.parse(response);
                    let status = data['status'];

                    if(status == 200)
                    {
                        __notif_show(1, 'Success', 'Updated successfully!');

                        const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#add_csc_clearance_III_modal'));
                        mdl.hide();
                        load_csc_clearance_III();
                    }
                }
            }
        });
    });
}
function load_csc_clearance_III(){

    let clearance_id = $('#clearance_id').val();

    $.ajax({
        url: bpath + 'clearance/load/csc/iii',
        type: "POST",
        data: { _token,  clearance_id},
        success: function (response) {
            if (response) {

                let data = JSON.parse(response);
                let clearance_III_data = data['clearance_III'];

                // if(clearance_III_data)
                // {
                //     $('.recent_setup_btn_div').hide();
                // }else
                // {
                //     $('.recent_setup_btn_div').show();
                // }

                $('.recent_setup_btn_div').show();

                $('.dt__csc_clearance_III tbody tr').detach();
                $('.dt__csc_clearance_III tbody').append(clearance_III_data);
            }
        }
    });
}
function add_csc_clearance_III_tr(){

    $('#csc_clearance_office_type').on('keydown', function() {

        $('#csc_clearance_office_type').removeClass('border-danger');
    });

    $('#csc_clearance_unit_office_name').on('keydown', function() {

        $('#csc_clearance_unit_office_name').removeClass('border-danger');
    });

    $('body').on('click', '#add_csc_clearance_III_tr', function (){

        const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#add_csc_clearance_III_modal'));
        mdl.toggle();

        $('#csc_clearance_iii_div').show();
        $('#csc_clearance_iv_div').hide();

        $('.csc_name_recent_setup_div').hide();
        $('.btn_use_recent_setup_csc_iv').hide();
        $('.btn_use_recent_setup_csc').show();

        $('.csc_iii_recent_setup_div').hide();
        $('.csc_iv_recent_setup_div').hide();
        $('.csc_iii_inputs_div').show();

        $('.add_csc_clearance_signatories').text('III. CLEARANCE FROM MONEY AND PROPERTY ACCOUNTABILITIES');

        $('#mdl_btn_save_csc_clearance_III_tr').show();
        $('#mdl_btn_update_csc_clearance_III_tr').hide();

        let clearance_type = 'CSC_III';
        $('#csc_clearance_type').val(clearance_type);

        clear_modal_inputs_clearance_III();


    });





    $('body').on('click', '#mdl_btn_save_csc_clearance_III_tr', function (){

        save_to_db_csc_clearance_III_IV();

    });

}
function save_to_db_csc_clearance_III_IV(){

    if($('#csc_clearance_office_type').val() == '' || $('#csc_clearance_office_type').val()== null)
    {
        $('#csc_clearance_office_type').addClass('border-danger');
        __notif_show(-1, 'Warning', 'Please dont leave blank, N/A if not applicable!');

    }else if($('#csc_clearance_unit_office_name').val() == '' || $('#csc_clearance_unit_office_name').val()== null)
    {
        $('#csc_clearance_unit_office_name').addClass('border-danger');
        __notif_show(-1, 'Warning', 'Please dont leave blank, N/A if not applicable!');

    }else
    {
        let category = 'III';

        let form_data = {

            _token,
            category,
            clearance_id                    : $('#clearance_id').val(),
            csc_clearance_office_type       : $('#csc_clearance_office_type').val(),
            csc_clearance_unit_office_name  : $('#csc_clearance_unit_office_name').val(),
            csc_clearance_employees         : $('#csc_clearance_employees').val(),

        }

        $.ajax({
            url: bpath + 'clearance/add/iii',
            type: "POST",
            data: form_data,
            success: function (response) {
                if(response)
                {
                    let data = JSON.parse(response);
                    let status = data['status'];

                    if(status == 200)
                    {
                        __notif_show(1, 'Success', 'Created successfully!');
                        clear_modal_inputs_clearance_III();
                        load_csc_clearance_III();

                    }else
                    {
                        __notif_show(-1, 'Warning', 'Something went wrong!');
                    }
                }
            }
        });
    }

}
function clear_modal_inputs_clearance_III(){

    $('#csc_clearance_office_type').val('');
    $('#csc_clearance_unit_office_name').val('');
    $('#csc_clearance_employees').val(null).trigger('change');
}
function delete_csc_clearance_iii(){

    $('body').on('click' , '.delete_iii_clearance', function (){

        const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#delete_csc_iii_mdl'));
        mdl.toggle();


        let csc_iii_id = $(this).data('iii-clearanceSignatories-id');
        $('#mdl_csc_iii_input_id').val(csc_iii_id);

    });

    $('body').on('click', '#btn_delete_my_csc_iii', function (){

        let csc_iii_id = $('#mdl_csc_iii_input_id').val();

        $.ajax({
            url: bpath + 'clearance/delete/csc/iii',
            type: "POST",
            data: { _token, csc_iii_id},
            success: function (response) {
                if(response)
                {
                    let data = JSON.parse(response);
                    let status = data['status'];

                    if(status == 200)
                    {
                        __notif_show(1, 'Success', 'Deleted successfully!');
                        load_csc_clearance_III();
                        const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#delete_csc_iii_mdl'));
                        mdl.hide();

                    }else
                    {
                        __notif_show(-1, 'Warning', 'Something went wrong!');
                    }
                }
            }
        });

    });

}






function load_csc_clearance_IV(){

    let clearance_id = $('#clearance_id').val();

    $.ajax({
        url: bpath + 'clearance/load/csc/iv',
        type: "POST",
        data: { _token,  clearance_id},
        success: function (response) {
            if (response) {

                let data = JSON.parse(response);
                let clearance_IV_data = data['clearance_IV'];

                // if(clearance_IV_data)
                // {
                //     $('.recent_setup_btn_div').hide();
                // }else
                // {
                //
                // }

                $('.recent_setup_btn_div').show();

                $('.dt__csc_clearance_IV tbody tr').detach();
                $('.dt__csc_clearance_IV tbody').append(clearance_IV_data);
            }
        }
    });
}
function add_csc_clearance_IV_tr(){

    $('body').on('click', '#add_csc_clearance_IV_tr', function (){

       __modal_toggle('add_csc_clearance_III_modal');

        $('#csc_clearance_iii_div').hide();
        $('#csc_clearance_iv_div').show();

        $('.csc_name_recent_setup_div').hide();
        $('.btn_use_recent_setup_csc').show();
        $('.btn_use_recent_setup_csc_iv').show();
        $('.csc_iii_recent_setup_div').hide();
        $('.csc_iv_recent_setup_div').hide();
        $('.csc_iii_inputs_div').show();


        $('.add_csc_clearance_signatories').text('IV. CERTIFICATION OF NO PENDING ADMINISTRATIVE CASE');

        $('#mdl_btn_save_csc_clearance_IV_tr').show();
        $('#mdl_btn_update_csc_clearance_IV_tr').hide();
        $('.btn_use_recent_setup_csc').hide();

        let clearance_type = 'CSC_IV';
        $('#csc_clearance_type').val(clearance_type);

        clear_modal_inputs_clearance_III();

    });

    $('body').on('click', '#mdl_btn_save_csc_clearance_IV_tr', function (){

        if($('#csc_clearance_office_type').val() == '' || $('#csc_clearance_office_type').val()== null)
        {
            $('#csc_clearance_office_type').addClass('border-danger');
            __notif_show(-1, 'Warning', 'Please dont leave blank, N/A if not applicable!');

        }else if($('#csc_clearance_unit_office_name').val() == '' || $('#csc_clearance_unit_office_name').val()== null)
        {
            $('#csc_clearance_unit_office_name').addClass('border-danger');
            __notif_show(-1, 'Warning', 'Please dont leave blank, N/A if not applicable!');

        }else
        {
            let form_data = {

                _token,
                clearance_id                    : $('#clearance_id').val(),
                csc_clearance_office_type       : $('#csc_clearance_office_type').val(),
                csc_clearance_unit_office_name  : $('#csc_clearance_unit_office_name').val(),
                csc_clearance_employees         : $('#csc_clearance_employees').val(),

            }

            $.ajax({
                url: bpath + 'clearance/add/iv',
                type: "POST",
                data: form_data,
                success: function (response) {
                    if(response)
                    {
                        let data = JSON.parse(response);
                        let status = data['status'];

                        if(status == 200)
                        {
                            __notif_show(1, 'Success', 'Created successfully!');
                            clear_modal_inputs_clearance_III();
                            load_csc_clearance_IV();

                        }else
                        {
                            __notif_show(-1, 'Warning', 'Something went wrong!');
                        }
                    }
                }
            });
        }

    });
}
function update_csc_clearance_IV(){

    $('body').on('click', '.update_IV_clearance', function (){

        let csc_iv_id          = $(this).data('iv-clearanceSignatories-id');
        let csc_iv_type        = $(this).data('iv-clearanceSignatories-type');
        let csc_iv_office      = $(this).data('iv-unit-office');
        let csc_iv_cleared     = $(this).data('iv-cleared');
        let csc_iv_not_cleared = $(this).data('iv-not-cleared');
        let csc_iv_officer_id  = $(this).data('iv-officer-id');

        __modal_toggle('add_csc_clearance_III_modal');

        $('.csc_iv_recent_setup_div').hide();
        $('.csc_iii_recent_setup_div').hide();
        $('.csc_name_recent_setup_div').hide();

        $('#csc_clearance_iii_div').hide();
        $('#mdl_btn_save_csc_clearance_IV_tr').hide();
        $('#mdl_btn_update_csc_clearance_IV_tr').show();
        $('#csc_clearance_iv_div').show();

        $('#csc_iii_input_id').val(csc_iv_id);
        $('#csc_clearance_office_type').val(csc_iv_type);
        $('#csc_clearance_unit_office_name').val(csc_iv_office);
        $('#csc_clearance_employees').val(csc_iv_officer_id).trigger('change');

        $('.add_csc_clearance_signatories').text('IV. CERTIFICATION OF NO PENDING ADMINISTRATIVE CASE');

    });

    $('body').on('click', '#mdl_btn_update_csc_clearance_IV_tr', function (){

        let form_data = {

            _token,
            csc_iii_id                      : $('#csc_iii_input_id').val(),
            csc_clearance_office_type       : $('#csc_clearance_office_type').val(),
            csc_clearance_unit_office_name  : $('#csc_clearance_unit_office_name').val(),
            csc_clearance_employees         : $('#csc_clearance_employees').val(),

        }

        $.ajax({
            url: bpath + 'clearance/update/csc/iv',
            type: "POST",
            data: form_data,
            success: function (response) {
                if (response)
                {
                    let data = JSON.parse(response);
                    let status = data['status'];

                    if(status == 200)
                    {
                        __notif_show(1, 'Success', 'Updated successfully!');

                        const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#add_csc_clearance_III_modal'));
                        mdl.hide();
                        load_csc_clearance_IV();
                    }
                }
            }
        });

    });
}
function delete_csc_clearance_IV(){

    $('body').on('click', '.tbl_btn_delete_csc_iv', function (){

        __modal_toggle('delete_csc_iv_modal');

    });
}






function add_semestral_clearance(){

    $('body').on('click', '#add_sem_clearance_tr', function (){

        const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#add_sem_clearance_tr_mdl'));
        mdl.toggle();

    });
    $('body').on('click', '#btn_om_add_tr_sem_clearance', function (){

        add_sem_clearance_table_row();
        clear_sem_clearance_table_row_inputs();

    });


    $('body').on('click', '#add_sem_clearance_approval_sign_tr', function (){

        const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#add_sem_clearance_approval_sign_mdl'));
        mdl.toggle();

    });
    $('body').on('click', '#btn_om_add_tr_sem_clearance_approval_sign', function (){

        add_sem_clearance_approval_sign_table_row();

    });

}
function add_sem_clearance_table_row(){

    let tr= '<tr class="hover:bg-gray-200">'+
        '   <td style="text-transform:uppercase"><input type="text" style="display: none" name="td_sem_clearance_docs[]" class="form-control flex text-center" value="'+$('#sem_clearance_docs').val()+'">'+$('#sem_clearance_docs').val()+'</td>'+
        '   <td style="text-transform:uppercase"><input type="text" style="display: none" name="td_sem_clearance_sign[]" class="form-control" value="'+$('#sem_clearance_signatory_om option:selected').val()+'">'+$('#sem_clearance_signatory_om option:selected').text()+'</td>'+
        // '   <td style="text-transform:uppercase"><input type="text" style="display: none" name="td_sem_clearance_rc[]" class="form-control flex text-center" value="'+$('#sem_clearance_rc_om option:selected').val()+'">'+$('#sem_clearance_rc_om option:selected').text()+'</td>'+
        '   <td style="text-transform:uppercase"><input type="text" style="display: none" name="td_sem_clearance_rc[]" class="form-control flex text-center" value="'+$('#sem_clearance_office').val()+'">'+$('#sem_clearance_office').val()+'</td>'+
        '   <td>' +
        '       <div class="flex justify-center items-center">' +
        '           <a href="javascript:void(0);" class="delete_sem_clearance_tr text-center"><i  class="w-4 h-4 text-danger fa-solid fa-trash"></i></a>' +
        '       </div>'+
        '   </td>'+
        '</tr>';

    $('.sem_clearance_table_tae tbody').append(tr);

}
function clear_sem_clearance_table_row_inputs(){

    $('#sem_clearance_docs').val("");

}
function delete_sem_clearance_table_row(){

    $('body').on('click' , '.delete_sem_clearance_tr', function (){

        $(this).parent().parent().parent().remove();

    });

}



function add_sem_clearance_approval_sign_table_row(){

    let tr= '<tr class="hover:bg-gray-200">'+
            '   <td style="text-transform:uppercase"><input type="text" style="display: none" name="td_sem_clearance_sign_user_id[]" class="form-control flex text-center" value="'+$('#sem_clearance__approval_signatory_om option:selected').val()+'">'+$('#sem_clearance__approval_signatory_om option:selected').val()+'</td>'+
            '   <td style="text-transform:uppercase"><input type="text" style="display: none" name="td_sem_clearance_sign_user_name[]" class="form-control" value="'+$('#sem_clearance__approval_signatory_om option:selected').text()+'">'+$('#sem_clearance__approval_signatory_om option:selected').text()+'</td>'+
            '   <td style="text-transform:uppercase"><input type="text" style="display: none" name="td_sem_clearance_sign_desc[]" class="form-control flex text-center" value="'+$('#sem_clearance_approval_desc').val()+'">'+$('#sem_clearance_approval_desc').val()+'</td>'+
            '   <td>' +
            '       <div class="flex justify-center items-center">' +
            '           <a href="javascript:void(0);" class="delete_sem_clearance_sign_tr text-center"><i  class="w-4 h-4 text-danger fa-solid fa-trash"></i></a>' +
            '       </div>'+
            '   </td>'+
            '</tr>';

    $('.sem_clearance_table_approval_sig tbody').append(tr);

}
function add_sem_documents_signatory(){

    $('body').on('click', '#create_sem_clearance', function (){

        $.ajax({
            url: bpath + 'clearance/create',
            type: "POST",
            data: {
                _token: _token,
            },
            success: function (response) {

            }
        });
    });

}



function create_my_csc_Clearance(){

    let purpose = '';
    let cleared_or_not = '';
    let pending_or_ongoing = '';

    $('#radio_switch_cleared').change(function() {
        if ($(this).is(':checked')) {

            $("#radio_switch_un_cleared").prop("checked", false);
            cleared_or_not = 1;

        }
    });

    $('#radio_switch_un_cleared').change(function() {
        if ($(this).is(':checked')) {

            $("#radio_switch_cleared").prop("checked", false);
            cleared_or_not = 0;

        }
    });

    $('#radio_switch_pending_case').change(function() {
        if ($(this).is(':checked')) {

            $("#radio_switch_ongoing_case").prop("checked", false);
            pending_or_ongoing = 1;

        }
    });

    $('#radio_switch_ongoing_case').change(function() {
        if ($(this).is(':checked')) {

            $("#radio_switch_pending_case").prop("checked", false);
            pending_or_ongoing = 0;

        }
    });


    $('body').on('click', '#btn_create_my_csc_clearance', function (){

        if($("#modal_Transfer").is(":checked"))
        {
            purpose = 'Transfer';
            $('#others_mode_sep').val();

        }

        if($("#modal_Resignation").is(":checked"))
        {
            purpose = 'Resignation';
            $('#others_mode_sep').val();

        }

        if($("#modal_Retirement").is(":checked"))
        {
            purpose = 'Retirement';
            $('#others_mode_sep').val();

        }

        if($("#modal_Leave").is(":checked"))
        {
            purpose = 'Leave';
            $('#others_mode_sep').val();

        }

        if($("#modal_others").is(":checked"))
        {
            purpose = 'Others';
        }

        let form_data = {
            _token,
            clearance_id : $('#mdl_my_csc_clearance_id').val(),
            purpose,
            others_mode_sep     : $('#others_mode_sep').val(),
            csc_clearance_rc    : $('#csc_clearance_rc').val(),
            csc_clearance_pos   : $('.csc_clearance_pos').val(),
            csc_clearance_sg    : $('#csc_clearance_sg').val(),
            csc_clearance_step  : $('#csc_clearance_step').val(),
            csc_immediate_supervisor  : $('#csc_immediate_supervisor').val(),
            csc_clearance_agency_head  : $('#csc_clearance_agency_head').val(),
            csc_clearance_agency_head_V  : $('#csc_clearance_agency_head_V').val(),
            cleared_or_not,
            pending_or_ongoing,
            date_filing     : $('#date_filing').val(),
            date_effective  : $('#date_effective').val(),

        }

        $.ajax({
            url: bpath + 'clearance/create/csc',
            type: "POST",
            data: form_data,
            success: function (response) {

                if (response)
                {
                    let data = JSON.parse(response);
                    let status = data['status'];

                    if(status == 200)
                    {
                        __notif_show(1, 'Success', 'Submitted successfully!');

                        const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#my_csc_clearance_modal'));
                        mdl.hide();
                        load_my_clearance();

                    }
                }
            }
        });
    });
}

// function save_created_clearance(){
//
//     $('body').on('click', '#btn_create_clearance', function (){
//
//         //CLEARANCE DOCUMENTS
//         let sem_clearance_docs = [];
//         $('input[name="td_sem_clearance_docs[]"]').each(function (i, _sem_clearance_docs) {
//             if(!$(_sem_clearance_docs).val() == "")
//             {
//                 sem_clearance_docs[i] = $(_sem_clearance_docs).val();
//             }
//         });
//
//         //CLEARANCE SIGNATORY
//         let sem_clearance_sign = [];
//         $('input[name="td_sem_clearance_sign[]"]').each(function (i, _sem_clearance_sign) {
//             if(!$(_sem_clearance_sign).val() == "")
//             {
//                 sem_clearance_sign[i] = $(_sem_clearance_sign).val();
//             }
//         });
//
//         //CLEARANCE SIGNATORY
//         let sem_clearance_rc = [];
//         $('input[name="td_sem_clearance_rc[]"]').each(function (i, _sem_clearance_rc) {
//             if(!$(_sem_clearance_rc).val() == "")
//             {
//                 sem_clearance_rc[i] = $(_sem_clearance_rc).val();
//             }
//         });
//
//
//
//         //APPROVAL SIGNATORIES USER ID
//         let approval_sem_clearance_user_id = [];
//         $('input[name="td_sem_clearance_sign_user_id[]"]').each(function (i, sample_input) {
//             if(!$(sample_input).val() == "")
//             {
//                 approval_sem_clearance_user_id[i] = $(sample_input).val();
//             }
//         });
//
//         //APPROVAL SIGNATORIES NAME
//         let approval_sem_clearance_user_name = [];
//         $('input[name="td_sem_clearance_sign_user_name[]"]').each(function (i, sample_input_1) {
//             if(!$(sample_input_1).val() == "")
//             {
//                 approval_sem_clearance_user_name[i] = $(sample_input_1).val();
//             }
//         });
//
//         //APPROVAL DESCRIPTION
//         let approval_sem_clearance_desc = [];
//         $('input[name="td_sem_clearance_sign_desc[]"]').each(function (i, sample_input_2) {
//             if(!$(sample_input_2).val() == "")
//             {
//                 approval_sem_clearance_desc[i] = $(sample_input_2).val();
//             }
//         });
//
//
//         let data = {
//             _token,
//
//             clearance_type  : $('#clearance_type').val(),
//             clearance_rc    : $('#clearance_rc').val(),
//             clearance_name  : $('#sem_clearance_name').val(),
//             clearance_desc  : $('.clearance_desc').val(),
//
//             sem_clearance_docs,
//             sem_clearance_sign,
//             sem_clearance_rc,
//
//             approval_sem_clearance_user_id,
//             approval_sem_clearance_user_name,
//             approval_sem_clearance_desc,
//
//         }
//         $.ajax({
//             url: bpath + 'clearanceSignatories/create/new',
//             type: "POST",
//             data: data,
//             success: function (response) {
//                 if(response)
//                 {
//                     let data = JSON.parse(response);
//                     let status = data['status'];
//
//                     if(status == 200)
//                     {
//                         __notif_show(1, 'Success', 'Created successfully!');
//                     }else
//                     {
//                         __notif_show(-1, 'Warning', 'Something went wrong!');
//                     }
//                 }
//             }
//         });
//     });
//
// }





function load_my_csc_clearance_iii_data(clearance_id){

    showLoading();
    $.ajax({
        url: bpath + 'clearance/my/csc/clearance/iii',
        type: "POST",
        data: {
            _token,
            clearance_id,
        },
        success: function (response) {
            if(response)
            {
                let data = JSON.parse(response);
                let my_csc_clearance_tale_row = data['My_III_CLEARANCE_FROM_MONEY_AND_PROPERTY_ACCOUNTABILITIES'];

                $('.dt_my_csc_clearance_III tbody').append(my_csc_clearance_tale_row);

                hideLoading();
            }
        }
    });
}
function load_my_csc_clearance_iv_data(clearance_id){

    showLoading();
    $.ajax({
        url: bpath + 'clearance/my/csc/clearance/iv',
        type: "POST",
        data: {
            _token,
            clearance_id,
        },
        success: function (response) {
            if(response)
            {
                let data = JSON.parse(response);
                let my_csc_clearance_table_row = data['My_IV_CLEARANCE_FROM_MONEY_AND_PROPERTY_ACCOUNTABILITIES'];

                $('.dt_my_csc_clearance_IV tbody').append(my_csc_clearance_table_row);

                hideLoading();
            }
        }
    });
}
function load_my_csc_clearance_other_info(clearance_id){
    $.ajax({
        url: bpath + 'clearance/my/csc/clearance/others',
        type: "POST",
        data: {
            _token,
            clearance_id,
        },
        success: function (response) {
            if(response)
            {
                let data = JSON.parse(response);

                let purpose         = data['purpose'];
                let purpose_others  = data['purpose_others'];
                let date_filing     = data['date_filing'];
                let date_effective  = data['date_effective'];
                let rc              = data['rc'];
                let position        = data['position'];
                let sg              = data['sg'];
                let step            = data['step'];
                let cleared         = data['cleared'];
                let immediate_supervisor = data['immediate_supervisor'];
                let case_data       = data['case_data'];

                if(purpose == 'Transfer')
                {
                    $('#modal_Transfer').prop('checked', true);

                }else if(purpose == 'Resignation')
                {
                    $('#modal_Resignation').prop('checked', true);

                }else if(purpose == 'Retirement')
                {
                    $('#modal_Retirement').prop('checked', true);

                }else if(purpose == 'Leave')
                {
                    $('#modal_Leave').prop('checked', true);

                }else if(purpose == 'Others')
                {
                    $('#modal_others').prop('checked', true);
                    $('#others_mode_sep_div').show();
                    $('#others_mode_sep').val(purpose_others);

                }

                if(cleared == '1')
                {
                    $('#radio_switch_cleared').prop('checked', true);

                }else if(cleared == '0')
                {
                    $('#radio_switch_un_cleared').prop('checked', true);
                }

                $('#csc_clearance_sg').val(sg).trigger('change');
                $('#csc_clearance_step').val(step).trigger('change');
                $('.csc_clearance_pos').val(position).trigger('change');

                if(case_data == '0')
                {
                    $('#radio_switch_ongoing_case').prop('checked', true);

                }else if(case_data == '1')
                {
                    $('#radio_switch_pending_case').prop('checked', true);
                }

                $('#date_filing').val(date_filing);
                $('#date_effective').val(date_effective);
            }
        }
    });
}
function request_csc_clearance(){

    $('#csc_note_request').on('keydown', function() {

        $('#csc_note_request').removeClass('border-danger');
    });

    $('body').on('click', '#btn_request_csc_clearance', function (){

        let clearance_id = $(this).data('clearanceSignatories-id');
        $('#mdl_request_csc_clearance_id').val(clearance_id);

        check_request(clearance_id);

        __dropdown_close('#csc_clearance_list_dd');



    });

    $('body').on('click', '#mdl_btn_send_request_csc_clearance', function (){

        let csc_note_request = $('#csc_note_request').val();
        let clearance_id = $('#mdl_request_csc_clearance_id').val();

        let button_send_request = $(this);
        button_send_request.prop('disabled', true);

        if($('#csc_note_request').val() == '' || $('#csc_note_request').val()== null)
        {
            $('#csc_note_request').addClass('border-danger');
            __notif_show(-1, 'Warning', 'Please dont leave blank, N/A if not applicable!');

            button_send_request.prop('disabled', false);

        }else
        {
            $.ajax({
                url: bpath + 'clearance/csc/send/request',
                type: "POST",
                data: { _token, csc_note_request, clearance_id },
                success: function (response) {

                    if (response)
                    {
                        let data = JSON.parse(response);
                        let status = data['status'];

                        if(status == 200)
                        {
                            button_send_request.prop('disabled', false);

                            __notif_show(1, 'Success', 'Requested successfully!');

                            const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#request_csc_clearance_modal'));
                            mdl.hide();
                            load_my_clearance();
                            load_clearance_requests();

                            $('csc_note_request').val('');

                        }
                    }
                }
            });
        }
    });
}
function check_request(clearance_id){

    showLoading();

    $.ajax({
        url: bpath + 'clearance/csc/check/request',
        type: "POST",
        data: { _token, clearance_id },
        success: function (response) {

            if (response)
            {
                let data = JSON.parse(response);
                let status = data['status'];
                let can_request = data['can_request'];

                if(can_request)
                {
                    const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#request_csc_clearance_modal'));
                    mdl.toggle();

                }else
                {
                    __notif_show(-1, 'Warning', 'You already Requested, please contact your Human Resource Officer!');
                }
            }
            hideLoading();
        }
    });
}
function update_my_requested_csc_clearance(){

    $('body').on('click', '#btn_edit_my_csc_clearance', function (){

        const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#my_csc_clearance_modal'));
        mdl.toggle();

        let clearance_id = $(this).data('clearanceSignatories-id');
        $('#mdl_my_csc_clearance_id').val(clearance_id);

        load_my_csc_clearance_iii_data(clearance_id);
        load_my_csc_clearance_iv_data(clearance_id);


        load_my_csc_clearance_other_info(clearance_id);

    });
}






function Clearance_Request_Info(){

    $('body').on('click', '#btn_csc_request_info', function (){
        const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#modal_request_info'));
        mdl.toggle();
        __dropdown_close('#csc_clearance_list_dd');
    });

    $('body').on('click', '#btn_csc_request_info_disapproved', function (){
        const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#modal_request_disapproved_info'));
        mdl.toggle();
        __dropdown_close('#csc_clearance_list_dd');
    });


}






function admin_approve_dis_approved_Clearance_Request(){

    approve_request();
    dis_approve_request();

    $('body').on('click', '.clearance_request_btn', function (){

        let clearance_name = $(this).data('clearanceSignatories-name');
        let clearance_id = $(this).data('clearanceSignatories-id');

        let clearance_request_id = $(this).data('clearanceSignatories-request-id');
        $('#mdl_approve_disapprove_csc_clearance_id').val(clearance_id);
        $('#mdl_approve_disapprove_clearance_name').val(clearance_name);
        $('#mdl_csc_clearance__request_id').val(clearance_request_id);

        __modal_toggle('approve_disapprove_csc_clearance_modal');

    });
}
function approve_request(){

    $('body').on('click', '#mdl_btn_approve_request', function (){

        let clearance_id = $('#mdl_approve_disapprove_csc_clearance_id').val();

        let clearance_request_id = $('#mdl_csc_clearance__request_id').val();
        let clearance_response_note = $('#mdl_approve_disapprove_response_note').val();
        let this_button = $(this);
        let approval = '11';

        if($('#mdl_approve_disapprove_response_note').val() == '' || $('#mdl_approve_disapprove_response_note').val()== null)
        {
            $('#mdl_approve_disapprove_response_note').addClass('border-danger');
            __notif_show(-1, 'Warning', 'Please dont leave blank, N/A if not applicable!');

            this_button.prop('disabled', false);

        }else
        {
            send_to_db_approve_disapprove(clearance_id, clearance_request_id, clearance_response_note, this_button, approval);
        }

    });
}
function dis_approve_request(){

    $('body').on('click', '#mdl_btn_disapprove_request', function (){

        let clearance_id = $('#mdl_approve_disapprove_csc_clearance_id').val();
        let clearance_request_id = $('#mdl_csc_clearance__request_id').val();
        let clearance_response_note = $('#mdl_approve_disapprove_response_note').val();
        let this_button = $(this);
        let approval = '12';

        if($('#mdl_approve_disapprove_response_note').val() == '' || $('#mdl_approve_disapprove_response_note').val()== null)
        {
            $('#mdl_approve_disapprove_response_note').addClass('border-danger');
            __notif_show(-1, 'Warning', 'Please dont leave blank, N/A if not applicable!');

            this_button.prop('disabled', false);

        }else
        {
            send_to_db_approve_disapprove(clearance_id, clearance_request_id, clearance_response_note, this_button, approval);
        }
    });



}
function send_to_db_approve_disapprove(clearance_id, clearance_request_id, clearance_response_note, this_button, approval) {

    $.ajax({
        url: bpath + 'clearance/approve/disapprove/requests',
        type: "POST",
        data: { _token, clearance_response_note, clearance_id, clearance_request_id, approval },
        success: function (response) {

            if (response)
            {
                let data = JSON.parse(response);
                let status = data['status'];

                if(status == 200)
                {
                    this_button.prop('disabled', false);

                    __notif_show(1, 'Success', 'Submitted successfully!');

                    const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#approve_disapprove_csc_clearance_modal'));
                    mdl.hide();
                    load_clearance_requests();
                    load_my_clearance();
                    count_clearance_request();

                    $('#mdl_approve_disapprove_clearance_name').val('');
                    $('#mdl_approve_disapprove_response_note').val('');

                }
            }
        }
    });
}


function load_my_signatories(){

    $.ajax({
        url: bpath + 'clearance/load/my/signatories',
        type: "POST",
        data: {
            _token,
        },
        success: function (response) {
            if(response)
            {
                let data = JSON.parse(response);
                let signatories_html_data = data['signatories_html_data'];
                let default_html_data = '';


                if(signatories_html_data)
                {
                    $('.clearance_signatories_list_div').html(signatories_html_data);
                }else
                {
                    default_html_data =
                        '<div class="intro-x">' +
                        '       <div class="box px-5 py-3 mb-3 flex items-center zoom-in">' +
                        '           <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">' +
                        '               <img alt="Profile Picture" src="/dist/images/empty.webp">' +
                        '           </div>' +
                        '           <div class="ml-4 mr-auto">' +
                        '           <div class="font-medium">No Clearance found for signatory!</div>' +
                        '               <div class="text-slate-500 text-xs mt-0.5"></div>' +
                        '           </div>' +
                        '   </div>' +
                        '</div>';

                    $('.clearance_signatories_list_div').html(default_html_data);

                }
            }
        }
    });
}
function Signatories_Sign(){

    $('body').on('click', '.clearance_signatories_btn', function (){

        let unit_office_name = $(this).data('unit-office');
        let signatory_id = $(this).data('signatory-id');
        let employee_id = $(this).data('employee-id');
        let clearance_request = $(this).data('request-id');

        $('.mdl_input_signatory_id').val(signatory_id);
        $('.unit_office_name').text(unit_office_name);
        $('.mdl_input_employee_id').val(employee_id);
        $('.mdl_input_clearance_request_id').val(clearance_request);
        const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#modal_signatory_sign'));
        mdl.toggle();

    });

    $('body').on('click', '#mdl_btn_submit_signatory', function (){

        let form_data = {
            _token,
            mdl_signatory_note     : $('#mdl_signatory_note').val(),
            mdl_input_signatory_id : $('.mdl_input_signatory_id').val(),
            mdl_input_employee_id  : $('.mdl_input_employee_id').val(),
            mdl_input_clearance_request_id  :  $('.mdl_input_clearance_request_id').val(),
            cleared_checkbox,
            signature_checkbox,
        }

        $.ajax({
            url: bpath + 'clearance/submit/my/signature',
            type: "POST",
            data: form_data,
            success: function (response) {

                if (response) {
                    let data = JSON.parse(response);
                    let status = data['status'];

                    if(status == 200)
                    {
                        __notif_show(1, 'Success', 'Submitted successfully!');
                        const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#modal_signatory_sign'));
                        mdl.hide();

                        load_my_signatories();

                        $('#mdl_signatory_note').val('');
                        $('.mdl_input_signatory_id').val('');
                        $('#checkbox_cleared_not_cleared').prop('checked', false);
                        $('#checkbox_signature').prop('checked', false);
                    }
                }
            }
        });


    });
}



//RECENT ACTIVITIES
function Recent_Activities(clearance_id){

    $.ajax({
        url: bpath + 'clearance/get/recent/activities',
        type: "POST",
        data: {
            _token,
            clearance_id,
        },
        success: function (response) {
            if(response)
            {
                let data = JSON.parse(response);

                let html_data = data['html_data'];

                let html_default_data =
                    '<div class="intro-x relative flex items-center mb-3">' +
                    '   <div class="before:block before:absolute before:w-20 before:h-px before:bg-slate-200 before:dark:bg-darkmode-400 before:mt-5 before:ml-5">' +
                    '       <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">' +
                    '           <img alt="Icon" src="/dist/images/empty.webp">' +
                    '       </div>' +
                    '  </div>' +
                    '   <div class="box px-5 py-3 ml-4 flex-1 zoom-in">' +
                    '       <div class="flex items-center">' +
                    '           <div class="font-medium">No Activities Yet!</div>' +
                    '       </div>' +
                    '   </div>' +
                    '</div>';


                if(html_data)
                {
                    $('.recent_activity_list_div').html(html_data);
                }else
                {
                    $('.recent_activity_list_div').html(html_default_data);
                }


            }
        }
    });




}
//RECENT ACTIVITIES


//CLICK MY CLEARANCE TABLE ROW TO DISPLAY RECENT ACTIVITIES
function Click_My_Clearance_Table_Row(){


    $('body').on('click', '.my_clearance_tr', function (){

        let clearance_id = $(this).data('clearanceSignatories-id');

        Recent_Activities(clearance_id);

    });
}


function Resubmit_My_Clearance_to_Clearing_Officer(){

    $('body').on('click', '.box_recent_activity', function (){

        __modal_toggle('activity_info_modal');

        let signatory_id = $(this).data('signatory-id');
        let activity_status = $(this).data('status');
        let activity_class = $(this).data('class');
        let note = $(this).data('note');
        let full_name = $(this).data('fullname');
        let status = '';

        $('#mdl_csc_clearance_signatory_id').val(signatory_id);

        if(activity_status == 'Failed')
        {
            status = 'Returned';
            $('#mdl_btn_resubmit_clearance').show();
        }else
        {
            status = activity_status;
            $('#mdl_btn_resubmit_clearance').hide();
        }




        let html_data =
            '<div class="flex items-center">' +
            '   <div>From: <span class="font-medium">'+full_name+'</span></div>' +
            '</div>' +
            '<div class="flex items-center">' +
            '   <div>Status: <span class="font-medium text-'+activity_class+'">'+status+'</span></div>' +
            '</div>' +
            '<div class="leading-relaxed text-slate-500 text-xs mt-2">' +
            '<div class="col-span-12 sm:col-span-6 mb-2 mt-2">' +
            '   <textarea style="height: 100px" class="form-control" disabled>'+note+'</textarea>' +
            '</div>'+
            '</div>';

        $('.clearing_official_response_div').html(html_data);

    });

    $('body').on('click', '#mdl_btn_resubmit_clearance', function (){

        let signatory_id =  $('#mdl_csc_clearance_signatory_id').val();

        $.ajax({
            url: bpath + 'clearance/resubmit/for/signatory',
            type: "POST",
            data: {
                _token,
                signatory_id,
            },
            success: function (response) {
                if (response) {
                    let data = JSON.parse(response);
                    let status = data['status'];

                    if(status == 200)
                    {
                        __notif_show(1, 'Success', 'Request has been re-submitted successfully!')
                        __modal_hide('activity_info_modal');
                        Recent_Activities();
                    }
                }
            }
        });

    });
}



function bind_checkbox(){

    $('#checkbox_cleared_not_cleared').change(function() {

        if ($(this).is(':checked')) {

            cleared_checkbox = '1';
            signature_checkbox = '1';
            $('#checkbox_signature').prop('checked', true);
        }else
        {
            cleared_checkbox = '0';
            signature_checkbox = '0';
            $('#checkbox_signature').prop('checked', false);
        }
    });

    $('#checkbox_signature').change(function() {

        if ($(this).is(':checked')) {

            signature_checkbox = '1';
            cleared_checkbox = '1';
            $('#checkbox_cleared_not_cleared').prop('checked', true);

        }else
        {
            signature_checkbox = '0';
            cleared_checkbox = '0';
            $('#checkbox_cleared_not_cleared').prop('checked', false);
        }
    });


    $('#checkbox_switch_clearance_status').change(function() {

        if ($(this).is(':checked')) {

            clearance_status_checkbox = '1';
            $('.switch_label').text('Active');
            let html_data =
                '<i class="fa-solid fa-toggle-on w-16 h-16 text-success mx-auto mt-3 fa-beat"></i>' +
                '<div class="text-3xl mt-5">Update Clearance Status</div>';

            $('.mdl_status_title').html(html_data);

        }else
        {
            clearance_status_checkbox = '0';
            $('.switch_label').text('In-Active');
            let html_data =
                '<i class="fa-solid fa-toggle-off w-16 h-16 text-danger mx-auto mt-3 fa-beat"></i>' +
                '<div class="text-3xl mt-5">Update Clearance Status</div>';

            $('.mdl_status_title').html(html_data);
        }
    });





    $('body').on('click', '.btn_check_state', function (){
        $('.btn_check_state').change(function() {

            if ($(this).is(':checked')) {

                clearance_status_checkbox = '1';
                $('.state_switch_label').text('Open');


                let clearance_id = $(this).data('clearanceSignatories-id');
                Admin_Update_Clearance_Status_State(clearance_id);

            }else
            {
                clearance_status_checkbox = '0';
                $('.state_switch_label').text('Closed');


                let clearance_id = $(this).data('clearanceSignatories-id');
                Admin_Update_Clearance_Status_State(clearance_id)

            }
        });
    });



}

function Admin_Update_Clearance_Status_State(clearance_id){

    showLoading();
    $.ajax({
        url: bpath + 'clearance/admin/update/status',
        type: "POST",
        data: {
            _token,
            clearance_id,
            clearance_status_checkbox,
        },
        success: function (response) {
            if (response)
            {
                let data = JSON.parse(response);
                let status = data['status'];

                if(status == 200)
                {
                    hideLoading();
                    location.reload();

                    clearance_status_checkbox = '';
                }
            }
        }
    });
}




function Admin_Update_Clearance_Status(){

    $('body').on('click', '.btn_clearance_status', function (){

        let is_admin = $(this).data('privilege');
        let clearance_id = $(this).data('clearanceSignatories-id');
        let status = $(this).data('status');
        $('.mdl_input_clearance_status_id').val(clearance_id);

        if(is_admin)
        {
            if(status == 1)
            {
                $('#checkbox_switch_clearance_status').prop('checked', true);
                $('.switch_label').text('Active');

                let html_data =
                    '<i class="fa-solid fa-toggle-on w-16 h-16 text-success mx-auto mt-3 fa-beat"></i>' +
                    '<div class="text-3xl mt-5">Update Clearance Status</div>';

                $('.mdl_status_title').html(html_data);

            }else if(status == 0)
            {
                $('#checkbox_switch_clearance_status').prop('checked', false);
                $('.switch_label').text('In-Active');

                let html_data =
                    '<i class="fa-solid fa-toggle-off w-16 h-16 text-danger mx-auto mt-3 fa-beat"></i>' +
                    '<div class="text-3xl mt-5">Update Clearance Status</div>';

                $('.mdl_status_title').html(html_data);

            }

            // __modal_toggle('modal_clearance_status');

        }else
        {
            __notif_show(-1, 'Warning', 'You dont have any privilege');
        }
    });


    $('body').on('click', '#mdl_btn_update_clearance_status', function (){

        let clearance_id = $('.mdl_input_clearance_status_id').val();

        $.ajax({
            url: bpath + 'clearance/admin/update/status',
            type: "POST",
            data: {
                _token,
                clearance_id,
                clearance_status_checkbox,
            },
            success: function (response) {
                if (response)
                {
                    let data = JSON.parse(response);
                    let status = data['status'];

                    if(status == 200)
                    {
                        __notif_show(1, 'Success', 'Status updated successfully!');
                        const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#modal_clearance_status'));
                        mdl.hide();

                        load_my_clearance();
                        load_admin_created_clearance();
                        location.reload();
                        $('.mdl_input_clearance_status_id').val('');
                        clearance_status_checkbox = '';
                    }
                }
            }
        });

    });

}


function Load_Important_Notes(){

    $.ajax({
        url: bpath + 'clearance/load/important/notes',
        type: "POST",
        data: { _token },
        success: function (response) {
            if (response)
            {
                let data = JSON.parse(response);
                let html_data = data['html_data'];

                $('.important_notes_div').html(html_data);

            }
        }
    });

}
function Add_Important_Notes(){

    $('#mdl_note_title').on('keydown', function() {

        $('#mdl_note_title').removeClass('border-danger');
    });

    $('#mdl_important_notes').on('keydown', function() {

        $('#mdl_important_notes').removeClass('border-danger');
    });

    $('.clearance_target_div').on('keydown', function() {

        $('.clearance_target_div').removeClass('border-danger');
    });


    $('body').on('click', '.btn_add_important_notes', function (){
        __modal_toggle('important_notes_modal');
    });

    $('body').on('click', '#mdl_btn_submit_notes', function (){

        let submit_button = $(this);

        if($('#clearance_note_rc').val() == '' && $('#clearance_note_employees').val()== '')
        {
            __notif_show(-1, 'Warning', 'Please Responsibility Center or Employee');
            $('.clearance_target_div').addClass('border-danger');

        }else if($('#mdl_note_title').val() == '' || $('#mdl_note_title').val()== null)
        {
            $('#mdl_note_title').addClass('border-danger');
            __notif_show(-1, 'Warning', 'Please dont leave blank, N/A if not applicable!');

        }else if($('#mdl_important_notes').val() == '' || $('#mdl_important_notes').val()== null)
        {
            $('#mdl_important_notes').addClass('border-danger');
            __notif_show(-1, 'Warning', 'Please dont leave blank, N/A if not applicable!');

        }else
        {
            submit_button.prop('disabled', true);

            let form_data = {
                _token,
                mdl_note_title           : $('#mdl_note_title').val(),
                mdl_important_notes      : $('#mdl_important_notes').val(),
                clearance_note_rc        : $('#clearance_note_rc').val(),
                clearance_note_employees : $('#clearance_note_employees').val(),
            };

            $.ajax({
                url: bpath + 'clearance/submit/important/notes',
                type: "POST",
                data: form_data,
                success: function (response) {
                    if (response)
                    {
                        let data = JSON.parse(response);
                        let status = data['status'];

                        if(status == 200)
                        {
                            __notif_show(1, 'Success', 'Important Note Posted successfully!');
                            __modal_hide('important_notes_modal');

                            Load_Important_Notes();

                            $('#clearance_note_rc').val(null).trigger('change');
                            $('#clearance_note_employees').val(null).trigger('change');
                            $('#mdl_note_title').val('');
                            $('#mdl_important_notes').val('');

                            location.reload();
                            submit_button.prop('disabled', false);
                        }
                    }
                }
            });
        }

    });
}
function Remove_Clearance_Important_Notes(){

    $('body').on('click', '.remove_clearance_note', function (){

        let note_id = $(this).data('note-id');

        $.ajax({
            url: bpath + 'clearance/dismiss/note',
            type: "POST",
            data: { _token, note_id},
            success: function (response) {
                if (response) {
                    let data = JSON.parse(response);
                    let status = data['status'];
                    if(status == 200)
                    {
                        location.reload();
                    }
                }
            }
        });
    });

}
function toggle_modal_Important_Notes(){

    $('body').on('click', '.my_note_box_btn', function (){

        let mdl_clearing_official_name = $(this).data('author-name');
        $('#mdl_clearing_official_name').val(mdl_clearing_official_name);

        let office_unit_dept = $('.unit_office_dept_info').val();
        $('#mdl_unit_office_dept').val(office_unit_dept);

        let note_content = $(this).data('note-content');
        $('.clearance_content').text(note_content);


        __modal_toggle('view_important_notes_modal');
    });


    $('body').on('click', '.admin_note_box_btn', function (){

        let mdl_clearing_official_name = $(this).data('author-name');
        $('#mdl_clearing_official_name').val(mdl_clearing_official_name);

        let office_unit_dept = $('.unit_office_dept_info').val();
        $('#mdl_unit_office_dept').val(office_unit_dept);

        let note_content = $(this).data('note-content');
        $('.clearance_content').text(note_content);


        __modal_toggle('view_important_notes_modal');

    });

}



function __modal_toggle(modal_id){

    const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#'+modal_id));
    mdl.toggle();

}

function __modal_hide(modal_id){

    const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#'+modal_id));
    mdl.hide();

}
