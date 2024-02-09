
use App\Http\Controllers\__Payroll\PayrollController as __PayrollPayrollController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\MyRegistrationController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Clearance\ClearanceController;
use App\Http\Controllers\Leave\LeaveController;
use App\Http\Controllers\analytic\AnalyticsController;
use App\Http\Controllers\ApplicationController\ApplicationController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\chat\chatController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DocumentPreviewController;
use App\Http\Controllers\DocumentTrashController;
use App\Http\Controllers\ForwardDocsController;
use App\Http\Controllers\HoldController;
use App\Http\Controllers\IncomingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OutgoingController;
use App\Http\Controllers\PrintQRController;
use App\Http\Controllers\ProfileController\ProfileController;
use App\Http\Controllers\PublicFilesController;
use App\Http\Controllers\ReceiveController;
use App\Http\Controllers\ReturnedController;
use App\Http\Controllers\ScannerController;
use App\Http\Controllers\Schedule\ScheduleController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\RR\AwardsController;
use App\Http\Controllers\RR\RewardController;
use App\Http\Controllers\RR\EventsController;
use App\Http\Controllers\competency\CompetencyController;
use App\Http\Controllers\dtr\DTRController;
use App\Http\Controllers\faculty_monitoring\FacultyController;
use App\Http\Controllers\faculty_monitoring\MonitoringController;
use App\Http\Controllers\Hiring\Hiring_Controller;
use App\Http\Controllers\Hiring\Position_Hiring_Controller;
use App\Http\Controllers\Hiring\Short_listed;
use App\Http\Controllers\Hiring\add_position;
use App\Http\Controllers\IDP\idp;
use App\Http\Controllers\employee_rating\employee_rating_controller;
use App\Http\Controllers\employee_rating\training_satisfaction_controller;
use App\Http\Controllers\Interview\CriteriaController;
use App\Http\Controllers\Payroll\HolidayController;
use App\Http\Controllers\Testing\testingContoller;
use App\Http\Controllers\ratingController\ratingContoller;
use App\Http\Controllers\Saln\SalnController;
use App\Http\Controllers\TravelOrder\TravelOrderController;
use App\Http\Middleware\handleUserPriv;
use App\Http\Middleware\updateProfile;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Payroll\OvertimeController;
use App\Http\Controllers\Payroll\NightDiffController;
use App\Http\Controllers\Payroll\PayrollController;
use App\Http\Controllers\system\SettingController;
use App\Http\Controllers\system\MailSettingsController;
use App\Http\Controllers\Payroll\ContributionController;
use App\Http\Controllers\myPayroll\myPayrollController;
use App\Http\Controllers\others\TermConditionController;
use Sabberworm\CSS\Settings;
use App\Http\Controllers\Payroll\PayrollSetupController;




Route::prefix("hiring")->group(function(){

/** Position Hiring **/

Route::get('/hire-position',[Position_Hiring_Controller::class, 'index'])->name('index')->middleware('auth', handleUserPriv::class);
Route::post('/save-position',[Position_Hiring_Controller::class,'position_hiring']);
Route::post('/get-salaries',[Position_Hiring_Controller::class, 'get_monthly_salaries']);
Route::get('/load-position',[Position_Hiring_Controller::class, 'load_hiring_data'])->name('load_data');
Route::get('/get-panel',[Position_Hiring_Controller::class, 'get_panels']);
Route::get('/get-competency-list',[Position_Hiring_Controller::class,'get_competencies_list']);
Route::post('/update-hiring-position',[Position_Hiring_Controller::class,'update_data']);
Route::post('/delete-position-hiring',[Position_Hiring_Controller::class, 'delete_data']);
Route::post('/delete-hiring-status',[Position_Hiring_Controller::class, 'change_status']);
Route::get('/print-position-hiring/{id}',[Position_Hiring_Controller::class, 'print_pdf']);
Route::get('/print-new-position/{id}',[Position_Hiring_Controller::class, 'new_print_pdf']);
Route::get('/export-position-hiring/{id}',[Position_Hiring_Controller::class, 'export_position_hiring_excel']);
Route::get('/export-all-position-hiring',[Position_Hiring_Controller::class, 'export_all_position_hiring'])->name('export_position_all');

/** Position Hiring **/

/** Add position **/

Route::get('/add-position',[add_position::class,'position_index'])->name('position_index')->middleware('auth', handleUserPriv::class);
Route::get('/display-position-details',[add_position::class,'display_position']);
Route::post('/saved-position',[add_position::class, 'create_position']);
Route::post('/delete-position',[add_position::class, 'delete_position_data']);
Route::get('/view-position-details',[add_position::class, 'update_position_data']);
Route::post('/update-position-data',[add_position::class, 'update_data_position']);

/** Add position **/

/** Applicant shortlisted **/

Route::get('/applicant-short-listed',[Short_listed::class, 'short_listed_index'])->name('short_index')->middleware('auth', handleUserPriv::class);
Route::get('/short-listed-list',[Short_listed::class,'short_listed_applicant']);
Route::post('/get-applicant-position',[Short_listed::class, 'get_applicants_details']);
Route::post('/appoint-interview-sched',[Short_listed::class, 'appoint_sched'])->name('sched');
Route::post('/update-applicant-status',[Short_listed::class, 'update_stat']);
Route::post('/update-shortlisted-applicant',[Short_listed::class, 'update_shortlisted_applicant']);
Route::post('/load-attachments',[Short_listed::class, 'get_attachment']);
Route::get('/view-attachment/{id}',[Short_listed::class, 'view_applicant_attachment']);
Route::get('/download-attachment/{id}',[Short_listed::class,'download_applicant_attachment']);
Route::post('/applicant-info',[Short_listed::class, 'get_child_details']);
Route::post('/send-email-notif',[Short_listed::class, 'send_applicant_email_notif']);
Route::post('/tmp/files-upload', [Short_listed::class, '_tmp_file_upload']);
Route::delete('/tmp/file-delete', [Short_listed::class, '_tmp_file_delete' ]);
Route::post('/saved/attachments-emails',[Short_listed::class, 'saved_email_attachments']);

/** Applicant shortlisted **/

//position type Page
Route::get('/position-type',[Hiring_Controller::class,'positionType_page'])->middleware('auth', handleUserPriv::class);
Route::post('/save-update/positoin-type',[Hiring_Controller::class,'save_update_positionType']);
Route::get('/fetched/position-type',[Hiring_Controller::class,'fetchedPosition_type']);
Route::post('/delete-position-category',[Hiring_Controller::class,'deletePosition_category']);

//Added by Montz
Route::post('/load/job/document/requirements',[Position_Hiring_Controller::class,'load_job_doc_requirements']);
Route::post('/delete/job/document/requirements',[Position_Hiring_Controller::class,'delete_job_doc_requirements']);
});



//IDP
Route::prefix('IDP')->group(function(){

Route::get('/idp',[idp::class,'index'])->name('idp.view');
Route::get('/fetch-idp-data',[idp::class,'fetch_idpData']);
Route::post('/save-idp',[idp::class,'save_idp']);
Route::post('/save-develop-target',[idp::class,'saveDevelop_target']);
Route::get('/show-target-data',[idp::class,'show_tagetData']);
Route::get('/delete-target-data',[idp::class,'delete_targetData']);
Route::post('/save-development-plan',[idp::class,'saveDevelopment_plan']);
Route::get('/show-development-plan-data',[idp::class,'show_Development_plan']);
Route::get('/delete-delopment-plan-data',[idp::class,'delete_Development_plan']);
Route::get('/print-idp-data/{idp_id}',[idp::class,'print_IDP_data']);
Route::post('/save-activity-plan',[idp::class,'saveActivityPlan']);

Route::get('/idp-details/{idpID}',[idp::class,'idp_detail']);
Route::post('/save-all-idp-data',[idp::class,'saveAll_idp']);
Route::get('/delete-target-data/{Targeting_id}',[idp::class,'delete_targeting_data']);
Route::get('/delete-Activity-data/{activity_id}',[idp::class,'delete_activiting_data']);
// Route::post('/get-position',[idp::class,'get__Employee_position']);
// Route::post('/update-job-description',[idp::class, 'update_job_pos']);

});


