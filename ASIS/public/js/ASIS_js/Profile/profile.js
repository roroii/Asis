var  _token = $('meta[name="csrf-token"]').attr('content');
var bpath;

// Initialize current step
var currentStep = 1;
var stepLabels = ["Personal Information", "Residential Address", "Permanent Address"];

$(document).ready(function (){

    bpath = __basepath + "/";

    loadPersonalInformation();

    toggle_show_password();


    updateProfilePicture();

    filePondInstance();
    select2Instance();
    populateAddresses();

    enrolleesUpdateProfileInformation();
    enrolleesUpdateAccountSettings();


    setupAccountWizard();

});

function select2Instance(){

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

}

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

function loadPersonalInformation(){

    $.ajax({
        url: bpath + 'get/profile',
        type: "POST",
        data: { _token, },
        success: function(response) {

            if(response)
                {

                    let data = JSON.parse(response);
                    let first_name = data['first_name'];
                    let last_name = data['last_name'];
                    let profile_pic = data['profile_pic'];
                    let middle_name = data['middle_name'];
                    let name_ext = data['name_ext'];
                    let password = data['password'];
                    let username = data['username'];
                    let _email = data['email'];
                    let email = '';

                    let per_province    = data['per_province'];
                    let per_city_mun    = data['per_city_mun'];
                    let per_barangay    = data['per_barangay'];
                    let per_sub_village = data['per_sub_village'];
                    let per_street      = data['per_street'];
                    let per_house_lot   = data['per_house_lot_no'];
                    let per_zip_code    = data['per_zip_code'];

                    let res_province    = data['res_province'];
                    let res_city_mun    = data['res_city_mun'];
                    let res_barangay    = data['res_barangay'];
                    let res_sub_village = data['res_sub_village'];
                    let res_street      = data['res_street'];
                    let res_house_lot   = data['res_house_lot_no'];
                    let res_zip_code    = data['res_zip_code'];

                    fillAddressFields(per_province,
                            per_city_mun,
                            per_barangay,
                            per_sub_village,
                            per_street,
                            per_house_lot,
                            per_zip_code,
                            res_province,
                            res_city_mun,
                            res_barangay,
                            res_sub_village,
                            res_street,
                            res_house_lot,
                            res_zip_code
                    );

                    if(_email === null || _email === '')
                    {
                        email = username;
                    }else
                    {
                        email = _email;
                    }


                    let html_data_1 = '<div class="sm:whitespace-normal font-medium text-lg">'+first_name+" "+middle_name+" "+last_name+'</div>'+
                        '<div class="text-slate-500">'+email+'</div>';

                    let html_data_2 = '<img id="profile_picture_holder" data-action="zoom" class="rounded-full zoom-in" alt="Relax" src="'+profile_pic+'">';
                        // '<a id="btn_update_profile_picture" href="javascript:;" class="absolute mb-1 mr-1 flex items-center justify-center bottom-0 right-0 bg-primary rounded-full p-2"> <i class="fa-solid fa-camera w-4 h-4 text-white"></i> </a>';

                    $('#profile_name').html(html_data_1);
                    $('#profile_pic_div').html(html_data_2);

                    $('#account_email').val(email);
                    $('#account_password').val(password);


                    $('.profile_firstname').val(first_name);
                    $('.profile_midname').val(middle_name);
                    $('.profile_lastname').val(last_name);
                    $('.profile_ext').val(name_ext);
                }
            }
        });
}

function updateProfilePicture(){

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


}

