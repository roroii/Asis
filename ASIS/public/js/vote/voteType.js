var  _token = $('meta[name="csrf-token"]').attr('content');
var voteType_data_table;
var votePosition_data_table;
var openClose_tbl;
var participants_tbl;
var program_tbl;

var electType_select;
var signatory_select;
var program_select;





$(document).ready(function () {
    bpath = __basepath + "/";
    onSubmit();
    loadData_table();
    fetch_voteType_data();
    OnClick_function();

    fetch_votePosition_data()

    cancelModal();

    select2();
    OnChange_select();

    // fetch_openApplication_data();
    // toggleButton();

    applyRadio_checked();

    checkAll();
    // table_filter();
    

    // enterKey_signatory();


});

function select2(){
    
    electType_select =  $('#electType_select').select2({
        placeholder: "Select Election Type ",
        closeOnSelect: true,

    });
    signatory_select =  $('#signatory_select').select2({
        placeholder: "Select Signatory ",
        closeOnSelect: true,

    });

    program_select =  $('#program_select').select2({
        placeholder: "Select Program ",
        closeOnSelect: true,

    });
}

function loadData_table(){

    voteType_data_table = $('#voteType_tbl').DataTable({
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
        "aLengthMenu": [[5,10,25,50,100,150,200,250,300,-1], [5,10,25,50,100,150,200,250,300,"All"]],
        "iDisplayLength": 10,
        "aaSorting": [],

    });


    votePosition_data_table = $('#votePosition_tbl').DataTable({
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
        "aLengthMenu": [[5,10,25,50,100,150,200,250,300,-1], [5,10,25,50,100,150,200,250,300,"All"]],
        "iDisplayLength": 10,
        "aaSorting": [],

    });

    openClose_tbl = $('#openClose_tbl').DataTable({
        dom:
        "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-6 text_left_1'l><'intro-y col-span-6 text_left_1'f>>"+
        "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-12'tr>>"+
        "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-12'<'datatable_paging_1'p>>>",
        renderer: 'bootstrap',
        "info": false,
        "bInfo":true,
        "bJQueryUI": true,
        "bProcessing": true,
        "bPaginate" : true,
        "aLengthMenu": [[5,10,25,50,100,150,200,250,300,-1], [5,10,25,50,100,150,200,250,300,"All"]],
        "iDisplayLength": 10,
        "aaSorting": [],

    });

    participants_tbl = $('#participants_tbl').DataTable({
        dom:
        "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-6 text_left_1'l><'intro-y col-span-6 text_left_1'f>>"+
        "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-12'tr>>"+
        "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-12'<'datatable_paging_1'p>>>",
        renderer: 'bootstrap',
        "info": false,
        "bInfo":true,
        "bJQueryUI": true,
        "bProcessing": true,
        "bPaginate" : true,
        "aLengthMenu": [[5,10,25,50,100,150,200,250,300,-1], [5,10,25,50,100,150,200,250,300,"All"]],
        "iDisplayLength": 10,
        "aaSorting": [],

    });

    program_tbl = $('#program_tbl').DataTable({
        dom:
        "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-6 text_left_1'l><'intro-y col-span-6 text_left_1'f>>" +
        "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-12'tr>>" +
        "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-12'<'datatable_paging_1'p>>>",
    renderer: 'bootstrap',
    "info": false,
    "bInfo":true,
    "bJQueryUI": true,
    "bProcessing": true,
    "bPaginate" : false,
    "aLengthMenu": [[10,25,50,100,150,200,250,300,-1], [10,25,50,100,150,200,250,300,"All"]],
    "iDisplayLength": 10,
    "aaSorting": [],
        "columnDefs": [
            { "orderable": false, "targets": "_all" } // Disable sorting on all columns
        ],
    });
}

function validateVotingType_input() {
    let voteType = $('#voteType').val();
    let typeDescription = $('#typeDescription').val();
    if (voteType == '') {
            if (typeDescription == '') {
                $('#typeDescriptionlbl').removeClass('hidden');
                $('#voteTypelbl').removeClass('hidden');
            }else{
                $('#voteTypelbl').removeClass('hidden');
                $('#typeDescriptionlbl').addClass('hidden');
            }

        return false;
    } else {
        if (typeDescription == '') {
            $('#typeDescriptionlbl').removeClass('hidden');
            return false;
        }else{
            $('#typeDescriptionlbl').addClass('hidden');
            $('#voteTypelbl').addClass('hidden');

            return true;
        }
    }
}

