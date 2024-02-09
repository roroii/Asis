<?php

use App\Http\Controllers\ASIS_Controllers\studentClearance\studentClearance;
use App\Http\Controllers\Pre_Enrollees\ProgramController;
use Sabberworm\CSS\Settings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\handleUserPriv;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\vote\voteController;
use App\Http\Controllers\vote\deleteController;
use App\Http\Controllers\vote\votingController;

use App\Http\Controllers\article\articleController;

use App\Http\Controllers\Enroll\enrolledController;
use App\Http\Controllers\portal\myPortalController;
use App\Http\Controllers\vote\applicationController;
use App\Http\Controllers\student\lists\ListController;
use App\Http\Controllers\vote\electionResultController;
use App\Http\Controllers\Evaluation\EvaluationController;
use App\Http\Controllers\signature\mySignatureController;
use App\Http\Controllers\student\enroll\enrollController;
use App\Http\Controllers\academic_records\academicRecords;

use App\Http\Controllers\Pre_Enrollees\ScheduleController;
use App\Http\Controllers\vote\candidate_partiesController;
use BeyondCode\LaravelWebSockets\Facades\WebSocketsRouter;
use App\Http\Controllers\Auth\MyEmailVerificationController;

use App\Http\Controllers\e_hris_controllers\CommonController;

use App\Http\Controllers\Pre_Enrollees\TransactionController;
use App\Http\Controllers\ASIS_Controllers\chat\chatController;
use App\Http\Controllers\ASIS_Controllers\event\eventReminder;
use App\Http\Controllers\Pre_Enrollees\EntranceExamController;

use App\Http\Controllers\e_hris_controllers\DocumentController;

use App\Http\Controllers\ASIS_Controllers\admin\AdminController;

use App\Http\Controllers\ASIS_Controllers\studentLedger\myLedger;
use App\Http\Controllers\e_hris_controllers\PublicFilesController;
use App\Http\Controllers\Pre_Enrollees\PreEnrolleesHomeController;
use App\Http\Controllers\ASIS_Controllers\system\SettingController;
use App\Http\Controllers\ASIS_Controllers\SemSched\Sem_Sched_Controller;
use App\Http\Controllers\ASIS_Controllers\system\MailSettingsController;

/*Student ledger*/
use App\Http\Controllers\ASIS_Controllers\curriculum\curriculumController;
use App\Http\Controllers\ASIS_Controllers\onlinerequest\onlinerequestController;
use App\Http\Controllers\e_hris_controllers\ProfileController\ProfileController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes([
    'verify' => true
]);


Route::get('/', [AuthController::class, 'index'])->name('login');
Route::get('find/my/account', [AuthController::class, 'find_my_account'])->name('find_account');
Route::post('find/my/account', [AuthController::class, 'find_account_now'])->name('find_account');
Route::post('find/my/birthDate', [AuthController::class, 'find_my_birthDate']);
Route::post('get/my/attempts', [AuthController::class, 'getMyAttempts']);
Route::post('send/email/verification', [AuthController::class, 'sendEmailVerification']);
Route::get('verify/my/email/{username}/{students_id}/{password}', [AuthController::class, 'verifyMyEmailAddress'])->name('verifyMyEmailAddress');



Route::get('verify/my/account/', [AuthController::class, 'verify_my_account_view'])->name('verify_account');
Route::post('verify/my/account', [AuthController::class, 'verify_my_account'])->name('verification_process');


Route::get('/home', [HomeController::class, 'index'])->middleware('verified')->name('home')->middleware('eval');
Route::get('/pre/enrollees/home', [PreEnrolleesHomeController::class, 'index'])->name('enrollees_home')->middleware('verified_enrollees_email');
Route::get('/admin/dashboard', [HomeController::class, 'index'])->name('enrollees_dashboard')->middleware('employees_auth');



Route::post('/public-files', [PublicFilesController::class, 'load_publicFiles']);
Route::post('/docs-view/load', [PublicFilesController::class, 'docView']);
Route::post('/docs-details/load', [PublicFilesController::class, 'docDetails']);
Route::post('/count/docs/view', [PublicFilesController::class, 'count_doc_view']);

Route::post('post-login', [AuthController::class, 'postLogin'])->name('student_login');



Route::post('admin/manage/check/account/notif', [AdminController::class, 'admin_manage_check_account_notif']);
Route::get('admin/manage/check/account/notif', [AdminController::class, 'admin_manage_check_account_notif']);

Route::post('bio-login', [App\Http\Controllers\Auth\AuthController::class, 'bioLogin'])->name('bio-login');


Route::get('/my/logout', [AuthController::class, 'logout'])->name('my_logout');

Route::get('/getnotif', [CommonController::class, 'GetNotificationData']);