Route::prefix('employee_ratings')->group(function(){

Route::get('/spms/set-up',[employee_rating_controller::class, 'index'])->name('employee_rating');
Route::post('/save/rating/data',[employee_rating_controller::class,'save_input']);
Route::post('/load/spms/data',[employee_rating_controller::class, 'load_spms_datas']);
Route::post('/load/rating/data',[employee_rating_controller::class ,'load_rating_data']);
Route::post('/update/rating.data',[employee_rating_controller::class, 'update_rating_data']);
Route::post('/delete/spms/data',[employee_rating_controller::class, 'delete_rating_data']);
Route::post('/activate/spms/rating',[employee_rating_controller::class,'activate_spms_rating']);

Route::get('/survey/training/satisfaction',[training_satisfaction_controller::class, 'index'])->name('training_survey');
Route::post('/saved/created/survey-data', [training_satisfaction_controller::class, 'saveData']);

});


Route::prefix('application')->group(function (){

//Application Form
Route::get('/form', [ApplicationController::class,'application'])->name('application');
Route::post('/apply', [ApplicationController::class, 'apply_job']);
Route::post('/submit/attachments', [ApplicationController::class, 'submit_application']);

//Application List
Route::get('/list', [ApplicationController::class,'applicant_list'])->name('applicant_list')->middleware('auth', handleUserPriv::class);
Route::post('/get/applicants', [ApplicationController::class, 'load_applicants'])->middleware('auth');

Route::post('/get/applicant/profile', [ApplicationController::class, 'get_applicant_profile']);
Route::post('/get/job/attachments', [ApplicationController::class, 'get_job_attachments']);
Route::get('/view/attachments/{path}', [ApplicationController::class, 'view_attachments']);
Route::get('/download/attachments/{path}', [ApplicationController::class, 'download_attachments']);

Route::post('/approve', [ApplicationController::class, 'approve_application']);
Route::post('/disapprove', [ApplicationController::class, 'disapprove_application']);
Route::post('/get/application/data', [ApplicationController::class, 'get_application_data']);

//TOR Upload
Route::post('/temp/tor/upload', [ApplicationController::class, '_tmp_Upload']);
Route::delete('/temp/delete', [ApplicationController::class, '_tmp_Delete' ]);

//Diploma Upload
Route::post('/temp/diploma/upload', [ApplicationController::class, '_tmp_diploma_Upload']);

//Certificate Upload
Route::post('/temp/certificate/upload', [ApplicationController::class, '_tmp_certificate_Upload']);

//Load all Address
Route::post('/get/address/region', [ApplicationController::class, 'get_address_via_region']);
Route::post('/get/address/province', [ApplicationController::class, 'get_address_via_province']);
Route::post('/get/address/municipality', [ApplicationController::class, 'get_address_via_municipality']);

Route::post('/get/address/brgy', [ApplicationController::class, 'get_address_via_brgy']);

//Load available Positions
Route::post('/get/available/positions', [ApplicationController::class, 'get_available_positions']);

//UPLOAD FILE ATTACHMENTS
Route::post('/tmp/file/upload', [ApplicationController::class, '_tmp_file_upload']);
Route::delete('/tmp/file/delete', [ApplicationController::class, '_tmp_file_delete' ]);



Route::post('/tmp/pds/upload', [ApplicationController::class, '_tmp_Upload_pds']);
Route::post('/tmp/prs/upload', [ApplicationController::class, '_tmp_Upload_prs']);
Route::post('/tmp/cs/upload', [ApplicationController::class, '_tmp_Upload_cs']);
Route::post('/tmp/tor/upload', [ApplicationController::class, '_tmp_Upload_tor']);

//DELETE FILE ATTACHMENTS
Route::delete('/tmp/delete/applicants/files', [ApplicationController::class, '_tmp_Delete_applicant_files' ]);


Route::post('/test', [ApplicationController::class, 'test_']);

});

Route::prefix("my")->group(function (){

Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::post('/load/profile', [ProfileController::class, 'load_profile']);

//Profile Picture Upload
//    Route::post('/temp/profile/upload', [ApplicationController::class, '_tmp_profile_pic_Upload']);
Route::post('/temp/profile/upload', [ProfileController::class, 'temp_upload_profile_picture']);
Route::post('/save/profile/picture', [ProfileController::class, 'save_profile_picture']);

//DELETE Profile Picture
Route::delete('/temp/profile/delete', [ProfileController::class, 'delete_profile_picture']);



//UPLOAD E-SIGNATURE NG INA MO
Route::post('/temp/e/signature/upload', [ProfileController::class, 'temp_upload_e_signature']);

//DELETE E-SIGNATURE NG INA MO
Route::delete('/temp/e/signature/delete', [ProfileController::class, 'temp_delete_e_signature']);
Route::post('/save/e/signature', [ProfileController::class, 'save_e_signature']);
Route::post('/load/e/signature', [ProfileController::class, 'load_e_signature']);
Route::post('/delete/e/signature', [ProfileController::class, 'delete_e_signature']);

//DOWNLOAD E-SIGNATURE NG INA MO
Route::get('/download/e/signature/{e_signature_value}', [ProfileController::class, 'download_e_signature']);


Route::post('/load/personal/information', [ProfileController::class, 'load_personal_information']);
Route::post('/load/educational/background', [ProfileController::class, 'load_educ_bg']);
Route::post('/add/educational/background', [ProfileController::class, 'add_educ_bg']);
Route::post('/update/educational/background', [ProfileController::class, 'update_educ_bg']);
Route::post('/remove/educational/background', [ProfileController::class, 'remove_educ_bg']);


Route::post('/load/residential/address', [ProfileController::class, 'load_residential_address']);
Route::post('/load/permanent/address', [ProfileController::class, 'load_permanent_address']);

Route::post('/load/family/background', [ProfileController::class, 'get_family_bg']);
Route::post('/load/civil/service/eligibility', [ProfileController::class, 'load_civil_service_eligibility']);
Route::post('/update/academic/background', [ProfileController::class, 'update_academic_bg']);

Route::post('/remove/child/family/background', [ProfileController::class, 'remove_child_family_bg']);
Route::post('/remove/academic/background', [ProfileController::class, 'remove_academic_bg']);


/** CIVIL SERVICE HERE **/
Route::post('/add/cs/eligibility',     [ProfileController::class, 'add_cs_eligibility']);
Route::post('/update/cs/eligibility',  [ProfileController::class, 'update_cs_eligibility']);
Route::post('/remove/cs',              [ProfileController::class, 'remove_cs']);
/** CIVIL SERVICE HERE **/



/** WORK EXPERIENCE HERE **/
Route::post('/add/work/experience',   [ProfileController::class, 'add_work_experience']);
Route::post('/load/work/experience', [ProfileController::class, 'load_work_experience']);
Route::post('/update/work/exp', [ProfileController::class, 'update_work_experience']);
Route::post('/remove/work/exp', [ProfileController::class, 'remove_work_exp']);
/** WORK EXPERIENCE HERE **/


/** VOLUNTARY WORK HERE **/
Route::post('/add/voluntary/work',   [ProfileController::class, 'add_voluntary_work']);
Route::post('/load/voluntary/work', [ProfileController::class, 'load_voluntary_work']);
Route::post('/update/voluntary/work', [ProfileController::class, 'update_vol_work']);
Route::post('/remove/voluntary/work', [ProfileController::class, 'remove_voluntary_work']);
/** VOLUNTARY WORK HERE **/



/** LEARNING DEVELOPMENT HERE **/
Route::post('/add/learning/development',   [ProfileController::class, 'add_learning_development']);
Route::post('/load/learning/development', [ProfileController::class, 'load_learning_development']);
Route::post('/update/learning/development', [ProfileController::class, 'update_learning_development']);
Route::post('/remove/learning/development', [ProfileController::class, 'remove_learning_development']);
/** LEARNING DEVELOPMENT HERE **/



/** SPECIAL SKILLS HERE **/
Route::post('/add/special/skills',   [ProfileController::class, 'add_special_skills']);
Route::post('/update/special/skills',   [ProfileController::class, 'update_special_skills']);
Route::post('/load/special/skills', [ProfileController::class, 'load_special_skills']);
Route::post('/remove/special/skills', [ProfileController::class, 'remove_special_skills']);
/** SPECIAL SKILLS HERE **/


Route::post('/load/other/information', [ProfileController::class, 'load_other_information']);



/** REFERENCES HERE **/
Route::post('/add/references',   [ProfileController::class, 'add_references']);
Route::post('/update/references',   [ProfileController::class, 'update_references']);
Route::post('/load/reference/info', [ProfileController::class, 'load_reference_info']);
Route::post('/remove/references', [ProfileController::class, 'remove_references']);
/** REFERENCES HERE **/


Route::post('/load/government/id', [ProfileController::class, 'load_government_id']);

Route::post('/save/pds', [ProfileController::class, 'save_pds']);
Route::post('/save/account/settings', [ProfileController::class, 'save_account_settings']);

Route::get('/print/pds/{user_id}', [ProfileController::class, 'print_pds']);

Route::post('/get/res/brgy', [ProfileController::class, 'get_ref_brgy']);
Route::post('/get/res/municipality', [ProfileController::class, 'get_res_municipality']);

Route::post('/get/per/brgy', [ProfileController::class, 'get_per_brgy']);


});

