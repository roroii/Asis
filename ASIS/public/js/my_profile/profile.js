var  _token = $('meta[name="csrf-token"]').attr('content');
var bpath = window.location.origin;
var tbl_data_educational_bg;
var tbl_data_name_child;

var citizenship_value = '';
var citizenship_type_value = '';

var cb_34_a = 0;
var cb_34_b = 0;

var cb_35_a = 0;
var cb_35_b = 0;

var cb_36 = 0;
var cb_37 = 0;

var cb_38_a = 0;
var cb_38_b = 0;

var cb_39 = 0;

var cb_40_a = 0;
var cb_40_b = 0;
var cb_40_c = 0;

$(document).ready(function (){

    bpath = __basepath + "/";
    load_data_table();
    load_profile_picture();
    load_personal_information();
    personal_information();
    load_select2_input_fields();
    lite_picker_instance();

    my_address();
    get_family_bg();
    family_background();
    educational_background();
    child_list();
    civil_service();
    work_experience();
    voluntary_work_involvement();
    learning_development();
    special_skills();
    others();

    references();

    save_all_pds_data();
    save_profile_picture();

    toggle_add_signature_mdl();
    save_e_signature(_token);
    load_uploaded_signature(_token);
    delete_uploaded_e_signature(_token);
    download_e_signature(_token);

    load_government_ID();

    bind_address();

    same_address();

    profile_tab_event_handler();

    save_account_settings();
    toggle_show_password();

});

function toggle_show_password(){

    let input_password = document.getElementById("account_password");

    $('#btn_show_pass').change(function() {
        if ($(this).is(':checked')) {

            input_password.type = "text";

        }else
        {
            input_password.type = "password";
        }
    });

}

function save_account_settings(){

    let pass_length = 0;

    $('#account_password').on('keyup', function() {
        pass_length = this.value.length;

        $('#account_password').removeClass('border-danger');
    });


    $('#account_email').on('keydown', function() {
        pass_length = this.value.length;

        $('#account_email').removeClass('border-danger');
    });


    $('body').on('click', '#btn_save_account_settings', function (){

        let password = $('#account_password').val();

        if(pass_length >= 8)
        {
            $.ajax({
                url: bpath + 'my/save/account/settings',
                type: "POST",
                data: {_token, password},
                success: function (response) {
                    if(response)
                    {
                        let data = JSON.parse(response);
                        let status = data['status'];

                        if(status == 200)
                        {
                            load_personal_information();
                            __notif_show(1, 'Success', 'Password updated successfully!');
                        }
                    }
                }
            });
        }else
        {
            $('#account_password').addClass('border-danger');
            __notif_show(-1, 'Warning', 'Password too short!');
        }
    });

}

function profile_tab_event_handler(){

    $('body').on('click', '#e_signature_tab', function (){

        $('.btn_save_PDS_div').hide();

    });

    $('body').on('click', '#profile-tab', function (){

        $('.btn_save_PDS_div').show();

    });

    $('body').on('click', '#account-tab', function (){

        $('.btn_save_PDS_div').hide();

    });

}

function load_data_table(){

    try{
        /***/
        tbl_data_educational_bg = $('#dt__educational_bg').DataTable({
            dom:

                "<<'intro-y col-span-12'tr>>" +
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

            columnDefs:
                [
                    { className: "dt-head-center", targets: [ 7 ] },
                ],
        });

        tbl_data_name_child = $('#dt__name_of_children').DataTable({
            dom:

                "<<'intro-y col-span-12'tr>>" +
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

            columnDefs:
                [
                    { className: "dt-head-center", targets: [ 2 ] },
                ],
        });

        /***/
    }catch(err){  }

}

function lite_picker_instance(){

    const calendar_date = new Date();
    let this_year = calendar_date.getFullYear();

    // let my_calendar = new Litepicker({
    //     element: document.getElementById('profile_date_birth'),
    //     autoApply: false,
    //     singleMode: true,
    //     numberOfColumns: 1,
    //     numberOfMonths: 1,
    //     showWeekNumbers: false,
    //     startDate: new Date(),
    //     format: "YYYY-MM-DD",
    //     allowRepick: true,
    //     dropdowns: {
    //         minYear: 1950,
    //         maxYear: null,
    //         months: true,
    //         years: true
    //     },
    //     setup: (picker) => {
    //         picker.on('button:apply', (date1) => {
    //             let get_date_instance = date1.dateInstance;
    //
    //             let to_string = get_date_instance.toString();
    //             let split = to_string.split(" ");
    //             let get_birth_year = split[3];
    //
    //             let age = this_year-get_birth_year;
    //
    //             $('#profile_age').val(age);
    //
    //         });
    //     },
    // });

    lite_picker('educ_school_from',   'MM/DD/YYYY');
    lite_picker('educ_school_to',     'MM/DD/YYYY');
    // lite_picker('educ_year_graduated','MM/DD/YYYY');

    // lite_picker('cs_date_validity',   'MM/DD/YYYY', "2090");
    lite_picker('cs_date_exam',       'MM/DD/YYYY');

    lite_picker('work_exp_date_from', 'MM/DD/YYYY');
    lite_picker('work_exp_date_to',   'MM/DD/YYYY');

    lite_picker('vol_work_date_from', 'MM/DD/YYYY');
    lite_picker('vol_work_date_to',   'MM/DD/YYYY');

    lite_picker('ld_date_from',       'MM/DD/YYYY');
    lite_picker('ld_date_to',         'MM/DD/YYYY');

}

function lite_picker(element_id, format, maxYear ){
    new Litepicker({
        element: document.getElementById(element_id),
        autoApply: false,
        singleMode: true,
        numberOfColumns: 1,
        numberOfMonths: 1,
        showWeekNumbers: false,
        startDate: new Date(),
        format: format,
        allowRepick: true,
        dropdowns: {
            minYear: 1950,
            maxYear: maxYear,
            months: true,
            years: true
        }
    });
}

function load_select2_input_fields(){

    $('#family_bg_type').select2({
        closeOnSelect: true,
    });

    $('#government_ids').select2({
        placeholder: "Select Government Issued ID's",
        closeOnSelect: true,
    });

    $('#ld_type').select2({
        closeOnSelect: true,
    });

    $('#work_exp_govt_service').select2({
        closeOnSelect: true,
    });

    $('#cs_type').select2({
        closeOnSelect: true,
    });

    $('#educ_bg_level').select2({
        placeholder: "Select Level",
        closeOnSelect: true,
    });

    $('#application_gender').select2({
        placeholder: "Select Gender",
        closeOnSelect: true,
    });

    $('#profile_civil_status').select2({
        placeholder: "Select Civil Status",
        closeOnSelect: true,
    });

    $('#profile_country').select2({
        placeholder: "Select Country",
        closeOnSelect: true,
    });

    $('#others_39_yes').select2({
        placeholder: "Select Country",
        closeOnSelect: true,
    });

    $('#profile_region').select2({
        placeholder: "Select Region",
        closeOnSelect: true,
    });

    $('.ref_province').select2({
        placeholder: "Select Province",
        closeOnSelect: true,
    });

    $('.ref_city_mun').select2({
        placeholder: "Select Municipality",
        closeOnSelect: true,
    });

    $('.ref_brgy').select2({
        placeholder: "Select Barangay",
        closeOnSelect: true,
    });


    $('.per_province').select2({
        placeholder: "Select Province",
        closeOnSelect: true,
    });

    $('.per_city_mun').select2({
        placeholder: "Select Municipality",
        closeOnSelect: true,
    });

    $('.per_brgy').select2({
        placeholder: "Select Barangay",
        closeOnSelect: true,
    });


    $('#application_pos').select2({
        placeholder: "Select Position(s)",
        closeOnSelect: true,
    });

    $("#profile_municipality").prop("disabled", true);
    $("#profile_brgy").prop("disabled", true);

}

function load_profile_picture() {

    $.ajax({
        url: bpath + 'my/load/profile',
        type: "POST",
        data: { _token, },
        success: function(response) {

            if(response)
            {
                var data = JSON.parse(response);

                let profile_pic = data['profile_pic'];
                let raw_image   = data['raw_image'];
                let email       = data['email'];
                let password    = data['password'];
                let full_name   = data['full_name'];
                let contact_number   = data['contact_number'];

                let profile_firstname = data['profile_firstname'];
                let profile_midname = data['profile_midname'];
                let profile_lastname = data['profile_lastname'];
                let profile_ext = data['profile_ext'];

                let html_data_1 =
                    '<div class="sm:whitespace-normal font-medium text-lg">'+full_name+'</div>';

                $('#profile_name').html(html_data_1);

                let html_data_2 = '<img id="profile_picture_holder" data-action="zoom" class="rounded-full" alt="Relax" src="'+profile_pic+'">';
                    // '<a id="btn_update_profile_picture" href="javascript:;" data-pos="'+email+'" data-profile="'+profile_pic+'" data-fullname="'+full_name+'" class="absolute mb-1 mr-1 flex items-center justify-center bottom-0 right-0 bg-primary rounded-full p-2"> <i class="fa-solid fa-camera w-4 h-4 text-white"></i> </a>';

                $('#profile_pic_div').html(html_data_2);

                $('#current_profile_picture_value').val(raw_image);

                $('.profile_student_email').text(email);
                $('.profile_student_contact').text(contact_number);


                $('#account_email').val(email);
                $('#account_password').val(password);

                $('.profile_firstname').val(profile_firstname);
                $('.profile_midname').val(profile_midname);
                $('.profile_lastname').val(profile_lastname);
                $('.profile_ext').val(profile_ext);
            }
        }
    });

}

// BEGIN  I. PERSONAL INFORMATION

    function load_personal_information(){

        $.ajax({
            url: bpath + 'my/load/profile',
            type: "POST",
            data: { _token, },
            success: function(response) {

                var data = JSON.parse(response);

                if(data.length > 0) {
                    for (var i = 0; i < data.length; i++) {

                        let last_name = data[i]['last_name'];
                        let first_name = data[i]['first_name'];
                        let mid_name = data[i]['mid_name'];
                        let ext = data[i]['name_ext'];
                        let name_ext = '';

                        if(ext == '' || ext == null)
                        {
                            name_ext = '';
                        }else
                        {
                            name_ext = data[i]['name_ext'];
                        }

                        let position = data[i]['position'];
                        let profile_pic = data[i]['profile_pic'];

                        let dateofbirth = data[i]['dateofbirth'];
                        let placeofbirth = data[i]['placeofbirth'];
                        let sex = data[i]['sex'];
                        let citizenship = data[i]['citizenship'];
                        let dual_citizenship_type = data[i]['dual_citizenship_type'];
                        let dual_citizenship_country = data[i]['dual_citizenship_country'];

                        let civilstatus = data[i]['civilstatus'];
                        let height = data[i]['height'];
                        let weight = data[i]['weight'];
                        let bloodtype = data[i]['bloodtype'];
                        let gsis = data[i]['gsis'];
                        let pagibig = data[i]['pagibig'];
                        let philhealth = data[i]['philhealth'];
                        let tin = data[i]['tin'];
                        let govissueid = data[i]['govissueid'];
                        let telephone = data[i]['telephone'];
                        let mobile_number = data[i]['mobile_number'];
                        let email = data[i]['email'];
                        let username = data[i]['username'];
                        let password = data[i]['password'];


                        let full_name = first_name+" "+last_name;

                        let html_data_1 = '<div class="sm:whitespace-normal font-medium text-lg">'+first_name+" "+mid_name+" "+last_name+" "+name_ext+'</div>'+
                                          '<div class="text-slate-500">'+email+'</div>';

                        let html_data_2 = '<img id="profile_picture_holder" class="rounded-full" alt="Relax" src="'+profile_pic+'">'+
                            '<a id="btn_update_profile_picture" href="javascript:;" data-pos="'+position+'" data-profile="'+profile_pic+'" data-fullname="'+full_name+'" class="absolute mb-1 mr-1 flex items-center justify-center bottom-0 right-0 bg-primary rounded-full p-2"> <i class="fa-solid fa-camera w-4 h-4 text-white"></i> </a>';

                        $('#profile_name').html(html_data_1);
                        $('#profile_pic_div').html(html_data_2);

                        $('#account_email').val(username);
                        $('#account_password').val(password);

                        $('#profile_last_name').val(last_name);
                        $('#profile_first_name').val(first_name);
                        $('#profile_mid_name').val(mid_name);
                        $('#profile_name_extension').val(name_ext);

                        $('#profile_date_birth').val(dateofbirth);
                        $('#profile_place_birth').val(placeofbirth);




                        if (sex)
                        {
                            $('#application_gender').val(sex);
                            $('#application_gender').select2({
                                placeholder: sex,
                                closeOnSelect: true,
                            });
                        }else
                        {
                            $('#application_gender').select2({
                                placeholder: 'Select Gender',
                                closeOnSelect: true,
                            });
                        }

                        if (citizenship == "Filipino") {
                            $('#citizen_filipino').prop('checked', true);
                            $('#citizen_dual').prop('checked', false);
                            $('#citizenship_country').val("");
                            $('#if_dual_citizen').hide();
                            citizenship_value = 'Filipino';


                        }
                        else if (citizenship == "DUAL_CITIZENSHIP") {
                            $('#citizen_filipino').prop('checked', false);
                            $('#citizen_dual').prop('checked', true);
                            $('#citizenship_country').val(dual_citizenship_country);
                            $('#if_dual_citizen').show();
                            $('#citizenship_country').select2({
                                placeholder: dual_citizenship_country,
                                closeOnSelect: true,
                            });
                            citizenship_value = 'DUAL_CITIZENSHIP';

                        }

                        if(dual_citizenship_type == "BY_BIRTH") {
                            $('#by_birth').prop('checked', true);
                            $('#by_naturalization').prop('checked', false);
                            citizenship_type_value = 'BY_BIRTH';

                        }
                        else if(dual_citizenship_type == "BY_NATURALIZATION") {

                            $('#by_birth').prop('checked', false);
                            $('#by_naturalization').prop('checked', true);
                            citizenship_type_value = 'BY_NATURALIZATION';
                        }

                        if(civilstatus) {
                            $('#profile_civil_status').val(civilstatus);
                            $('#profile_civil_status').select2({
                                placeholder: civilstatus,
                                closeOnSelect: true,
                            });
                        }
                        else{
                            $('#profile_civil_status').select2({
                                placeholder: "Select Civil Status",
                                closeOnSelect: true,
                            });
                        }



                        $('#profile_height').val(height);
                        $('#profile_weight').val(weight);
                        $('#profile_blood_type').val(bloodtype);
                        $('#profile_gsis').val(gsis);
                        $('#profile_pagibig').val(pagibig);
                        $('#profile_philhealth').val(philhealth);
                        $('#profile_tin').val(tin);
                        $('#profile_agency').val(govissueid);
                        $('#profile_tel_number').val(telephone);
                        $('#profile_mobile_number').val(mobile_number);
                        $('#profile_email').val(email);
                    }
                }
            }
        });

    }
    function personal_information(){

        $('#citizen_filipino').change(function() {
            if ($(this).is(':checked')) {

                $('#if_dual_citizen').hide();
                $("#by_birth").prop("checked", false);
                $("#by_naturalization").prop("checked", false);
                $('#citizenship_country').val("");

                citizenship_value = "Filipino";
                citizenship_type_value = "";
            } else {
                $('#if_dual_citizen').show();
                citizenship_value = "DUAL_CITIZENSHIP";
            }
        });

        $('#citizen_dual').change(function() {
            if ($(this).is(':checked')) {

                $('#if_dual_citizen').show();
                $("#by_birth").prop("checked", false);
                $("#by_naturalization").prop("checked", false);

                $('#citizenship_country').select2({
                    placeholder: "Select Country",
                    closeOnSelect: true,
                });

                citizenship_value = "DUAL_CITIZENSHIP";
            } else {
                $('#if_dual_citizen').hide();
                citizenship_value = "Filipino";
            }
        });

        $('#by_birth').change(function() {
            if ($(this).is(':checked')) {

                $("#by_naturalization").prop("checked", false);

                citizenship_type_value = "BY_BIRTH";
            } else {

                citizenship_type_value = "BY_NATURALIZATION";
            }
        });

        $('#by_naturalization').change(function() {
            if ($(this).is(':checked')) {

                $("#by_birth").prop("checked", false);

                citizenship_type_value = "BY_NATURALIZATION";
            } else {

                citizenship_type_value = "BY_BIRTH";
            }
        });

    }

    // BEGIN  ADDRESS
        function my_address(){

            load_residential_address();
            load_permanent_address();
        }
        function load_residential_address(){
            $.ajax({
                url: bpath + 'my/load/residential/address',
                type: "POST",
                data: { _token },
                success: function (response) {

                    var data = JSON.parse(response);

                    if(data.length > 0) {
                        for (var i = 0; i < data.length; i++) {

                            /***/

                            let id = data[i]['id'];
                            let address_type = data[i]['address_type'];
                            let house_block_no = data[i]['house_block_no'];
                            let street = data[i]['street'];
                            let subdivision_village = data[i]['subdivision_village'];

                            let res_brgy_code = data[i]['brgy_code'];
                            let res_brgy = data[i]['brgy'];

                            let res_municipality_code = data[i]['municipality_code'];
                            let res_municipality = data[i]['municipality'];

                            let res_province_code = data[i]['province_code'];
                            let res_province = data[i]['province'];

                            let zip_code = data[i]['zip_code'];

                            $('#res_house_block').val(house_block_no);
                            $('#res_street').val(street);
                            $('#res_sub').val(subdivision_village);
                            $('#res_zip_code').val(zip_code);

                            populate_residential_address(res_province,res_province_code, res_municipality_code,res_municipality, res_brgy_code,res_brgy);

                            /***/
                        }
                    }
                }
            });
        }
        function load_permanent_address(){
            $.ajax({
                url: bpath + 'my/load/permanent/address',
                type: "POST",
                data: { _token },
                success: function (response) {

                    var data = JSON.parse(response);

                    if(data.length > 0) {
                        for (var i = 0; i < data.length; i++) {

                            /***/

                            let id = data[i]['id'];
                            let address_type = data[i]['address_type'];
                            let house_block_no = data[i]['house_block_no'];
                            let street = data[i]['street'];
                            let subdivision_village = data[i]['subdivision_village'];


                            let per_brgy_code = data[i]['per_brgy_code'];
                            let per_brgy = data[i]['per_brgy'];

                            let per_city_mun_code = data[i]['per_municipality_code'];
                            let per_city_mun = data[i]['per_municipality'];

                            let per_province_code = data[i]['per_province_code'];
                            let per_province = data[i]['per_province'];

                            let zip_code = data[i]['zip_code'];

                            $('#per_house_block').val(house_block_no);
                            $('#per_street').val(street);
                            $('#per_sub').val(subdivision_village);

                            $('#per_zip_code').val(zip_code);

                            populate_permanent_address(per_province_code,per_province, per_city_mun_code,per_city_mun, per_brgy_code,per_brgy);

                            /***/
                        }
                    }
                }
            });
}
    // END ADDRESS

