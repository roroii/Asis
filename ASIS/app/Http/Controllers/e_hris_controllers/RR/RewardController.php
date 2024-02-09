<?php

namespace App\Http\Controllers\RR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\rr\Rewards;
use Illuminate\Support\Str;

class RewardController extends Controller
{

    /*  ============ */

    public function DB_SCHEMA() {
        return "primehrmo.";
    }

    public function DBTBL_AWARDS() {
        $result = [
            "driver" => "e-hris",
            "table" => $this->DB_SCHEMA() . "rr_awards",
        ];
        return $result;
    }

    public function DBTBL_AWARD_TYPES() {
        $result = [
            "driver" => "e-hris",
            "table" => $this->DB_SCHEMA() . "rr_award_types",
        ];
        return $result;
    }

    public function DBTBL_EVENTS() {
        $result = [
            "driver" => "e-hris",
            "table" => $this->DB_SCHEMA() . "rr_events",
        ];
        return $result;
    }

    public function DBTBL_EVENTS_AWARDS() {
        $result = [
            "driver" => "e-hris",
            "table" => $this->DB_SCHEMA() . "rr_events_awards",
        ];
        return $result;
    }

    /*  ============ */



    public function load_view(){
        return view('rr.rewards');
    }

    public function load_data(Request $request){
        $data = $request->all();
        $tres = [];
        $name = '';

        $awards = Rewards::get();

        foreach ($awards as $dt) {
            $cut=Str::limit($dt->desc, 120);
            $name='<a href="" class="font-medium whitespace-nowrap">'. $dt->name .'</a>
                    <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">'. $cut .'</div>';
            $td = [
                "id" => $dt->id,
                "name" => $name,
                "type" => $dt->type,
            ];

            $tres[count($tres)] = $td;
        }
        echo json_encode($tres);
    }


}