Route::prefix('clearance')->group(function (){

Route::get('/overview', [ClearanceController::class,'Overview'])->name('Overview')->middleware(handleUserPriv::class);
Route::get('/my/clearance', [ClearanceController::class,'my_clearance'])->name('my_clearance')->middleware(handleUserPriv::class);


Route::post('/load/my/clearance', [ClearanceController::class, 'load_my_clearance']);

//    Route::post('/create/new', [ClearanceController::class, 'create_new_clearance']);
Route::get('/print/semestral/{clearance_id}', [ClearanceController::class, 'print_semestral_clearance']);

Route::post('/create/new/updated', [ClearanceController::class, 'create_new_clearance']);
Route::post('/update/created/csc', [ClearanceController::class, 'update_created_csc']);
Route::post('/get/rc', [ClearanceController::class, 'get_Responsibility_Center']);

Route::post('/get/agency', [ClearanceController::class, 'get_Agency']);
Route::post('/get/sg/step', [ClearanceController::class, 'get_sg_steps']);


Route::post('/add/iii', [ClearanceController::class, 'add_clearance_iii']);
Route::post('/load/csc/iii', [ClearanceController::class, 'load_csc_clearance_III']);
Route::post('/update/csc/iii', [ClearanceController::class, 'update_csc_clearance_III']);
Route::post('/delete/csc/iii', [ClearanceController::class, 'delete_csc_clearance_III']);



Route::post('/load/csc/iv', [ClearanceController::class, 'load_csc_clearance_IV']);
Route::post('/add/iv',      [ClearanceController::class, 'add_clearance_IV']);
Route::post('/update/csc/iv', [ClearanceController::class, 'update_csc_clearance_IV']);
Route::post('/delete/csc/iv', [ClearanceController::class, 'delete_csc_clearance_IV']);


Route::post('/load/csc/information', [ClearanceController::class, 'load_csc_clearance_information']);


Route::post('/create/csc', [ClearanceController::class, 'create_my_csc_clearance']);

Route::get('/csc/print/{clearance_id}', [ClearanceController::class, 'print_CSC_clearance']);


Route::post('/csc/send/request', [ClearanceController::class, 'send_request_csc_clearance']);
Route::post('/csc/check/request',[ClearanceController::class, 'check_clearance_request']);
Route::post('/my/csc/clearance/iii',[ClearanceController::class, 'get_my_csc_clearance_iii']);
Route::post('/my/csc/clearance/iv',[ClearanceController::class, 'get_my_csc_clearance_iv']);
Route::post('/my/csc/clearance/others',[ClearanceController::class, 'get_my_csc_clearance_others']);


Route::post('/load/admin/requests',[ClearanceController::class, 'load_admin_clearance_request']);
Route::post('/approve/disapprove/requests',[ClearanceController::class, 'approve_disapprove_request']);


Route::post('/load/my/signatories',[ClearanceController::class, 'load_my_signatories']);
Route::post('/submit/my/signature',[ClearanceController::class, 'submit_my_signatory']);



Route::post('/get/recent/activities',[ClearanceController::class, 'load_clearance_recent_activities']);

Route::post('/admin/update/status',[ClearanceController::class, 'admin_update_clearance_status']);


Route::post('/resubmit/for/signatory',[ClearanceController::class, 'resubmit_for_signatory']);


/** ADMIN OVERVIEW HERE!! **/
Route::post('/load/important/notes',[ClearanceController::class, 'load_important_notes']);
Route::post('/submit/important/notes',[ClearanceController::class, 'submit_important_notes']);
Route::post('/dismiss/note',[ClearanceController::class, 'dismiss_notes']);


Route::post('/count/request',[ClearanceController::class, 'count_clearance_request']);
Route::post('/count/completed',[ClearanceController::class, 'count_clearance_completed']);

Route::post('/load/employee/completed/clearance',[ClearanceController::class, 'load_employee_completed_clearance']);
Route::post('/load/employee/completed/clearance/Name',[ClearanceController::class, 'load_employee_completed_clearance_name']);


Route::post('/csc/iii/load/data',[ClearanceController::class, 'load_csc_iii_data']);
Route::post('/add/csc/iii/data/from/setup',[ClearanceController::class, 'add_csc_iii_data_setup']);

Route::post('/csc/iv/load/data',[ClearanceController::class, 'load_csc_iv_data']);
Route::post('/add/csc/iv/data/from/setup',[ClearanceController::class, 'add_csc_iv_data_setup']);


Route::get('/print/cleared/reports/{clearance_id}',[ClearanceController::class, 'print_cleared_clearance_report']);
});

Route::prefix('schedule')->group(function (){

Route::get('/', [ScheduleController::class,'index'])->name('schedule')->middleware(handleUserPriv::class);

});



Route::prefix("rr")->group(function(){
Route::get('/overview', [RewardController::class, 'load_view'])->name('rr_rewards');
Route::post('/data/load', [RewardController::class, 'load_data']);

Route::get('/awards', [AwardsController::class, 'awards_load_view'])->name('rr_awards');
Route::get('/awards/data/get', [AwardsController::class, 'awards_data_get']);
Route::post('/awards/data/get', [AwardsController::class, 'awards_data_get']);
Route::get('/awards/data/info', [AwardsController::class, 'awards_data_info']);
Route::post('/awards/data/info', [AwardsController::class, 'awards_data_info']);
Route::post('/awards/data/add', [AwardsController::class, 'awards_data_add']);
Route::post('/awards/data/update', [AwardsController::class, 'awards_data_update']);
Route::post('/awards/data/delete', [AwardsController::class, 'awards_data_delete']);
Route::get('/awards/option/types/get', [AwardsController::class, 'awards_option_awards_type_get']);
Route::post('/awards/option/types/get', [AwardsController::class, 'awards_option_awards_type_get']);

Route::get('/events', [EventsController::class, 'events_load_view'])->name('rr_events');
Route::get('/events/data/get', [EventsController::class, 'events_data_get']);
Route::post('/events/data/get', [EventsController::class, 'events_data_get']);
Route::get('/events/data/info', [EventsController::class, 'events_data_info']);
Route::post('/events/data/info', [EventsController::class, 'events_data_info']);
Route::post('/events/data/add', [EventsController::class, 'events_data_add']);
Route::post('/events/data/update', [EventsController::class, 'events_data_update']);
Route::post('/events/data/delete', [EventsController::class, 'events_data_delete']);
});

