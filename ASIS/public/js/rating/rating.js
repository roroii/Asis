
var  _token = $('meta[name="csrf-token"]').attr('content');
var rating_table;
var tbl_applicant_rated;
var Applicant_position_select;
var area_sumValue;


$(document).ready(function () {

    bpath = __basepath + "/";
    
    $('#rateLabel').hide();
    $('#positionLabel').hide();
    $('#criteriaLabel').hide();
    $('#competencyLabel').hide();

    $('#remarks_div').hide();
    $('#tfoot_id').hide();
    $('#saveRate_btn').hide();
    $('.criteria_div').hide();


    
    fetchedCriteria();
    action_function();
    cancel();
    dropdown();
    loadTables();
    onChange();
    refresh();
    sum_rate();
    manageRating_Validation();
    onClick_function();
    onSubmit();
    fetched_rated();
    toggleCheck()
    sumOf_areaInput_points();
    // validate_table_input();


});

function fetchedCriteria(position_id){
    $.ajax({
        url: bpath + 'rating/fetch-criteria',
        type: "get",
        data: {
            _token: _token, position_id:position_id,
        },
        success: function(data) {
            $('#tbl_criteria_div').html(data);

            $('#tbl_criteria').DataTable({
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

                order: [0, 'desc'],

            });
        }
    });
}

function action_function(){
    // CHANGE NAME OF BUTTON
    $("body").on('click', '.addCriteria', function () {
        $('#addAndUpdate_header').text('Add Criteria');
        $('#add_criteria_btn').text("Save");
        $('.add_rowBtn_div').show()
        $('#crit_tbl').show()
    });

    // EDIT CRITERIA
    $("body").on('click', '.editCriteria_btn', function () {
        var crit_id = $(this).attr('id');
        var criteria = $(this).data('criteria');
        var maxrate = $(this).data('max-rate');
        var position_id = $(this).data('position');
        var competency_id = $(this).data('competency-id');
        // console.log(criteria +' '+crit_id+'  '+maxrate+' '+position_id);
        $('#addAndUpdate_header').text('Update Criteria');
        $('#add_criteria_btn').text('Update')
        // $('.add_rowBtn_div').hide()
        // $('#crit_tbl').hide()

        const ediCreteriaModel = tailwind.Modal.getOrCreateInstance(document.querySelector('#update_criteria_Modal'));
        ediCreteriaModel.show();
        // alert(maxrate);
        $('#maxrate_up').val(maxrate);
        $('#critID_up').val(crit_id);
        if(competency_id == ""){
            $('.competency_div').hide();
            $('.criteria_div').show();
            $('#criteria_up').val(criteria);
        }else{
            $('.competency_div').show();
            $('.criteria_div').hide();
            $('#competency_up').val(competency_id).trigger('change');
        }
        $('#position_up').val(position_id).trigger('change');

    });

    //DELETE CRITERIA
    $("body").on("click", ".deleteCriteria_btn", function (ev) {
        ev.preventDefault();
        var position_cat = $('#positioncritPage').val();

        swal({
            container: 'my-swal',
            title: 'Are you sure?',
            text: "It will permanently deleted !",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value == true) {

              let criteria_id = $(this).attr('id');

                // console.log(criteria_id);
                $.ajax({
                    url:  bpath + 'rating/delete-criteria',
                    method: 'POST',
                    data: {
                        _token:_token,
                        criteria_id: criteria_id,
                    },
                    cache: false,
                    success: function (data) {
                        //console.log(data);
                        var status = data.status;
                        // alert(status)
                        if(status == 200){
                            swal("Deleted!", "your Criteria has been deleted Successfully.", "success");
                            __notif_show( 1,"Successfully Deleted!");
                            fetchedCriteria(position_cat);


                        }else{
                            swal("Warning!", "Deleter Unsuccessful.", "warning");
                        }
                    }
                });
            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swal("Cancelled", "Your data is safe :)", "error");
            }
        })
    });

    //Show Area
    $("body").on('click', '.show_areas', function () {
        var criters_id = $(this).attr('id');
        var criters_name = $(this).data('criteria-name');
        var max_points = $(this).data('criteria-points');
        var competency_id = $(this).data('competency-id');
        $('#crit_id').val(criters_id);
        $('#crit_max_points').text(max_points);
        $('#competency_id').val(competency_id);
        $('#crit_max').val(max_points);
        $('#criters_name').text(criters_name+'  '+'Area/s');

        pull_areaData(criters_id)
    });

}

function pull_areaData(criteria_id){
    $.ajax({
        url:  bpath + 'rating/show-criteria-areas/'+criteria_id,
        method: 'get',
        data: {
            _token:_token,
        },
        cache: false,
        success: function (data) {
            //console.log(data);
            // var status = data.status;
            // alert(status)
            /***/
            var data = JSON.parse(data);
            // alert(data.length)


            if(data.length > 0) {

                for(var i=0;i<data.length;i++) {
                        /***/

                        var areas_id = data[i]['id'];
                        var area = data[i]['area'];
                        var rate = data[i]['rate'];
                        var area_sum = data[i]['area_sum'];

                        $('#input_points').text(area_sum);


                        $('#addArea_table').append(
                            '<tr>'+
                                '<td style = "width: 40%">'+
                                    '<input type="hidden" value="'+areas_id+'" class="form-control" name="areasID[]" id="areasID" placeholder="Enter Area Rate">'+

                                    '<textarea class="form-control areaname" name="areaname[]" id="rate_name" placeholder="Enter Area">'+area+'</textarea>'+
                                    '<label id="on_selectSkill" class="text-xs cursor-pointer underline decoration-dotted underline-offset-4 text-primary dark:text-slate-400" href="javascript:;" data-tw-toggle="modal" data-tw-target="#select_skill_modal">select Skills</label>'+
                                '</td>'+
                                '<td>'+
                                    ' <input type="text" value="'+rate+'" id="arearate" class="form-control arearate" name="arearate[]" id="rate_id">'+
                                '</td>'+
                                '<td>'+
                                    ' <a href="javascript:;" id="'+areas_id+'" class="remove-table-row deleteArea"> <i class="fa fa-trash-alt w-4 h-4 mr-2 text-danger"></i></a>'+
                                '</td>'+
                            '</tr>');


                }

            }



        }
    });
}

