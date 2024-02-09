<?php

namespace App\Http\Controllers\others;

use App\Http\Controllers\Controller;
use App\Models\others\admin_term_condition;
use Auth;
use Illuminate\Http\Request;

class TermConditionController extends Controller
{


    public function index_terms_and_condition(){

        return view('others.terms_condition.index');
    }

    public function update_terms_and_condition(Request $request){
        $data = $request->all();

        $add_update_tc = [
            'title' => Auth::user()->employee,
            'desc_content' => $request->desc_content,
            'author' => Auth::user()->employee,
            'created_by' => Auth::user()->employee,
        ];

        $tc_id = admin_term_condition::updateOrCreate(['id' => $request->tc_id],$add_update_tc)->id;
        $load_content = admin_term_condition::where('active',1)->first();

        return json_encode(array(
            "data"=>$data,
            "load_content"=>$load_content,
        ));
     }
}
