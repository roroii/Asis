

$(document).ready(function () {

    bpath = __basepath + "/";
    load_datatable();
    load_accounts();
    load_user_id();
    reload_dropdowns();

});


var _token = $('meta[name="csrf-token"]').attr('content');
var user_id_global;
var tbldata_manage_users;
var modal_designation_id;
var modal_position_id;
var modal_rc_id;
var modal_employee_id;
var modal_employment_type;
var modal_employee_status;

$(document).on('select2:open', function (e) {
    document.querySelector(`[aria-controls="select2-${e.target.id}-results"]`).focus();
});

function load_datatable() {

    try {
        /***/
        tbldata_manage_users = $('#dt__manage_users').DataTable({
            dom:
                "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-6 text_left_1'l><'intro-y col-span-6 text_left_1'f>>" +
                "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-12'tr>>" +
                "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-12'<'datatable_paging_1'p>>>",
            renderer: 'bootstrap',
            "info": false,
            "bInfo": true,
            "bJQueryUI": true,
            "bProcessing": true,
            "bPaginate": true,
            "aLengthMenu": [[10, 25, 50, 100, 150, 200, 250, 300, -1], [10, 25, 50, 100, 150, 200, 250, 300, "All"]],
            "iDisplayLength": 10,
            "aaSorting": [],

            columnDefs:
                [
                    { className: "dt-head-center", targets: [6] },
                ],

        }).on("draw", function () {
            //console.log("drawing");
            if (!tbldata_manage_users.data().any()) {
                $("#dt__manage_users").children().hide();
            } else {
                $("#dt__manage_users").children().show();
            }
        });


        modal_designation_id = $('#modal_designation_id').select2({
            placeholder: "Select Designation",
            allowClear: true,
            closeOnSelect: false,
        });

        modal_position_id = $('#modal_position_id').select2({
            placeholder: "Select Position",
            allowClear: true,
            closeOnSelect: false,
        });

        modal_rc_id = $('#modal_rc_id').select2({
            placeholder: "Select Responsibility Center",
            allowClear: true,
            closeOnSelect: false,
        });

        modal_employee_id = $('#modal_employee_id').select2({
            allowClear: true,
            closeOnSelect: false,
        });


        /***/
    } catch (err) { }
}

function reload_dropdowns() {


    modal_designation_id = $('#modal_designation_id').select2({
        placeholder: "Select Designation",
        allowClear: true,
        closeOnSelect: false,
    });

    modal_position_id = $('#modal_position_id').select2({
        placeholder: "Select Position",
        allowClear: true,
        closeOnSelect: false,
    });

    modal_rc_id = $('#modal_rc_id').select2({
        placeholder: "Select Responsibility Center",
        allowClear: true,
        closeOnSelect: false,
    });

    modal_employee_id = $('#modal_employee_id').select2({
        allowClear: true,
        closeOnSelect: false,
    });

    modal_employment_type = $('#modal_employment_type').select2({
        allowClear: true,
        closeOnSelect: false,
    });

    modal_employee_status = $('#modal_employee_status').select2({
        allowClear: true,
        closeOnSelect: false,
    });

}

