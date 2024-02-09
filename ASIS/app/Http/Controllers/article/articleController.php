<?php

namespace App\Http\Controllers\article;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class articleController extends Controller
{
    public function my_Article(){
        return view ('article.myArticlePage');
    }
}