function onClick_function(){
    // Select Class
    $("body").on('click', '.selectClass', function(){
        let _blank = "";
        if($('#select_id').text() == "Select from Competency"){
            $('.competency_div').show();
            $('.criteria_div').hide();
            $('#select_id').text('Manual Type Criteria');
            $('.criteria_div').hide();
            $('#competency').val(_blank);
            $('#criteria').val(_blank);
            dropdown();
        }else{
            $('.competency_div').hide();
            $('.criteria_div').show();
            $('#select_id').text('Select from Competency');
            $('#competency').val(_blank);
            $('#criteria').val(_blank);
            dropdown();
        }

    })

     //Add Row Area
     $("body").on('click', '#add_more', function () {

        $('#addArea_table > tbody').append(
         '<tr>'+
             '<td>'+
                '<input type="hidden" value="0" class="form-control" name="areasID[]" id="areasID">'+
                 '<textarea type="text" id="areaname" class="form-control areaname" name="areaname[]" id="rate_name" placeholder="Enter Area Area"></textarea>'+
                 '<label id="on_selectSkill" class="text-xs cursor-pointer underline decoration-dotted underline-offset-4 text-primary dark:text-slate-400" href="javascript:;" data-tw-toggle="modal" data-tw-target="#select_skill_modal">select Skills</label>'+
             '</td>'+
             '<td>'+

                 ' <input type="text" id="arearate" class="form-control arearate" name="arearate[]">'+

             '</td>'+
             '<td>'+
                 ' <a href="javascript:;" class="remove-table-row"> <i class="fa fa-trash-alt w-4 h-4 mr-2 text-danger"></i></a>'+
             '</td>'+
         '</tr>');


     });

     //Remove Row Area
     $("body").on('click', '.remove-table-row', function () {
        let row = $(this).closest('tr')
        var _arearate = row.find('td .arearate');

        var max_pointss = new Number($('#crit_max').val());
        var t_points = $('#input_points').text();

        var area_points = new Number(_arearate.val());
        var _t_points = new Number(t_points);
        // alert(area_points+' -- '+ _t_points)

        var deducting = new Number(_t_points - area_points);

        $('#input_points').text(deducting);

        if(deducting > max_pointss){
            $('#input_points').addClass('text-danger');
        }else{
            $('#input_points').removeClass('text-danger');
        }

         $(this).parents('tr').remove();


      });

      //on_selectSkill

      var area_name;
      var skill_point;
    $("body").on('click','#on_selectSkill', function () {
        var comp_id = $('#competency_id').val();
        var _tr = $(this).closest('tr');
        var _rate_name = _tr.find('td .areaname');
        var _arearate = _tr.find('td .arearate');
        area_name = _rate_name;
        skill_point = _arearate;

        $('#comp_id').val(comp_id)
        // $.ajax({
        //     url:  bpath + 'rating/dropdown-skills-area/'+comp_id,
        //     method: 'get',
        //     data: {
        //         _token:_token,
        //     },
        //     cache: false,
        //     success: function (re) {
        //         $('#_skill_dropdown').html(re);

        //         $('#_skills').select2({
        //             placeholder: "Select Skills",
        //             closeOnSelect: true,
        
        //         });

        //         $("#_skills").change(function (e) { 
        //             e.preventDefault();
        //             // alert('change')
        //             let skill_id = $(this).val();
        //             alert(skill_id);
        //         });
               
        //     }
        // });
    });

    //Select Skill
    $("body").on('click','#btn_skill_select', function () {
       var prev_value =  skill_point.val();
    let _skillVal = $('#_skills').val();
    let _skillText = $('#_skills :selected').text();
    let _skillPoints = $('#skill_point').val();
    let area_mx =  $('#crit_max').val();

    // console.log(_skillVal +' == '+_skillText)
    area_name.val(_skillText);
    area_name.css('border-color', '');
    skill_point.val(_skillPoints);
    skill_point.css('border-color', '');

    let points = $('#input_points').text();

    var skilss_points = new Number(_skillPoints);
    var _points = new Number(points);
    var deducted = new Number(_points - prev_value);
    // alert(deducted)
    var adding = new Number(deducted + skilss_points);

    // alert(_skillPoints);
    // var _skill_point = Number(skill_point);
    if(area_mx < adding){
        $('#input_points').addClass('text-danger');
    }else{
        $('#input_points').removeClass('text-danger');
    }

   $('#input_points').text(adding);

    const skill_modal = tailwind.Modal.getOrCreateInstance(document.querySelector('#select_skill_modal'));
    skill_modal.hide();
    
    });

    //delete Areas
    $("body").on('click', '.deleteArea', function () {
        var id = $(this).attr('id');
        $.ajax({
            url:  bpath + 'rating/delete-criteria-area/'+id,
            method: 'get',
            data: {
                _token:_token,
            },
            cache: false,
            success: function (response) {
                __notif_show( 1,"Area Deleted");
            }
        });
    });

    //rate area Modal
    $("body").on('click', '.rating_area', function () { 
        // alert('123')
        var id = $(this).attr('id');
        area_sumValue = $(this).closest('tr').find('.rateClass');
        // var rateValue = $(this).closest('tr').find('.rateClass');
        // rateValue.addClass('selected-input');
        var maxrate = $(this).data('max-rate');
        var critname = $(this).data('criteria-name');
        $('#criteria_name').text(critname +' '+'Area/s');
        var applicantID = $('#applicant_ids').val();
        var positionID = $('#position').val();
        var applicant_list_id = $('#applicant_list_id').val();
        var applicant_job_ref = $('#applicant_job_ref').val();
        // $('#ops_id').text(critname);
        // alert(applicant_list_id+' -- '+applicant_job_ref);
        $('#applicant_id').val(applicantID);
        $('#position_id').val(positionID);
        $('#applicant_list_ids').val(applicant_list_id);
        $('#applicant_job_refs').val(applicant_job_ref);
        $('#maximumrate').val(maxrate);

        if ($("#rating_check").is(":checked")) {
            
        }else{

        }
        $('#maxratelabel').text(maxrate);

        // alert(maxrate)
        $('#criteria_id').val(id);
        // $('#ratingArea_table').find('for-row-romoval').remove('tr');
        // $('.remove-table-row').parents('tr').remove();
        $("#ratingArea_table").find("tr:gt(0)").remove();
        // alert(id)
        $.ajax({
            url:  bpath + 'rating/show-rate-criteria-area/'+id,
            method: 'get',
            data: {
                _token:_token, 
                applicantID:applicantID, 
                positionID:positionID,
                applicant_list_id:applicant_list_id,
                applicant_job_ref:applicant_job_ref,
            },
            cache: false,
            success: function (data) {

                var data = JSON.parse(data);
                // alert(data.length);\
                // rateValue.val($('#rateSum').val());
                // console.log(data.length);
                if(data.length > 0) {
                    const myModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#ratingArias_modal"));
                    myModal.show();
                    for(var i=0;i<data.length;i++) {

                        var areas_id = data[i]['id'];
                        var area = data[i]['area'];
                        var rate = data[i]['rate'];
                        var max_rate = data[i]['max_rate'];
                        var max_average = data[i]['max_average'];
                        var rated_id = data[i]['rated_id'];
                        var sumall = data[i]['sumAll'];
                        var ratedArea_ave = data[i]['ratedArea_ave'];

                        $('#sumAll').val(sumall);
                        $('#rateSum').val(sumall);


                        if($("#rating_check").is(":checked")){
                            $('#sumOf_rate').text(ratedArea_ave);
                              $('#maxratelabel').text(max_average);
                        }else{
                            $('#sumOf_rate').text(sumall);
                        }
                       




                        $('#ratingArea_table').append(
                            '<tr>'+

                                '<td class="for-row-romoval">'+
                                    '<input type="hidden" value="'+rated_id+'" class="form-control" name="ratedArea_id[]" id="ratedArea_id">'+
                                    area+
                                '</td>'+

                                '<td class="for-row-romoval">'+
                                    '<input type="hidden" value="'+max_rate+'" class="form-control" name="max_area_rate[]" id="max_area_rate">'+
                                    max_rate+
                                '</td>'+

                                '<td>'+
                                    '<input type="hidden" value="'+areas_id+'" class="form-control" name="areas_id[]" id="areas_id">'+
                                    '<input type="text" value="'+rate+'" class="form-control areaClass" name="rate_area[]" maxlength="3" size="2" id="ratearea_name">'+
                                    '<label class="text-xs" id="rateArea_label"></label>'+
                                '</td>'+


                            '</tr>');

                    }
                }else{
                    const warning = tailwind.Modal.getOrCreateInstance(document.querySelector('#warning_Modal'));
                    warning.show();
                    $('#warning_text').text('This Criteria Does'+"'"+'nt Have Any  Area/s!');

                }


            }
        });
    });

    //onClick Rate Icon
    $("body").on('click','.rate_Icon', function () {
        var applicant = $(this).data('applicant-id');
        var position = $(this).data('position-id');
        var position_type = $(this).data('position-type')
        var applicant_list_id = $(this).data('applicant-list-id')
        var applicant_job_ref = $(this).data('applicant-job-ref')

        $('#applicant_ids').val(applicant);
        $('#position').val(position);
        $('#position_type').val(position_type);
        $('#applicant_list_id').val(applicant_list_id);
        $('#applicant_job_ref').val(applicant_job_ref);

        const rateModal = tailwind.Modal.getOrCreateInstance(document.querySelector('#rateModal'));
        rateModal.show();
        // console.log('applicant: '+applicant+'  Position: '+position+' Position Type: '+position_type);

        showCriteria(position)
    });

    //clock Btn Rate Icon
    $("body").on('click', '.timer_btn', function(){
        var rate_date = $(this).data('rate-date');
        // var date_today = $(this).data('date-today');
        // alert(date_today)
        var row = $(this).closest('tr');
        var p_tag = row.find('p.timer');
        var days_span = row.find('span.timer-days')
        var hour_span = row.find('span.timer-hours')
        var mins_span = row.find('span.timer-mins')
        var secs_span = row.find('span.timer-secs')
        var timer_btn = row.find('a.timer_btn')

        // alert(rate_date)
        // countdouwn_timer(rate_date);
        var endDate = new Date(rate_date).getTime();
            // alert(endDate);
        setInterval(function() {
                    // alert( timer)
            let now = new Date().getTime();
            // alert(new Date())
            let t = endDate - now;

        if (t >= 0) {

            let days = Math.floor(t / (1000 * 60 * 60 * 24));
            let hours = Math.floor((t % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            let mins = Math.floor((t % (1000 * 60 * 60 )) / (1000 * 60));
            let secs = Math.floor((t % (1000 * 60)) / 1000);


                var dd = days +':';
                days_span.text(dd);

                var h = ("0"+hours).slice(-2) + ':';
                hour_span.text(h);

                var m = ("0"+mins).slice(-2) +':';
                mins_span.text(m);

                var s = ("0"+secs).slice(-2) +'s';
                secs_span.text(s);


            // document.getElementById("timer-hours").innerHTML = ("0"+hours).slice(-2) +
            // "<span class='label'> Hr(s)</span>";

            // document.getElementById("timer-mins").innerHTML = ("0"+mins).slice(-2) +
            // "<span class='label'> Min(s)</span>";

            // document.getElementById("timer-secs").innerHTML = ("0"+secs).slice(-2) +
            // "<span class='label'> Sec(s)</span>";

        } else {

            //    p_tag.text("rating is available");

        }

    }, 1000);

    });

    //add row criteria
    var curentPosition_data = [];
    var curentCompetent_data = [];
    var Criteria = [];

    $("body").on('click','#add_row', function () {

        let _positionID = $('#positionss').val();
        let _competencyID = $('#competency').val();
        let _criteria = $('#criteria').val();
        let _maxrate = $('#maxrate').val();

        let _positionText = $('#positionss :selected').text();
        let _competenText = $('#competency :selected').text();

        var criteria_content = "";
            if(_competencyID != "" && _criteria == "" ){
                criteria_content = _competenText;
            }else if(_criteria != "" && _competencyID == ""){
                criteria_content = _criteria;
            }

        if(_positionID == "" ){
            $('#positionLabel').show();
        }else if(_maxrate == ""){
            $('#rateLabel').show();
        }
        else {

            if(_competencyID != "" && _criteria == "" || _criteria != "" && _competencyID == ""){

                curentPosition_data.push(curentPosition_data, _positionID);
                curentCompetent_data.push(_competencyID);
                // curentPosition_data.push(_positionID);

                console.log(curentPosition_data, curentCompetent_data);
                let _row = '<tr id="criteria_row">'+
                                '<td> <input value="'+_positionID+'" type="hidden" name="positionID[]"> '+_positionText+'</td>'+
                                '<td><input value="'+_criteria+'" type="hidden" name="criterias[]"> <input value="'+_competencyID+'" type="hidden" name="competencyID[]">'+criteria_content+'</td>'+
                                '<td><input value="'+_maxrate+'" type="hidden" name="maxrate[]">'+_maxrate+'</td>'+
                                '<td> <a id="remove_row" type="button" href="javascript:;"> <i class="fa fa-trash text-danger" aria-hidden="true"></i> </a> </td>'+
                                '</tr>';
                $('#crit_tbl').append(_row);

                $('#rateLabel').hide();
                $('#positionLabel').hide();
                $('#criteriaLabel').hide();
                $('#competencyLabel').hide();
            }else{
                $('#criteriaLabel').show();
                $('#competencyLabel').show();
            }


        }
        // console.log(_positionID+ '--' + _competencyID+ '-- ' +_maxrate +'-- '+_positionText+'-- '+_competenText)

    });

    //remove criteria row
    $("body").on('click', '#remove_row', function () {
        $(this).parents('tr').remove();
     });

}

function onSubmit(){
     // ADD CRITERIA
     $("#addCriteriaForm").submit(function (e) {
        e.preventDefault();

        curentPosition_data;
        curentCompetent_data;
        Criteria;


        var row_length = $('#crit_tbl').find('tr#criteria_row').length;
        const fd = new FormData(this);
                if(row_length > 0 ){
                    // alert('Save')
                    // var crit = $('#criteria').val();
                    var position = $('#positioncritPage').val();
                    // var maxrate = $('#maxrate').val();
                    $.ajax({
                        url:  bpath + 'rating/add-criteria',
                        method: 'post',
                        data: fd,
                        cache:false,
                        contentType: false,
                        processData: false,
                        dataType: 'json',

                        success: function (r) {
                            if(r.status == 200){
                            __notif_show( 1,"criteria Added Successfully");
                            $('#addCriteriaForm')[0].reset();
                            const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#addCriteria_modal'));
                            mdl.hide();
                            fetchedCriteria(position);
                            dropdown();
                            // $('#crit_tbl').find('tbody').detach();
                            $("#crit_tbl > tbody").html("");
                            }
                        }
                    });
                }else{
                    alert('Please Add Content of Criteria')
                }

     });

     // UPDATE CRITERIA
    $("#updateCriteria_form").submit(function (e) { 
        e.preventDefault();
        var position = $('#positioncritPage').val();
        const fd = new FormData(this);
        
        $.ajax({
            url:  bpath + 'rating/update-criteria',
            method: 'post',
            data: fd,
            cache:false,
            contentType: false,
            processData: false,
            dataType: 'json',

            success: function (r) {
            if(r.status == 200){
            __notif_show( 1,"Criteria Updated Successfully");
            $('#updateCriteria_form')[0].reset();
            const ediCreteriaModel = tailwind.Modal.getOrCreateInstance(document.querySelector('#update_criteria_Modal'));
            ediCreteriaModel.hide();
            fetchedCriteria(position);
            dropdown();
            }
        }
    });
    });

     //SAVE AREAS OF CRITERIA
     $('#area_form').submit(function (e) {

        e.preventDefault();
        var pos_id = $('#positioncritPage').val();
        let input_points = $('#input_points').text();
        let max_points = $('#crit_max').val();

        var num = Number(input_points);

        // console.log(input_points+' -- '+ num)
        if(num > max_points){
            alert('your input over its maximum points')
        }else{
            
            if(check_table_input()){

                const fd = new FormData(this);

                $.ajax({
                    url:  bpath + 'rating/add-criteria-area',
                    method: 'post',
                    data: fd,
                    cache:false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',

                    success: function (r) {
                        if(r.status == 200){
                        __notif_show( 1," Area/s Save Successfully");
                        $('#area_form')[0].reset();
                        $('.remove-table-row').parents('tr').remove();
                        const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#arias_modal'));
                        mdl.hide();

                        var selected = $('#manageRating_table').find('input.selected-input');
                        selected.removeClass('selected-input');
                        $('#input_points').text("");

                        }
                    }
                });
            }
        }

     });

    //SAVE RATINGS
    $('#saveRate_form').submit(function (e) {
            e.preventDefault();
            $('#ops_id').text('');
            var ratessss =   $('#manageRating_table').find('input.rateClass');
            var ffd = ratessss.val() == 0;

                var ff =   $('#manageRating_table').find('label.text-danger').length;
                // var app = $('#applicant').find('selected');
                // var cc =
                // alert(app)
                var rowCount = $('#manageRating_table > tbody').find('tr').length;

                let rate_sum = $('#foot_totalrate').text();

                if( ff != 0)
                {
                    const warning = tailwind.Modal.getOrCreateInstance(document.querySelector('#warning_Modal'));
                    warning.show();
                    $('#warning_text').text('You Can'+"'"+'t rate Above its Maximum Rate!!');

                }
                else{
                    const fd = new FormData(this);
                    $.ajax({
                        url:  bpath + 'rating/save-rating',
                        method: 'POST',
                        data: fd,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function (res) {

                            if(res.status == 200){

                                __notif_show( 1,"Applicant Rated Successfully");
                                $('#saveRate_form')[0].reset();
                                const rateModal = tailwind.Modal.getOrCreateInstance(document.querySelector('#rateModal'));
                                rateModal.hide();
                                fetched_rated();
                            }
                        }
                    });
                }

    });

    //SAVE RATED AREA
    $("#ratingarea_form").submit(function (e) {
        e.preventDefault();

       var rates = $('#rateSum').val();
        //    alert(rates);
       var applicantPosition_id = $('#position_id').val();

        var ff =   $('#ratingarea_form').find('a.text-danger').length;
        var cc =   $('#ratingArea_table').find('label.text-danger').length;


        if(cc != 0){

            $('#errorCacher').addClass('text-danger').text('Unable to Save.!!! You Rated Over its Maximum Rate');

        }else{

            var formdata = new FormData(this);

            $.ajax({
                url:  bpath + 'rating/store/rated-areas',
                method: 'POST',
                data: formdata,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (data) {
                    let rate_input = $('#rateSum').val();
                    if(data.status == 200){

                        area_sumValue.val(rate_input);
                        // __notif_show( 1,"Area rate Save");
                        $('#ratingarea_form')[0].reset();
                        const myModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#ratingArias_modal"));
                        myModal.hide();

                    //     var c_id = $('#criteria_id').val();
                    // // showCriteria(applicantPosition_id);
                    // alert
                    //   var rr =  $('#manageRating_table').find('.criteria-id-classs');
                    //   alert(rr.val());
                    //   var rateValues = rr.closest('tr').find('.rateClass');



                    }
                }
            });
        }
    });


}


function cancel(){
   $("#addCriteriaForm").submit(function (e) {
    e.preventDefault();
    $("#addCriteriaForm")[0].reset();
   });

   $("#editCriteriaForm").submit(function (e) {
    e.preventDefault();
    $("#editCriteriaForm")[0].reset();
   });


   $("body").on('click', '#btn_cancel', function () {
    $('#input_points').text("");
        let _blank = "";
        $("#crit_tbl > tbody").html("");
        $('.remove-table-row').parents('tr').remove();
        $("#positionss").val(_blank);
        $("#competency").val(_blank);
        $("#criteria").val(_blank);
        $("#maxrate").val(_blank);
        dropdown();

   });

  

   $("body").on('click', '#cnl_area_rating', function () {

    $('#ratingarea_form')[0].reset();
    $('#sumOf_rate').removeClass('text-danger');
    $('#sumOf_rate').text("");
   });

   $("body").on('click', '#cnl_rate_modal', function () {
    $('#saveRate_form')[0].reset();
    $('#foot_maxrating').text('0');
    $('#foot_totalrate').text('0');
    });

    $("body").on('click','#btn_c_skill_select', function () {
        let _blank = "";
        $('#_skills').val(_blank);
    });

   dropdown();
}

function dropdown(){

        $('#positioncritPage').select2({
            placeholder: "Select Position Category",
            closeOnSelect: true,
            allowClear: true
        });


        $('#position1').select2({
            placeholder: "Select Position Category",
            closeOnSelect: true,

        });
        $('#applicant').select2({
            placeholder: "Select Applicant",
            closeOnSelect: true,

        });

        $('#positionss').select2({
            placeholder: "Select Position",
            closeOnSelect: true,

        });
        $('#competency').select2({
            placeholder: "Select Competency",
            closeOnSelect: true,

        });

        $('#_skills').select2({
            placeholder: "Select Skills",
            closeOnSelect: true,

        });
        $('#position_up').select2({
            placeholder: "Select Position",
            closeOnSelect: true,

        });
        $('#competency_up').select2({
            placeholder: "Select Competency",
            closeOnSelect: true,

        });


}
    //////////////////////////////

function fetched_rated(){
    $.ajax({
        url:  bpath + 'rating/filter-rated-applicants',
        type: "get",
        data: {
        _token: _token,
        },
        success: function (response) {
            $('#tbl_applicant_rated_div').html(response);

            $('#tbl_applicant_rated').DataTable({
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
                "iDisplayLength": 5,
                "aaSorting": [],

                order: [0, 'desc']

            });
        }
    });

}

function loadTables(){

    tbl_applicant_rated = $('#tbl_applicant_rated').DataTable({
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
                            "iDisplayLength": 5,
                            "aaSorting": [],

                            order: [0, 'desc']

                        });

    rating_table =  $('#manageRating_table').DataTable({
                        dom: 'lrt',
                        renderer: 'bootstrap',
                        "info": false,
                        "bInfo":true,
                        "bJQueryUI": true,
                        "bProcessing": true,
                        "bPaginate" : false,
                        "aaSorting": [],

                        order: [0, 'desc'],

                    });
}

function onChange(){

    $('#position1').change(function (e) {
        e.preventDefault();
        var id = $(this).val();
        // alert(id)


        $.ajax({
            url:  bpath + 'rating/filter-by-position/'+id,
            type: "get",
            data: {
                _token: _token,
            },
            success: function(data) {

                rating_table.clear().draw();
				/***/
				var data = JSON.parse(data);

				if(data.length > 0) {
					for(var i=0;i<data.length;i++) {
							/***/

                            var criteria_id = data[i]['id'];
                            var criteria = data[i]['criteria'];
                            var positionID = data[i]['positionID'];
                            var maxrate = data[i]['maxrate'];

                            var cd = "";
							/***/

								cd = '' +

						                    '<td class="group_member_id">' +
                                                '<div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">'+
                                                    '<a href="" class="font-medium">'+criteria+'</a>'+
                                                    '<div class="text-slate-500 text-xs mt-0.5">Software Engineer</div>'+
                                                '</div>'+

						                    '</td>' +

                                            '<td>' +
                                                '<div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">'+
                                                    '<div class="text-slate-500 text-xs mt-0.5">Maximum Rating</div>'+
                                                    '<a href="" class="font-medium">'+maxrate+'</a>'+
                                                '</div>'+
						                    '</td>' +


                                            '<td>' +
                                                '<div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">'+
                                                    '<div class="text-slate-500 text-xs mt-0.5">Your Rating</div>'+
                                                    '<input id="criteriaID" name="criteriaID[]" value="'+criteria_id+'" type="hidden">'+
                                                    '<input id="rate" name="rate[]" type="text">'+
                                                '</div>'+
						                    '</td>' +



						                '</tr>' +
								'';

								rating_table.row.add($(cd)).draw();


							/***/

					}

				}



            }
        });

    });

    $('#positioncritPage').change(function (e) {
        e.preventDefault();
        var id = $(this).val();
        fetchedCriteria(id);

    });

    $('#applicant').change(function (e) {
        e.preventDefault();
        var applicant_id = $(this).val();
        showPosition(applicant_id)
        // alert(appID)
    });

    $('#competency').change(function (e) {
        e.preventDefault();
        var competency_id = $(this).val();

        $.ajax({
            url:  bpath + 'rating/onchange-competency-points/'+competency_id,
            type: "get",
            data: {
                _token: _token,
            },
            success: function (res) {
                let points = res.points;
                $('#maxrate').val(points);
            }
        });

    });

    $("#_skills").change(function (e) { 
        e.preventDefault();

        let skill_id = $(this).val();

        $.ajax({
            url:  bpath + 'rating/onchange-skill-points/'+skill_id,
            type: "get",
            data: {
                _token: _token,
            },
            success: function (res) {
                let skill_points = res.skill_points;
                $('#skill_point').val(skill_points);
            }
        });
        
    });

}

function showPosition(applicant_id){

    $.ajax({
        url:  bpath + 'rating/filter-position-applicant/'+applicant_id,
        type: "get",
        data: {
            _token: _token,
        },
        success: function(data){
            /***/
            $('#positionApplied_div').html(data);

             $('#ApplicantPosition_select').select2();

                $('#ApplicantPosition_select').change(function (e) {
                    e.preventDefault();

                    // alert('potaaaa')

                    var applicantPosition_id = $(this).val();

                    // alert(appl_id)
                    showCriteria(applicantPosition_id);



                });

            }
    });
}

function showCriteria(applicantPosition_id){
    // var applicantid = $('#applicant').val();
    // var position = $('#applicant_ids').val(applicant);
    // var applicant = $('#position').val(position);
    var applicant_s_list_id = $('#applicant_list_id').val();
    var applicant = $('#applicant_ids').val();

    // alert(applicantid);
    $.ajax({
        url:  bpath + 'rating/filter-by-position/'+applicantPosition_id,
        type: "get",
        data: {
            _token: _token,applicantid:applicant,applicant_s_list_id:applicant_s_list_id,
        },
        success: function(data) {
            // console.log(data);
            rating_table.clear().draw();
            /***/
            var data = JSON.parse(data);

            if(data.length > 0) {

                for(var i=0;i<data.length;i++) {
                        /***/

                        var criteria_id = data[i]['id'];
                        var criteria = data[i]['criteria'];
                        var positionID = data[i]['positionID'];
                        var maxrate = data[i]['maxrate'];
                        // var p_category = data[i]['p_category'];
                        // var p_categoryID = data[i]['p_categoryID'];
                        var totalMax_rate = data[i]['totalMax_rate'];
                        var areaSum = data[i]['areaSum'];
                        var area_sum_all = data[i]['area_sum_all'];
                        var count_criteria = data[i]['count_criteria'];
                        var max_ave = data[i]['max_ave'];


                        $('#max_percent').val(totalMax_rate)
                        $('#foot_maxrating').text(totalMax_rate+'%')
                        // $('#p_category').val(p_category);
                        // $('#p_categoryID').val(p_categoryID);
                        $('#foot_totalrate').text(area_sum_all);
                        $('#count_criteria').val(count_criteria);
                        $('#max_ave').val(max_ave);

                        if(totalMax_rate > 100){
                            $('#overrate').text('The rating is Over');
                        }



                    var cd = "";

                    /***/

                    cd = '' +
                            '<tr >' +

                                '<td class="group_member_id">' +
                                    '<div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">'+
                                        '<a href="javascript:;" class="font-medium">'+criteria+'</a>'+

                                    '</div>'+

                                '</td>' +

                                '<td>' +
                                    '<div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">'+
                                        '<input id="maxratehidden" value="'+maxrate+'" type="hidden">'+
                                        '<label>'+maxrate+'</label>'+
                                    '</div>'+
                                '</td>' +

                                '<td>' +
                                    '<div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">'+
                                        '<a id="'+criteria_id+'" data-criteria-name="'+
                                                criteria+'" data-max-rate="'+
                                                maxrate+'" href="javascript:;"'+
                                            'class="underline decoration-dotted underline-offset-4 text-primary dark:text-slate-400 cursor-pointer rating_area">'+
                                            'Areas'+
                                        '</a>'+

                                    '</div>'+
                                '</td>' +

                                '<td>' +
                                    '<div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">'+
                                        '<input class="criteria-id-classs" id="criteriaID" name="criteriaID[]" value="'+criteria_id+'" type="hidden">'+
                                        '<input id="rate" name="rate[]" value="'+areaSum+'" class="rateClass" maxlength="3" size="1" type="text" >'+
                                        '<label id="rateLabel" class="text-xs"></label>'+
                                    '</div>'+
                                '</td>' +

                            '</tr>' +
                    '';

                    rating_table.row.add($(cd)).draw();


                        /***/

                }


                $('#tfoot_id').show();
                $('#remarks_div').show();
                $('#saveRate_btn').show();
                // count_ratingTable();
            }else{
            $('#tfoot_id').hide();
            $('#remarks_div').hide();
            $('#saveRate_btn').hide();
            }

            toggleCheck();

        }
    });
}

function toggleCheck(){

    $("#rating_check").on("click", function(){
        var id = parseInt($(this).val(), 10);

        var ave;
        var percent;

        let max_average = $('#max_ave').val();
        let max_percent = $('#max_percent').val();
        let average_ratee = $('#total_average_rate').val();
        let percent_ratee = $('#total_rate').val();
            // (max_average+'-- = '+average_ratee+' -- '+max_percent+' -- = '+percent_ratee)
            // console.log(max_average, max_percent, average_ratee, percent_ratee);

        if($(this).is(":checked") || $("#rating_check").is(":checked")) {
            $("#total_name").text('Total Average');
            $('#foot_maxrating').text(max_average);
            $('#foot_totalrate').text(average_ratee);
            $('#checkbox').val(1);
            
        } else {
            $('#foot_maxrating').text(max_percent+'%');
            $('#foot_totalrate').text(percent_ratee+'%');
            $("#total_name").text('Total Percent');
            $('#checkbox').val(0);
        }
    });

}

function refresh(){
    $("body").on('click', '#refresh', function () {
        fetchedCriteria();

            $('.select2-selection__clear').remove();

            $('#positioncritPage').select2({
                placeholder: "Select Position Category",
                closeOnSelect: true,
                allowClear: true
            });


    });
}

function manageRating_Validation(){

    $("#manageRating_table").on('change', 'input', function () {

        var _thisTr = $(this).closest('tr');
        var maxrating = _thisTr.find('td #maxratehidden');

        var _thisMax = maxrating.val();
        var _thisVaue = $(this).val();

        var _maxNum = Number(_thisMax);
        var _thisNum = Number(_thisVaue);

        var _ratingLabel = _thisTr.find('td #rateLabel');


        if(_thisNum <= _maxNum){

            $(this).css('border-color', '');
            _ratingLabel.text("").removeClass('text-danger');

        }
        else if(_thisNum > _thisMax){
            $(this).css('border-color', '#Ff696c');
            _ratingLabel.text('Your Exceed the Maximum Points').addClass('text-danger');
        }




    });

    $("#ratingArea_table").on('change', 'input', function () {

        var _thisTr = $(this).closest('tr');
        var maxrating = _thisTr.find('td #max_area_rate');

        var _thisMax = maxrating.val();
        var _thisVaue = $(this).val();

        var _maxNum = Number(_thisMax);
        var _thisNum = Number(_thisVaue);

        var _ratingLabel = _thisTr.find('td #rateArea_label');


        if(_thisNum <= _maxNum){

            $(this).css('border-color', '');
            _ratingLabel.text("").removeClass('text-danger');
            $('#errorCacher').removeClass('text-danger').text("");

        }
        else if(_thisNum > _thisMax){
            $(this).css('border-color', '#Ff696c');
            _ratingLabel.text('Your Exceed the Maximum Points').addClass('text-danger');
        }




    });
}

function sumOf_areaInput_points(){

//   var  table = $("#addArea_table")

  var total_areaRate = 0.00;

  $("#addArea_table").on('change', function () {
        var rateArea = $( this.node() ).first().find('#arearate').val();

        total_areaRate += parseFloat(rateArea);

    } );

    // const sdf = total_areaRate.toLocaleString('en-US');
    $('#input_points').text( total_areaRate);
}

function check_table_input()
{
    let row = $("#addArea_table").find('tr');

      var emptyInputs = row.find("input").filter(function() {
        return this.value === "";

      });

      var emptytextArea = row.find("textarea").filter(function() {
        return this.value === "";
        
      });

      if ( emptytextArea.length != 0) {

            emptytextArea.css('border-color', '#ff0000');
            return false;

      } else {
        emptytextArea.css('border-color', '');

        if ( emptyInputs.length != 0) {

            emptyInputs.css('border-color', '#ff0000');
            return false;

        } else{
            emptyInputs.css('border-color', '');
            return true;
        }
     }


}

function sum_rate(){
    // CRITERIA RATE SUM
    $("#manageRating_table").on('input', '.rateClass', function () {
        var calculated_total_sum = 0;
        var average = 0;

        let count_criteria = $('#count_criteria').val();


            $("#manageRating_table .rateClass").each(function () {
                var get_textbox_value = $(this).val();
                if ($.isNumeric(get_textbox_value)) {
                calculated_total_sum += parseFloat(get_textbox_value);
                }
             });

            average = calculated_total_sum/count_criteria;
            
            
                $('#total_average_rate').val(average);
              
               $('#total_rate').val(calculated_total_sum);

               if($('#rating_check').is(":checked")){
                    $("#foot_totalrate").text(average);
               }else{
                    $("#foot_totalrate").text(calculated_total_sum+'%');

               }
        });

    // ARIA RATE SUM
    $("#ratingArea_table").on('input', '.areaClass', function () {
        var area_total_sum = 0;
        var area_total_ave = 0;


        $("#ratingArea_table .areaClass").each(function () {
            var get_textbox_value = $(this).val();
            if ($.isNumeric(get_textbox_value)) {
                area_total_sum += parseFloat(get_textbox_value);
            }
        });

            var rowCount = $('#ratingArea_table > tbody').find('tr').length;
            // var selected = $('#manageRating_table').find('input.selected-input');
            
            area_total_ave = area_total_sum/rowCount;

            if($('#rating_check').is(":checked")){

                $("#sumOf_rate").text(area_total_ave);
                $("#rateSum").val(area_total_ave);
                // selected.val(area_total_ave);

            }else{
                $("#rateSum").val(area_total_sum);
                $("#sumOf_rate").text(area_total_sum);
                // selected.val(area_total_sum);
            }
            


           

            if(area_total_sum > $('#maximumrate').val()){
                $('#sumOf_rate').addClass('text-danger');
                $('#input_areaRate').addClass('text-danger');
            }
            else{
            $('#sumOf_rate').removeClass('text-danger');
            $('#input_areaRate').removeClass('text-danger');
            }
            
            
    });

    //AREA MAX SUM
    $("#addArea_table").on('input', '.arearate', function () {
        var crit_max_sum = 0;


        $("#addArea_table .arearate").each(function () {
            var get_textbox_val = $(this).val();
            if ($.isNumeric(get_textbox_val)) {
                crit_max_sum += parseFloat(get_textbox_val);
                $(this).css('border-color', '');
            }else{
                $(this).css('border-color', '#Ff696c');
            }
                });


                $("#input_points").text(crit_max_sum);
                //    $("#crit_max").val(crit_max_sum);

                if(crit_max_sum > $('#crit_max').val()){
                    $('#input_points').addClass('text-danger');
                }
                else{
                $('#input_points').removeClass('text-danger');
                }

    });
            
}

function countdouwn_timer(rateDate){

    var endDate = new Date(rateDate).getTime();
    // alert(endDate);
    var timer = setInterval(function() {

    let now = new Date().getTime();
    let t = endDate - now;

    if (t >= 0) {

        let days = Math.floor(t / (1000 * 60 * 60 * 24));
        let hours = Math.floor((t % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        let mins = Math.floor((t % (1000 * 60 * 60)) / (1000 * 60));
        let secs = Math.floor((t % (1000 * 60)) / 1000);

        document.getElementById("timer-days").innerHTML = days +
        "<span class='label'> Day(s)</span>";

        document.getElementById("timer-hours").innerHTML = ("0"+hours).slice(-2) +
        "<span class='label'> Hr(s)</span>";

        document.getElementById("timer-mins").innerHTML = ("0"+mins).slice(-2) +
        "<span class='label'> Min(s)</span>";

        document.getElementById("timer-secs").innerHTML = ("0"+secs).slice(-2) +
        "<span class='label'> Sec(s)</span>";

    } else {

        document.getElementById(timer).innerHTML = "The countdown is over!";

    }

}, 1000);
}



