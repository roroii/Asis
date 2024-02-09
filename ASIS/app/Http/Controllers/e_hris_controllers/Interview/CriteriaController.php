<?php

namespace App\Http\Controllers\Interview;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Interview\Criteria;

class CriteriaController extends Controller
{
    public function index(){
        return view('interview.criteria');
    }

    public function load(Request $request){
        $data = $request->all();
        $tres = [];
        $name = '';


        $awards = Criteria::with('area')->get();
        foreach ($awards as $dt) {
            $name='<a href="" class="font-medium whitespace-nowrap">'. $dt->name .'</a>
                    <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">'. $dt->desc .'</div>';


            $td = [
                "id" => $dt->id,
                "name" => $name,
                "nature"=> $dt->nature,
                "areas"=> $dt->area->count()
            ];
            $tres[count($tres)] = $td;
        }

        echo json_encode($tres);
    }
}
