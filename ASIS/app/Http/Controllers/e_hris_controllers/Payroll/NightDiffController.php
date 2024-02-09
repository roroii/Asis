<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payroll\NightDiff;

class NightDiffController extends Controller
{
    //
    public function index(){
        return view('payroll.nightdiff');
    }

    public function loadsetup(Request $request){
        $data = $request->all();
        $tres = [];
        $name = '';


        $nightdiff = NightDiff::get();
        foreach ($nightdiff as $dt) {

            $td = [
                "id" => $dt->id,
                "name" => $dt->name,
                "desc"=> $dt->desc,
                "mode"=> $dt->mode,
                "value"=>$dt->value
            ];
            $tres[count($tres)] = $td;
        }

        echo json_encode($tres);
    }
}