//Payroll
Route::prefix("payroll")->group(function(){
Route::get('/overtime', [OvertimeController::class, 'index'])->name('overtime_setup');
Route::post('/overtime/loadsetup', [OvertimeController::class, 'loadsetup'])->name('overtime_setup_load');

Route::get('/nightdiff', [NightDiffController::class, 'index'])->name('nightdiff_setup');
Route::post('/nightdiff/loadsetup', [NightDiffController::class, 'loadsetup'])->name('nightdiff_setup_load');

Route::get('/payroll', [PayrollController::class, 'index'])->name('payroll_index');
Route::post('/payroll/load', [PayrollController::class, 'loadpayroll'])->name('payroll_load');


Route::get('/payroll/create', [PayrollController::class, 'createpayroll'])->name('payroll_create');
Route::post('/payroll/save', [PayrollController::class, 'savepayroll'])->name('payroll_save');
Route::post('/payroll/details/save', [PayrollController::class, 'savepayrolldetails'])->name('payroll_details_save');
Route::post('/payroll/tax/save', [PayrollController::class, 'savepayrolltax'])->name('payroll_tax_save');

Route::post('/payroll/loademp', [PayrollController::class, 'loadpayrollemp'])->name('payrollemp_load');
Route::post('/payroll/loademp_select', [PayrollController::class, 'loadpayrollemp_select'])->name('payrollemp_select_load');
Route::post('/payroll/getsalary', [PayrollController::class, 'getsalary'])->name('getsalary');
Route::post('/payroll/getsalary/hourly', [PayrollController::class, 'getsalary_hourly'])->name('getsalary_hourly');

Route::get('/payroll/getsalary', [PayrollController::class, 'getsalary'])->name('getsalary');


Route::get('/contribution', [ContributionController::class, 'index'])->name('contribution_setup');


Route::post('/contribution/emp/load', [ContributionController::class, 'loadempdeduction'])->name('emp_deduction_load');

Route::get('/contribution/assignment', [ContributionController::class, 'assignment'])->name('contribution_assignment');


Route::get('/setup', [PayrollSetupController::class, 'index'])->name('payroll_setup');
Route::post('/setup/load', [PayrollSetupController::class, 'loadsetup'])->name('payroll_setup_load');
Route::get('/setup/load', [PayrollSetupController::class, 'loadsetup'])->name('payroll_setup_load');

Route::post('/setup/store', [PayrollSetupController::class, 'storesetup'])->name('payroll_setup_store');
Route::post('/setup/update', [PayrollSetupController::class, 'updatesetup'])->name('payroll_setup_update');
Route::post('/setup/getsalary', [PayrollSetupController::class, 'getsalary_sg'])->name('payroll_setup_getsalary_sg');
Route::post('/setup/getdeduction', [PayrollSetupController::class, 'getdeduction'])->name('payroll_setup_deduction');
Route::post('/setup/getrate_amount', [PayrollSetupController::class, 'getrate_amount'])->name('payroll_setup_getrate_amount');
Route::post('/setup/getdeduction_amount', [PayrollSetupController::class, 'getdeduction_amount'])->name('payroll_setup_getdeduction_amount');
Route::post('/setup/loadsalary_toedit', [PayrollSetupController::class, 'loadsalary_toedit'])->name('payroll_setup_loadsalary_toedit');


Route::post('/setup/incentive/load', [PayrollSetupController::class, 'load_emp_incentive'])->name('payroll_setup_load_deduction');
Route::post('/setup/incentive/insert', [PayrollSetupController::class, 'insert_emp_incentive'])->name('payroll_setup_insert_incentive');
Route::post('/setup/incentive/delete', [PayrollSetupController::class, 'delete_emp_incentive'])->name('payroll_setup_delete_incentive');


Route::post('/setup/contribution/load', [PayrollSetupController::class, 'load_emp_contribution'])->name('payroll_setup_load_contribution');
Route::post('/setup/contribution/insert', [PayrollSetupController::class, 'insert_emp_contribution'])->name('payroll_setup_insert_contribution');
Route::post('/setup/contribution/delete', [PayrollSetupController::class, 'delete_emp_contribution'])->name('payroll_setup_delete_contribution');

Route::post('/setup/deduction/insert', [PayrollSetupController::class, 'insert_emp_deduction'])->name('payroll_setup_insert_deduction');
Route::post('/setup/deduction/update', [PayrollSetupController::class, 'update_emp_deduction'])->name('payroll_setup_update_deduction');

Route::post('/setup/loan/load', [PayrollSetupController::class, 'load_emp_loan'])->name('payroll_setup_load_loan');
Route::post('/setup/loan/insert', [PayrollSetupController::class, 'insert_emp_loan'])->name('payroll_setup_insert_loan');
Route::post('/setup/loan/delete', [PayrollSetupController::class, 'delete_emp_loan'])->name('payroll_setup_delete_loan');



//Created by Ladbu
Route::get('/holiday', [HolidayController::class, 'index'])->name('holiday_setup');
});

Route::get('calendar-event', [HolidayController::class, 'index']);
Route::post('calendar-crud-ajax', [HolidayController::class, 'calendarEvents']);

Route::prefix("competency")->group(function(){
Route::get('/overview', [CompetencyController::class, 'load_view'])->name('competency');
Route::post('/data/load', [CompetencyController::class, 'load_data']);

Route::get('/skills', [CompetencyController::class, 'skills_load_view'])->name('competency_skills');
Route::get('/skills/data/get', [CompetencyController::class, 'skills_data_get']);
Route::post('/skills/data/get', [CompetencyController::class, 'skills_data_get']);
Route::get('/skills/data/info', [CompetencyController::class, 'skills_data_info']);
Route::post('/skills/data/info', [CompetencyController::class, 'skills_data_info']);
Route::post('/skills/data/add', [CompetencyController::class, 'skills_data_add']);
Route::post('/skills/data/update', [CompetencyController::class, 'skills_data_update']);
Route::post('/skills/data/delete', [CompetencyController::class, 'skills_data_delete']);

Route::get('/dictionary', [CompetencyController::class, 'dictionary_load_view'])->name('competency_dictionary');
Route::get('/dictionary/data/get', [CompetencyController::class, 'dictionary_data_get']);
Route::post('/dictionary/data/get', [CompetencyController::class, 'dictionary_data_get']);
Route::get('/dictionary/data/info', [CompetencyController::class, 'dictionary_data_info']);
Route::post('/dictionary/data/info', [CompetencyController::class, 'dictionary_data_info']);
Route::post('/dictionary/data/add', [CompetencyController::class, 'dictionary_data_add']);
Route::post('/dictionary/data/update', [CompetencyController::class, 'dictionary_data_update']);
Route::post('/dictionary/data/delete', [CompetencyController::class, 'dictionary_data_delete']);
Route::get('/dictionary/option/groups/get', [CompetencyController::class, 'dictionary_option_groups_get']);
Route::post('/dictionary/option/groups/get', [CompetencyController::class, 'dictionary_option_groups_get']);
Route::get('/dictionary/skills/data/get', [CompetencyController::class, 'dictionary_skills_data_get']);
Route::post('/dictionary/skills/data/get', [CompetencyController::class, 'dictionary_skills_data_get']);
Route::post('/dictionary/skills/data/add', [CompetencyController::class, 'dictionary_skills_data_add']);
Route::post('/dictionary/skills/data/update', [CompetencyController::class, 'dictionary_skills_data_update']);
Route::post('/dictionary/skills/data/delete', [CompetencyController::class, 'dictionary_skills_data_delete']);
Route::get('/dictionary/reqs/data/get', [CompetencyController::class, 'dictionary_reqs_data_get']);
Route::post('/dictionary/reqs/data/get', [CompetencyController::class, 'dictionary_reqs_data_get']);
Route::post('/dictionary/reqs/data/add', [CompetencyController::class, 'dictionary_reqs_data_add']);
Route::post('/dictionary/reqs/data/update', [CompetencyController::class, 'dictionary_reqs_data_update']);
Route::post('/dictionary/reqs/data/delete', [CompetencyController::class, 'dictionary_reqs_data_delete']);

Route::get('/groups', [CompetencyController::class, 'groups_load_view'])->name('competency_groups');
Route::get('/groups/data/get', [CompetencyController::class, 'groups_data_get']);
Route::post('/groups/data/get', [CompetencyController::class, 'groups_data_get']);
Route::get('/groups/data/info', [CompetencyController::class, 'groups_data_info']);
Route::post('/groups/data/info', [CompetencyController::class, 'groups_data_info']);
Route::post('/groups/data/add', [CompetencyController::class, 'groups_data_add']);
Route::post('/groups/data/update', [CompetencyController::class, 'groups_data_update']);
Route::post('/groups/data/delete', [CompetencyController::class, 'groups_data_delete']);

});

