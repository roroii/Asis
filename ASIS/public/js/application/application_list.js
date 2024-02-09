var  _token = $('meta[name="csrf-token"]').attr('content');
var bpath = window.location.origin;
var tbl_data_applicant_list;
$(document).ready(function (){

    bpath = __basepath + "/";

    load_data_tables();

    load_applicants_datatable();

    select2_event_handler();

});

function load_data_tables(){

    try{
        /***/
        tbl_data_applicant_list = $('#dt__applicant_list').DataTable({
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
                    { className: "dt-head-center", targets: [ 1 ] },
                ],
        });

        $('#applied_pos').select2({
            closeOnSelect: true,
        });

        /***/
    }catch(err){  }

}

function load_applicants_datatable(){

    $.ajax({
        url: bpath + 'application/get/applicants',
        type: "POST",
        data: {
            _token: _token,
        },
        success: function(response) {

            tbl_data_applicant_list.clear().draw();
            /***/
            var data = JSON.parse(response);

            if(data.length > 0) {
                for(var i=0;i<data.length;i++) {

                    /***/

                    var job_ref_no = data[i]['job_ref_no'];
                    var applicant_id = data[i]['applicant_id'];
                    var last_name = data[i]['lastname'];
                    var first_name = data[i]['firstname'];
                    var mid_name = data[i]['mi'];
                    var extension = data[i]['extension'];
                    var mobile_number = data[i]['mobile_number'];
                    var email = data[i]['email'];

                    var position = data[i]['position'];
                    var active = data[i]['active'];
                    var hiring_status = data[i]['hiring_status'];
                    var hiring_status_class = data[i]['hiring_status_class'];

                    var full_name = first_name+" "+last_name;
                    var profile_pic= data[i]['profile_pic'];
                    var status = '';
                    var button_color = '';
                    var date_applied = data[i]['date_applied'];
                    var application_count = data[i]['application_count'];

                    button_color = "success";

                    if(email == "")
                    {
                        email = "N/A";
                    }

                    if (active == 1)
                    {
                         status = "Active";
                    }else {
                         status = "In-Active";
                    }

                    var cd = "";
                    /***/

                    cd = '' +
                        '<tr class="intro-x cursor-pointer" data-fullname="'+full_name+'" data-email="'+email+'" data-profile-pic="'+profile_pic+'" data-applicant-id="'+applicant_id+'">' +

                        // '<td class="w-20">' +
                        //     '<a class="underline decoration-dotted whitespace-nowrap">#'+
                        //     applicant_id+'</a>'+
                        // '</td>' +

                        ' <td class="!py-3.5">' +
                            '<div class="flex items-center">' +
                                '<div class="w-9 h-9 image-fit zoom-in">' +
                                    '<img id="profile_pic_toggle" data-email="'+email+'" data-identifier="applicant_list" data-fullname="'+full_name+'" data-profile="'+profile_pic+'" alt="Profile Picture" class="rounded-lg border-white shadow-md tooltip" src="'+profile_pic+'" title="Applied at '+date_applied+'">' +
                            '</div>' +
                                '<div class="ml-4">' +
                                    '<a href="javascript:;" class="font-medium whitespace-nowrap">'+full_name+'</a>' +
                                    '<div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">'+email+'</div>' +
                                '</div>' +
                            '</div>' +
                        '</td>'+


                        // '<td class="status">'+
                        //     '<div class="flex justify-center items-center">'+
                        //         '<div class="w-9 h-9 relative image-fit mb-5 mr-5 cursor-pointer zoom-in">' +
                        //             '<img class="rounded-md" alt="Midone - HTML Admin Template" src="'+profile_pic+'">' +
                        //             '<div title="Total application count" class="tooltip w-5 h-5 flex items-center justify-center absolute rounded-full text-white bg-danger right-0 top-0 -mr-2 -mt-2">'+application_count+'</div>' +
                        //         '</div>'+
                        //     '</div>'+
                        // '</td>' +

                        // '<td class="status">'+
                        //     '<div class="flex justify-center items-center whitespace-nowrap text-'+hiring_status_class+'"><div class="w-2 h-2 bg-'+hiring_status_class+' rounded-full mr-3"></div>'+hiring_status+'</div>' +
                        // '</td>' +

                        // '<td>'+
                        //     '<div class="whitespace-nowrap">Direct bank transfer</div>' +
                        //     '<div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">25 March, 12:55</div>' +
                        // '</td>' +


                        '<td>' +
                            '<div class="flex justify-center items-center">'+
                                '<a id="btn_toggle_application_modal" href="javascript:;" data-job-refno="'+job_ref_no+'" data-applicant-id="'+applicant_id+'" class="w-8 h-8 mr-2 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip " title="Approve"> <i class="fa-solid fa-thumbs-up text-'+button_color+'"></i> </a>'+

                                '<div id="applicant_list_dd" class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 text-slate-400 zoom-in tooltip dropdown" title="More Action">'+
                                    '<a class="flex justify-center items-center" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h items-center text-center text-primary"></i> </a>'+
                                    '<div class="dropdown-menu w-40">'+
                                        '<div class="dropdown-content">'+
                                        '<a id="btn_showDetails" href="javascript:;" data-job-refno="'+job_ref_no+'" data-fullname="'+full_name+'" data-email="'+email+'" data-profile-pic="'+profile_pic+'" data-applicant-id="'+applicant_id+'" class="dropdown-item"> <i class="fa fa-tasks w-4 h-4 mr-2 text-secondary"></i> Details </a>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</td>' +

                        '</tr>' +
                        '';

                    tbl_data_applicant_list.row.add($(cd)).draw();
                    /***/
                }
            }
        }
    });
}

