var  _token = $('meta[name="csrf-token"]').attr('content');
var temp_pos_id_idp,temp_depart_idp,temp_desig_idp;
var idp_table;

$(document).ready(function(){

    bpath = __basepath + "/";

    $('.dev_targetSave').hide();
    $('#viewActivity_btn').hide();

    select2();
    onClick_function();
    onSubmit();
    onChange();
    loadData_table();
    fetch_idp();
    datePicker();
    cancelOrX_function();

});
function fetch_idp(){
   $.ajax({
    method: 'get',
    url: bpath + 'IDP/fetch-idp-data',
    data: {_token},
    success: function (response) {

        idp_table.clear().draw();
        /***/
        var data = JSON.parse(response);

        if (data.length > 0) {
            
            for (let i = 0; i < data.length; i++) {
                    var created_by_id = data[i]['id'];
                    var year_from = data[i]['year_from'];
                    var year_to = data[i]['year_to'];
                    var target = data[i]['target'];
                    var activity = data[i]['activity'];

                    var ii = i+1;

                    var year;
                    var from;
                    var to;
                    if(year_from != null){
                        from = year_from;
                    }else{
                        from = '';
                    }

                    if(year_to != null){
                        to ='-'+ year_to;
                    }else{
                        to = '';
                    }

                    year = from+to;

                    var cd = '';
							/***/

								cd = '' +
                                        '<tr class="text-center">'+

						                    '<td>' +
                                                    ii+
						                    '</td>' +


                                            '<td>' +
                                                    '<h2 class="text-medium font-medium mr-auto">'+year+' </h2>'+
						                    '</td>' +


                                            '<td>' +
                                                    target+
						                    '</td>' +


                                            '<td>' +
                                                    activity+
                                            '</td>' +


                                            '<td>' +
                                                
                                                '<div class="flex justify-center items-center">'+
                                                    '<div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="Print">'+
                                                        '<a class="flex justify-center items-center"'+
                                                            'target="_blank" href="/IDP/print-idp-data/'+created_by_id+'" >'+
                                                            '<i class="fa fa-print items-center text-center text-primary"></i>'+ 
                                                        '</a>'+
                                                    '</div>'+
                                                    '<div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="More Action">'+
                                                        '<a class="flex justify-center items-center" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h items-center text-center text-primary"></i> </a>'+
                                                        '<div class="dropdown-menu w-auto">'+
                                                            '<div class="dropdown-content">'+
                                                                '<a class="dropdown-item" href="/IDP/idp-details/'+created_by_id+'">'+
                                                                    '<i class="fa fa-tasks text-success" aria-hidden="true"></i>'+
                                                                    '<span class="ml-2"> Detail </span>'+
                                                                '</a>'+
                                                            '</div>'+
                                                            '<div class="dropdown-content">'+
                                                                '<a class="dropdown-item" href="javascript:;">'+
                                                                    '<i class="fa fa-trash text-danger"></i>'+
                                                                    '<span class="ml-2"> delete </span>'+
                                                                '</a>'+
                                                            '</div>'+
                                                        '</div>'+
                                                    '</div>'+
                                                '</div>'+   
                                            '</td>' +



						                '</tr>' +
								'';

								idp_table.row.add($(cd)).draw();


							/***/

                
            }
        }

    }
   });
}

function select2(){

    $('#my_position').select2({
        placeholder: "Select Position ",
        closeOnSelect: true,

    });
    $('#my_sg').select2({
        placeholder: "Select Salary Grade ",
        closeOnSelect: true,

    });
    $('#my_supervisor').select2({
        placeholder: "Select Your Supervisor ",
        closeOnSelect: true,

    }); 
    $('#from_year').select2({
        placeholder: "Select Year From ",
        closeOnSelect: true,

    });
    $('#to_year').select2({
        placeholder: "Select Year To ",
        closeOnSelect: true,

    });
}