function validateVotingPosition_input() {
    let votePosition = $('#votePosition').val();
    let position_Description = $('#positionDescription').val();
    if (votePosition == '') {
        $('#votePositionlbl').removeClass('hidden');
            if (position_Description == '') {
                $('#positionDescriptionlbl').removeClass('hidden');

            }else{
                $('#positionDescriptionlbl').addClass('hidden');
            }

        return false;
    } else {
        if (position_Description == '') {
            $('#positionDescriptionlbl').removeClass('hidden');
            return false;
        }else{
            $('#positionDescriptionlbl').addClass('hidden');
            $('#votePositionlbl').addClass('hidden');

            return true;
        }
    }
}

function fetch_voteType_data(){

    $.ajax({
        url:  bpath + 'vote/fetched/vote-type-data',
        type: "get",
        data: {
            _token,
        },
        success: function(data) {

            voteType_data_table.clear().draw();
            /***/
            var data = JSON.parse(data);

            if (data.length > 0) {

                for (let i = 0; i < data.length; i++) {
                    var id_voteType = data[i]['id'];
                    var voteType = data[i]['voteType'];
                    var VoteDiscription = data[i]['VoteDiscription'];

                    var date_openApp = data[i]['date_openApp'];
                    var time_openApp = data[i]['time_openApp'];
                    var date_closeApp = data[i]['date_closeApp'];
                    var time_closeApp = data[i]['time_closeApp'];

                    // console.log(date_openApp+':'+time_openApp+' <===> '+ date_closeApp+':'+time_closeApp);

                    var openApplicationDate = data[i]['openApplicationDate'];
                    var voter = data[i]['voter'];
                    var type_exist = data[i]['type_exist'];

                    var openBtn_text = 'Open';
                    var iconClass = '';
                    var status = '';
                    var statusText = '';
                    var icon_title = '';                      

                    if(openApplicationDate === 'notOpen'){
                        openBtn_text = 'Open';
                        iconClass = 'fa fa-sign-in';
                        iconText = 'text-success';
                        openBTN_title = 'Open Application'; 
                        status = 'No Action';
                        statusText = 'text-slate-500';
                    }else if(openApplicationDate === 'open'){
                        openBtn_text = 'Update';
                        iconClass = 'fa fa-refresh';
                        iconText = 'text-primary';
                        openBTN_title = 'Update Status';   
                        status = 'Aplication is Open';
                        statusText = 'text-success';
                    }else if(openApplicationDate === 'comming'){
                        openBtn_text = 'Update';
                        openBTN_title = 'Update Status'; 
                        iconClass = 'fa fa-refresh';
                        iconText = 'text-primary';
                        status = 'Soon to Open';
                        statusText = 'text-pending';
                    }else{
                        openBTN_title = 'Update Status';   
                        openBtn_text = 'update';
                        iconClass = 'fa fa-refresh';
                        iconText = 'text-pending';
                        status = 'Application is Close';
                        statusText = 'text-danger';
                    }

                    // console.log(type_exist);
                    var editClass = '';
                    var editColor = 'slate-500';
                    var additionalAction = '';
                    if(!type_exist){

                        additionalAction = 
                            '<a id="'+id_voteType+'" data-vote-type="'+voteType+'" data-vote-description="'+VoteDiscription+'"'+
                                'class="dropdown-item editVoteType" href="javascript:;">'+
                                '<i class="fas fa-edit text-success" aria-hidden="true"></i>'+
                                '<span class="ml-2 text-success"> Edit </span>'+
                            '</a>'+

                            '<a id="'+id_voteType+'" data-vote-type="'+voteType+'" data-vote-description="'+VoteDiscription+'"'+
                                'class="dropdown-item deleteVoteType" href="javascript:;">'+
                                '<i class="fa fa-trash text-danger"></i>'+
                                '<span class="ml-2 text-danger"> Delete </span>'+
                            '</a>';
                    }


                    var ii = i+1;

                    var cd = '';
                        /***/

                            cd = '' +
                                '<tr class="whitespace-wrap">'+

                                    '<td>' +
                                            ii+
                                    '</td>' +


                                    '<td>'+

                                        '<a href="#" class="font-medium whitespace-nowrap text-right">'+voteType+'</a>'+
                                        '<div class="text-slate-500 text-xs text-justify mt-0.5">'+VoteDiscription+'</div>'+
                                    
                                    '</td>'+

                                    '<td>' +

                                        '<a href="javascript:;" class="font-medium whitespace-nowrap text-right '+statusText+'">'+status+'</a>'+
                                    
                                    '</td>' +


                                    '<td>' +

                                        '<div class="flex justify-center items-center">'+

                                            '<div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="'+openBTN_title+'">'+
                                                '<a id="'+id_voteType+'" data-vote-type="'+voteType+'"'+
                                                    'data-open-application="'+openApplicationDate+'"'+
                                                    'data-open-application-date="'+date_openApp+'"'+
                                                    'data-open-application-time="'+time_openApp+'"'+
                                                    'data-close-application-date="'+date_closeApp+'"'+
                                                    'data-close-application-time="'+time_closeApp+'"'+
                                                    'class="dropdown-item openApplication" href="javascript:;">'+
                                                    '<i class="'+iconClass+' '+iconText+'" aria-hidden="true"></i>'+
                                                '</a>'+
                                            '</div>'+

                                            '<div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="Add Signatory">'+
                                                '<a id="'+id_voteType+'" data-vote-type="'+voteType+'" data-vote-description="'+VoteDiscription+'"'+
                                                    'class="dropdown-item elec_typeSignatories" href="javascript:;">'+
                                                    '<i class="fas fa-file-signature text-primary"></i>'+
                                                '</a>'+
                                            '</div>'+

                                            '<div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="More Action">'+
                                                '<a class="flex justify-center items-center" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h items-center text-center text-primary"></i> </a>'+
                                                '<div class="dropdown-menu w-auto">'+
                                                    '<div class="dropdown-content">'+

                                                        '<a id="'+id_voteType+'" data-vote-type="'+voteType+'" data-vote-description="'+VoteDiscription+'" data-voter="'+voter+'"'+
                                                            'class="dropdown-item assign_voters" href="javascript:;">'+
                                                            '<i class="fa-solid fa-people-arrows text-primary"></i>'+
                                                            '<span class="ml-2 text-primary"> Voters </span>'+
                                                        '</a>'+

                                                        additionalAction+
                                                        
                                                '</div>'+
                                            '</div>'+


                                        '</div>'+
                                    '</td>' +



                                '</tr>' +
                    '';

                    voteType_data_table.row.add($(cd)).draw();


                    /***/
                }
            }

        }
    });

}

