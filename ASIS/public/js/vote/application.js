var  _token = $('meta[name="csrf-token"]').attr('content');
// var voteType_data_table;
// var votePosition_data_table;
var openClose_tbl;
// var participants_tbl;

var applicant_select;
var applicant_parties;





$(document).ready(function () {
    bpath = __basepath + "/";
    onSubmit();
    loadData_table();
    // fetch_voteType_data();
    OnClick_function();

    // fetch_votePosition_data()

    cancelModal();
    // DeleteVoteData();

    select2();
    on_change_function();

    fetch_openApplication_data();

    // toggleButton();

    // applyRadio_checked();

    // enterKey_signatory();

    handleActiveCandidate();


});

function loadData_table(){

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
}
function cancelModal(){
    $("body").on('click' ,'.cancel-apply', function () {
        applicant_select.val('').trigger('change');
        applicant_parties.empty();
        $('#applied_for_position_form')[0].reset();
    });
}


function select2(){
    applicant_select =  $('#applicant').select2({
        placeholder: "Select Applicant ",
        closeOnSelect: true,

    });

    applicant_parties =  $('#applicant_parties').select2({
        placeholder: "Select Parties ",
        closeOnSelect: true,

    });
}

function fetch_openApplication_data(){

    $.ajax({
        url:  bpath + 'vote/fetched/open/application-data',
        type: "get",
        data: {
            _token,
        },
        dataType: "json",
        success: function(data) {
            try {
                openClose_tbl.clear().draw();
            /***/
                var admin = data.admin;
                var applicationData = data.open_application_datas;
                // var data = JSON.parse(applicatioData);

                if (Array.isArray(applicationData) && applicationData.length > 0) {

                    for (let i = 0; i < applicationData.length; i++) {
                            var open_Application_id = applicationData[i]['open_Application_id'];
                            var vote_typeID = applicationData[i]['vote_typeID'];
                            var voteType = applicationData[i]['vote_typeName'];

                            var openVoting_date = applicationData[i]['openVoting_date'];
                            var voting_time_open = applicationData[i]['voting_time_open'];
                            var closeVoting_date = applicationData[i]['closeVoting_date'];
                            var voting_time_close = applicationData[i]['voting_time_close'];

                            var openTimeDate = applicationData[i]['openTimeDate'];
                            var openVoting_status = applicationData[i]['openVoting_status'];
                            var applied = applicationData[i]['applied'];
                            // var VoteDiscription = data[i]['VoteDiscription'];


                            var ii = i+1;

                            var inactive = '';
                            var apply_class = '';
                            var applyText = '';
                            var btn_text = '';
                            var applyZoom = '';
                            var apply_title = '';
                            var apply_icon = '';

                            var openVote_text = '';
                            var openVote_Class = '';
                            var openVote_Zoom = '';
                            var openVote_Icon = '';
                            var openVote_Title = '';

                            //CHECK IF VOTING APPLICATION IS ALREADY OPEN
                            if(openTimeDate === 1){

                                inactive = 'success';
                                apply_class = 'applying';
                                btn_text = 'Application is Open';
                                openVote_Icon = 'fa fa-calendar';
                                openVote_Zoom = '';
                                applyZoom = 'zoom-in';
                                openVote_Title = 'Unavailable';
                                openVote_text = 'slate-400';
                                openVote_Class = '';

                                // if(applied === 1){
                                //     apply_icon = 'fa fa-info-circle';
                                //     applyText = 'success';
                                //     apply_title = 'Already Applied';
                                // }else{
                                    apply_icon = 'fa fa-street-view';
                                    applyText = 'primary';
                                    apply_title = 'Apply';
                                // }

                                // openVote_text = 'slate-400';

                            }else if(openTimeDate === 2){
                                apply_icon = 'fa fa-street-view';
                                inactive = 'pending';
                                apply_class = '';
                                applyText = 'slate-400';
                                btn_text = 'Waiting';
                                applyZoom = '';
                                openVote_Title = 'Open Voting Unabled';
                                openVote_Icon = 'fa fa-calendar';
                                openVote_text = 'slate-400';
                                openVote_Class = '';
                                openVote_Zoom = '';

                            }else{
                                apply_icon = 'fa fa-street-view';
                                inactive = 'danger';
                                apply_class = '';
                                applyText = 'slate-400';
                                applyZoom = '';


                                if (openVoting_status === 'close') {
                                    openVote_Title = 'Extend Voting';
                                    openVote_Icon = 'fa fa-calendar';
                                    openVote_Class = 'Open_voting';
                                    openVote_text = 'danger';
                                    openVote_Zoom = 'zoom-in';
                                    btn_text = 'This Election Ends';
                                } else if(openVoting_status === 'open'){
                                    openVote_Title = 'Ongoing Voting';
                                    openVote_text = 'pending';
                                    openVote_Icon = 'fa fa-calendar fa-spin';
                                    openVote_Class = 'Open_voting';
                                    btn_text = "Application Close";
                                    openVote_Zoom = 'zoom-in';

                                }else if(openVoting_status === 'comming'){
                                    openVote_Title = 'Waiting Voting';
                                    openVote_Icon = 'fa fa-calendar';
                                    openVote_text = 'pending';
                                    openVote_Class = '';
                                    openVote_Zoom = 'zoom-in';
                                    btn_text = "Application Close";
                                }else{
                                    openVote_Title = 'Open Voting';
                                    openVote_Icon = 'fa fa-calendar';
                                    openVote_text = 'primary';
                                    openVote_Class = 'Open_voting';
                                    openVote_Zoom = 'zoom-in';
                                    btn_text = "Application Close";
                                }
                            }

                            //CHECK IF APPLIED
                            var isApplied = applied ? true : false;

                            //CHECK IF ADMIN
                            var action = '';
                            if(admin == 1){
                                action =` <td>
                                            <div class="flex justify-center items-center">

                                                <a id="${open_Application_id}"
                                                    data-vote-type-id="${vote_typeID}"
                                                    data-vote-type-name="${voteType}"
                                                    data-open-voting-date="${openVoting_date}"
                                                    data-voting-time-open="${voting_time_open}"
                                                    data-close-voting-date="${closeVoting_date}"
                                                    data-voting-time-close="${voting_time_close}"
                                                    data-voting-time-status="${openVoting_status}"
                                                    class="${openVote_Class}" href="javascript:;">

                                                    <div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 ${openVote_Zoom} tooltip dropdown" title="${openVote_Title}">
                                                        <i class="${openVote_Icon} text-${openVote_text}" aria-hidden="true"></i>
                                                    </div>
                                                </a>

                                                <a id="" data-applied="${applied}"
                                                        data-vote-type-id="${vote_typeID}"
                                                        data-vote-type-name="${voteType}"
                                                        class="${apply_class}" href="javascript:;">

                                                    <div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 ${applyZoom} tooltip dropdown" title="${apply_title}">

                                                        <i class="${apply_icon} text-${applyText}" aria-hidden="true"></i>

                                                    </div>
                                                </a>

                                                <div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="More Action">
                                                    <a class="flex justify-center items-center" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h items-center text-center text-primary"></i> </a>
                                                    <div class="dropdown-menu w-40">
                                                        <div class="dropdown-content">
                                                            <a data-applied="${applied}"
                                                                data-vote-type-id="${vote_typeID}"
                                                                data-vote-type-name="${voteType}"
                                                                class="dropdown-item viewCandidateList" href="javascript:;">
                                                                <i class="fas fa-users text-success"></i>
                                                                <span class="ml-2">Candidates</span>
                                                            </a>
                                                           
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </td>`;
                            }else{
                                
                                action = `<td>
                                                <div class="flex justify-center items-center">
                                                    <div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="More Action">
                                                        <a class="flex justify-center items-center" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h items-center text-center text-primary"></i> </a>
                                                        <div class="dropdown-menu w-40">
                                                            <div class="dropdown-content">
                                                                <a data-applied="${applied}"
                                                                    data-vote-type-id="${vote_typeID}"
                                                                    data-vote-type-name="${voteType}"
                                                                    class="dropdown-item viewCandidateList" href="javascript:;">
                                                                    <i class="fas fa-users text-success"></i>
                                                                    <span class="ml-2">Candidates</span>
                                                                </a>
                                                            
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </td>`;
                            }


                            var cd = '';
                                    /***/

                                    cd = `<tr class="whitespace-wrap">

                                        <td>
                                                ${ii}
                                        </td>


                                        <td>
                                            <a href="#" class="font-medium whitespace-nowrap text-right">${voteType}</a>
                                            <div class="text-slate-500 text-xs text-justify mt-0.5">VoteDiscription</div>
                                        </td>

                                        <td>
                                            <div class="flex">
                                                <div id="id_voteType" data-vote-type-id="${vote_typeID}"
                                                    <span class="text-${inactive} button-text">${btn_text}</span>
                                                </div>

                                                <span class="text-${isApplied ? 'success' : 'slate-500'} ml-auto text-xs text-justify mt-0.5">
                                                    ${ isApplied ? 'Participated' : '' }
                                                </span>
                                            </div>
                                            
                                        </td>


                                            ${action}


                                    </tr>`;


                                openClose_tbl.row.add($(cd)).draw();


                    }
                }
            } catch (error) {
                console.log(error);
            }

        }
    });

}