Route::prefix("dtr")->group(function(){
//Route::get('/overview', [DTRController::class, 'load_view'])->name('dtr');
Route::post('/data/load', [DTRController::class, 'load_data']);

Route::get('/manage/bio', [DTRController::class, 'manage_bio_load_view'])->name('dtr_manage_bio');
Route::get('/manage/bio/data/get', [DTRController::class, 'manage_bio_data_get']);
Route::post('/manage/bio/data/get', [DTRController::class, 'manage_bio_data_get']);
Route::get('/manage/bio/data/info', [DTRController::class, 'manage_bio_data_info']);
Route::post('/manage/bio/data/info', [DTRController::class, 'manage_bio_data_info']);
Route::post('/manage/bio/data/add', [DTRController::class, 'manage_bio_data_add']);
Route::post('/manage/bio/data/update', [DTRController::class, 'manage_bio_data_update']);
Route::post('/manage/bio/data/delete', [DTRController::class, 'manage_bio_data_delete']);
Route::post('/manage/bio/users/list', [DTRController::class, 'manage_bio_users_list']);
Route::get('/manage/bio/users/list', [DTRController::class, 'manage_bio_users_list']);
Route::post('/manage/bio/check/employee', [DTRController::class, 'manage_bio_check_employee']);
Route::get('/manage/bio/check/employee', [DTRController::class, 'manage_bio_check_employee']);

Route::post('/manage/bio/fingerprint/save', [DTRController::class, 'manage_bio_fingerprint_save']);
Route::post('/manage/bio/user/fingerprint/data/get', [DTRController::class, 'manage_bio_user_fingerprint_data_get']);
Route::get('/manage/bio/user/fingerprint/data/get', [DTRController::class, 'manage_bio_user_fingerprint_data_get']);


Route::get('/attendance', [DTRController::class, 'attendance_load_view']);
Route::post('/attendance/data/save', [DTRController::class, 'attendance_data_save']);


Route::get('/', function () {
    return redirect('dtr/my');
});
Route::get('/overview', [DTRController::class, 'load_overview'])->name('dtr_overview');
Route::get('/my', [DTRController::class, 'my_dtr_load_view'])->name('dtr_my');
Route::post('/my/data/get', [DTRController::class, 'my_dtr_data_get']);
Route::get('/my/data/get', [DTRController::class, 'my_dtr_data_get']);
Route::get('/my/print', [DTRController::class, 'my_dtr_data_print']);

Route::get('/overview/data/list/get', [DTRController::class, 'overview_data_list_get']);
Route::post('/overview/data/list/get', [DTRController::class, 'overview_data_list_get']);
Route::get('/overview/records/data/list/get', [DTRController::class, 'overview_records_data_list_get']);
Route::post('/overview/records/data/list/get', [DTRController::class, 'overview_records_data_list_get']);
Route::get('/overview/record/info/data/get', [DTRController::class, 'overview_record_info_get']);
Route::post('/overview/record/info/data/get', [DTRController::class, 'overview_record_info_get']);
Route::get('/overview/statistics/data/get', [DTRController::class, 'overview_statistics_data_get']);
Route::post('/overview/statistics/data/get', [DTRController::class, 'overview_statistics_data_get']);

Route::get('/manage/data', [DTRController::class, 'manage_data_load_view'])->name('dtr_manage_data');
Route::post('/manage/data/save', [DTRController::class, 'manage_data_save_sata']);

Route::get('/manage/dtr/remarks/', [DTRController::class, 'manage_dtr_remarks_load_view'])->name('dtr_manage_dtr_remarks');
Route::get('/manage/dtr/remarks/data/save', [DTRController::class, 'manage_dtr_remarks_data_save']);
Route::get('/manage/dtr/remarks/data/get', [DTRController::class, 'manage_dtr_remarks_data_get']);
Route::post('/manage/dtr/remarks/data/get', [DTRController::class, 'manage_dtr_remarks_data_get']);


});

Route::prefix("bioengine")->group(function(){
Route::get('/settings/get', [App\Http\Controllers\bioengine\BioEngineController::class, 'get_settings']);
Route::post('/settings/get', [App\Http\Controllers\bioengine\BioEngineController::class, 'get_settings']);

Route::get('/api/get/fp/all', [DTRController::class, 'bio_api_data_get_fp_all']);
Route::post('/api/get/fp/all', [DTRController::class, 'bio_api_data_get_fp_all']);

});

Route::prefix("request")->group(function(){

Route::get('/', function () {
    return redirect('request/overview');
});
Route::get('/overview', [App\Http\Controllers\request\RequestController::class, 'request_overview_load_view'])->name('request_overview');

});

Route::prefix("interview")->group(function(){
Route::get('/criteria', [CriteriaController::class, 'index'])->name('criteria');
Route::post('/criteria/load', [CriteriaController::class, 'load'])->name('load_criteria');
//    Route::get('/criteria/load', [CriteriaController::class, 'load'])->name('load_criteria');
});

//Rating
Route::prefix("rating")->group(function(){
//Criteria URL view
Route::get('/criteria-page', [ratingContoller::class, 'criteria_page'])->middleware(handleUserPriv::class);
Route::get('/fetch-criteria', [ratingContoller::class, 'fetchedCriteria']);
Route::post('/add-criteria', [ratingContoller::class, 'addCriteria']);
Route::post('/update-criteria', [ratingContoller::class, 'updateCriteria']);
Route::post('/delete-criteria', [ratingContoller::class, 'deleteCriteria']);
Route::get('/onchange-competency-points/{competency_id}', [ratingContoller::class, 'onchangeCompetency_points']);
// Route::get('/criteria/filter-by-position-type/{id}', [ratingContoller::class, 'filterCriteriaPosition_type']);
Route::get('/filter-position-applicant/{id}', [ratingContoller::class, 'filterPositionBy_applicant']);

Route::post('/add-criteria-area', [ratingContoller::class, 'storeArea']);
Route::get('/show-criteria-areas/{id}', [ratingContoller::class, 'showAreas']);
Route::get('/delete-criteria-area/{id}', [ratingContoller::class, 'deleteAreas']);
Route::get('/onchange-skill-points/{skill_id}', [ratingContoller::class, 'onChangeSkill']);

//Manage Rating URL view
Route::get('/manage-rating-page', [ratingContoller::class, 'manageRating_page']);
Route::get('/filter-by-position/{id}', [ratingContoller::class, 'filter_ratingCriteria']);
Route::post('/save-rating', [ratingContoller::class, 'saveRating']);
Route::get('/show-rate-criteria-area/{id}', [ratingContoller::class, 'showRatingArea']);
Route::post('/store/rated-areas', [ratingContoller::class, 'storeRated_areas']);
Route::get('/filter-rated-applicants', [ratingContoller::class, 'filterRatedApplicants']);

//Summary of rating
Route::get('/summary', [ratingContoller::class, 'summary_page']);
Route::get('/print-summary/{ap_id}/{ref_num}/{short_listID}/{rated_check_in_value}', [ratingContoller::class, 'printSummary']);
Route::get('/fetched/applicant-summary/{id}', [ratingContoller::class, 'fetched_Applicant_summary']);
Route::get('/rater-details', [ratingContoller::class, 'rater_details']);
// Route::get('/summary-details', [ratingContoller::class, 'summary_details']);
Route::get('/approving-applicant/{shortList_id}', [ratingContoller::class, 'approving_applicants']);
Route::get('/approve-applicant/{shortList_id}', [ratingContoller::class, 'approve_applicants']);

Route::get('/rated-applicant', [ratingContoller::class, 'rated_applicant_page'])->middleware(handleUserPriv::class);
Route::get('/fetched/rated-applicant/{position_id}/{status_id}', [ratingContoller::class, 'fetch_ratedApplicant']);
Route::get('/hire-applicant/{shortList_id}', [ratingContoller::class, 'hireApplicant']);
Route::get('/disapprove-applicant/{rated_id}', [ratingContoller::class, 'disapproveApplicant']);
Route::get('/change-status/{rates_id}/{position}', [ratingContoller::class, 'changeStatus']);
Route::get('/end-contruct', [ratingContoller::class, 'endContruct']);
Route::get('/final-proceed-applicant/{rated_doneID}', [ratingContoller::class, 'final_proceed_Applicant']);

Route::get('/applicant-information-page/{id}/{rated_check_in_value}', [ratingContoller::class, 'applicant_info_page']);
Route::get('/applicant-information', [ratingContoller::class, 'applicant_info']);
Route::get('/rater-criteria-points', [ratingContoller::class, 'rater_criteria_points']);
Route::get('/rater-aria-points', [ratingContoller::class, 'rater_aria_points']);
Route::post('/notify-applicant', [ratingContoller::class, 'notifyApplicant']);

//print summary
Route::post('/interview-summary-print', [ratingContoller::class, 'interview_summary_Print'])->name('load_interview_summary_print');

Route::get('/final-listed-applicant-page', [ratingContoller::class, 'final_listed_Applicant_page'])->middleware(handleUserPriv::class);
Route::get('/fetched/select-applicant/{position_id}', [ratingContoller::class, 'fetched_selectApplicant']);
Route::get('/select-applicant/{id}', [ratingContoller::class, 'select_Applicant']);
Route::get('/return-applicant/{id}', [ratingContoller::class, 'return_Applicant']);
Route::get('/fetched/listed-modal-applicant/{id}', [ratingContoller::class, 'listed_modal_Applicant']);
Route::get('/remove-applicant/{id}', [ratingContoller::class, 'remove_Applicant']);

});