// END  I. PERSONAL INFORMATION

$("body").on('click', '#btn_update_profile_picture', function (){

    const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#update_profile_picture_mdl'));
    mdl.toggle();

    // let full_name = $(this).data('fullname');
    // let position = $(this).data('pos');
    // let profile_pic = $(this).data('profile');
    //
    //
    // let html_data = '<img id="profile_picture_holder" alt="Profile Picture" class="rounded-md" src="'+profile_pic+'">' +
    //                 '<span class="absolute top-0 bg-pending/80 text-white text-xs m-5 px-2 py-1 rounded z-10">Featured</span>'+
    //                 '<div class="absolute bottom-0 text-white px-5 pb-6 z-10">' +
    //                     '<a href="" class="block font-medium text-base">'+full_name+'</a>' +
    //                     '<span class="text-white/90 text-xs mt-3">'+position+'</span>'+
    //                 '</div>';
    //
    // $('#update_profile_holder').html(html_data);


});

// $("body").on('click', '#btn_delete_educ_bg', function (){
//
//     let applicant_id = $(this).data('user-id');
//     let academic_bg_id = $(this).data('academic-id');
//
//     $.ajax({
//         url: bpath + 'my/remove/educational/background',
//         type: "POST",
//         data: {
//             _token,
//             applicant_id,
//             academic_bg_id,
//         },
//         success: function (response) {
//
//             if(response.status == 200)
//             {
//                 __notif_show(1, "Successful", "Deleted successfully!");
//                 load_educational_bg();
//             }
//         }
//     });
//
// });

$('#table_name_of_child tbody').on('click','.delete',function(){
    $(this).parent().parent().remove();
});

function family_background(){

    $("body").on('click', '#add_family_bg', function (){
        const child_mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#add_family_bg_mdl'));
        child_mdl.toggle();
    });

    $('#spouse_tab').show();
    $('#father_tab').hide();
    $('#mother_tab').hide();

    let add_button_value = 'Spouse';

    let family_type = '';
    const family_bg_type = $("#family_bg_type");

    family_bg_type.on("select2:select", function (e) {
        family_type = family_bg_type.val();

        if (family_type == "Spouse")
        {
            $('#spouse_tab').show();
            $('#father_tab').hide();
            $('#mother_tab').hide();
            add_button_value = 'Spouse';

        }else if (family_type == "Father")
        {
            $('#spouse_tab').hide();
            $('#father_tab').show();
            $('#mother_tab').hide();
            add_button_value = 'Father';

        }else if (family_type == "Mother")
        {
            $('#spouse_tab').hide();
            $('#father_tab').hide();
            $('#mother_tab').show();
            add_button_value = 'Mother';

        }
    });
}
function get_family_bg() {

    $.ajax({
        url: bpath + 'my/load/family/background',
        type: "POST",
        data: { _token },
        success: function (response) {

            var data = JSON.parse(response);

            let spouse_surname = data['spouse_surname'];
            let spouse_firstname = data['spouse_firstname'];
            let spouse_name_ext = data['spouse_ext'];
            let spouse_mid_name = data['spouse_mi'];

            let fam_father_surname = data['father_surname'];
            let fam_father_first_name = data['father_firstname'];
            let fam_father_name_ext = data['father_ext'];
            let fam_father_mid_name = data['father_mi'];

            let fam_mother_maiden_name = data['mother_maidenname'];
            let fam_mother_surname = data['mother_surname'];
            let fam_mother_first_name = data['mother_firstname'];
            let fam_mother_mid_name = data['mother_mi'];

            let spouse_occupation = data['occupation'];
            let occupation_employer = data['employer_name'];
            let occupation_address = data['business_address'];
            let occupation_tel_no = data['tel_no'];

            let child_list_tr = data['child_list_tr'];

            $('#fam_spouse_surname').val(spouse_surname);
            $('#fam_spouse_first_name').val(spouse_firstname);
            $('#fam_spouse_name_ext').val(spouse_name_ext);
            $('#fam_spouse_mid_name').val(spouse_mid_name);

            $('#fam_father_surname').val(fam_father_surname);
            $('#fam_father_first_name').val(fam_father_first_name);
            $('#fam_father_name_ext').val(fam_father_name_ext);
            $('#fam_father_mid_name').val(fam_father_mid_name);

            $('#spouse_occupation').val(spouse_occupation);
            $('#occupation_employer').val(occupation_employer);
            $('#occupation_address').val(occupation_address);
            $('#occupation_tel_no').val(occupation_tel_no);

            $('#fam_mother_maiden_name').val(fam_mother_maiden_name);
            $('#fam_mother_surname').val(fam_mother_surname);
            $('#fam_mother_first_name').val(fam_mother_first_name);
            $('#fam_mother_mid_name').val(fam_mother_mid_name);


            $('#table_name_of_child tbody').append(child_list_tr);
        }
    });
}
function child_list(){

    $("body").on('click', '#add_child_list', function (){

        add_row_child_list();

    });

    function add_row_child_list(){

        var tr='<tr class="hover:bg-gray-200">'+
            '<td > <input id="td_input_child_name" name="td_input_child_name[]" type="text" style="text-transform:uppercase" class="form-control" placeholder="Name of Children"></td>'+
            '<td > <input id="td_input_child_bdate" name="td_input_child_bdate[]" type="date" class="form-control pl-12 "></td>'+
            '<td><a href="javascript:void(0);" class="flex items-center justify-center text-theme-6 delete"><i  class="w-4 h-4 mr-1 text-danger fa-solid fa-trash">Remove</i></a></td>'+
            '</tr>';

        $('#table_name_of_child tbody').append(tr);
    };

    $('#table_name_of_child tbody').on('click','.delete',function(){

        $(this).parent().parent().remove();
    });

    $('body').on('click', '.delete_child_list_from_db', function (){

        let child_list_id = $(this).data('list-id');
        $(this).parent().parent().remove();

        $.ajax({
            url: bpath + 'my/remove/child/family/background',
            type: "POST",
            data: { _token,child_list_id },
            success: function (response) {
                __notif_show(1, 'Success', 'Child removed successfully!');
            }
        });

    });
}

//  III. BEGIN EDUCATIONAL BACKGROUND
function load_educational_bg(){

    $('#update_educ_bg').hide();
    $('#add_educ_bg').show();

    $.ajax({
        url: bpath + 'my/load/educational/background',
        type: "POST",
        data: {_token},
        success: function (response) {
            var data = JSON.parse(response);

            let educational_list = data['educational_list'];

            $('#dt__educational_bg_new tbody').append(educational_list);

        }
    });

}
function educational_background(){

    load_educational_bg();

    $('#educ_bg_level').on('select2:select', function (e) {
        // Do something
        $('#educ_bg_level').select2({
            theme: "default"
        });
    });

    $("body").on('click', '#btn_toggle_add_educ_bg_modal', function (){

        const educ_mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#add_educ_bg_mdl'));
        educ_mdl.toggle();

        clear_educ_bg_inputs();

        $('#update_educ_bg').hide();
        $('#add_educ_bg').show();

    });

    $('#educ_school_name').on('keydown', function() {

        $('#educ_school_name').removeClass('border-danger');
    });

    $('#educ_year_graduated').on('keydown', function() {

        $('#educ_year_graduated').removeClass('border-danger');
    });

    $('#educ_degree_course').on('keydown', function() {

        $('#educ_degree_course').removeClass('border-danger');
    });

    $('#educ_highest_level_earned').on('keydown', function() {

        $('#educ_highest_level_earned').removeClass('border-danger');
    });

    $('#educ_scholarship').on('keydown', function() {

        $('#educ_scholarship').removeClass('border-danger');
    });

    // $("body").on('click', '#add_educ_bg', function (){
    //
    //
    //     if ($('#educ_bg_level').val() == null)
    //     {
    //         $('#educ_bg_level').select2({
    //             theme: "error",
    //             placeholder: "Academic Level is required",
    //         });
    //     }else if($('#educ_school_name').val() == null || $('#educ_school_name').val() == '' )
    //     {
    //         $('#educ_school_name').addClass('border-danger');
    //
    //     }else if($('#educ_degree_course').val() == null || $('#educ_degree_course').val() == '' )
    //     {
    //         $('#educ_degree_course').addClass('border-danger');
    //
    //     }else if($('#educ_highest_level_earned').val() == null || $('#educ_highest_level_earned').val() == '' )
    //     {
    //         $('#educ_highest_level_earned').addClass('border-danger');
    //
    //     }else if($('#educ_year_graduated').val() == null || $('#educ_year_graduated').val() == '' )
    //     {
    //         $('#educ_year_graduated').addClass('border-danger');
    //
    //     }else if($('#educ_scholarship').val() == null || $('#educ_scholarship').val() == '' )
    //     {
    //         $('#educ_scholarship').addClass('border-danger');
    //
    //     }else
    //     {
    //         add_row_educ_bg();
    //         $('#educ_year_graduated').removeClass('border-danger');
    //         $('#educ_school_name').removeClass('border-danger');
    //         $('#educ_degree_course').removeClass('border-danger');
    //         $('#educ_highest_level_earned').removeClass('border-danger');
    //         $('#educ_scholarship').removeClass('border-danger');
    //         $('#educ_school_name').val("");
    //         $('#educ_degree_course').val("");
    //         $('#educ_highest_level_earned').val("");
    //         $('#educ_scholarship').val("");
    //     }
    //
    // });

    // function add_row_educ_bg(){
    //
    //     var tr='<tr class="hover:bg-gray-200">'+
    //         '<td style="text-transform:uppercase"><input type="text" style="display: none; " name="td_educ_bg_level[]" class="form-control" value="'+$('#educ_bg_level option:selected').text()+'">'+$('#educ_bg_level option:selected').text()+'</td>'+
    //         '<td style="text-transform:uppercase"><input type="text" style="display: none; text-transform:uppercase" name="td_educ_school_name[]" class="form-control flex text-center" value="'+$('#educ_school_name').val()+'">'+$('#educ_school_name').val()+'</td>'+
    //         '<td style="text-transform:uppercase"><input type="text" style="display: none" name="td_educ_degree_course[]" class="form-control flextext-center" value="'+$('#educ_degree_course').val()+'">'+$('#educ_degree_course').val()+'</td>'+
    //         '<td style="text-transform:uppercase"><input type="text" style="display: none" name="td_educ_school_from[]" class="form-control flex text-center" value="'+$('#educ_school_from').val()+'">'+$('#educ_school_from').val()+'</td>'+
    //         '<td style="text-transform:uppercase"><input type="text" style="display: none" name="td_educ_school_to[]" class="form-control flex text-center" value="'+$('#educ_school_to').val()+'">'+$('#educ_school_to').val()+'</td>'+
    //         '<td style="text-transform:uppercase"><input type="text" style="display: none" name="td_educ_highest_level_earned[]" class="form-control flex text-center" value="'+$('#educ_highest_level_earned').val()+'">'+$('#educ_highest_level_earned').val()+'</td>'+
    //         '<td style="text-transform:uppercase"><input type="text" style="display: none" name="td_educ_educ_year_graduated[]" class="form-control flex text-center" value="'+$('#educ_year_graduated').val()+'">'+$('#educ_year_graduated').val()+'</td>'+
    //         '<td style="text-transform:uppercase"><input type="text" style="display: none" name="td_educ_scholarship[]" class="form-control flex text-center" value="'+$('#educ_scholarship').val()+'">'+$('#educ_scholarship').val()+'</td>'+
    //         '<td>' +
    //             '<div class="flex justify-center items-center">' +
    //                 '<a href="javascript:void(0);" class="delete text-center"><i  class="w-4 h-4 text-danger fa-solid fa-trash"></i></a>' +
    //             '</div>'+
    //         '</td>'+
    //         '</tr>';
    //
    //     $('#dt__educational_bg_new tbody').append(tr);
    //
    //     // '<a id="btn_edit_academic" href="javascript:void(0);" class=" text-center"> <i  class="w-4 h-4 mr-4 fa-regular fa-pen-to-square">Edit</i></a>' +
    // };

    $('#dt__educational_bg_new tbody').on('click','.delete',function(){
        $(this).parent().parent().parent().remove();
    });

    $("body").on('click', '.edit_saved_educ_bg', function (){

        const educ_mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#add_educ_bg_mdl'));
        educ_mdl.toggle();

        let acad_id = $(this).data('acad-id');
        let acad_level = $(this).data('acad-level');
        let acad_name = $(this).data('acad-name');
        let acad_course = $(this).data('acad-course');
        let acad_from = $(this).data('acad-from');
        let acad_to = $(this).data('acad-to');
        let acad_earned = $(this).data('acad-earned');
        let acad_graduated = $(this).data('acad-graduated');
        let acad_honors = $(this).data('acad-honors');

        $('#educ_bg_level').val(acad_level);

        $('#acad_level').val(acad_level);

        $('#educ_bg_level').select2({
            placeholder: acad_level
        });

        $('#acad_id').val(acad_id);
        $('#educ_school_name').val(acad_name);
        $('#educ_degree_course').val(acad_course);
        $('#educ_highest_level_earned').val(acad_earned);
        $('#educ_scholarship').val(acad_honors);

        $('#update_educ_bg').show();
        $('#add_educ_bg').hide();
    });

    $('#educ_bg_level').on('select2:select', function (e) {
        // Do something

        let academic_level = $(this).val();

        $('#acad_level').val(academic_level);

    });

    $("body").on('click', '#cancel_educ_bg', function (){

        $('#educ_bg_level').val(null).trigger('change');

        $('#acad_id').val("");
        $('#educ_school_name').val("");
        $('#educ_degree_course').val("");
        $('#educ_highest_level_earned').val("");
        $('#educ_scholarship').val("");

        $('#add_educ_bg').show();
        $('#update_educ_bg').hide();

    });

}
function clear_educ_bg_inputs(){

    $('#educ_bg_level').val(null).trigger('change');

    $('#educ_bg_level').select2({
        placeholder: "Select Level",
        closeOnSelect: true,
    });

    $('#acad_id').val("");
    $('#educ_school_name').val("");
    $('#educ_degree_course').val("");
    $('#educ_highest_level_earned').val("");
    $('#educ_scholarship').val("");


}
//  III. END EDUCATIONAL BACKGROUND