function load_signatory(type_id){
    // console.log(type_id);
    $.ajax({
        type: "GET",
        url: bpath + 'vote/load-signatory',
        data: {type_id:type_id},
        success: function (response) {
            $('#signatory_div').html(response);
        }
    });
}

function load_program(type_id){

    $.ajax({
        type: "get",
        url: bpath + "vote/load-program",
        data: {_token: _token, type_id:type_id},
        dataType: "json",
        success: function (data) {
            // console.log(data);
            try {

                program_tbl.clear().draw();

                var type_exist      = data.exists;
    
                var disabled = '';
                $('#check_all').prop('checked', false).prop('disabled', false);

                console.log(type_exist);
                if(!type_exist){
                    disabled = 'disabled';
                    $('#check_all').prop('disabled', true);
                    $('.save_btn_div').hide();
                }

                console.log(disabled);

                var data = data.program;
    
                if(data.length > 0){
                    for(let i = 0; i < data.length; i++){
                        var program_code    = data[i]['program_code'];
                        var program_desc    = data[i]['program_desc'];
                        var checked         = data[i]['checked'];

                        var row = '';

                        row = `<tr class="cursor-pointer">
                                    <td>
                                        <input id="${program_code}" type="checkbox" name="prog_code[]" value="${program_code}" ${checked} class="prog_code-checkbox" ${disabled}>
                                    </td>
    
                                    <td>
                                        <label style="font-weight: bold;" for="${program_code}">${program_code} - ${program_desc}</label>
                                    </td>
    
                                </tr>`;
    
                                program_tbl.row.add($(row)).draw();
                    }
    
                    
                }
                
            } catch (error) {
                console.log(error);
            }
            
           
        }
    });
}

function checkAll() {
    // Add an event listener to the "check_all" checkbox
    $('input[name="check_all"]').change(function() {
        var isChecked = $(this).prop('checked');
        // Set the checked state of all individual checkboxes within the table body
        $('table#program_tbl tbody input[type="checkbox"]').prop('checked', isChecked);
    });

    // // Add an event listener to the checkboxes with the name "prog_code[]"
    // $('input[name="prog_code[]"]').change(function() {
    //     // Check if the checkbox is checked
    //     var isChecked = $(this).prop('checked');

    //     // Display an alert message when the checkbox is checked
    //     if (isChecked) {
    //         alert('Please enter');
    //     }
    // });
}

