var  _token = $('meta[name="csrf-token"]').attr('content');
var voteType_data_table;
var votePosition_data_table;
var openClose_tbl;
var participants_tbl;

var electType_select;

$(document).ready(function () {

    fetch_voteParticipants_data();
    loadData_table();
    onClick_function();
    submit_fuction();
    checkVoted_participants();

    // _radio_changed()
});


//===  Election Participants  ===//

function loadData_table(){

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
}

function fetch_voteParticipants_data(){

    $.ajax({
        url:  bpath + 'vote/fetched/election-participants-data',
        type: "get",
        data: {
            _token,
        },
        success: function(data) {

            participants_tbl.clear().draw();
            /***/
            var data = JSON.parse(data);

            if (data.length > 0) {

                for (let i = 0; i < data.length; i++) {
                        var vote_typeID = data[i]['vote_typeID'];
                        var Vote_typeName = data[i]['Vote_typeName'];
                        var is_voted = data[i]['is_voted'];
                        var openVoting_status = data[i]['openVoting_status'];
                        var this_candidate = data[i]['this_candidate'];
                        // var voter = data[i]['voter'];
                        // var voter_is = data[i]['voter_is'];
                        var ii = i+1;

                        var modalView = '';
                        var voteClass_click = '';
                        var iconClass = 'primary';
                        var tittle = 'Vote';
                        var status = '';
                        var statusClass = '';

                        if(is_voted == 1){
                            iconClass = 'success';
                            tittle = 'Voted';
                        }

                        if(openVoting_status == 'end'){

                            status = 'The Voting is End';
                            statusClass = 'text-danger';
                            if(is_voted == 1){
                                voteClass_click = 'vote_participants';
                                modalView = 'data-tw-toggle="modal" data-tw-target="#voteApplicant_modal"';
                                iconClass = 'success';
                                tittle = 'Voted';
                            }else{
                                iconClass = 'slate-500';
                                voteClass_click = '';
                                modalView = '';
                            }
                        }else if(openVoting_status == 'open'){
                            status = 'The Voting is Open';
                            statusClass = 'text-success';
                            if(is_voted == 1){
                                voteClass_click = 'vote_participants';
                                modalView = 'data-tw-toggle="modal" data-tw-target="#voteApplicant_modal"';
                                iconClass = 'success';
                                tittle = 'Voted';
                            }else{
                                voteClass_click = 'vote_participants';
                                modalView = 'data-tw-toggle="modal" data-tw-target="#voteApplicant_modal"';
                                iconClass = 'primary';
                            }

                        }else{
                            iconClass = 'pending';
                            voteClass_click = '';
                            status = 'The Voting is not yet Started';
                            statusClass = 'text-pending';

                        }

                        // console.log(voter+'<br>'+voter_is);
                        var cd = '';
                                /***/


                                    cd = '' +
                                            '<tr class="whitespace-wrap">'+

                                                '<td>' +
                                                        ii+
                                                '</td>' +


                                                '<td>'+
                                                    '<a id="'+vote_typeID+'" href="javascript:;" class="font-medium whitespace-nowrap text-right">'+Vote_typeName+'</a>'+
                                                    // '<div class="text-slate-500 text-xs text-justify mt-0.5">'+VoteDiscription+'</div>'+
                                                '</td>'+

                                                '<td>' +
                                                       '<label class="'+statusClass+'">'+status+'</label>'+
                                                '</td>' +

                                                '<td>' +
                                                    '<a id="'+vote_typeID+'" data-candidate-count="'+this_candidate+'" data-vote-type-name="'+Vote_typeName+'" data-is-voted="'+is_voted+'"'+
                                                    ''+modalView+''+
                                                        'class="dropdown-item '+voteClass_click+'" href="javascript:;">'+
                                                        '<div class="flex justify-center items-center">'+

                                                            '<div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="'+tittle+'">'+

                                                                    '<i class="fas fa-vote-yea text-'+iconClass+'"></i>'+

                                                            '</div>'+

                                                        '</div>'+
                                                    '</a>'+
                                                '</td>' +



                                            '</tr>' +
                                    '';



                                participants_tbl.row.add($(cd)).draw();



                                /***/


                }
            }

        }
    });

}