//  IV. BEGIN Civil Service Eligibility
function civil_service(){

    load_civil_service_eligibility();
    edit_saved_cs();
    update_cs_eligibility();

    $('#cs_type').on('select2:select', function (e) {
        // Do something
        $('#cs_type').select2({
            theme: "default"
        });
    });

    $("body").on('click', '#add_civil_service', function (){

        const child_mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#add_civil_service_mdl'));
        child_mdl.toggle();

        clear_cs_inputs();

        $('#btn_save_civil_service').show();
        $('#btn_update_cs').hide();

    });

    $('#cs_date_validity').on('keydown', function() {

        $('#cs_date_validity').removeClass('border-danger');
    });

    $('#cs_rating').on('keydown', function() {

        $('#cs_rating').removeClass('border-danger');
    });

    $('#cs_place_exam').on('keydown', function() {

        $('#cs_place_exam').removeClass('border-danger');
    });

    $('#cs_license_number').on('keydown', function() {

        $('#cs_license_number').removeClass('border-danger');
    });


    $("body").on('click', '#btn_save_civil_service', function (){

        if($('#cs_rating').val() == '' || $('#cs_rating').val()== null)
        {
            $('#cs_rating').addClass('border-danger');
            __notif_show(-1, 'Warning', 'Please dont leave blank, N/A if not applicable!');

        }else if($('#cs_place_exam').val() == '' || $('#cs_place_exam').val()== null)
        {
            $('#cs_place_exam').addClass('border-danger');
            __notif_show(-1, 'Warning', 'Please dont leave blank, N/A if not applicable!');

        }else if($('#cs_license_number').val() == '' || $('#cs_license_number').val()== null)
        {
            $('#cs_license_number').addClass('border-danger');
            __notif_show(-1, 'Warning', 'Please dont leave blank, N/A if not applicable!');

        }else if($('#cs_date_validity').val() == '' || $('#cs_date_validity').val()== null)
        {
            $('#cs_date_validity').addClass('border-danger');
            __notif_show(-1, 'Warning', 'Please dont leave blank, N/A if not applicable!');

        }else
        {
            save_to_db_cs();
        }

    });

    function save_to_db_cs(){

        let form_data = {

            _token,
            cs_type       : $('#cs_type').val(),
            cs_rating    : $('#cs_rating').val(),
            cs_date_exam    : $('#cs_date_exam').val(),
            cs_place_exam      : $('#cs_place_exam').val(),
            cs_license_number  : $('#cs_license_number').val(),
            cs_date_validity : $('#cs_date_validity').val(),

        }

        $.ajax({
            url: bpath + 'my/add/cs/eligibility',
            type: "POST",
            data: form_data,
            success: function (response) {

                if(response)
                {
                    let data = JSON.parse(response);
                    let status = data['status'];

                    if(status == 200){

                        $('#dt__civil_service tbody tr').detach();

                        __notif_show(1, 'Success', 'Added successfully!');
                        load_civil_service_eligibility();

                        clear_cs_inputs();

                    }
                }
            }
        });


    }

    function update_cs_eligibility(){

        $('body').on('click', '.update_cs_eligibility', function (){

            $('#btn_save_civil_service').hide();
            $('#btn_update_cs').show();

            let cs_id = $(this).data('cs-id');
            let cs_type = $(this).data('cs-type');
            let cs_rating = $(this).data('cs-rating');
            let cs_date = $(this).data('cs-date');
            let cs_place = $(this).data('cs-place');
            let cs_license = $(this).data('license-number');
            let cs_validity = $(this).data('license-validity');

            $('#cs_type').val(cs_type).trigger('change');
            $('#cs_rating').val(cs_rating);
            $('#cs_date_exam').val(cs_date);
            $('#cs_place_exam').val(cs_place);
            $('#cs_license_number').val(cs_license);
            $('#cs_date_validity').val(cs_validity);

            $('#cs_eligibility_id').val(cs_id);

            const child_mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#add_civil_service_mdl'));
            child_mdl.toggle();

        });

        $('body').on('click', '#btn_update_cs', function (){

            let form_data = {

                _token,
                cs_id               : $('#cs_eligibility_id').val(),
                cs_type             : $('#cs_type').val(),
                cs_rating           : $('#cs_rating').val(),
                cs_date_exam        : $('#cs_date_exam').val(),
                cs_place_exam       : $('#cs_place_exam').val(),
                cs_license_number   : $('#cs_license_number').val(),
                cs_date_validity    : $('#cs_date_validity').val(),

            }

            $.ajax({
                url: bpath + 'my/update/cs/eligibility',
                type: "POST",
                data: form_data,
                success: function (response) {

                    if(response)
                    {
                        let data = JSON.parse(response);
                        let status = data['status'];

                        if(status == 200){

                            $('#dt__civil_service tbody tr').detach();

                            __notif_show(1, 'Success', 'Updated successfully!');
                            load_civil_service_eligibility();

                            clear_cs_inputs();

                            const child_mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#add_civil_service_mdl'));
                            child_mdl.hide();

                        }
                    }
                }
            });

        });
    }

    function add_row_civil_service(){

        var tr='<tr class="hover:bg-gray-200">'+
            '<td style="text-transform:uppercase"><input type="text" style="display: none" name="td_cs_type[]" class="form-control" value="'+$('#cs_type').val()+'">'+$('#cs_type').val()+'</td>'+
            '<td style="text-transform:uppercase"><input type="text" style="display: none" name="td_cs_rating[]" class="form-control" value="'+$('#cs_rating').val()+'">'+$('#cs_rating').val()+'</td>'+
            '<td style="text-transform:uppercase"><input type="text" style="display: none" name="td_cs_date_exam[]" class="form-control" value="'+$('#cs_date_exam').val()+'">'+$('#cs_date_exam').val()+'</td>'+
            '<td style="text-transform:uppercase"><input type="text" style="display: none" name="td_cs_place_exam[]" class="form-control" value="'+$('#cs_place_exam').val()+'">'+$('#cs_place_exam').val()+'</td>'+
            '<td style="text-transform:uppercase"><input type="text" style="display: none" name="td_cs_license_number[]" class="form-control" value="'+$('#cs_license_number').val()+'">'+$('#cs_license_number').val()+'</td>'+
            '<td style="text-transform:uppercase"><input type="text" style="display: none" name="td_cs_date_validity[]" class="form-control" value="'+$('#cs_date_validity').val()+'">'+$('#cs_date_validity').val()+'</td>'+
            '<td>' +
                '<div class="flex justify-center items-center">' +
                    '<a href="javascript:void(0);" class="delete text-center"><i  class="w-4 h-4 text-danger fa-solid fa-trash"></i></a>' +
                '</div>'+
            '</td>'+
            '</tr>';

        $('#dt__civil_service tbody').append(tr);

        // '<a id="btn_edit_academic" href="javascript:void(0);" class=" text-center"> <i  class="w-4 h-4 mr-4 fa-regular fa-pen-to-square">Edit</i></a>' +
    };

    $('#dt__civil_service tbody').on('click','.delete',function(){
        $(this).parent().parent().parent().remove();
    });

    $("body").on('click', '.delete_saved_cs', function (){

        let cs_id = $(this).data('cs-id');

        $('#mdl_cs_input_id').val(cs_id);

        const cs_mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#delete_cs_eligibility_mdl'));
        cs_mdl.toggle();

    });

    $('body').on('click', '#btn_delete_my_cs_eligibility', function (){

        let cs_id = $('#mdl_cs_input_id').val();

        $.ajax({
            url: bpath + 'my/remove/cs',
            type: "POST",
            data: { _token, cs_id },
            success: function (response) {

                if(response.status == 200)
                {
                    $('#dt__civil_service tbody tr').detach();
                    __notif_show(1, 'Success', 'Removed successfully!');
                    load_civil_service_eligibility();
                    const cs_mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#delete_cs_eligibility_mdl'));
                    cs_mdl.hide();

                }
            }
        });

    });

}
function clear_cs_inputs(){
    $('#cs_type').val(null).trigger('change');

    $('#cs_type').select2({
        placeholder: "Select Eligibility Type",
        closeOnSelect: true,
    });

    $('#cs_rating').val("");
    $('#cs_place_exam').val("");
    $('#cs_license_number').val("");
    $('#cs_date_validity').val("");

}
function load_civil_service_eligibility(){

    $('#dt__civil_service tbody tr').detach();

    $.ajax({
        url: bpath + 'my/load/civil/service/eligibility',
        type: "POST",
        data: { _token },
        success: function (response) {

            var data = JSON.parse(response);

            let cs_eligibility_list = data['cs_eligibility_list'];

            $('#dt__civil_service tbody').append(cs_eligibility_list);


        }
    });
}
function edit_saved_cs(){

    $("body").on('click', '.edit_saved_cs', function (){

        let cs_id = $(this).data('cs-id');
        let cs_type = $(this).data('cs-type');
        let cs_rating = $(this).data('cs-rating');
        let cs_date = $(this).data('cs-date');
        let cs_place = $(this).data('cs-place');
        let cs_license = $(this).data('cs-license');
        let cs_validity = $(this).data('cs-validity');

        $('#cs_eligibility_id').val(cs_id);
        $('#cs_rating').val(cs_rating);
        $('#cs_place_exam').val(cs_place);
        $('#cs_license_number').val(cs_license);

        $('#cs_type').val(cs_type).trigger('change');

        $('#cs_type').select2({
            placeholder: cs_type
        });

        const child_mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#add_civil_service_mdl'));
        child_mdl.toggle();

        $('#save_civil_service').hide();
        $('#update_cs').show();

    });

    $("body").on('click', '#update_cs', function (){

        if($('#cs_type').val() == null)
        {
            $('#cs_type').select2({
                theme: "error",
                placeholder: "Eligiblity Type is required",
            });

        }else
        {
            let form_data = {

                _token,
                cs_id : $('#cs_eligibility_id').val(),
                cs_eligibility_type : $('#cs_type').val(),
                cs_rating : $('#cs_rating').val(),
                cs_date_exam : $('#cs_date_exam').val(),
                cs_place_exam : $('#cs_place_exam').val(),
                cs_license_number : $('#cs_license_number').val(),
                cs_license_validity : $('#cs_date_validity').val(),
            }

            $.ajax({
                url: bpath + 'my/update/cs/eligibility',
                type: "POST",
                data: form_data,
                success: function (response) {

                    const educ_mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#add_civil_service_mdl'));
                    educ_mdl.hide();

                    $('#dt__civil_service tbody tr').detach();

                    load_civil_service_eligibility();
                    __notif_show(1, 'Success', 'Civil Service updated successfully!');
                }
            });
        }

    });
}
//  IV. END Civil Service Eligibility

