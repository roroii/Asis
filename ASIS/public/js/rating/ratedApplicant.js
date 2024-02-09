
var  _token = $('meta[name="csrf-token"]').attr('content');

$(document).ready(function () {
    bpath = __basepath + "/";
    $('#ramarks_div').hide();

    _thisSelect();
    onChange_function();
    fetched_rated_applicants();
    fetch_Select_applicant()
    _onClick_function();
    onSubmit();
    cancel();

});
function _thisSelect(){
    $('#pos_cat').select2({
        placeholder: "Select Position ",
        closeOnSelect: true,

    });

    $('#active_position').select2({
        placeholder: "Select Position ",
        closeOnSelect: true,

    });
    $('#interview_status').select2({
        placeholder: "Select Status ",
        closeOnSelect: true,

    });
    $('#interview_position').select2({
        placeholder: "Select position ",
        closeOnSelect: true,

    });
    $('#position').select2({
        placeholder: "Select position ",
        closeOnSelect: true,

    });

    $('#status_rated').select2({
        placeholder: "Select Status ",
        closeOnSelect: true,

    });
}

function onChange_function(){
    $("body").on('change', '#position', function () {
        var position_id = $(this).val();
        var status_id = $('#status_rated').val();
        fetched_rated_applicants(position_id, status_id)
    });
    $("body").on('change', '#status_rated', function () {
        var status_id = $(this).val();
        var position_id = $('#position').val();
        fetched_rated_applicants(position_id, status_id)
    });

    $("body").on('change', '#active_position', function () {
        var active_position_id = $(this).val();
        // alert(active_position_id)
        fetch_Select_applicant(active_position_id)
    });

    $("#rated_check").on("click", function(){
        var status_id = $('#status_rated').val();
        var position_id = $('#position').val();

        var rated_check_in_value;

        if($(this).is(":checked") || $("#rated_check").is(":checked")) {

            rated_check_in_value =  $('#rated_check_in').val(1);
            
        } else {

            rated_check_in_value = $('#rated_check_in').val(0);
        }

        fetched_rated_applicants(position_id, status_id)

    });
    
}