function OnClick_function(){
    $("body").on('click', '.applying', function () {
        let open_typeID = $(this).attr('id');
        let vote_typeID = $(this).data('vote-type-id');
        let applied = $(this).data('applied');
        let typeName = $(this).data('vote-type-name');
        let group = $(this).data('group');

        // if(group === "independent"){
        //     $('#group_id').val(0);
        // }else{
        //     // alert('with');
        // }


            $('#apply_Header').text(typeName+ ' - Application');
            // $('#submit_applyModal_btn').removeClass('hidden');
            $('#please_select').text('Select Position to Apply');


        // console.log('typeID:  '+ vote_typeID)
        $('#open_typeID').val(open_typeID);
        $('#vote_typeID').val(vote_typeID);

        $.ajax({
            method: 'get',
            url: bpath + 'vote/fetch/applicable-position-data',
            data: {_token,vote_typeID},
            success: function (response) {
                try {
                /***/
                if (response !== '') {
                    var data = JSON.parse(response);
                    $('#apply_position_modal_tbl > tbody').empty();

                    if (data.length > 0) {



                        for (let i = 0; i < data.length; i++) {
                            var assign_id = data[i]['assign_id'];
                            var vote_PositionID = data[i]['vote_PositionID'];
                            var vote_PositionName = data[i]['vote_PositionName'];
                            var vote_PositionDesc = data[i]['vote_PositionDesc'];
                            // var participated = data[i]['participated'];

                            // var participated_id = data[i]['participated_id'];

                            // console.log(participated);


                            var radioId = `apply_Position_id_${vote_PositionID}`;

                            // if(participated_id == vote_PositionID){
                            //     $('#'+ radioId).prop('checked', true)
                            //     $('#'+ radioId).prop('disabled', false)
                            // }
                            var cd = `<tr class="whitespace-wrap applyPosition" data-toggle="radio">
                                        <td>
                                            <label>
                                                <div class="flex form-check mr-2 apply_posion-row">
                                                    <input id="${radioId}" name="apply_Position_id" type="radio" value="${vote_PositionID}" class="form-check-input apply-position-radio">
                                                    <span class="form-check-label">${vote_PositionName}</span>
                                                    <a id="change_${vote_PositionID}"
                                                        class="ml-auto hidden text-primary"
                                                        style="text-decoration: none;"
                                                        onmouseover="this.style.textDecoration='underline';"
                                                        onmouseout="this.style.textDecoration='none';">
                                                            Applied
                                                    </a>
                                                </div>
                                            </label>
                                        </td>
                                      </tr>`;

                            $('#apply_position_modal_tbl > tbody').append(cd);

                            // if (participated == 1 && participated_id == vote_PositionID) {
                            //     $('#' + radioId).prop('checked', true);
                            //     $('#' + radioId).prop('disabled', false);
                            //     $('#change_' + vote_PositionID).removeClass('hidden'); // Show the link
                            // }
                        }


                    }
                }

                } catch (error) {
                    console.log(error);
                }
            }
        });

        const apply_modal = tailwind.Modal.getOrCreateInstance(document.querySelector("#apply__modal"));
        apply_modal.show();
        // alert(open_typeID+'----'+vote_typeID);
    });

    $("body").on('click', '.Open_voting', function () {

        let open_Application_id = $(this).attr('id');
        let type_id = $(this).data('vote-type-id');
        let type_name = $(this).data('vote-type-name');

        let openVoting_status = $(this).data('voting-time-status');

        let openVoting_date = $(this).data('open-voting-date');
        let voting_time_open = $(this).data('voting-time-open');
        let closeVoting_date = $(this).data('close-voting-date');
        let voting_time_close = $(this).data('voting-time-close');

        if (openVoting_status !== 'no') {
            $('#openDate').val(openVoting_date);
            $('#openTime').val(voting_time_open);
            $('#closeDate').val(closeVoting_date);
            $('#closeTime').val(voting_time_close);
            if (openVoting_status === 'close') {
                $('#header_voteTypeName').text('Extend: '+type_name);
            }

            $('#openVoting_btn').text('Update');
        }else{
            $('#openDate').val('');
            $('#openTime').val('');
            $('#closeDate').val('');
            $('#closeTime').val('');

            $('#openVoting_btn').text('Set');
            $('#header_voteTypeName').text('SET OPEN VOTING DATE TO: '+type_name);

        }

        $('#voteTypeID').val(type_id);
        $('#open_Application_id').val(open_Application_id);


        var open_voting_modal = tailwind.Modal.getOrCreateInstance(document.querySelector('#open_voting_modal'));
        open_voting_modal.show();

    });

    $("body").on('click','.viewCandidateList', function () {
        
        var applied = $(this).data('applied');
        var type_id = $(this).data('vote-type-id');
        var type_name = $(this).data('vote-type-name');

        $('#applicantList_modal_Header').text(type_name);
        $('#type-id').val(type_id);
        load_candidateList(type_id)

        const apply_modal = tailwind.Modal.getOrCreateInstance(document.querySelector("#applicant_list_modal"));
        apply_modal.show();

    });

}