//  V. BEGIN::  WORK EXPERIENCE
function work_experience(){

    load_added_work_exp();
    edit_saved_work_exp();
    delete_saved_work_exp();
    bind_work_exp_inputs();

    $("body").on('click', '#add_work_exp', function (){
        const child_mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#add_work_exp_mdl'));
        child_mdl.toggle();

        $('#save_work_exp').show();
        $('#edit_work_exp').hide();
    });

    $("body").on('click', '#save_work_exp', function (){

        if($('#work_exp_pos_title').val() == '' || $('#work_exp_pos_title').val()== null)
        {
            $('#work_exp_pos_title').addClass('border-danger');
            __notif_show(-1, 'Warning', 'Please dont leave blank, N/A if not applicable!');

        }else if($('#work_exp_dept_agency').val() == '' || $('#work_exp_dept_agency').val()== null)
        {
            $('#work_exp_dept_agency').addClass('border-danger');
            __notif_show(-1, 'Warning', 'Please dont leave blank, N/A if not applicable!');

        }else if($('#work_exp_sal').val() == '' || $('#work_exp_sal').val()== null)
        {
            $('#work_exp_sal').addClass('border-danger');
            __notif_show(-1, 'Warning', 'Please dont leave blank, N/A if not applicable!');

        }else if($('#work_exp_sg').val() == '' || $('#work_exp_sg').val()== null)
        {
            $('#work_exp_sg').addClass('border-danger');
            __notif_show(-1, 'Warning', 'Please dont leave blank, N/A if not applicable!');

        }else if($('#work_exp_status').val() == '' || $('#work_exp_status').val()== null)
        {
            $('#work_exp_status').addClass('border-danger');
            __notif_show(-1, 'Warning', 'Please dont leave blank, N/A if not applicable!');

        }else {
            save_to_db_work_exp();
        }

    });

    $("body").on('click', '#btn_cancel_add_work_exp', function (){
        clear_work_exp_inputs();
    });

    function add_row_work_exp(){

        var tr='<tr class="hover:bg-gray-200">'+
            '<td style="text-transform:uppercase"><input type="text" style="display: none" name="td_worK_exp_from[]" class="form-control" value="'+$('#work_exp_date_from').val()+'">'+$('#work_exp_date_from').val()+'</td>'+
            '<td style="text-transform:uppercase"><input type="text" style="display: none" name="td_worK_exp_to[]" class="form-control" value="'+$('#work_exp_date_to').val()+'">'+$('#work_exp_date_to').val()+'</td>'+
            '<td style="text-transform:uppercase"><input type="text" style="display: none" name="td_worK_exp_pos[]" class="form-control" value="'+$('#work_exp_pos_title').val()+'">'+$('#work_exp_pos_title').val()+'</td>'+
            '<td style="text-transform:uppercase"><input type="text" style="display: none" name="td_worK_exp_agency[]" class="form-control" value="'+$('#work_exp_dept_agency').val()+'">'+$('#work_exp_dept_agency').val()+'</td>'+
            '<td style="text-transform:uppercase"><input type="text" style="display: none" name="td_worK_exp_sal[]" class="form-control" value="'+$('#work_exp_sal').val()+'">'+$('#work_exp_sal').val()+'</td>'+
            '<td style="text-transform:uppercase"><input type="text" style="display: none" name="td_worK_exp_sg[]" class="form-control" value="'+$('#work_exp_sg').val()+'">'+$('#work_exp_sg').val()+'</td>'+
            '<td style="text-transform:uppercase"><input type="text" style="display: none" name="td_worK_exp_status[]" class="form-control" value="'+$('#work_exp_status').val()+'">'+$('#work_exp_status').val()+'</td>'+
            '<td ><input type="text" style="display: none" name="td_worK_exp_service_type[]" class="form-control" value="'+$('#work_exp_govt_service').val()+'">'+$('#work_exp_govt_service').val()+'</td>'+
            '<td>' +
                '<div class="flex justify-center items-center">' +
                    // '<a id="btn_edit_academic" href="javascript:void(0);" class=" text-center"> <i  class="w-4 h-4 mr-4 fa-regular fa-pen-to-square">Edit</i></a>' +
                    '<a href="javascript:void(0);" class="delete text-center"><i  class="w-4 h-4 text-danger fa-solid fa-trash"></i></a>' +
                '</div>'+
            '</td>'+
            '</tr>';

        $('#dt__work_exp tbody').append(tr);

    };

    $('#dt__work_exp tbody').on('click','.delete',function(){
        $(this).parent().parent().parent().remove();
    });

    function save_to_db_work_exp(){

        let form_data = {

            _token,
            work_exp_date_from   : $('#work_exp_date_from').val(),
            work_exp_date_to     : $('#work_exp_date_to').val(),
            work_exp_pos_title   : $('#work_exp_pos_title').val(),
            work_exp_dept_agency : $('#work_exp_dept_agency').val(),
            work_exp_sal         : $('#work_exp_sal').val(),
            work_exp_sg          : $('#work_exp_sg').val(),
            work_exp_status      : $('#work_exp_status').val(),
            work_exp_govt_service: $('#work_exp_govt_service').val(),

        }

        $.ajax({
            url: bpath + 'my/add/work/experience',
            type: "POST",
            data: form_data,
            success: function (response) {

                if(response)
                {
                    let data = JSON.parse(response);
                    let status = data['status'];

                    if(status == 200){

                        $('#dt__work_exp tbody tr').detach();

                        __notif_show(1, 'Success', 'Added successfully!');
                        load_added_work_exp();

                        clear_work_exp_inputs();

                    }
                }
            }
        });

    }
}
function bind_work_exp_inputs(){

    $('#work_exp_pos_title').on('keydown', function() {

        $('#work_exp_pos_title').removeClass('border-danger');
    });

    $('#work_exp_dept_agency').on('keydown', function() {

        $('#work_exp_dept_agency').removeClass('border-danger');
    });

    $('#work_exp_sal').on('keydown', function() {

        $('#work_exp_sal').removeClass('border-danger');
    });

    $('#work_exp_sg').on('keydown', function() {

        $('#work_exp_sg').removeClass('border-danger');
    });

    $('#work_exp_status').on('keydown', function() {

        $('#work_exp_status').removeClass('border-danger');
    });

}
function load_added_work_exp(){

    $.ajax({
        url: bpath + 'my/load/work/experience',
        type: "POST",
        data: { _token },
        success: function (response) {

            var data = JSON.parse(response);

            let work_exp_list = data['work_exp_list'];

            $('#dt__work_exp tbody').append(work_exp_list);

        }
    });

}
function clear_work_exp_inputs(){

    $('#work_exp_pos_title').val("");
    $('#work_exp_dept_agency').val("");
    $('#work_exp_sal').val("");
    $('#work_exp_sg').val("");
    $('#work_exp_status').val("");

}
function edit_saved_work_exp(){

    $("body").on('click', '.update_work_exp', function (){

        let work_exp_id = $(this).data('exp-id');
        let work_from = $(this).data('exp-from');
        let work_to = $(this).data('exp-to');
        let work_title = $(this).data('exp-title');
        let work_office = $(this).data('exp-office');
        let work_sal = $(this).data('exp-sal');
        let work_sg = $(this).data('exp-sg');
        let work_status = $(this).data('exp-status');
        let work_service = $(this).data('exp-gvt');

        const child_mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#add_work_exp_mdl'));
        child_mdl.toggle();

        $('#work_exp_id').val(work_exp_id);
        $('#work_exp_date_from').val(work_from);
        $('#work_exp_date_to').val(work_to);
        $('#work_exp_pos_title').val(work_title);
        $('#work_exp_dept_agency').val(work_office);
        $('#work_exp_sal').val(work_sal);
        $('#work_exp_sg').val(work_sg);
        $('#work_exp_status').val(work_status);
        $('#work_exp_govt_service').val(work_service).trigger('change');

        $('#save_work_exp').hide();
        $('#edit_work_exp').show();

    });

    $("body").on('click', '#edit_work_exp', function (){

        let update_work_exp_data = {

            _token,
            work_exp_id : $('#work_exp_id').val(),
            work_exp_date_from : $('#work_exp_date_from').val(),
            work_exp_date_to : $('#work_exp_date_to').val(),
            work_exp_pos_title : $('#work_exp_pos_title').val(),
            work_exp_dept_agency : $('#work_exp_dept_agency').val(),
            work_exp_sal : $('#work_exp_sal').val(),
            work_exp_sg : $('#work_exp_sg').val(),
            work_exp_status : $('#work_exp_status').val(),
            work_exp_govt_service : $('#work_exp_govt_service').val(),
        }

        $.ajax({
            url: bpath + 'my/update/work/exp',
            type: "POST",
            data: update_work_exp_data,
            success: function (response) {

                const educ_mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#add_work_exp_mdl'));
                educ_mdl.hide();

                $('#dt__work_exp tbody tr').detach();

                load_added_work_exp();
                __notif_show(1, 'Success', 'Updated successfully!');
            }
        });

    });

}
function delete_saved_work_exp(){

    $("body").on('click', '.delete_work_exp', function (){

        let work_exp_id = $(this).data('exp-id');
        $('#mdl_work_exp_input_id').val(work_exp_id);

        const cs_mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#delete_work_exp_mdl'));
        cs_mdl.toggle();

    });

    $('body').on('click', '#btn_delete_my_work_exp', function (){

        let work_exp_id =  $('#mdl_work_exp_input_id').val();

        $.ajax({
            url: bpath + 'my/remove/work/exp',
            type: "POST",
            data: { _token, work_exp_id },
            success: function (response) {

                if(response.status == 200)
                {
                    $('#dt__work_exp tbody tr').detach();

                    load_added_work_exp();
                    __notif_show(1, 'Success', 'Deleted successfully!');

                    const cs_mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#delete_work_exp_mdl'));
                    cs_mdl.hide();
                }
            }
        });

    });

}
//  V. END::  WORK EXPERIENCE


//  VI. BEGIN:: Voluntary Work or Involvement in Civic / Non-Government / People / Voluntary Organization/s
function voluntary_work_involvement(){

    load_added_vol_work();
    bind_voluntary_work_inputs();
    edit_saved_vol_work();
    delete_saved_vol_work();

    $("body").on('click', '#add_voluntary_work', function (){
        const child_mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#add_voluntary_work_mdl'));
        child_mdl.toggle();

        $('#save_voluntary_work').show();
        $('#edit_vol_work').hide();

    });

    $("body").on('click', '#save_voluntary_work', function (){

        if($('#vol_work_org_name').val() == '' || $('#vol_work_org_name').val()== null)
        {
            $('#vol_work_org_name').addClass('border-danger');
            __notif_show(-1, 'Warning', 'Please dont leave blank, N/A if not applicable!');

        }else if($('#vol_work_hr_number').val() == '' || $('#vol_work_hr_number').val()== null)
        {
            $('#vol_work_hr_number').addClass('border-danger');
            __notif_show(-1, 'Warning', 'Please dont leave blank, N/A if not applicable!');

        }else if($('#vol_work_nature').val() == '' || $('#vol_work_nature').val()== null)
        {
            $('#vol_work_nature').addClass('border-danger');
            __notif_show(-1, 'Warning', 'Please dont leave blank, N/A if not applicable!');

        }else{

            save_to_db_voluntary_work();
        }

    });

    function add_row_work_voluntary(){

        var tr='<tr class="hover:bg-gray-200">'+
            '<td style="text-transform:uppercase"><input type="text" style="display: none" name="td_vol_work_name[]" class="form-control" value="'+$('#vol_work_org_name').val()+'">'+$('#vol_work_org_name').val()+'</td>'+
            '<td style="text-transform:uppercase"><input type="text" style="display: none" name="td_vol_work_from[]" class="form-control" value="'+$('#vol_work_date_from').val()+'">'+$('#vol_work_date_from').val()+'</td>'+
            '<td style="text-transform:uppercase"><input type="text" style="display: none" name="td_vol_work_to[]" class="form-control" value="'+$('#vol_work_date_to').val()+'">'+$('#vol_work_date_to').val()+'</td>'+
            '<td style="text-transform:uppercase"><input type="text" style="display: none" name="td_vol_work_hr_number[]" class="form-control" value="'+$('#vol_work_hr_number').val()+'">'+$('#vol_work_hr_number').val()+'</td>'+
            '<td style="text-transform:uppercase"><input type="text" style="display: none" name="td_vol_work_nature[]" class="form-control" value="'+$('#vol_work_nature').val()+'">'+$('#vol_work_nature').val()+'</td>'+
            '<td>' +
                '<div class="flex justify-center items-center">' +
                    '<a id="btn_edit_academic" href="javascript:void(0);" class=" text-center"> <i  class="w-4 h-4 mr-4 fa-regular fa-pen-to-square">Edit</i></a>' +
                    '<a href="javascript:void(0);" class="delete text-center"><i  class="w-4 h-4 text-danger fa-solid fa-trash"></i></a>' +
                '</div>'+
            '</td>'+
            '</tr>';

        $('#dt__voluntary tbody').append(tr);

    };

    $('#dt__voluntary tbody').on('click','.delete',function(){
        $(this).parent().parent().parent().remove();
    });
}
function save_to_db_voluntary_work(){

    let form_data = {

        _token,
        vol_work_org_name   : $('#vol_work_org_name').val(),
        vol_work_date_from  : $('#vol_work_date_from').val(),
        vol_work_date_to    : $('#vol_work_date_to').val(),
        vol_work_hr_number  : $('#vol_work_hr_number').val(),
        vol_work_nature     : $('#vol_work_nature').val(),

    }

    $.ajax({
        url: bpath + 'my/add/voluntary/work',
        type: "POST",
        data: form_data,
        success: function (response) {

            if(response)
            {
                let data = JSON.parse(response);
                let status = data['status'];

                if(status == 200){

                    $('#dt__voluntary tbody tr').detach();

                    __notif_show(1, 'Success', 'Added successfully!');
                    load_added_vol_work();

                    clear_vol_work_inputs();

                }
            }
        }
    });

}
function load_added_vol_work(){
    $.ajax({
        url: bpath + 'my/load/voluntary/work',
        type: "POST",
        data: { _token },
        success: function (response) {

            var data = JSON.parse(response);

            let vol_work_list = data['vol_work_list'];

            $('#dt__voluntary tbody').append(vol_work_list);

        }
    });
}
function clear_vol_work_inputs(){
    $('#vol_work_org_name').val("");
    $('#vol_work_hr_number').val("");
    $('#vol_work_nature').val("");
}
function edit_saved_vol_work(){

    $("body").on('click', '.update_vol_work', function (){

        let vol_work_id = $(this).data('vol-id');
        let vol_work_name = $(this).data('vol-org-name');
        let vol_work_from = $(this).data('vol-from');
        let vol_work_to = $(this).data('vol-to');
        let vol_work_hrs_num = $(this).data('vol-number');
        let vol_work_nature = $(this).data('vol-nature');

        const child_mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#add_voluntary_work_mdl'));
        child_mdl.toggle();

        $('#vol_work_id').val(vol_work_id);
        $('#vol_work_org_name').val(vol_work_name);
        $('#vol_work_date_from').val(vol_work_from);
        $('#vol_work_date_to').val(vol_work_to);
        $('#vol_work_hr_number').val(vol_work_hrs_num);
        $('#vol_work_nature').val(vol_work_nature);

        $('#save_voluntary_work').hide();
        $('#edit_vol_work').show();

    });

    $("body").on('click', '#edit_vol_work', function (){

        let update_vol_work_data = {
            _token,
            vol_work_id : $('#vol_work_id').val(),
            vol_work_org_name : $('#vol_work_org_name').val(),
            vol_work_date_from : $('#vol_work_date_from').val(),
            vol_work_date_to : $('#vol_work_date_to').val(),
            vol_work_hr_number : $('#vol_work_hr_number').val(),
            vol_work_nature : $('#vol_work_nature').val(),
        }

        $.ajax({
            url: bpath + 'my/update/voluntary/work',
            type: "POST",
            data: update_vol_work_data,
            success: function (response) {

                const educ_mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#add_voluntary_work_mdl'));
                educ_mdl.hide();

                $('#dt__voluntary tbody tr').detach();

                load_added_vol_work();
                clear_vol_work_inputs();
                __notif_show(1, 'Success', 'Updated successfully!');
            }
        });

    });

    $("body").on('click', '#btn_cancel_add_vol_work', function (){
        clear_vol_work_inputs();
    });

}
function delete_saved_vol_work(){

    $("body").on('click', '.delete_vol_work', function (){

        let vol_work_id = $(this).data('vol-id');
        $('#mdl_vol_work_input_id').val(vol_work_id);

        const child_mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#delete_voluntary_work_mdl'));
        child_mdl.toggle();

    });

    $('body').on('click', '#btn_delete_my_voluntary_work', function (){

        let vol_work_id = $('#mdl_vol_work_input_id').val();

        $.ajax({
            url: bpath + 'my/remove/voluntary/work',
            type: "POST",
            data: { _token, vol_work_id },
            success: function (response) {

                if(response.status == 200)
                {
                    $('#dt__voluntary tbody tr').detach();

                    load_added_vol_work();
                    __notif_show(1, 'Success', 'Removed successfully!');
                    clear_vol_work_inputs();

                    const child_mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#delete_voluntary_work_mdl'));
                    child_mdl.hide();
                }
            }
        });

    });

}
function bind_voluntary_work_inputs(){

    $('#vol_work_org_name').on('keydown', function() {

        $('#vol_work_org_name').removeClass('border-danger');
    });

    $('#vol_work_hr_number').on('keydown', function() {

        $('#vol_work_hr_number').removeClass('border-danger');
    });

    $('#vol_work_nature').on('keydown', function() {

        $('#vol_work_nature').removeClass('border-danger');
    });

}
//  VI. END:: Voluntary Work or Involvement in Civic / Non-Government / People / Voluntary Organization/s


