<?php

namespace App\Http\Controllers\Evaluation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ASIS_Models\Evaluation\Answersss;
use App\Models\ASIS_Models\Evaluation\EvalActive;
use App\Models\ASIS_Models\Evaluation\Evaluation;
use App\Models\ASIS_Models\Evaluation\RatingScale;
use App\Models\ASIS_Models\Evaluation\EvalQuestion;
use App\Models\ASIS_Models\Evaluation\EvalTempQues;
use App\Models\ASIS_Models\posgres\portal\srgb\employeeee;
use App\Models\ASIS_Models\posgres\portal\srgb\semsubject;
use App\Models\ASIS_Models\posgres\portal\srgb\registration;

class EvaluationController extends Controller
{
    public function student_eval() {
        return view('Evaluation.evaluation');
    }

    public function get_instructor() {
        $stud = auth()->user()->studid;
    
        $active = EvalActive::where('active', '1')->first();
    
        if ($active) {
            $get = registration::select('subjcode')
                ->where('studid', $stud)
                ->where('sy', $active->sy)
                ->where('sem', $active->sem)
                ->get();

            if ($get->isNotEmpty()) {
                $subjcodes = $get->pluck('subjcode');
    
                $instructorsArray = [];

                foreach ($subjcodes as $subjcode) {
                    $faculty = semsubject::select('facultyid')
                        ->where('subjcode', $subjcode)
                        ->where('sy', $active->sy)
                        ->where('sem', $active->sem)
                        ->first();
    
                    if ($faculty && $faculty->facultyid !== null) {
                        $instructorsArray[] = trim($faculty->facultyid);
                    } 
                }

                if (!empty($instructorsArray)) {

                    $instructorNames = [];

                    foreach ($instructorsArray as $namee) {
                        $name = employeeee::select('empid', 'fullname')
                            ->where('empid', $namee)
                            ->first();
                    
                        if ($name && $name->fullname !== null) {
                            $checkExists = Evaluation::where('instructor_id', $namee)
                                ->where('stud_id', $stud)
                                ->where('sy', $active->sy)
                                ->where('sem', $active->sem)
                                ->exists();

                            if (!$checkExists) {
                                $instructorNames[] = [
                                    'id' => $name->empid,
                                    'fullname' => $name->fullname,
                                ];
                            }
                        }
                    }
                    
                    if (!empty($instructorNames)) {
                        return response()->json($instructorNames);
                    } else {
                        return response()->json('empty');
                    }

                } else {
                    return response()->json('empty');
                }

            } else {
                if (auth()->user()->role == 'Admin') {
                    return response()->json('bypass');
                } else {
                    return response()->json('empty');
                }
            }

        } else {
            return response()->json('empty');
        }
    }

    // ============== Begin : Active ============
    public function load_active_scale() {
        $active = EvalActive::first();
        
        if ($active === null) {
            return response()->json('empty');
        } else {
            $scale = $active->rating_scale;
            $from = $active->date_from;
            $to = $active->date_to;
            $currentDate = date('Y-m-d');
    
            if ($scale === null) {
                return response()->json('empty');
            } else {
                if (auth()->user()->role == 'Admin') {
                    $get = RatingScale::where('scale_name', $scale)
                        ->orderBy('id', 'asc')
                        ->get();

                    return response()->json($get);
                } else {
                    if (strtotime($currentDate) >= strtotime($from) && strtotime($currentDate) <= strtotime($to)) {
                        $get = RatingScale::where('scale_name', $scale)
                            ->orderBy('id', 'asc')
                            ->get();
        
                        return response()->json($get);
                    } else {
                        return response()->json('empty');
                    }
                }
            }
        }
    }
    
    public function load_active_title() {
        $active = EvalActive::first();
        
        if ($active === null) {
            return response()->json('empty');
        } else {
            $questions = $active->questions;
            $from = $active->date_from;
            $to = $active->date_to;
            $currentDate = date('Y-m-d');
    
            if ($questions === null) {
                return response()->json('empty');
            } else {
                if (auth()->user()->role == 'Admin') {
                    $get = EvalQuestion::where('id', $questions)->first();
    
                    return response()->json($get);
                } else {
                    if (strtotime($currentDate) >= strtotime($from) && strtotime($currentDate) <= strtotime($to)) {
                        $get = EvalQuestion::where('id', $questions)->first();
    
                        return response()->json($get);
                    } else {
                        return response()->json('empty');
                    }
                }
            }
        }
    }