$("body").on('click', '#profile_pic_toggle', function (){

    const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#applicant_list_profile_picture_mdl'));
    mdl.toggle();

    let full_name = $(this).data('fullname');
    let profile_pic = $(this).data('profile');
    let email = $(this).data('email');

    $('#profile_picture_holder').src = $(this).data('');

    let html_data = '<img id="profile_picture_holder" alt="Profile Picture" class="rounded-md" src="'+profile_pic+'">' +
        '<span class="absolute top-0 bg-pending/80 text-white text-xs m-5 px-2 py-1 rounded z-10">Featured</span>'+
        '<div class="absolute bottom-0 text-white px-5 pb-6 z-10">' +
            '<a href="" class="block font-medium text-base">'+full_name+'</a>' +
            '<span class="text-white/90 text-xs mt-3">'+email+'</span>'+
        '</div>';

    $('#applicant_list_profile_holder').html(html_data);

});

$("body").on('click', '#btn_showDetails', function (){

    let applicant_id = $(this).data('applicant-id');
    let job_ref_no = $(this).data('job-refno');

    let profile_pic = $(this).data('profile-pic')
    let full_name = $(this).data('fullname');
    let email = $(this).data('email');

    $("#profile_picture").attr("src", profile_pic);

    let html_data = '<a href="javascript:;" class="block font-medium text-base">'+full_name+'</a> <span class="text-white/90 text-xs mt-3">'+email+'</span>';

    $('#profile_first_name').html(html_data);

    const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#applicant_details_mdl'));
    mdl.toggle();

    __dropdown_close('#applicant_list_dd');



    $.ajax({
        url: bpath + 'application/get/applicant/profile',
        type: "POST",
        data: {
            _token, applicant_id,job_ref_no,
        },
        success: function (response) {
            var data = JSON.parse(response);

            let applied_for = data['applied_for'];

            $('#dt__applied_pos tbody tr').detach();
            $('#dt__applied_pos tbody').append(applied_for);

        }
    });

});

$("body").on('click', '.btn_applied_position', function (){


    let position_ref_num = $(this).data('pos-ref')
    let applicant_id = $(this).data('applicant-id');

    const modal = tailwind.Modal.getOrCreateInstance(document.querySelector('#job_attachment_mdl'));
    modal.toggle();

    get_job_attachments(position_ref_num, applicant_id);

});

function get_job_attachments(position_ref_num, applicant_id){
    $.ajax({
        url: bpath + 'application/get/job/attachments',
        type: "POST",
        data: {
            _token, position_ref_num, applicant_id,
        },
        success: function (response) {
            var data = JSON.parse(response);

            let attachments_list = data['attachments_list'];
            let download_all_btn = data['download_all_btn'];

            $('#dt__attachment_list tbody tr').detach();

            $('#dt__attachment_list tbody').append(attachments_list);

            // $('.download_all_div').html(download_all_btn);
        }
    });
}

$("body").on('click', '#btn_toggle_application_modal', function (){

    const modal = tailwind.Modal.getOrCreateInstance(document.querySelector('#job_approval_mdl'));
    modal.toggle();


    let applicant_id = $(this).data('applicant-id');
    let position_ref_num = $(this).data('job-refno');

    load_data_for_approval(position_ref_num, applicant_id)

});