//  VII. BEGIN:: LEARNING AND DEVELOPMENT (L&D) INTERVENTIONS/TRAINING PROGRAMS ATTENDED
function learning_development(){

    load_added_learning_development();
    bind_ld_inputs();
    update_my_learning_development();
    delete_saved_ld();

    $("body").on('click', '#add_ld', function (){
        const child_mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#add_LD_mdl'));
        child_mdl.toggle();

        $('#save_LD').show();
        $('#edit_ld').hide();

    });

    $("body").on('click', '#save_LD', function (){

        if($('#ld_title').val() == '' || $('#ld_title').val()== null)
        {
            $('#ld_title').addClass('border-danger');
            __notif_show(-1, 'Warning', 'Please dont leave blank, N/A if not applicable!');

        }else if($('#ld_hr_number').val() == '' || $('#ld_hr_number').val()== null)
        {
            $('#ld_hr_number').addClass('border-danger');
            __notif_show(-1, 'Warning', 'Please dont leave blank, N/A if not applicable!');

        }else if($('#ld_sponsored_by').val() == '' || $('#ld_sponsored_by').val()== null) {

            $('#ld_sponsored_by').addClass('border-danger');
            __notif_show(-1, 'Warning', 'Please dont leave blank, N/A if not applicable!');

        }else if($('#ld_type').val() == "OTHERS" && $('#ld_type_others').val() == '') {

            $('#ld_type_others').addClass('border-danger');
            __notif_show(-1, 'Warning', 'Please dont leave blank, N/A if not applicable!');

        }else {

            save_to_db_learning_dev();
        }

    });

    function add_row_LD(){

        let ld_type = "";

        if($('#ld_type').val()=="OTHERS")
        {
            ld_type = $('#ld_type_others').val();
        }else
        {
            ld_type = $('#ld_type').val();
        }

        var tr='<tr class="hover:bg-gray-200">'+
            '<td style="text-transform:uppercase"><input type="text" style="display: none" name="td_ld_title[]" class="form-control" value="'+$('#ld_title').val()+'">'+$('#ld_title').val()+'</td>'+
            '<td style="text-transform:uppercase"><input type="text" style="display: none" name="td_ld_date_from[]" class="form-control" value="'+$('#ld_date_from').val()+'">'+$('#ld_date_from').val()+'</td>'+
            '<td style="text-transform:uppercase"><input type="text" style="display: none" name="td_ld_date_to[]" class="form-control" value="'+$('#ld_date_to').val()+'">'+$('#ld_date_to').val()+'</td>'+
            '<td style="text-transform:uppercase"><input type="text" style="display: none" name="td_ld_hr_number[]" class="form-control" value="'+$('#ld_hr_number').val()+'">'+$('#ld_hr_number').val()+'</td>'+
            '<td style="text-transform:uppercase"><input type="text" style="display: none" name="td_ld_type[]" class="form-control" value="'+ld_type+'">'+ld_type+'</td>'+
            '<td style="text-transform:uppercase"><input type="text" style="display: none" name="td_ld_sponsor[]" class="form-control" value="'+$('#ld_sponsored_by').val()+'">'+$('#ld_sponsored_by').val()+'</td>'+
            '<td>' +
                '<div class="flex justify-center items-center">' +
                    // '<a id="btn_edit_academic" href="javascript:void(0);" class=" text-center"> <i  class="w-4 h-4 mr-4 fa-regular fa-pen-to-square">Edit</i></a>' +
                    '<a href="javascript:void(0);" class="delete text-center"><i  class="w-4 h-4 text-danger fa-solid fa-trash"></i></a>' +
                '</div>'+
            '</td>'+
            '</tr>';

        $('#dt__LD tbody').append(tr);

    };

    $('#ld_type').on('select2:select', function (e) {
        // Do something
        if($('#ld_type').val()=="OTHERS")
        {
            load_other_ld_type_inputs();

        }else{
            $('#div_if_others').hide();
        }
    });


    $('#dt__LD tbody').on('click','.delete',function(){
        $(this).parent().parent().parent().remove();
    });

}
function bind_ld_inputs(){

    $('#ld_title').on('keydown', function() {

        $('#ld_title').removeClass('border-danger');
    });

    $('#ld_hr_number').on('keydown', function() {

        $('#ld_hr_number').removeClass('border-danger');
    });

    $('#ld_sponsored_by').on('keydown', function() {

        $('#ld_sponsored_by').removeClass('border-danger');
    });

    $('#ld_type_others').on('keydown', function() {

        $('#ld_type_others').removeClass('border-danger');
    });

}
function save_to_db_learning_dev(){

    let form_data = {

        _token,
        ld_title        : $('#ld_title').val(),
        ld_date_from    : $('#ld_date_from').val(),
        ld_date_to      : $('#ld_date_to').val(),
        ld_hr_number    : $('#ld_hr_number').val(),
        ld_type         : $('#ld_type').val(),
        ld_sponsored_by : $('#ld_sponsored_by').val(),
        ld_type_others  : $('#ld_type_others').val(),

    }

    $.ajax({
        url: bpath + 'my/add/learning/development',
        type: "POST",
        data: form_data,
        success: function (response) {

            if(response)
            {
                let data = JSON.parse(response);
                let status = data['status'];

                if(status == 200){

                    $('#dt__LD tbody tr').detach();

                    __notif_show(1, 'Success', 'Added successfully!');
                    load_added_learning_development()

                    clear_ld_inputs();

                }
            }
        }
    });

}
function load_other_ld_type_inputs(){

    $('#div_if_others').show();

    let html_data = '<label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> if Others <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">(Write in full if Others)</span> </label>' +
        '<input id="ld_type_others" type="text" name="ld_type_others" style="text-transform:uppercase" class="form-control" placeholder="Types of LD" minLength="2" required autoComplete="off">';

    $('#div_if_others').html(html_data);

}
function update_my_learning_development(){

    $('body').on('click', '.update_my_ld', function (){

        let ld_id = $(this).data('ld-id');
        let ld_title = $(this).data('ld-title');
        let ld_from = $(this).data('ld-from');
        let ld_to = $(this).data('ld-to');
        let ld_number = $(this).data('ld-number');
        let ld_type = $(this).data('ld-type');
        let ld_sponsored = $(this).data('ld-sponsored');
        let ld_type_others = $(this).data('ld-others');

        if(ld_type  == "OTHERS")
        {
            load_other_ld_type_inputs();
            $('#ld_type_others').val(ld_type_others);
            $('#ld_type').val(ld_type).trigger('change');

            $('#ld_id').val(ld_id);
            $('#ld_title').val(ld_title);
            $('#ld_date_from').val(ld_from);
            $('#ld_date_to').val(ld_to);
            $('#ld_hr_number').val(ld_number);
            $('#ld_sponsored_by').val(ld_sponsored);

        }else
        {
            $('#div_if_others').hide();
            $('#ld_id').val(ld_id);
            $('#ld_title').val(ld_title);
            $('#ld_date_from').val(ld_from);
            $('#ld_date_to').val(ld_to);
            $('#ld_hr_number').val(ld_number);
            $('#ld_type').val(ld_type).trigger('change');
            $('#ld_sponsored_by').val(ld_sponsored);
        }



        const child_mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#add_LD_mdl'));
        child_mdl.toggle();

        $('#save_LD').hide();
        $('#edit_ld').show();
    });

    $('body').on('click', '#edit_ld', function (){

        let form_data = {

            _token,
            ld_id           : $('#ld_id').val(),
            ld_title        : $('#ld_title').val(),
            ld_date_from    : $('#ld_date_from').val(),
            ld_date_to      : $('#ld_date_to').val(),
            ld_hr_number    : $('#ld_hr_number').val(),
            ld_type         : $('#ld_type').val(),
            ld_sponsored_by : $('#ld_sponsored_by').val(),
            ld_type_others  : $('#ld_type_others').val(),

        }

        $.ajax({
            url: bpath + 'my/update/learning/development',
            type: "POST",
            data: form_data,
            success: function (response) {

                if(response)
                {
                    let data = JSON.parse(response);
                    let status = data['status'];

                    if(status == 200){

                        $('#dt__LD tbody tr').detach();

                        __notif_show(1, 'Success', 'Updated successfully!');
                        load_added_learning_development();

                        clear_ld_inputs();

                        const child_mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#add_LD_mdl'));
                        child_mdl.hide();

                    }
                }
            }
        });

    });
}
function load_added_learning_development(){

    $.ajax({
        url: bpath + 'my/load/learning/development',
        type: "POST",
        data: { _token },
        success: function (response) {

            var data = JSON.parse(response);

            let ld_list = data['ld_list'];

            $('#dt__LD tbody').append(ld_list);

        }
    });
}
function delete_saved_ld(){

    $("body").on('click', '.delete_ld', function (){

        const child_mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#delete_ld_mdl'));
        child_mdl.toggle();

        let ld_id = $(this).data('ld-id');
        $('#mdl_ld_input_id').val(ld_id);


    });

    $('body').on('click', '#btn_delete_my_learning_dev', function (){

        let ld_id = $('#mdl_ld_input_id').val();

        $.ajax({
            url: bpath + 'my/remove/learning/development',
            type: "POST",
            data: { _token, ld_id },
            success: function (response) {

                if(response.status == 200)
                {
                    $('#dt__LD tbody tr').detach();

                    load_added_learning_development()
                    __notif_show(1, 'Success', 'Removed successfully!');

                    const child_mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#delete_ld_mdl'));
                    child_mdl.hide();
                }
            }
        });
    });
}
function clear_ld_inputs(){
    $('#ld_id').val("");
    $('#ld_title').val("");
    $('#ld_hr_number').val("");
    $('#ld_sponsored_by').val("");
    $('#ld_type_others').val("");
    $('#div_if_others').hide();

    $('#ld_type').val("MANAGERIAL").trigger('change');
}
//  VII. BEGIN:: LEARNING AND DEVELOPMENT (L&D) INTERVENTIONS/TRAINING PROGRAMS ATTENDED


//  VIII. BEGIN:: OTHER INFORMATION
function special_skills(){

    load_added_special_skills();
    delete_saved_special_skills();
    bind_special_skills_inputs();
    update_special_skills();

    $("body").on('click', '#add_other_info', function (){

        $('#save_other_info').show();
        $('#update_other_info').hide();

        const child_mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#add_other_info_mdl'));
        child_mdl.toggle();

    });

    $("body").on('click', '#save_other_info', function (){

        if($('#others_skills').val() == '' || $('#others_skills').val()== null)
        {
            $('#others_skills').addClass('border-danger');
            __notif_show(-1, 'Warning', 'Please dont leave blank, N/A if not applicable!');

        }else if($('#others_distinction').val() == '' || $('#others_distinction').val()== null)
        {
            $('#others_distinction').addClass('border-danger');
            __notif_show(-1, 'Warning', 'Please dont leave blank, N/A if not applicable!');

        }else if($('#others_membership').val() == '' || $('#others_membership').val()== null)
        {
            $('#others_membership').addClass('border-danger');
            __notif_show(-1, 'Warning', 'Please dont leave blank, N/A if not applicable!');

        }else
        {
            save_to_db_special_skills();
        }
    });

    function add_row_other_info(){

        var tr='<tr class="hover:bg-gray-200">'+
            '<td style="text-transform:uppercase"><input type="text" style="display: none" name="td_special_skills[]" class="form-control" value="'+$('#others_skills').val()+'">'+$('#others_skills').val()+'</td>'+
            '<td style="text-transform:uppercase"><input type="text" style="display: none" name="td_others_distinction[]" class="form-control" value="'+$('#others_distinction').val()+'">'+$('#others_distinction').val()+'</td>'+
            '<td style="text-transform:uppercase"><input type="text" style="display: none" name="td_others_membership[]" class="form-control" value="'+$('#others_membership').val()+'">'+$('#others_membership').val()+'</td>'+
            '<td><a href="javascript:void(0);" class="flex items-center justify-center text-theme-6 delete"><i  class="w-4 h-4 mr-1 text-danger fa-solid fa-trash">Remove</i></a></td>'+
            '</tr>';

        $('#dt__special_skill tbody').append(tr);

    };

    $('#dt__special_skill tbody').on('click','.delete',function(){
        $(this).parent().parent().parent().remove();
    });
}
function clear_other_info(){
    $('#others_skills').val("");
    $('#others_distinction').val("");
    $('#others_membership').val("");
}

function save_to_db_special_skills(){

    let form_data = {

        _token,
        others_skills       : $('#others_skills').val(),
        others_distinction  : $('#others_distinction').val(),
        others_membership   : $('#others_membership').val(),

    }

    $.ajax({
        url: bpath + 'my/add/special/skills',
        type: "POST",
        data: form_data,
        success: function (response) {

            if(response)
            {
                let data = JSON.parse(response);
                let status = data['status'];

                if(status == 200){

                    $('#dt__special_skill tbody tr').detach();

                    __notif_show(1, 'Success', 'Added successfully!');
                    load_added_special_skills();

                    clear_other_info();

                }
            }
        }
    });

}
function bind_special_skills_inputs(){

    $('#others_skills').on('keydown', function() {

        $('#others_skills').removeClass('border-danger');
    });

    $('#others_distinction').on('keydown', function() {

        $('#others_distinction').removeClass('border-danger');
    });

    $('#others_membership').on('keydown', function() {

        $('#others_membership').removeClass('border-danger');
    });

}
function load_added_special_skills(){
    $.ajax({
        url: bpath + 'my/load/special/skills',
        type: "POST",
        data: { _token },
        success: function (response) {

            var data = JSON.parse(response);

            let special_skill_list = data['special_skill_list'];

            $('#dt__special_skill tbody').append(special_skill_list);

        }
    });
}
function update_special_skills(){

    $('body').on('click', '.update_special_skills', function (){


        let skill_id = $(this).data('skill-id');
        let skills = $(this).data('skills');
        let distinctions = $(this).data('skill-distinctions');
        let org_membership = $(this).data('skill-org');

        $('#special_skills_id').val(skill_id);
        $('#others_skills').val(skills);
        $('#others_distinction').val(distinctions);
        $('#others_membership').val(org_membership);


        $('#save_other_info').hide();
        $('#update_other_info').show();

        const skills_mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#add_other_info_mdl'));
        skills_mdl.toggle();

    });

    $('body').on('click', '#update_other_info', function (){

        let form_data = {

            _token,
            special_skills_id   : $('#special_skills_id').val(),
            others_skills       : $('#others_skills').val(),
            others_distinction  : $('#others_distinction').val(),
            others_membership   : $('#others_membership').val(),

        }

        $.ajax({
            url: bpath + 'my/update/special/skills',
            type: "POST",
            data: form_data,
            success: function (response) {

                if(response)
                {
                    let data = JSON.parse(response);
                    let status = data['status'];

                    if(status == 200){

                        $('#dt__special_skill tbody tr').detach();

                        __notif_show(1, 'Success', 'Updated successfully!');
                        load_added_special_skills();

                        clear_other_info();

                        const skills_mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#add_other_info_mdl'));
                        skills_mdl.hide();

                    }
                }
            }
        });
    });
}
function delete_saved_special_skills(){

    $("body").on('click', '.delete_special_skills', function (){

        let skill_id = $(this).data('skill-id');
        $('#special_skills_id').val(skill_id);

        const skills_mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#delete_other_info_mdl'));
        skills_mdl.toggle();

    });

    $('body').on('click', '#btn_delete_my_special_skills', function (){

        let skill_id =  $('#special_skills_id').val();

        $.ajax({
            url: bpath + 'my/remove/special/skills',
            type: "POST",
            data: { _token, skill_id },
            success: function (response) {

                if(response.status == 200)
                {
                    $('#dt__special_skill tbody tr').detach();

                    load_added_special_skills();
                    __notif_show(1, 'Success', 'Removed successfully!');

                    const skills_mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#delete_other_info_mdl'));
                    skills_mdl.hide();
                }
            }
        });
    });

}
//  VIII. END:: OTHER INFORMATION