function load_accounts(filter_data) {
    showLoading();
    $.ajax({
        url: bpath + 'admin/manage/user/load',
        type: "POST",
        data: {
            _token: _token,
            filter_data: filter_data,
        },
        success: function (data) {
            tbldata_manage_users.clear().draw();
            /***/
            var data = JSON.parse(data);
            if (data.length > 0) {
                for (var i = 0; i < data.length; i++) {

                    /***/
                    var account_id = data[i]['account_id'];
                    var agency_id = data[i]['agency_id'];
                    var name = data[i]['name'];
                    var deleted = data[i]['deleted'];
                    var last_seen = data[i]['last_seen'];
                    var username = data[i]['username'];
                    var can_delete = data[i]['can_delete'];
                    var read = 1;

                    var cd = "";
                    /***/

                    cd = '' +
                        '<tr >' +

                        '<td style="display: none">' +

                        '<input class="form-check-input user_check[]" name="user_check" type="checkbox" value="' + agency_id + '" id="user_check[]" >' +

                        '</td>' +

                        '<td style="display: none" class="user_id">' +
                        agency_id +
                        '</td>' +

                        '<td class="w-auto">' +
                        name +
                        '</td>' +

                        '<td> ' +
                        last_seen +
                        '</td>' +

                        '<td>' +
                        deleted +
                        '</td>' +

                        '<td>' +
                        '<span class="text">' + username + '</span>' +
                        '</td>' +

                        '<td class="w-auto">' +
                        '<div class="flex justify-center items-center">' +
                        '<a id="account_details_btn" href="javascript:;" data-usr-id="' + account_id + '"  class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip" title="Details"><i class="fa fa-info text-slate-500 text-success"></i></a>' +
                        '<div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="More Action">' +
                        '<a class="flex justify-center items-center" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h items-center text-center text-primary"></i> </a>' +
                        '<div id="account_action_dropdown" class="dropdown-menu w-40">' +
                        '<div class="dropdown-content">' +
                        '<a id="btn_showIncomingDetails" href="javascript:;" class="dropdown-item" data-usr-id="' + account_id + '"> <i class="fa fa-tasks w-4 h-4 mr-2 text-success"></i> Details </a>' +
                        can_delete +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</td>' +

                        '</tr>' +
                        '';

                    tbldata_manage_users.row.add($(cd)).draw();


                    /***/

                }

            }
            hideLoading();
        }

    });
}

function load_user_id(user_id) {

    showLoading();

    $.ajax({
        url: bpath + 'admin/manage/user/load/id',
        type: "POST",
        data: {
            _token: _token,
            user_id: user_id,
        },
        success: function (data) {
            var data = JSON.parse(data);

            $('#div_user_details').empty();
            $('#div_user_profile').empty();
            $('#div_user_employment').empty();

            $('#filer_Active').empty();
            $('#filer_Inactive').empty();
            $('#filer_ActiveToday').empty();
            $('#filer_Users').empty();
            $('#filer_Employees').empty();
            $('#filer_Applicants').empty();
            $('#filer_Admin').empty();
            $('#filer_Unused').empty();

            $('#div_user_details').append(data.user_info);
            $('#div_user_profile').append(data.profile_info);
            $('#div_user_employment').append(data.employment_info);

            $('#filer_Active').append(data.accounts_Active + ' User(s)');
            $('#filer_Inactive').append(data.accounts_Inactive + ' User(s)');
            $('#filer_ActiveToday').append(data.accounts_ActiveToday + ' User(s)');
            $('#filer_Users').append(data.accounts_Users + ' User(s) / ' + data.accounts_UsersRemoved + ' Removed ');
            $('#filer_Employees').append(data.accounts_Employees + ' User(s)');
            $('#filer_Applicants').append(data.accounts_Applicants + ' User(s)');
            $('#filer_Admin').append(data.accounts_Admin + ' User(s)');
            $('#filer_Unused').append(data.accounts_Guest + ' User(s)');

            user_id_global = data.user_id_global;

            __notif_load_data(__basepath + "/");

            hideLoading();
        }

    });

}

$("body").on('click', '#filter_div', function () {
    $(this).addClass(' rounded-lg items-center  bg-primary text-white font-medium')
        .siblings()
        .removeClass('flex rounded-lg items-center bg-primary text-white font-medium');
    let filter_value = $(this).data('fil-value');
    load_accounts(filter_value);
});

$("body").on('click', '#add_new_account', function () {
    clear_fields();

});

$("body").on('click', '.no_user_priv', function () {
    clear_fields();

    $.ajax({
        url: bpath + 'admin/manage/load/priv/notif',
        type: "POST",
        data: {
            _token: _token,
        },
        success: function (data) {
            var data = JSON.parse(data);

            __notif_load_data(__basepath + "/");

        }

    });

});

$("body").on("click", "#account_details_btn", function (ev) {
    user_id = $(this).data('usr-id');
    user_id_global = $(this).data('usr-id');
    load_user_id(user_id);
});

$("body").on("click", "#sync_data_account_profile_employee", function (ev) {
    showLoading();

    if (!ev.detail || ev.detail == 1) {
        $.ajax({
            url: bpath + 'admin/manage/sync/account/profile/employee',
            type: "POST",
            data: {
                _token: _token,
                includ_account: $('#includ_account').val(),
                includ_profile: $('#includ_profile').val(),
                includ_employee: $('#includ_employee').val(),
            },
            success: function (data) {
                var data = JSON.parse(data);

                __notif_load_data(__basepath + "/");
                // console.log(data);
                hideLoading();
                //location.reload();
            }

        });
    }


});