var global_assignVoter_typeID;
function OnClick_function() {
    $("body").on('click', '.editVoteType', function () {
        // data-vote-type="'+voteType+'" data-vote-description="
        let vote_type_id = $(this).attr('id')
        let voteType = $(this).data('vote-type')
        let votedescription = $(this).data('vote-description')
        // console.log(vote_type_id);
        $('#typeIDdd').val(vote_type_id);
        $('#voteType').val(voteType);
        $('#typeDescription').val(votedescription);

        $('#typeModalHeader').text('Update '+voteType+'');

        $('#typeDescription').attr('rows', 5);

        var voteType_modal = tailwind.Modal.getOrCreateInstance(document.querySelector("#voteType_modal"));
        voteType_modal.show();


    });    

    $("body").on('click', '.openApplication', function () {
        let voteType_id = $(this).attr('id');
        let voteTypeName = $(this).data('vote-type');
        let opendate = $(this).data('open-application');

        let date_openApp = $(this).data('open-application-date');
        let time_openApp = $(this).data('open-application-time');
        let date_closeApp = $(this).data('close-application-date');
        let time_closeApp = $(this).data('close-application-time');


        if(opendate !== 'notOpen'){
            $('#openDate').val(date_openApp);
            $('#openTime').val(time_openApp);

            $('#closeDate').val(date_closeApp);
            $('#closeTime').val(time_closeApp);
            $('#openAppsetDate_submitBtn').text('Update')
        }else{
            $('#openAppsetDate_submitBtn').text('Set')
        }
        
// console.log(opendate+'<===> '+date_openApp+':'+time_openApp+' <===> '+ date_closeApp+':'+time_closeApp);

        $('#voteTypeID').val(voteType_id);

        $('#header_voteTypeName').text('SET DATE : '+voteTypeName);
        var openVoting_application_Modal = tailwind.Modal.getOrCreateInstance(document.querySelector('#openVoting_application_Modal'));
        openVoting_application_Modal.show();

    });

    $("body").on('click', '.elec_typeSignatories', function () {

        let type_id = $(this).attr('id');
        let type_name = $(this).data('vote-type');

        $('#typeID').val(type_id);
        // console.log(type_id);
        $('#signatory_ModalHeader').text(type_name+' - Signatory');

        load_signatory(type_id)
        const signatory_modal = tailwind.Modal.getOrCreateInstance(document.querySelector("#signatory_modal"));
        signatory_modal.show();
    });

    $("body").on('click', '.assign_voters', function () {
        // alert('123');
        global_assignVoter_typeID = $(this).attr('id')
        let voteType = $(this).data('vote-type')
        let votedescription = $(this).data('vote-description')
        let voter = $(this).data('voter')

        if (voter !== ''){
            program_select.val(voter).trigger('change');
            $('#add_voters_btn').text('Update');
        }else{
            $('#add_voters_btn').text('Save');
        }

        $('#type_idsss').val(global_assignVoter_typeID);
        $('#voters_ModalHeader').text(voteType+' - Voters');

        load_program(global_assignVoter_typeID);

        const voters_modal = tailwind.Modal.getOrCreateInstance(document.querySelector("#voters_modal"));
        voters_modal.show();
        // console.log('type_id : '+ vote_type_id, 'vote_typ : '+ voteType, 'vote_description : '+ votedescription);

    });

    $("body").on('click','#btn_revert', function () {
        load_program(global_assignVoter_typeID)

        $('#program_tbl > thead').find('input[name="check_all"]').prop('checked', false);
    });

    
 // ================================= START OF VOTING POSISTION ON CLICK======================== //

    $("body").on('click', '.editVotePosition', function () {
        // data-vote-position="'+votePosition+'" data-position-desc="'+position_desc+'"'+
        let vote_Position_id = $(this).attr('id')

        // alert(vote_Position_id);
        let votePosition = $(this).data('vote-position')
        let position_desc = $(this).data('position-desc')
        $('#votePositionIDss').val(vote_Position_id);
        $('#votePosition').val(votePosition);
        $('#positionDescription').val(position_desc);

        $('#PositionModalHeader').text('Update '+votePosition+'');

        $('#positionDescription').attr('rows', 5);
        const votePosition_modal = tailwind.Modal.getOrCreateInstance(document.querySelector("#votePosition_modal"));
        votePosition_modal.show();


    });

    $("body").on('click', '.clickPositionRow[data-toggle="checkbox"]', function () {
        var result = clickModalPositionRow.call(this);
        var row = $(this).closest('tr');
        var positionTag = row.find('.a-position');

        var positionID = positionTag.attr('id');
        var positionName = positionTag.text();
        var positionDesc = positionTag.data('position-description');
            // console.validateVotingPosition_input(positionID +' == '+positionName +' == '+positionDesc)

        var noAvalable = $('.positionDiv').find('.noAvailable');

        if(noAvalable){
            noAvalable.remove();
        }

           if (result === true) {
                var existingPosition = $('.positionDiv').find(`[data-position-id="${positionID}"]`);
                // console.log(existingPosition);
                if (!existingPosition.length) {
                    $('.positionDiv').append(`
                        <div class="items-center mb-5 positionItem" data-position-id="${positionID}">
                            <input name="assign_positionID[]" type="hidden" value="0">
                            <input name="positionID[]" type="hidden" value="${positionID}">
                            <input name="positionName[]" type="hidden" value="${positionName}">
                            <div><strong>${positionName}</strong></div>
                            <div class="ml-auto text-pending"></div>
                        </div>
                    `);
                }
            } else {
                var positionToRemove = $('.positionDiv').find(`[data-position-id="${positionID}"]`);
                positionToRemove.remove();

                var finding = $('.positionDiv').find('.positionItem');

                // console.log(finding.length)
                if(finding.length === 0){
                    $('.positionDiv').html(`<div class="flex justify-center items-center h-full noAvailable">

                                                        <h2 class="text-slate-500 text-md"> No Selected position/s.</h2>

                                                    </div>`);
                }

    }

    });

 }

 function onSubmit() {

    $("#VoteType_form").submit(function (e) {
        e.preventDefault();

        const fd = new FormData(this);

       if (validateVotingType_input()) {

            $.ajax({
                url:  bpath + 'vote/add-voting-type',
                method: 'post',
                data: fd,
                cache:false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {

                    if (data.status == 'saved') {
                        __notif_show( 1, "Vote Type Save");
                        $('#VoteType_form')[0].reset();
                        fetch_voteType_data();
                        // $('#typeModalHeader').text('Add Vote Type');
                    }else if(data.status == 'exists') {
                        __notif_show( -1, "Unable to update Vote Type");
                        $('#VoteType_form')[0].reset();

                    }else if(data.status == 'updated'){
                        __notif_show( 1, "Vote Type Updated");
                        $('#VoteType_form')[0].reset();
                        $('#typeModalHeader').text('Add Vote Type');
                        var voteType_modal = tailwind.Modal.getOrCreateInstance(document.querySelector("#voteType_modal"));
                        voteType_modal.hide();
                        fetch_voteType_data();
                    }else{
                        __notif_show( 1, data.message);
                        $('#VoteType_form')[0].reset();
                        var voteType_modal = tailwind.Modal.getOrCreateInstance(document.querySelector("#voteType_modal"));
                        voteType_modal.hide();
                    }
                }
            });
        }

    });

    $('#signatory_form').submit(function (e) { 
        e.preventDefault();

        if (blockEmpty_signatory()) {
            const fd = $(this);
            $.ajax({
                url: bpath + 'vote/add-signatory',
                method: 'post',
                data: fd.serialize(),
                success: function (response) {
                    // console.log(response.type_id);
                    if (response.status == 200) {
                        load_signatory(response.type_id);
                        __notif_show( 1, "Signatory Added successfully");
                        signatory_select.val('').trigger('change');
                        $('#sig_description').val('');
                        // console.log(response.type_id);
                        
                    }
                
                }
            });
        }
        
        
    });

    $('#voters_form').submit(function (e) { 
        e.preventDefault();
       
        // if (blockEmpty_program()) {

            const fd = $(this);
            $.ajax({
                url: bpath + 'vote/assign-voters',
                method: 'post',
                data: fd.serialize(),
                success: function (response) {
                    if (response.status == 200) {
                        fetch_voteType_data();
                        __notif_show( 1, "Voters Set Successfully");
                        load_program(global_assignVoter_typeID)
                    }
                
                }
            });
            
        // }
        
    });

    $("#VotePosition_form").submit(function (e) {
        e.preventDefault();

        const fd = new FormData(this);

       if (validateVotingPosition_input()) {

            $.ajax({
                url:  bpath + 'vote/add-voting-position',
                method: 'post',
                data: fd,
                cache:false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {

                    if (data.status == 'saved') {
                        __notif_show( 1, "Vote Position Save");
                        $('#VotePosition_form')[0].reset();
                        fetch_votePosition_data();
                        // $('#typeModalHeader').text('Add Vote Type');
                    }else if(data.status == 'updated'){
                        __notif_show( 1, "Vote Position Updated");
                        $('#VotePosition_form')[0].reset();
                        fetch_votePosition_data();
                        $('#PositionModalHeader').text('Create Vote Position');
                        const votePosition_modal = tailwind.Modal.getOrCreateInstance(document.querySelector("#votePosition_modal"));
                        votePosition_modal.hide();

                    }else{
                        __notif_show( 1, data.message);
                        $('#VotePosition_form')[0].reset();
                        const votePosition_modal = tailwind.Modal.getOrCreateInstance(document.querySelector("#votePosition_modal"));
                        votePosition_modal.hide();
                    }
                }
            });
        }

    });

    $('#asisgn_position_form').submit(function (e) {
        e.preventDefault();

        if(blockEmptyData()){
            const fd = new FormData(this);

            $.ajax({
                url: bpath + 'vote/assign-positions-dasta',
                type: 'post',
                data: fd,
                caches: false,
                contentType:false,
                processData:false,
                dataType: 'json',
                success: function (response) {
                    if(response.status === 200){
                        __notif_show( 1, "Position Asigned Successsfully");
                        electType_select.val(null).trigger('change');
                        $('#modal_position_tbl .position-checkbox').prop('checked', false);

                        $('.positionDiv').html(`<div class="flex justify-center items-center h-full noAvailable">

                                                    <h2 class="text-slate-500 text-md"> No Selected position/s.</h2>

                                                </div>`);
                    }
                },error: function(error){
                    console.log(error);
                }
            });
        }

    });

    $("#openApplicantion_Date_form").submit(function (e) {
        e.preventDefault();
        if (blockEmptyDate()) {
            const fd = new FormData(this);
            $.ajax({
                url: bpath + 'vote/set/open/voting-application-date',
                type: 'post',
                data: fd,
                caches: false,
                contentType:false,
                processData:false,
                dataType: 'json',
                success: function (response) {
                    if(response.status === 200){
                        $('#openApplicantion_Date_form')[0].reset();
                        var openVoting_application_Modal = tailwind.Modal.getOrCreateInstance(document.querySelector('#openVoting_application_Modal'));
                        openVoting_application_Modal.hide();
                        fetch_voteType_data();
                    }
                },error: function(error){
                    console.log(error);
                }
            });
        }
    });

   

}

 function cancelModal(){

    $("body").on('click', '#btn_voteType_cancel', function () {
        $('#typeDescription').attr('rows', 3);
        $('#typeModalHeader').text('Add Vote Type');
        $('#VoteType_form')[0].reset();
    });

    $("body").on('click', '#btn_votePosition_cancel', function () {

        $('#positionDescription').attr('rows', 3);
        $('#PositionModalHeader').text('Create Vote Position');
        $('#VotePosition_form')[0].reset();
    });

    $("body").on('click','#cancel-apply', function () {
        $('#please_select').removeClass('text-danger');
        // alert('12344')
    });

    $("body").on('click', '#openAppsetDate_cancelBtn', function () {
        $('#openApplicantion_Date_form')[0].reset();
    });

    $("body").on('click', '#cancel_signature_modal', function () {
        $('#signatory_form')[0].reset();
        signatory_select.val('').trigger('change');
    });

 }

 // ================================= END OF VOTING TYPE JS ======================== \\

 // ================================= START OF VOTING POSISTION JS ======================== \\
 function fetch_votePosition_data(){

    
    $.ajax({
        url:  bpath + 'vote/fetched/vote-position-data',
        type: "get",
        data: {
            _token,
        },
        success: function(data) {

            votePosition_data_table.clear().draw();
            /***/
            var data = JSON.parse(data);

            if (data.length > 0) {

                for (let i = 0; i < data.length; i++) {
                        var id_votePosition = data[i]['id'];
                        var votePosition = data[i]['votePosition'];
                        var position_desc = data[i]['position_desc'];

                        var ii = i+1;

                        var cd = '';
                                /***/

                                    cd = '' +
                                            '<tr class="whitespace-wrap">'+

                                                '<td>' +
                                                        ii+
                                                '</td>' +


                                                '<td>'+
                                                    '<a href="#" class="font-medium whitespace-nowrap text-right">'+votePosition+'</a>'+
                                                    '<div class="text-slate-500 text-xs text-justify mt-0.5">'+position_desc+'</div>'+
                                                '</td>'+


                                                '<td>' +

                                                    '<div class="flex justify-center items-center">'+

                                                        '<div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="More Action">'+
                                                            '<a class="flex justify-center items-center" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h items-center text-center text-primary"></i> </a>'+
                                                            '<div class="dropdown-menu w-40">'+
                                                                '<div class="dropdown-content">'+
                                                                    '<a id="'+id_votePosition+'" data-vote-position="'+votePosition+'" data-position-desc="'+position_desc+'"'+
                                                                        'class="dropdown-item editVotePosition" href="javascript:;">'+
                                                                        '<i class="fa fa-edit text-success" aria-hidden="true"></i>'+
                                                                        '<span class="ml-2">Edit</span>'+
                                                                    '</a>'+
                                                                    '<a id="'+id_votePosition+'"'+
                                                                        'class="dropdown-item deleteVotePosition" href="javascript:;">'+
                                                                        '<i class="fa fa-trash text-danger"></i>'+
                                                                        '<span class="ml-2">Delete</span>'
                                                                    '</a>'+
                                                                '</div>'+
                                                            '</div>'+
                                                        '</div>'+


                                                    '</div>'+
                                                '</td>' +



                                            '</tr>' +
                                    '';

                                    votePosition_data_table.row.add($(cd)).draw();


                                /***/


                }
            }

        }
    });

}

 // =================================  START OF VOTING POSISTION JS ===================== \\