function others(){

    // BEGIN::  Number 34
    $('#others_34_b_yes_div').hide();

    $('#btn_34_a_yes').change(function() {
        if ($(this).is(':checked')) {
            $("#btn_34_a_no").prop("checked", false);
            cb_34_a = 1;
        }else
        {
            cb_34_a = 0;
        }
    });
    $('#btn_34_a_no').change(function() {
        if ($(this).is(':checked')) {
            $("#btn_34_a_yes").prop("checked", false);
            cb_34_a = 0;
        }else
        {
            cb_34_a = 1;
        }
    });

    $('#btn_34_b_yes').change(function() {
        if ($(this).is(':checked')) {
            $('#others_34_b_yes_div').show();
            $("#btn_34_b_no").prop("checked", false);
            cb_34_b = 1;
        } else {
            $('#others_34_b_yes_div').hide();
            cb_34_b = 0;
        }
    });
    $('#btn_34_b_no').change(function() {
        if ($(this).is(':checked')) {
            $("#btn_34_b_yes").prop("checked", false);
            $('#others_34_b_yes_div').hide();
            cb_34_b = 0;
            $('#others_34_b_yes').val("");
        }else
        {
            cb_34_b = 1;
        }
    });

    // END::  Number 34


    // BEGIN::  Number 35
    // BEGIN::  Number 35 A.
    $('#others_35_a_yes_div').hide();
    $('#others_35_b_yes_div').hide();

    $('#btn_35_a_yes').change(function() {
        if ($(this).is(':checked')) {
            $('#others_35_a_yes_div').show();
            $("#btn_35_a_no").prop("checked", false);
            cb_35_a = 1;
        } else {
            $('#others_35_a_yes_div').hide();
            cb_35_a = 0;
        }
    });
    $('#btn_35_a_no').change(function() {
        if ($(this).is(':checked')) {
            $("#btn_35_a_yes").prop("checked", false);
            $('#others_35_a_yes_div').hide();
            cb_35_a = 0;
            $('#others_35_a_yes').val("");
        }else
        {
            cb_35_a = 1;
        }
    });
    // END::  Number 35 A.

    // BEGIN::  Number 35 B.
    $('#btn_35_b_yes').change(function() {
        if ($(this).is(':checked')) {
            $('#others_35_b_yes_div').show();
            $("#btn_35_b_no").prop("checked", false);
            cb_35_b = 1;
        } else {
            $('#others_35_a_yes_div').hide();
            cb_35_b = 0;
        }
    });
    $('#btn_35_b_no').change(function() {
        if ($(this).is(':checked')) {
            $("#btn_35_b_yes").prop("checked", false);
            $('#others_35_b_yes_div').hide();
            cb_35_b = 0;
            $('#others_35_b_yes').val("");
            $('#others_35_b_status_case').val("");
            $('#others_35_b_date_filed').val("");
        }else
        {
            cb_35_b = 1;
        }
    });
    // END::  Number 35 B.
    // END::  Number 35

    // BEGIN:: Number 36
    $('#others_36_yes_div').hide();
    $('#btn_36_yes').change(function() {
        if ($(this).is(':checked')) {
            $('#others_36_yes_div').show();
            $("#btn_36_no").prop("checked", false);
            cb_36 = 1;
        } else {
            $('#others_36_yes_div').hide();
            cb_36 = 0;
        }
    });
    $('#btn_36_no').change(function() {
        if ($(this).is(':checked')) {
            $("#btn_36_yes").prop("checked", false);
            $('#others_36_yes_div').hide();
            cb_36 = 0;
            $('#others_36_yes').val("");
        }else
        {
            cb_36 = 1;
        }
    });
    // END:: Number 36

    // BEGIN:: Number 37
    $('#others_37_yes_div').hide();
    $('#btn_37_yes').change(function() {
        if ($(this).is(':checked')) {
            $('#others_37_yes_div').show();
            $("#btn_37_no").prop("checked", false);
            cb_37 = 1;
        } else {
            $('#others_37_yes_div').hide();
            cb_37 = 0;
        }
    });
    $('#btn_37_no').change(function() {
        if ($(this).is(':checked')) {
            $("#btn_37_yes").prop("checked", false);
            $('#others_37_yes_div').hide();
            cb_37 = 0;
            $('#others_37_yes').val("");
        }else
        {
            cb_37 = 1;
        }
    });
    // END:: Number 37

    // BEGIN:: Number 38
    $('#others_38_a_yes_div').hide();
    $('#others_38_b_yes_div').hide();

    //Number 38. A.
    $('#btn_38_a_yes').change(function() {
        if ($(this).is(':checked')) {
            $('#others_38_a_yes_div').show();
            $("#btn_38_a_no").prop("checked", false);
            cb_38_a = 1;
        } else {
            $('#others_38_a_yes_div').hide();
            cb_38_a = 0;
        }
    });
    $('#btn_38_a_no').change(function() {
        if ($(this).is(':checked')) {
            $("#btn_38_a_yes").prop("checked", false);
            $('#others_38_a_yes_div').hide();
            cb_38_a = 0;
            $('#others_38_a_yes').val("");
        }else
        {
            cb_38_a = 1;
        }
    });

    //Number 38. B.
    $('#btn_38_b_yes').change(function() {
        if ($(this).is(':checked')) {
            $('#others_38_b_yes_div').show();
            $("#btn_38_b_no").prop("checked", false);
            cb_38_b = 1;
        } else {
            $('#others_38_b_yes_div').hide();
            cb_38_b = 0;
        }
    });
    $('#btn_38_b_no').change(function() {
        if ($(this).is(':checked')) {
            $("#btn_38_b_yes").prop("checked", false);
            $('#others_38_b_yes_div').hide();
            cb_38_b = 0;
            $('#others_38_b_yes').val("");
        }else
        {
            cb_38_b = 1;
        }
    });
    // END:: Number 38

    // BEGIN:: Number 39
    $('#others_39_yes_div').hide();
    $('#btn_39_yes').change(function() {
        if ($(this).is(':checked')) {
            $('#others_39_yes_div').show();
            $("#btn_39_no").prop("checked", false);
            cb_39 = 1;
        } else {
            $('#others_39_yes_div').hide();
            cb_39 = 0;
        }
    });
    $('#btn_39_no').change(function() {
        if ($(this).is(':checked')) {
            $("#btn_39_yes").prop("checked", false);
            $('#others_39_yes_div').hide();
            cb_39 = 0;
            $('#others_39_yes').val("");
        }else
        {
            cb_39 = 1;
        }
    });
    // END:: Number 39

    // BEGIN:: Number 40
    $('#others_40_a_yes_div').hide();
    $('#others_40_b_yes_div').hide();
    $('#others_40_c_yes_div').hide();

    //Number 40. A.
    $('#btn_40_a_yes').change(function() {
        if ($(this).is(':checked')) {
            $('#others_40_a_yes_div').show();
            $("#btn_40_a_no").prop("checked", false);
            cb_40_a = 1;
        } else {
            $('#others_40_a_yes_div').hide();
            cb_40_a = 0;
        }
    });
    $('#btn_40_a_no').change(function() {
        if ($(this).is(':checked')) {
            $("#btn_40_a_yes").prop("checked", false);
            $('#others_40_a_yes_div').hide();
            cb_40_a = 0;
            $('#others_40_a_yes').val("");
        }else
        {
            cb_40_a = 1;
        }
    });

    //Number 40. B.
    $('#btn_40_b_yes').change(function() {
        if ($(this).is(':checked')) {
            $('#others_40_b_yes_div').show();
            $("#btn_40_b_no").prop("checked", false);
            cb_40_b = 1;
        } else {
            $('#others_38_b_yes_div').hide();
            cb_40_b = 0;
        }
    });
    $('#btn_40_b_no').change(function() {
        if ($(this).is(':checked')) {
            $("#btn_40_b_yes").prop("checked", false);
            $('#others_40_b_yes_div').hide();
            cb_40_b = 0;
            $('#others_40_b_yes').val("");
        }else
        {
            cb_40_b = 1;
        }
    });

    //Number 40. C.
    $('#btn_40_c_yes').change(function() {
        if ($(this).is(':checked')) {
            $('#others_40_c_yes_div').show();
            $("#btn_40_c_no").prop("checked", false);
            cb_40_c = 1;
        } else {
            $('#others_38_b_yes_div').hide();
            cb_40_c = 0;
        }
    });
    $('#btn_40_c_no').change(function() {
        if ($(this).is(':checked')) {
            $("#btn_40_c_yes").prop("checked", false);
            $('#others_40_c_yes_div').hide();
            cb_40_c = 0;
            $('#others_40_c_yes').val("");
        }else
        {
            cb_40_c = 1;
        }
    });
    // END:: Number 40

    load_other_infos();

}
function load_other_infos(){

    $.ajax({
        url: bpath + 'my/load/other/information',
        type: "POST",
        data: { _token, },
        success: function (response) {
            var data = JSON.parse(response);

            if(data.length > 0) {
                for (var i = 0; i < data.length; i++) {

                    /***/
                    var other_info_34_a = data[i]['other_info_34_a'];
                    var other_info_34_b = data[i]['other_info_34_b'];
                    var other_info_34_b_details = data[i]['other_info_34_b_details'];

                    var other_info_35_a = data[i]['other_info_35_a'];
                    var other_info_35_a_details = data[i]['other_info_35_a_details'];

                    var other_info_35_b = data[i]['other_info_35_b'];
                    var other_info_35_b_details = data[i]['other_info_35_b_details'];
                    var other_info_35_b_date_filed = data[i]['other_info_35_b_date_filed'];
                    var other_info_35_b_status = data[i]['other_info_35_b_status'];

                    var other_info_36 = data[i]['other_info_36'];
                    var other_info_36_details = data[i]['other_info_36_details'];

                    var other_info_37 = data[i]['other_info_37'];
                    var other_info_37_details = data[i]['other_info_37_details'];

                    var other_info_38_a = data[i]['other_info_38_a'];
                    var other_info_38_a_details = data[i]['other_info_38_a_details'];
                    var other_info_38_b = data[i]['other_info_38_b'];
                    var other_info_38_b_details = data[i]['other_info_38_b_details'];

                    var other_info_39 = data[i]['other_info_39'];
                    var other_info_39_details = data[i]['other_info_39_details'];

                    var other_info_40_a = data[i]['other_info_40_a'];
                    var other_info_40_a_details = data[i]['other_info_40_a_details'];
                    var other_info_40_b = data[i]['other_info_40_b'];
                    var other_info_40_b_details = data[i]['other_info_40_b_details'];
                    var other_info_40_c = data[i]['other_info_40_c'];
                    var other_info_40_c_details = data[i]['other_info_40_c_details'];

                    if(other_info_34_a == 1)
                    {
                        $( "#btn_34_a_yes" ).prop( "checked", true );
                        $( "#btn_34_a_no" ).prop( "checked", false );
                        cb_34_a = 1;
                    }else
                    {
                        $( "#btn_34_a_no" ).prop( "checked", true );
                        $( "#btn_34_a_yes" ).prop( "checked", false );
                        cb_34_a = 0;
                    }

                    if(other_info_34_b == 1)
                    {
                        $( "#btn_34_b_yes" ).prop( "checked", true );
                        $( "#btn_34_b_no" ).prop( "checked", false );
                        $('#others_34_b_yes_div').show();
                        $('#others_34_b_yes').val(other_info_34_b_details);
                        cb_34_b = 1;
                    }else
                    {
                        $( "#btn_34_b_no" ).prop( "checked", true );
                        $( "#btn_34_b_yes" ).prop( "checked", false );
                        $('#others_34_b_yes_div').hide();
                        $('#others_34_b_yes').val("");
                        cb_34_b = 0;
                    }

                    if(other_info_35_a == 1)
                    {
                        $( "#btn_35_a_yes" ).prop( "checked", true );
                        $( "#btn_35_a_no" ).prop( "checked", false );
                        $('#others_35_a_yes_div').show();
                        $('#others_35_a_yes').val(other_info_35_a_details);
                        cb_35_a = 1;
                    }else
                    {
                        $( "#btn_35_a_no" ).prop( "checked", true );
                        $( "#btn_35_a_yes" ).prop( "checked", false );
                        $('#others_35_a_yes_div').hide();
                        $('#others_35_a_yes').val("");
                        cb_35_a = 0;
                    }

                    if(other_info_35_b == 1)
                    {
                        $( "#btn_35_b_yes" ).prop( "checked", true );
                        $( "#btn_35_b_no" ).prop( "checked", false );
                        $('#others_35_b_yes_div').show();
                        $('#others_35_b_yes').val(other_info_35_b_details);
                        $('#others_35_b_status_case').val(other_info_35_b_status);
                        $('#others_35_b_date_filed').val(other_info_35_b_date_filed);
                        cb_35_b = 1;
                    }else
                    {
                        $( "#btn_35_b_no" ).prop( "checked", true );
                        $( "#btn_35_b_yes" ).prop( "checked", false );
                        $('#others_35_b_yes_div').hide();
                        $('#others_35_b_yes').val("");
                        $('#others_35_b_status_case').val("");
                        $('#others_35_b_date_filed').val("");
                        cb_35_b = 0;
                    }

                    if(other_info_36 == 1)
                    {
                        $( "#btn_36_yes" ).prop( "checked", true );
                        $( "#btn_36_no" ).prop( "checked", false );
                        $('#others_36_yes_div').show();
                        $('#others_36_yes').val(other_info_36_details);
                        cb_36 = 1;
                    }else
                    {
                        $( "#btn_36_no" ).prop( "checked", true );
                        $( "#btn_36_yes" ).prop( "checked", false );
                        $('#others_36_yes_div').hide();
                        $('#others_36_yes').val("");
                        cb_36 = 0;
                    }

                    if(other_info_37 == 1)
                    {
                        $( "#btn_37_yes" ).prop( "checked", true );
                        $( "#btn_37_no" ).prop( "checked", false );
                        $('#others_37_yes_div').show();
                        $('#others_37_yes').val(other_info_37_details);
                        cb_37 = 1;
                    }else
                    {
                        $( "#btn_37_no" ).prop( "checked", true );
                        $( "#btn_37_yes" ).prop( "checked", false );
                        $('#others_37_yes_div').hide();
                        $('#others_37_yes').val("");
                        cb_37 = 0;
                    }

                    if(other_info_38_a == 1)
                    {
                        $( "#btn_38_a_yes" ).prop( "checked", true );
                        $( "#btn_38_a_no" ).prop( "checked", false );
                        $('#others_38_a_yes_div').show();
                        $('#others_38_a_yes').val(other_info_38_a_details);
                        cb_38_a = 1;
                    }else
                    {
                        $( "#btn_38_a_no" ).prop( "checked", true );
                        $( "#btn_38_a_yes" ).prop( "checked", false );
                        $('#others_38_a_yes_div').hide();
                        $('#others_38_a_yes').val("");
                        cb_38_a = 0;
                    }

                    if(other_info_38_b == 1)
                    {
                        $( "#btn_38_b_yes" ).prop( "checked", true );
                        $( "#btn_38_b_no" ).prop( "checked", false );
                        $('#others_38_b_yes_div').show();
                        $('#others_38_b_yes').val(other_info_38_b_details);
                        cb_38_b = 1;
                    }else
                    {
                        $( "#btn_38_b_no" ).prop( "checked", true );
                        $( "#btn_38_b_yes" ).prop( "checked", false );
                        $('#others_38_b_yes_div').hide();
                        $('#others_38_b_yes').val("");
                        cb_38_b = 0;
                    }

                    if(other_info_39 == 1)
                    {
                        $( "#btn_39_yes" ).prop( "checked", true );
                        $( "#btn_39_no" ).prop( "checked", false );
                        $('#others_39_yes_div').show();
                        $('#others_39_yes').val(other_info_39_details);
                        cb_39 = 1;
                    }else
                    {
                        $( "#btn_39_no" ).prop( "checked", true );
                        $( "#btn_39_yes" ).prop( "checked", false );
                        $('#others_39_yes_div').hide();
                        $('#others_39_yes').val("");
                        cb_39 = 0;
                    }

                    if(other_info_40_a == 1)
                    {
                        $( "#btn_40_a_yes" ).prop( "checked", true );
                        $( "#btn_40_a_no" ).prop( "checked", false );
                        $('#others_40_a_yes_div').show();
                        $('#others_40_a_yes').val(other_info_40_a_details);
                        cb_40_a = 1;
                    }else
                    {
                        $( "#btn_40_a_no" ).prop( "checked", true );
                        $( "#btn_40_a_yes" ).prop( "checked", false );
                        $('#others_40_a_yes_div').hide();
                        $('#others_40_a_yes').val("");
                        cb_40_a = 0;
                    }

                    if(other_info_40_b == 1)
                    {
                        $( "#btn_40_b_yes" ).prop( "checked", true );
                        $( "#btn_40_b_no" ).prop( "checked", false );
                        $('#others_40_b_yes_div').show();
                        $('#others_40_b_yes').val(other_info_40_b_details);
                        cb_40_b = 1;
                    }else
                    {
                        $( "#btn_40_b_no" ).prop( "checked", true );
                        $( "#btn_40_b_yes" ).prop( "checked", false );
                        $('#others_40_b_yes_div').hide();
                        $('#others_40_b_yes').val("");
                        cb_40_b = 0;
                    }

                    if(other_info_40_c == 1)
                    {
                        $( "#btn_40_c_yes" ).prop( "checked", true );
                        $( "#btn_40_c_no" ).prop( "checked", false );
                        $('#others_40_c_yes_div').show();
                        $('#others_40_c_yes').val(other_info_40_c_details);
                        cb_40_c = 1;
                    }else
                    {
                        $( "#btn_40_c_no" ).prop( "checked", true );
                        $( "#btn_40_c_yes" ).prop( "checked", false );
                        $('#others_40_c_yes_div').hide();
                        $('#others_40_c_yes').val("");
                        cb_40_c = 0;
                    }

                }
            }
        }
    });

}