function onClick_function(){

    $("body").on('click', '.voteApplicant_modal_saveBtn', function () {

    });

    $("body").on("click", ".vote_participants", function () {

        var type_id = $(this).attr('id');
        var type_name = $(this).data('vote-type-name');
        var is_voted = $(this).data('is-voted');
        var candidate_count = $(this).data('candidate-count');

        $('#voteTypeID').val(type_id);
            // console.log(candidate_count);
        // console.log(type_id+' -- '+ type_name);

            if (is_voted == 1) {
                // alert(is_voted);
                $('#clr_selection').addClass('hidden');
                $('.voteApplicant_modal_saveBtn').addClass('hidden');
                $('.voteApplicant_modal_cancelBtn').removeClass('hidden');
                $('#vote-header_title').text("Your Choosen Candidate for: "+type_name);
            } else {
                $('#clr_selection').removeClass('hidden');
                $('#vote-header_title').text("Choose Candidate for: "+type_name);
                $('.voteApplicant_modal_saveBtn').removeClass('hidden');
                $('.voteApplicant_modal_cancelBtn').addClass('hidden');
            }



        fetch_openType_position(type_id);
    });

    $("body").on('click', '.revert_vote', function () {
        var position_id = $(this).attr('id');
        var checkbox = $(this).closest('div.box').find('input[name="' + position_id + '"]');
        checkbox.prop('checked', false);
    });

}

function fetch_openType_position(type_id){
    $.ajax({
        url:  bpath + 'vote/fetch/open/voting-type-position',
        type: "get",
        data: {
            _token,type_id
        },
        success: function (response) {

            $('#openType_positio_div').html(response);
            // console.log(response);
        }
    });
}

function submit_fuction(){
    $('#voteApplicant_modal_form').submit(function (e) {
        e.preventDefault();

        const fd = new FormData(this);
        const selectedCandidates = {};

        // Collect selected candidates
        $('#openType_positio_div input[type="radio"]:checked').each(function () {
            const positionID = $(this).attr('name');
            const candidateID = $(this).val();
            const positionName = $(this).data('position-name');
            const candidateName = $(this).data('candidate-name');

            selectedCandidates[positionID] = {
                positionName: positionName,
                candidateID: candidateID,
                candidateName: candidateName
            };
        });

        console.log(selectedCandidates);

        const selectedCandidatesDiv = $('#selectedCandidates');
        selectedCandidatesDiv.empty();

        const selectedCandidatesList = $('#selectedCandidatesList');
        selectedCandidatesList.empty();

        $.each(selectedCandidates, function (positionID, candidate) {
            const positionName = candidate.positionName;
            const candidateID = candidate.candidateID;
            const candidateName = candidate.candidateName;

            console.log('positionID:', positionID);
            console.log('positionName:', positionName);
            console.log('candidateID:', candidateID);
            console.log('candidateName:', candidateName);

            if (positionName && candidateName) {
                selectedCandidatesDiv.append(
                    `<p class="mt-2 text-bold">${positionName} <span class="ml-3">: ${candidateName}</span></p>`
                );
                selectedCandidatesList.append(
                    `<li>${positionName}: ${candidateName}</li>`
                );
            } else {
                const undefinedPosition = positionName ? positionName : 'Undefined Position';
                const undefinedCandidate = candidateName ? candidateName : 'Undefined Candidate';

                selectedCandidatesDiv.append(
                    `<p class="mt-2 text-bold">${undefinedPosition} <span class="ml-3">: ${undefinedCandidate}</span></p>`
                );

                selectedCandidatesList.append(
                    `<li>${undefinedPosition}: ${undefinedCandidate}</li>`
                );
            }
        });




        Swal.fire({
            title: 'List of Candidate/s Selected',
            html: '<div class="text-left text-xs ml-5">' + selectedCandidatesDiv.html() + '</div>',
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm',
            customClass: {
                container: 'custom-swal-modal',
                '@media (max-width: 480px)': {
                    container: 'custom-swal-modal-responsive'
            },
            onOpen: function () {
                $('.swal-title').css('font-size', '16px');
            }
        },
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: bpath + 'vote/save/selected-participants',
                    method: 'post',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 200) {
                            __notif_show(1, 'You Successfully Voted');
                            $('#voteApplicant_modal_form')[0].reset();
                            fetch_voteParticipants_data();
                            var set_voteCandidate_modal = tailwind.Modal.getOrCreateInstance(
                                document.querySelector('#voteApplicant_modal')
                            );
                            set_voteCandidate_modal.hide();
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error',
                            text: 'An error occurred while processing your vote.',
                            icon: 'error',
                            customClass: {
                                container: 'custom-swal-modal',
                            },
                        });
                    },
                });
            }
        });
    });


}

function checkVoted_participants() {
  $("body").on('click', '.candidate_div', function () {

    var _this_id = $(this).attr('id');
    var _this_radio = $(this).find('input[id="' + _this_id + '"]');
    _this_radio.prop('checked', true);

  });
}

function _radio_changed(){
    $('input[type="radio"]').change(function () {
        updateSelectedCandidates();
    });
}