$("body").on("click", "#export_data_account_profile_employee", function (ev) {
    // showLoading();
    // $.ajax({
    // 	url: bpath + 'admin/manage/sync/account/profile/employee/temp',
    // 	type: "POST",
    // 	data: {
    // 		_token: _token,
    // 	},
    // 	success: function(data) {
    //         var data = JSON.parse(data);

    //         //__notif_load_data(__basepath + "/");

    //         hideLoading();
    //         //location.reload();
    //     }

    // });

});

$("body").on("click", "#load_account_edit", function (ev) {
    account_id = $(this).data('acc-id');

    if (!ev.detail || ev.detail == 1) {
        $.ajax({
            url: bpath + 'admin/manage/load/edit/account/id',
            type: "POST",
            data: {
                _token: _token,
                account_id: account_id,
            },
            success: function (data) {
                var data = JSON.parse(data);

                console.log(data);
                clear_fields();

                $('#modal_account_id').val(data['load_account']['id']);

                $('#account_modal_id').val(data['load_account']['id']);
                $('#modal_account_agency_id').val(data['load_account']['employee']);
                $('#modal_account_first_name').val(data['load_account']['firstname']);
                $('#modal_account_last_name').val(data['load_account']['lastname']);
                $('#modal_account_active_date').val(data['active_date']);
                $('#modal_account_expire_date').val(data['expire_date']);
                $('#modal_account_username').val(data['load_account']['username']);
                $('#modal_account_password').val(data['password_tex']);
                $('#modal_account_role_name').val(data['load_account']['role_name']);
                $('#modal_account_last_seen').val(data['load_account']['last_seen']);
                $('#account_status_modal_title').empty();
                $('#account_status_modal_title').append(data.go_no_go);

            }

        });
    }


});

$("body").on("click", "#load_profile_edit", function (ev) {
    profile_id = $(this).data('pro-id');

    if (!ev.detail || ev.detail == 1) {
        $.ajax({
            url: bpath + 'admin/manage/load/edit/profile/id',
            type: "POST",
            data: {
                _token: _token,
                profile_id: profile_id,
            },
            success: function (data) {
                var data = JSON.parse(data);

                // console.log(data);
                clear_fields();

                $('#profile_modal_id').val(data['load_profile']['id']);

                $('#modal_profile_last_name').val(data['load_profile']['lastname']);
                $('#modal_profile_first_name').val(data['load_profile']['firstname']);
                $('#modal_profile_mid_name').val(data['load_profile']['mi']);
                $('#modal_profile_name_extension').val(data['load_profile']['extension']);
                $('#modal_profile_date_birth').val(data['load_profile']['dateofbirth']);
                $('#modal_application_gender').val(data['load_profile']['sex']);
                $('#modal_profile_civil_status').val(data['load_profile']['civilstatus']);
                $('#modal_profile_height').val(data['load_profile']['height']);
                $('#modal_profile_weight').val(data['load_profile']['weight']);
                $('#modal_profile_blood_type').val(data['load_profile']['bloodtype']);
                $('#modal_profile_gsis').val(data['load_profile']['gsis']);
                $('#modal_profile_pagibig').val(data['load_profile']['pagibig']);
                $('#modal_profile_philhealth').val(data['load_profile']['philhealth']);
                $('#modal_profile_tin').val(data['load_profile']['tin']);
                $('#modal_profile_agency').val(data['load_profile']['agencyid']);
                $('#modal_profile_age').val(data['load_profile']['agencyid']);
                $('#modal_profile_tel_number').val(data['load_profile']['telephone']);
                $('#modal_profile_mobile_number').val(data['load_profile']['mobile_number']);
                $('#modal_profile_email').val(data['load_profile']['email']);
                $('#modal_profile_place_birth').val(data['load_profile']['placeofbirth']);
                $('#profile_print_modal_title').empty();
                $('#profile_print_modal_title').append(data['profile_pint_and_title']);

            }

        });
    }


});