function filePondInstance(){

    // Register the plugin
    FilePond.registerPlugin(
        // validates the size of the file

        FilePondPluginImagePreview,
        FilePondPluginFileValidateSize,
        FilePondPluginFileValidateType,

    );

    const update_profile_pic_inputElement = document.querySelector('input[id="up_profile_pic"]');

    const update_profile_pic_pond = FilePond.create((update_profile_pic_inputElement), {

        credits: false,
        allowMultiple: false,
        allowFileTypeValidation: true,
        acceptedFileTypes: ['image/*'],

    });

    update_profile_pic_pond.setOptions({
        server: {
            process: "/my/temp/profile/upload",
            revert: "/my/temp/profile/delete",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        },
    });

    function remove_Update_UploadedProfile_pic() {
        if (update_profile_pic_pond) {
            var files = update_profile_pic_pond.getFiles();
            if (files.length > 0) {
                update_profile_pic_pond.processFiles().then(() => {
                    update_profile_pic_pond.removeFiles();
                    // console.log('Removed');
                });
            }
        }
    }

    function save_profile_picture(){

        $('#form_profile_picture').submit(function (event){
            event.preventDefault();

            var form = $(this);

            $.ajax({
                type: "POST",
                url: bpath + 'my/save/profile/picture',
                data: form.serialize(),
                success: function (response) {

                    if(response.status == 200)
                    {
                        __notif_show(1, "Success", "Profile picture updated successfully!");

                        // load_profile_picture();
                        location.reload();
                        remove_Update_UploadedProfile_pic();

                        const modal = tailwind.Modal.getOrCreateInstance(document.querySelector('#update_profile_picture_mdl'));
                        modal.hide();


                    } else {

                        __notif_show(-1, "Warning", "OOps! Something went wrong!");
                    }
                }
            });
        });

    }

}

function enrolleesUpdateProfileInformation(){

    $('body').on('click', '#btn_save_profile_information', function(){

        let input_fields = [
            '.profile_firstname',
            '.profile_midname',
            '.profile_lastname',
            '.ref_province',
            '.ref_city_mun',
            '.ref_brgy',
            '#res_sub',
            '#res_street',
            '#res_house_block',
            '#res_zip_code',
            '.per_province',
            '.per_city_mun',
            '.per_brgy',
            '#per_sub',
            '#per_street',
            '#per_house_block',
            '#per_zip_code',
        ];

        let isValid = true;

        // Iterate through each field
        input_fields.forEach(function(field) {
            let value = $(field).val();
            // Check if the field is empty
            if (value.trim() === '') {
                // Add red border to the empty field
                $(field).addClass('border-danger');
                // Set isValid to false
                isValid = false;
            } else {
                // Remove red border if the field is not empty
                $(field).removeClass('border-danger');
            }
        });

        // If any field is empty, show SweetAlert
        if (!isValid) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please fill in all the required fields!',
            });
        } else {
            let form_data = {

                _token,
                profile_firstname   : $('.profile_firstname').val(),
                profile_midname     : $('.profile_midname').val(),
                profile_lastname    : $('.profile_lastname').val(),
                profile_ext         : $('.profile_ext').val(),

                res_address_type: $('.res_address_type').val(),
                ref_province    : $('.ref_province').val(),
                ref_city_mun    : $('.ref_city_mun').val(),
                ref_brgy        : $('.ref_brgy').val(),
                res_sub         : $('#res_sub').val(),
                res_street      : $('#res_street').val(),
                res_house_block : $('#res_house_block').val(),
                res_zip_code    : $('#res_zip_code').val(),

                per_address_type: $('.per_address_type').val(),
                per_province    : $('.per_province').val(),
                per_city_mun    : $('.per_city_mun').val(),
                per_brgy        : $('.per_brgy').val(),
                per_sub         : $('#per_sub').val(),
                per_street      : $('#per_street').val(),
                per_house_block : $('#per_house_block').val(),
                per_zip_code    : $('#per_zip_code').val(),

            }

            $.ajax({
                url: bpath + 'update/profile/information',
                type: "POST",
                data: form_data,
                success: function(response) {

                    if(response)
                    {
                        let data = JSON.parse(response);
                        let status = data['status'];
                        let title = data['title'];
                        let message = data['message'];

                        Swal.fire({
                            icon: status,
                            title: title,
                            text: message,
                        });

                        loadPersonalInformation();
                    }
                }
            });
        }
    });
}