function _onClick_function(){

    $("body").on('click', '.printSummary_btn', function () {
    
        let rated_check_in_value = 0;
            if($("#rated_check").is(":checked")) {

                rated_check_in_value = 1;
                
            } else {

                rated_check_in_value = 0;
            }
            // alert(rated_check_in_value);
       $('#toggleCheck_value').val(rated_check_in_value);
      
    });
    //Hire Class Button
    $("body").on('click', '.hired_class', function(){
        let rated_id = $(this).data('rated-id')
        let shortList_id = $(this).data('shortlist-id')
        let applicant_id = $(this).data('applicant-id')
        let ref_num = $(this).data('job-ref')
        let position_id = $(this).data('position-id')
        let name = $(this).data('name')
        let status_id = $('#status_rated').val();
        let positionRated_id = $('#position').val();
        // alert(name)
        $.ajax({
            url:  bpath + 'rating/hire-applicant/'+shortList_id,
            method: 'get',
            data: {_token:_token,
                        applicant_id:applicant_id,
                        rated_id:rated_id,
                        ref_num:ref_num,

                    },
            success: function (response) {
                console.log(response.status);

                if(response.status == 200){
                    __notif_show( 1, name+ " is Registered as new Employee");

                    fetched_rated_applicants(positionRated_id, status_id);
                    _thisSelect()
                }
                else if(response.status == 400){
                    __notif_show( 1, name+" Position is Updated");
                    fetched_rated_applicants(positionRated_id, status_id);
                    _thisSelect();

                }
            }
        });

    })

    // Disapprove Class Button
    $("body").on('click', '.disapprove_class', function(){
        let rated_id = $(this).attr('id');
        let notify = $(this).data('notify');
        let status = $(this).data('status');

        let status_id = $('#status_rated').val();
        let positionRated_id = $('#position').val();

        // alert(notify)
        if(notify != 0 && status === 22){
            
                Swal.fire({
                    title: '<strong>Can'+"'t"+' Disapprove</strong>',
                    icon: 'warning',
                    html:
                      'Applicant interview is already <b>Notified</b> by the Head',
                    showCloseButton: false,
                    showCancelButton: false,
                    focusConfirm: false,
                    confirmButtonText:
                      'Ok',
                    confirmButtonAriaLabel: 'Thumbs up, Ok',
    
                  })
                      
        }else{

            $.ajax({
                url:  bpath + 'rating/disapprove-applicant/'+rated_id,
                method: 'get',
                data: {_token:_token,
                        },
                success: function (response) {
                    console.log(response.status);

                    if(response.status == 200){
                        __notif_show( 1," Applicant Disapproved");

                        fetched_rated_applicants(positionRated_id, status_id);
                        _thisSelect()
                    }

                }
            });

        }
       
    })

    // Change Status Button
    $("body").on('click', '._changeStat', function () {
        let rates_id = $(this).attr('id')
        let position = $(this).data('position-id')
        let status_id = $('#status_rated').val();
        let positionRated_id = $('#position').val();

        $.ajax({
            url:  bpath + 'rating/change-status/'+rates_id+'/'+position,
            method: 'get',
            data: {_token:_token,
                    },
            success: function (response) {
                console.log(response.status);

                if(response.status == 200){
                    __notif_show( 1," Status Change Successfully ");

                    fetched_rated_applicants(positionRated_id, status_id);
                    _thisSelect()
                }

            }
        });
    });

    // End Contruct Button
    $("body").on('click', '.end_contruct', function () {
        let ratess_id = $(this).attr('id')
        let positions_ids = $(this).data('position-id')
        let applicant_id = $(this).data('applicant-id')
        let status_id = $('#status_rated').val();
        let positionRated_id = $('#position').val();

        $.ajax({
            url:  bpath + 'rating/end-contruct',
            method: 'get',
            data: {_token:_token, applicant_id:applicant_id, 
                    ratess_id:ratess_id, 
                    positions_ids:positions_ids,
                    },
            success: function (response) {
                // console.log(response.status);
                if(response.status == 200){
                    __notif_show( 1,"Contruct Ends Successfully ");

                    fetched_rated_applicants(positionRated_id, status_id);
                    _thisSelect()
                }

            }
        });
    });

    //Proceed to final listed Button
    $("body").on('click','.proceed', function () {
        let rated_doneID = $(this).attr('id');
        var postion_d = $('#position').val();
        let status_id = $('#status_rated').val();
        let positions_ids = $(this).data('position-id')
        // alert(id);
        $.ajax({
            url:  bpath + 'rating/final-proceed-applicant/'+rated_doneID,
            method: 'get',
            data: {_token:_token
                    },
            success: function (response) {
                // console.log(response.status);
                if(response.status == 200){
                    __notif_show( 1,"Applicant Proceeded");

                    
                    fetched_rated_applicants(postion_d, status_id);
                }

            }
        });
    });

        //Applicant Info

    // $("body").on('click', '.btn_info', function () {
    //     let id = $(this).attr('id');
    //     let position_id = $(this).data('position-id');
    //     let position_name = $(this).data('position-name');
    //     let job_ref = $(this).data('job-ref');
    //     let applicant_name = $(this).data('name');
    //     let status = $(this).data('status');
    //     let recommend_by = $(this).data('recommend-by');
    //     let applicant_id = $(this).data('applicant-id');
    //     console.log(id+' -- ' +position_id+
    //                 ' -- ' +position_name+' -- ' +job_ref+
    //                 ' -- ' +applicant_name+' -- ' +status+' -- ' +
    //                 recommend_by+' -- ' +applicant_id);
    //         $.ajax({
    //             url:  bpath + 'rating/applicant-information',
    //             method: 'get',
    //             data: {_token:_token,id,position_id,position_name,job_ref,applicant_name,status,recommend_by,applicant_id,
    //                     },
    //             success: function (response) {
    //                 // console.log(response.status);    
    //                 // if(response.status == 200){
    //                 //     __notif_show( 1, name+"  is Selected");    
    //                 //     fetch_Select_applicant(pos_id);
    //                 // }    
    //             }
    //         });
    // });

//Notify Applicant

    $("body").on('click','.notify_applicant', function () {
        // alert('123')
        let id = $(this).attr('id');
        let position_id = $(this).data('position-id');
        let position_name = $(this).data('position-name');
        let job_ref = $(this).data('job-ref');
        let applicant_id = $(this).data('applicant-id');
        let proceeded_by = $(this).data('proceeded-by');
        let name = $(this).data('name');
        let status = $(this).data('status');

        const notify_Modal = tailwind.Modal.getInstance(document.querySelector("#notifyier_modal"));
        notify_Modal.show();

        $('#applicant_name').text(name);
        $('#proceeded_by').text(proceeded_by);
        $('#status').text(status);
        $('#rated_id').val(id);
        $('#position_id').val(position_id);
        $('#job_ref').val(job_ref);
        $('#applicant_id').val(applicant_id);

    });

    //listed_countClass
    $("body").on('click', '.listed_countClass', function () {
        let rated_doneID = $(this).attr('id');
        let position_ref = $(this).data('job-ref')
        let position_name = $(this).data('position-name')
        // alert(position_name+' -- '+position_ref+' -- '+rated_doneID)
        $('#header_name').text('Position :  '+ position_name)

        fetching_finalListing(position_ref)
    });

    //Final Listed Applicant Pass
    $("body").on('click',' .listed_pass', function () {

        let id = $(this).attr('id')
        let name = $(this).data('name')
        let job_ref = $(this).data('job-ref')
        let remarks = $(this).data('remarks')
        let aplicant_profile_pic = $(this).data('aplicant-profile')
        let pos_id = $('#active_position').val();

        // alert(job_ref);

        $('#selection_modal_image').attr('src', aplicant_profile_pic)
        $('#select_applicantName').text(name)
        $('#remarks').text(remarks);
        $('#listed_id').val(id);
        $('#job_ref').val(job_ref);
        $('#applicantName_input').val(name);

    });

    //Final Select Save
    $("body").on('click', '#select_save', function () {

        let liste_id =  $('#listed_id').val();
        let job_ref =  $('#job_ref').val();
        let pres_notes =  $('#pres_notes').val();
        let name =  $('#pres_notes').val();
        // alert(job_ref+'-- '+liste_id+'-- '+pres_notes)
        $.ajax({
            url:  bpath + 'rating/select-applicant/'+liste_id,
            method: 'get',
            data: {_token:_token, pres_notes:pres_notes,
                    },
            success: function (response) {
                // console.log(response.status);

                if(response.status == 200){
                    __notif_show( 1, name+"  is Selected");

                    $('#pres_notes').val("");
                    const select_Modal = tailwind.Modal.getInstance(document.querySelector("#selection_modal"));
                    select_Modal.hide();

                    fetching_finalListing(job_ref)
                }

            }
        });
    });
     //Final Listed Applicant Return
     $("body").on('click',' .listed_return', function () {

        let id = $(this).attr('id')
        let job_ref = $(this).data('job-ref')
        let pos_id = $('#active_position').val();

        $.ajax({
            url:  bpath + 'rating/return-applicant/'+id,
            method: 'get',
            data: {_token:_token,
                    },
            success: function (response) {
                // console.log(response.status);

                if(response.status == 200){
                    __notif_show( 1,"Return Successfuly");

                    fetching_finalListing(job_ref)
                }

            }
        });

    });

    //On Click Rater info
    $("body").on('click','.rater_click', function () {
        let rater_id = $(this).attr('id');
        let rater_name = $(this).data('rater-name');
        let rater_points = $(this).data('points');
        let check_value = $(this).data('check-value');
        let applicant_id = $('#applicant_id').val();
        let job_ref = $('#job_ref').val();
        let short_list = $('#short_listID').val();

        $('#rater_name').text('Rated By:  '+rater_name);
        $('#rater_point').text(rater_points);
        $('#ramarks_div').show();
        

        $.ajax({
            url:  bpath + 'rating/rater-criteria-points',
            method: 'get',
            data: {_token:_token,rater_id,applicant_id,job_ref,short_list,check_value,
                    },
            success: function (response) {
                // console.log(response);
                $('#crit_points').html(response.criteria);
                $('#rater_remark').text(response.remark);
            }
        });

    });

    //On Click Criteria Info
    $("body").on('click','.tr_criteria', function () {
        let crit_id = $(this).attr('id')
        let crit_name = $(this).data('criteria-name')
        let rater_agency_id = $(this).data('rater-agency-id')
        let _applicant_id = $('#applicant_id').val()
        let _job_ref = $('#job_ref').val()
        let _short_listID = $('#short_listID').val()

        $('#criter_name').text(crit_name);
        // alert(crit_id+'-- '+crit_name+'-- '+rater_agency_id)

        const area_rater_infoModal = tailwind.Modal.getInstance(document.querySelector("#aria_rate_info_modal"));
        area_rater_infoModal.show();

        $.ajax({
                url:  bpath + 'rating/rater-aria-points',
                method: 'get',
                data: {_token:_token,crit_id,rater_agency_id,_applicant_id,_job_ref,_short_listID,
                        },
                success: function (response) {
                    // console.log(response);
                    $('#raterArea_points_div').html(response);
                }
            });
    });

    //Remove Applicant
    $("body").on('click', '.remove_applicant', function () {
        let position = $('#position').val();
        let status_id = $('#status_rated').val();
        let rated_id = $(this).attr('id');

        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Remove it!'
          }).then((result) => {
            if (result.value == true) {
              $.ajax({
                    url:  bpath + 'rating/remove-applicant/'+rated_id,
                    method: 'get',
                    data: {_token:_token,
                            },
                    success: function (response) {
                        // console.log(response);
                        // console.log(response.status);
        
                        if(response.status == 200){
                            __notif_show( -1,"Applicant Remove Successfuly");
        
                            fetched_rated_applicants(position, status_id);
                        }else{
                            swal("Warning!", "Remove Unsuccessful.", "warning");
                        }
                        
                    }
                });
            }
        
        })
    });
}