$("body").on("click", "#load_employee_edit", function (ev) {
    employee_id = $(this).data('emp-id');

    if (!ev.detail || ev.detail == 1) {
        $.ajax({
            url: bpath + 'admin/manage/load/edit/employee/id',
            type: "POST",
            data: {
                _token: _token,
                employee_id: employee_id,
            },
            success: function (data) {
                var data = JSON.parse(data);

                //console.log(data);

                $('#modal_update_emp_id').val(data['load_employee']['id']);


                $('#modal_employment_type').val(data['load_employee']['employment_type']);
                $('#modal_start_date').val(data['load_employee']['start_date']);
                $('#modal_end_date').val(data['load_employee']['end_date']);

                $('#modal_designation_id').val(data['load_employee']['designation_id']);

                $('#modal_position_id').val(data['load_employee']['position_id']);
                $('#modal_rc_id').val(data['load_employee']['office_id']);
                $('#modal_salary').val(data['load_employee']['salary_amount']);
                $('#modal_employee_status').val(data['load_employee']['status']);


                var new_Data = new Option(data['load_employee']['agency_id'], data['load_employee']['agency_id'], true, true);
                modal_employee_id.append(new_Data).trigger('change');
                modal_employee_id.val(data['load_employee']['agency_id']);
                modal_employee_id.trigger('change');
                modal_designation_id.trigger('change');
                modal_position_id.trigger('change');
                modal_employment_type.trigger('change');
                modal_rc_id.trigger('change');
                modal_employee_status.trigger('change');
            }

        });
    }


});

$("body").on("click", "#load_account_save", function (ev) {
    ev.preventDefault();
    //$('.btn').prop('disabled', true);

    account_id = $('#account_modal_id').val();
    if (!ev.detail || ev.detail == 1) {
        $.ajax({
            url: bpath + 'admin/manage/load/save/account',
            type: "POST",
            data: {
                _token: _token,
                account_id: account_id,
                modal_account_agency_id: $('#modal_account_agency_id').val(),
                modal_account_first_name: $('#modal_account_first_name').val(),
                modal_account_last_name: $('#modal_account_last_name').val(),
                modal_account_acti: $('#modal_account_acti').val(),
                modal_account_expi: $('#modal_account_expi').val(),
                modal_account_username: $('#modal_account_username').val(),
                modal_account_password: $('#modal_account_password').val(),
                modal_account_role_name: $('#modal_account_role_name').val(),
                modal_account_last_seen: $('#modal_account_last_seen').val(),
                modal_account_active_date: $('#modal_account_active_date').val(),
                modal_account_expire_date: $('#modal_account_expire_date').val(),
            },
            success: function (data) {
                var data = JSON.parse(data);

                const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#account_modal'));
                mdl.hide();

                __notif_load_data(__basepath + "/");

                // load_user_id(user_id_global);
                clear_fields();
            }

        });
    }


});

$("body").on("click", "#load_profile_save", function (ev) {
    ev.preventDefault();
    //$('.btn').prop('disabled', true);

    profile_id = $('#profile_modal_id').val();

    if (!ev.detail || ev.detail == 1) {

        $.ajax({
            url: bpath + 'admin/manage/load/save/profile',
            type: "POST",
            data: {
                _token: _token,
                profile_id: profile_id,
                user_id_global: user_id_global,
                modal_profile_last_name: $('#modal_profile_last_name').val(),
                modal_profile_first_name: $('#modal_profile_first_name').val(),
                modal_profile_mid_name: $('#modal_profile_mid_name').val(),
                modal_profile_name_extension: $('#modal_profile_name_extension').val(),
                modal_profile_date_birth: $('#modal_profile_date_birth').val(),
                modal_application_gender: $('#modal_application_gender').val(),
                modal_profile_civil_status: $('#modal_profile_civil_status').val(),
                modal_profile_height: $('#modal_profile_height').val(),
                modal_profile_weight: $('#modal_profile_weight').val(),
                modal_profile_blood_type: $('#modal_profile_blood_type').val(),
                modal_profile_gsis: $('#modal_profile_gsis').val(),
                modal_profile_pagibig: $('#modal_profile_pagibig').val(),
                modal_profile_philhealth: $('#modal_profile_philhealth').val(),
                modal_profile_tin: $('#modal_profile_tin').val(),
                modal_profile_agency: $('#modal_profile_agency').val(),
                modal_profile_place_birth: $('#modal_profile_place_birth').val(),
                modal_profile_tel_number: $('#modal_profile_tel_number').val(),
                modal_profile_mobile_number: $('#modal_profile_mobile_number').val(),
                modal_profile_email: $('#modal_profile_email').val()
            },
            success: function (data) {
                var data = JSON.parse(data);

                const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#profile_modal'));
                mdl.hide();

                __notif_load_data(__basepath + "/");

                load_user_id(user_id_global);

                clear_fields();
            }

        });
    }


});

