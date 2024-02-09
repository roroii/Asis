
var  _token = $('meta[name="csrf-token"]').attr('content');

$(document).ready(function () {
    DeleteVoteData();
    DeleteVoteData_click_Class();
});
var sig_type_id;
function DeleteVoteData_click_Class(){
    //DELETE VOTE TYPE DATA
    $("body").on('click', '.deleteVoteType', function () {
        let vote_type_id = $(this).attr('id');
        $('#for_delete').val('VoteType');
        $('#delete_request_id').val(vote_type_id);

        const delete_modal = tailwind.Modal.getOrCreateInstance(document.querySelector("#delete-modal"));
        delete_modal.show();
    });
    
    // DELETE SIGNATORY DATA
    $("body").on('click', '.delete_signatory', function () {
        let sig_id = $(this).attr('id');
         sig_type_id = $(this).data('type-id');

        $('#delete_request_id').val(sig_id);
        $('#for_delete').val('signatory');

        const delete_modal = tailwind.Modal.getOrCreateInstance(document.querySelector("#delete-modal"));
        delete_modal.show();

    });
    // DELETE VOTE POSITION DATA
    $("body").on('click', '.deleteVotePosition', function () {
        let vote_position_id = $(this).attr('id')
        $('#for_delete').val('VotePosition');
        $('#delete_request_id').val(vote_position_id);;

        const delete_modal = tailwind.Modal.getOrCreateInstance(document.querySelector("#delete-modal"));
        delete_modal.show();
    });

    // DELETE PARTIES DATA
    $("body").on('click', '.deletecandidateParty', function () {

        let parties_id = $(this).attr('id');

        $('#delete_request_id').val(parties_id);
        $('#for_delete').val('candidate_parties');
        const delete_modal = tailwind.Modal.getOrCreateInstance(document.querySelector("#delete-modal"));
        delete_modal.show();

    });

}

function DeleteVoteData(){
    // DELETE ALL VOTE DATA
    $("body").on('click', '#deleteBtn', function () {
        let RequestForDelete = $('#for_delete').val();
        let voteDataID = $('#delete_request_id').val();
        $.ajax({
            method: 'get',
            url: bpath + 'vote/delete/vote-data/'+voteDataID+'/'+RequestForDelete,
            data: {_token},
            success: function (response) {
                if(response.status == 'voteTypeDeleted'){
                    __notif_show( 1, "Vote Type Data Deleted Successfully");
                    const delete_modal = tailwind.Modal.getOrCreateInstance(document.querySelector("#delete-modal"));
                    delete_modal.hide();
                    fetch_voteType_data();
                }
                else if(response.status == 'votePositionDeleted'){
                    __notif_show( 1, "Vote Position Data Deleted Successfully");
                    const delete_modal = tailwind.Modal.getOrCreateInstance(document.querySelector("#delete-modal"));
                    delete_modal.hide();
                    fetch_votePosition_data();
                }else if(response.status == 'signatoryDeleted'){
                    console.log(sig_type_id);
                    load_signatory(sig_type_id)
                    __notif_show( 1, "Signatory Remove Successfully");
                    const delete_modal = tailwind.Modal.getOrCreateInstance(document.querySelector("#delete-modal"));
                    delete_modal.hide();
                    
                }else if(response.status == 'partiesDeleted'){
                    __notif_show( 1, "Parties Remove Successfully");
                    const delete_modal = tailwind.Modal.getOrCreateInstance(document.querySelector("#delete-modal"));
                    delete_modal.hide();                    
                    load_candidate_partiesDatas();
                    
                }
            }
        });
    });
}