Route::prefix("my-payroll")->group(function(){
Route::get('/payroll-details', [myPayrollController::class, 'myPayrollDetail'])->name('payrollDetail');
Route::get('/payroll-others', [myPayrollController::class, '_pera_others'])->name('payrollOthers');
Route::get('/payroll-deduction', [myPayrollController::class, 'my_deduction'])->name('payrollDeduction');
Route::get('/fetch-mypayroll-detail', [myPayrollController::class, 'fetch_MyPayrollDetail']);
});





Route::prefix('travel/order')->group(function () {

Route::get('/', [TravelOrderController::class, 'myto'])->name('myto')->middleware(handleUserPriv::class);
Route::get('/list', [TravelOrderController::class, 'to_list'])->name('to_list');
Route::get('/rated', [TravelOrderController::class, 'rated'])->name('rated');
Route::post('/load/travel/order', [TravelOrderController::class, 'load_travel_order']);
Route::get('/load/travel/order', [TravelOrderController::class, 'load_travel_order']);

Route::post('/load/travel/order/list', [TravelOrderController::class, 'load_travel_order_list']);
Route::get('/load/travel/order/list', [TravelOrderController::class, 'load_travel_order_list']);

Route::post('/add/travel/order', [TravelOrderController::class, 'add_travel_order']);
Route::get('/add/travel/order', [TravelOrderController::class, 'add_travel_order']);
Route::post('/remove', [TravelOrderController::class, 'remove_to']);
Route::post('/load/details', [TravelOrderController::class, 'load_details']);
Route::get('/print/to/{id}/{type}', [TravelOrderController::class, 'print']);

Route::get('/travelorder-export',[TravelOrderController::class, 'export_travel_order'])->name('export_travel_order');


Route::post('/release/travel/order', [TravelOrderController::class, 'release_travel_order']);
Route::get('/release/travel/order', [TravelOrderController::class, 'release_travel_order']);

Route::post('/remove/signatory/travel/order', [TravelOrderController::class, 'remove_signatory']);


Route::post('/load/travel/order/rated', [TravelOrderController::class, 'load_travel_order_rated']);
Route::get('/load/travel/order/rated', [TravelOrderController::class, 'load_travel_order_rated']);
});

Route::prefix('saln')->group(function () {

Route::get('/', [SalnController::class, 'mysaln'])->name('mysaln')->middleware(handleUserPriv::class);
Route::post('/load/saln', [SalnController::class, 'load_saln']);
Route::get('/load/saln', [SalnController::class, 'load_saln']);
Route::post('/load/details', [SalnController::class, 'load_details']);
Route::post('/remove', [SalnController::class, 'remove_saln']);
Route::post('/remove/data/from/table', [SalnController::class, 'remove_data_from_table']);
Route::post('/add/saln', [SalnController::class, 'add_saln']);
Route::get('/add/saln', [SalnController::class, 'add_saln']);
Route::get('/print/saln/{id}/{type}', [SalnController::class, 'print']);

});

Route::prefix('documents')->group(function (){

//My-Documents
Route::get('/my-documents',[DocumentController::class, 'my_documents'])->name('my_documents')->middleware(handleUserPriv::class);
Route::get('/outgoing',[DocumentController::class, 'outgoing'    ])->name('outgoing');
Route::get('/returned',[DocumentController::class, 'returned'    ])->name('returned');
//    Route::post('/docs-details/load', [DocumentController::class, 'docDetails']);
//    Route::post('/docs-view/load', [DocumentController::class, 'docView']);
Route::post('/employee-list/load', [DocumentController::class, 'employee_List']);
Route::post('/created-docs/load', [DocumentController::class, 'created_docs']);
Route::get('/created-docs/load', [DocumentController::class, 'created_docs']);
Route::post('/group-list/load', [DocumentController::class, 'group_List']);
Route::get('/group-list/load', [DocumentController::class, 'group_List']);
Route::post('/rc-list/load', [DocumentController::class, 'rc_List']);
Route::post('/docs-insert', [DocumentController::class, 'create_documents']);
Route::post('/docs-update', [DocumentController::class, 'update_documents']);
Route::post('/docs-delete', [DocumentController::class, 'delete_documents']);
Route::post('/tmp-upload', [DocumentController::class, 'tmpUpload'   ])->name('tmpUpload');
Route::delete('/tmp-delete', [DocumentController::class, 'tmpDelete' ])->name('tmpDelete');
Route::post('/tmp/attachments/upload', [DocumentController::class, 'attachments_tmpUpload'   ]);
Route::post('/docs-fast-send', [DocumentController::class, 'FastSend_Docs']);
Route::post('/docs-trail-send', [DocumentController::class, 'TrailSend_Docs']);
Route::post('/docs-updateDocStats', [DocumentController::class, 'sendCompleted']);
Route::get('/download-documents/{path}', [DocumentPreviewController::class, 'Download_Documents']);
Route::post('/docs-mark-as-complete', [DocumentController::class, 'markAsComplete']);
Route::post('/tmp-delete-canceled', [DocumentController::class, 'tmpDeleteIfCanceled' ]);


Route::post('/load/summary/print', [DocumentController::class, 'load_summary_print' ])->name('load_summary_print');
Route::get('/load/summary/print', [DocumentController::class, 'load_summary_print' ])->name('load_summary_print');

});

Route::prefix('documents/attachments')->group(function () {

Route::post('/insert/attachments', [DocumentAttachmentController::class, 'attach_documents']);
Route::post('/delete/attachments', [DocumentAttachmentController::class, 'delete_attached_documents']);
Route::post('/load', [DocumentPreviewController::class, 'docView']);



});

Route::prefix("documents/incoming")->group(function(){

//Incoming Documents
Route::get('/', [IncomingController::class, 'incoming'])->name('incoming')->middleware(handleUserPriv::class);
Route::post('/incoming-docs-details/load', [IncomingController::class, 'incoming_docDetails']);
Route::post('/incoming-docs/load', [IncomingController::class, 'incoming_Docs']);
Route::get('/incoming-docs/load', [IncomingController::class, 'incoming_Docs']);
Route::post('/take/action', [IncomingController::class, 'take_action']);
Route::get('/take/action', [IncomingController::class, 'take_action']);
Route::post('/doc/details', [IncomingController::class, 'load_document_details']);
Route::get('/doc/details', [IncomingController::class, 'load_document_details']);

});