$("body").on("click", "#load_employee_save", function (ev) {
    ev.preventDefault();
    //$('.btn').prop('disabled', true);

    employee_id = $('#modal_update_emp_id').val();


    if (!ev.detail || ev.detail == 1) {

        $.ajax({
            url: bpath + 'admin/manage/load/save/employee',
            type: "POST",
            data: {
                _token: _token,
                user_id_global: user_id_global,
                employee_id: employee_id,
                modal_employee_id: $('#modal_employee_id').val(),
                modal_employment_type: $('#modal_employment_type').val(),
                modal_start_date: $('#modal_start_date').val(),
                modal_end_date: $('#modal_end_date').val(),
                modal_designation_id: $('#modal_designation_id').val(),
                modal_position_id: $('#modal_position_id').val(),
                modal_rc_id: $('#modal_rc_id').val(),
                modal_salary: $('#modal_salary').val(),
                modal_employee_status: $('#modal_employee_status').val(),

            },
            success: function (data) {
                var data = JSON.parse(data);

                const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#employee_modal'));
                mdl.hide();
                __notif_load_data(__basepath + "/");
                load_user_id(user_id_global);
                clear_fields();
            }

        });
    }



});

$("body").on("click", "#modal_btn_new_account", function (ev) {
    clear_fields();
});

function clear_fields() {

    //$('.btn').removeAttr('disabled');
    $('#modal_account_id').val('');
    $('#account_modal_id').val('');
    $('#modal_account_agency_id').val('');
    $('#modal_account_first_name').val('');
    $('#modal_account_last_name').val('');
    $('#modal_account_active_date').val('');
    $('#modal_account_expire_date').val('');
    $('#modal_account_username').val('');
    $('#modal_account_password').val('');
    $('#modal_account_role_name').val('');
    $('#modal_account_last_seen').val('');


    $('#profile_modal_id').val('');

    $('#modal_profile_last_name').val('');
    $('#modal_profile_first_name').val('');
    $('#modal_profile_mid_name').val('');
    $('#modal_profile_name_extension').val('');
    $('#modal_profile_date_birth').val('');
    $('#modal_application_gender').val('');
    $('#modal_profile_civil_status').val('');
    $('#modal_profile_height').val('');
    $('#modal_profile_weight').val('');
    $('#modal_profile_blood_type').val('');
    $('#modal_profile_gsis').val('');
    $('#modal_profile_pagibig').val('');
    $('#modal_profile_philhealth').val('');
    $('#modal_profile_tin').val('');
    $('#modal_profile_agency').val('');
    $('#modal_profile_age').val('');
    $('#modal_profile_tel_number').val('');
    $('#modal_profile_mobile_number').val('');
    $('#modal_profile_email').val('');
    $('#modal_profile_place_birth').val(''),

        $('#modal_update_emp_id').val('');


    $('#modal_employee_id').val('');
    $('#modal_employment_type').val('');
    $('#modal_start_date').val('');
    $('#modal_end_date').val('');
    $('#modal_designation_id').val('');
    $('#modal_position_id').val('');
    $('#modal_rc_id').val('');
    $('#modal_salary').val('');
    $('#modal_employee_status').val('');

    $('#modal_employee_id').load(location.href + ' #modal_employee_id');



}

$("body").on("click", "#save_modal_add_designation", function (ev) {
    // clear_fields();
    ev.preventDefault();
    //$('.btn').prop('disabled', true);
    if (!ev.detail || ev.detail == 1) {
        $.ajax({
            url: bpath + 'admin/manage/save/designation',
            type: "POST",
            data: {
                _token: _token,
                modal_desig_name: $('#modal_desig_name').val(),
                modal_desig_description: $('#modal_desig_description').val(),

            },
            success: function (data) {
                var data = JSON.parse(data);

                const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#modal_second_add_designation'));
                mdl.hide();

                __notif_load_data(__basepath + "/");

                $('#modal_designation_id').empty();
                $('#modal_designation_id').append(data.option_des);
                reload_dropdowns();

                $('#modal_desig_name').val('');
                $('#modal_desig_description').val('');
                //$('.btn').removeAttr('disabled');
            }

        });
    }

});