//BEGIN:: REFERENCES
function references(){

    load_ref_info();
    delete_references();
    bind_my_references();
    update_my_references();

    $("body").on('click', '#add_references', function (){
        const child_mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#add_references_mdl'));
        child_mdl.toggle();

        $('#save_ref_info').show();
        $('#update_ref_info').hide();

    });

    $("body").on('click', '#save_ref_info', function (){

        if($('#ref_name').val() == '' || $('#ref_name').val()== null)
        {
            $('#ref_name').addClass('border-danger');
            __notif_show(-1, 'Warning', 'Please dont leave blank, N/A if not applicable!');

        }else if($('#ref_address').val() == '' || $('#ref_address').val()== null) {
            $('#ref_address').addClass('border-danger');
            __notif_show(-1, 'Warning', 'Please dont leave blank, N/A if not applicable!');

        }else if($('#ref_tel_no').val() == '' || $('#ref_tel_no').val()== null) {

            $('#ref_tel_no').addClass('border-danger');
            __notif_show(-1, 'Warning', 'Please dont leave blank, N/A if not applicable!');

        }else{

            save_to_db_my_references();
        }
    });

    function add_row_ref_info(){

        var tr='<tr class="hover:bg-gray-200">'+
            '<td style="text-transform:uppercase"><input type="text" style="display: none" name="td_ref_full_name[]" class="form-control" value="'+$('#ref_name').val()+'">'+$('#ref_name').val()+'</td>'+
            '<td style="text-transform:uppercase"><input type="text" style="display: none" name="td_ref_address[]" class="form-control" value="'+$('#ref_address').val()+'">'+$('#ref_address').val()+'</td>'+
            '<td style="text-transform:uppercase"><input type="text" style="display: none" name="td_ref_tel_no[]" class="form-control" value="'+$('#ref_tel_no').val()+'">'+$('#ref_tel_no').val()+'</td>'+
            '<td><a href="javascript:void(0);" class="flex items-center justify-center text-theme-6 delete"><i  class="w-4 h-4 mr-1 text-danger fa-solid fa-trash">Remove</i></a></td>'+
            '</tr>';

        $('#dt__reference tbody').append(tr);
    };

    $('#dt__reference tbody').on('click','.delete',function(){
        $(this).parent().parent().remove();
    });
}
function bind_my_references(){

    $('#ref_name').on('keydown', function() {

        $('#ref_name').removeClass('border-danger');
    });

    $('#ref_address').on('keydown', function() {

        $('#ref_address').removeClass('border-danger');
    });

    $('#ref_tel_no').on('keydown', function() {

        $('#ref_tel_no').removeClass('border-danger');
    });

}
function save_to_db_my_references(){

    let form_data = {

        _token,
        ref_name     : $('#ref_name').val(),
        ref_address  : $('#ref_address').val(),
        ref_tel_no   : $('#ref_tel_no').val(),

    }

    $.ajax({
        url: bpath + 'my/add/references',
        type: "POST",
        data: form_data,
        success: function (response) {

            if(response)
            {
                let data = JSON.parse(response);
                let status = data['status'];

                if(status == 200){

                    $('#dt__reference tbody tr').detach();

                    __notif_show(1, 'Success', 'Added successfully!');
                    load_ref_info();

                    clear_ref_info();

                }
            }
        }
    });

}
function clear_ref_info(){

    $('#ref_name').val("");
    $('#ref_address').val("");
    $('#ref_tel_no').val("");

}
function load_ref_info(){

    $.ajax({
        url: bpath + 'my/load/reference/info',
        type: "POST",
        data: { _token },
        success: function (response) {

            var data = JSON.parse(response);

            let reference_list = data['reference_list'];

            $('#dt__reference tbody tr').detach();

            $('#dt__reference tbody').append(reference_list);

        }
    });
}
function delete_references(){

    $("body").on('click', '.delete_references', function (){

        const child_mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#delete_references_mdl'));
        child_mdl.toggle();

        let reference_id = $(this).data('ref-id');
        $('#mdl_references_input_id').val(reference_id);

    });

    $('body').on('click', '#btn_delete_my_references', function (){

        let reference_id = $('#mdl_references_input_id').val();

        $.ajax({
            url: bpath + 'my/remove/references',
            type: "POST",
            data: { _token, reference_id },
            success: function (response) {

                if(response.status == 200)
                {
                    $('#dt__reference tbody tr').detach();

                    load_ref_info();
                    __notif_show(1, 'Success', 'Removed successfully!');

                    const child_mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#delete_references_mdl'));
                    child_mdl.hide();
                }
            }
        });
    });
}
function update_my_references(){

    $('body').on('click', '.update_my_references', function (){

        let reference_id    = $(this).data('ref-id');
        let reference_name  = $(this).data('ref-name');
        let reference_address = $(this).data('ref-address');
        let reference_tel   = $(this).data('ref-tel');

        const child_mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#add_references_mdl'));
        child_mdl.toggle();

        $('#reference_input_id').val(reference_id);
        $('#ref_name').val(reference_name);
        $('#ref_address').val(reference_address);
        $('#ref_tel_no').val(reference_tel);

        $('#save_ref_info').hide();
        $('#update_ref_info').show();

    });

    $('body').on('click', '#update_ref_info', function (){

        let form_data = {

            _token,
            reference_id : $('#reference_input_id').val(),
            ref_name     : $('#ref_name').val(),
            ref_address  : $('#ref_address').val(),
            ref_tel_no   : $('#ref_tel_no').val(),

        }

        $.ajax({
            url: bpath + 'my/update/references',
            type: "POST",
            data: form_data,
            success: function (response) {
                if(response)
                {
                    let data = JSON.parse(response);
                    let status = data['status'];

                    if(status == 200){

                        $('#dt__reference tbody tr').detach();

                        __notif_show(1, 'Success', 'Added successfully!');
                        load_ref_info();

                        clear_ref_info();
                        const child_mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#add_references_mdl'));
                        child_mdl.hide();

                    }
                }
            }
        });
    });

}
//END:: REFERENCES

//BEGIN:: GOVERNMENT ID'S
function load_government_ID(){

    $.ajax({
        url: bpath + 'my/load/government/id',
        type: "POST",
        data: { _token },
        success: function (response) {

            var data = JSON.parse(response);

            if(data.length > 0) {
                for (var i = 0; i < data.length; i++) {

                    let gvt_issued_id = data[i]['gvt_issued_id'];
                    let id_license_passport_no = data[i]['id_license_passport_no'];
                    let date_place_issuance = data[i]['date_place_issuance'];

                    $('#government_ids').val(gvt_issued_id);
                    $('#government_ids').select2({
                        placeholder: gvt_issued_id,
                        closeOnSelect: true,
                    });
                    $('#government_license_no').val(id_license_passport_no);
                    $('#government_license_issuance').val(date_place_issuance);

                }
            }
        }
    });
}

//END:: GOVERNMENT ID'S