function load_data_for_approval(position_ref_num, applicant_id){

    $.ajax({
        url: bpath + 'application/get/application/data',
        type: "POST",
        data: {
            _token, position_ref_num, applicant_id
        },
        success: function (response) {
            var data = JSON.parse(response);

            let attachments_list = data['attachments_list'];
            let position_option = data['position_option'];
            let applied_for = data['applied_for'];

            $('#dt__attachment_list tbody tr').detach();
            $('#dt__attachment_list tbody').append(attachments_list);
            $('#dt__approve_applied_pos tbody tr').detach();
            $('#dt__approve_applied_pos tbody').append(applied_for);
        }
    });

}

function select2_event_handler(){

    $('#select_applicant_status').select2({
       placeholder: "Select Status",
    });

    $('#applied_pos').on('select2:select', function (e) {
        // Do something

        let position_ref_num = $(this).val();

        let applicant_id = $(this).children('option:selected').data('applicant-id')

        $('#applicant_id').val(applicant_id);
        $('#job_ref_no').val(position_ref_num);

        $.ajax({
            url: bpath + 'application/get/job/attachments',
            type: "POST",
            data: {
                _token, position_ref_num, applicant_id
            },
            success: function (response) {
                var data = JSON.parse(response);

                let attachments_list = data['attachments_list'];

                $('#dt__attachment_list tbody tr').detach();
                $('#dt__attachment_list tbody').append(attachments_list);

            }
        });

    });

}




$("body").on('click', '.btn_approve', function (){

    let applicant_id = $(this).data('applicant-id');
    let job_ref_no = $(this).data('pos-ref');
    let position_ = $(this).data('pos-title')
    let action_type = $(this).data('action-type');
    let status = $(this).data('status');


    const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#application_approval_mdl'));
    mdl.toggle();

    __dropdown_close("#application_approve_dd");
    approve_button(job_ref_no, applicant_id, action_type, position_);

});

function approve_button(job_ref_no, applicant_id, action_type, position_){

    $("body").on('click', '#btn_submit_approval', function (){

        let application_note = $('#application_note').val();

        approve(job_ref_no, applicant_id, action_type, application_note, position_);
    });
}

function approve(job_ref_no, applicant_id, action_type, application_note, position_){

    $.ajax({
        url: bpath + 'application/approve',
        type: "POST",
        data: {
            _token, job_ref_no, applicant_id, action_type, application_note, position_
        },
        success: function (response) {

            let applicant_id = response.applicant_id;
            let job_ref_no = response.job_ref_no;
            let message = response.message;

            if(response.status == 200)
            {
                __notif_show(1, "Success", message);

                load_data_for_approval(job_ref_no, applicant_id);

                const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#application_approval_mdl'));
                mdl.hide();

                load_applicants_datatable();

                $('#application_note').val("");

            }

        }
    });
}






$("body").on('click', '.btn_disapprove', function (){

    let applicant_id = $(this).data('applicant-id');
    let job_ref_no = $(this).data('pos-ref');
    let position_ = $(this).data('pos-title')
    let action_type = $(this).data('action-type');

    const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#application_approval_mdl'));
    mdl.toggle();

    __dropdown_close("#application_approve_dd");
    disapprove_button(job_ref_no, applicant_id, action_type, position_);

});

function disapprove_button(job_ref_no, applicant_id, action_type, position_){

    $("body").on('click', '#btn_submit_approval', function (){

        let application_note = $('#application_note').val();

        disapprove(job_ref_no, applicant_id, action_type, application_note, position_);
    });
}

function disapprove(job_ref_no, applicant_id, action_type, application_note, position_){

    $.ajax({
        url: bpath + 'application/disapprove',
        type: "POST",
        data: {
            _token, job_ref_no, applicant_id, action_type, application_note, position_,
        },
        success: function (response) {

            let applicant_id = response.applicant_id;
            let job_ref_no = response.job_ref_no;
            let message = response.message;

            if(response.status == 200)
            {
                __notif_show(1, "Success", message);

                load_data_for_approval(job_ref_no, applicant_id);

                const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#application_approval_mdl'));
                mdl.hide();

                load_applicants_datatable();
                $('#application_note').val("");

            }

        }
    });
}

$("body").on('click', '.btn_view_attach_file', function (){

    let position_ref_num = $(this).data('pos-ref')
    let applicant_id = $(this).data('applicant-id');

    const modal = tailwind.Modal.getOrCreateInstance(document.querySelector('#job_attachment_mdl'));
    modal.toggle();


    get_job_attachments(position_ref_num, applicant_id);

});