Route::prefix("documents/received")->group(function(){

//Receive Documents
Route::get('/', [ReceiveController::class, 'received'])->name('received')->middleware(handleUserPriv::class);
Route::post('/received-docs/load', [ReceiveController::class, 'received_Docs']);
Route::get('/received-docs/load', [ReceiveController::class, 'received_Docs']);
Route::post('/release/action', [ReceiveController::class, 'release_action']);
Route::post('/load/trail', [ReceiveController::class, 'load_trail']);
Route::get('/load/trail', [ReceiveController::class, 'load_trail']);
Route::post('/add/trail', [ReceiveController::class, 'add_trail']);
Route::get('/add/trail', [ReceiveController::class, 'add_trail']);

Route::post('/load/signatories', [ReceiveController::class, 'load_signatories']);
Route::get('/load/signatories', [ReceiveController::class, 'load_signatories']);

Route::post('/load/signatories/history', [ReceiveController::class, 'load_signatories_history']);
Route::get('/load/signatories/history', [ReceiveController::class, 'load_signatories_history']);

Route::post('/add/action/signatory', [ReceiveController::class, 'add_action_signatory']);
Route::get('/add/action/signatory', [ReceiveController::class, 'add_action_signatory']);
});

Route::prefix("documents/hold")->group(function(){

Route::get('/', [HoldController::class, 'hold'])->name('hold')->middleware(handleUserPriv::class);
Route::post('/hold-docs/load', [HoldController::class, 'hold_Docs']);

});

Route::prefix("documents/returned")->group(function(){
Route::get('/', [ReturnedController::class, 'returned'])->name('returned')->middleware(handleUserPriv::class);
Route::post('/returned-docs/load', [ReturnedController::class, 'returned_Docs']);
Route::get('/returned-docs/load', [ReturnedController::class, 'returned_Docs']);
});

Route::prefix("track")->group(function(){

Route::get('/', [TrackingController::class, 'dockTracks']);
Route::get('/doctrack/{doccode}', [TrackingController::class, 'dockTracks'])->name('dockTracks');
Route::post('/track-users/load', [TrackingController::class, 'track_Docs']);
Route::get('/track-users/load', [TrackingController::class, 'track_Docs']);
Route::post('/load/recipients', [TrackingController::class, 'load_recipient']);
Route::post('/load/sender', [TrackingController::class, 'get_sender']);
Route::post('/add/note', [TrackingController::class, 'add_document_notes']);
Route::post('/remove/note', [TrackingController::class, 'remove_document_notes']);

Route::post('/load/attachments', [TrackingController::class, 'load_file_attachments']);

});

Route::prefix("documents/outgoing")->group(function(){
Route::get('/', [OutgoingController::class, 'outgoing'])->name('outgoing')->middleware(handleUserPriv::class);
Route::post('/outgoing-docs/load', [OutgoingController::class, 'outgoing_Docs']);
Route::get('/outgoing-docs/load', [OutgoingController::class, 'outgoing_Docs']);
});

Route::prefix("documents/trashBin")->group(function(){
Route::get('/', [DocumentTrashController::class, 'docTrashIndex'])->name('trash')->middleware(handleUserPriv::class);
Route::post('/docs-trash', [DocumentTrashController::class, 'getTrash']);
});

Route::prefix("documents/scanner")->group(function(){

Route::get('/', [ScannerController::class, 'scanner'])->name('scanner')->middleware(handleUserPriv::class);

Route::post('/take/action/viaqr', [ScannerController::class, 'take_action_viaqr']);
Route::get('/take/action/viaqr', [ScannerController::class, 'take_action_viaqr']);

Route::get('/add/note', [ScannerController::class, 'add_note']);
Route::post('/add/note', [ScannerController::class, 'add_note']);

Route::post('/remove/note', [ScannerController::class, 'remove_note']);
Route::get('/remove/note', [ScannerController::class, 'remove_note']);
Route::get('/receive/details/{status}', [ScannerController::class, 'receive_details']);
Route::post('/receive/details/{status}', [ScannerController::class, 'receive_details']);
Route::post('/receive/action', [ScannerController::class, 'receive_action']);
Route::get('/receive/action', [ScannerController::class, 'receive_action']);
Route::get('/release/action', [ScannerController::class, 'release_action']);
Route::post('/release/action', [ScannerController::class, 'release_action']);
//Route::post('/scanner-docs/load', [HoldController::class, 'scanner_Docs']);

Route::get('/hold/action', [ScannerController::class, 'hold_action']);
Route::post('/hold/action', [ScannerController::class, 'hold_action']);
Route::get('/return/action', [ScannerController::class, 'return_action']);
Route::post('/return/action', [ScannerController::class, 'return_action']);

Route::get('/multiple/action', [ScannerController::class, 'multiple_action']);
Route::post('/multiple/action', [ScannerController::class, 'multiple_action']);
});

Route::get('/print-qr/{docID}', [PrintQRController::class, 'Print_QR'])->name('print_QR');
Route::get('/print-qr/{docID}', [PrintQRController::class, 'Print_QR'])->name('print_QR');
Route::post('/forward-docs', [ForwardDocsController::class, 'forwardDocuments']);





//Leave Application Route

Route::prefix("Leave")->group(function(){
Route::get('/Leave-Dashboard',[LeaveController::class, 'index'])->name('leave_dashboard');
Route::get('/My-Leave-Dashboard', [LeaveController::class, 'my_leave'])->name('my_leave_emp');
Route::post('/load_leave_type', [LeaveController::class, 'load_leave_type'])->name('load_leave_type');
Route::post('/store_leave_type', [LeaveController::class, 'store_leave_type'])->name('store_leave_type');
Route::get('/edit_leave_type/{id}/edit',[LeaveController::class, 'edit_leave_type'])->name('edit_leave_type');
Route::put('/update_leave_type/{id}', [LeaveController::class, 'update_leave_type'])->name('update_leave_type');
Route::get('/delete_leave_type/{id}/delete',[LeaveController::class, 'delete_leave_type'])->name('delete_leave_type');
Route::get('/load_employee_leave_details', [LeaveController::class, 'load_employee_leave_details'])->name('load_employee_leave_details');
Route::post('/load_employee_leave_details', [LeaveController::class, 'load_employee_leave_details'])->name('load_employee_leave_details');
Route::get('/delete_leave_employee_details/agency_id/delete', [LeaveController::class, 'delete_leave_employee_details'])->name('delete_leave_employee_details');
Route::post('/load_applied_leave_submitted', [LeaveController::class, 'load_applied_leave_submitted'])->name('load_applied_leave_submitted');
Route::post('/load_president_leave_approval', [LeaveController::class, 'load_president_leave_for_approval'])->name('load_president_leave_for_approval');
Route::get('/get_id_approval_for_president/{id}/edit', [LeaveController::class, 'get_id_approval_for_president']);
Route::post('/update_approval_for_president', [LeaveController::class, 'update_approval_for_president'])->name('update_approval_for_president');
Route::post('/hr_for_approval', [LeaveController::class, 'hr_for_approval'])->name('hr_for_approval');
Route::get('/get_hr_approval_info/{id}/edit', [LeaveController::class, 'get_hr_approval_info']);
Route::post('/hr_approval_leave_submitted', [LeaveController::class, 'hr_approval_leave_submitted']);
Route::get('/download_attachment_documents/{id}/download', [LeaveController::class, 'download_attachment_documents']);


Route::post('/store_employee_leave_beginning_balance_earn', [LeaveController::class, 'store_employee_leave_beginning_balance_earn'])->name('store_employee_leave_beginning_balance_earn');
Route::get('/store_employee_leave_beginning_balance_earn', [LeaveController::class, 'store_employee_leave_beginning_balance_earn'])->name('store_employee_leave_beginning_balance_earn');
Route::post('/store_employee_leave_beginning_balance_deduction', [LeaveController::class, 'store_employee_leave_beginning_balance_deduction'])->name('store_employee_leave_beginning_balance_deduction');
Route::get('/store_employee_leave_beginning_balance_deduction', [LeaveController::class, 'store_employee_leave_beginning_balance_deduction'])->name('store_employee_leave_beginning_balance_deduction');
Route::get('/get_employee_details_set_leave/{id}/edit', [LeaveController::class, 'get_employee_details_set_leave'])->name('get_employee_details_set_leave');
Route::get('/get_leave_ledger_details/{agency_id}/show', [LeaveController::class, 'get_leave_ledger_details'])->name('get_leave_ledger_details');
Route::get('/show_my_leave_ledger_details/{agency_id}', [LeaveController::class, 'show_my_leave_ledger_details'])->name('show_my_leave_ledger_details');

Route::get('/print_my_leave_application/{lid}', [LeaveController::class, 'print_my_leave_application'])->name('print_my_leave_application');

Route::get('/My-Leave-Settings', [LeaveController::class, 'leave_settings_view'])->name('leave_settings_view');
Route::post('/store_leave_category', [LeaveController::class, 'store_leave_category'])->name('store_leave_category');
Route::get('/delete_leave_category/{id}/delete', [LeaveController::class, 'delete_leave_category'])->name('delete_leave_category');
Route::post('/my_leave_submitted', [LeaveController::class, 'my_leave_submitted'])->name('my_leave_submitted');
Route::post('/get_emp_leave_details/{employeeid}', [LeaveController::class, 'get_emp_leave_details'])->name('get_emp_leave_details');
Route::post('/temp_attachement_documents', [LeaveController::class, 'temp_attachement_documents'])->name('temp_attachement_documents');
Route::delete('/remove_attachments_forleave', [LeaveController::class, 'remove_attachement_documents'])->name('remove_attachement_documents');
Route::post('/store_apply_leave_application', [LeaveController::class, 'store_apply_leave_application'])->name('store_apply_leave_application');
Route::get('/get_approval_value_recommendation/{id}/edit', [LeaveController::class, 'get_approval_value_recommendation']);
Route::post('/recommendation_approve_action_leave_application', [LeaveController::class, 'recommendation_approve_action_leave_application'])->name('recommendation_approve_action_leave_application');
Route::get('/leave-summary-transaction', [LeaveController::class, 'leave_summary'])->name('leave_summary');
Route::post('/get_leave_summery', [LeaveController::class, 'get_leave_summery_transaction'])->name('get_leave_summery_transaction');
Route::post('/print_leave_summary', [LeaveController::class, 'print_leave_summary'])->name('print_leave_summary');
Route::get('/print_leave_summary', [LeaveController::class, 'print_leave_summary'])->name('print_leave_summary');



});