function cancelOrX_function(){
    $("body").on('click','#cancel_develop_target', function () {
        $("#taget_table > tbody").html("");
        $('#addTarget_form')[0].reset();
        $('#add_taget_btn').text('Add');
        $('.dev_targetSave').hide();
        $('#div_target_textarea').hide();
        fetch_idp();
        
    });

    $("body").on('click','#cancel_develop_activity', function () {
        $("#activity_table > tbody").html("");
        $('#addDev_plan_form')[0].reset();
        // $('#add_taget_btn').text('Add');
        // $('.dev_targetSave').hide();
        // $('#div_target_textarea').hide();
        // fetch_idp();
        
    });
}

function loadActivity(idp_id){
    $.ajax({
        method: 'get',
        url: bpath + 'IDP/show-development-plan-data',
        data: {_token, idp_id},
        success: function (response) {

            var activity_data = JSON.parse(response);

            if(activity_data.length > 0){
                $('#viewActivity_btn').hide(); 
                $('#addActivity_btn').show();
                $('#div_footer_plan').hide();
                $('#div_development_plan_textboxes').hide();
                $('#div_development_plan_table').show();
                $('#btn_saveTarget').text('Add Target');
                for (let i = 0; i < activity_data.length; i++){
                    var activity_id = activity_data[i]['activity_id'];
                    var dev_activity = activity_data[i]['dev_activity'];
                    var support_needed = activity_data[i]['support_needed'];
                    var planned = activity_data[i]['planned'];
                    var accom_mid_year = activity_data[i]['accom_mid_year'];
                    var accom_year_end = activity_data[i]['accom_year_end'];

                    $('#activity_table > tbody').append(
                        '<tr style="border-bottom:1px solid rgb(9, 8, 8)">'+
                            '<td>'+
                                    '<input type="hidden" value="'+activity_id+'" id="activity_id" name="activity_id">'+
                                    (i+1) +
                            '</td>'+
            
            
                            '<td>'+
                                    '<input type="hidden" value="'+dev_activity+'" id="dev_activity" name="dev_activity[]">'+
                                    '<label id="activity_label">'+dev_activity+'</label>'+
                            '</td>'+
            
                            '<td>'+
                                    '<input type="hidden" value="'+support_needed+'" id="support_needed" name="support_needed[]">'+
                                    '<label id="activity_label_support">'+support_needed+'</label>'+
                            '</td>'+
            

                            '<td>'+

                            '<div class="flex justify-center items-center">'+
                                                    '<div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="Activity Plan">'+
                                                        '<a id="'+activity_id+'" data class="flex justify-center items-center activity_planned" data-tw-toggle="modal" data-tw-target="#add_activity_plan_modal">'+
                                                            '<i class="fa-solid fa-lightbulb fa-bounce text-pending"></i>'+ 
                                                        '</a>'+
                                                    '</div>'+
                                                    '<div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="More Action">'+
                                                        '<a class="flex justify-center items-center action-activity" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h items-center text-center text-primary"></i> </a>'+
                                                        '<div class="dropdown-menu w-auto">'+
                                                            '<div class="dropdown-content" title="Edit">'+
                                                                ' <a id="'+activity_id+'" href="javascript:;" class="editClass-activity"> <i class="fa-solid fa-pen text-success"></i></a>'+
                                                            '</div>'+
                                                            '<div class="dropdown-content" title="Delete">'+
                                                                '<a id="'+activity_id+'" href="javascript:;" class="remove-table-row-activity"> <i class="fa fa-trash-alt w-4 h-4 mr-2 text-danger"></i></a>'+
                                                            '</div>'+
                                                        '</div>'+
                                                    '</div>'+
                                                '</div>'+   



                                    
                                    
                            '</td>'+
                        '</tr>');
                }
            }else{
                $('#div_development_plan_table').hide();
                
                // $('#btn_saveTarget').text('Save');
            }
        }
    });
}

