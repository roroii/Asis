$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // ============== Begin : Load Active ============
    function load_active_scale() {
        $.ajax({
            url: '/student-evaluation/load_active_scale',
            method: 'GET',
            dataType: 'json',
            beforeSend: function() {
                $('#load_actived_scale').empty();
                $('#load_actived_scale').append('<tr><td colspan="3" style="background-color: aliceblue; text-align: center;">Loading <i class="fa-solid fa-spinner fa-spin"></i></td></tr>');
            },
            success: function(response) {
                $('#load_actived_scale').empty();
                if (response == 'empty') {
                    $('#load_actived_scale').append('\
                        <tr>\
                            <td colspan="3" style="text-align: center;">\
                                <div class="font-bold text-danger">No rating scale available yet</div>\
                            </td>\
                        </tr>');
                } else {
                    $.each(response, function(index, row){
                        $('#load_actived_scale').append('\
                            <tr>\
                                <td class="whitespace-nowrap text-center">'+ row.numerical +'</td>\
                                <td class="whitespace-nowrap text-center">'+ row.descriptive +'</td>\
                                <td class="whitespace-nowrap text-center">'+ row.qualitative +'</td>\
                            </tr>');
                    });
                }
            },
            error: function(err) {
                alert('Error occured: ' + err);
            }
        });

        $.ajax({
            url: '/student-evaluation/load_active_title',
            method: 'GET',
            dataType: 'json',
            beforeSend: function() {
                $('#ques_tab_content').empty();
                $('#ques_tab_content').append('<div class="text-center text-xl mt-4">Loading <i class="fa-solid fa-spinner fa-spin"></i></div>');
            },
            success: function(response) {
                $('#ques_tab_content').empty();
                if (response == 'empty' || response === null) {
                    $('#ques_tab_content').append('\
                    <div class="text-center mt-5" style="padding-top: 25px; padding-bottom: 25px;">\
                        <div class="text-success text-5xl"><i class="fa-solid fa-check-to-slot fa-beat"></i></div>\
                        <div class="mt-4 font-bold text-2xl">Congratulations!</div>\
                        <div class="mt-3">Your evaluation has already been successfully completed.</div>\
                    </div>');
                } else {
                    $('#ques_tab_content').append('\
                    <div class="mt-10 bg-warning/20 dark:bg-darkmode-600 border border-warning dark:border-0 rounded-md relative p-5">\
                        <i data-lucide="lightbulb" class="w-12 h-12 text-warning/80 absolute top-0 right-0 mt-5 mr-3"></i> \
                        <div class="mt-1 font-medium">Note</div>\
                        <div class="leading-relaxed text-xs mt-2 text-slate-600 dark:text-slate-500">\
                            <div>Complete this evaluation for each instructor before navigating the student portal.</div>\
                        </div>\
                    </div>\
                    <div class="question_names mt-5">\
                        <div class="flex items-end">\
                            <div class="font-bold w-1/4">Instructor:</div>\
                            <div class="select_ins w-3/4">\
                                <select id="stud_instructor" name="stud_instructor" required>\
                                    <option value=""></option>\
                                </select>\
                            </div>\
                        </div>\
                    </div>');

                    $.ajax({
                        url: '/student-evaluation/get_instructor',
                        method: 'GET',
                        dataType: 'json',
                        success: function(instruc) {
                            $('#stud_instructor').empty();
                            if (instruc == 'empty') {
                                $('#ques_tab_content').empty();
                                $('#ques_tab_content').append('\
                                <div class="text-center mt-5" style="padding-top: 25px; padding-bottom: 25px;">\
                                    <div class="text-success text-5xl"><i class="fa-solid fa-check-to-slot fa-beat"></i></div>\
                                    <div class="mt-4 font-bold text-2xl">Congratulations!</div>\
                                    <div class="mt-3">Your evaluation has already been successfully completed.</div>\
                                </div>');
                                $('#load_actived_scale').empty();
                                $('#load_actived_scale').append('\
                                <tr>\
                                    <td colspan="3" style="text-align: center;">\
                                        <div class="font-bold text-danger">No rating scale available yet</div>\
                                    </td>\
                                </tr>');
                            } else {
                                if (instruc == 'bypass') {
                                    $('#stud_instructor').append('<option value="" selected disabled>Select instructor</option>');
                                } else {
                                    $('#stud_instructor').append('<option value="" selected disabled>Select instructor</option>');
                                    $.each(instruc, function(index, rooow){
                                        $('#stud_instructor').append('<option value="'+ rooow.id +'">'+ rooow.fullname +'</option>');
                                    });
                                }

                                $('#ques_tab_content').append('\
                                <div id="title_tab_cont">\
                                    <div class="question_header text-center mt-10">\
                                        <div class="font-bold text-xl">'+ response.ques_title +'</div>\
                                        <div class="mt-1 text-slate-600">'+ response.ques_sub +'</div>\
                                    </div>\
                                    <div class="question_direction mt-10 flex">\
                                        <div class="mr-5 font-bold">Direction:</div>\
                                        <div class="ml-2">'+ response.ques_direction +'</div>\
                                    </div>\
                                </div>\
                                <div class="overflow-x-auto mt-10">\
                                    <table class="table table-bordered">\
                                        <thead>\
                                            <tr id="tr_for_title">\
                                            </tr>\
                                        </thead>\
                                        <tbody id="tbody__for_ques">\
                                        </tbody>\
                                    </table>\
                                </div>');

                                $.ajax({
                                    url: '/student-evaluation/load_desc_title',
                                    method: 'GET',
                                    dataType: 'json',
                                    success: function(desc) {
                                        $('#tr_for_title').empty();
                                        $('#tr_for_title').append('<th>Areas</th>');
                                        $.each(desc, function(index, row){
                                            $('#tr_for_title').append('<th class="text-center">'+ row.descriptive +'</th>');
                                        });

                                        $.ajax({
                                            url: '/student-evaluation/load_ques_body',
                                            method: 'GET',
                                            dataType: 'json',
                                            success: function(ques) {
                                                $('#tbody__for_ques').empty();
                                                var count = 1
                                                $.each(ques, function(index, row){
                                                    if (row.ques_type == 't') {
                                                        var rowString = '<tr><th>' + row.ques_ques + '</th>';
                                                        $.each(desc, function (index, rows) {
                                                            rowString += '<th></th>';
                                                        });
                                                        rowString += '</tr>';
                                        
                                                        $('#tbody__for_ques').append(rowString);
                                                    } else {
                                                        var rowString2 = '<tr><td>'+ row.ques_ques + '</td>';
                                                        $.each(desc, function (index, rows) {
                                                            rowString2 += '<td class="text-center"><input type="radio" required value="'+ rows.id +'" name="'+row.id+'" data-question-name="'+ row.id +'"></td>';
                                                        });
                                                        rowString2 += '</tr>';

                                                        $('#tbody__for_ques').append(rowString2);
                                                    }
                                                });
                                            }
                                        });
                                    }
                                });
                                
                                $('#ques_tab_content').append('\
                                <div class="mt-5">\
                                    <label for="remarks">Remarks:</label>\
                                    <textarea name="remarks" id="remarks" style="width: 100%; margin-top: 10px;" rows="5"></textarea>\
                                </div>');
                            
                                $('#ques_tab_content').append('\
                                <div class="flex justify-end" style="padding: 10px 40px; margin-bottom: 25px; margin-top: 20px;">\
                                    <button type="submit" id="submit_answerss" class="btn btn-primary" style="padding-left: 30px; padding-right: 30px;">Submit</button>\
                                </div>');
                            }
                        }
                    });

                }
            },
            error: function(err) {
                alert('Error occured on questionnaire.');
            }
        });
    }
    load_active_scale();

    $('#form_ques').submit(function (event) {
        event.preventDefault();

        var selectedInstructor = $('#stud_instructor').val().toString();
        var remarks = $('#remarks').val();

        var answers = [];
        $('#tbody__for_ques tr').each(function () {
            var input = $(this).find('input:checked');
            if (input.length > 0) {
                var selectedAnswer = input.val();
                var questionName = input.data('question-name');
                answers.push({ answerId: selectedAnswer, questionName: questionName });
            }
        });

        var formData = {
            instructorId: selectedInstructor,
            remarks: remarks,
            answers: answers
        };

        $.ajax({
            url: '/student-evaluation/save_evaluation',
            method: 'POST',
            dataType: 'json',
            data: formData,
            success: function (response) {
                if(response.message == 'success') {
                    load_active_scale();
                    __notif_show(1, "Success", "Successfully save credentials.");
                } else {
                    __notif_show(-2, "Failed", "Failed to save credentials.");
                }
            },
            error: function (error) {
                console.error('Error occurred:', error);
                alert('Error occurred: ' + error.statusText);
            }
        });
    });
    // ============== End : Load Active ============



    // ============== Begin : Rating Scale ============
    function loadscale() {
        $.ajax({
            url: '/student-evaluation/load_temp_scale',
            method: 'GET',
            dataType: 'json',
            beforeSend: function() {
                $('#modal_tbody_scale').empty();
                $('#modal_tbody_scale').append('\
                    <tr>\
                        <td colspan="4" style="background-color: aliceblue;" class="whitespace-nowrap text-center">Loading <i class="fa-solid fa-spinner fa-spin"></i></td>\
                    </tr>');
            },
            success: function(response) {
                $('#modal_tbody_scale').empty();
                if (response === null || response == '') {
                    $('#modal_tbody_scale').append('\
                        <tr>\
                            <td colspan="4" style="background-color: aliceblue;" class="whitespace-nowrap text-center">No data found</td>\
                        </tr>');
                } else {
                    $.each(response, function(index, row) {
                        $('#modal_tbody_scale').append('\
                            <tr>\
                                <td class="whitespace-nowrap text-center">' + row.numerical + '</td>\
                                <td class="whitespace-nowrap text-center">' + row.descriptive + '</td>\
                                <td class="whitespace-nowrap text-center">' + row.qualitative + '</td>\
                                <td><button data-id="'+ row.id +'" class="dlt_modal_scale"><i class="fa-solid fa-trash-can text-danger"></i></button></td>\
                            </tr>');
                    });
                    $('.dlt_modal_scale').click(function(){
                        var id = $(this).data('id');
                        $('#id_to_dlt').val(id);
                        const myModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#modal_dlt_scale"));
                        myModal.show();
                    });
                }
            }
        });
    }

    $('#create_scale_btn').click(function(){
        $('#modal_tbody_scale').empty();
        $('#scale_name_val').val('');
        loadscale();
    });

    $('#add_scale_rating_btn').click(function(){
        var numerical = $('#numerical_val').val();
        var descriptive = $('#descriptive_val').val();
        var qualitative = $('#qualitative_val').val();

        if (numerical.trim() == '' || descriptive.trim() == '' || qualitative.trim() == '') {
            __notif_show(-1, "Empty", "Please fill all entries");
        } else {
            $.ajax({
                url: '/student-evaluation/savascale',
                method: 'POST',
                dataType: 'json',
                data: {
                    numerical: numerical,
                    descriptive: descriptive,
                    qualitative: qualitative
                },
                success: function(response) {
                    if (response.msg == 'success') {
                        $('#numerical_val').val('');
                        $('#descriptive_val').val('');
                        $('#qualitative_val').val('');
                        __notif_show(1, "Success", "Successfully save credentials.");
                        loadscale();
                    } else {
                        __notif_show(-2, "Failed", "Failed to save credentials.");
                    }
                },  
                error: function(err) {
                    console.log('Error occurred: ' + err);
                }
            });
        }
    });

    $('#dlt_scale_btn').click(function(){
        var id = $('#id_to_dlt').val();
        const myModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#modal_dlt_scale"));

        $.ajax({
            url: '/student-evaluation/deletescale',
            method: 'POST',
            dataType: 'json',
            data: {id: id},
            success: function (response) {
                if (response.msg == 'success') {
                    myModal.hide();
                    __notif_show(1, "Success", "Successfully delete credentials.");
                    loadscale();
                } else {
                    __notif_show(-2, "Failed", "Failed to delete credentials.");
                }
            }
        });
    });
    
    $('#save_scale_btn').click(function(){
        var name = $('#scale_name_val').val();
        const myModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#modal_to_add_scale"));

        if (name.trim() == '') {
            __notif_show(-1, "Empty", "Please enter scale name");
        } else {
            $.ajax({
                url: '/student-evaluation/savescale',
                method: 'POST',
                dataType: 'json',
                data: {name: name},
                success: function(response) {
                    if (response.msg == 'success') {
                        myModal.hide();
                        loadscale_name();
                        __notif_show(1, "Success", "Successfully save rating scale.");
                    } else if (response.msg == 'exist') {
                        __notif_show(-1, "Existed", "Questionnaire name existed.");
                    } else {
                        __notif_show(-3, "Failed", "Failed to save credentials.");
                    }
                }
            });
        }
    });
    
    $('#clear_scale_btn').click(function(){
        const myModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#modal_sure_clear_scale"));

        $.ajax({
            url: '/student-evaluation/clear_temp_scale',
            method: 'GET',
            dataType: 'json',
            beforeSend: function() {
                $('#loading_scale').html('<i class="fa-solid fa-spinner fa-spin"></i>');
            },
            success: function(response) {
                $('#loading_scale').html('');
                if (response.msg == 'success'){
                    __notif_show(2, "Success", "Rating Scale cleared successfully.");
                    myModal.hide();
                    loadscale();
                } else {
                    myModal.hide();
                    __notif_show(-3, "Failed", "Failed to clear credentials.");
                }
            },
            error: function(err) {
                alert('Error Occurred: ' + err);
            }
        });
    });
    // ============== End : Rating Scale ============
    


    // ============== Begin : Questionnaire ============
    function loadques() {
        $('#tbody_for_ques').empty();
        $.ajax({
            url: '/student-evaluation/load_temp_ques',
            method: 'GET',
            dataType: 'json',
            beforeSend: function() {
                $('#tbody_for_ques').append('<tr><td style="background-color: aliceblue; text-align: center;">Loading <i class="fa-solid fa-spinner fa-spin"></i></td></tr>');
            },
            success: function(response) {
                $('#tbody_for_ques').empty();
                if (response == '' || response == null) {
                    $('#tbody_for_ques').append('<tr><td style="background-color: aliceblue; text-align: center;">Create questions above</td></tr>');
                } else {
                    var count = 1;
                    $.each(response, function(index, row) {
                        if (row.ques_type == 't') {
                            $('#tbody_for_ques').append('\
                            <tr>\
                                <th>'+ row.ques_ques +'</th>\
                                <th class="text-danger"><i data-id="'+ row.id +'" class="dlt_ques fa-regular fa-trash-can cursor-pointer"></i></th>\
                            </tr>');
                            count = 1;
                        } else {
                            $('#tbody_for_ques').append('\
                            <tr>\
                                <td>'+ count +'. '+ row.ques_ques +'</td>\
                                <td class="text-danger"><i data-id="'+ row.id +'" class="dlt_ques fa-regular fa-trash-can cursor-pointer"></i></td>\
                            </tr>');
                            count++;
                        }
                    });
                }
                $('#tbody_for_ques').on('click', '.dlt_ques', function() {
                    var id = $(this).data('id');
                    $('#dlt_this_ques').val(id);
                    const myModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#dlt_notif_ques"));
                    myModal.show();
                });
            },
            error: function(err) {
                alert('Error occurred');
            }
        });
    }
    
    $('#create_ques_btn').click(function(){
        loadques();
    }); 

    $('#add_ques_btn').click(function(){
        var type = $('#ques_type').val();
        var ques = $('#ques_ques').val();
        
        if (type == '' || type === null || ques.trim() == '') {
            __notif_show(-1, "Empty", "Please type and question");
        } else {
            $.ajax({
                url: '/student-evaluation/add_temp_ques',
                method: 'POST',
                dataType: 'json',
                data: {type: type, ques:ques},
                beforeSend: function() {
                    $('#loading_ques').html('<i class="fa-solid fa-spinner fa-spin"></i>');
                },
                success: function(response) {
                    $('#loading_ques').html('');
                    if (response.msg == 'success') {
                        $('#ques_type').val('');
                        $('#ques_ques').val('');
                        __notif_show(2, "Success", "Question added successfully.");
                        loadques();
                    } else {
                        __notif_show(-3, "Failed", "Failed to save credentials.");
                    }
                }, 
                error: function(err) {
                    alert('Error Occurred: ' + err);
                }
            });
        }
    });

    $('#clear_ques_btn').click(function(){
        const myModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#modal_sure_clear"));
        $.ajax({
            url: '/student-evaluation/clear_temp_ques',
            method: 'GET',
            dataType: 'json',
            beforeSend: function() {
                $('#loading_ques').html('<i class="fa-solid fa-spinner fa-spin"></i>');
            },
            success: function(response) {
                $('#loading_ques').html('');
                if (response.msg == 'success'){
                    $('#ques_type').val('');
                    $('#ques_ques').val('');
                    __notif_show(2, "Success", "Question cleared successfully.");
                    myModal.hide();
                    loadques();
                } else {
                    myModal.hide();
                    __notif_show(-3, "Failed", "Failed to save credentials.");
                }
            },
            error: function(err) {
                alert('Error Occurred: ' + err);
            }
        });
    });

    $('#save_ques_ques').click(function(){
        const myModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#modal_to_create_ques"));
        var name = $('#ques_name_val').val();
        var title = $('#ques_title_val').val();
        var sub = $('#ques_sub_val').val();
        var direction = $('#ques_direc_val').val();

        if(name == '' || title == '' || sub == '' || direction == '') {
            __notif_show(-1, "Empty", "Please fill all entries!");
        } else {
            $.ajax({
                url: '/student-evaluation/save_temp_ques',
                method: 'POST',
                dataType: 'json',
                data: {
                    name: name,
                    title: title,
                    sub: sub,
                    direction: direction
                },
                success: function(response) {
                    if(response.msg == 'empty') {
                        __notif_show(-1, "Empty", "Add some questions.");
                    } else if (response.msg == 'exist') {
                        __notif_show(-1, "Existed", "Questionnaire name existed.");
                    } else if (response.msg == 'success') {
                        myModal.hide();
                        __notif_show(1, "Successful", "Successfully save questionnaire.");
                    } else {
                        alert(response.msg);
                    }
                }
            });
        }
    });

    $('#dlt_btn_ques').click(function(){
        var id = $('#dlt_this_ques').val();
        const myModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#dlt_notif_ques"));

        $.ajax({
            url: '/student-evaluation/dlt_temp_ques',
            method: 'POST',
            dataType: 'json',
            data: {id: id},
            success: function(response) {
                if (response.msg == 'success') {
                    __notif_show(2, "Success", "Credentials deleted successfully.");
                    loadques();
                    myModal.hide();
                } else {
                    __notif_show(-3, "Failed", "Failed to delete credentials.");
                }
            },
            error: function(err) {
                alert('Error occured');
            }
        });
    });
    // ============== End : Questionnaire ============


    
    // ============== Begin : Change ============
    function loadscale_name() {
        $('#select_scale_name').empty();

        $.ajax({
            url: '/student-evaluation/getscalename',
            method: 'GET',
            dataType: 'json',
            beforeSend: function() {
                $('#select_scale_name').append('<option value="" selected disabled>Loading ...</option>');
            },
            success: function(response) {
                $('#select_scale_name').empty();
                $('#select_scale_name').append('<option value="" selected disabled>Please select</option>');
                $.each(response, function(index, row) {
                    $('#select_scale_name').append('<option>'+ row.scale_name +'</option>');
                });
            },
            error: function(err) {
                alert('Error occured: ' + err);
            }
        });
    }

    function loadques_name() {
        $('#select_ques_name').empty();

        $.ajax({
            url: '/student-evaluation/getquesname',
            method: 'GET',
            dataType: 'json',
            beforeSend: function() {
                $('#select_ques_name').append('<option value="" selected disabled>Loading ...</option>');
            },
            success: function(response) {
                $('#select_ques_name').empty();
                $('#select_ques_name').append('<option value="" selected disabled>Please select</option>');
                $.each(response, function(index, row) {
                    $('#select_ques_name').append('<option value="'+ row.id +'">'+ row.ques_name +'</option>');
                });
            },
            error: function(err) {
                alert('Error occured: ' + err);
            }
        });
    }

    $('#modal_to_change_ques_id').click(function(){
        loadques_name();
        loadscale_name();

        $.ajax({
            url: '/student-evaluation/get_active_data',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#select_ques_name').val(response.questions);
                $('#select_scale_name').val(response.rating_scale);
                $('#ques_date_from').val(response.date_from);
                $('#ques_date_to').val(response.date_to);
                $('#sy_select').val(response.sy);
                $('#sem_select').val(response.sem);
            }
        });
    });
   
    $('#change_ques_btn_change').click(function(){
        var ques = $('#select_ques_name').val();
        var scale = $('#select_scale_name').val();
        var from = $('#ques_date_from').val();
        var to = $('#ques_date_to').val();
        var sy = $('#sy_select').val();
        var sem = $('#sem_select').val();
        const myModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#modal_to_change_ques"));

        if (ques == '' || ques == null || scale == '' || scale == null || from == '' || to == '' || sy == '' || sy == null || sem == '' || sem == null) {
            __notif_show(-1, "Empty", "Please fill all entries.");
        } else if (from > to) {
            __notif_show(-3, "Error", "Date inputed are invalid");
        } else {
            $.ajax({
                url: '/student-evaluation/change_active_ques',
                method: 'POST',
                dataType: 'json',
                data: {ques: ques, from: from, to: to, scale: scale, sy: sy, sem: sem},
                success: function(response) {
                    if(response.msg == 'success'){
                        myModal.hide();
                        load_active_scale();
                        __notif_show(2, "Success", "Successfully change the credentials.");
                    } else {
                        __notif_show(-3, "Failed", "Failed to change credentials.");
                    }
                }
            });
        }
    });
    // ============== End : Change ============
});