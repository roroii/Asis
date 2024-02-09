var  _token = $('meta[name="csrf-token"]').attr('content');
var voteType_data_table;
var votePosition_data_table;
var openClose_tbl;
var participants_tbl;

var electType_position_resultSelect;
var electType_resultSelect;

$(document).ready(function () {
    // fetch_voteParticipants_data();
    // loadData_table();
    // onClick_function();
    // submit_fuction();

    selec2_function();
    onChange_function();
    onClick_function();
});

function selec2_function(){
    electType_resultSelect =  $('#electType_resultSelect').select2({
        placeholder: "Select Election Name",
        closeOnSelect: true,

    });

    electType_position_resultSelect =  $('#electType_position_resultSelect').select2({
        placeholder: "Select Position",
        closeOnSelect: true,

    });
}

function onChange_function(){

    $("#electType_resultSelect").change(function (e) { 
        e.preventDefault();
        let type_id = $(this).val();
        fetch_candidate_by_type(type_id);
        // alert(type_id)

        // $.ajax({
        //     url:  bpath + 'vote/filter/election-type-positions/' + type_id,
        //     type: "get",
        //     data: {
        //         _token,
        //     },
        //     success: function (data) {

                
        //         try {
        //             electType_position_resultSelect.empty();
                
        //             var data = JSON.parse(data);
                
        //             electType_position_resultSelect.append('<option value="">Select Election Type Position</option>');
        //             $.each(data, function (index, value) {
        //                 electType_position_resultSelect.append('<option value="' + value.postition_id + '">' + value.position_name + '</option>');
        //             });
                
        //             electType_position_resultSelect.trigger('change');
        //         } catch (error) {
        //             console.error('An error occurred:', error);
        //         }
                
        //     }
        // });
        
    });


}

function fetch_candidate_by_type(type_id) {

    $.ajax({
        url:  bpath + 'vote/fetch/election-candidate_by_type/' + type_id,
        method: 'get',
        data: {
            _token,
        },
        dataType: 'json',
        success: function (response) {

            var contain_data = response.contain_data;
            var output = response.output;

            // console.log(contain_data, output);
            $('#position_div').html(output);
            $('#data_container').val(contain_data);
            fetch_leaderBoard(type_id)
        },
        error: function (xhr, status, error) {
            // Handle AJAX error
            console.log('AJAX Error:', error);
        }
    });
}

function fetch_leaderBoard(type_id){
    $.ajax({
        url:  bpath + 'vote/fetch/leaderBoard/' + type_id,
        method: 'get',
        data: {
            _token,
        },
        success: function (response) {
            $('#leaderBoard_div').html(response);
        }
    });

}


function onClick_function(){
    $("body").on('click', '#print_btn', function () {
        let type_id = $('#electType_resultSelect');
        let contain_data = $('#data_container');
        const choose_print_modal = tailwind.Modal.getOrCreateInstance(document.querySelector("#chose_print_modal"));
        const noContain_data_modal = tailwind.Modal.getOrCreateInstance(document.querySelector("#noContain_data_modal"));
        
        if(validateEmptySelet(type_id)){

            // console.log(contain_data.val());
            if(contain_data.val() == 1){
                choose_print_modal.show();
                $('#type_id').val(type_id.val());
            }else{
                noContain_data_modal.show();
            }
            
        }
    });

    $("body").on('click', '#print_result_all', function () {
        $('#print_win_result').removeClass('bg-primary').addClass('bg-slate-200')
        $('#printWin_result_text').removeClass('text-white').addClass('text-primary')

        $('#to_print').val(1);
        $(this).removeClass('bg-slate-200').addClass('bg-primary');
        $('#print_result_text').removeClass('text-primary').addClass('text-white')
    });

    $("body").on('click', '#print_win_result', function () {

        $('#print_result_all').removeClass('bg-primary').addClass('bg-slate-200')
        $('#print_result_text').removeClass('text-white').addClass('text-primary')

        $('#to_print').val(0);
        $(this).removeClass('bg-slate-200').addClass('bg-primary');
        $('#printWin_result_text').removeClass('text-primary').addClass('text-white')
    });
   
}

function validateEmptySelet(type_id){

    if(type_id.val() == ''){

        type_id.select2({
            placeholder: "Election Name is Required",
            theme: "error",
        });
           
        return false;
    }else{

        type_id.select2({
            placeholder: "Select Election Name",
            closeOnSelect: true,
        });

       return true;       
        
    }
    
}