function onSubmit() {

     // Applied for The Selected Position

    $("#applied_for_position_form").submit(function (e) {
        e.preventDefault();
        let checkedRadio = $('.apply-position-radio:checked');

        if (blockingEmptyApplicant()) {
            if (checkedRadio.length > 0) {
                let positionId = checkedRadio.val();
                // console.log('Radio button is checked for position ID:', positionId);

                $('#please_select').removeClass('text-danger');

                const fd = new FormData(this);
                $.ajax({
                    url: bpath + 'vote/save-applied-position',
                    method: 'post',
                    data: fd,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                        

                        if (response.status == 200) {
                            __notif_show( 1, "Candidate Applied Successfully");
                            applicant_select.val('').trigger('change');
                            applicant_parties.empty();
                            $('#applied_for_position_form')[0].reset();
                            const apply_modal = tailwind.Modal.getOrCreateInstance(document.querySelector("#apply__modal"));
                            apply_modal.hide();
                            fetch_openApplication_data();

                        }else{
                            __notif_show( -1, "Candidate Can't Apply Same Position and Parties");
                        }
                        // Handle success response
                    }
                });
            } else {
                // console.log('No radio button checked');
                $('#please_select').addClass('text-danger');
            }
        }


    });

    $('#openVoting_modal_form').submit(function (e) {
        e.preventDefault();

        if (blockEmptyDate()) {
            const fd = new FormData(this);

            $.ajax({
                url: bpath + 'vote/set/open/-voting-date',
                type: 'post',
                data: fd,
                caches: false,
                contentType:false,
                processData:false,
                dataType: 'json',
                success: function (response) {
                    if(response.status === 200){
                        __notif_show( 1, "Voting Date Set Successfully");
                        fetch_openApplication_data();
                        $('#openVoting_modal_form')[0].reset();
                        var open_voting_modal = tailwind.Modal.getOrCreateInstance(document.querySelector('#open_voting_modal'));
                        open_voting_modal.hide();
                    }
                }
            });
        }


    });
}

