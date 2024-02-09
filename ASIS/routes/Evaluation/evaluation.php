<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Evaluation\EvaluationController;

// Evaluation
Route::prefix('student-evaluation')->group(function () {

    Route::get('/', [EvaluationController::class, 'student_eval'])->name('student_eval');
    
    Route::get('get_instructor', [EvaluationController::class, 'get_instructor'])->name('get_instructor'); 


    // ============== Begin : Active Question and Scale ============
    Route::get('load_active_scale', [EvaluationController::class, 'load_active_scale'])->name('load_active_scale'); 
    
    Route::get('load_active_title', [EvaluationController::class, 'load_active_title'])->name('load_active_title'); 

    Route::get('load_desc_title', [EvaluationController::class, 'load_active_scale'])->name('load_desc_title'); 

    Route::get('load_ques_body', [EvaluationController::class, 'load_ques_body'])->name('load_ques_body'); 

    Route::post('save_evaluation', [EvaluationController::class, 'save_evaluation'])->name('save_evaluation');
    // ============== End : Active Question and Scale ============
    
    // ============== Begin : Rating Scale ============
    Route::get('load_temp_scale', [EvaluationController::class, 'load_temp_scale'])->name('load_temp_scale'); 

    Route::get('clear_temp_scale', [EvaluationController::class, 'clear_temp_scale'])->name('clear_temp_scale'); 
    
    Route::post('savascale', [EvaluationController::class, 'savascale'])->name('savascale'); 

    Route::post('deletescale', [EvaluationController::class, 'deletescale'])->name('deletescale'); 

    Route::post('savescale', [EvaluationController::class, 'savescale'])->name('savescale'); 
    // ============== End : Rating Scale ============
    

    // ============== Begin : Questionnaire ============ 
    Route::get('load_temp_ques', [EvaluationController::class, 'load_temp_ques'])->name('load_temp_ques');

    Route::post('add_temp_ques', [EvaluationController::class, 'add_temp_ques'])->name('add_temp_ques');
    
    Route::get('clear_temp_ques', [EvaluationController::class, 'clear_temp_ques'])->name('clear_temp_ques');

    Route::post('save_temp_ques', [EvaluationController::class, 'save_temp_ques'])->name('save_temp_ques');

    Route::post('dlt_temp_ques', [EvaluationController::class, 'dlt_temp_ques'])->name('dlt_temp_ques');
    // ============== End : Questionnaire ============


    // ============== Begin : Change Active ============ 
    Route::get('getscalename', [EvaluationController::class, 'getscalename'])->name('getscalename');

    Route::get('getquesname', [EvaluationController::class, 'getquesname'])->name('getquesname');

    Route::get('get_active_data', [EvaluationController::class, 'get_active_data'])->name('get_active_data');

    Route::post('change_active_ques', [EvaluationController::class, 'change_active_ques'])->name('change_active_ques');
    // ============== End : Change Active ============ 
});