// End Leave Application Route



Route::prefix('dashboard')->group(function () {

Route::get('/', [AnalyticsController::class, 'dashboard_analytics'])->name('dashboard_analytics')->middleware(handleUserPriv::class);
Route::post('/load/gender', [AnalyticsController::class, 'dashboard_analytics_gender'])->name('dashboard_analytics_gender');
Route::post('/load/tribe', [AnalyticsController::class, 'dashboard_analytics_tribe'])->name('dashboard_analytics_tribe');
Route::post('/load/address', [AnalyticsController::class, 'dashboard_analytics_address'])->name('dashboard_analytics_address');
Route::post('/load/leave', [AnalyticsController::class, 'dashboard_analytics_leave'])->name('dashboard_analytics_leave');
Route::post('/load/SALN', [AnalyticsController::class, 'dashboard_analytics_SALN'])->name('dashboard_analytics_SALN');
Route::post('/load/DTR', [AnalyticsController::class, 'dashboard_analytics_DTR'])->name('dashboard_analytics_DTR');
Route::post('/load/employee', [AnalyticsController::class, 'dashboard_analytics_employee'])->name('dashboard_analytics_employee');
Route::post('/load/travelorder', [AnalyticsController::class, 'dashboard_analytics_travelorder'])->name('dashboard_analytics_travelorder');

});


Route::prefix('payroll')->group(function () {

Route::get('/', [__PayrollPayrollController::class, 'payroll_mng'])->name('payroll_mng')->middleware(handleUserPriv::class);
Route::get('/set/payroll', [__PayrollPayrollController::class, 'payroll_set'])->name('payroll_set')->middleware(handleUserPriv::class);

});


Route::prefix('chat')->group(function () {

Route::get('/', [chatController::class, 'chat'])->name('chat');
Route::post('/search/user/info', [chatController::class, 'chat_search_user_info']);
Route::post('/load/my/conversations', [chatController::class, 'load_my_conversations']);
Route::get('/load/my/conversations', [chatController::class, 'load_my_conversations']);
Route::post('/load/conversation/content', [chatController::class, 'load_conversation_content']);
Route::post('/send/conversation/text', [chatController::class, 'send_conversation_text']);
Route::post('/save/new/conversation', [chatController::class, 'save_new_conversation']);
Route::post('/add/new/member', [chatController::class, 'add_new_member']);
Route::post('/load/all/users', [chatController::class, 'load_all_contacts']);
Route::post('/load/conversation/members', [chatController::class, 'load_conversation_members']);
Route::post('/add/conversation/new/member', [chatController::class, 'add_conversation_new_member']);
Route::post('/leave/conversation', [chatController::class, 'leave_conversation']);
Route::post('/remove/conversation', [chatController::class, 'remove_conversation']);
Route::post('/load/chat/history', [chatController::class, 'load_chat_history']);
Route::post('/remove/user/conversation', [chatController::class, 'remove_user_conversation']);
Route::post('/send/message/user', [chatController::class, 'send_message_user']);
Route::post('/autoload/conversation', [chatController::class, 'autoload_conversation']);


});

// Route::post('chat/load/message/id', [chatController::class, 'load_message_id'])->name('trydaw');
Route::post('chat/load/message/id', [App\Http\Controllers\chat\chatController::class, 'load_message_id'])->name('load_message_id');


Route::prefix('others')->group(function () {

Route::get('/terms-and-condition', [TermConditionController::class, 'index_terms_and_condition'])->name('index_terms_and_condition');

Route::post('/update/terms-and-condition', [TermConditionController::class, 'update_terms_and_condition'])->name('update_terms_and_condition');
Route::get('/update/terms-and-condition', [TermConditionController::class, 'update_terms_and_condition'])->name('update_terms_and_condition');
});


Route::prefix('faculty-monitoring')->group(function () {
//faculty
Route::get('/faculty', [FacultyController::class, 'faculty'])->name('faculty');

Route::post('/add/schedule', [FacultyController::class, 'add_schedule'])->name('add_schedule');
Route::get('/add/schedule', [FacultyController::class, 'add_schedule'])->name('add_schedule');

Route::post('/load/subject', [FacultyController::class, 'load_subject'])->name('load_subject');
Route::get('/load/subject', [FacultyController::class, 'load_subject'])->name('load_subject');

Route::post('/load/linked', [FacultyController::class, 'load_linked'])->name('load_linked');
Route::get('/load/linked', [FacultyController::class, 'load_linked'])->name('load_linked');

Route::post('/add/linked', [FacultyController::class, 'add_linked'])->name('add_linked');
Route::get('/add/linked', [FacultyController::class, 'add_linked'])->name('add_linked');

Route::post('/add/link/meeting', [FacultyController::class, 'add_link_meeting'])->name('add_link_meeting');
Route::get('/add/link/meeting', [FacultyController::class, 'add_link_meeting'])->name('add_link_meeting');

Route::post('/load/link/meeting/update', [FacultyController::class, 'load_link_meeting_update'])->name('load_link_meeting_update');
Route::get('/load/link/meeting/update', [FacultyController::class, 'load_link_meeting_update'])->name('load_link_meeting_update');


Route::post('/add/class/started', [FacultyController::class, 'add_class_started'])->name('add_class_started');
Route::get('/add/class/started', [FacultyController::class, 'add_class_started'])->name('add_class_started');

Route::post('/add/class/ended', [FacultyController::class, 'add_class_ended'])->name('add_class_ended');
Route::get('/add/class/ended', [FacultyController::class, 'add_class_ended'])->name('add_class_ended');
//monitoring
Route::get('/monitoring', [MonitoringController::class, 'monitoring'])->name('monitoring');

Route::get('/get-profile-image/{id}', [MonitoringController::class, 'getProfileImage'])->name('getProfileImage');


Route::get('/your-api-endpoint', [MonitoringController::class, 'fetchData'])->name('faculty-monitoring.fetch-data');
});
