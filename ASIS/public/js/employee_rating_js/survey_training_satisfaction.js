var survey_table = '',temp_data_survey = [],final_saved_data = [];
var temp_save_data =[];
const create_modal_survey = tailwind.Modal.getInstance(document.querySelector("#create_survey_modal"));

$(document).ready(function(){
    load_datatable();
    check_editor();
    press_enter_survey();
    delete_survey_row();
    saved_survey_training();
});

//**=============================================**//
//initialize the datatable
function load_datatable()
{
    try{
		/***/
        survey_table = $('#survey_satisfaction_dt').DataTable({
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

            // columnDefs:
            //     [
            //         { className: "dt-head-center", targets: [] },
            //     ],
		});
	}catch(err){
        console.log(err);
     }
}

//load the data of the check editor
function check_editor()
{
    ClassicEditor
    .create( document.querySelector( '#editor_textarea_survey' ) )
    .then(editor => {survey_content = editor})
    .catch( error => {
        console.error( error );
    } );
}

//**=============================================**//
//read the enter keys on the keyboard
function press_enter_survey()
{
    $(document).on('keypress',function(event){

        let keycode = event.keyCode || event.which;
        let survey_val = survey_content.getData();

        if(keycode == 13)
        {
            append_survey_question(survey_val);
        }
    });
}

//append the value of the checked editor in the table
function append_survey_question(val)
{
    let cd ='';

    cd = '<tr>'+
         '<td><label id="question_survey" class="question_survey">'+val+'</label></td>' +
         '<td><textarea id="question_textarea" class="question_survey"hidden>'+val+'</textarea></td>' +
         '<td><button class="ml-2" id="btn_delete_survey_questionnaire_val" type="button"> <i class="fa fa-trash-alt"></i> </button></td>'+
        '</tr>' + ' ';

        $("#survey_question_table").append(cd);

}

//delete the selected row
function delete_survey_row()
{
    $("body").on('click','#btn_delete_survey_questionnaire_val',function(){
        $(this).closest('tr').remove();
    });
}

//temporarily saved the data of a table
function store_survey_question()
{
    $("#survey_question_table tr").each(function(i)
    {
        let question = $(this).find("td #question_textarea").text();

        if(i!='')
        {
            if(temp_data_survey[i]!=question)
            {
                temp_data_survey.push(question);
            }
        }
    });
}

//saved the data when the button saved is click
function saved_survey_training()
{
    $("#btn_save_survey_training").on('click',function(){
        store_survey_question();
        saved_survey_rating(temp_data_survey)
        clear_array_fields();
    });
}

//clear the content of the array
function clear_array_fields()
{
    temp_data_survey = [];
}
//**=============================================**//

//**=============================================**//
function saved_survey_rating(indicators)
{
    $.ajax({
        url: bpath + 'employee_ratings/saved/created/survey-data',
        type: "POST",
        data: {_token,indicators},
        dataType: 'json',

        success:function(response){
            console.log(response);
            if(response.status == true)
            {
                __notif_show(1,'',response.message);
                $("#survey_modal")[0].reset();
                create_modal_survey.hide();
            }else
            {
                __notif_show(-1,'',response.message);
            }
        }

    });
}
