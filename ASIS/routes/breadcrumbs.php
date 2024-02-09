<?php // routes/breadcrumbs.php

//use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

use App\Models\ASIS_Models\pre_enrollees\enrollees_appointment;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;


// Dashboard
Breadcrumbs::for('Dashboard', function ($trail) {
$trail->push('Dashboard', route('home'));
});

// Dashboard / Documents / Document Scanner
Breadcrumbs::for('Document Scanner', function ($trail) {
    $trail->parent('Dashboard');
//    $trail->parent('Documents');
    $trail->push('Document Scanner', route('scanner'));
});

// Dashboard / Documents / My Documents
Breadcrumbs::for('My Documents', function ($trail) {
//    $trail->parent('Document Scanner');
    $trail->parent('Dashboard');
    $trail->push('My Documents', route('my_documents'));
});

// Dashboard / Documents / Incoming
Breadcrumbs::for('Incoming Documents', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Incoming Documents', route('incoming'));
});

// Dashboard / Documents / Received
Breadcrumbs::for('Received Documents', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Received Documents', route('received'));
});

// Dashboard / Documents / Outgoing
Breadcrumbs::for('Outgoing Documents', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Outgoing Documents', route('outgoing'));
});

// Dashboard / Documents / Hold
Breadcrumbs::for('Hold Documents', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Hold Documents', route('hold'));
});

// Dashboard / Documents / Returned
Breadcrumbs::for('Returned Documents', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Returned Documents', route('returned'));
});

// Dashboard / Documents / Trash Bin
Breadcrumbs::for('Trash Bin', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Trash Bin', route('trash'));
});


// Dashboard / Admin / Responsibility Center
Breadcrumbs::for('Responsibility Center', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Responsibility Center', route('rc'));
});

// Dashboard / Admin / Groups
Breadcrumbs::for('Groups', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Groups', route('group'));
});

// Dashboard / Admin / User Privileges
Breadcrumbs::for('User Privileges', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('User Privileges', route('user_privileges'));
});

// Dashboard / Admin / Document Settings
Breadcrumbs::for('Document Settings', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Document Settings', route('document_settings'));
});

// Dashboard / Admin / Link Lists
Breadcrumbs::for('Link List', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Link List', route('link_lists'));
});

// Dashboard / Application
Breadcrumbs::for('Application', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Application', route('application'));
});

// Dashboard / My Profile
Breadcrumbs::for('My Profile', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('My Profile', route('profile'));
});

// Dashboard / Schedule
Breadcrumbs::for('Schedule', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Schedule', route('schedule'));
});


Breadcrumbs::for('Clearance', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Clearance', route('my_clearance'));
});

Breadcrumbs::for('Overview', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Overview', route('Overview'));
});


Breadcrumbs::for('Student List', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Student List', route('student_list'));
});

Breadcrumbs::for('Vote Type', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Vote Type', route('votingType'));
});

Breadcrumbs::for('Vote Position', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Vote Position', route('votingPosition'));
});

Breadcrumbs::for('Election Application', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Election Application', route('elecApplication'));
});

Breadcrumbs::for('Vote', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Vote', route('elecParticipants'));
});

Breadcrumbs::for('My Signature', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('My Signature', route('my_signature'));
});

Breadcrumbs::for('Election Result', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Election Result', route('elecParticipants'));
});

Breadcrumbs::for('Election Parties', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Election Parties', route('elect_parties_page'));
});

Breadcrumbs::for('Enrollee_Schedule', function ($trail) {

    $trail->push('Schedule', route('enroll_schedule'));
});


Breadcrumbs::for('My Clearance', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('My Clearance', route('myClearance'));
});



/** BEGIN: ADMIN HERE */
// EMPLOYEE DASHBOARD
Breadcrumbs::for('Employee Dashboard', function ($trail) {
    $trail->push('Dashboard', route('enrollees_dashboard'));
});

// EMPLOYEE SCHEDULE OVERVIEW
Breadcrumbs::for('Enrollees_Overview', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Overview', route('enrollees_overview'));
});
// EMPLOYEE TRANSACTION LIST
Breadcrumbs::for('Transactions', function ($trail) {
    $trail->parent('Employee Dashboard');
    $trail->push('Transactions', route('transactionList'));
});

// EMPLOYEE NESTED TO DETAILS
Breadcrumbs::for('Transaction Details', function ($trail, $transactionId) {

    $trail->parent('Transactions');
    $trail->push('Details', route('transactionListDetails', $transactionId));

});

// CLEARANCE OVERVIEW
Breadcrumbs::for('Clearance Overview', function ($trail) {
    $trail->parent('Employee Dashboard');
    $trail->push('Clearance Overview', route('overview'));
});

// EMPLOYEE ENTRANCE EXAM LIST
Breadcrumbs::for('Examinees List', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Examinees List', route('entranceExamineesList'));
});

// EMPLOYEE ENTRANCE SHORT LISTED
Breadcrumbs::for('Short List', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Short List', route('entranceExamineesShortList'));
});

// STUDENTS ACCOUNT MANAGEMENT
Breadcrumbs::for('Students Accounts', function ($trail) {
    $trail->parent('Employee Dashboard');
    $trail->push('Students Accounts', route('adminStudentsAccountManagement'));
});


// ENROLLEES ACCOUNT MANAGEMENT
Breadcrumbs::for('Enrollees Accounts', function ($trail) {
    $trail->parent('Employee Dashboard');
    $trail->push('Enrollees Accounts', route('adminStudentsAccountManagement'));
});

// EMPLOYEE ENTRANCE SHORT LISTED
Breadcrumbs::for('Program', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Program', route('programOverview'));
});

// EMPLOYEE ENTRANCE RATED LISTED
Breadcrumbs::for('Rated List', function ($trail) {
    $trail->parent('Dashboard');
    $trail->push('Rated List', route('entranceExamineesRatedList'));
});

/** END:: ADMIN HERE */



/** BEGIN:: PRE - ENROLLEESS HERE */
// PRE ENROLLEES DASHBOARD
Breadcrumbs::for('Pre-Enrollees Dashboard', function ($trail) {
    $trail->push('Dashboard', route('enrollees_home'));
});
// PRE ENROLLEES MY TRANSACTIONS
Breadcrumbs::for('My Transactions', function ($trail) {
    $trail->parent('Pre-Enrollees Dashboard');
    $trail->push('Transactions', route('myTransaction'));
});

Breadcrumbs::for('My Transaction Details', function ($trail, $transactionId) {

    $trail->parent('My Transactions');
    $trail->push('Details', route('myTransactionDetails', $transactionId));

});

// PRE ENROLLEES MY ENTRANCE EXAM RESULT
Breadcrumbs::for('My Entrance Exam Result', function ($trail) {
    $trail->parent('Pre-Enrollees Dashboard');
    $trail->push('My Entrance Exam Result', route('myEntranceExamResult'));
});
/** END:: PRE - ENROLLEESS HERE */