function enrolleesUpdateAccountSettings(){

    $('body').on('click', '#btn_save_account_settings', function(){


        var passwordInput = $("#account_password");
        var passwordValue = $.trim(passwordInput.val());

        if (passwordValue === "" || passwordValue.length < 8) {
            // If the password is empty or less than 8 characters, show a SweetAlert2 warning message
            Swal.fire({
                icon: 'warning',
                title: 'Ooops!',
                text: passwordValue === '' ? 'Password cannot be empty!' : 'Password does not meet the minimum requirements!',
            });
            passwordInput.css("border-color", "red");

        } else {
            // If the password is not empty and has at least 8 characters, proceed with your logic (AJAX or other actions)
            let form_data = {

                _token,
                account_email       : $('#account_email').val(),
                account_password    : $('#account_password').val(),

            }
            $.ajax({
                url: bpath + 'update/account/settings',
                type: "POST",
                data: form_data,
                success: function(response) {

                    if(response)
                    {
                        let data = JSON.parse(response);
                        let status = data['status'];
                        let title = data['title'];
                        let message = data['message'];

                        Swal.fire({
                            icon: status,
                            title: title,
                            text: message,
                        });

                        loadPersonalInformation();
                    }
                }
            });
        }
    });
}

function populateAddresses(){

    $('.per_province').on('select2:select', function (e) {

        let provCode = $(this).val();

        $.ajax({
            url: bpath + 'get/address/province',
            type: "POST",
            data: {_token, provCode,},
            success: function (response) {

                if(response)
                {
                    let data = JSON.parse(response);
                    let per_city_mun_val = data['municipality_option'];
                    let per_brgy_val = data['brgy_option'];

                    $('.per_city_mun').html(per_city_mun_val);
                    $('.per_brgy').html(per_brgy_val);
                }
            }
        });

    });
    $('.ref_province').on('select2:select', function (e) {

        let provCode = $(this).val();

        $.ajax({
            url: bpath + 'get/address/province',
            type: "POST",
            data: {_token, provCode,},
            success: function (response) {

                if(response)
                {
                    let data = JSON.parse(response);
                    let per_city_mun_val = data['municipality_option'];
                    let per_brgy_val = data['brgy_option'];

                    $('.ref_city_mun').html(per_city_mun_val);
                    $('.ref_brgy').html(per_brgy_val);
                }
            }
        });

    });

    $('.per_city_mun').on('select2:select', function (e) {

        let city_munCode = $(this).val();

        $.ajax({
            url: bpath + 'get/address/municipality',
            type: "POST",
            data: {_token, city_munCode,},
            success: function (response) {

                if(response)
                {
                    let data = JSON.parse(response);
                    let ref_province = data['province_option'];
                    let ref_brgy_val = data['brgy_option'];

                    // $('.per_province').html(ref_province);
                    $('.per_brgy').html(ref_brgy_val);
                }
            }
        });

    });
    $('.ref_city_mun').on('select2:select', function (e) {

        let city_munCode = $(this).val();

        $.ajax({
            url: bpath + 'get/address/municipality',
            type: "POST",
            data: {_token, city_munCode,},
            success: function (response) {

                if(response)
                {
                    let data = JSON.parse(response);
                    let ref_province = data['province_option'];
                    let ref_brgy_val = data['brgy_option'];

                    // $('.ref_province').html(ref_province);
                    $('.ref_brgy').html(ref_brgy_val);
                }
            }
        });

    });

    $('body').on('click', '#btn_same_address', function(){

        alert('TAE');
    });
}

