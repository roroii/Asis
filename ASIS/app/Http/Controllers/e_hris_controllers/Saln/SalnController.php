<?php

namespace App\Http\Controllers\Saln;

use App\Http\Controllers\Controller;
use App\Models\saln\saln_biafc;
use App\Models\saln\saln_info;
use App\Models\saln\saln_liabilities;
use App\Models\saln\saln_personal_properties;
use App\Models\saln\saln_real_properties;
use App\Models\saln\saln_ritgs;
use App\Models\saln\saln_unmarried_children;
use Auth;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class SalnController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('auth',['except' => ['login','setup','setupSomethingElse']]);
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function mysaln()
    {

        return view('saln.mysaln');
    }


    public function load_saln()
    {
        $userID = Auth::user()->employee;

        $tres = [];

        $saln = saln_info::
            where('active',1)
            ->where('created_by',Auth::user()->employee)
            ->orderBy('created_at', 'DESC')
            ->get();

        foreach ($saln as $sln) {

            $declarant_miden = '';
                        if($sln->declarant_middlename){
                            $declarant_miden = mb_substr($sln->declarant_middlename, 0, 1) .'. ';
                        }
                        $declarant_name = $sln->declarant_firstname .' '.$declarant_miden.' '. $sln->declarant_lastname;


                        $spouse_miden = '';
                        if($sln->declarant_middlename){
                            $spouse_miden = mb_substr($sln->spouse_middlename, 0, 1) .'. ';
                        }
                        $spouse_name = $sln->spouse_firstname .' '.$spouse_miden.' '. $sln->spouse_lastname;

            $td = [
                "id" => $sln->id,
                "declarant_name" => strtoupper($declarant_name),
                "spouse_name" => strtoupper($spouse_name),
                "created_at" => format_date_time(1,  Carbon::parse($sln->created_at)),
                "liabilities_total" => $sln->liabilities_total,
                "acquisition_personal_prop_total" => $sln->acquisition_personal_prop_total,
                "net_worth" => $sln->net_worth,
            ];
            $tres[count($tres)] = $td;

        }
        echo json_encode($tres);

    }

    public function add_saln(Request $request)
    {
        $data = $request->all();

        if($request->save_or_update === 'Save'){

        }

        $countbiafcs = 1;
        $countritgs = 1;


        if($request->table_biafc_nameofentity){
            $countbiafcs = 0;
        }
        if($request->table_ritgs_nameofrelative){
            $countbiafcs = 0;
        }

            //add
            $joint_filing = '0';
            $separate_filing = '0';
            $not_applicable = '0';

            if($request->modal_joint_filing == 1){
                $joint_filing = '1';
                $separate_filing = '0';
                $not_applicable = '0';
            }else if($request->modal_joint_filing == 2){
                $separate_filing = '1';
                $joint_filing = '0';
                $not_applicable = '0';
            }else if($request->modal_joint_filing == 3){
                $not_applicable = '1';
                $joint_filing = '0';
                $separate_filing = '0';
            }

            // if($request->modal_spouse_firstname){
            //     $joint_filing = '1';
            //     $separate_filing = '0';
            //     $not_applicable = '0';
            // }else{
            //     $separate_filing = '1';
            //     $joint_filing = '0';
            //     $not_applicable = '0';
            // }

            $ACQUISITIONCOST = 0;
            $RealPropertiessubtotal = 0;
            $PersonalPropertiessubtotal = 0;
            $TOTALASSETS = 0;
            $TOTALLIABILITIES = 0;
            $NETWORTH = 0;

            $add_saln = [
                'as_of' => $request->as_of,

                'joint_filing' => $joint_filing,
                'separate_filing' => $separate_filing,
                'not_applicable' => $not_applicable,

                'declarant_firstname' => $request->modal_declarant_firstname,
                'declarant_lastname' => $request->modal_declarant_lastname,
                'declarant_middlename' => $request->modal_declarant_middlename,
                'declarant_address' => $request->modal_declarant_address,
                'declarant_position' => $request->modal_declarant_position,
                'declarant_agency_office' => $request->modal_declarant_agency_office,
                'declarant_office_address' => $request->modal_declarant_office_address,
                'declarant_id' => $request->modal_declarant_id,
                'declarant_id_num' => $request->modal_declarant_id_no,
                'declarant_id_date' => $request->modal_declarant_date,

                'spouse_firstname' => $request->modal_spouse_firstname,
                'spouse_lastname' => $request->modal_spouse_lastname,
                'spouse_middlename' => $request->modal_spouse_middlename,
                'spouse_position' => $request->modal_spouse_position,
                'spouse_agency_office' => $request->modal_spouse_agency_office,
                'spouse_office_address' => $request->modal_spouse_office_address,
                'spouse_id' => $request->modal_spouse_id,
                'spouse_id_num' => $request->modal_spouse_no,
                'spouse_id_date' => $request->modal_spouse_date,


                'acquisition_assets_total' => $ACQUISITIONCOST,
                'acquisition_personal_prop_sub_total' => $request->modal_real_prop_sub_total,
                'acquisition_personal_prop_total' => $request->modal_personal_pro_sub_total,

                'liabilities_total' => $request->modal_total_liabilities,
                'net_worth' => $request->modal_total_net_worth,

                'biafc_has_business_interest' => $countbiafcs,
                'ritgs_has_gov_serv_relative' => $countritgs ,



                'created_by' => Auth::user()->employee,

            ];

            $saln_id = saln_info::updateOrCreate(['id' => $request->saln_id],$add_saln)->id;

            if ($request->has('table_un_chil_name')) {
                foreach ($request->table_un_chil_name as $i => $name) {

                    $add_unmarried_children = [
                        'saln_id' => $saln_id,
                        'name' => $name,
                        'dateofbirth' => $request->table_un_chil_dateofbirth[$i],
                        'age' => $request->table_un_chil_age[$i],
                        'created_by' =>Auth::user()->employee,
                    ];

                    $unmarried_children_id = saln_unmarried_children::updateOrCreate(['id' => $request->table_un_chil_id[$i]],$add_unmarried_children)->id;
                }
            }


            if ($request->has('modal_asset_description')) {
                foreach ($request->modal_asset_description as $in => $description) {

                    $add_asset = [
                        'saln_id' => $saln_id,
                        'description' => $description,
                        'kind' => $request->modal_asset_kind[$in],
                        'exact_location' => $request->modal_asset_exact_loc[$in],
                        'assessed_value' => $request->modal_asset_assesed_value[$in],
                        'market_value' => $request->modal_asset_market_value[$in],
                        'year' => $request->modal_asset_year[$in],
                        'mode' => $request->modal_asset_mode[$in],
                        'cost' => $request->modal_asset_acquisition_cost[$in],
                        'created_by' =>Auth::user()->employee,
                    ];

                    $real_properties_id = saln_real_properties::updateOrCreate(['id' => $request->modal_asset_id[$in]],$add_asset)->id;

                    $RealPropertiessubtotal += $request->modal_asset_acquisition_cost[$in];
                }
            }

            if ($request->has('table_personal_prop_description')) {
                foreach ($request->table_personal_prop_description as $in => $prop_description) {

                    $add_personal_properties = [
                        'saln_id' => $saln_id,
                        'description' => $prop_description,
                        'year_acquired' => $request->table_personal_prop_year_acquired[$in],
                        'cost' => $request->table_personal_prop_acquisition_cost[$in],
                        'created_by' =>Auth::user()->employee,
                    ];

                    $personal_properties_id = saln_personal_properties::updateOrCreate(['id' => $request->table_personal_prop_id[$in]],$add_personal_properties)->id;

                    $PersonalPropertiessubtotal += $request->table_personal_prop_acquisition_cost[$in];
                }

            }

            $TOTALASSETS = $RealPropertiessubtotal + $PersonalPropertiessubtotal;


            if ($request->has('table_liabilities_nature')) {
                foreach ($request->table_liabilities_nature as $in => $liabilities) {

                    $add_liabilities = [
                        'saln_id' => $saln_id,
                        'nature' => $liabilities,
                        'name_of_creditors' => $request->table_liabilities_nameofcred[$in],
                        'out_standing_balance' => $request->table_liabilities_outstanding_balance[$in],
                        'created_by' =>Auth::user()->employee,
                    ];

                    $liabilities_id = saln_liabilities::updateOrCreate(['id' => $request->table_liabilities_id[$in]],$add_liabilities)->id;

                    $TOTALLIABILITIES += $request->table_liabilities_outstanding_balance[$in];
                }
            }


            if ($request->has('table_biafc_nameofentity')) {
                foreach ($request->table_biafc_nameofentity as $in => $nameofentity) {

                    $add_biafc = [
                        'saln_id' => $saln_id,
                        'name_of_entity' => $nameofentity,
                        'business_address' => $request->table_biafc_businessaddress[$in],
                        'nature_of_business_interest' => $request->table_biafc_natureofbusiness[$in],
                        'date_of_acquisistion' => $request->table_biafc_dateofacquisition[$in],
                        'created_by' =>Auth::user()->employee,
                    ];

                    $biafc_id = saln_biafc::updateOrCreate(['id' => $request->table_biafc_id[$in]],$add_biafc)->id;
                }
            }


            if ($request->has('table_ritgs_nameofrelative')) {
                foreach ($request->table_ritgs_nameofrelative as $in => $nameofrelative) {

                    $add_ritgs = [
                        'saln_id' => $saln_id,
                        'name_of_relative' => $nameofrelative,
                        'relationship' => $request->table_ritgs_relationship[$in],
                        'position' => $request->table_ritgs_position[$in],
                        'name_of_agency' => $request->table_ritgs_nameofagency[$in],
                        'created_by' =>Auth::user()->employee,
                    ];

                    $ritgs_id = saln_ritgs::updateOrCreate(['id' => $request->table_ritgs_id[$in]],$add_ritgs)->id;
                }
            }

            $NETWORTH = $TOTALASSETS -  $TOTALLIABILITIES ;

            $update_saln = [
                'acquisition_assets_total' => $RealPropertiessubtotal,
                'acquisition_personal_prop_sub_total' => $PersonalPropertiessubtotal ,
                'acquisition_personal_prop_total' => $TOTALASSETS ,
                'liabilities_total' => $TOTALLIABILITIES,
                'net_worth' => $NETWORTH ,
            ];
            saln_info::where(['id' =>  $saln_id])->first()->update($update_saln);

            $notif ='Added';
            if($request->saln_id){
                $notif ='Updated';
            }

            __notification_set(1, "SALN Added!", "SALN ".$notif." successfully!");
            add_log('saln', $saln_id,'SALN '. $notif.' Successfully!');



        return json_encode(array(
            "data"=>$data,
        ));
    }


    public function load_details(Request $request){
        $data = $request->all();

        $get_saln = saln_info::with('get_biafc',
        'get_liabilities',
        'get_personal_prop',
        'get_real_prop',
        'get_ritgs',
        'get_unm_chil')->where('id',$request->saln_id)->first();

        $get_biafc_table = '';

        if($get_saln->get_biafc()->exists()){
            foreach ($get_saln->get_biafc as $biafc) {

                $get_biafc_table .= '<tr class="hover:bg-gray-200">
                <td style="display: none"><input name="table_biafc_id[]" type="text" class="form-control table_biafc_id" placeholder="id" value="'.$biafc->id.'"></td>
                <td><input name="table_biafc_nameofentity[]" type="text" class="form-control" placeholder="NAME OF ENTITY/BUSINESS ENTERPRISE" value="'.$biafc->name_of_entity.'"></td>
                <td><input name="table_biafc_businessaddress[]" type="text" class="form-control" placeholder="BUSINESS ADDRESS" value="'.$biafc->business_address.'"></td>
                <td><input name="table_biafc_natureofbusiness[]" type="text" class="form-control" placeholder="NATURE OF BUSINESS INTEREST &/OR FINANCIAL CONNECTION" value="'.$biafc->nature_of_business_interest.'"></td>
                <td><input name="table_biafc_dateofacquisition[]" type="date" class="form-control" placeholder="DATE OF ACQUISITION OF INTEREST OR CONNECTION" value="'.$biafc->date_of_acquisistion.'"></td>
                <td><a href="javascript:void(0);" class="flex items-center text-theme-6 delete"><i  class="w-4 h-4 mr-1 far fa-trash-alt">Remove</i></a></td>
            </tr>';

            }
        }

        $get_liabilities_table = '';

        if($get_saln->get_liabilities()->exists()){
            foreach ($get_saln->get_liabilities as $liabilities) {

                $get_liabilities_table .= '<tr class="hover:bg-gray-200">
                <td style="display: none"><input name="table_liabilities_id[]" type="text" class="form-control table_liabilities_id" placeholder="id" value="'.$liabilities->id.'"></td>
                <td><input name="table_liabilities_nature[]" type="text" class="form-control" placeholder="NATURE" value="'.$liabilities->nature.'"></td>
                <td><input name="table_liabilities_nameofcred[]" type="text" class="form-control" placeholder="NAME OF CREDITORS" value="'.$liabilities->name_of_creditors.'"></td>
                <td><input name="table_liabilities_outstanding_balance[]" type="number" min="0" class="form-control table_liabilities_outstanding_balance" placeholder="OUTSTANDING BALANCE" value="'.$liabilities->out_standing_balance.'"></td>
                <td><a href="javascript:void(0);" class="flex items-center text-theme-6 delete"><i  class="w-4 h-4 mr-1 far fa-trash-alt">Remove</i></a></td>
            </tr>';

            }
        }

        $get_personal_prop_table = '';

        if($get_saln->get_personal_prop()->exists()){
            foreach ($get_saln->get_personal_prop as $personal_prop) {

                $get_personal_prop_table .= '<tr class="hover:bg-gray-200">
                <td style="display: none"><input name="table_personal_prop_id[]" type="text" class="form-control table_personal_prop_id" placeholder="id" value="'.$personal_prop->id.'"></td>
                <td><input name="table_personal_prop_description[]" type="text" class="form-control" placeholder="DESCRIPTION" value="'.$personal_prop->description.'"></td>
                <td><input name="table_personal_prop_year_acquired[]" type="text"  min="0" class="form-control" placeholder="YEAR ACQUIRED" value="'.$personal_prop->year_acquired.'"></td>
                <td><input name="table_personal_prop_acquisition_cost[]" type="number" min="0" class="form-control table_personal_prop_acquisition_cost" placeholder="ACQUISITION COST/AMOUNT" value="'.$personal_prop->cost.'"></td>
                <td><a href="javascript:void(0);" class="flex items-center text-theme-6 delete"><i  class="w-4 h-4 mr-1 far fa-trash-alt">Remove</i></a></td>
            </tr>';

            }
        }

        $get_real_prop_table = '';

        if($get_saln->get_real_prop()->exists()){
            foreach ($get_saln->get_real_prop as $real_prop) {

                $get_real_prop_table .= '<tr class="hover:bg-gray-200">
                <td style="display: none"><input name="modal_asset_id[]" type="text" class="form-control modal_asset_id" placeholder="id" value="'.$real_prop->id.'"></td>
                <td><input name="modal_asset_description[]" type="text" class="form-control" placeholder="DESCRIPTION" value="'.$real_prop->description.'"></td>
                <td><input name="modal_asset_kind[]" type="text" class="form-control" placeholder="KIND" value="'.$real_prop->kind.'"></td>
                <td><input name="modal_asset_exact_loc[]" type="text" class="form-control" placeholder="EXACT LOCATION" value="'.$real_prop->exact_location.'"></td>
                <td><input name="modal_asset_assesed_value[]" type="number"  min="0" class="form-control" placeholder="ASSESSED VALUE" value="'.$real_prop->assessed_value.'"></td>
                <td><input name="modal_asset_market_value[]" type="number"  min="0" class="form-control" placeholder="CURRENT FAIR MARKET VALUE" value="'.$real_prop->market_value.'"></td>
                <td><input name="modal_asset_year[]" type="text" class="form-control"  placeholder="Year" value="'.$real_prop->year.'"></td>
                <td><input name="modal_asset_mode[]" type="text" class="form-control" placeholder="Mode" value="'.$real_prop->mode.'"></td>
                <td><input name="modal_asset_acquisition_cost[]" type="number"  min="0" class="form-control modal_asset_acquisition_cost" placeholder="ACQUISITION COST" value="'.$real_prop->cost.'"></td>
                <td><a href="javascript:void(0);" class="flex items-center text-theme-6 delete"><i  class="w-4 h-4 mr-1 far fa-trash-alt">Remove</i></a></td>
            </tr>';

            }
        }


        $get_ritgs_table = '';

        if($get_saln->get_ritgs()->exists()){
            foreach ($get_saln->get_ritgs as $ritgs) {

                $get_ritgs_table .= '<tr class="hover:bg-gray-200">
                <td style="display: none"><input name="table_ritgs_id[]" type="text" class="form-control table_ritgs_id" placeholder="id" value="'.$ritgs->id.'"></td>
                <td><input name="table_ritgs_nameofrelative[]" type="text" class="form-control" placeholder="NAME OF RELATIVE" value="'.$ritgs->name_of_relative.'"></td>
                <td><input name="table_ritgs_relationship[]" type="text" class="form-control" placeholder="RELATIONSHIP" value="'.$ritgs->relationship.'"></td>
                <td><input name="table_ritgs_position[]" type="text" class="form-control" placeholder="POSITION" value="'.$ritgs->position.'"></td>
                <td><input name="table_ritgs_nameofagency[]" type="text" class="form-control" placeholder="NAME OF AGENCY/OFFICE AND ADDRESS" value="'.$ritgs->name_of_agency.'"></td>
                <td><a href="javascript:void(0);" class="flex items-center text-theme-6 delete"><i  class="w-4 h-4 mr-1 far fa-trash-alt">Remove</i></a></td>
            </tr>';

            }
        }


        $get_unm_chil_table = '';

        if($get_saln->get_unm_chil()->exists()){
            foreach ($get_saln->get_unm_chil as $unm_chil) {

                $get_unm_chil_table .= '<tr class="hover:bg-gray-200">
                    <td style="display: none"><input  name="table_un_chil_id[]" type="text" class="form-control table_un_chil_id" placeholder="id" value="'.$unm_chil->id.'"></td>
                    <td><input  name="table_un_chil_name[]" type="text" class="form-control" placeholder="Name" value="'.$unm_chil->name.'"></td>
                    <td><input  name="table_un_chil_dateofbirth[]" type="date" class="form-control" placeholder="Date of Birth" value="'.$unm_chil->dateofbirth.'"></td>
                    <td><input  name="table_un_chil_age[]" type="text" class="form-control" placeholder="Age" value="'.$unm_chil->age.'"></td>
                    <td><a href="javascript:void(0);" class="flex items-center text-theme-6 delete"><i  class="w-4 h-4 mr-1 far fa-trash-alt">Remove</i></a></td>
                </tr>';

            }
        }



        return json_encode(array(
            "data"=>$data,
            "get_saln"=>$get_saln,
            "get_biafc_table"=>$get_biafc_table,
            "get_liabilities_table"=>$get_liabilities_table,
            "get_personal_prop_table"=>$get_personal_prop_table,
            "get_real_prop_table"=>$get_real_prop_table,
            "get_ritgs_table"=>$get_ritgs_table,
            "get_unm_chil_table"=>$get_unm_chil_table,

        ));
    }



    public function remove_data_from_table(Request $request){
        $data = $request->all();

        if($request->has('type_id')){

            $update_remove_data_from_table = [
                'active' => '0',
            ];

            if($request->type == 'un_chil_table_modal'){

                saln_unmarried_children::where(['id' =>  $request->type_id])->first()->update($update_remove_data_from_table);

            }elseif($request->type == 'asset_modal_table'){
                saln_real_properties::where(['id' =>  $request->type_id])->first()->update($update_remove_data_from_table);

            }elseif($request->type == 'pp_modal_table'){
                saln_personal_properties::where(['id' =>  $request->type_id])->first()->update($update_remove_data_from_table);


            }elseif($request->type == 'liab_modal_table'){
                saln_liabilities::where(['id' =>  $request->type_id])->first()->update($update_remove_data_from_table);

            }elseif($request->type == 'buin_modal_table'){
                saln_biafc::where(['id' =>  $request->type_id])->first()->update($update_remove_data_from_table);


            }elseif($request->type == 'regs_modal_table'){
                saln_ritgs::where(['id' =>  $request->type_id])->first()->update($update_remove_data_from_table);

            }

            __notification_set(1,'Success','Item removed successfully!');
            add_log($request->type,$request->type_id,'SALN table item removed successfully!');
        }



        return json_encode(array(
            "data"=>$data,
        ));
    }

    public function remove_saln(Request $request){
        $data = $request->all();

        if($request->has('saln_id')){

            $update_remove = [
                'active' => '0',
            ];
            saln_info::where(['id' =>  $request->saln_id])->first()->update($update_remove);

        }

        __notification_set(1,'Success','SALN removed successfully!');

        add_log('saln',$request->saln_id,'SALN removed successfully!');

        return json_encode(array(
            "data"=>$data,
        ));
    }

    public function print($id, $type)
    {
        $now = date('m/d/Y g:ia');

        $datetime = Carbon::createFromFormat('m/d/Y g:ia', $now);
        $datetime->setTimezone('Asia/Manila');
        $current_date = $datetime->format('m-d-Y g:iA');

        $filename = 'pdf';

        $get_saln = saln_info::with('get_biafc',
        'get_liabilities',
        'get_personal_prop',
        'get_real_prop',
        'get_ritgs',
        'get_unm_chil')->where('id',$id)->first();

        //dd($sig_divs);
        $filename = 'SALN_'.$get_saln->declarant_firstname .'_'.$get_saln->declarant_lastname;

        $pdf = PDF::loadView('saln.print.print_saln',compact('get_saln','filename'))->setPaper('legal', 'portrait')->setOptions(['defaultFont' => 'Bookman Old']);

        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf ->get_canvas();
        $canvas->page_text(275, 950, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));

        if ($type == 'vw') {
            return $pdf->stream($filename . '.pdf');
        } elseif ($type == 'dl') {
            return $pdf->download($filename . '.pdf');
        }

    }


}