function OnChange_select(){
    $('#electType_select').change(function (e) {
        e.preventDefault();
        let typeID = $(this).val()
        // alert(typeID)
        $.ajax({
                url:  bpath + 'vote/filter/position-data',
                type: "get",
                data: {
                    _token, typeID
                },
                success: function (res) {
                    var data;

                    // console.log(res);
                    try {
                        $('.positionDiv').empty();
                        if(res !== ''){
                            data = JSON.parse(res);

                            var content = '';

                            // console.log(Array.isArray(data) && data.length);

                            if (Array.isArray(data) && data.length > 0) {
                                $('#modal_position_tbl .position-checkbox').prop('checked', false);
                            for (let i = 0; i < data.length; i++) {
                                var assign_positionID = data[i]['assign_id']
                                var positionID = data[i]['id'];
                                var vote_position = data[i]['vote_position'];
                                var position_desc = data[i]['position_desc'];

                                var modal_position_tbl = $('#modal_position_tbl');

                                var matchingPosition = modal_position_tbl.find('.a-position[id="' + positionID + '"]');
                                var positionCheckbox = matchingPosition.closest('tr').find('.position-checkbox');

                                // console.log(`Position ID: ${positionID}`);
                                // console.log(`Matching Position Length: ${matchingPosition.length}`);
                                if (matchingPosition.length > 0) {

                                    positionCheckbox.prop('checked', true);
                                }

                                var row = `<div class="items-center mb-5 positionItem" data-position-id="${positionID}">
                                                <input name="assign_positionID[]" type="hidden" value="${assign_positionID}">
                                                <input name="positionID[]" type="hidden" value="${positionID}">
                                                <input name="positionName[]" type="hidden" value="${vote_position}">
                                                <div><strong>${vote_position}</strong></div>
                                                <div class="ml-auto text-pending"></div>
                                            </div>`;

                                content += row;
                            }

                            } else {
                            content = `<div class="flex justify-center items-center h-full noAvailable">

                                            <h2 class="text-slate-500 text-md"> No Selected position/s.</h2>

                                        </div>`;
                            }

                            $('.positionDiv').html(content);
                        }else{

                            var modal_position_tbl = $('#modal_position_tbl');

                                var matchingPosition = modal_position_tbl.find('.position-checkbox');

                                if (matchingPosition) {

                                    matchingPosition.prop('checked', false);
                                }

                            $('.positionDiv').html(`<div class="flex justify-center items-center h-full noAvailable">

                                                        <h2 class="text-slate-500 text-md"> No Selected position/s.</h2>

                                                    </div>`);
                        }


                    }catch (error) {
                    console.error("Error parsing JSON response:", error);
                    // Handle the error appropriately, such as showing an error message to the user
                    // or taking some other corrective action.
                    }
                }, error: function(xhr, status, error) {
                    console.error("AJAX Request Error:", error);
                    // Handle the AJAX error appropriately
                }

        });

    });
}