function on_change_function(){

    $('#applicant').change(function (e) {
        e.preventDefault();

        // let applicant_id = $(this).val();
        let applicant_id = $('#applicant').val();
        let typeID = $("input[name='vote_typeID']").val();
        // console.log(applicant_id, typeID);
        $.ajax({
            type: "get",
            url: bpath + "vote/change/select-applicant",
            data: {_token:_token, applicant_id:applicant_id, typeID:typeID},
            dataType: "json",
            success: function (response) {

                try {
                    var parties = response.parties;
                    var applied = response.applied;
                    var participated_id = response.participated_id;
                    var candidate_parties_id = response.candidate_parties_id;
                    applicant_parties.val(null);

                    applicant_parties.empty(); // Clear existing options

                    if (parties !== '' && parties.length > 0) { // Check if response is defined and not empty
                        for (let i = 0; i < parties.length; i++) {
                            var parties_id = parties[i]['parties_id'];
                            var parties_name = parties[i]['parties_name'];

                            // Create a new option element and append it to the select element
                            var option = '<option value="' + parties_id + '">' + parties_name + '</option>';
                            applicant_parties.append(option);
                        }
                    }


                    var radioId = `apply_Position_id_${participated_id}`;
                    var positions = $('#apply_position_modal_tbl').find('#' + radioId);

                    if (applied == 1) {
                        // Disable all radio buttons except the one with the specified ID
                        $('input[type="radio"]').not(positions).prop('disabled', true);
                        positions.prop('checked', true);
                        applicant_parties.val(candidate_parties_id).trigger('change');
                        applicant_parties.prop('disabled', true);

                        $('#submit_applyModal_btn').prop('disabled', true);
                    } else {
                        // Enable all radio buttons and uncheck the specified one
                        $('input[type="radio"]').prop('checked', false).prop('disabled', false);
                        $('#submit_applyModal_btn').prop('disabled', false);
                        applicant_parties.val('').trigger('change');
                        applicant_parties.prop('disabled', false);
                    }

                } catch (error) {
                    console.error('An error occurred:', error);
                }
            }
        });
    });

}

