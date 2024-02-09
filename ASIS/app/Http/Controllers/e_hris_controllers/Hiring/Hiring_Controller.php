<?php

namespace App\Http\Controllers\Hiring;

use App\Http\Controllers\Controller;
use App\Models\Hiring\tbl_job_doc_requirements;
use App\Models\PDS\pds_cs_eligibility;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Hiring\tbl_hiringavailable;
use App\Models\Hiring\tbl_position;
use App\Models\Hiring\tbl_hiringlist;
use App\Models\Hiring\tbl_salarygrade;
use App\Models\Hiring\tbl_positionType;
use App\Models\Hiring\tblpanels;
use Carbon\Carbon;

class Hiring_Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

// position type dre
public function positionType_page(){
    return view('hiring_blade.positionType_page');
}
//Fetch Position Type
public function fetchedPosition_type(){

    try
    {
        $output = '';
        $i = 1;

        $positionType_data = tbl_positionType::orderBy('positiontype', 'asc')->where('active', 1)->get();

        if ($positionType_data->count() > 0) {
			$output .= '<table id="positionType_Table" class="table table-sm text-center align-middle">
            <thead>
              <tr>
              <th class="text-center whitespace-nowrap ">ID</th>
              <th class="text-center whitespace-nowrap ">Position Type</th>
              <th class="text-center whitespace-nowrap ">Description</th>
              <th class="text-center whitespace-nowrap "> Action</th>
              </tr>
            </thead>
            <tbody>';
            foreach($positionType_data as $positionType){

            $output .= '<tr class="item-center text-center">
                            <td>'. $i++ .'</td>

                            <td>' . $positionType->positiontype . '</td>
                            <td>' . $positionType->desc . '</td>

                            <td>
                            <div class="flex justify-center items-center">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="More Action">
                                    <a class="flex justify-center items-center" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h items-center text-center text-primary"></i> </a>
                                    <div class="dropdown-menu w-40">
                                        <div class="dropdown-content">
                                            <a id="'.$positionType->id.'" data-pt="'.$positionType->positiontype.'" data-ptd="'.$positionType->desc.'" href="javascript:;"
                                                class="dropdown-item editPosType" data-tw-toggle="modal" data-tw-target="#add_Pos_type_modal">
                                                    <i class="fa fa-edit w-4 h-4 mr-2 text-success"></i> Edit
                                            </a>
                                            <a id="'.$positionType->id.'" href="javascript:;" class="dropdown-item delete_Position_category"> <i class="fa fa-trash-alt w-4 h-4 mr-2 text-danger"></i> Delete </a>
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
            echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
        }

        //     foreach($positionType_data as $positionType)
        //     {

        //         $td = [
        //             "position_type" => $datas -> id,
        //             "desciption" => $position -> emp_position,
        //             ];
        //             $load_typeData[count($load_typeData)] = $td;

        //     }
        // echo json_encode($load_typeData);

    }catch(Throwable $e)
    {
        report($e);
    }
}

//delete Position type
public function deletePosition_category(Request $request){
    
    $criteria_id = tbl_positionType::where('id', $request->positionCategory_id)->first();

    $removeToRow = [
        'active' => 0,
    ];
    $criteria_id->update($removeToRow);

    return response()->json(['status' => 200]);
}

// End of Position Type Controller


// Add $ Update Position Type
public function save_update_positionType(Request $request){
    // dd($request->all());
    if($request->typeID == ""){
        $savePos_type = new tbl_positionType;
        $savePos_type->positiontype = $request->input('positionType');
        $savePos_type->desc = $request->input('type_desc');
        $savePos_type->save();

        return response()->json([
            'status' => "save",
        ]);
    }else{
        // dd('update');
        $id = tbl_positionType::where('id', $request->typeID)
            ->update([ 'positiontype' => $request->positionType,'desc' => $request->type_desc,]);

        return response()->json([
            'status' => "updated",
        ]);
    }
}
// End of Position Type =====================================================================================================================

    // public function view_hiring()
    // {
    //     return view('hiring_blade.hiring');
    // }

    // public function hiring_position(Request $request)
    // {
    //     try{

    //         //use the date now to as referrence for the generated id
    //         $date = Carbon::now()->format('d-m-y');
    //         //responsible for generating an id
    //         $id =$this->IDGenerator(new tbl_hiringavailable,'ref_num',4,$date);
    //         //get the panel
    //         $panel = $this->save_panels($id,$request->temp_panels);

    //         $hiring_start = $this->change_date_format($request->hiring_start);
    //         $hiring_until = $this->change_date_format($request->hiring_until);

    //         $data = [
    //             "positionid" => $request->position,
    //             "ref_num" => $id,
    //             "descriptions" => $request->text_description,
    //             "salarygrade" => $request->salary_grade,
    //             "salaryrate" => $request->salary_rate,
    //             "hiring_start" => $hiring_start,
    //             "hiring_until" => $hiring_until,
    //             "pos_type" => $request->pos_type,
    //             "status" => false,
    //         ];
    //         $saved_hiring = tbl_hiringavailable::create($data);
    //         $panel;
    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Successfully Saved'
    //         ]);

    //     } catch(Exception $e)
    //     {
    //         dd($e);
    //     }

    // }

    // //generate an id
    // private static function IDGenerator($model,$trow,$lenght=4,$prefix)
    // {
    //     $data = $model::orderBy('id','desc')->first();
    //     if(!$data)
    //     {
    //         $log_length = $lenght;
    //         $last_number = '';
    //     } else{
    //         $code = substr($data->$trow, strlen($prefix)+1);
    //         $actual_last_number = ($code/1)*1;
    //         $increment_last_number = $actual_last_number+1;
    //         $last_number_length = strlen($increment_last_number);
    //         $log_length = $lenght - $last_number_length;
    //         $last_number = $increment_last_number;
    //     }
    //     $zeros = "";
    //     for($i=0;$i<$log_length;$i++)
    //     {
    //         $zeros.="0";
    //     }
    //     return $prefix.'-'.$zeros.$last_number;
    // }

    //  //save different panels
    //  private function save_panels($id,$request)
    //  {
    //         foreach($request as $panel)
    //         {
    //          $saved_panel = tblpanels::create([
    //              'available_ref' => $id,
    //              'panel_id'=>$panel,
    //          ]);
    //         }
    //  }

    //  //get the list of the panel
    //  public function get_different_panels(Request $request)
    //  {
    //     $ref_num = $request->ref_num;
    //     $temp = [];

    //         $panels = tblpanels::where('available_ref',$ref_num)->get(['panel_id']);

    //         foreach($panels as $panel)
    //         {
    //             $td = [
    //                 'get_panel' => $panel->panel_id,
    //             ];
    //             $temp[count($temp)]=$td;
    //         }
    //         echo json_encode($temp);
    //  }

    //  //update the data
    //  public function upadate_hiring(Request $request)
    //  {
    //      $hiring_start = $this->change_date_format($request->hiring_start);
    //      $hiring_until = $this->change_date_format($request->hiring_until);
    //     //responsible for the update of the panels
    //      $panels_update = $this->update_panels($request->update_panel,$request->refference_num);

    //      $update_data = [
    //          "positionid" => $request ->position,
    //          "descriptions" => $request ->text_description,
    //          "salarygrade" => $request ->salary_grade,
    //          "salaryrate" => $request ->salary_rate,
    //          "hiring_start" => $hiring_start,
    //          "hiring_until" => $hiring_until,
    //          "pos_type" => $request->pos_type,
    //      ];

    //      $update = tbl_hiringavailable::where('id','=',$request->hiring)->update($update_data);
    //      $panels_update;
    //      return response()->json([
    //          'status' => true,
    //          'message' => 'Successfully Updated'
    //      ]);
    //  }

    //  //update the different panel
    //  private function update_panels($panels,$request)
    //  {
    //        $delete = tblpanels::where('available_ref',$request)->delete();

    //        foreach($panels as $panel)
    //        {
    //             $insert = tblpanels::create([
    //                 'available_ref' => $request,
    //                 'panel_id' => $panel,
    //             ]);
    //        }
    //  }

    //  //delete the data
    //  public function delete_data(Request $request)
    //  {
    //      $delete_data = tbl_hiringavailable::where('id',$request->id)->update([
    //          'active' => '0'
    //      ]);
    //      return response()->json([
    //          'status' => true,
    //          'message' => 'Successfully Deleted'
    //      ]);
    //  }

    //  //close the hiring position
    //  public function close_position_status(Request $request)
    //  {
    //     $close_status = tbl_hiringavailable::where('id',$request->id)->update([
    //         'status'=>'0',
    //     ]);

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Position hiring is now close',
    //     ]);
    //  }

    //   //change the date format
    //   private function change_date_format($request)
    //   {
    //       $date = Carbon::createFromTimestamp(strtotime($request))->format('Y/m/d');
    //       return $date;
    //   }

    // //load the data from the tblhiring database up to the datatbale ==========================================================================================
    // public function load_hiring_list()
    // {
    //     try
    //     {
    //         $data = $this->load_data();
    //         $load_datable = [];

    //             foreach($data as $datas)
    //             {
    //                 $get_position = $this->get_pos($datas);

    //                 foreach($get_position as $position)
    //                 {
    //                     $getSalary = $this->get_salaryRate($datas);

    //                     foreach($getSalary as $rate)
    //                     {
    //                         $getpostype = $this->get_postype($datas);

    //                         foreach($getpostype as $position_type)
    //                         {
    //                             $panel = $this->get_panels($datas);
    //                             foreach($panel as $panels)
    //                             {
    //                                 if($datas->status!=0)
    //                                 {
    //                                     $td = [
    //                                         "hiring_id" => $datas -> id,
    //                                         "ref_num" => $datas->ref_num,
    //                                         "position" => $position -> emp_position,
    //                                         "position_id" => $datas -> positionid,
    //                                         "descriptions" => $datas -> descriptions,
    //                                         "description_title" => str::limit($datas->descriptions,20,'....'),
    //                                         "salarygrade" => $rate -> salarygrade,
    //                                         "salarygrade_id" => $datas -> salarygrade,
    //                                         "salaryrate" => $datas -> salaryrate,
    //                                         "hiring_start" => $datas -> hiring_start,
    //                                         "hiring_until" => $datas -> hiring_until,
    //                                         "pos_type" => $position_type -> positiontype,
    //                                         "pos_type_id" => $datas -> pos_type,
    //                                         "panel" => $panels ->panel_id,
    //                                         "status" => $datas->status,
    //                                        ];
    //                                        $load_datable[count($load_datable)] = $td;
    //                                 }
    //                             }

    //                         }

    //                     }

    //                 }
    //             }
    //         echo json_encode($load_datable);

    //     }catch(Throwable $e)
    //     {
    //         report($e);
    //     }
    // }
    // //instantiate the
    // private function load_data()
    // {
    //     return $load = tbl_hiringavailable::with('getPosition','getSalary_rate','getPosition_type','getPanels')->where('active','1')->where('status','1')->orderBy('id','ASC')->get();
    // }
    // //get the hiring position
    // private function get_pos($pos)
    // {
    //     return $pos->getPosition;
    // }
    // //get the salary rate
    // private function get_salaryRate($salary)
    // {
    //     return $salary->getSalary_rate;
    // }
    // //get the position type
    // private function get_postype($postype)
    // {
    //     return $postype->getPosition_type;
    // }
    // //get the panels
    // private function get_panels($panel)
    // {
    //     return $panel->getPanels->unique('available_ref');
    // }
}