function onClick_function(){
    $("body").on('click', '.createIDP_class', function () {
        let pos_id = $(this).data('position-id');
        let salary_grade = $(this).data('salary-grade');
        let no_y_position = $(this).data('year');
        let name = $(this).data('name');

        $('#my_position').val(pos_id).trigger('change');
        $('#my_sg').val(salary_grade).trigger('change');
        $('#created_by_name').val(name);
        $('#year_n_postision').val(no_y_position);

    });


//----------- Develop Taget Start ----------//
        $("body").on('click', '.develop-target', function () {
            var idp_id = $(this).attr('id');
            $('#ridp_id').val(idp_id);


            var target_count = $(this).data('target-count');
            var get_target = $(this).data('deveplop-target');
            if(target_count > 0){
                $('#div_target_textarea').hide();
                $.ajax({
                    method: 'get',
                    url: bpath + 'IDP/show-target-data',
                    data: {_token, idp_id},
                    success: function (response) {

                        var taget_data = JSON.parse(response);

                        if(taget_data.length > 0){

                            $('.dev_targetSave').show();
                            $('#btn_saveTarget').text('Add Target');
                            for (let i = 0; i < taget_data.length; i++){
                                var target_id = taget_data[i]['target_id'];
                                var dev_target = taget_data[i]['dev_target'];
                                var dev_goal = taget_data[i]['pg_support'];
                                var dev_objective = taget_data[i]['objective'];

                                $('#taget_table > tbody').append(
                                    '<tr>'+
                                        '<td>'+
                                                '<input type="hidden" value="'+target_id+'" id="target_id" name="target_id[]">'+
                                                (i+1) +
                                        '</td>'+
                        
                        
                                        '<td>'+
                                                '<input type="hidden" value="'+dev_target+'" id="develop_target" name="develop_target[]">'+
                                                '<label id="dev_label_target">'+dev_target+'</label>'+
                                        '</td>'+
                        
                                        '<td>'+
                                                '<input type="hidden" value="'+dev_goal+'" id="develop_goal" name="develop_goal[]">'+
                                                '<label id="dev_label_goal">'+dev_goal+'</label>'+
                                        '</td>'+
                        
                                        '<td>'+
                                                '<input type="hidden" value="'+dev_objective+'" id="develop_objective" name="develop_objective[]">'+
                                                '<label id="dev_label_objective">'+dev_objective+'</label>'+
                                        '</td>'+
                        
                                        '<td>'+
                                                '<a id="'+target_id+'" href="javascript:;" class="editClass"> <i class="fas fa-edit w-4 h-4 mr-2 text-success"></i></a>'+
                                                '<a id="'+target_id+'" href="javascript:;" class="remove-table-row"> <i class="fa fa-trash-alt w-4 h-4 mr-2 text-danger"></i></a>'+
                                        '</td>'+
                                    '</tr>');
                            }
                        }else{
                            $('#btn_saveTarget').text('Save');
                        }
                    }
                });
            }else{
                $('#div_target_textarea').show();
            }

        });
            var _thisTaget_row;
            var _thisDevelop_target;
            var _thisDevelop_goal;
            var _thisDevelop_objective;
            var _thisDevelop_target_label;
            var _thisDevelop_goal_label;
            var _thisDevelop_objective_label;

        $("body").on('click', '.editClass', function () {
            $('#div_target_textarea').show();
            $('#add_taget_btn').text('Update');
            $('#btn_saveTarget').text('Save')
            // $(this).closest('tr').css('border-color', '#edb65c');

            _thisTaget_row = $(this).closest('tr');
            _thisDevelop_target = _thisTaget_row.find('#develop_target');
            _thisDevelop_goal = _thisTaget_row.find('#develop_goal');
            _thisDevelop_objective = _thisTaget_row.find('#develop_objective');
            _thisDevelop_target_label = _thisTaget_row.find('#dev_label_target');
            _thisDevelop_goal_label = _thisTaget_row.find('#dev_label_goal');
            _thisDevelop_objective_label = _thisTaget_row.find('#dev_label_objective');

            $('#rdev_target').val(_thisDevelop_target.val());
            $('#rdev_goal').val(_thisDevelop_goal.val());
            $('#rdev_objective').val(_thisDevelop_objective.val());
        });

        // Add Row Develop target
        $("body").on('click','#add_taget_btn', function () {

            
            var dev_target = $('#rdev_target').val();
            var dev_goal = $('#rdev_goal').val();
            var dev_objective = $('#rdev_objective').val();

            if(dev_target != ""){
                $('.dev_targetSave').show();

                if($('#add_taget_btn').text() === 'Update'){
                    
                    _thisDevelop_target_label.text(dev_target);
                    _thisDevelop_goal_label.text(dev_goal);
                    _thisDevelop_objective_label.text(dev_objective);

                    _thisDevelop_target.val(dev_target);
                    _thisDevelop_goal.val(dev_goal);
                    _thisDevelop_objective.val(dev_objective);
                    // _thisTaget_row.css('border-color', '#edb65c');
                    $('#add_taget_btn').text('Add');
                    $('#rdev_target').val("");
                    $('#rdev_goal').val("");
                    $('#rdev_objective').val("");
                }else{
                var target_id = '';
                var rowCount = $('#taget_table').find('tr').length;

                $('#rdev_target').css('border-color', '');
                
                $('#taget_table > tbody').append(
                    '<tr>'+
                        '<td>'+
                                '<input type="hidden" value="0" id="target_id" name="target_id[]">'+
                                rowCount+
                        '</td>'+
        
        
                        '<td>'+
                                '<input type="hidden" value="'+dev_target+'" id="develop_target" name="develop_target[]">'+
                                '<label id="dev_label_target">'+dev_target+'</label>'+
                        '</td>'+
        
                        '<td>'+
                                '<input type="hidden" value="'+dev_goal+'" id="develop_goal" name="develop_goal[]">'+
                                '<label id="dev_label_goal">'+dev_goal+'</label>'+
                        '</td>'+
        
                        '<td>'+
                                '<input type="hidden" value="'+dev_objective+'" id="develop_objective" name="develop_objective[]">'+
                                '<label id="dev_label_objective">'+dev_objective+'</label>'+
                        '</td>'+
        
                        '<td>'+
                                '<a id="'+target_id+'" href="javascript:;" class="editClass"> <i class="fas fa-edit w-4 h-4 mr-2 text-success"></i></a>'+
                                '<a id="'+target_id+'" href="javascript:;" class="remove-table-row"> <i class="fa fa-trash-alt w-4 h-4 mr-2 text-danger"></i></a>'+
                        '</td>'+
                    '</tr>');
                    $('#rdev_target').val("");
                    $('#rdev_goal').val("");
                    $('#rdev_objective').val("");
                }
            }else{
                $('#rdev_target').css('border-color', '#Ff696c');
            }

            
        });

        // Remove Row Develop target
        $("body").on('click','.remove-table-row', function () {

            let targeting_id = $(this).attr('id');
            var table_row = $(this).parents('tr');

            if(targeting_id == ""){
                table_row.remove();
            }else{
                $.ajax({
                    method: 'get',
                    url: bpath + 'IDP/delete-target-data',
                    data: {_token, targeting_id},
                    success: function (response) {
                        if(response.status == 200){
                            table_row.remove();
                        }
                    }
                });
            }
            
        });

//----------- Develop Taget End----------//

// ---------- Development Activity  Start----------//

    $('body').on('click', '.development-activity', function(){
        let idp_id = $(this).attr('id');
    // alert(idp_id);
        $('#idp_id_plan').val(idp_id);

        var plan_count = $(this).data('activity-count');
        if(plan_count > 0){
            $('#div_development_plan_textboxes').hide();
            $('#div_footer_plan').hide();

            loadActivity(idp_id);

        }else{
            $('#div_development_plan_textboxes').show();
            $('#div_footer_plan').show();
            $('#viewActivity_btn').show();
            $('#div_development_plan_table').hide();
            $('#addActivity_btn').hide();       
        }
    });

    //Remove Row Activity
    $("body").on('click','.remove-table-row-activity', function () {

        let idp_id = $('#idp_id_plan').val();
        let activity_id = $(this).attr('id');
        var table_row = $(this).parents('tr');

        if(activity_id == "" || activity_id == undefined){
            table_row.remove();
            console.log('uy dili Paytss');
        }else{
            $.ajax({
                method: 'get',
                url: bpath + 'IDP/delete-delopment-plan-data',
                data: {_token, activity_id},
                success: function (response) {
                    if(response.status == 200){
                        fetch_idp();
                        $("#activity_table > tbody").html("");
                        loadActivity(idp_id);
                    }
                }
            });
        }
        
    });

    //Add Activity Button
    $("body").on('click', '#addActivity_btn', function () {
        $('#div_development_plan_textboxes').show();
        $('#div_footer_plan').show();
        $('#viewActivity_btn').show();
        $('#div_development_plan_table').hide();
        $('#addActivity_btn').hide();       

    });

    //View Activity Button
    $("body").on('click', '#viewActivity_btn', function () {
        $('#div_development_plan_textboxes').hide();
        $('#div_footer_plan').hide();
        $('#viewActivity_btn').hide();
        $('#div_development_plan_table').show();
        $('#addActivity_btn').show();        

    });

    var _thisactivity_row;
    var _thisDevelop_id;
    var _thisDevelop_activity;
    var _thisDevelop_Support;
    var _thisDevelop_planned;
    var _thisAccomplish_midYear;
    var _thisAccomplish_yearEnd;
    
    var _thisDevelop_activity_label;
    var _thisDevelop_Support_label;
    var _thisDevelop_planned_label;
    var _thisAccomplish_midYear_label;
    var _thisAccomplish_yearEnd_label;

    $("body").on('click', '.action-activity', function () {

            _thisactivity_row = $(this).closest('tr');
            _thisDevelop_id = _thisactivity_row.find('#activity_id');
            _thisDevelop_activity = _thisactivity_row.find('#dev_activity');
            _thisDevelop_Support = _thisactivity_row.find('#support_needed');
            
    });

    $("body").on('click', '.editClass-activity', function () {

        $('#div_development_plan_textboxes').show();
        $('#div_footer_plan').show();
        $('#viewActivity_btn').show();
        $('#div_development_plan_table').hide();
        $('#addActivity_btn').hide();  
        
        $('#activityID').val(_thisDevelop_id.val());
            $('#development_activity').val(_thisDevelop_activity.val());
            $('#development_support').val(_thisDevelop_Support.val());

    });
    // var activity_ids;
    $("body").on('click','.activity_planned', function () {
        let activity_ids = $(this).attr('id');
        $('#activity_ids').val(activity_ids);

        let idps = $('#idp_id_plan').val();
        $('#idp_idss').val(idps);

        // alert(idps)

    });

    //Add Activity Plan Row
    $("body").on('click', '.add-plan-row', function () {
        $('#activity_plan_tbl > tbody').append(
            '<tr>'+

                '<td>'+
                   '<input type="hidden" value="0" class="form-control" name="activity_planID[]" id="activity_planID">'+
                    '<textarea type="text" id="plans" class="form-control" name="plans[]" placeholder="Type Activity Plan..."></textarea>'+
                '</td>'+

                '<td>'+
   
                    '<textarea type="text" id="mid_year" class="form-control" name="mid_year[]" placeholder="Type Mid-Year Accomplish..."> </textarea>'+
   
                '</td>'+

                '<td>'+
                    '<textarea type="text" id="year_end" class="form-control" name="year_end[]" placeholder="Type Year-end Accomplish..."> </textarea>'+
                '</td>'+


                '<td>'+
                    '<a id="" href="javascript:;" class="remove-row-activity-plan"> <i class="fa fa-trash-alt w-4 h-4 mr-2 text-danger"></i></a>'+
                '</td>'+
            '</tr>');
    });

    //Remove Activity Plan Row
    $("body").on('click', '.remove-row-activity-plan', function () {
        $(this).parents('tr').remove();
    });
// ---------- Development Activity End ----------//

// -----------Begin IDP Details -------------- //

//Add Target Row Button
$("body").on('click','#add__targetRow_btn', function () {
    
    
    $('#idpTaget_table > tbody').append(
        '<tr>'+

            '<td>'+
                '<input type="hidden" value="0" class="form-control" name="targetID[]" id="targetID">'+
                '#'+
            '</td>'+

            '<td>'+

                '<textarea type="text" id="dev_target" class="form-control" name="dev_target[]" placeholder="......"> </textarea>'+

            '</td>'+

            '<td>'+
                '<textarea type="text" id="pg_support" class="form-control" name="pg_support[]" placeholder="......"> </textarea>'+
            '</td>'+

            '<td>'+
                '<textarea type="text" id="objective" class="form-control" name="objective[]" placeholder="......"> </textarea>'+
            '</td>'+


            '<td>'+
                '<a id="" href="javascript:;" class="remove-row-idp-target"> <i class="fa fa-trash-alt w-4 h-4 mr-2 text-danger"></i></a>'+
            '</td>'+
        '</tr>');


});

 //Remove IDP Target Row
 $("body").on('click', '.remove-row-idp-target', function () {

    let _thisRow = $(this).closest('tr');
    let deleteTarget_id = _thisRow.find('#targetID');

    if(deleteTarget_id.val() == 0){
        $(this).parents('tr').remove();
    }else{
        let Targeting_id = deleteTarget_id.val();

        // alert(Targeting_id)
        $.ajax({
            method: 'get',
            url: bpath + 'IDP/delete-target-data/'+Targeting_id,
            data: {_token},
            success: function (response) {
                if(response.status === 200){
                    
                    $("#idpTaget_table").load(location.href + " #idpTaget_table");
                    // location.reload(); 
                    __notif_show( 1,"One Data Remove Successfully");

                }
            }
        });
    }

    // $(this).parents('tr').remove();
});

//Edit IDP Target
$("body").on('click', '.edit-idp-target', function () {
    var target_row = $(this).closest('tr');

    var target = target_row.find('#dev_target')
    var target_label = target_row.find('#dev_target_label')
    var _thisEdit_btn = target_row.find('.edit-idp-target')
    var _thisDoneEdit = target_row.find('.done-edit-idp-target')
    target.removeClass('hidden');
    target_label.addClass('hidden');

    var pg_support = target_row.find('#pg_support')
    var pg_support_label = target_row.find('#pg_support_label')
    pg_support.removeClass('hidden');
    pg_support_label.addClass('hidden');

    var objective = target_row.find('#objective')
    var objective_label = target_row.find('#objective_label')
    objective.removeClass('hidden');
    objective_label.addClass('hidden');

    _thisEdit_btn.addClass('hidden')
    _thisDoneEdit.removeClass('hidden')


});

//Done Edit IDP Target
$("body").on('click','.done-edit-idp-target', function () {
    var targets_row = $(this).closest('tr');

    var targets = targets_row.find('#dev_target')
    var target_labels = targets_row.find('#dev_target_label')
    var _thisEdits_btn = targets_row.find('.edit-idp-target')
    var _thisDoneEdits = targets_row.find('.done-edit-idp-target')
    targets.addClass('hidden');
    target_labels.removeClass('hidden');

    let devTargetValue = targets.val();
    target_labels.text(devTargetValue);

    var pg_supports = targets_row.find('#pg_support')
    var pg_support_labels = targets_row.find('#pg_support_label')
    pg_supports.addClass('hidden');
    pg_support_labels.removeClass('hidden');

    let pgSupportValue = pg_supports.val();
    pg_support_labels.text(pgSupportValue);

    var objectives = targets_row.find('#objective')
    var objective_labels = targets_row.find('#objective_label')
    objectives.addClass('hidden');
    objective_labels.removeClass('hidden');

    let objectiveValue = objectives.val();
    objective_labels.text(objectiveValue);

    _thisEdits_btn.removeClass('hidden')
    _thisDoneEdits.addClass('hidden')
});

//Add Activity Row Button
$("body").on('click','#add__activityRow_btn', function () {
    
    
    $('#idpActivity_table > tbody').append(
        '<tr>'+

            '<td>'+
               '<input type="hidden" value="0" class="form-control" name="activityID[]" id="activityID">'+
                '#'+
            '</td>'+

            '<td>'+

                '<textarea type="text" id="dev_activity" class="form-control" name="dev_activity[]" placeholder="......"> </textarea>'+

            '</td>'+

            '<td>'+
                '<textarea type="text" id="support_needed" class="form-control" name="support_needed[]" placeholder="......"> </textarea>'+
            '</td>'+

            '<td colspan="3">'+
            
            '</td>'+


            '<td>'+
                '<a id="" href="javascript:;" class="remove-row-idp-activity"> <i class="fa fa-trash-alt w-4 h-4 mr-2 text-danger"></i></a>'+
            '</td>'+
        '</tr>');


});

 //Remove IDP Activity Row
 $("body").on('click', '.remove-row-idp-activity', function () {
    let _thisRow = $(this).closest('tr');
    let deleteActivity_id = _thisRow.find('#activityID');

    if(deleteActivity_id.val() == 0){
        $(this).parents('tr').remove();
    }else{
        let Activity_idss = deleteActivity_id.val();

        // alert(Targeting_id)
        $.ajax({
            method: 'get',
            url: bpath + 'IDP/delete-Activity-data/'+Activity_idss,
            data: {_token},
            success: function (response) {
                if(response.status === 200){
                    
                    $("#idpActivity_table").load(location.href + " #idpActivity_table");
                    // location.reload(); 
                    __notif_show( 1,"One Data Remove Successfully");

                }
            }
        });
    }
});

//Edit IDP Activity
$("body").on('click', '.edit-idp-activity', function () {
    var activity_row = $(this).closest('tr');

    var dev_activity = activity_row.find('#dev_activity')
    var activity_label = activity_row.find('#activity_label')
    
    var _thisEdit_btn = activity_row.find('.edit-idp-activity')
    var _thisDoneEdit = activity_row.find('.done-edit-idp-activity')

    dev_activity.removeClass('hidden');
    activity_label.addClass('hidden');

    var support_needed = activity_row.find('#support_needed')
    var activity_label_support = activity_row.find('#activity_label_support')
    support_needed.removeClass('hidden');
    activity_label_support.addClass('hidden');

    _thisEdit_btn.addClass('hidden')
    _thisDoneEdit.removeClass('hidden')
});

//Done Edit IDP Activity
$("body").on('click','.done-edit-idp-activity', function () {
    var activitys_row = $(this).closest('tr');

    var dev_activitys = activitys_row.find('#dev_activity')
    var activitys_label = activitys_row.find('#activity_label')
    var _thisEdits_btn = activitys_row.find('.edit-idp-activity')
    var _thisDoneEdits = activitys_row.find('.done-edit-idp-activity')

    let activityValue = dev_activitys.val();
    activitys_label.text(activityValue);
    
    dev_activitys.addClass('hidden');
    activitys_label.removeClass('hidden');

    var support_neededs = activitys_row.find('#support_needed')
    var activity_label_supports = activitys_row.find('#activity_label_support')

    let support_neededsValue = support_neededs.val();
    activity_label_supports.text(support_neededsValue);

    support_neededs.addClass('hidden');
    activity_label_supports.removeClass('hidden');

    _thisEdits_btn.removeClass('hidden')
    _thisDoneEdits.addClass('hidden')
});



// -----------End IDP Details -------------- //


}


