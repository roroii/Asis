<?php

namespace App\Http\Controllers\request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use Auth;

use Session;
use PDF;



class RequestController extends Controller
{


    /* REQUEST START ============ */

    public function request_overview_load_view() {
        
        return view('request.overview');

    }

    /* REQUEST END ============ */



    /* PDF ================================== */

    public function pdf_load($title = "Print", $content = "", $papersize = "a4", $orientation = "portrait", $margins = "margin: 0.1in 0.1in;", $fontFamily = "sans-serif"){


        $style = '@page { ' . $margins . ' } body { ' . $margins . ' font-family: sans-serif; } .tbl,.tbl tr,.tbl td,.tbl th,.tbl tbody,.tbl thead,.tbl tfoot { padding: 0; margin: 0; border-spacing: 0; } .tbl-1 td,.tbl-1 th { padding: 0; margin: 0; border-spacing: 0; border: 1px solid #000; } .ta-center { text-align: center; } .uppercase { text-transform: uppercase; } ';

        $data = [
            'title' => $title,
            'date' => date('m/d/Y'),
            'content' => $content,
            'style' => $style,
        ];

        $html = view('dtr.print', $data)->with("current_timestamp",$this->get_current_datetime(2))->with('data',$data)->render();
        return @\PDF::loadHTML($html, 'utf-8')->setPaper($papersize, $orientation)->set_option('defaultMediaType', 'all')->set_option('isFontSubsettingEnabled', true)->stream();
        
    }
 


    /* PDF ================================== */


}