function clickModalPositionRow() {

    var checkbox = $(this).find('.position-checkbox');

    if (checkbox.prop('checked')) {
        checkbox.prop('checked', false);
        return false;
    } else {
        checkbox.prop('checked', true);
        return true;
    }
}

function blockEmpty_signatory() {

    if($('#signatory_select').val() == '') {
        $('#signatory_select').select2({
            theme: "error",
            placeholder: "Signatory is required",
        });
        if ($('#sig_description').val() == '') {
            $('#sig_description').css('border-color', 'red')
        }else{
            $('#sig_description').css('border-color', '')
        }
        return false;
    }else{
        $('#signatory_select').select2({
            placeholder: "Select Signatory",
            closeOnSelect: true,
            allowClear:true,
        });
        if ($('#sig_description').val() == '') {
            $('#sig_description').css('border-color', 'red')
            return false;
        }else{
            $('#sig_description').css('border-color', '')
            return true;
        }
        
    }
}

function  blockEmptyData(){
    var positionDivvv = $('.positionDiv').find('.positionItem');
    var voteType_select = $('#electType_select');
    var please_select = $('#please_select');
// console.log(voteType_select.val());


    if(voteType_select.val() !== ''){

        voteType_select.select2({
            placeholder: "Select Election Type",
            closeOnSelect: true,
            allowClear:true,
        });

            if(positionDivvv.length === 0){
                please_select.addClass('text-danger')
                return false;
                
            }else{
                please_select.removeClass('text-danger')
                return true;
            }
        
        
    }else{

        voteType_select.select2({
            theme: "error",
            placeholder: "Election Type is Required",
        });
        if(positionDivvv.length === 0){
            please_select.addClass('text-danger')
            
        }else{
            please_select.removeClass('text-danger')
        }
        return false;
    }

}

