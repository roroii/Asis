var  _token = $('meta[name="csrf-token"]').attr('content');
var schedule_id = '';
var days_modal = '';
var esms_faculty = '';
var agency_employee = '';
var dt__faculty_subjects;
var dt__linked_data;
// var filter_sem = '';

var sy = '';
var sm = '';
var sc = '';
var sec = '';
var scd = '';
var blk = '';
var fid = '';
var pk = '';

$(document).ready(function (){

    bpath = __basepath + "/";
    load_dropdown_days();
    load_subjects_datatable();
    load_linked_datatable();
    load_subject_data_list();
    load_linked_data_list();
});

function load_dropdown_days() {

    days_modal = $('#days_modal').select2({
        placeholder: "Select Employee",
        allowClear: true,
        closeOnSelect: false,
        width: "100%",
    });
    modal_sem = $('#modal_sem').select2({
        placeholder: "Select Employee",
        allowClear: true,
        closeOnSelect: false,
        width: "100%",
    });
    esms_faculty = $('#esms_faculty').select2({
        placeholder: "Select Faculty",
        allowClear: true,
        closeOnSelect: false,
        width: "100%",
    });
    agency_employee = $('#agency_employee').select2({
        placeholder: "Select Employee",
        allowClear: true,
        closeOnSelect: false,
        width: "100%",
    });

}

function load_subjects_datatable(){
    try{
        /***/
        dt__faculty_subjects = $('#dt__faculty_subjects').DataTable({
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
                    {
                        className: "dt-head-center",
                        targets: [  13 ],
                        "orderable": false,
                    },
                ],

        });

    /***/
    }catch(err){  }
}

function load_linked_datatable(){
    dt__linked_data = $('#dt__linked_data').DataTable({
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
                {
                    className: "dt-head-center",
                    targets: [  2 ],
                    "orderable": false,
                },
            ],
    });
}

function load_subject_data_list() {
    showLoading();
    $.ajax({
        url: bpath + 'faculty-monitoring/load/subject',
        type: "POST",
        data: {
            _token: _token,
            filter_year: $('#filter_year').val(),
            filter_sem: $('#filter_sem').val(),
        },
        success: function(data) {

            dt__faculty_subjects.clear().draw();
            /***/
            var data = JSON.parse(data);

            if(data.length > 0) {
                for(var i=0;i<data.length;i++) {

                    /***/
                    var oid = data[i]['oid'];
                    var sy = data[i]['sy'];
                    var sem = data[i]['sem'];
                    var subjcode = data[i]['subjcode'];
                    var section = data[i]['section'];
                    var subjsecno = data[i]['subjsecno'];
                    var days = data[i]['days'];
                    var time = data[i]['time'];
                    var room = data[i]['room'];
                    var bldg = data[i]['bldg'];
                    var block = data[i]['block'];
                    var maxstud = data[i]['maxstud'];
                    var forcoll = data[i]['forcoll'];
                    var fordept = data[i]['fordept'];
                    var lock = data[i]['lock'];
                    var facultyload = data[i]['facultyload'];
                    var tuitionfee = data[i]['tuitionfee'];
                    var facultyid = data[i]['facultyid'];
                    var primary_key = data[i]['primary_key'];
                    var status = data[i]['status'];
                    var class_color = data[i]['class_color'];
                    var status_btn = data[i]['status_btn'];
                    /***/

                    cd = '' +
                        '<tr>' +

                    //facultyid
                    '<td style="width:200px" class="facultyid text-center">' +
                        facultyid+
                    '</td>' +

                    //subjcode
                    '<td  class="subjcode">' +
                        subjcode+
                    '</td>' +

                    //section
                    '<td  class="section">' +
                        section+
                    '</td>' +

                    //days
                    '<td style="display:none" class="days">' +
                        days+
                    '</td>' +

                   //time
                   '<td style="display:none" class="time">' +
                        time+
                    '</td>' +

                    //room
                    '<td style="display:none" class="room">' +
                        room+
                    '</td>' +

                    //bldg
                    '<td style="display:none" class="bldg">' +
                        bldg+
                    '</td>' +

                    //block
                    '<td  class="block_data">' +
                         block+
                    '</td>' +

                    //maxstud
                    '<td class="maxstud">' +
                        maxstud+
                    '</td>' +

                    //forcoll
                    '<td  class="forcoll">' +
                        forcoll+
                    '</td>' +

                    //fordept
                    '<td  class="fordept">' +
                        fordept+
                    '</td>' +

                    //facultyload
                    '<td  class="facultyload">' +
                        facultyload+
                    '</td>' +

                    //classs status
                    '<td  class="facultyload">' +
                        '<div class="w-full mt-3 xl:mt-0 flex-1">' +
                            '<div class="form-check form-switch">' +
                                status_btn +
                                '<label class="form-check-label text-'+class_color+'" >'+status+'</label>' +
                            '</div>' +
                        '</div>' +
                    '</td>' +

                    //actions
                    '<td class="items-center">' +
                        '<div class="flex justify-center items-center">'+
                            //new btn
                                '<div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="More Action">'+
                                    '<a class="flex justify-center items-center" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h items-center text-center text-primary"></i> </a>'+
                                    '<div class="dropdown-menu w-40">'+
                                        '<div class="dropdown-content">'+
                                            //new btn
                                            '<a id="btn_for_update_link_meeting" href="javascript:;" class="dropdown-item" data-id-sy="'+sy+'" data-id-sm="'+sem+'" data-id-sc="'+subjcode+'" data-id-sec="'+section+'" data-id-scd="'+subjsecno+'" data-id-blk="'+block+'" data-id-fid="'+facultyid+'" data-id-fc="'+forcoll+'" data-id-pk="'+primary_key+'"> <i class="fa fa-edit w-4 h-4 mr-2 text-success"></i> Edit </a>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                        '</div>'+
                    '</td>' +

                    '</tr>';

                        dt__faculty_subjects.row.add($(cd)).draw();
                    /***/
                }
            }
            hideLoading();
        }
    });
}