function cancel(){
    var final_position = $('#active_position').val();
    $("body").on('click' ,'#btn_cancel_listed_modal', function () {

        fetch_Select_applicant(final_position)
    });
}

function fetching_finalListing(position_ref){
    $.ajax({
        url:  bpath + 'rating/fetched/listed-modal-applicant/'+position_ref,
        type: "get",
        data: {
            _token: _token,
        },
        success: function(data) {

            $('#listed_tbl_div').html(data);
            
            $('#listed_tbl').DataTable({
                dom: 'lrt',
                    renderer: 'bootstrap',
                    "info": false,
                    "bInfo":true,
                    "bJQueryUI": true,
                    "bProcessing": true,
                    "bPaginate" : false,
                    "aaSorting": [],
            });

        }
    });
}

function onSubmit(){

    $('#2ndInterview_form').submit(function (e) { 
        e.preventDefault();

        const fd = new FormData(this);

        let ffrrr = $('#interview_date').val();
        
        if(ffrrr == ""){
            $('.requiredClass').removeClass('text-slate-600');
            $('.requiredClass').addClass('text-danger');
            // alert('puta')
        }else{

            $('.requiredClass').removeClass('text-danger');
            $('.requiredClass').addClass('text-slate-600');
            

            $.ajax({
                url:  bpath + 'rating/notify-applicant',
                method: 'post',
                data: fd,
                cache:false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    let job_ref = $('#job_ref').val();
                    let name = $('#applicant_name').text();
                    if(data.status == 200){
                        const notify_Modal = tailwind.Modal.getInstance(document.querySelector("#notifyier_modal"));
                        notify_Modal.hide();

                        __notif_show( 1, name+"  is Notified");

                        fetching_finalListing(job_ref);
                    }
        
                }
            });
        }

    });
}
function fetched_rated_applicants(position_id, status_id){
    var rated_check_in_value;
    if($("#rated_check").is(":checked")) {

        rated_check_in_value = 1;
        
    } else {

        rated_check_in_value = 0;
    }
    
    $.ajax({
        url:  bpath + 'rating/fetched/rated-applicant/'+position_id+'/'+status_id,
        type: "get",
        data: {
            _token: _token, rated_check_in_value:rated_check_in_value,
        },
        success: function(data) {

            $('#ratedApplicant_div').html(data);
            $('#tbl_ratedApplicant').DataTable({
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

function fetch_Select_applicant(position_id){
    $.ajax({
        url:  bpath + 'rating/fetched/select-applicant/'+position_id,
        type: "get",
        data: {
            _token: _token,
        },
        success: function(data) {

            $('#select_Applicant_div').html(data);
            $('#select_Applicant_tbl').DataTable({
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

                            order: [0, 'desc']
            });

        }
    });
}