function blockEmptyDate() {
    var openDate = $('#openDate')[0]; // Get the DOM element
    var closeDate = $('#closeDate')[0]; // Get the DOM element

    var openTime = $('#openTime')[0];
    var closeTime = $('#closeTime')[0];

    var openDate_lbl = $('#openDate_lbl');
    var closeDate_lbl= $('#closeDate_lbl');

    if (openDate.value !== '' && closeDate.value !== '') {

        if (openDate.value > closeDate.value) {


            openDate.style.borderColor = 'red';
            closeDate.style.borderColor = 'red';
            openDate_lbl.removeClass('hidden');
            closeDate_lbl.text('Closing Date must not be lesser than the opening Date');
            closeDate_lbl.removeClass('hidden');

            return false;
        }else if(openDate.value === closeDate.value){

            if (openTime.value !== '' && closeTime.value !== '') {

                if (openTime.value > closeTime.value) {
                    openDate.style.borderColor = 'red';
                    openTime.style.borderColor = 'red';
                    openDate_lbl.removeClass('hidden');

                    return false;

                } else if(openTime.value === closeTime.value){
                    closeDate.style.borderColor = 'red';
                    closeTime.style.borderColor = 'red';
                    openDate.style.borderColor = '';
                    openTime.style.borderColor = '';
                    closeDate_lbl.text('Closing Date must no be the same of opening date');
                    closeDate_lbl.removeClass('hidden');
                    openDate_lbl.addClass('hidden');

                    return false;
                }else{
                    openDate.style.borderColor = '';
                    closeDate.style.borderColor = '';
                    openTime.style.borderColor = '';
                    closeTime.style.borderColor = '';
                    closeDate_lbl.text('Closing Date must not be lesser than the opening Date');
                    closeDate_lbl.addClass('hidden');
                    openDate_lbl.addClass('hidden');

                    return true;
                }

            } else {

                if (openTime.value === '') {
                    openTime.style.borderColor = 'red';
                    if (closeTime.value === '') {
                        closeTime.style.borderColor = 'red';
                    }else{
                        closeTime.style.borderColor = '';
                    }

                } else {
                    closeTime.style.borderColor = 'red';
                    openTime.style.borderColor = '';
                }

                return false;
            }
        }else{
            openDate.style.borderColor = '';
            closeDate.style.borderColor = '';
            closeTime.style.borderColor = '';
            closeDate_lbl.text('Closing Date must not be lesser than the opening Date');
            closeDate_lbl.addClass('hidden');
            openDate_lbl.addClass('hidden');

            if (openTime.value !== '' && closeTime.value !== '') {
                openDate.style.borderColor = '';
                closeDate.style.borderColor = '';
                openTime.style.borderColor = '';
                closeTime.style.borderColor = '';
                closeDate_lbl.text('Closing Date must not be lesser than the opening Date');
                closeDate_lbl.addClass('hidden');
                openDate_lbl.addClass('hidden');

                return true;
            } else {
                if (openTime.value === '') {
                    openTime.style.borderColor = 'red';
                    if (closeTime.value === '') {
                        closeTime.style.borderColor = 'red';

                    }else{
                        closeTime.style.borderColor = '';
                    }

                } else {
                    openTime.style.borderColor = '';
                    closeTime.style.borderColor = 'red';
                }
                return false;
            }

        }

    } else {
        if (openDate.value === '') {
            openDate.style.borderColor = 'red';
            if (closeDate.value !== '') {
                closeDate.style.borderColor = '';
            } else {
                closeDate.style.borderColor = 'red';
            }
        } else {
            openDate.style.borderColor = '';
            closeDate.style.borderColor = 'red';
        }

        return false;
    }
}