function load_linked_data_list(){
    showLoading();
    $.ajax({
        url: bpath + 'faculty-monitoring/load/linked',
        type: "POST",
        data: {
            _token: _token,
            esms_faculty: $('#esms_faculty').val(),
            agency_employee: $('#agency_employee').val(),
        },
        success: function(data) {

            dt__linked_data.clear().draw();
            /***/
            var data = JSON.parse(data);

            if(data.length > 0) {
                for(var i=0;i<data.length;i++) {

                    /***/

                    var esms_faculty_id = data[i]['esms_faculty_id'];
                    var hris_agency_id = data[i]['hris_agency_id'];
                    var fullname = data[i]['fullname'];


                    /***/

                    cd = '' +
                        '<tr >' +

                    //to_id
                        '<td class="to_id">' +
                        fullname+
                        '</td>' +

                    //user_id
                    '<td  class="subjcode">' +
                        esms_faculty_id+
                    '</td>' +

                    //user_id
                    '<td  class="subjcode">' +
                        esms_faculty_id+
                    '</td>' +

                    //user_id
                    '<td  class="subjcode">' +
                        hris_agency_id+
                    '</td>' +

                    //user_id
                    '<td  class="subjcode">' +
                        hris_agency_id+
                    '</td>' +

                    //actions
                        '<td>' +
                            '<div class="flex justify-center items-center">'+
                                '<button class="zoom-in w-5 h-5 bg-red-500 rounded-full flex items-center justify-center text-white text-2xl shadow-md"onclick="handleDeleteClick()"><i class="w-2 h-2 fas fa-trash"></i></button>'
                            '</div>'+
                        '</td>' +

                        '</tr>' +
                        '';

                        dt__linked_data.row.add($(cd)).draw();
                    /***/
                }
            }
            hideLoading();
        }
    });
}

$('#filter_year').change(function()
{
    load_subject_data_list();
});

$('#filter_sem').change(function()
{
    load_subject_data_list();
});

$('#esms_faculty').change(function()
{

    load_linked_data_list();
});

$('#agency_employee').change(function()
{

    load_linked_data_list();

});

$("body").on("click", "#add_new_schedule_btn", function (ev) {

    schedule_id = $('#schedule_id').val();

    var days_list = [];

    $('#days_modal :selected').each(function(i, selected) {
        days_list[i] = $(selected).val();
    });

    $.ajax({
        url: bpath + "faculty-monitoring/add/schedule",
        type: "POST",
        data: {
            _token:_token,
            schedule_id:schedule_id,
            modal_subject_name:$('#modal_subject_name').val(),
            modal_subject_code:$('#modal_subject_code').val(),
            modal_type:$('#modal_type').val(),
            days_modal:$('#days_modal').val(),
            modal_date_time:$('#modal_date_time').val(),
            modal_status:$('#modal_status').val(),
            modal_year:$('#modal_year').val(),
            modal_sem:$('#modal_sem').val(),
            modal_Description:$('#modal_Description').val(),
        },
        cache: false,
        success: function(data) {

            var data = JSON.parse(data);
            console.log(data);

            const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#add_new_schedule_modal'));
            mdl.hide();
            clear_fields();
        }
    });

});