$("body").on("click", "#save_modal_add_position", function (ev) {
    ev.preventDefault();
    //$('.btn').prop('disabled', true);
    if (!ev.detail || ev.detail == 1) {
        $.ajax({
            url: bpath + 'admin/manage/save/position',
            type: "POST",
            data: {
                _token: _token,
                modal_position_name: $('#modal_position_name').val(),
                modal_position_description: $('#modal_position_description').val(),

            },
            success: function (data) {
                var data = JSON.parse(data);

                //  console.log(data);

                const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#modal_second_add_position'));
                mdl.hide();

                __notif_load_data(__basepath + "/");

                $('#modal_position_id').empty();
                $('#modal_position_id').append(data.option_pos);
                reload_dropdowns();

                $('#modal_position_name').val('');
                $('#modal_position_description').val('');
                //$('.btn').removeAttr('disabled');
            }

        });
    }

});

$("body").on("click", "#save_modal_add_rc", function (ev) {
    ev.preventDefault();
    //$('.btn').prop('disabled', true);
    if (!ev.detail || ev.detail == 1) {
        $.ajax({
            url: bpath + 'admin/manage/save/rc',
            type: "POST",
            data: {
                _token: _token,
                modal_rc_name: $('#modal_rc_name').val(),
                modal_rc_description: $('#modal_rc_description').val(),

            },
            success: function (data) {
                var data = JSON.parse(data);

                console.log(data);

                const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#modal_second_add_respon'));
                mdl.hide();

                __notif_load_data(__basepath + "/");

                $('#modal_rc_id').empty();
                $('#modal_rc_id').append(data.option_rc);

                reload_dropdowns();

                $('#modal_rc_name').val('');
                $('#modal_rc_description').val('');
                //$('.btn').removeAttr('disabled');
            }

        });
    }

});


$("body").on("click", "#save_modal_add_employment_type", function (ev) {
    ev.preventDefault();
    //$('.btn').prop('disabled', true);
    if (!ev.detail || ev.detail == 1) {
        $.ajax({
            url: bpath + 'admin/manage/save/emloyement/type',
            type: "POST",
            data: {
                _token: _token,
                modal_employment_type_name: $('#modal_employment_type_name').val(),
                modal_employment_type_description: $('#modal_employment_type_description').val(),

            },
            success: function (data) {
                var data = JSON.parse(data);

                console.log(data);

                const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#modal_second_add_employment_type'));
                mdl.hide();

                __notif_load_data(__basepath + "/");

                $('#modal_employment_type').empty();
                $('#modal_employment_type').append(data.option_et);

                reload_dropdowns();

                $('#modal_employment_type_name').val('');
                $('#modal_employment_type_description').val('');
                //$('.btn').removeAttr('disabled');
            }

        });
    }

});

$("body").on("click", ".btn_delete_account", function (ev) {
    ev.preventDefault();

    account_id = $(this).data('ac-id');

    // console.log(account_id);

    const account_action_dropdown = tailwind.Dropdown.getOrCreateInstance(document.querySelector("#account_action_dropdown"));
    account_action_dropdown.hide();

    swal({
        title: 'Are you sure?',
        text: "It will remove this account!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1e40af',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, remove it!'
    }).then((result) => {
        if (result.value == true) {

            swal({
                text: "Account Deactivated!",
                title: "Account successfully removed!",
                type: "success",
                confirmButtonColor: '#1e40af',
                timer: 500
            });

            tbldata_manage_users
                .row($(this)
                    .parents('tr'))
                .remove()
                .draw();

            $.ajax({
                url: "account/remove",
                type: "POST",
                data: {
                    _token: _token,
                    type: 1,
                    account_id: account_id,
                },
                cache: false,
                success: function (data) {
                    // console.log(data);
                    var data = JSON.parse(data);
                    __notif_load_data(__basepath + "/");
                    load_accounts('');
                }
            });

        } else if (
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swal({
                title: "Cancelled",
                text: "No action taken!",
                type: "error",
                confirmButtonColor: '#1e40af',
                timer: 500
            });
        }
    })
});