    public function load_ques_body() {
        $active = EvalActive::first();
        
        if ($active === null) {
            return response()->json('empty');
        } else {
            $questions = $active->questions;
            $from = $active->date_from;
            $to = $active->date_to;
            $currentDate = date('Y-m-d');
    
            if ($questions === null) {
                return response()->json('empty');
            } else {
                if (auth()->user()->role == 'Admin') {
                    $get = EvalTempQues::where('ques_name_id', $questions)
                        ->orderBy('id', 'ASC') 
                        ->get(); 
            
                    return response()->json($get);
                } else {
                    if (strtotime($currentDate) >= strtotime($from) && strtotime($currentDate) <= strtotime($to)) {
                        $get = EvalTempQues::where('ques_name_id', $questions)
                            ->orderBy('id', 'ASC') 
                            ->get(); 
                
                        return response()->json($get);
                    } else {
                        return response()->json('empty');
                    }
                }
            }
        }
    }

    public function save_evaluation(Request $request) {
        try {
            $instructorId = $request->input('instructorId');
            $remarks = $request->input('remarks');
            $answers = $request->input('answers');
            $stud = auth()->user()->studid;

            $active = EvalActive::first();
        
            if ($active === null) {
                return response()->json('empty');
            } else {
                $sy = $active->sy;
                $sem = $active->sem;
        
                $saveIns = Evaluation::create([
                    'instructor_id' => $instructorId,
                    'stud_id' => $stud,
                    'sy' => $sy,
                    'sem' => $sem,
                    'remarks' => $remarks
                ]);

                if($saveIns) {
                    $instid = $saveIns -> id;

                    foreach ($answers as $ans) {
                        $questionId = $ans['questionName'];
                        $answerId = $ans['answerId'];

                        $saveAns = Answersss::create([
                            'instruc_id' => $instid,
                            'question_id' => $questionId,
                            'answer_id' => $answerId
                        ]);
                    }

                    return response()->json(['message' => 'success']);
                } else {
                    return response()->json(['message' => 'empty']);
                }
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage()); 
            return response()->json(['error' => 'An error occurred while saving the evaluation'], 500);
        }
    }
    // ============== End : Active ============



    // ============== Begin : Rating Scale ============
    public function load_temp_scale() {
        $get = RatingScale::where('scale_name', null)
            ->orderBy('id', 'asc')
            ->get();
    
        return response()->json($get);
    }

    public function savascale(Request $request) {
        $numerical = $request->input('numerical');
        $descriptive = $request->input('descriptive');
        $qualitative = $request->input('qualitative');

        $newEntry = RatingScale::create([
            'numerical' => $numerical,
            'descriptive' => $descriptive,
            'qualitative' => $qualitative
        ]);

        if ($newEntry) {
            return response()->json(['msg' => 'success']);
        } else {
            return response()->json(['msg' => 'failed']);
        }
    }

    public function deletescale(Request $request) {
        $id = $request->input('id');

        $dlt = RatingScale::find($id);

        if ($dlt->delete()) {
            return response()->json(['msg' => 'success']);
        } else {
            return response()->json(['msg' => 'failed']);
        }
    }

    public function savescale(Request $request) {
        $name = $request->input('name');

        $check = RatingScale::where('scale_name', $name)->get();

        if ($check -> isNotEmpty()) {
            return response()->json(['msg' => 'exist']);
        } else {
            $change = RatingScale::where('scale_name', null)->update(['scale_name' => $name]);
        
            if ($change) {
                return response()->json(['msg' => 'success']);
            } else {
                return response()->json(['msg' => 'failed']);
            }
        }
    }