$("body").on("click", "#add_new_linking_btn", function (ev) {

    var esms_facultyList = [];
    var agency_employeeList = [];

    $('#esms_faculty :selected').each(function(i, selected) {
        esms_facultyList[i] = $(selected).val();
    });

    $('#agency_employee :selected').each(function(i, selected) {
        agency_employeeList[i] = $(selected).val();
    });

    if($('#esms_faculty').val() != '' && $('#agency_employee').val() != ''){
        $.ajax({
            url: bpath + "faculty-monitoring/add/linked",
            type: "POST",
            data: {
                _token:_token,
                esms_facultyList:$('#esms_faculty').val(),
                agency_employeeList:$('#agency_employee').val(),
            },
            cache: false,
            success: function(data) {

                var data = JSON.parse(data);
                console.log(data);

                const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#lingking_agency_esms_modal'));
                mdl.hide();

            }
        });
    }


});

$("body").on("click", "#btn_for_update_link_meeting", function (ev){
    ev.preventDefault();

    if(!ev.detail || ev.detail == 1){

        sy = $(this).data('id-sy');
        sm = $(this).data('id-sm');
        sc = $(this).data('id-sc');
        sec = $(this).data('id-sec');
        scd = $(this).data('id-scd');
        blk = $(this).data('id-blk');
        fid = $(this).data('id-fid');
        fc = $(this).data('id-fc');
        pk = $(this).data('id-pk');


        $.ajax({
            url: bpath + "faculty-monitoring/load/link/meeting/update",
            type: "POST",
            data: {
                _token:_token,
                pk:pk,
            },
            cache: false,
            success: function(data) {
                var data = JSON.parse(data);

                if(data['get_status']){

                    $('#modal_link_meeting').val(data['get_status']['link_meeting']);
                    $('#modal_link_meeting_description').val(data['get_status']['link_meeting_description']);

                }else{

                    clear_fields();

                }

                const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#modal_update_link_meeting'));
                mdl.toggle();
            }
        });

    }

});

$("body").on("click", "#add_update_link_meeting_modal_btn", function (ev){
    ev.preventDefault();

    if(!ev.detail || ev.detail == 1){

        const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#modal_update_link_meeting'));
                mdl.toggle();
        $.ajax({
            url: bpath + "faculty-monitoring/add/link/meeting",
            type: "POST",
            data: {
                _token:_token,
                sy:sy,
                sm:sm,
                sc:sc,
                sec:sec,
                scd:scd,
                blk:blk,
                fid:fid,
                fc:fc,
                pk:pk,
                modal_link_meeting:$('#modal_link_meeting').val(),
                modal_link_meeting_description:$('#modal_link_meeting_description').val(),
            },
            cache: false,
            success: function(data) {
                var data = JSON.parse(data);

                const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#modal_update_link_meeting'));
                mdl.hide();
                load_subject_data_list();
                clear_fields();
            }
        });
    }

});


$("body").on("click", "#add_update_link_modal_btn", function (ev) {
    ev.preventDefault();

    if(!ev.detail || ev.detail == 1){

        if($('#esms_faculty').val() != ''){
            $.ajax({
                url: bpath + "faculty-monitoring/add/linked",
                type: "POST",
                data: {
                    _token:_token,
                    esms_facultyList:$('#esms_faculty').val(),
                    agency_employeeList:$('#agency_employee').val(),
                },
                cache: false,
                success: function(data) {
                    var data = JSON.parse(data);

                    const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#lingking_agency_esms_modal'));
                    mdl.hide();

                }
            });
        }

    }



});


function clear_fields(){
    days_modal.val(null).trigger('change');
    $('#modal_subject_name').val('');
    $('#modal_subject_code').val('');
    $('#modal_type').val('');
    $('#modal_date_time').val('');
    $('#modal_status').val('');
    $('#modal_year').val('');
    $('#modal_sem').val('');
    $('#modal_Description').val('');
    $('#modal_link_meeting').val('');
    $('#modal_link_meeting_description').val('');
}

function checkClickFunc($primary_key,$link_meeting,$class_id)
{
var checkbox = document.getElementById($primary_key);
var link_meeting = checkbox.dataset.idLnk;

var route_ = '';
 if (checkbox.checked == true)
 {
    alert("Class Started");
    route_ = 'faculty-monitoring/add/class/started';
 }else{
    alert("Class Ended");
    route_ = 'faculty-monitoring/add/class/ended';
 }

 $.ajax({
    url: bpath + route_,
    type: "POST",
    data: {
        _token:_token,
        primary_key:$primary_key,
        link_meeting:$link_meeting,
        class_id:$class_id,
        link_meeting_text:link_meeting,
    },
    cache: false,
    success: function(data) {
        var data = JSON.parse(data);
        console.log(data);
        load_subject_data_list();

    }
});
}