// function toggleButton() {

//     /*---the span.toggle-indicator Name Moving Right and Left --*/

//     $("body").on('click', '#id_voteType', function () {
//         const toggleButton = $(this);
//         const buttonLabel = toggleButton.find(".button-text");
//         const toggleIndicator = toggleButton.find(".toggle-indicator");

//         toggleButton.toggleClass("inactive");
//         if (toggleButton.hasClass("inactive")) {
//             // toggleIndicator.removeClass("bg-danger").addClass("bg-primary");
//             buttonLabel.text("Close");
//             // toggleIndicator.find(".initial-position").removeClass("fa-toggle-off").addClass("fa-circle-arrow-right");
//         } else {
//             // toggleIndicator.removeClass("bg-primary").addClass("bg-danger");
//             buttonLabel.text("Open");
//             // toggleIndicator.find(".initial-position").removeClass("fa-circle-arrow-right").addClass("fa-toggle-off");
//         }
//         toggleIndicator.toggleClass("inactive");

//         // Toggle the move-left class on the toggle-indicator
//         toggleIndicator.toggleClass("move-left");
//         buttonLabel.toggleClass("move-center");
//     });


// }

function applyRadio_checked(){
    window.onload = function() {
        var rows = document.querySelectorAll('.applyPosition');

        rows.forEach(function(row) {
          row.addEventListener('click', function() {
            var radio = row.querySelector('.form-check-input');
            radio.checked = true;
          });
        });
      };
}

function printAllVoters() {
    var type_idsssValue = document.getElementById('type_idsss').value;
    var printUrl = bpath + "vote/print-all-voters/" + type_idsssValue;
    window.open(printUrl, '_blank');
}


