    public function clear_temp_scale() {
        $clear = RatingScale::where('scale_name', null)->get();

        if ($clear->isNotEmpty()) {
            $clear->each(function ($item) {
                $item->delete();
            });

            return response()->json(['msg' => 'success']);
        } else {
            return response()->json(['msg' => 'failed']);
        }
    }
    // ============== End : Rating Scale ============



    // ============================ Begin : Questionnaire ==========================
    public function load_temp_ques() {
        $get = EvalTempQues::where('ques_name_id', null)
            ->orderBy('id', 'ASC') 
            ->get(); 

        return response()->json($get);
    }
    
    public function add_temp_ques(Request $request) {
        $type = $request->input('type');
        $ques = $request->input('ques');

        $insert = EvalTempQues::create([
            'ques_type' => $type,
            'ques_ques' => $ques
        ]);

        if ($insert) {
            return response()->json(['msg' => 'success']);
        } else {
            return response()->json(['msg' => 'failed']);
        }
    }

    public function clear_temp_ques() {
        $clear = EvalTempQues::where('ques_name_id', null)->get();

        if ($clear->isNotEmpty()) {
            $clear->each(function ($item) {
                $item->delete();
            });

            return response()->json(['msg' => 'success']);
        } else {
            return response()->json(['msg' => 'failed']);
        }
    }

    public function save_temp_ques(Request $request) {
        $name = $request->input('name');
        $title = $request->input('title');
        $sub = $request->input('sub');
        $direction = $request->input('direction');

        $check = EvalTempQues::where('ques_name_id', null)->get();

        if ($check -> isEmpty()){
            return response()->json(['msg' => 'empty']);
        } else {
            $checkname = EvalQuestion::where('ques_name', $name)->get();

            if ($checkname-> isEmpty()) {
                $insert = EvalQuestion::create([
                    'ques_name' => $name,
                    'ques_title' => $title,
                    'ques_sub' => $sub,
                    'ques_direction' => $direction
                ]);
    
                $id = $insert->id;
    
                $save = EvalTempQues::where('ques_name_id', null)->update(['ques_name_id' => $id]);

                if ($save) {
                    return response()->json(['msg' => 'success']);
                } else {
                    return response()->json(['msg' => 'failed']);
                }
            } else {
                return response()->json(['msg' => 'exist']);
            }
            
        }
    }

    public function dlt_temp_ques(Request $request) {
        $id = $request->input('id');

        $dlt = EvalTempQues::where('id', $id)->first();

        if ($dlt -> delete()) {
            return response()->json(['msg' => 'success']);
        } else {
            return response()->json(['msg' => 'failed']);
        }
    }
    // ============================ End : Questionnaire ==========================



    // ============================ Begin : Change Active ==========================
    public function getscalename() {
        $get = RatingScale::select('scale_name')
            ->whereNotNull('scale_name')
            ->groupBy('scale_name')
            ->get();

        return response()->json($get);
    }
    
    public function getquesname() {
        $get = EvalQuestion::get();

        return response()->json($get);
    }

    public function get_active_data() {
        $active = EvalActive::first();

        return response()->json($active);
    }

    public function change_active_ques(Request $request) {
        $ques = $request->input('ques');
        $scale = $request->input('scale');
        $from = $request->input('from');
        $to = $request->input('to');
        $sy = $request->input('sy');
        $sem = $request->input('sem');

        $check = EvalActive::where('active', '1')->first();
    
        if ($check === null) {
            $insert = EvalActive::create([
                'rating_scale' => $scale,
                'questions' => $ques,
                'date_from' => $from,
                'date_to' => $to,
                'sy' => $sy,
                'sem' => $sem,
                'active' => '1'
            ]);
    
            if ($insert) {
                return response()->json(['msg' => 'success']);
            } else {
                return response()->json(['msg' => 'failed']);
            }
        } else {
            $change = EvalActive::where('active', '1')->update(['rating_scale' => $scale,'questions' => $ques, 'date_from' => $from, 'date_to' => $to, 'sy' => $sy, 'sem' => $sem]);
    
            if ($change) {
                return response()->json(['msg' => 'success']);
            } else {
                return response()->json(['msg' => 'failed']);
            }
        }
    }
    // ============================ End : Change Active ==========================
}
