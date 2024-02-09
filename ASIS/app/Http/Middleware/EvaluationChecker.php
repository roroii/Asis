<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ASIS_Models\Evaluation\EvalActive;
use App\Models\ASIS_Models\Evaluation\Evaluation;
use App\Models\ASIS_Models\posgres\portal\srgb\employeeee;
use App\Models\ASIS_Models\posgres\portal\srgb\semsubject;
use App\Models\ASIS_Models\posgres\portal\srgb\registration;

class EvaluationChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->role == 'Admin') {
            return $next($request);
        } else {
            $stud = auth()->user()->studid;
        
            $active = EvalActive::where('active', '1')->first();
        
            if ($active && $active->exists()) {
                $from = $active -> date_from;
                $to = $active -> date_to;
                $currentDate = date('Y-m-d');
                
                if (strtotime($currentDate) >= strtotime($from) && strtotime($currentDate) <= strtotime($to)) {
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
                                return redirect('/student-evaluation');
                            } else {
                                return $next($request);
                            }
        
                        } else {
                            return $next($request);
                        }
        
                    } else {
                        return $next($request);
                    }
                } else {
                    return $next($request);
                }
            } else {
                return $next($request);
            }
        }

    }
}