function onSubmit(){
    $('#idp_form').submit(function (e) { 
        e.preventDefault();

        const fd = new FormData(this);

        $.ajax({            
            url: bpath + 'IDP/save-idp',
            method: 'POST',
            data:fd,
            cache:false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (res) {
                if(res.status === 200){
                    __notif_show( 1,"IDP Created Successfully");
                    $('#idp_form')[0].reset();
                    const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#createIDP_modal'));
                    mdl.hide();
                    fetch_idp();

                }
            }
           });
        
    });

    $('#addTarget_form').submit(function (e) { 
        e.preventDefault();

        if($('#btn_saveTarget').text() === "Add Target"){
            $('#div_target_textarea').show();
            $('#btn_saveTarget').text('Save')
        }else{
            const fd = new FormData(this);

            $.ajax({            
                url: bpath + 'IDP/save-develop-target',
                method: 'POST',
                data:fd,
                cache:false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (res) {
                    if(res.status === 200){
                        __notif_show( 1,"IDP  Target Added Successfully");
                        $('#addTarget_form')[0].reset();
                        const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#addTarget_modal'));
                        mdl.hide();
                        fetch_idp();
                        $("#taget_table > tbody").html("");
                        $('.dev_targetSave').hide();
                    }
                }
           });
        }
    });

    $('#addDev_plan_form').submit(function (e) { 
        e.preventDefault();
        let idp_id = $('#idp_id_plan').val();
        const fd = new FormData(this);

        $.ajax({            
            url: bpath + 'IDP/save-development-plan',
            method: 'POST',
            data:fd,
            cache:false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (res) {
                if(res.status === 200){
                    __notif_show( 1,"IDP  Activity Added Successfully");
                    $('#addDev_plan_form')[0].reset();
                    // const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#addDevelopment_activity_modal'));
                    // mdl.hide();
                    fetch_idp();
                    $("#activity_table > tbody").html("");
                    $('#activityID').val(0);
                    loadActivity(idp_id)

                    // $("#taget_table > tbody").html("");
                    // $('.div_development_plan_textboxes').hide();
                }
            }
       });
        
    });

    $('#addActivity_plan_form').submit(function (e) { 
        e.preventDefault();

        let idp_id = $('#idp_idss').val();
        // alert(idp_id);
        const fd = new FormData(this);

        $.ajax({            
            url: bpath + 'IDP/save-activity-plan',
            method: 'POST',
            data:fd,
            cache:false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (res) {
                if(res.status === 200){
                    __notif_show( 1,"Activity Plan Added Successfully");
                    $('#addActivity_plan_form')[0].reset();
                    // const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#add_activity_plan_modal'));
                    // mdl.hide();
                    $("#activity_plan_tbl > tbody").html("");
                    loadActivity(idp_id)

                    // $("#taget_table > tbody").html("");
                    // $('.div_development_plan_textboxes').hide();
                }
            }
       });

    });

    $("#idp_all_form").submit(function (e) { 
        e.preventDefault();

        // alert(check_table_textarea_blank());

      if (check_table_textarea_blank()) {

            const fd = new FormData(this);

            $.ajax({            
                url: bpath + 'IDP/save-all-idp-data',
                method: 'POST',
                data:fd,
                cache:false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (res) {
                    if(res.status === 200){
                        location.reload(); 
                        __notif_show( 1,"Saved Successfully");
                        // $('#idp_form')[0].reset();
                        // const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#createIDP_modal'));
                        // mdl.hide();
                        // fetch_idp();
    
                    }
                }
            });
        }else{
            console.log('patay napud');
        }

    });
}
function onChange(){
    $("#from_year").change(function (e) { 
        e.preventDefault();
        let from_year = $(this).val();

        $('#from_year_label').text('  - '+from_year);
    });

    $("#to_year").change(function (e) { 
        e.preventDefault();
        let to_year = $(this).val();
        if(to_year != 0){
            $('#to_year_label').text(' to '+to_year);
        }else{
            $('#to_year_label').text('');
        }
       
    });
}
function loadData_table(){
    idp_table = $('#idp_table').DataTable({
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
        columnDefs: [
            { className: 'text-left', targets: [0, 1, 2, 3] },
            { className: 'text-center', targets: [4] },
          ],
          


    });
}
function datePicker(){
    $("#datepicker").datepicker( {
        format: "yyyy",
        viewMode: "years", 
        minViewMode: "years",
        autoclose:false

    });
}

function check_table_textarea_blank()
{
    let row = $("#idpTaget_table").find('tr');


      var emptytextArea = row.find("textarea").filter(function() {
        return this.value === "";

      });

      alert(emptytextArea.length);
    if (emptytextArea.length != 0){

            emptytextArea.css('border-color', '#ff0000');
                
            return false;
    }else {

        emptytextArea.css('border-color', '');
        return true;

    }


}