//
//Route::get('/adminNotification/core/create', [NotificationController::class, 'notification_create']);
//Route::get('/adminNotification/core/load', [NotificationController::class, 'notification_load']);
//Route::post('/incoming-update-adminNotification', [NotificationController::class, 'update_incoming_notif']);
//Route::post('/adminNotification/details/load', [NotificationController::class, 'notification_details_load']);
//
//Route::post('/adminNotification/get/details', [NotificationController::class, 'get_notification_details']);
//Route::post('/adminNotification/for/applicants', [NotificationController::class, 'load_applicants_notifications']);
//
////load the position hiring adminNotification
//Route::post('/adminNotification/status/update',[NotificationController::class, 'update_hiring_notif_status']);
//Route::post('/load/panel/adminNotification',[NotificationController::class,'load_hiring_notification_info']);
//Route::post('/display/notif/info', [NotificationController::class, 'display_notif_content']);
//
//// ROY NOT READY
//Route::get('/adminNotification/hired-applicant', [NotificationController::class, '_notif_applicant']);
//Route::post('/adminNotification/interview-update/{notif_id}', [NotificationController::class, '_notif_hiredUpdate']);
//Route::get('/adminNotification/selected-applicant', [NotificationController::class, '_notif_selected_applicant']);
//
//Route::prefix("adminNotification")->group(function(){
//
//    Route::post('/documents', [NotificationController::class, 'load_employee_documents']);
//
//});


Route::get('/attendance', function () {
    return redirect('dtr/attendance');
});
Route::get('/att', function () {
    return redirect('dtr/attendance');
});


Route::prefix("admin")->group(function () {

    //rc
    Route::get('/rc', [AdminController::class, 'rescen'])->name('rc')->middleware(handleUserPriv::class);
    Route::post('/rc/add/members', [AdminController::class, 'add_rcmembers']);
    Route::post('/rc/load/members', [AdminController::class, 'load_rcmembers']);
    Route::post('/rc/load', [AdminController::class, 'load_rc']);
    Route::post('/rc/member/remove', [AdminController::class, 'rc_remove_member_group']);

    //groups
    Route::get('/group', [AdminController::class, 'group'])->name('group')->middleware(handleUserPriv::class);
    Route::post('/group/load', [AdminController::class, 'load_group']);
    Route::post('/group/add', [AdminController::class, 'create_group']);
    Route::post('/group/load/members', [AdminController::class, 'load_groupmembers']);
    Route::post('/group/add/update/members', [AdminController::class, 'add_update_groupmembers']);
    Route::post('/group/remove', [AdminController::class, 'remove_group']);
    Route::post('/group/member/remove', [AdminController::class, 'group_remove_member_group']);
    //user privs
    Route::get('/user-privileges', [AdminController::class, 'user_privileges'])->name('user_privileges')->middleware(handleUserPriv::class);
    Route::post('/user/load', [AdminController::class, 'load_employee']);
    Route::get('/user/load', [AdminController::class, 'load_employee']);
    Route::get('/user/priv/load', [AdminController::class, 'load_user_priv']);
    Route::post('/user/priv/load', [AdminController::class, 'load_user_priv']);
    Route::post('/user/priv/update', [AdminController::class, 'update_user_priv']);


    Route::post('/user/priv/update/reload', [AdminController::class, 'update_user_priv_reload']);
    Route::get('/user/priv/update/reload', [AdminController::class, 'update_user_priv_reload']);


    //Link List
    Route::get('/link-list', [AdminController::class, 'link_lists'])->name('link_lists');
    Route::post('/get-list', [AdminController::class, 'get_link_list']);
    Route::post('/update-list', [AdminController::class, 'update_link_list']);


    //Account Management
    Route::get('/ac', [AdminController::class, 'acmn'])->name('ac')->middleware(handleUserPriv::class);
    Route::post('/manage/user/load/id', [AdminController::class, 'load_user_id']);
    Route::get('/manage/user/load/id', [AdminController::class, 'load_user_id']);
    Route::post('/manage/user/load', [AdminController::class, 'load_accounts']);
    Route::get('/manage/sync/account/profile/employee', [AdminController::class, 'sync_data_account_profile_employee']);
    Route::post('/manage/sync/account/profile/employee', [AdminController::class, 'sync_data_account_profile_employee']);
    Route::post('/manage/load/edit/account/id', [AdminController::class, 'manage_load_edit_account_id']);
    Route::post('/manage/load/edit/profile/id', [AdminController::class, 'manage_load_edit_profile_id']);
    Route::post('/manage/load/edit/employee/id', [AdminController::class, 'manage_load_edit_employee_id']);

    Route::get('/manage/sync/account/profile/employee/temp', [AdminController::class, 'sync_data_account_profile_employee_temp']);
    Route::post('/manage/sync/account/profile/employee/temp', [AdminController::class, 'sync_data_account_profile_employee_temp']);

    Route::get('/manage/sync/account/profile/employee', [AdminController::class, 'sync_data_account_profile_employee']);
    Route::post('/manage/sync/account/profile/employee', [AdminController::class, 'sync_data_account_profile_employee']);


    Route::post('/manage/load/save/account', [AdminController::class, 'manage_load_save_account']);
    Route::post('/manage/load/save/profile', [AdminController::class, 'manage_load_save_profile']);
    Route::post('/manage/load/save/employee', [AdminController::class, 'manage_load_save_employee']);
    Route::get('/manage/load/save/employee', [AdminController::class, 'manage_load_save_employee']);
    Route::post('/manage/load/priv/notif', [AdminController::class, 'manage_load_priv_notif']);

    Route::post('/manage/load/back/image', [AdminController::class, 'manage_load_back_image']);
    Route::get('/manage/load/back/image', [AdminController::class, 'manage_load_back_image']);

    Route::get('/profile-export', [AdminController::class, 'export_profile'])->name('export_profile');

    Route::get('/profile-import', [AdminController::class, 'import_profile'])->name('import_profile');
    Route::post('/profile-import', [AdminController::class, 'import_profile'])->name('import_profile');


    Route::post('/manage/save/designation', [AdminController::class, 'manage_save_designation']);
    Route::get('/manage/save/designation', [AdminController::class, 'manage_save_designation']);

    Route::post('/manage/save/position', [AdminController::class, 'manage_save_position']);
    Route::get('/manage/save/position', [AdminController::class, 'manage_save_position']);

    Route::post('/manage/save/rc', [AdminController::class, 'manage_save_rc']);
    Route::get('/manage/save/rc', [AdminController::class, 'manage_save_rc']);

    Route::post('/manage/save/emloyement/type', [AdminController::class, 'manage_save_emloyement_type']);
    Route::get('/manage/save/emloyement/type', [AdminController::class, 'manage_save_emloyement_type']);


    Route::post('/account/remove', [AdminController::class, 'remove_account']);

    //System Settings
    Route::get('/ss', [SettingController::class, 'system_setting'])->name('ss')->middleware(handleUserPriv::class);
    Route::post('/add/setting', [SettingController::class, 'add_setting'])->name('add_setting');
    Route::post('/load/system/settings', [SettingController::class, 'load_system_setting']);
    Route::post('/remove/ss', [SettingController::class, 'remove_ss']);
    Route::post('/load/ss/details', [SettingController::class, 'load_details']);

    Route::post('/temp/system/image/upload', [SettingController::class, '_tmp_system_Upload']);
    Route::delete('/temp/delete', [SettingController::class, '_tmp_system_Delete']);

    //Mail Settings
    Route::get('mail/settings', [MailSettingsController::class, 'mail_settings_index'])->name('mail')->middleware(handleUserPriv::class);
    Route::post('configure/save', [MailSettingsController::class, 'saved_configure_data']);
    Route::post('display-config/data', [MailSettingsController::class, 'display_data']);
    Route::post('update-confi/data', [MailSettingsController::class, 'update_data_config']);
    Route::post('update-active/status', [MailSettingsController::class, 'update_stat_email_stat']);
    Route::delete('delete-mail-config', [MailSettingsController::class, 'delete_email_config']);



    //DOCUMENT SETTINGS
    Route::get('/document-settings', [DocumentController::class, 'document_settings_index'])->name('document_settings')->middleware(handleUserPriv::class);

    //docs Type
    Route::post('/document-type/load', [DocumentController::class, 'document_type'])->middleware(handleUserPriv::class);
    Route::post('/document-type/insert', [DocumentController::class, 'document_type_insert']);
    Route::post('/document-type/update', [DocumentController::class, 'document_type_update']);
    Route::post('/document-type/delete', [DocumentController::class, 'document_type_delete']);

    //docs Level
    Route::post('/document-level/load', [DocumentController::class, 'document_level'])->middleware(handleUserPriv::class);
    Route::post('/document-level/insert', [DocumentController::class, 'document_level_insert']);
    Route::post('/document-level/update', [DocumentController::class, 'document_level_update']);
    Route::post('/document-level/delete', [DocumentController::class, 'document_level_delete']);


    //document count
    Route::post('/load/document/count', [DocumentController::class, 'load_document_count']);
});

