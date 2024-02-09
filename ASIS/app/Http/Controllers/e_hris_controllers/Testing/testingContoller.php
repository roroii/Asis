<?php

namespace App\Http\Controllers\Testing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\testing\testPart_model;
use App\Models\testing\testQtype_model;
use App\Models\testing\testQuestion_model;
use App\Models\testing\testChoice_model;

class testingContoller extends Controller
{
    public function testing_page(){
        return view('testing/testing_page');
    }
    public function testPart(){
        $output = '';
        $testPart = testPart_model::where('active', 1)->get();
        if ($testPart->count() > 0) {
            $output .= ' <table id="tbl_criteria" class="table table-report table-hover text-center align-middle">
            <thead>

                    <tr>
                        <th class="text-center whitespace-nowrap ">Test Part</th>
                        <th class="text-center whitespace-nowrap ">Description</th>
                        <th class="text-center whitespace-nowrap ">Action</th>
                    </tr>

            </thead>
            <tbody>';
            foreach($testPart as $t_part){


                //    dd($position);

                $output .= '<tr class="text-center">

                                <td>' .$t_part->test_part. '</td>

                                <td>
                                    ' .$t_part->description. '
                                </td>

                                <td>

                                    <div class="flex justify-center items-center">

                                        <div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="More Action">
                                            <a class="flex justify-center items-center" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h items-center text-center text-primary"></i> </a>
                                            <div class="dropdown-menu w-40">
                                                <div class="dropdown-content">
                                                    <a id="'.$t_part->id.'" data-test-part="'.$t_part->test_part.'" data-part-desc="'.$t_part->description.'" href="javascript:;"
                                                        class="dropdown-item edit_Tpart">
                                                            <i class="fa fa-edit w-4 h-4 mr-2 text-success"></i> Edit
                                                    </a>
                                                    <a id="'.$t_part->id.'" href="javascript:;" class="dropdown-item delete_Tpart"> <i class="fa fa-trash-alt w-4 h-4 mr-2 text-danger"></i> Delete </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </td>
                            </tr>';

            }
                    $output .= '</tbody></table>';

                echo $output;
        }else{
            echo '<div class="accordion-item text-center">
                    <div id="faq-accordion-content-4" class="accordion-header text-center">
                        <button class="accordion-button text-center collapsed" type="button"> No Data Found in Database!! </button>
                    </div>

                </div>';
        }
    }
    public function testQuestion_types(){

        $output = '';
        $testTypes = testQtype_model::where('active', 1)->get();
        if ($testTypes->count() > 0) {
            $output .= ' <table id="tbl_criteria" class="table table-report table-hover text-center align-middle">
            <thead>

                    <tr>
                        <th class="text-center whitespace-nowrap ">Question Types</th>
                        <th class="text-center whitespace-nowrap ">Description</th>
                        <th class="text-center whitespace-nowrap ">Action</th>
                    </tr>

            </thead>
            <tbody>';
            foreach($testTypes as $testType){


                //    dd($position);

                $output .= '<tr class="text-center">

                                <td>' .$testType->question_type. '</td>

                                <td>
                                    ' .$testType->description. '
                                </td>

                                <td>

                                    <div class="flex justify-center items-center">

                                        <div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="More Action">
                                            <a class="flex justify-center items-center" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h items-center text-center text-primary"></i> </a>
                                            <div class="dropdown-menu w-40">
                                                <div class="dropdown-content">
                                                    <a id="'.$testType->id.'" data-test-question="'.$testType->question_type.'" data-type-desc="'.$testType->description.'" href="javascript:;"
                                                        class="dropdown-item edit_Tpart">
                                                            <i class="fa fa-edit w-4 h-4 mr-2 text-success"></i> Edit
                                                    </a>
                                                    <a id="'.$testType->id.'" href="javascript:;" class="dropdown-item delete_Tpart"> <i class="fa fa-trash-alt w-4 h-4 mr-2 text-danger"></i> Delete </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </td>
                            </tr>';

            }
                    $output .= '</tbody></table>';

                echo $output;
        }else{
            echo '<div class="accordion-item text-center">
                    <div id="faq-accordion-content-4" class="accordion-header text-center">
                        <button class="accordion-button text-center collapsed" type="button"> No Data Found in Database!! </button>
                    </div>

                </div>';
        }

    }
    public function testQuestion(){

        $output = '';
        $testQuestions = testQuestion_model::where('active', 1)->get();
        if ($testQuestions->count() > 0) {
            $output .= ' <table id="tbl_criteria" class="table table-report table-hover text-center align-middle">
            <thead>

                    <tr>
                        <th class="text-center whitespace-nowrap ">Test Part</th>
                        <th class="text-center whitespace-nowrap ">Description</th>
                        <th class="text-center whitespace-nowrap ">Action</th>
                    </tr>

            </thead>
            <tbody>';
            foreach($testQuestions as $testQuestion){


                //    dd($position);

                $output .= '<tr class="text-center">

                                <td>' .$testQuestion->Question. '</td>

                                <td>
                                    ' .$testQuestion->ans_choice. '
                                </td>

                                <td>

                                    <div class="flex justify-center items-center">

                                        <div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="More Action">
                                            <a class="flex justify-center items-center" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h items-center text-center text-primary"></i> </a>
                                            <div class="dropdown-menu w-40">
                                                <div class="dropdown-content">
                                                    <a id="'.$testQuestion->id.'" data-test-question="'.$testQuestion->Question.'" data-question-ans="'.$testQuestion->ans_choice.'" href="javascript:;"
                                                        class="dropdown-item edit_Tpart">
                                                            <i class="fa fa-edit w-4 h-4 mr-2 text-success"></i> Edit
                                                    </a>
                                                    <a id="'.$testQuestion->id.'" href="javascript:;" class="dropdown-item delete_Tpart"> <i class="fa fa-trash-alt w-4 h-4 mr-2 text-danger"></i> Delete </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </td>
                            </tr>';

            }
                    $output .= '</tbody></table>';

                echo $output;
        }else{
            echo '<div class="accordion-item text-center">
                    <div id="faq-accordion-content-4" class="accordion-header text-center">
                        <button class="accordion-button text-center collapsed" type="button"> No Data Found in Database!! </button>
                    </div>

                </div>';
        }

    }
    public function testChoise(){
        $output = '';
        $testChoices = testChoice_model::where('active', 1)->get();
        if ($testChoices->count() > 0) {
            $output .= ' <table id="tbl_criteria" class="table table-report table-hover text-center align-middle">
            <thead>

                    <tr>
                        <th class="text-center whitespace-nowrap ">Test Part</th>
                        <th class="text-center whitespace-nowrap ">Action</th>
                    </tr>

            </thead>
            <tbody>';
            foreach($testChoices as $testChoice){


                //    dd($position);

                $output .= '<tr class="text-center">

                                <td>' .$testChoice->test_choices. '</td>


                                <td>

                                    <div class="flex justify-center items-center">

                                        <div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="More Action">
                                            <a class="flex justify-center items-center" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h items-center text-center text-primary"></i> </a>
                                            <div class="dropdown-menu w-40">
                                                <div class="dropdown-content">
                                                    <a id="'.$testChoice->id.'" data-test-choice="'.$testChoice->test_choices.'" href="javascript:;"
                                                        class="dropdown-item edit_Tpart">
                                                            <i class="fa fa-edit w-4 h-4 mr-2 text-success"></i> Edit
                                                    </a>
                                                    <a id="'.$testChoice->id.'" href="javascript:;" class="dropdown-item delete_Tpart"> <i class="fa fa-trash-alt w-4 h-4 mr-2 text-danger"></i> Delete </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </td>
                            </tr>';

            }
                    $output .= '</tbody></table>';

                echo $output;
        }else{
            echo '<div class="accordion-item text-center">
                    <div id="faq-accordion-content-4" class="accordion-header text-center">
                        <button class="accordion-button text-center collapsed" type="button"> No Data Found in Database!! </button>
                    </div>

                </div>';
        }
    }
}