function fillAddressFields(per_province, per_city_mun, per_barangay, per_sub_village, per_street, per_house_lot, per_zip_code, res_province, res_city_mun, res_barangay, res_sub_village, res_street, res_house_lot, res_zip_code){

        $('.ref_province').val(res_province).trigger('change');
        $('.ref_city_mun').val(res_city_mun).trigger('change');
        $('.ref_brgy').val(res_barangay).trigger('change');
        $('#res_sub').val(res_sub_village);
        $('#res_street').val(res_street);
        $('#res_house_block').val(res_house_lot);
        $('#res_zip_code').val(res_zip_code);

        $('.per_province').val(per_province).trigger('change');
        $('.per_city_mun').val(per_city_mun).trigger('change');
        $('.per_brgy').val(per_barangay).trigger('change');
        $('#per_sub').val(per_sub_village);
        $('#per_street').val(per_street);
        $('#per_house_block').val(per_house_lot);
        $('#per_zip_code').val(per_zip_code);


        $.ajax({
            type: 'POST',
            url: bpath + 'get/res/address/barangay',
            data: { _token, per_city_mun, res_city_mun }
        }).
        then(function (response) {

            if(response) {

                let data = JSON.parse(response);

                let option_value = data['option_value'];
                let brgy_id = data['brgy_id'];

                $('.ref_brgy').html(option_value);
                $('.ref_brgy').val(res_barangay).trigger('change');

            }
        });

        $.ajax({
            type: 'POST',
            url: bpath + 'get/per/address/barangay',
            data: { _token, per_city_mun, res_city_mun }
        }).
        then(function (response) {

            if(response) {

                let data = JSON.parse(response);

                let option_value = data['option_value'];
                let brgy_id = data['brgy_id'];

                $('.per_brgy').html(option_value);
                $('.per_brgy').val(per_barangay).trigger('change');

            }
        });

}


function setupAccountWizard(){


    // Initial setup
    updateButtonHighlights();
    showHideSteps(currentStep);

    //UPPERCASE ALL TEXT INSIDE THE PERSONAL INFO DIV
    upperCaseTextFields('personalInfoDiv');
    upperCaseTextFields('residentialAddressDiv');
    upperCaseTextFields('permanentAddressDiv');

    // Next button click event
    $(".btn_next").on("click", function () {

        if (currentStep === 1) {
            // Validate personalInfoDiv fields before proceeding to the next step
            if (!validatePersonalInfo()) {
                // Display an alert or message for invalid fields

                Swal.fire({
                    icon: 'warning',
                    title: 'Missing Inputs',
                    text: 'Please fill in all required fields!',
                });
                return;
            }
        }

        if (currentStep === 2) {

            $(this).text("Save");

            // Validate personalInfoDiv fields before proceeding to the next step
            if (!validateResidentialAddress()) {
                // Display an alert or message for invalid fields

                Swal.fire({
                    icon: 'warning',
                    title: 'Missing Inputs',
                    text: 'Please fill in all required fields!',
                });
                return;
            }
        }

        if (currentStep === 3) {

            // Validate personalInfoDiv fields before proceeding to the next step
            if (!validatePermanentAddress()) {
                // Display an alert or message for invalid fields

                Swal.fire({
                    icon: 'warning',
                    title: 'Missing Inputs',
                    text: 'Please fill in all required fields!',
                });
                return;
            }else {

                saveDataAJAX();

            }


        }

        if (currentStep < 3) {
            currentStep++;
            updateButtonHighlights();
            showHideSteps(currentStep);
            updateStepLabel(currentStep);
        }

    });

    // Previous button click event
    $(".btn_previous").on("click", function () {

        if (currentStep > 1) {

            $('.btn_next').text("Next");
            currentStep--;
            updateButtonHighlights();
            showHideSteps(currentStep);
            updateStepLabel(currentStep);
        }
    });


}

// Function to update button highlights
function updateButtonHighlights() {
    $(".btn_selected_div").removeClass("btn-primary bg-slate-100 dark:bg-darkmode-400 dark:border-darkmode-400 text-slate-500");
    $(".btn_selected_div:nth-child(" + currentStep + ")").addClass("btn-primary");
}

// Function to show/hide wizard steps
function showHideSteps(step) {
    $(".wizard-step").hide();
    $(".wizard-step:nth-child(" + step + ")").show();

    // Hide all address divs initially
    $("#residentialAddressDiv").hide();
    $("#permanentAddressDiv").hide();

    // Unhide specific address div based on the step
    if (step === 1) {

        $("#personalInfoDiv").show();
        $("#residentialAddressDiv").hide();
        $("#permanentAddressDiv").hide();

    } else if (step === 2) {

        $("#residentialAddressDiv").show();
        $("#personalInfoDiv").hide();
        $("#permanentAddressDiv").hide();

    } else if (step === 3) {

        $("#permanentAddressDiv").show();
        $("#personalInfoDiv").hide();
        $("#residentialAddressDiv").hide();

    }
}