//Route::get('logout', [App\Http\Controllers\OneLogin\OneLoginController::class, 'logout']);
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::prefix("onelogin")->group(function () {
    Route::get('/settings/get', [App\Http\Controllers\OneLogin\OneLoginController::class, 'get_settings'])->middleware('auth', handleUserPriv::class);
    Route::post('/settings/get', [App\Http\Controllers\OneLogin\OneLoginController::class, 'get_settings']);
    Route::get('/login/post/check', [App\Http\Controllers\OneLogin\OneLoginController::class, 'post_login_check']);
    Route::post('/login/save', [App\Http\Controllers\OneLogin\OneLoginController::class, 'save_login']);
});


//MY PROFILE
Route::prefix("my")->group(function () {

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile')->middleware('eval');
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

// Article
Route::prefix("article")->group(function () {
    Route::get('/my-article', [articleController::class, 'my_Article'])->name('my_article');
});

// Semestral Sched

Route::prefix("sem")->group(function () {
    Route::get('/semestral/sched/view', [Sem_Sched_Controller::class, 'index'])->name('sem_sched');
    Route::post('/get/college/program', [Sem_Sched_Controller::class, 'retrieved_program']);
});

// Semestral Sched


//User Signature
Route::prefix("signature")->group(function () {
    Route::get('/my-sinature', [mySignatureController::class, 'signaturePage'])->name('my_signature');

    Route::post('/upload/signature', [mySignatureController::class,'uploadSignature'])->name('uploadSignature');

    Route::post('/temp/user/signature/upload', [mySignatureController::class, 'tmpUploadSignature']);
    Route::delete('/temp/user/signature/delete', [mySignatureController::class, 'delete_temp_user_signature']);
    Route::post('/save/user/signature', [mySignatureController::class, 'saveSignature']);
});

Route::prefix("vote")->group(function () {
    // DELETE /vote DATA
    Route::get('/delete/vote-data/{voteDataID}/{RequestForDelete}', [deleteController::class, 'delete_voteData']);


    Route::get('/voting-type', [votingController::class, 'voteType'])->name('votingType');
    Route::post('/add-voting-type', [votingController::class, 'add_voteType']);
    Route::get('/fetched/vote-type-data', [votingController::class, 'fetch_voteTypeData']);

    Route::post('/add-signatory', [votingController::class, 'addSignatory']);
    Route::get('/load-signatory', [votingController::class, 'loadSignatory']);

    Route::post('/assign-voters', [votingController::class, 'assign_voters']);
    Route::get('/load-program', [votingController::class, 'loadProgram']);
    Route::get('/print-all-voters/{voteType_id}', [votingController::class, 'print_allVoters']);

    //VOTE ELECTION PARTIES

    Route::get('/election-parties', [candidate_partiesController::class, 'election_parties_page'])->name('elect_parties_page');
    Route::post('/add-candidate-parties', [candidate_partiesController::class, 'add_candidateParties_page']);
    Route::get('/load-candidate-parties', [candidate_partiesController::class, 'load_candidateParties_page']);
    Route::post('/add-parties-member', [candidate_partiesController::class, 'add_partiesMember']);
    Route::get('/get-parties-member', [candidate_partiesController::class, 'get_partiesMember']);

    // ======   VOTING POSITION ======= //
    Route::get('/voting-position', [votingController::class, 'votingPosition'])->name('votingPosition');
    Route::post('/add-voting-position', [votingController::class, 'add_votePosition']);
    Route::get('/fetched/vote-position-data', [votingController::class, 'fetch_votePositionData']);

    // ======   VOTING APPLICABLE POSITION ======= //
    Route::get('/election-application', [applicationController::class, 'electionApplication'])->name('elecApplication');
    Route::get('/fetched/open/application-data', [applicationController::class, 'fetch_openVoting_Application_data']);
    Route::get('/fetch/applicable-position-data', [applicationController::class, 'fetch_applicablePosition_data']);
    Route::post('/set/open/-voting-date', [applicationController::class, 'set_openVoting_date']);
    Route::post('/save-applied-position', [applicationController::class, 'saveApplied_position']);
    // Route::get('/load-candidate-groups', [applicationController::class, 'loadCandidateGroups']);
    Route::get('/change/select-applicant', [applicationController::class, 'changeSelectApplicant']);

    Route::get('/filter/position-data', [votingController::class, 'filterPosition']);
    Route::post('/assign-positions-dasta', [votingController::class, 'assignPosition']);
    Route::post('/set/open/voting-application-date', [votingController::class, 'set_openApplication_Voting_date']);
    Route::get('/load-candidate-list', [applicationController::class, 'loadCandidateList']);
    Route::post('/upload/candidate-profile', [applicationController::class, 'uploadParticipants_profile']);
    Route::post('/handle-active-candidate', [applicationController::class, 'handleActiveCandidate']);

     // ======   VOTING ELECTION PARTICIPANTS ======= //
    Route::get('/election-participants', [voteController::class, 'election_voting'])->name('elecParticipants')->middleware('eval');
    Route::get('/fetched/election-participants-data', [voteController::class, 'fetchElectionVoting']);
    Route::get('/fetch/open/voting-type-position', [voteController::class, 'fetch_openVoting_type_position']);
    Route::post('/save/selected-participants', [voteController::class, 'save_selected_applicants']);


    // ======   VOTING ELECTION REGISTRATION ======= //
    // Route::get('/election-registration', [electionRegistrationController::class, 'election_registrationPage'])->name('elecRegistration');

    // ======   VOTING ELECTION RESULT ======= //
    Route::get('/election-result', [electionResultController::class, 'resultPage'])->name('result');
    Route::get('/filter/election-type-positions/{type_id}', [electionResultController::class, 'filter_type_position']);
    // Route::get('/fetch/election-candidate/{type_id}/{position_id}', [electionResultController::class, 'fetch_candidate']);
    Route::get('/fetch/election-candidate_by_type/{type_id}', [electionResultController::class, 'fetch_candidate_by_type']);
    Route::get('/fetch/leaderBoard/{type_id}', [electionResultController::class, 'fetch_leaderBoard']);

    Route::get('/print-vote-result', [electionResultController::class, 'print_vote_result'])->name('print_vote_result');

});


//CHAT
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


//portal
Route::prefix('my-portal')->group(function () {

    Route::get('/', [myPortalController::class, 'my_portal'])->name('my_portal')->middleware('eval');
    Route::get('/load-student-data', [myPortalController::class, 'load_student_data'])->name('load_student_data');
});

//enroll
Route::prefix('student-enroll')->group(function () {

    Route::get('/', [enrollController::class, 'student_enroll'])->name('student_enroll')->middleware('eval');
    Route::post('/enroll', [enrollController::class, 'enroll'])->name('enroll');
    Route::post('/update/phone/number', [enrollController::class, 'updatePhoneNumber']);
    Route::post('/check-enrollment', [enrollController::class, 'checkEnrollment'])->name('checkEnrollment');

    //print
    Route::get('/enrollment-print-list', [enrollController::class, 'printEnrollmentList'])->name('printEnrollmentList');

    Route::get('enrollment/export', [enrollController::class, 'exportEnrollmentList'])->name('exportEnrollmentList');
});

// Enroll
Route::prefix("enroll")->group(function () {

    Route::get('/enrolled-list', [enrolledController::class, 'enrolledList'])->name('enrolledList');
    Route::post('/enrolled-list', [enrolledController::class, 'enrolledList'])->name('enrolledList');
    Route::post('/tmp/institute-logo-upload', [enrolledController::class, 'tmp_IinstituteLogo_upload']);
    Route::delete('/tmp/file-delete', [enrolledController::class, 'tmp_InstituteLogo_delete']);

    Route::get('/enrollment-list-load', [enrolledController::class, 'loadEnrollmentList'])->name('loadEnrollmentList');

    Route::get('/sync_data_recorrect', [enrolledController::class, 'sync_data_recorrect'])->name('sync_data_recorrect');

    Route::get('/change-student-status', [enrolledController::class, 'changeStudentStatus'])->name('change-student-status');
    Route::post('/change-student-status', [enrolledController::class, 'changeStudentStatus'])->name('change-student-status');
});

/**Grading sheet route function**/
Route::prefix('onlinerequest/dashboard')->group(function () {

    Route::get('/dashboard', [onlinerequestController::class, 'dashboard'])->name('dashboard');
    Route::get('/student/dashboard', [onlinerequestController::class, 'student_dashboard'])->name('student_dashboard')->middleware('eval');

    Route::get('/get_offices_services', [onlinerequestController::class, 'get_offices_services'])->name('get_offices_services');

    Route::post('/student/load_requested_data', [onlinerequestController::class, 'load_requested_data'])->name('load_requested_data');
    Route::get('/student/load_requested_data', [onlinerequestController::class, 'load_requested_data'])->name('load_requested_data');
    Route::get('/get_receive_date_f/{id}', [onlinerequestController::class, 'get_receive_function_request'])->name('get_receive_function_request');
    Route::post('/receive_date_function', [onlinerequestController::class, 'receive_date_function'])->name('receive_date_function');
     Route::get('/printR/{id}/print', [onlinerequestController::class, 'printR_request'])->name('printR_request');

    Route::get('/manage_or', [onlinerequestController::class, 'manage_or'])->name('manage_or');

    Route::post('/get_offices', [onlinerequestController::class, 'get_office_departmentlist'])->name('get_office_departmentlist');
    Route::get('/edit_offices/{id}/edit', [onlinerequestController::class, 'edit_offices_manage'])->name('edit_offices_manage');
    Route::get('/delete_offices/{id}/delete', [onlinerequestController::class, 'delete_offices'])->name('delete_offices');
    Route::post('/store_new_office', [onlinerequestController::class, 'store_new_office'])->name('store_new_office');
    Route::post('/list_of_offices_and_services', [onlinerequestController::class, 'get_list_of_offices_and_services'])->name('get_list_of_offices_and_services');
    Route::post('/store_officeServices', [onlinerequestController::class, 'store_officeServices'])->name('store_officeServices');
    Route::get('/store_officeServices', [onlinerequestController::class, 'store_officeServices'])->name('store_officeServices');
    Route::get('/delete_services_f/{id}/delete', [onlinerequestController::class, 'delete_services'])->name('delete_services');
    Route::post('/load_student_request', [onlinerequestController::class, 'load_student_request'])->name('load_student_request');
    Route::post('/store_student_request', [onlinerequestController::class, 'student_request_application'])->name('student_request_application');
        Route::get('/store_student_request', [onlinerequestController::class, 'student_request_application'])->name('student_request_application');
    Route::get('/get_requested_action/{id}/edit', [onlinerequestController::class, 'approval_requested_action'])->name('approval_requested_action');
    Route::post('/requested_action_approval', [onlinerequestController::class, 'requested_action_approval'])->name('requested_action_approval');
    Route::get('/requested_action_approval', [onlinerequestController::class, 'requested_action_approval'])->name('requested_action_approval');
    Route::get('/print_transcation', [onlinerequestController::class, 'print_request_transactions'])->name('print_request_transactions');
    Route::post('/print_transcation', [onlinerequestController::class, 'print_request_transactions'])->name('print_request_transactions');
    Route::post('/set_account_inoffice', [onlinerequestController::class, 'load_set_account_office'])->name('load_set_account_office');

    Route::post('/set_user_account_update', [onlinerequestController::class, 'set_user_account_update'])->name('set_user_account_update');
    Route::get('/set_user_account_update', [onlinerequestController::class, 'set_user_account_update'])->name('set_user_account_update');

    Route::get('/printRequestList_byProgram', [onlinerequestController::class, 'printRequestList_byProgram'])->name('printRequestList_byProgram');
    Route::post('/printRequestList_byProgram', [onlinerequestController::class, 'printRequestList_byProgram'])->name('printRequestList_byProgram');

  Route::post('/create_temporaryfiles', [onlinerequestController::class, 'create_temporaryfiles'])->name('create_temporaryfiles');

    Route::delete('/remove_attachement_documents', [onlinerequestController::class, 'remove_attachement_documents'])->name('remove_attachement_documents');

     Route::get('/download_attachment_documents/{id}/download', [onlinerequestController::class, 'download_attachment_documents'])->name('download_attachment_documents');

      Route::get('/get_taeuser', [onlinerequestController::class, 'load_admin_employee_data'])->name('load_admin_employee_data');


});
/**End Grading sheet route function**/


/*Begin:Student ledger*/
Route::prefix('student_ledger')->group(function(){

    Route::get('/my/ledger', [myLedger::class,'index'])->name('my_ledger')->middleware(handleUserPriv::class)->middleware('eval');
    Route::get('/display/user/info',[myLedger::class,'getUserInfo']);
    Route::get('/my/subsidiary/ledger',[myLedger::class,'displayStudentLedger']);
    Route::post('/my/subsidiary/ledger/details',[myLedger::class,'getStudentAssessmentDetails']);
    Route::post('/my/payment',[myLedger::class, 'getStudentpaymentDetails']);
});
/*END:Student ledger*/

//Student List
Route::prefix('students')->group(function () {

    Route::get('/', [ListController::class, 'student_list'])->name('student_list')->middleware('employees_auth');

    Route::post('/load/list', [ListController::class, 'loadESMS_Students']);
});
//

//Academic Records
Route::prefix('academic-records')->group(function () {

    Route::get('/', [academicRecords::class, 'academic_transcript'])->name('academic_transcript')->middleware('eval');

});
//

//Academic Records
Route::prefix('curriculum')->group(function () {

    Route::get('/', [curriculumController::class, 'curriculum'])->name('curriculum');
    Route::get('/load-subjects', [curriculumController::class, 'load_subjects'])->name('load_subjects');

    Route::POST('/save-curriculum', [curriculumController::class, 'save_curriculum'])->name('save_curriculum');
    Route::get('/save-curriculum', [curriculumController::class, 'save_curriculum'])->name('save_curriculum');

    Route::get('/load-data', [curriculumController::class, 'curriculum_data'])->name('curriculum_data');

    Route::get('/curriculum-list-load', [curriculumController::class, 'loadCurriculumList'])->name('loadCurriculumList');

    Route::POST('/remove-sy-endpoint', [curriculumController::class, 'remove_sy_endpoint'])->name('remove_sy_endpoint');
    Route::GET('/remove-sy-endpoint', [curriculumController::class, 'remove_sy_endpoint'])->name('remove_sy_endpoint');
    Route::POST('/remove-subject-endpoint', [curriculumController::class, 'remove_subject_endpoint'])->name('remove_subject_endpoint');
    Route::GET('/remove-subject-endpoint', [curriculumController::class, 'remove_subject_endpoint'])->name('remove_subject_endpoint');
    Route::POST('/remove-semester-endpoint', [curriculumController::class, 'remove_semester_endpoint'])->name('remove_semester_endpoint');
    Route::GET('/remove-semester-endpoint', [curriculumController::class, 'remove_semester_endpoint'])->name('remove_semester_endpoint');

    Route::POST('/load-curriculum-update', [curriculumController::class, 'load_curriculum_update'])->name('load_curriculum_update');
    Route::GET('/load-curriculum-update', [curriculumController::class, 'load_curriculum_update'])->name('load_curriculum_update');


    Route::get('/my-curriculum', [curriculumController::class, 'my_curriculum'])->name('my_curriculum')->middleware('eval');

    Route::get('/print/curriculum/{type}', [curriculumController::class, 'printCurriculum'])->name('printCurriculum');
    Route::get('/load/fetch/data', [curriculumController::class, 'loadFetchData'])->name('loadFetchData');
});
//

/*Begin:Event*/
Route::prefix('event')->group(function(){
    Route::get('/reminder',[eventReminder::class,'index'])->name('event_reminder');
    Route::post('/saved/event/list',[eventReminder::class,'saveEventReminder']);
    Route::get('/display/list',[eventReminder::class,'getEventReminder']);
    Route::post('/update/status',[eventReminder::class,'updateStat']);
    Route::get('/notif/load',[eventReminder::class,'getNotification']);
    Route::post('/saved/notif/view',[eventReminder::class,'SavedUserView']);
    Route::post('/list/program',[eventReminder::class,'displayProgram']);
    Route::post('/delete/event/list',[eventReminder::class,'deleteEventList']);
    Route::get('/retrieved/event',[eventReminder::class,'getEventReminderList']);
});
/*End:Event*/



/** STUDENT'S CLEARANCE */

Route::prefix('student/clearance')->group(function(){

    Route::get('/my/clearance',[studentClearance::class,'myClearance'])->name('myClearance')->middleware('auth');
    Route::get('/overview',[studentClearance::class,'overview'])->name('overview')->middleware('employees_auth');

    Route::post('/load/my/signatories',[studentClearance::class,  'load_All_MySignatories']);
    Route::post('/approve/clearance',[studentClearance::class,  'approveClearance']);
    Route::post('/resubmit/clearance',[studentClearance::class,  'resubmitClearance']);
    Route::post('/load/created/clearance',[studentClearance::class,  'load_All_StudentClearance']);
    Route::post('/load/my/recent/activities',[studentClearance::class,  'loadMyClearanceRecentActivities']);


    Route::post('/dismiss/important/notes',[studentClearance::class,  'dismissImportantNotes']);
    Route::post('/create/important/notes',[studentClearance::class,  'createImportantNotes']);


    Route::post('/load/my/clearance',[studentClearance::class,  'load_myStudentClearance']);
    Route::post('/request/clearance',[studentClearance::class,  'requestStudentClearance']);
    Route::post('/view/signed/data',[studentClearance::class,  'viewMyClearanceSignedData']);

    Route::post('/create',[studentClearance::class,  'createClearance'])->middleware('employees_auth');
    Route::post('/delete',[studentClearance::class,  'deleteClearance'])->middleware('employees_auth');
    Route::post('/view/signatories',[studentClearance::class,  'viewClearanceSignatories'])->middleware('employees_auth');
    Route::post('/update/status',[studentClearance::class,  'updateClearanceStatus'])->middleware('employees_auth');
    Route::post('/use/template',[studentClearance::class,  'useClearanceTemplate'])->middleware('employees_auth');

    Route::post('/signatory/list-load',[studentClearance::class,  'load_All_Signatories'])->middleware('employees_auth');
    Route::post('/employee/list-load',[studentClearance::class,  'load_All_Employees'])->middleware('employees_auth');
    Route::post('/student/list-load',[studentClearance::class,  'load_All_Students'])->middleware('employees_auth');
    Route::post('/student/add-to/signatories',[studentClearance::class,  'addStudentToSignatories'])->middleware('employees_auth');
    Route::post('/employee/add-to/signatories',[studentClearance::class,  'addEmployeeToSignatories'])->middleware('employees_auth');
    Route::post('/add/designation',[studentClearance::class,  'addSignatoryDesignation'])->middleware('employees_auth');
    Route::post('/remove/from/signatories',[studentClearance::class,  'removeFromSignatory'])->middleware('employees_auth');

    Route::get('/print/clearance/{clearance_id}',[studentClearance::class,  'studentPrintClearance']);

});






















































/** -----------------   MONT'Z ROUTE'S HERE     -----------------*/

    /** ACCOUNT MANAGEMENT */
    Route::prefix("ASIS/admin")->group(function () {

        Route::get('/manage/students/accounts', [AdminController::class, 'adminStudentsAccountManagement'])->name('adminStudentsAccountManagement')->middleware('employees_auth');
        Route::post('/list-load',[AdminController::class,  'loadAll_MYSQL_Students'])->middleware('employees_auth');
        Route::post('/update/students/account',[AdminController::class,  'updateStudentsAccount'])->middleware('employees_auth');

        Route::get('/manage/enrollees/accounts', [AdminController::class, 'adminEnrolleesAccountManagement'])->name('adminEnrolleesAccountManagement')->middleware('employees_auth');
        Route::post('/enrollees/list-load',[AdminController::class,  'loadEnrolleesAccounts'])->middleware('employees_auth');
        Route::post('/update/enrollees/account',[AdminController::class,  'updateEnrolleessAccount'])->middleware('employees_auth');


        Route::get('/students/e-sms', [ListController::class, 'student_list'])->name('student_list')->middleware('employees_auth');
        Route::post('/load/list', [ListController::class, 'loadESMS_Students'])->middleware('employees_auth');

    });


    /** PRE-ENROLLEES  */
    Route::prefix('enrollees')->group(function(){


      /**   BEGIN: ADMIN FOR PRE ENROLLEES **/
          Route::get('/schedule/overview', [ScheduleController::class, 'adminScheduleOverview'])->name('enrollees_overview')->middleware('employees_auth');
          Route::post('/load/schedule',[ScheduleController::class,  'adminLoadSchedule'])->middleware('employees_auth');
          Route::post('/save/schedule',[ScheduleController::class,  'save_schedule'])->middleware('employees_auth');
          Route::post('/delete/schedule',[ScheduleController::class,  'delete_schedule'])->middleware('employees_auth');

          Route::post('/load/appointments',[ScheduleController::class,  'adminLoadAppointments'])->middleware('employees_auth');
          Route::post('/search/name/appointments',[ScheduleController::class,  'searchNameAppointments'])->middleware('employees_auth');
          Route::post('/approve/disapprove/appointments',[ScheduleController::class,  'approveDisapproveAppointments'])->middleware('employees_auth');

      /**   END: ADMIN FOR PRE ENROLLEES **/



      /*    BEGIN: PRE ENROLLEES    */
          Route::get('/schedule',[ScheduleController::class, 'mySchedule'])->name('enroll_schedule')->middleware(['enrollees_auth', 'verified_enrollees_email', 'account_status_guard']);
          Route::post('/load/enrollees/schedule',[ScheduleController::class,  'userLoadSchedule'])->middleware('enrollees_auth');
          Route::post('/submit/appointment',[ScheduleController::class,  'submit_appointment'])->middleware('enrollees_auth');

      /*    END: PRE ENROLLEES    */


    });





    /** TRANSACTIONS  */
    Route::prefix('transaction')->group(function(){

        /** LOAD PRE-ENROLLEES TRANSACTION */
        Route::get('/list', [TransactionController::class, 'transactionList'])->name('transactionList')->middleware('transactions_guard');
        Route::post('/list-load',[TransactionController::class,  'loadAllTransactions'])->middleware('employees_auth');


        /** LOAD PRE-ENROLLEES TRANSACTION */
        Route::get('/my/transaction',[TransactionController::class, 'myTransaction'])->name('myTransaction')->middleware(['enrollees_auth', 'verified_enrollees_email', 'account_status_guard']);
        Route::post('/my/list-load',[TransactionController::class,  'loadMyTransactions'])->middleware('enrollees_auth');


        Route::get('/list/details/{transactionId}', [TransactionController::class, 'transactionListDetails'])->name('transactionListDetails');
        Route::get('/print/details/{transactionId}', [TransactionController::class, 'transactionPrintDetails']);

    });


    /** ENTRANCE EXAM  */
    Route::prefix('exam')->group(function(){

        Route::get('/list', [EntranceExamController::class, 'entranceExamineesList'])->name('entranceExamineesList')->middleware('employees_auth');
        Route::post('/list-load',[EntranceExamController::class,  'loadExamineesToday'])->middleware('employees_auth');
        Route::post('/update/status',[EntranceExamController::class,  'updateExaminationStatus'])->middleware('employees_auth');
        Route::post('/update/stanine/score',[EntranceExamController::class,  'updateStanineExamScore'])->middleware('employees_auth');


        Route::get('/rated/list', [EntranceExamController::class, 'entranceExamineesRatedList'])->name('entranceExamineesRatedList')->middleware('employees_auth');
        Route::post('/rated/list-load',[EntranceExamController::class,  'loadRatedEnrollees'])->middleware('employees_auth');
        Route::post('/rated/update/status',[EntranceExamController::class,  'updateExamRatedListStatus'])->middleware('employees_auth');


        Route::get('/short/listed', [EntranceExamController::class, 'entranceExamineesShortList'])->name('entranceExamineesShortList')->middleware('employees_auth');
        Route::post('/short/listed-load',[EntranceExamController::class,  'loadShortListedEnrollees'])->middleware('employees_auth');



        Route::get('/my/result', [EntranceExamController::class, 'myEntranceExamResult'])->name('myEntranceExamResult')->middleware('enrollees_auth');

    });


    /** PROGRAM  */
    Route::prefix('program')->group(function(){

        Route::get('/overview', [ProgramController::class, 'programOverview'])->name('programOverview')->middleware('employees_auth');
        Route::post('/list-load',[ProgramController::class,  'loadPrograms'])->middleware('employees_auth');
        Route::post('/update/program/slots',[ProgramController::class,  'updateProgramSlots'])->middleware('employees_auth');
    });



    Route::get('/asis/profile',[\App\Http\Controllers\Pre_Enrollees\ProfileController::class, 'my_profile'])->name('asis_profile');
    Route::post('/get/profile',[\App\Http\Controllers\Pre_Enrollees\ProfileController::class, 'loadProfileInformation']);
    Route::post('/temp/profile/upload', [\App\Http\Controllers\Pre_Enrollees\ProfileController::class, 'temp_upload_profile_picture']);
    Route::post('/save/profile/picture', [\App\Http\Controllers\Pre_Enrollees\ProfileController::class, 'save_profile_picture']);
    Route::post('/update/profile/information', [\App\Http\Controllers\Pre_Enrollees\ProfileController::class, 'updateProfileInformation']);
    Route::post('/update/account/settings', [\App\Http\Controllers\Pre_Enrollees\ProfileController::class, 'updateAccountSettings']);


    /** SELECT2  BIND ADDRESSES  */
    Route::post('/get/address/province', [\App\Http\Controllers\Pre_Enrollees\ProfileController::class, 'get_address_via_province']);
    Route::post('/get/address/municipality', [\App\Http\Controllers\Pre_Enrollees\ProfileController::class, 'get_address_via_municipality']);
    Route::post('/get/res/address/barangay', [\App\Http\Controllers\Pre_Enrollees\ProfileController::class, 'get_residential_brgy']);
    Route::post('/get/per/address/barangay', [\App\Http\Controllers\Pre_Enrollees\ProfileController::class, 'get_permanent_brgy']);


    /** DELETE Profile Picture  */
    Route::delete('/temp/profile/delete', [\App\Http\Controllers\Pre_Enrollees\ProfileController::class, 'delete_profile_picture']);


/*End:PRE ENROLLEES*/
