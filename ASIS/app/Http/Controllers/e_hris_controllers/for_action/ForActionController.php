<?php

namespace App\Http\Controllers\for_action;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForActionController extends Controller
{
    //FOR ACTION documents
    public function f_action(){
        return view('admin.management.account');
    }
}