// Function to update step label
function updateStepLabel(step) {
    $(".Setup_label").text(stepLabels[step - 1]);
}


// Function to validate fields in a given div
function validateFields(divId) {
    var isValid = true;

    // Check each input field in the specified div
    $("#" + divId + " input").each(function () {
        if ($(this).val().trim() === "") {
            isValid = false;
            // Add danger border to empty fields
            $(this).addClass("border-danger");
        } else {
            // Remove danger border if field is not empty
            $(this).removeClass("border-danger");
        }
    });

    return isValid;
}

// Function to validate personalInfoDiv fields
function validatePersonalInfo() {
    return validateFields("personalInfoDiv");
}

// Function to validate residentialAddressDiv fields
function validateResidentialAddress() {
    return validateFields("residentialAddressDiv");
}

// Function to validate permanentAddressDiv fields
function validatePermanentAddress() {
    return validateFields("permanentAddressDiv");
}

function upperCaseTextFields(divId){

    // Add an event listener for the "input" event on all inputs within personalInfoDiv
    $("#" + divId + " input").on("input", function(){
        // Get the current value of the input
        var inputValue = $(this).val();

        // Convert the value to uppercase
        var uppercaseValue = inputValue.toUpperCase();

        // Set the uppercase value as the new value of the input
        $(this).val(uppercaseValue);
    });

}

//Function to Save DATA on DATABASE using AJAX
function saveDataAJAX(){

    let form_data = {

        _token,
        profile_firstname   : $('.profile_firstname').val(),
        profile_midname     : $('.profile_midname').val(),
        profile_lastname    : $('.profile_lastname').val(),
        profile_ext         : $('.profile_ext').val(),

        res_address_type: $('.res_address_type').val(),
        ref_province    : $('.ref_province').val(),
        ref_city_mun    : $('.ref_city_mun').val(),
        ref_brgy        : $('.ref_brgy').val(),
        res_sub         : $('#res_sub').val(),
        res_street      : $('#res_street').val(),
        res_house_block : $('#res_house_block').val(),
        res_zip_code    : $('#res_zip_code').val(),

        per_address_type: $('.per_address_type').val(),
        per_province    : $('.per_province').val(),
        per_city_mun    : $('.per_city_mun').val(),
        per_brgy        : $('.per_brgy').val(),
        per_sub         : $('#per_sub').val(),
        per_street      : $('#per_street').val(),
        per_house_block : $('#per_house_block').val(),
        per_zip_code    : $('#per_zip_code').val(),

    }

    $.ajax({
        url: bpath + 'update/profile/information',
        type: "POST",
        data: form_data,
        beforeSend: function () {

            $('.btn_next').html('Saving <svg width="25" viewBox="-2 -2 42 42" xmlns="http://www.w3.org/2000/svg" stroke="white" class="w-4 h-4 ml-2"> <g fill="none" fill-rule="evenodd"> <g transform="translate(1 1)" stroke-width="4"> <circle stroke-opacity=".5" cx="18" cy="18" r="18"></circle><path d="M36 18c0-9.94-8.06-18-18-18"><animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="1s" repeatCount="indefinite"></animateTransform></path> </g></g> </svg>');
            $('.btn_next').prop('disabled', true);
        },
        success: function(response) {

            if(response)
            {
                // let data = JSON.parse(response);
                // let status = data['status'];
                // let title = data['title'];
                // let message = data['message'];
                //
                // Swal.fire({
                //     icon: status,
                //     title: title,
                //     text: message,
                // });
                //
                // loadPersonalInformation();

                location.reload();
            }
        },
        complete: function(){

            $('.btn_next').html('Save');
            $('.btn_next').prop('disabled', false);

        },
    });

}