function blockingEmptyApplicant(){

    var appicant = $('#applicant');
    var parties = $('#applicant_parties');

    if(appicant.val() == ''){
        $('#applicant').select2({
            theme: "error",
            placeholder: "Please Select Applicant",
        });
        if(parties.val() == ''){
            $('#applicant_parties').select2({
                theme: "error",
                placeholder: "Please Select Parties",
            });
        }else{
            $('#applicant_parties').select2({
                placeholder: "Select Parties ",
                closeOnSelect: true,
            });
        }

        return false;
    }else{
        $('#applicant').select2({
            placeholder: "Select Applicant",
            closeOnSelect: true,
        });

        if(parties.val() == ''){
            $('#applicant_parties').select2({
                theme: "error",
                placeholder: "Please Select Parties",
            });
            return false;
        }else{
            $('#applicant_parties').select2({
                placeholder: "Select Parties ",
                closeOnSelect: true,
            });
            return true;
        }
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

function load_candidateList(type_id){
    $.ajax({
        type: "get",
        url: bpath + "vote/load-candidate-list",
        data: { _token:_token, type_id: type_id },
        success: function (response) {
            $('#candidate_list_div').html(response);
           
        }
    });
}

function previewFile() {
    
    var preview = document.getElementById('previewImage');
    var fileInput = document.getElementById('fileInput');
    var file = fileInput.files[0];
    var reader = new FileReader();

    reader.onloadend = function () {
        preview.src = reader.result;
    };

    if (file) {
        reader.readAsDataURL(file);

        
        var fd = new FormData($('#applicantList_modal_form')[0]);
        $.ajax({
            type: "POST",
            url: bpath + "vote/upload/candidate-profile",
            data: fd,
            processData: false, 
            contentType: false,
            dataType: "json",
            success: function (response) {
                if(response.status === 200) {
                    __notif_show( 1, "Profile Updated Successfully");
                    load_candidateList(response.type_id)
                }
            },
            error: function (error) {
                // Handle the error
            }
        });

    } else {
        preview.src = "{{ asset('dist/images/profile-4.jpg') }}";
    }
}

function handleActiveCandidate() {

    $("body").on('click', '#inactivecandidate', function () {

        var type_id = $(this).data('t');
        var participant = $(this).val();

        var isChecked = $(this).prop('checked');

        // console.log(isChecked, 'type --- ' +  type_id, 'participants --- ' + participants);

        $.ajax({
            type: 'POST', // or 'GET'
            url: bpath + 'vote/handle-active-candidate',
            data:   {   _token: _token, 
                        isCheck: isChecked, 
                        participant: participant, 
                        type_id: type_id
                    },
            success: function(response) {

                if(response.status == 200) {
                    __notif_show( 1, "Candidate Status Updated Successfully");
                    load_candidateList(response.type_id)
                }
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });

    });
    
}