//SAVE ALL PDS DATA TO DB
function save_all_pds_data(){

    $("body").on('click', '#save_PDS_to_db', function (){

        let profile_last_name = $('#profile_last_name').val();
        let profile_first_name = $('#profile_first_name').val();
        let profile_mid_name = $('#profile_mid_name').val();
        let profile_name_extension = $('#profile_name_extension').val();
        let profile_date_birth = $('#profile_date_birth').val();
        let profile_place_birth = $('#profile_place_birth').val();
        let application_gender = $('#application_gender').val();
        let citizenship_country = $('#citizenship_country').val();
        let profile_civil_status = $('#profile_civil_status').val();
        let profile_height = $('#profile_height').val();
        let profile_weight = $('#profile_weight').val();
        let profile_blood_type = $('#profile_blood_type').val();
        let profile_gsis = $('#profile_gsis').val();
        let profile_pagibig = $('#profile_pagibig').val();
        let profile_philhealth = $('#profile_philhealth').val();
        let profile_tin = $('#profile_tin').val();
        let profile_agency = $('#profile_agency').val();
        let profile_tel_number = $('#profile_tel_number').val();
        let profile_mobile_number = $('#profile_mobile_number').val();
        let profile_email = $('#profile_email').val();


        let spouse_surname = $('#fam_spouse_surname').val();
        let spouse_firstname = $('#fam_spouse_first_name').val();
        let spouse_name_ext = $('#fam_spouse_name_ext').val();
        let spouse_mid_name = $('#fam_spouse_mid_name').val();

        let fam_father_surname = $('#fam_father_surname').val();
        let fam_father_first_name = $('#fam_father_first_name').val();
        let fam_father_name_ext = $('#fam_father_name_ext').val();
        let fam_father_mid_name = $('#fam_father_mid_name').val();

        let spouse_occupation = $('#spouse_occupation').val();
        let occupation_employer = $('#occupation_employer').val();
        let occupation_address = $('#occupation_address').val();
        let occupation_tel_no = $('#occupation_tel_no').val();

        let fam_mother_maiden_name = $('#fam_mother_maiden_name').val();
        let fam_mother_surname = $('#fam_mother_surname').val();
        let fam_mother_first_name = $('#fam_mother_first_name').val();
        let fam_mother_mid_name = $('#fam_mother_mid_name').val();

        //Child Name
        let td_input_child_name = [];
        $('input[name="td_input_child_name[]"]').each(function (i, child_name) {
            if(!$(child_name).val() == "")
            {
                td_input_child_name[i] = $(child_name).val();
            }
        });

        //Child Birth Date
        let td_input_child_bdate = [];
        $('input[name="td_input_child_bdate[]"]').each(function (i, child_bdates) {
            if(!$(child_bdates).val() == "")
            {
                td_input_child_bdate[i] = $(child_bdates).val();
            }
        });


        // //Educational Background ID
        // let td_educ_bg_id = [];
        // $('input[name="td_educ_bg_id[]"]').each(function (i, _educ_bg_id) {
        //     if(!$(_educ_bg_id).val() == "")
        //     {
        //         td_educ_bg_id[i] = $(_educ_bg_id).val();
        //     }
        // });
        //
        // //Educational Background Level
        // let td_educ_bg_level = [];
        // $('input[name="td_educ_bg_level[]"]').each(function (i, educ_level) {
        //     if(!$(educ_level).val() == "")
        //     {
        //         td_educ_bg_level[i] = $(educ_level).val();
        //     }
        // });
        //
        // //Name of School
        // let td_educ_school_name = [];
        // $('input[name="td_educ_school_name[]"]').each(function (i, school_name) {
        //     if(!$(school_name).val() == "")
        //     {
        //         td_educ_school_name[i] = $(school_name).val();
        //     }
        // });
        //
        // //Basic Education/Degree/Course
        // let td_educ_degree_course = [];
        // $('input[name="td_educ_degree_course[]"]').each(function (i, educ_degree_course) {
        //     if(!$(educ_degree_course).val() == "")
        //     {
        //         td_educ_degree_course[i] = $(educ_degree_course).val();
        //     }
        // });
        //
        // //Period of Attendance From
        // let td_educ_school_from = [];
        // $('input[name="td_educ_school_from[]"]').each(function (i, attendance_from) {
        //     if(!$(attendance_from).val() == "")
        //     {
        //         td_educ_school_from[i] = $(attendance_from).val();
        //     }
        // });
        //
        // //Period of Attendance To
        // let td_educ_school_to = [];
        // $('input[name="td_educ_school_to[]"]').each(function (i, attendance_to) {
        //     if(!$(attendance_to).val() == "")
        //     {
        //         td_educ_school_to[i] = $(attendance_to).val();
        //     }
        // });
        //
        // //Highest Level/Units Earned
        // let td_educ_highest_level_earned = [];
        // $('input[name="td_educ_highest_level_earned[]"]').each(function (i, educ_highest_level_earned) {
        //     if(!$(educ_highest_level_earned).val() == "")
        //     {
        //         td_educ_highest_level_earned[i] = $(educ_highest_level_earned).val();
        //     }
        // });
        //
        // //Year Graduated
        // let td_educ_educ_year_graduated = [];
        // $('input[name="td_educ_educ_year_graduated[]"]').each(function (i, educ_educ_year_graduated) {
        //     if(!$(educ_educ_year_graduated).val() == "")
        //     {
        //         td_educ_educ_year_graduated[i] = $(educ_educ_year_graduated).val();
        //     }
        // });
        //
        // //Scholarship/Academic Honors Received
        // let td_educ_scholarship = [];
        // $('input[name="td_educ_scholarship[]"]').each(function (i, educ_scholarship) {
        //     if(!$(educ_scholarship).val() == "")
        //     {
        //         td_educ_scholarship[i] = $(educ_scholarship).val();
        //     }
        // });

        // //CAREER SERVICE/ RA 1080 (BOARD/ BAR) UNDER SPECIAL LAWS/ CES/ CSEE BARANGAY ELIGIBILITY / DRIVER'S LICENSE
        // let td_cs_type = [];
        // $('input[name="td_cs_type[]"]').each(function (i, _cs_type) {
        //     if(!$(_cs_type).val() == "")
        //     {
        //         td_cs_type[i] = $(_cs_type).val();
        //     }
        // });
        //
        // //RATING (If Applicable)
        // let td_cs_rating = [];
        // $('input[name="td_cs_rating[]"]').each(function (i, _cs_rating) {
        //     if(!$(_cs_rating).val() == "")
        //     {
        //         td_cs_rating[i] = $(_cs_rating).val();
        //     }
        // });
        //
        // //DATE OF EXAMINATION / CONFERMENT
        // let td_cs_date_exam = [];
        // $('input[name="td_cs_date_exam[]"]').each(function (i, _cs_date_exam) {
        //     if(!$(_cs_date_exam).val() == "")
        //     {
        //         td_cs_date_exam[i] = $(_cs_date_exam).val();
        //     }
        // });
        //
        // //PLACE OF EXAMINATION / CONFERMENT
        // let td_cs_place_exam = [];
        // $('input[name="td_cs_place_exam[]"]').each(function (i, _cs_place_exam) {
        //     if(!$(_cs_place_exam).val() == "")
        //     {
        //         td_cs_place_exam[i] = $(_cs_place_exam).val();
        //     }
        // });
        //
        // //LICENSE NUMBER
        // let td_cs_license_number = [];
        // $('input[name="td_cs_license_number[]"]').each(function (i, _cs_license_number) {
        //     if(!$(_cs_license_number).val() == "")
        //     {
        //         td_cs_license_number[i] = $(_cs_license_number).val();
        //     }
        // });
        //
        // //LICENSE VALIDITY
        // let td_cs_date_validity = [];
        // $('input[name="td_cs_date_validity[]"]').each(function (i, _cs_date_validity) {
        //     if(!$(_cs_date_validity).val() == "")
        //     {
        //         td_cs_date_validity[i] = $(_cs_date_validity).val();
        //     }
        // });

        // //INCLUSIVE DATES From (mm/dd/yyyy)
        // let td_worK_exp_from = [];
        // $('input[name="td_worK_exp_from[]"]').each(function (i, _worK_exp_from) {
        //     if(!$(_worK_exp_from).val() == "")
        //     {
        //         td_worK_exp_from[i] = $(_worK_exp_from).val();
        //     }
        // });
        //
        // //INCLUSIVE DATES To (mm/dd/yyyy)
        // let td_worK_exp_to = [];
        // $('input[name="td_worK_exp_to[]"]').each(function (i, _worK_exp_to) {
        //     if(!$(_worK_exp_to).val() == "")
        //     {
        //         td_worK_exp_to[i] = $(_worK_exp_to).val();
        //     }
        // });
        //
        // //POSITION TITLE (Write in full/Do not abbreviate)
        // let td_worK_exp_pos = [];
        // $('input[name="td_worK_exp_pos[]"]').each(function (i, worK_exp_pos) {
        //     if(!$(worK_exp_pos).val() == "")
        //     {
        //         td_worK_exp_pos[i] = $(worK_exp_pos).val();
        //     }
        // });
        //
        // //DEPARTMENT / AGENCY / OFFICE / COMPANY (Write in full/Do not abbreviate)
        // let td_worK_exp_agency = [];
        // $('input[name="td_worK_exp_agency[]"]').each(function (i, _worK_exp_agency) {
        //     if(!$(_worK_exp_agency).val() == "")
        //     {
        //         td_worK_exp_agency[i] = $(_worK_exp_agency).val();
        //     }
        // });
        //
        // //MONTHLY SALARY
        // let td_worK_exp_sal = [];
        // $('input[name="td_worK_exp_sal[]"]').each(function (i, _worK_exp_sal) {
        //     if(!$(_worK_exp_sal).val() == "")
        //     {
        //         td_worK_exp_sal[i] = $(_worK_exp_sal).val();
        //     }
        // });
        //
        // //SALARY/ JOB/ PAY GRADE (if applicable)& STEP  (Format "00-0")/ INCREMENT
        // let td_worK_exp_sg = [];
        // $('input[name="td_worK_exp_sg[]"]').each(function (i, _worK_exp_sg) {
        //     if(!$(_worK_exp_sg).val() == "")
        //     {
        //         td_worK_exp_sg[i] = $(_worK_exp_sg).val();
        //     }
        // });
        //
        // //STATUS OF APPOINTMENT
        // let td_worK_exp_status = [];
        // $('input[name="td_worK_exp_status[]"]').each(function (i, _worK_exp_status) {
        //     if(!$(_worK_exp_status).val() == "")
        //     {
        //         td_worK_exp_status[i] = $(_worK_exp_status).val();
        //     }
        // });
        //
        // //GOV'T SERVICE (Y/ N)
        // let td_worK_exp_service_type = [];
        // $('input[name="td_worK_exp_service_type[]"]').each(function (i, _worK_exp_service_type) {
        //     if(!$(_worK_exp_service_type).val() == "")
        //     {
        //         td_worK_exp_service_type[i] = $(_worK_exp_service_type).val();
        //     }
        // });
        //
        // //NAME & ADDRESS OF ORGANIZATION (Write in full)
        // let td_vol_work_name = [];
        // $('input[name="td_vol_work_name[]"]').each(function (i, _vol_work_name) {
        //     if(!$(_vol_work_name).val() == "")
        //     {
        //         td_vol_work_name[i] = $(_vol_work_name).val();
        //     }
        // });
        //
        // //INCLUSIVE DATES From (mm/dd/yyyy)
        // let td_vol_work_from = [];
        // $('input[name="td_vol_work_from[]"]').each(function (i, _vol_work_from) {
        //     if(!$(_vol_work_from).val() == "")
        //     {
        //         td_vol_work_from[i] = $(_vol_work_from).val();
        //     }
        // });
        //
        // //INCLUSIVE DATES To (mm/dd/yyyy)
        // let td_vol_work_to = [];
        // $('input[name="td_vol_work_to[]"]').each(function (i, _vol_work_to) {
        //     if(!$(_vol_work_to).val() == "")
        //     {
        //         td_vol_work_to[i] = $(_vol_work_to).val();
        //     }
        // });
        //
        // //NUMBER OF HOURS
        // let td_vol_work_hr_number = [];
        // $('input[name="td_vol_work_hr_number[]"]').each(function (i, _vol_work_hr_number) {
        //     if(!$(_vol_work_hr_number).val() == "")
        //     {
        //         td_vol_work_hr_number[i] = $(_vol_work_hr_number).val();
        //     }
        // });
        //
        // //POSITION / NATURE OF WORK
        // let td_vol_work_nature = [];
        // $('input[name="td_vol_work_nature[]"]').each(function (i, _vol_work_nature) {
        //     if(!$(_vol_work_nature).val() == "")
        //     {
        //         td_vol_work_nature[i] = $(_vol_work_nature).val();
        //     }
        // });
        //
        // //TITLE OF LEARNING AND DEVELOPMENT INTERVENTIONS/TRAINING PROGRAMS (Write in full)
        // let td_ld_title = [];
        // $('input[name="td_ld_title[]"]').each(function (i, _ld_title) {
        //     if(!$(_ld_title).val() == "")
        //     {
        //         td_ld_title[i] = $(_ld_title).val();
        //     }
        // });
        //
        // //INCLUSIVE DATES From (mm/dd/yyyy)
        // let td_ld_date_from = [];
        // $('input[name="td_ld_date_from[]"]').each(function (i, _ld_date_from) {
        //     if(!$(_ld_date_from).val() == "")
        //     {
        //         td_ld_date_from[i] = $(_ld_date_from).val();
        //     }
        // });
        //
        // //INCLUSIVE DATES To (mm/dd/yyyy)
        // let td_ld_date_to = [];
        // $('input[name="td_ld_date_to[]"]').each(function (i, _ld_date_to) {
        //     if(!$(_ld_date_to).val() == "")
        //     {
        //         td_ld_date_to[i] = $(_ld_date_to).val();
        //     }
        // });
        //
        // //NUMBER OF HOURS
        // let td_ld_hr_number = [];
        // $('input[name="td_ld_hr_number[]"]').each(function (i, _ld_hr_number) {
        //     if(!$(_ld_hr_number).val() == "")
        //     {
        //         td_ld_hr_number[i] = $(_ld_hr_number).val();
        //     }
        // });
        //
        // //Type of LD ( Managerial/ Supervisory/Technical/etc)
        // let td_ld_type = [];
        // $('input[name="td_ld_type[]"]').each(function (i, _ld_type) {
        //     if(!$(_ld_type).val() == "")
        //     {
        //         td_ld_type[i] = $(_ld_type).val();
        //     }
        // });
        //
        // // CONDUCTED/ SPONSORED BY (Write in full)
        // let td_ld_sponsor = [];
        // $('input[name="td_ld_sponsor[]"]').each(function (i, _ld_sponsor) {
        //     if(!$(_ld_sponsor).val() == "")
        //     {
        //         td_ld_sponsor[i] = $(_ld_sponsor).val();
        //     }
        // });


        //SPECIAL SKILLS and HOBBIES
        // let td_special_skills = [];
        // $('input[name="td_special_skills[]"]').each(function (i, _special_skills) {
        //     if(!$(_special_skills).val() == "")
        //     {
        //         td_special_skills[i] = $(_special_skills).val();
        //     }
        // });
        //
        // //NON-ACADEMIC DISTINCTIONS / RECOGNITION (Write in full)
        // let td_others_distinction = [];
        // $('input[name="td_others_distinction[]"]').each(function (i, _others_distinction) {
        //     if(!$(_others_distinction).val() == "")
        //     {
        //         td_others_distinction[i] = $(_others_distinction).val();
        //     }
        // });
        //
        // //MEMBERSHIP IN ASSOCIATION/ORGANIZATION (Write in full)
        // let td_others_membership = [];
        // $('input[name="td_others_membership[]"]').each(function (i, _others_membership) {
        //     if(!$(_others_membership).val() == "")
        //     {
        //         td_others_membership[i] = $(_others_membership).val();
        //     }
        // });
        // SPECIAL SKILLS HERE

        // //REFERENCES
        // let td_ref_full_name = [];
        // $('input[name="td_ref_full_name[]"]').each(function (i, _ref_full_name) {
        //     if(!$(_ref_full_name).val() == "")
        //     {
        //         td_ref_full_name[i] = $(_ref_full_name).val();
        //     }
        // });
        //
        // let td_ref_address = [];
        // $('input[name="td_ref_address[]"]').each(function (i, _ref_address) {
        //     if(!$(_ref_address).val() == "")
        //     {
        //         td_ref_address[i] = $(_ref_address).val();
        //     }
        // });
        //
        // let td_ref_tel_no = [];
        // $('input[name="td_ref_tel_no[]"]').each(function (i, _ref_tel_no) {
        //     if(!$(_ref_tel_no).val() == "")
        //     {
        //         td_ref_tel_no[i] = $(_ref_tel_no).val();
        //     }
        // });
        // //REFERENCES

        //  Other Information Here
        let others_34_b_yes = $('#others_34_b_yes').val();
        let others_35_a_yes = $('#others_35_a_yes').val();
        let others_35_b_yes = $('#others_35_b_yes').val();
        let others_35_b_status_case = $('#others_35_b_status_case').val();
        let others_35_b_date_filed = $('#others_35_b_date_filed').val();
        let others_36_yes = $('#others_36_yes').val();
        let others_37_yes = $('#others_37_yes').val();
        let others_38_a_yes = $('#others_38_a_yes').val();
        let others_38_b_yes = $('#others_38_b_yes').val();
        let others_39_yes = $('#others_39_yes').val();
        let others_40_a_yes = $('#others_40_a_yes').val();
        let others_40_b_yes = $('#others_40_b_yes').val();
        let others_40_c_yes = $('#others_40_c_yes').val();
        //  Other Information Here

        //GOVERNMENT ID'S
        let government_id = $('#government_ids').val();
        // let government_id = $( "#government_ids option:selected" ).text();
        let government_license_no = $('#government_license_no').val();
        let government_license_issuance = $('#government_license_issuance').val();
        //GOVERNMENT ID'S

        let form_data = {

            _token,

            //PERSONAL INFO HERE
               profile_last_name,
               profile_first_name,
               profile_mid_name,
               profile_name_extension,
               profile_date_birth,
               profile_place_birth,
               application_gender,
               citizenship_value, citizenship_type_value, citizenship_country,
               profile_civil_status,
               profile_height,
               profile_weight,
               profile_blood_type,
               profile_gsis,
               profile_pagibig,
               profile_philhealth,
               profile_tin,
               profile_agency,
               profile_tel_number,
               profile_mobile_number,
               profile_email,
            //PERSONAL INFO HERE


            //MY ADDRESS HERE
                //RESIDENTIAL ADDRESS
                res_address_type : "RESIDENTIAL",
                res_house_block : $('#res_house_block').val(),
                res_street : $('#res_street').val(),
                res_sub : $('#res_sub').val(),

                res_bgry : $('.ref_brgy').val(),
                res_city_mun : $('.ref_city_mun').val(),
                res_province : $('.ref_province').val(),
                res_zip_code : $('#res_zip_code').val(),

                //RESIDENTIAL ADDRESS

                //PERMANENT ADDRESS
                per_address_type : "PERMANENT",
                per_house_block : $('#per_house_block').val(),
                per_street : $('#per_street').val(),
                per_sub : $('#per_sub').val(),

                per_bgry : $('.per_brgy').val(),
                per_city_mun : $('.per_city_mun').val(),
                per_province : $('.per_province').val(),
                per_zip_code : $('#per_zip_code').val(),
                //RESIDENTIAL ADDRESS

            //MY ADDRESS HERE

            // FAMILY BACKGROUND HERE
            spouse_surname, spouse_mid_name,
            spouse_firstname, spouse_name_ext,
            fam_father_surname, fam_father_first_name,
            fam_father_name_ext, fam_father_mid_name,
            spouse_occupation, occupation_employer,
            occupation_address, occupation_tel_no,
            fam_mother_maiden_name, fam_mother_surname,
            fam_mother_first_name, fam_mother_mid_name,
            td_input_child_name, td_input_child_bdate,
            // FAMILY BACKGROUND HERE


            // // EDUCATIONAL BACKGROUND HERE
            // td_educ_bg_id,
            // td_educ_bg_level,
            // td_educ_school_name,
            // td_educ_degree_course,
            // td_educ_school_from,
            // td_educ_school_to,
            // td_educ_highest_level_earned,
            // td_educ_educ_year_graduated,
            // td_educ_scholarship,
            // // EDUCATIONAL BACKGROUND HERE

            // //  CIVIL SERVICE HERE
            // td_cs_type,
            // td_cs_rating,
            // td_cs_date_exam,
            // td_cs_place_exam,
            // td_cs_license_number,
            // td_cs_date_validity,
            // //  CIVIL SERVICE HERE


            // // WORK EXPERIENCE HERE
            // td_worK_exp_from,
            // td_worK_exp_to,
            // td_worK_exp_pos,
            // td_worK_exp_agency,
            // td_worK_exp_sal,
            // td_worK_exp_sg,
            // td_worK_exp_status,
            // td_worK_exp_service_type,
            // // WORK EXPERIENCE HERE
            //
            //
            // // VOLUNTARY WORK HERE
            // td_vol_work_name,
            // td_vol_work_from,
            // td_vol_work_to,
            // td_vol_work_hr_number,
            // td_vol_work_nature,
            // // VOLUNTARY WORK HERE
            //
            //
            // // LEARNING AND DEVELOPMENT HERE
            // td_ld_title,
            // td_ld_date_from,
            // td_ld_date_to,
            // td_ld_hr_number,
            // td_ld_type,
            // td_ld_sponsor,
            // // LEARNING AND DEVELOPMENT HERE


            // // SPECIAL SKILLS FORM DATA HERE
            // td_special_skills,
            // td_others_distinction,
            // td_others_membership,
            // // SPECIAL SKILLS FORM DATA HERE


            // OTHER INFO FORM DATA HERE
            cb_34_a,
            cb_34_b, others_34_b_yes,
            cb_35_a, others_35_a_yes,

            cb_35_b, others_35_b_yes,others_35_b_status_case,others_35_b_date_filed,

            cb_36, others_36_yes,
            cb_37, others_37_yes,
            cb_38_a, others_38_a_yes,
            cb_38_b, others_38_b_yes,
            cb_39, others_39_yes,
            cb_40_a, others_40_a_yes,
            cb_40_b, others_40_b_yes,
            cb_40_c, others_40_c_yes,
            // OTHER INFO FORM DATA HERE

            // //REFERENCES HERE
            //     td_ref_full_name, td_ref_address, td_ref_tel_no,
            // //REFERENCES HERE

            //GOVERNMENT ID'S
                government_id, government_license_no, government_license_issuance,
            //GOVERNMENT ID'S
        }


        $.ajax({
            url: bpath + 'my/save/pds',
            type: "POST",
            data: form_data,
            success: function (response) {

                __notif_show(1, 'Success', 'PDS updated successfully!');

                load_personal_information();
                clear_educ_bg_inputs();

                //MY ADDRESS HERE
                load_residential_address();
                load_permanent_address();
                //MY ADDRESS HERE


                // FAMILY BACKGROUND HERE
                $('#table_name_of_child tbody tr').detach();
                get_family_bg();
                // FAMILY BACKGROUND HERE


                // // EDUCATIONAL BACKGROUND HERE
                // $('#dt__educational_bg_new tbody tr').detach();
                // load_educational_bg();
                // clear_educ_bg_inputs();
                // // EDUCATIONAL BACKGROUND HERE


                // //  CIVIL SERVICE HERE
                // $('#dt__civil_service tbody tr').detach();
                // load_civil_service_eligibility();
                // clear_cs_inputs();
                // //  CIVIL SERVICE HERE
                //
                //
                // // WORK EXPERIENCE HERE
                // $('#dt__work_exp tbody tr').detach();
                // load_added_work_exp();
                // // WORK EXPERIENCE HERE
                //
                //
                // // VOLUNTARY WORK HERE
                // $('#dt__voluntary tbody tr').detach();
                // load_added_vol_work();
                // // VOLUNTARY WORK HERE
                //
                //
                // // LEARNING AND DEVELOPMENT HERE
                // $('#dt__LD tbody tr').detach();
                // load_added_learning_development();
                // // LEARNING AND DEVELOPMENT HERE
                //
                //
                // // SPECIAL SKILLS HERE
                // $('#dt__special_skill tbody tr').detach();
                // load_added_special_skills();
                // // SPECIAL SKILLS HERE


                // OTHER INFO HERE
                load_other_infos();

                //REFERENCES
                // load_ref_info();
                load_government_ID();
            }
        });

    });

}

function same_address(){

    $('body').on('click', '#btn_same_address', function (){

        let res_province_code = $('.ref_province').val();
        let res_province_ = $( ".ref_province option:selected" ).text();

        let res_city_mun_code = $('.ref_city_mun').val();
        let res_city_mun_ = $( ".ref_city_mun option:selected" ).text();

        let res_brgy_code = $('.ref_brgy').val();
        let res_brgy_ = $( ".ref_brgy option:selected" ).text();


        let res_house_no = $('#res_house_block').val();
        let res_street   = $('#res_street').val();
        let res_subd     = $('#res_sub').val();
        let res_zipcode  = $('#res_zip_code').val();

        $('.per_province').val(res_province_code);
        $('.per_province').select2({
            placeholder: res_province_,
            closeOnSelect: true,
        });

        $('.per_city_mun').val(res_city_mun_code);
        $('.per_city_mun').select2({
            placeholder: res_city_mun_,
            closeOnSelect: true,
        });

        load_dynamic_city_mun(res_province_code, res_city_mun_code);
        load_dynamic_brgy(res_city_mun_code, res_brgy_code);

        $('#per_house_block').val(res_house_no);
        $('#per_street').val(res_street);
        $('#per_sub').val(res_subd);
        $('#per_zip_code').val(res_zipcode);

    });

}

