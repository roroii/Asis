<?php

namespace App\Http\Controllers\ASIS_Controllers\admin;

use App\Exports\profileExport;
use App\Http\Controllers\Controller;
use App\Imports\ImportProfile;
use App\Models\ASIS_Models\pre_enrollees\enrollees_appointment;
use App\Models\ASIS_Models\pre_enrollees\pre_enrollees;
use App\Models\ASIS_Models\system\user_groups;
use App\Models\ASIS_Models\system\user_privilege;
use App\Models\ASIS_Models\system\user_rc_group;
use App\Models\tbl_responsibilitycenter;
use App\Models\tblemployee;
use App\Models\tblposition;
use App\Models\tbluserassignment;
use App\Models\User;
use Carbon\Carbon;
use Crypt;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

//        $this->middleware('auth');
//        $this->middleware('employees_auth');
        //$this->middleware('auth',['except' => ['login','setup','setupSomethingElse']]);
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function enrolleesAdminDashboard()
    {
        return view('admin.schedule.dashboard');
    }


    public function rescen()
    {
        return view('admin.management.rc');
    }

    public function add_rcmembers(Request $request){
        $data = $request->all();

        if($request->has('rc_members')){
            foreach($request->rc_members as $key => $user_id){
                $check = user_rc_group::where('user_id',$user_id)->where('rc_id',$request->rc_id_modal)->where('active',1)->first();
                if(!$check){
                    $add_members = [
                        'type' =>  'rc',
                        'type_id' =>  $request->rc_id_modal,
                        'user_id' =>  $user_id,
                        'rc_id' =>  $request->rc_id_modal,
                    ];
                    user_rc_group::create($add_members);
                    createNotification('rc',$request->rc_id_modal,'user',Auth::user()->employee,$user_id,'user','You have been added to a responsibility center as a member.');
                }

            }

        }


        __notification_set(1,'Success','Responsibility Center updated Successfuly!');
        add_log('rc',$request->rc_id_modal,'RC Members Added Successfuly!');

        return json_encode(array(
            "data"=>$data,
            "head"=>$request->rc_modal_head,
        ));
    }

    public function load_rcmembers(Request $request){
        $data = $request->all();
        $tres = [];

        $getmembers = user_rc_group::with('getUserinfo','getOffice')->where('type','rc')->where('type_id',$request->rc_id)->where('active',1)->get();


        foreach ($getmembers as $cd) {

                if($cd->getUserinfo)
                {

                    $first_name = $cd->getUserinfo->firstname;
                    $last_name = $cd->getUserinfo->lastname;

                }else
                {
                    $first_name = '';
                    $last_name = '';
                }
                $td = [
                    "id" => $cd->id,
                    "name" => $first_name .' '.$last_name,

                ];
                $tres[count($tres)] = $td;
            }


        echo json_encode($tres);

    }

    public function load_users(Request $request){
        $data = $request->all();

        if($request->user_id){
            $user = User::with('getUserinfo.getHRdetails.getPosition','getUserinfo.getHRdetails.getDesig')->where('employee',$request->user_id)->where('active',1)->first();
        }else{
            $user = User::with('getUserinfo.getHRdetails.getPosition','getUserinfo.getHRdetails.getDesig')->where('active',1)->get();
        }

        echo json_encode($user);

    }

    public function load_rc(Request $request){

        $data = $request->all();
        $tres = [];
        $rc_head_id = '';

        if($request->rc_id){
            $rc = \App\Models\ASIS_Models\HRIS_model\tbl_responsibilitycenter::with('sub_employeeinf')->where('responid',$request->rc_id)->where('active',1)->first();
        }else{
            $rc = \App\Models\ASIS_Models\HRIS_model\tbl_responsibilitycenter::with('sub_employeeinf')->where('active',1)->get();
        }

        foreach ($rc as $dt) {
            $fullname = '';
            if($dt->sub_employeeinf()->exists())
            {
                $fullname =  $dt->sub_employeeinf->firstname .' '.$dt->sub_employeeinf->lastname;
                $rc_head_id = $dt->sub_employeeinf->agencyid;

                if($dt->department)
                {
                    $department = $dt->department;
                }else
                {
                    $department = 'No Department set';
                }
            }else
            {
                $department = 'No Department set';
            }

                $td = [
                    "responid" => $dt->responid,
                    "centername" => $dt->centername,
                    "department" => $department,
                    "descriptions" => $dt->descriptions,
                    "head" => $dt->head,
                    "head_name" => $fullname,
                    "rc_head_id" => $rc_head_id,
                ];
                $tres[count($tres)] = $td;


        }
        //dd($fullname);
        echo json_encode($tres);

    }

    public function group()
    {
        return view('admin.management.group');
    }

    public function load_group(Request $request){
        $data = $request->all();
        $tres = [];

        if($request->group_id){

            $group = user_rc_group::with('getMembers')->where('id',$request->group_id)->where('active',1)->first();

        }else{

            $group = user_rc_group::with(['getMembers', 'getHead'])->where('type', 'group')->where('active',1)->get();


        }


        foreach ($group as $dt) {

            if($dt->getHead()->exists())
            {
                $td = [
                    "id" => $dt->id,
                    "name" => $dt->name,
                    "desc" => $dt->desc,
                    "group_head_id" =>$dt->getHead->agencyid,
                    "grpHeadLastname" => $dt->getHead->lastname,
                    "grpHeadFirstname" => $dt->getHead->firstname,

                ];
                $tres[count($tres)] = $td;

            }else{
                $td = [
                    "id" => $dt->id,
                    "name" => $dt->name,
                    "desc" => $dt->desc,

                ];
                $tres[count($tres)] = $td;
            }
        }

        //dd($fullname);
        echo json_encode($tres);

    }

    public function create_group(Request $request){
        $data = $request->all();

        if($request->has('modal_group_title')){

            $group = [
                'name' =>  $request->modal_group_title,
                'desc' =>  $request->modal_group_desc
            ];
            $group_id = user_groups::create($group)->id;

        }


        if($request->has('memberList')) {

            foreach($request->memberList as $key => $user_id){

                    $add_members = [
                        'type' =>  'group',
                        'type_id' =>  $group_id,
                        'user_id' =>  $user_id,
                        'group_id' =>  $group_id ,
                    ];
                    user_rc_group::create($add_members);
            }

            }

        __notification_set(1,'Success','Group '.$request->modal_group_title.' Created Successfuly!');
        add_log('group',$group_id,'Group '.$request->modal_group_title.' Created Successfuly!');
        return json_encode(array(
            "data"=>$data,
        ));
    }

    public function load_groupmembers(Request $request){

        $data = $request->all();
        $tres = [];

        $option__ = '';

        $getmembers = user_rc_group::with('getUserinfo','getOffice')->where('type','group')->where('type_id',$request->group_id)->where('active',1)->get();
        $getgroup = user_groups::where('id',$request->group_id)->first();

        //        $getgroup_name = $getgroup->name;
        //        $getgroup_desc = $getgroup->desc;

        foreach ($getmembers as $cd) {

                $td = [
                    "id" => $cd->id,
                    "name" => $cd->getUserinfo->firstname .' '.$cd->getUserinfo->lastname,
                ];
                $tres[count($tres)] = $td;
            }

        echo json_encode(array($tres));
        //        echo json_encode(array($tres,$getgroup_name,$getgroup_desc));

    }

    public function add_update_groupmembers(Request $request){
        $data = $request->all();

        if($request->has('update_group_modal_head')){

            $update_head = [
                'head' => $request->update_group_modal_head,
                'name' => $request->update_modal_group_title,
                'desc' => $request->update_modal_group_desc,
            ];
            user_groups::where(['id' =>  $request->group_id_modal])->first()->update($update_head);

            createNotification('group',$request->group_id_modal,'user',Auth::user()->employee,$request->update_group_modal_head,'user','You have been added to a group as a head.');
        }


        if($request->has('memberList')) {

                    foreach($request->memberList as $key => $user_id){
                        $check = user_rc_group::where('user_id',$user_id)->where('type','group')->where('type_id',$request->group_id_modal)->where('active',1)->first();
                        if(!$check){
                            $add_members = [
                                'type' =>  'group',
                                'type_id' =>  $request->group_id_modal,
                                'user_id' =>  $user_id,
                                'group_id' =>  $request->group_id_modal,
                            ];
                            user_rc_group::create($add_members);
                            createNotification('group',$request->group_id_modal,'user',Auth::user()->employee,$user_id,'user','You have been added to a group as a member.');
                        }

                    }

                }



        __notification_set(1,'Success','Group updated Successfuly!');

        add_log('group',$request->group_id_modal,'Group '.$request->update_modal_group_title.' Updated Successfuly!');
        return json_encode(array(
            "data"=>$data,
            "head"=>$request->rc_modal_head,
        ));
    }

    public function remove_group(Request $request){
        $data = $request->all();

        if($request->has('group_id')){

            $update_remove = [
                'active' => '0',
            ];
            user_groups::where(['id' =>  $request->group_id])->first()->update($update_remove);

        }

        __notification_set(1,'Success','Group '.$request->modal_group_title.' removed Successfuly!');

        add_log('group',$request->group_id,'Group removed Successfuly!');

        return json_encode(array(
            "data"=>$data,
        ));
    }

    public function group_remove_member_group(Request $request){
        $data = $request->all();

        if($request->has('group_member_id')){

            $update_remove = [
                'active' => '0',
            ];
            user_rc_group::where(['id' =>  $request->group_member_id])->first()->update($update_remove);

        }

        __notification_set(-1,'Success','Group member removed Successfuly!');

        add_log('group',$request->group_member_id,'Group Member Removed Successfuly!');

        return json_encode(array(
            "data"=>$data,
        ));
    }

    public function rc_remove_member_group(Request $request){
        $data = $request->all();

        if($request->has('rc_member_id')){

            $update_remove = [
                'active' => '0',
            ];
            user_rc_group::where(['id' =>  $request->rc_member_id])->first()->update($update_remove);

        }

        __notification_set(-1,'Success','RC member removed Successfuly!');

        add_log('rc',$request->rc_member_id,'RC Member Removed Successfuly!');

        return json_encode(array(
            "data"=>$data,
        ));
    }


    public function user_privileges()
    {

        return view('admin.management.privilege');
    }

    public function load_employee(Request $request){
        $data = $request->all();
        $tres = [];

        if($request->user_id){
            // $employee = employee::with('getHRdetails','getUsername')->has('getUsername')->where('agencyid',$request->user_id)->where('active',1)->first();
            $employee = User::with('getUserinfo')->where('active',1)->whereHas('getUserinfo')->where('employee',$request->user_id)->where('active',1)->first();
        }else{
            // $employee = employee::with('getHRdetails','getUsername')->has('getUsername')->where('active',1)->get();
            $employee = User::with('getUserinfo')->where('active',1)->whereHas('getUserinfo')->where('active',1)->orderBy('last_seen', 'DESC')->get();

        }

        foreach ($employee as $dt) {
            $fullname = '';
            $sex = '';
            if($dt->getUserinfo()->exists()){
                $fullname =  $dt->getUserinfo->firstname .' '.$dt->getUserinfo->lastname;
                $sex =  $dt->getUserinfo->sex;
            }
            $last_seen = 'N/A';


                if($dt->last_seen){
                    $last_seen = Carbon::parse($dt->last_seen)->diffForHumans();
                }





                $td = [
                    "id" => $dt->employee,
                    "name" => $fullname,
                    "sex" =>    $sex,
                    "last_seen" => $last_seen,
                ];
                $tres[count($tres)] = $td;


        }

        //dd($fullname);
        echo json_encode($tres);

    }

    public function load_user_priv(Request $request){
        $data = $request->all();
        $tres = [];



        if($request->user_id === null) {
            $user_id = Auth::user()->employee;

        }else{

            $user_id = $request->user_id;

        }

        $user_priv = user_privilege::with('getModule')->where('user_id', $user_id)->where('active',1)->get();

        //dd($user_priv );
        foreach ($user_priv as $dt) {

                $td = [
                    "id" => $dt->id,
                    "module_id" => $dt->module_id,
                    "link" => $dt->getModule->link,
                    "module_name" => $dt->getModule->module_name,
                    "read" => $dt->read,
                    "write" => $dt->write,
                    "create" => $dt->create,
                    "delete" => $dt->delete,
                    "import" => $dt->import,
                    "export" => $dt->export,
                    "print" => $dt->print,
                    "user_id" => $dt->user_id,
                    "aut_user" => Auth::user()->employee,
                    "samp" => $request->user_id,

                ];
                $tres[count($tres)] = $td;


        }

        //dd($fullname);
        echo json_encode($tres);

    }


    public function update_user_priv(Request $request){
        $data = $request->all();


        if($request->user_id === null) {

            if($request->has('multiple_user')) {


                foreach($request->multiple_user as $key => $user_id){

                    if($request->has('readList')) {
                        $getModuleschecked = user_privilege::where('user_id',$user_id)->whereIn('module_id',$request->readList )->where('active',1)->get();
                        foreach ($getModuleschecked as $checked) {
                            $update_priv = [
                                'read' => '1',
                            ];
                            user_privilege::where(['id' =>  $checked->id])->first()->update($update_priv);
                                }

                        $getModulesnotchecked = user_privilege::where('user_id',$user_id)->whereNotIn('module_id',$request->readList )->where('active',1)->get();
                        foreach ($getModulesnotchecked as $notchecked) {
                            $update_priv = [
                                'read' => '0',
                            ];
                            user_privilege::where(['id' =>  $notchecked->id])->first()->update($update_priv);
                                }
                            }else{

                                $getModulesnotchecked = user_privilege::where('user_id',$user_id)->where('active',1)->get();
                                foreach ($getModulesnotchecked as $notchecked) {
                                    $update_priv = [
                                        'read' => '0',
                                    ];
                                    user_privilege::where(['id' =>  $notchecked->id])->first()->update($update_priv);
                                        }

                            }


                            if($request->has('writeList')) {
                                $getModuleschecked = user_privilege::where('user_id',$user_id)->whereIn('module_id',$request->writeList )->where('active',1)->get();
                                foreach ($getModuleschecked as $checked) {
                                    $update_priv = [
                                        'write' => '1',
                                    ];
                                    user_privilege::where(['id' =>  $checked->id])->first()->update($update_priv);
                                        }

                                $getModulesnotchecked = user_privilege::where('user_id',$user_id)->whereNotIn('module_id',$request->writeList )->where('active',1)->get();
                                foreach ($getModulesnotchecked as $notchecked) {
                                    $update_priv = [
                                        'write' => '0',
                                    ];
                                    user_privilege::where(['id' =>  $notchecked->id])->first()->update($update_priv);
                                        }
                                    }else{

                                        $getModulesnotchecked = user_privilege::where('user_id',$user_id)->where('active',1)->get();
                                        foreach ($getModulesnotchecked as $notchecked) {
                                            $update_priv = [
                                                'write' => '0',
                                            ];
                                            user_privilege::where(['id' =>  $notchecked->id])->first()->update($update_priv);
                                                }

                                    }

                                    if($request->has('createList')) {
                                        $getModuleschecked = user_privilege::where('user_id',$user_id)->whereIn('module_id',$request->createList )->where('active',1)->get();
                                        foreach ($getModuleschecked as $checked) {
                                            $update_priv = [
                                                'create' => '1',
                                            ];
                                            user_privilege::where(['id' =>  $checked->id])->first()->update($update_priv);
                                                }

                                        $getModulesnotchecked = user_privilege::where('user_id',$user_id)->whereNotIn('module_id',$request->createList )->where('active',1)->get();
                                        foreach ($getModulesnotchecked as $notchecked) {
                                            $update_priv = [
                                                'create' => '0',
                                            ];
                                            user_privilege::where(['id' =>  $notchecked->id])->first()->update($update_priv);
                                                }
                                            }else{

                                                $getModulesnotchecked = user_privilege::where('user_id',$user_id)->where('active',1)->get();
                                                foreach ($getModulesnotchecked as $notchecked) {
                                                    $update_priv = [
                                                        'create' => '0',
                                                    ];
                                                    user_privilege::where(['id' =>  $notchecked->id])->first()->update($update_priv);
                                                        }

                                            }


                                            if($request->has('dtdeleteList')) {
                                                //$getModules = user_privilege::where('user_id',$request->user_id)->get();
                                                $getModuleschecked = user_privilege::where('user_id',$user_id)->whereIn('module_id',$request->dtdeleteList )->where('active',1)->get();
                                                foreach ($getModuleschecked as $checked) {
                                                    $update_priv = [
                                                        'delete' => '1',
                                                    ];
                                                    user_privilege::where(['id' =>  $checked->id])->first()->update($update_priv);
                                                        }

                                                $getModulesnotchecked = user_privilege::where('user_id',$user_id)->whereNotIn('module_id',$request->dtdeleteList )->where('active',1)->get();
                                                foreach ($getModulesnotchecked as $notchecked) {
                                                    $update_priv = [
                                                        'delete' => '0',
                                                    ];
                                                    user_privilege::where(['id' =>  $notchecked->id])->first()->update($update_priv);
                                                        }
                                                    }else{

                                                        $getModulesnotchecked = user_privilege::where('user_id',$user_id)->where('active',1)->get();
                                                        foreach ($getModulesnotchecked as $notchecked) {
                                                            $update_priv = [
                                                                'delete' => '0',
                                                            ];
                                                            user_privilege::where(['id' =>  $notchecked->id])->first()->update($update_priv);
                                                                }

                                                    }


                                                    if($request->has('dtimportList')) {
                                                        //$getModules = user_privilege::where('user_id',$request->user_id)->get();
                                                        $getModuleschecked = user_privilege::where('user_id',$user_id)->whereIn('module_id',$request->dtimportList )->where('active',1)->get();
                                                        foreach ($getModuleschecked as $checked) {
                                                            $update_priv = [
                                                                'import' => '1',
                                                            ];
                                                            user_privilege::where(['id' =>  $checked->id])->first()->update($update_priv);
                                                                }

                                                        $getModulesnotchecked = user_privilege::where('user_id',$user_id)->whereNotIn('module_id',$request->dtimportList )->where('active',1)->get();
                                                        foreach ($getModulesnotchecked as $notchecked) {
                                                            $update_priv = [
                                                                'import' => '0',
                                                            ];
                                                            user_privilege::where(['id' =>  $notchecked->id])->first()->update($update_priv);
                                                                }
                                                            }else{

                                                                $getModulesnotchecked = user_privilege::where('user_id',$user_id)->where('active',1)->get();
                                                                foreach ($getModulesnotchecked as $notchecked) {
                                                                    $update_priv = [
                                                                        'import' => '0',
                                                                    ];
                                                                    user_privilege::where(['id' =>  $notchecked->id])->first()->update($update_priv);
                                                                        }

                                                            }


                                                            if($request->has('dtexportList')) {
                                                                //$getModules = user_privilege::where('user_id',$request->user_id)->get();
                                                                $getModuleschecked = user_privilege::where('user_id',$user_id)->whereIn('module_id',$request->dtexportList )->where('active',1)->get();
                                                                foreach ($getModuleschecked as $checked) {
                                                                    $update_priv = [
                                                                        'export' => '1',
                                                                    ];
                                                                    user_privilege::where(['id' =>  $checked->id])->first()->update($update_priv);
                                                                        }

                                                                $getModulesnotchecked = user_privilege::where('user_id',$user_id)->whereNotIn('module_id',$request->dtexportList )->where('active',1)->get();
                                                                foreach ($getModulesnotchecked as $notchecked) {
                                                                    $update_priv = [
                                                                        'export' => '0',
                                                                    ];
                                                                    user_privilege::where(['id' =>  $notchecked->id])->first()->update($update_priv);
                                                                        }
                                                                    }else{

                                                                        $getModulesnotchecked = user_privilege::where('user_id',$user_id)->where('active',1)->get();
                                                                        foreach ($getModulesnotchecked as $notchecked) {
                                                                            $update_priv = [
                                                                                'export' => '0',
                                                                            ];
                                                                            user_privilege::where(['id' =>  $notchecked->id])->first()->update($update_priv);
                                                                                }

                                                                    }


                                                            if($request->has('dtprintList')) {
                                                                //$getModules = user_privilege::where('user_id',$request->user_id)->get();
                                                                $getModuleschecked = user_privilege::where('user_id',$user_id)->whereIn('module_id',$request->dtprintList )->where('active',1)->get();
                                                                foreach ($getModuleschecked as $checked) {
                                                                    $update_priv = [
                                                                        'print' => '1',
                                                                    ];
                                                                    user_privilege::where(['id' =>  $checked->id])->first()->update($update_priv);
                                                                        }

                                                                $getModulesnotchecked = user_privilege::where('user_id',$user_id)->whereNotIn('module_id',$request->dtprintList )->where('active',1)->get();
                                                                foreach ($getModulesnotchecked as $notchecked) {
                                                                    $update_priv = [
                                                                        'print' => '0',
                                                                    ];
                                                                    user_privilege::where(['id' =>  $notchecked->id])->first()->update($update_priv);
                                                                        }
                                                                    }else{

                                                                        $getModulesnotchecked = user_privilege::where('user_id',$user_id)->where('active',1)->get();
                                                                        foreach ($getModulesnotchecked as $notchecked) {
                                                                            $update_priv = [
                                                                                'print' => '0',
                                                                            ];
                                                                            user_privilege::where(['id' =>  $notchecked->id])->first()->update($update_priv);
                                                                                }

                                                                    }

                }

            }

        }else
        {

            if($request->has('readList')) {
                //$getModules = user_privilege::where('user_id',$request->user_id)->get();
                $getModuleschecked = user_privilege::where('user_id',$request->user_id)->whereIn('module_id',$request->readList )->where('active',1)->get();
                foreach ($getModuleschecked as $checked) {
                    $update_priv = [
                        'read' => '1',
                    ];
                    user_privilege::where(['id' =>  $checked->id])->first()->update($update_priv);
                        }

                $getModulesnotchecked = user_privilege::where('user_id',$request->user_id)->whereNotIn('module_id',$request->readList )->where('active',1)->get();
                foreach ($getModulesnotchecked as $notchecked) {
                    $update_priv = [
                        'read' => '0',
                    ];
                    user_privilege::where(['id' =>  $notchecked->id])->first()->update($update_priv);
                        }
                    }else{

                        $getModulesnotchecked = user_privilege::where('user_id',$request->user_id)->where('active',1)->get();
                        foreach ($getModulesnotchecked as $notchecked) {
                            $update_priv = [
                                'read' => '0',
                            ];
                            user_privilege::where(['id' =>  $notchecked->id])->first()->update($update_priv);
                                }

                    }


                    if($request->has('writeList')) {
                        //$getModules = user_privilege::where('user_id',$request->user_id)->get();
                        $getModuleschecked = user_privilege::where('user_id',$request->user_id)->whereIn('module_id',$request->writeList )->where('active',1)->get();
                        foreach ($getModuleschecked as $checked) {
                            $update_priv = [
                                'write' => '1',
                            ];
                            user_privilege::where(['id' =>  $checked->id])->first()->update($update_priv);
                                }

                        $getModulesnotchecked = user_privilege::where('user_id',$request->user_id)->whereNotIn('module_id',$request->writeList )->where('active',1)->get();
                        foreach ($getModulesnotchecked as $notchecked) {
                            $update_priv = [
                                'write' => '0',
                            ];
                            user_privilege::where(['id' =>  $notchecked->id])->first()->update($update_priv);
                                }
                            }else{

                                $getModulesnotchecked = user_privilege::where('user_id',$request->user_id)->where('active',1)->get();
                                foreach ($getModulesnotchecked as $notchecked) {
                                    $update_priv = [
                                        'write' => '0',
                                    ];
                                    user_privilege::where(['id' =>  $notchecked->id])->first()->update($update_priv);
                                        }

                            }


                            if($request->has('createList')) {
                                //$getModules = user_privilege::where('user_id',$request->user_id)->get();
                                $getModuleschecked = user_privilege::where('user_id',$request->user_id)->whereIn('module_id',$request->createList )->where('active',1)->get();
                                foreach ($getModuleschecked as $checked) {
                                    $update_priv = [
                                        'create' => '1',
                                    ];
                                    user_privilege::where(['id' =>  $checked->id])->first()->update($update_priv);
                                        }

                                $getModulesnotchecked = user_privilege::where('user_id',$request->user_id)->whereNotIn('module_id',$request->createList )->where('active',1)->get();
                                foreach ($getModulesnotchecked as $notchecked) {
                                    $update_priv = [
                                        'create' => '0',
                                    ];
                                    user_privilege::where(['id' =>  $notchecked->id])->first()->update($update_priv);
                                        }
                                    }else{

                                        $getModulesnotchecked = user_privilege::where('user_id',$request->user_id)->where('active',1)->get();
                                        foreach ($getModulesnotchecked as $notchecked) {
                                            $update_priv = [
                                                'create' => '0',
                                            ];
                                            user_privilege::where(['id' =>  $notchecked->id])->first()->update($update_priv);
                                                }

                                    }




                                    if($request->has('dtdeleteList')) {
                                        //$getModules = user_privilege::where('user_id',$request->user_id)->get();
                                        $getModuleschecked = user_privilege::where('user_id',$request->user_id)->whereIn('module_id',$request->dtdeleteList )->where('active',1)->get();
                                        foreach ($getModuleschecked as $checked) {
                                            $update_priv = [
                                                'delete' => '1',
                                            ];
                                            user_privilege::where(['id' =>  $checked->id])->first()->update($update_priv);
                                                }

                                        $getModulesnotchecked = user_privilege::where('user_id',$request->user_id)->whereNotIn('module_id',$request->dtdeleteList )->where('active',1)->get();
                                        foreach ($getModulesnotchecked as $notchecked) {
                                            $update_priv = [
                                                'delete' => '0',
                                            ];
                                            user_privilege::where(['id' =>  $notchecked->id])->first()->update($update_priv);
                                                }
                                            }else{

                                                $getModulesnotchecked = user_privilege::where('user_id',$request->user_id)->where('active',1)->get();
                                                foreach ($getModulesnotchecked as $notchecked) {
                                                    $update_priv = [
                                                        'delete' => '0',
                                                    ];
                                                    user_privilege::where(['id' =>  $notchecked->id])->first()->update($update_priv);
                                                        }

                                            }




                                            if($request->has('dtimportList')) {
                                                //$getModules = user_privilege::where('user_id',$request->user_id)->get();
                                                $getModuleschecked = user_privilege::where('user_id',$request->user_id)->whereIn('module_id',$request->dtimportList )->where('active',1)->get();
                                                foreach ($getModuleschecked as $checked) {
                                                    $update_priv = [
                                                        'import' => '1',
                                                    ];
                                                    user_privilege::where(['id' =>  $checked->id])->first()->update($update_priv);
                                                        }

                                                $getModulesnotchecked = user_privilege::where('user_id',$request->user_id)->whereNotIn('module_id',$request->dtimportList )->where('active',1)->get();
                                                foreach ($getModulesnotchecked as $notchecked) {
                                                    $update_priv = [
                                                        'import' => '0',
                                                    ];
                                                    user_privilege::where(['id' =>  $notchecked->id])->first()->update($update_priv);
                                                        }
                                                    }else{

                                                        $getModulesnotchecked = user_privilege::where('user_id',$request->user_id)->where('active',1)->get();
                                                        foreach ($getModulesnotchecked as $notchecked) {
                                                            $update_priv = [
                                                                'import' => '0',
                                                            ];
                                                            user_privilege::where(['id' =>  $notchecked->id])->first()->update($update_priv);
                                                                }

                                                    }

                                                    if($request->has('dtexportList')) {
                                                        //$getModules = user_privilege::where('user_id',$request->user_id)->get();
                                                        $getModuleschecked = user_privilege::where('user_id',$request->user_id)->whereIn('module_id',$request->dtexportList )->where('active',1)->get();
                                                        foreach ($getModuleschecked as $checked) {
                                                            $update_priv = [
                                                                'export' => '1',
                                                            ];
                                                            user_privilege::where(['id' =>  $checked->id])->first()->update($update_priv);
                                                                }

                                                        $getModulesnotchecked = user_privilege::where('user_id',$request->user_id)->whereNotIn('module_id',$request->dtexportList )->where('active',1)->get();
                                                        foreach ($getModulesnotchecked as $notchecked) {
                                                            $update_priv = [
                                                                'export' => '0',
                                                            ];
                                                            user_privilege::where(['id' =>  $notchecked->id])->first()->update($update_priv);
                                                                }
                                                            }else{

                                                                $getModulesnotchecked = user_privilege::where('user_id',$request->user_id)->where('active',1)->get();
                                                                foreach ($getModulesnotchecked as $notchecked) {
                                                                    $update_priv = [
                                                                        'export' => '0',
                                                                    ];
                                                                    user_privilege::where(['id' =>  $notchecked->id])->first()->update($update_priv);
                                                                        }

                                                            }

                                                            if($request->has('dtprintList')) {
                                                                //$getModules = user_privilege::where('user_id',$request->user_id)->get();
                                                                $getModuleschecked = user_privilege::where('user_id',$request->user_id)->whereIn('module_id',$request->dtprintList )->where('active',1)->get();
                                                                foreach ($getModuleschecked as $checked) {
                                                                    $update_priv = [
                                                                        'print' => '1',
                                                                    ];
                                                                    user_privilege::where(['id' =>  $checked->id])->first()->update($update_priv);
                                                                        }

                                                                $getModulesnotchecked = user_privilege::where('user_id',$request->user_id)->whereNotIn('module_id',$request->dtprintList )->where('active',1)->get();
                                                                foreach ($getModulesnotchecked as $notchecked) {
                                                                    $update_priv = [
                                                                        'print' => '0',
                                                                    ];
                                                                    user_privilege::where(['id' =>  $notchecked->id])->first()->update($update_priv);
                                                                        }
                                                                    }else{

                                                                        $getModulesnotchecked = user_privilege::where('user_id',$request->user_id)->where('active',1)->get();
                                                                        foreach ($getModulesnotchecked as $notchecked) {
                                                                            $update_priv = [
                                                                                'print' => '0',
                                                                            ];
                                                                            user_privilege::where(['id' =>  $notchecked->id])->first()->update($update_priv);
                                                                                }

                                                                    }


        }



        __notification_set(1,'Success','Responsibility Center updated Successfuly!');
        add_log('priv',$request->user_id,'User Privileges Updated Successfuly!');
        return json_encode(array(
            "data"=>$data,

        ));
    }

    public function update_user_priv_reload(Request $request){

        $data = $request->all();

        if($request->has('importantList')) {

                $getModuleschecked = doc_modules::whereIn('id',$request->importantList)->where('active',1)->get();
                foreach ($getModuleschecked as $checked) {
                        $update_priv = [
                            'important' => '1',
                        ];
                        doc_modules::where(['id' =>  $checked->id])->first()->update($update_priv);
                    }

                    $getModulesnotchecked = doc_modules::whereNotIn('id',$request->importantList )->where('active',1)->get();
                        foreach ($getModulesnotchecked as $notchecked) {
                            $update_priv = [
                                'important' => '0',
                            ];
                            doc_modules::where(['id' =>  $notchecked->id])->first()->update($update_priv);
                            }
                }
        reloadAddUsers('');
        __notification_set(1,'Success','Responsibility Center updated Successfuly!');
        add_log('priv',$request->user_id,'User Privileges Updated Successfuly!');


        return json_encode(array(
            "data"=>$data,
        ));
    }

    public function link_lists()
    {
        return view('admin.management.link_list');
    }

    public function get_link_list(Request $request)
    {
        $tres = [];

        $employee = doc_modules::where('active',1)->get();

            //        foreach ($employee as $dt) {
            //            $fullname = '';
            //            if($dt->exists()){
            //                $fullname =  $dt->firstname .' '.$dt->lastname;
            //            }
            //            $td = [
            //                "id" => $dt->agencyid,
            //                "name" => $fullname,
            //                "sex" => $dt->sex,
            //
            //            ];
            //            $tres[count($tres)] = $td;
            //
            //
            //        }

        echo json_encode($employee);
    }

    public function update_link_list(Request $request)
    {
        doc_modules::where('id', $request->link_id)->update([
            'module_name' => $request->module_name,
        ]);

    }


        //HRIS Account Management
    public function acmn(){

        return view('admin.management.account');
    }

    public function load_accounts(Request $request){
        $data = $request->all();
        $tres = [];


        if($request->filter_data === "Active"){

            //$accounts = employee::with('getHRdetails','getUsername')->has('getUsername')->where('agencyid',$request->filter_data)->where('active',1)->first();
            $accounts = User::with('getUserinfo')->where('active',1)->whereMonth('last_seen','>=', Carbon::now()->subMonth())->orderBy('last_seen', 'desc')->get();

        }elseif($request->filter_data === 'Inactive'){

            $accounts = User::with('getUserinfo')->where('active',1)->whereDate('last_seen','<',Carbon::now()->subMonth())->orderBy('last_seen', 'desc')->get();

        }elseif($request->filter_data === 'Active Today'){

            $accounts = User::with('getUserinfo')->whereDate('last_seen', Carbon::today())->where('active',1)->whereNotNull('employee')->orderBy('last_seen', 'desc')->get();

        }elseif($request->filter_data === 'Users'){

            $accounts = User::with('getUserinfo')->get();

        }elseif($request->filter_data === 'Employees'){

            $accounts = User::with('getUserinfo','get_user_employment')->where('active',1)->whereHas('get_user_employment')->get();

        }elseif($request->filter_data === 'Applicants'){

            $accounts = User::with('getUserinfo','get_is_at_applicant_list')->where('active',1)->whereHas('get_is_at_applicant_list')->get();

        }elseif($request->filter_data === 'Admin'){

            $accounts = User::with('getUserinfo')->where('active',1)->where('role_name','Admin')->get();

        }elseif($request->filter_data === 'Guest'){

            $accounts = User::with('getUserinfo')->where('active',1)->whereNull('last_seen')->orderBy('last_seen', 'desc')->get();

        }else{

            $accounts = User::with('getUserinfo')->where('active',1)->get();
        }


        $system_setting = \App\Models\ASIS_Models\system\default_setting::where('active',1)->get();

        $get_user_priv = Session::get('get_user_priv');

        foreach ($accounts as $dt) {
            $fullname = 'N/A';
            $can_delete = '';
            if($dt->getUserinfo()->exists()){
                $miden = '';
                if($dt->getUserinfo->mi){
                    $miden = mb_substr($dt->getUserinfo->mi, 0, 1) .'. ';
                }
                $fullname =  $dt->getUserinfo->firstname .' '.$miden.' '. $dt->getUserinfo->lastname.' '. $dt->getUserinfo->extension;
            }
            $deleted = '';
            if ($dt->active == 1) {
                $deleted = 'Good';
            }else{
                $deleted = 'Removed';
            }

            $last_seen = 'Unused';

            if(strtotime($dt->last_seen)){
                $last_seen = Carbon::parse($dt->last_seen)->diffForHumans();
            }

            if($get_user_priv){
                if($get_user_priv[0]->delete == 1 || Auth::user()->role_name == 'Admin'){
                    $can_delete = '<a id="btn_delete_account" href="javascript:;" class="dropdown-item btn_delete_account" data-ac-id="'.$dt->id.'"> <i class="fa fa-trash-alt w-4 h-4 mr-2 text-danger"></i> Delete </a>';
                }
            }else{
                $can_delete = '<a id="btn_delete_account" href="javascript:;" class="dropdown-item btn_delete_account" data-ac-id="'.$dt->id.'"> <i class="fa fa-trash-alt w-4 h-4 mr-2 text-danger"></i> Delete </a>';
            }


                $td = [
                    "account_id" => $dt->id,
                    "agency_id" => $dt->employee,
                    "name" => Str::title($fullname) ,
                    "deleted" => $deleted,
                    "last_seen" => $last_seen,
                    "username" => $dt->username,
                    "can_delete" => $can_delete,
                ];
                $tres[count($tres)] = $td;


        }


        echo json_encode($tres);

    }

    public function load_user_id(Request $request){

        $data = $request->all();
        $user = '';
        $user_info = '';
        $profile_info = '';
        $employment_info = '';
        $user_id_global = '';
        $can_update ='';
        $can_update_icon ='';

        $system_setting = \App\Models\ASIS_Models\system\default_setting::where('active',1)->get();

        $get_user_priv = Session::get('get_user_priv');


        if($request->has('user_id')) {
            $user = User::with('get_user_employment.get_employment_status','get_user_employment.get_employment_type',
            'get_user_profile')->where('id',$request->user_id)->first();

        }else{
            $user = User::with('get_user_employment.get_employment_status','get_user_employment.get_employment_type',
            'get_user_profile')->where('id',Auth::user()->id)->first();
        }

        if($user){
            $created_at = 'N/A';
            $user_role = 'User';
            $user_name = 'N/A';
            $last_seen = 'N/A';
            $password = 'N/A';


            if($user->created_at){
                $created_at=$user->created_at;
            }

            if($user->role_name){
                $user_role=$user->role_name;
            }

            if($user->username){
                $user_name=$user->username;
            }

            if($user->last_seen){
                $last_seen=$user->last_seen;
            }

            if($user->password){
                $password=$user->password;
            }

            if($get_user_priv){
                if($get_user_priv[0]->write == 1 ||  Auth::user()->role_name == 'Admin' ){
                    $can_update = '<a id="load_account_edit" href="javascript:;" data-acc-id="'.$user->id.'" data-tw-toggle="modal" data-tw-target="#account_modal" class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md">';
                    $can_update_icon = '<i class="fa fa-edit w-4 h-4 text-slate-500 ml-auto"></i>';

                }else{
                    $can_update = '<a href="javascript:;" data-acc-id="'.$user->id.'" class="no_user_priv flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md">';
                    $can_update_icon = '<i class="fa fa-minus w-4 h-4 text-slate-500 ml-auto"></i>';
                }
            }else{
                $can_update = '<a id="load_account_edit" href="javascript:;" data-acc-id="'.$user->id.'" data-tw-toggle="modal" data-tw-target="#account_modal" class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md">';
                $can_update_icon = '<i class="fa fa-edit w-4 h-4 text-slate-500 ml-auto"></i>';
            }

            $user_id_global = $user->id;
            $user_info .= '
                <div class=" border-b border-slate-200 dark:border-darkmode-400">

                        '.$can_update.'
                        <div class="mr-auto font-medium text-base">Account Details</div>
                        <i data-lucide="edit" class="w-4 h-4 text-slate-500 ml-2"></i>
                        <div class="ml-auto font-medium">'.$can_update_icon.'</div>
                    </a>
                </div>
                <div class="flex items-center pt-5 border-b border-slate-200 dark:border-darkmode-400 pb-5">
                    <div>
                        <div class="text-slate-500">Created at</div>
                        <div class="mt-1">'.$created_at.'</div>
                    </div>
                    <i data-lucide="clock" class="w-4 h-4 text-slate-500 ml-auto"></i>
                </div>
                <div class="flex items-center border-b border-slate-200 dark:border-darkmode-400 py-5">
                    <div>
                        <div class="text-slate-500">User Role</div>
                        <div class="mt-1">'.$user_role.'</div>
                    </div>
                    <i data-lucide="user" class="w-4 h-4 text-slate-500 ml-auto"></i>
                </div>
                <div class="flex items-center border-b border-slate-200 dark:border-darkmode-400 py-5">
                    <div>
                        <div class="text-slate-500">User Name</div>
                        <div class="mt-1">'.$user_name.'</div>
                    </div>
                    <i data-lucide="users" class="w-4 h-4 text-slate-500 ml-auto"></i>
                </div>
                <div class="flex items-center border-b border-slate-200 dark:border-darkmode-400 py-5">
                    <div>
                        <div class="text-slate-500">Password</div>
                        <div class="mt-1">'.$password.'</div>
                    </div>
                    <i data-lucide="users" class="w-4 h-4 text-slate-500 ml-auto"></i>
                </div>
                <div class="flex items-center pt-5">
                    <div>
                        <div class="text-slate-500">Last Seen</div>
                        <div class="mt-1">'.$last_seen.'</div>
                    </div>
                    <i data-lucide="mic" class="w-4 h-4 text-slate-500 ml-auto"></i>
                </div>';
        }else{

            if($get_user_priv){
                if( $get_user_priv[0]->create == 1 ||  Auth::user()->role_name == 'Admin' ){
                    $can_update = '<a href="javascript:;" data-usr-id="" data-tw-toggle="modal" data-tw-target="#account_modal" class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md">';
                    $can_update_icon = '<i class="fa fa-plus w-4 h-4 text-slate-500 ml-auto"></i>';

                }else{
                    $can_update = '<a href="javascript:;" data-usr-id="" class="no_user_priv flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md">';
                    $can_update_icon = '<i class="fa fa-minus w-4 h-4 text-slate-500 ml-auto"></i>';
                }
            }else{
                $can_update = '<a href="javascript:;" data-usr-id="" data-tw-toggle="modal" data-tw-target="#account_modal" class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md">';
                    $can_update_icon = '<i class="fa fa-plus w-4 h-4 text-slate-500 ml-auto"></i>';
            }

            $user_info .= '
            <div class=" border-slate-200 dark:border-darkmode-400">
                    '.$can_update.'
                    <div class="mr-auto font-medium text-base">User not found!</div>
                    <div class="ml-auto font-medium">'.$can_update_icon.'</div>
                </a>
            </div>
            ';

        }
        $profile_pint_and_title = '
        <h2 class="font-medium text-base mr-auto">
            I. Personal Information
        </h2>';
        if( $user->get_user_profile()->exists()){

            $full_name ='N/A';
            $agencyid = 'N/A';
            $dateofbirth = 'N/A';
            $sex = 'N/A';
            $citizenship = 'N/A';
            $civilstatus = 'N/A';


            $miden = '';
            if($user->get_user_profile->mi){
                $miden = mb_substr($user->get_user_profile->mi, 0, 1) .'. ';
            }
                $full_name =  $user->get_user_profile->firstname .' '.$miden.' '. $user->get_user_profile->lastname.' '. $user->get_user_profile->extension;

            if($user->get_user_profile->agencyid){
                $agencyid = $user->get_user_profile->agencyid;
            }
            if($user->get_user_profile->dateofbirth){
                $dateofbirth = $user->get_user_profile->dateofbirth;
            }
            if($user->get_user_profile->sex){
                $sex = $user->get_user_profile->sex;
            }
            if($user->get_user_profile->citizenship){
                $citizenship = $user->get_user_profile->citizenship;
            }
            if($user->get_user_profile->civilstatus){
                $civilstatus = $user->get_user_profile->civilstatus;
            }
            if($get_user_priv){
                if($get_user_priv[0]->write == 1 ||  Auth::user()->role_name == 'Admin' ){
                    $can_update = '<a id="load_profile_edit" data-pro-id="'.$user->get_user_profile->id.'" href="javascript:;" data-tw-toggle="modal" data-tw-target="#profile_modal" class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md">';
                    $can_update_icon = '<i class="fa fa-edit w-4 h-4 text-slate-500 ml-auto"></i>';

                }else{
                    $can_update = '<a href="javascript:;" class="no_user_priv flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md">';
                    $can_update_icon = '<i class="fa fa-minus w-4 h-4 text-slate-500 ml-auto"></i>';
                }
            }else{
                $can_update = '<a id="load_profile_edit" data-pro-id="'.$user->get_user_profile->id.'" href="javascript:;" data-tw-toggle="modal" data-tw-target="#profile_modal" class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md">';
                $can_update_icon = '<i class="fa fa-edit w-4 h-4 text-slate-500 ml-auto"></i>';
            }


            $profile_pint_and_title = '
            <h2 class="font-medium text-base mr-auto">
                I. Personal Information
            </h2>
            <a id="btn_print_PDS" target="_blank" href="/my/print/pds/'.Crypt::encrypt($user->get_user_profile->user_id).'" class="ml-auto text-primary truncate flex items-center"> <i class="fa fa-print w-4 h-4 mr-2"></i> PDS </a>';

            $profile_info .= '

            <div class=" border-b border-slate-200 dark:border-darkmode-400">

                    '.$can_update.'
                    <div class="mr-auto font-medium text-base">Profile Details</div>
                    <i data-lucide="edit" class="w-4 h-4 text-slate-500 ml-2"></i>
                    <div class="ml-auto font-medium">'.$can_update_icon.'</div>
                </a>
            </div>
            <div class="flex pt-5 items-center border-b border-slate-200 dark:border-darkmode-400 pb-5">
                <div>
                    <div class="text-slate-500">Full Name</div>
                    <div class="mt-1">'.Str::title($full_name).'</div>
                </div>
                <i data-lucide="clock" class="w-4 h-4 text-slate-500 ml-auto"></i>
            </div>
            <div class="flex items-center border-b border-slate-200 dark:border-darkmode-400 py-5">
                <div>
                    <div class="text-slate-500">Agency ID</div>
                    <div class="mt-1">'.$agencyid.'</div>
                </div>
                <i data-lucide="user" class="w-4 h-4 text-slate-500 ml-auto"></i>
            </div>
            <div class="flex items-center border-b border-slate-200 dark:border-darkmode-400 py-5">
                <div>
                    <div class="text-slate-500">Date of Birth</div>
                    <div class="mt-1">'.$dateofbirth.'</div>
                </div>
                <i data-lucide="users" class="w-4 h-4 text-slate-500 ml-auto"></i>
            </div>
            <div class="flex items-center border-b border-slate-200 dark:border-darkmode-400 py-5">
                <div>
                    <div class="text-slate-500">Sex</div>
                    <div class="mt-1">'.$sex.'</div>
                </div>
                <i data-lucide="users" class="w-4 h-4 text-slate-500 ml-auto"></i>
            </div>
            <div class="flex items-center border-b border-slate-200 dark:border-darkmode-400 py-5">
                <div>
                    <div class="text-slate-500">Citizenship</div>
                    <div class="mt-1">'.$citizenship.'</div>
                </div>
                <i data-lucide="mic" class="w-4 h-4 text-slate-500 ml-auto"></i>
            </div>
            <div class="flex items-center pt-5">
                <div>
                    <div class="text-slate-500">Civil status</div>
                    <div class="mt-1">'.$civilstatus.'</div>
                </div>
                <i data-lucide="mic" class="w-4 h-4 text-slate-500 ml-auto"></i>
            </div>';

            __notification_set(1,Str::title($full_name),'Details loaded!');
        }else{
            if($get_user_priv){
                if( $get_user_priv[0]->create == 1 ||  Auth::user()->role_name == 'Admin' ){
                    $can_update = '<a href="javascript:;" data-usr-id="" data-tw-toggle="modal" data-tw-target="#profile_modal" class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md">';
                    $can_update_icon = '<i class="fa fa-plus w-4 h-4 text-slate-500 ml-auto"></i>';

                }else{
                    $can_update = '<a href="javascript:;" data-usr-id="" class="no_user_priv flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md">';
                    $can_update_icon = '<i class="fa fa-minus w-4 h-4 text-slate-500 ml-auto"></i>';
                }
            }else{
                $can_update = '<a href="javascript:;" data-usr-id="" data-tw-toggle="modal" data-tw-target="#profile_modal" class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md">';
                $can_update_icon = '<i class="fa fa-plus w-4 h-4 text-slate-500 ml-auto"></i>';
            }

            $profile_info .= '
            <div class=" border-slate-200 dark:border-darkmode-400">
                    '.$can_update.'
                    <div class="mr-auto font-medium text-base">Profile not found!</div>
                    <div class="ml-auto font-medium">'.$can_update_icon.'</div>
                </a>
            </div>
            ';

        }

        if( $user->get_user_employment()->exists()){
            $employment_type = 'N/A';
            $start_date = 'N/A';
            $end_date = 'N/A';
            $status = 'N/A';
            $status_class = 'N/A';
            // $employment_type = 'N/A';

            // if($user->get_user_employment->employment_type){
            //     $employment_type = $user->get_user_employment->employment_type;
            // }

            if($user->get_user_employment->start_date){
                $start_date = $user->get_user_employment->start_date;
            }
            if($user->get_user_employment->end_date){
                $end_date = $user->get_user_employment->end_date;
            }
            if( $user->get_user_employment->get_employment_status()->exists()){
                $status = $user->get_user_employment->get_employment_status->name;
                $status_class = $user->get_user_employment->get_employment_status->class;
            }
            if( $user->get_user_employment->get_employment_type()->exists()){
                $employment_type = $user->get_user_employment->get_employment_type->name;
            }
            if($get_user_priv){
                if($get_user_priv[0]->write == 1 ||  Auth::user()->role_name == 'Admin' ){
                    $can_update = '<a id="load_employee_edit"  href="javascript:;" data-emp-id="'.$user->get_user_employment->id.'" data-tw-toggle="modal" data-tw-target="#employee_modal" class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md">';
                    $can_update_icon = '<i class="fa fa-edit w-4 h-4 text-slate-500 ml-auto"></i>';

                }else{
                    $can_update = '<a href="javascript:;" class="no_user_priv flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md">';
                    $can_update_icon = '<i class="fa fa-minus w-4 h-4 text-slate-500 ml-auto"></i>';
                }
            }else{
                $can_update = '<a id="load_employee_edit"  href="javascript:;" data-emp-id="'.$user->get_user_employment->id.'" data-tw-toggle="modal" data-tw-target="#employee_modal" class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md">';
                $can_update_icon = '<i class="fa fa-edit w-4 h-4 text-slate-500 ml-auto"></i>';
            }

            $employment_info .= '
            <div class=" border-b border-slate-200 dark:border-darkmode-400">

                    '.$can_update.'
                    <div class="mr-auto font-medium text-base">Employment Details</div>
                    <i data-lucide="edit" class="w-4 h-4 text-slate-500 ml-2"></i>
                    <div class="ml-auto font-medium">'.$can_update_icon.'</div>
                </a>
            </div>
            <div class="flex pt-5 items-center border-b border-slate-200 dark:border-darkmode-400 pb-5">
                <div>
                    <div class="text-slate-500">Employment Type</div>
                    <div class="mt-1">'.$employment_type.'</div>
                </div>
                <i data-lucide="clock" class="w-4 h-4 text-slate-500 ml-auto"></i>
            </div>
            <div class="flex items-center border-b border-slate-200 dark:border-darkmode-400 py-5">
                <div>
                    <div class="text-slate-500">Start Date</div>
                    <div class="mt-1">'.$start_date.'</div>
                </div>
                <i data-lucide="user" class="w-4 h-4 text-slate-500 ml-auto"></i>
            </div>
            <div class="flex items-center border-b border-slate-200 dark:border-darkmode-400 py-5">
                <div>
                    <div class="text-slate-500">End Date</div>
                    <div class="mt-1">'.$end_date.'</div>
                </div>
                <i data-lucide="users" class="w-4 h-4 text-slate-500 ml-auto"></i>
            </div>
            <div class="flex items-center pt-5">
                <div>
                    <div class="text-slate-500">Status</div>
                    <div class="mt-1 text-'.$status_class.'">'.$status.'</div>
                </div>
                <i data-lucide="mic" class="w-4 h-4 text-slate-500 ml-auto"></i>
            </div>';

        }else{

            if($get_user_priv){
                if( $get_user_priv[0]->create == 1 ||  Auth::user()->role_name == 'Admin' ){
                    $can_update = '<a href="javascript:;" data-usr-id="" data-tw-toggle="modal" data-tw-target="#employee_modal" class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md">';
                    $can_update_icon = '<i class="fa fa-plus w-4 h-4 text-slate-500 ml-auto"></i>';

                }else{
                    $can_update = '<a href="javascript:;" data-usr-id="" class="no_user_priv flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md">';
                    $can_update_icon = '<i class="fa fa-minus w-4 h-4 text-slate-500 ml-auto"></i>';
                }
            }else{
                $can_update = '<a href="javascript:;" data-usr-id="" data-tw-toggle="modal" data-tw-target="#employee_modal" class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md">';
                $can_update_icon = '<i class="fa fa-plus w-4 h-4 text-slate-500 ml-auto"></i>';
            }

            $employment_info .= '
            <div class=" border-slate-200 dark:border-darkmode-400">
                    '.$can_update.'
                    <div class="mr-auto font-medium text-base">Not Employed!</div>
                    <div class="ml-auto font-medium">'.$can_update_icon.'</div>
                </a>
            </div>
            ';

        }



        $accounts_Active = User::with('getUserinfo')->where('active',1)->whereMonth('last_seen','>=', Carbon::now()->subMonth())->get()->count();
        $accounts_Inactive = User::with('getUserinfo')->where('active',1)->whereDate('last_seen','<',Carbon::now()->subMonth())->get()->count();
        $accounts_ActiveToday = User::with('getUserinfo')->whereDate('last_seen', Carbon::today())->where('active',1)->whereNotNull('employee')->get()->count();
        $accounts_Users = User::with('getUserinfo')->get()->count();
        $accounts_UsersRemoved = User::with('getUserinfo')->where('active',0)->get()->count();
        $accounts_Employees = User::with('getUserinfo','get_user_employment')->where('active',1)->whereHas('get_user_employment')->get()->count();
        $accounts_Applicants = User::with('getUserinfo','get_is_at_applicant_list')->where('active',1)->whereHas('get_is_at_applicant_list')->get()->count();
        $accounts_Admin = User::with('getUserinfo')->where('active',1)->where('role_name','Admin')->get()->count();
        $accounts_Guest = User::with('getUserinfo')->where('active',1)->whereNull('last_seen')->get()->count();
        $accounts_ = User::with('getUserinfo')->where('active',1)->get()->count();



        return json_encode(array(
            "data"=>$data,
            "user"=>$user,
            "user_id_global"=>$user_id_global,
            "user_info"=>$user_info,
            "profile_info"=>$profile_info,
            "employment_info"=>$employment_info,
            "accounts_Active"=>$accounts_Active,
            "accounts_Inactive"=>$accounts_Inactive,
            "accounts_ActiveToday"=>$accounts_ActiveToday,
            "accounts_Users"=>$accounts_Users,
            "accounts_UsersRemoved"=>$accounts_UsersRemoved,
            "accounts_Employees"=>$accounts_Employees,
            "accounts_Applicants"=>$accounts_Applicants,
            "accounts_Admin"=>$accounts_Admin,
            "accounts_Guest"=>$accounts_Guest,
            "accounts_"=>$accounts_,
            "accounts_"=>$accounts_,
            "profile_pint_and_title"=>$profile_pint_and_title,
        ));
    }

    public function sync_data_account_profile_employee(Request $request){
        $data = $request->all();

        tblemployee::with('getHRdetails')->whereNotNull('agencyid')->where('active',1)->chunk(100, function ($profiles) {
            foreach($profiles as $profile){

                $check_if_has_account = User::where('employee',$profile->agencyid)->first();

                if($check_if_has_account ){


                }else{

                    $username = $profile->agencyid;

                    if($profile->email){
                        $username = $profile->email;
                    }

                    $create_user = [
                        'profile_id' => $profile->id,
                        'username' => $username,
                        'password' => '1234',
                        'employee' => $profile->agencyid,
                        'firstname' => $profile->firstname,
                        'middlename' => $profile->mi,
                        'lastname' => $profile->lastname,
                    ];

                    $user_id_ = User::create($create_user)->id;

                }




                $check_if_employed = agency_employees::where('agency_id',$profile->agencyid)->first();

                if($check_if_employed){



                }else{
                    $agencyid = $profile->agencyid;
                    $designation_id = '';
                    $position_id = '';
                    $agencycode_id = '';
                    $salary_amount = '';
                    $regular_status = '';
                    $rank = '';
                    $tranch = '';

                if($profile->getHRdetails()->exists()){

                    $agencyid = $profile->getHRdetails->employeeid;
                    $designation_id = $profile->getHRdetails->position;
                    $position_id = $profile->getHRdetails->designation;
                    $agencycode_id = $profile->getHRdetails->agencycodeid;
                    $salary_amount = $profile->getHRdetails->salary;
                    $regular_status = $profile->getHRdetails->regular_status;
                    $rank = $profile->getHRdetails->rank;
                    $tranch = $profile->getHRdetails->tranch;
                }


                $agency_code = default_settingNew::where('key','agency_code')->first();

                $count_emp_year = agency_employees::get()->count();
                $employee_id = sprintf($agency_code->value.'-%05d',  $count_emp_year+1);
                $start_date = date('Y-m-d H:i:s');

                $create_employee = [
                    'user_id' => $profile->user_id,
                    'profile_id' => $profile->id,
                    'employee_id' => $employee_id,
                    'agency_id' => $agencyid,
                    'designation_id' => $designation_id,
                    'position_id' => $position_id,
                    'agencycode_id' => $agencycode_id,
                    'office_id' => 27,
                    'employment_type' => '',
                    'start_date' => $start_date,
                    // 'end_date' => $profile,
                    'salary_amount' => $salary_amount,
                    'regular_status' => $regular_status,
                    'rank' => $rank,
                    // 'status' => $profile,
                    'created_by' => Auth::user()->employee,
                ];

                $agency_employees_id = agency_employees::create($create_employee)->id;
                }
                $new_user_id = '';
                if($check_if_has_account){
                    $new_user_id = $check_if_has_account->id;
                }else{
                    $new_user_id = $user_id_;
                }
                $new_employee_id = '';
                if($check_if_employed){
                    $new_employee_id = $check_if_employed->id;
                }else{
                    $new_employee_id = $agency_employees_id ;
                }

                $update_profile = [
                    'user_id' => $new_user_id ,
                    'employee_id' =>  $new_employee_id,
                ];

                tblemployee::where('id',$profile->id)->update($update_profile);

                $update_agency_employees= [
                    'profile_id' =>  $profile->id,
                    'user_id' =>  $new_user_id,
                ];

               agency_employees::where('agency_id',$profile->agencyid)->update($update_agency_employees);

               $update_account = [
                        'profile_id' => $profile->id,
                        'employee_id' => $new_employee_id,
                        'firstname' => $profile->firstname,
                        'middlename' => $profile->mi,
                        'lastname' => $profile->lastname,
                    ];

                User::where('employee', $profile->agencyid)->update($update_account);

            }

        });


        if($request->has('delete_unused_account')) {

            $get_account_not_active = User::whereNull('last_seen')->get();

            foreach($get_account_not_active as $account){

                $get_employee = tblemployee::where('agencyid',$account->employee)->get();

                foreach($get_employee as $profile){
                    tblemployee::where('id', $profile->id)->firstorfail()->delete();
                }

                $get_agency_employee = agency_employees::where('agency_id',$account->employee)->get();

                foreach($get_agency_employee as $employee){
                    agency_employees::where('id', $employee->id)->firstorfail()->delete();
                }


                User::where('id', $account->id)->firstorfail()->delete();

            }

        }




        __notification_set(1,'Sync Data','Data sync User, Profile and Employee successfully!');

        return json_encode(array(
            "data"=>$data,
        ));
    }

    public function sync_data_account_profile_employee_temp(Request $request){
        $data = $request->all();

        // $users = User::get();

        tblemployee::with('getHRdetails')->whereNotNull('agencyid')->where('active',1)->chunk(100, function ($profiles) {

            foreach($profiles as $profile){
                $check_if_already_in = agency_employees::where('agency_id',$profile->agencyid)->where('active',1)->first();

                if($check_if_already_in){


                }else{
                        $agencyid = $profile->agencyid;
                        $designation_id = '';
                        $position_id = '';
                        $agencycode_id = '';
                        $salary_amount = '';
                        $regular_status = '';
                        $rank = '';
                        $tranch = '';

                    if($profile->getHRdetails()->exists()){

                        $agencyid = $profile->getHRdetails->employeeid;
                        $designation_id = $profile->getHRdetails->position;
                        $position_id = $profile->getHRdetails->designation;
                        $agencycode_id = $profile->getHRdetails->agencycodeid;
                        $salary_amount = $profile->getHRdetails->salary;
                        $regular_status = $profile->getHRdetails->regular_status;
                        $rank = $profile->getHRdetails->rank;
                        $tranch = $profile->getHRdetails->tranch;
                    }


                    $agency_code = default_settingNew::where('key','agency_code')->first();

                    $count_emp_year = agency_employees::get()->count();
                    $employee_id = sprintf($agency_code->value.'-%05d',  $count_emp_year+1);
                    $start_date = date('Y-m-d H:i:s');

                    $create_employee = [
                        'user_id' => $profile->user_id,
                        'profile_id' => $profile->id,
                        'employee_id' => $employee_id,
                        'agency_id' => $agencyid,
                        'designation_id' => $designation_id,
                        'position_id' => $position_id,
                        'agencycode_id' => $agencycode_id,
                        'office_id' => 27,
                        'employment_type' => '',
                        'start_date' => $start_date,
                        // 'end_date' => $profile,
                        'salary_amount' => $salary_amount,
                        'regular_status' => $regular_status,
                        'rank' => $rank,
                        // 'status' => $profile,
                        'created_by' => Auth::user()->employee,
                    ];

                    $agency_id = agency_employees::create($create_employee)->id;


                    $update_profile = [
                        'user_id' => $profile->user_id,
                        'employee_id' =>   $agency_id,
                    ];

                    tblemployee::where('id',$profile->id)->update($update_profile);

                    $update_account = [
                        'profile_id' => $profile->id,
                        'employee_id' => $agency_id,
                        'firstname' => $profile->firstname,
                        'middlename' => $profile->mi,
                        'lastname' => $profile->lastname,
                    ];

                    User::where('id', $profile->user_id)->update($update_account);

                }
            }

        });





        //dd($create_employee);

        //__notification_set(1,'Sync Data','Data sync User, Profile and Employee successfully!');
        return json_encode(array(
            "data"=>$data,

        ));
    }

    public function manage_load_edit_account_id(Request $request){
        $data = $request->all();

        $load_account = '';
        $password_tex = '';
        $active_date = '';
        $expire_date = '';
        $go_no_go = '';

        $date_today = date('Y-m-d');
        $date_today=date('Y-m-d', strtotime($date_today));


        if($request->has('account_id')) {

            $load_account = User::where('id', $request->account_id)->first();
            $password_tex = $load_account->password;

            if($load_account->active_date){
                $active_date =  date('Y-m-d', strtotime($load_account->active_date));

            }
            if($load_account->expire_date){
                $expire_date = date('Y-m-d', strtotime($load_account->expire_date));

            }

            if($active_date && $expire_date){
                if (($date_today >= $active_date) && ($date_today <= $expire_date)){
                    $go_no_go = '<i class="fa fa-check w-4 h-4 w-4 h-4 mr-2 text-success"></i><span class="text-success">Active</span>';
                }else{
                    $go_no_go = '<i class="fa fa-minus w-4 h-4 w-4 h-4 mr-2 text-danger"></i><span class="text-danger">Restricted</span>';
                }
            }else if(!$active_date && $expire_date){

                if($date_today <= $expire_date){
                    $go_no_go = '<i class="fa fa-check w-4 h-4 w-4 h-4 mr-2 text-success"></i><span class="text-success">Active</span>';
                }else{
                    $go_no_go = '<i class="fa fa-minus w-4 h-4 w-4 h-4 mr-2 text-danger"></i><span class="text-danger">Restricted</span>';
                }

            }else if($active_date && !$expire_date){
                if($date_today >= $active_date){
                    $go_no_go = '<i class="fa fa-check w-4 h-4 w-4 h-4 mr-2 text-success"></i><span class="text-success">Active</span>';
                }else{
                    $go_no_go = '<i class="fa fa-minus w-4 h-4 w-4 h-4 mr-2 text-danger"></i><span class="text-danger">Restricted</span>';
                }

            }else{
                $go_no_go = '<i class="fa fa-percent w-4 h-4 w-4 h-4 mr-2 text-primary"></i><span class="text-primary">Infinite</span>';
            }


        }

        //dd($load_account);


        return json_encode(array(
            "data"=>$data,
            "load_account"=>$load_account,
            "password_tex"=>$password_tex,
            "active_date"=>$active_date,
            "expire_date"=>$expire_date,
            "go_no_go"=>$go_no_go,


        ));
    }

    public function manage_load_edit_profile_id(Request $request){
        $data = $request->all();

        $load_profile = '';
        $profile_pint_and_title = '<h2 class="font-medium text-base mr-auto">
            I. Personal Information
        </h2>';

        if($request->has('profile_id')) {

            $load_profile = tblemployee::where('id', $request->profile_id)->first();


            $profile_pint_and_title = '
            <h2 class="font-medium text-base mr-auto">
                I. Personal Information
            </h2>
            <a id="btn_print_PDS" target="_blank" href="/my/print/pds/'.Crypt::encrypt($load_profile->agencyid).'" class="ml-auto text-primary truncate flex items-center"> <i class="fa fa-print w-4 h-4 mr-2"></i> PDS </a>';

        }


        return json_encode(array(
            "data"=>$data,
            "load_profile"=>$load_profile,
            "profile_pint_and_title"=>$profile_pint_and_title,

        ));
    }

    public function manage_load_edit_employee_id(Request $request){
        $data = $request->all();

        $load_employee = '';

        if($request->has('employee_id')) {

            $load_employee = agency_employees::where('id', $request->employee_id)->first();

        }

        return json_encode(array(
            "data"=>$data,
            "load_employee"=>$load_employee,

        ));
    }

    public function manage_load_save_account(Request $request){
        $data = $request->all();

        if($request->account_id){
            $get_account_details = User::where('id',$request->account_id)->first();
            $account_agency_id = $get_account_details->employee;

            $add_edit_account = [
                'employee' => $account_agency_id,
                'firstname' => $request->modal_account_first_name,
                'lastname' => $request->modal_account_last_name,
                'username' => $request->modal_account_username,
                'password' => $request->modal_account_password,
                'role_name' => $request->modal_account_role_name,
                'active_date' => $request->modal_account_active_date,
                'expire_date' => $request->modal_account_expire_date,
                'created_by' =>Auth::user()->employee,
            ];

            $account_id_new = User::updateOrCreate(['id' => $request->account_id],$add_edit_account)->id;

            __notification_set(1, "User Account Updated!", "User Account Updated Successfully!");
            add_log('account',$account_id_new,'User Account Updated Successfully!');


        }else{

            if($request->modal_account_first_name === "" && $request->modal_account_last_name === ""){

                $account_agency_id = generate_employee_id(tblemployee::get()->count());

                $check_if_already_in = tblemployee::where('firstname', $request->modal_account_first_name)->where('lastname', $request->modal_account_last_name)->first();

                if($check_if_already_in){
                    __notification_set(-1, "Notice!", "This account already exists!");
                }else{
                    $check_if_username_already_in = User::where('username',$request->modal_account_username)->first();

                    if( $check_if_username_already_in){
                        __notification_set(-1, "Notice!", "This username already taken!");
                    }else{
                        $add_edit_account = [
                            'employee' => $account_agency_id,
                            'firstname' => $request->modal_account_first_name,
                            'lastname' => $request->modal_account_last_name,
                            'username' => $request->modal_account_username,
                            'password' => $request->modal_account_password,
                            'role_name' => $request->modal_account_role_name,
                            'active_date' => $request->modal_account_active_date,
                            'expire_date' => $request->modal_account_expire_date,
                            'created_by' =>Auth::user()->employee,
                        ];

                        $account_id_new = User::updateOrCreate(['id' => $request->account_id],$add_edit_account)->id;


                        $create_new_profile = [
                            'agencyid' => $account_agency_id,
                            'firstname' => $request->modal_account_first_name,
                            'lastname' => $request->modal_account_last_name,
                            'user_id' => $account_id_new,
                            'created_by' =>Auth::user()->employee,
                        ];
                        $profile_id = tblemployee::create($create_new_profile);

                        $update_account = [
                            'profile_id' => $profile_id->id,
                        ];

                        User::where('id',  $account_id_new)->update($update_account);

                        //update user priv
                        reloadAddUsers($account_agency_id);

                        __notification_set(1, "User Account Added!", "User Account Added Successfully!");
                        add_log('account',$account_id_new,'User Account Added Successfully!');
                    }

                }
                }else{
                    __notification_set(-1, "Notice!", "Make sure to fill all the fields!");
                }
            }


        return json_encode(array(
            "data"=>$data,

        ));
    }

    public function manage_load_save_profile(Request $request){
        $data = $request->all();


        $add_edit_profile = [
            'lastname' => $request->modal_profile_last_name,
            'firstname' => $request->modal_profile_first_name,
            'mi' => $request->modal_profile_mid_name,
            'extension' => $request->modal_profile_name_extension,
            'dateofbirth' => $request->modal_profile_date_birth,
            'sex' => $request->modal_application_gender,
            'civilstatus' => $request->modal_profile_civil_status,
            'height' => $request->modal_profile_height,
            'weight' => $request->modal_profile_weight,
            'bloodtype' => $request->modal_profile_blood_type,
            'gsis' => $request->modal_profile_gsis,
            'pagibig' => $request->modal_profile_pagibig,
            'philhealth' => $request->modal_profile_philhealth,
            'tin' => $request->modal_profile_tin,
            'agencyid' => $request->modal_profile_agency,
            'placeofbirth' => $request->modal_profile_place_birth,
            'telephone' => $request->modal_profile_tel_number,
            'mobile_number' => $request->modal_profile_mobile_number,
            'email' => $request->modal_profile_email,
            'created_by' =>Auth::user()->employee,
        ];

        $profile_id_new = tblemployee::updateOrCreate(['id' => $request->profile_id],$add_edit_profile)->id;

        if($request->profile_id){
            __notification_set(1, "User Profile Updated!", "User Profile Updated Successfully!");
            add_log('profile',$profile_id_new,'User Profile Updated Successfully!');

        }else{

            $update_profile = [
                'user_id' => $request->user_id_global,
            ];

            tblemployee::where('id',  $profile_id_new)->update($update_profile);


            $update_user = [
                'profile_id' => $profile_id_new,
                'lastname' => $request->modal_profile_last_name,
                'firstname' => $request->modal_profile_first_name,
                'middlename' => $request->modal_profile_mid_name,
            ];

            User::where('id',  $request->user_id_global)->update($update_user);

            __notification_set(1, "User Profile Added!", "User Profile Added Successfully!");
            add_log('profile',$profile_id_new,'User Profile Added Successfully!');
        }

        return json_encode(array(
            "data"=>$data,
        ));
    }

    public function manage_load_save_employee(Request $request){
        $data = $request->all();
        $employee_id = '';
        $generated_id = '';
        $agency_id = '';
        $employee_id_new = '';
        $agency_code = default_settingNew::where('key','agency_code')->first();

        if($request->employee_id){

            $employee_id = $request->employee_id;

        }else{

            $count_emp_year = agency_employees::get()->count();
            $generated_id = sprintf($agency_code->value.'-%05d',  $count_emp_year+1);
            $check_id = agency_employees::where('employee_id',$generated_id)->get()->count();

            if($check_id){
                $employee_id = sprintf($agency_code->value.'-%05d',  $count_emp_year+1+$check_id);
            }else{
                $employee_id = sprintf($agency_code->value.'-%05d',  $count_emp_year+1);
            }

        }


        $check_profile = tblemployee::where('user_id',  $request->user_id_global)->first();

        if($check_profile){
            if($check_profile->agencyid){

                $agency_id = $check_profile->agencyid;

            }else{

                $agency_id = $request->modal_employee_id;

            }
        }else{

            $agency_id = $request->modal_employee_id;

        }


        $add_edit_employee = [
            'user_id' => $request->user_id_global,
            'employee_id' => $employee_id,
            'agency_id' => $agency_id,
            'designation_id' => $request->modal_designation_id,
            'position_id' => $request->modal_position_id,
            'agencycode_id' => $agency_code->value,
            'office_id' => $request->modal_rc_id,
            'employment_type' => $request->modal_employment_type,
            'start_date' => $request->modal_start_date,
            'end_date' => $request->modal_end_date,
            'salary_amount' => $request->modal_salary,
            'regular_status' => '',
            'rank' => '',
            'tranch' => '',
            'status' => $request->modal_employee_status,
            'created_by' =>Auth::user()->employee,
        ];

        $employee_id_new = agency_employees::updateOrCreate(['id' => $request->employee_id],$add_edit_employee)->id;

        if($request->employee_id){

            __notification_set(1, "Employee Updated!", "Employee Updated Successfully!");
            add_log('employee',$employee_id_new,'Employee Updated Successfully!');

        }else{


            $update_profile = [
                'employee_id' => $employee_id_new,
                'agencyid' => $agency_id,
            ];

            $profile_id = tblemployee::updateOrCreate(['user_id' => $request->user_id_global],$update_profile)->id;

            $update_user = [
                'employee_id' => $employee_id_new,
                'profile_id' => $profile_id,
                'employee' => $agency_id,
            ];

            User::where('id',  $request->user_id_global)->update($update_user);

            $update_employee = [
                'user_id' => $request->user_id_global,
                'profile_id' => $profile_id,
            ];
            agency_employees::where('id',  $employee_id_new)->update($update_employee);


            __notification_set(1, "Employee Added!", "Employee Added Successfully!");
            add_log('employee',$employee_id_new,'Employee Added Successfully!');
        }

        return json_encode(array(
            "data"=>$data,
        ));
    }

    public function manage_load_priv_notif(Request $request){
        $data = $request->all();

        __notification_set(-1,'Notice','You dont have privilege to access this operation, Contact System Administrator.');

        return json_encode(array(
            "data"=>$data,
        ));
    }

    public function manage_load_back_image(Request $request){

        $login_white_logo_background = '';

        $query_logo = default_settingNew::where('key', 'login_white_logo_background')->where('active', true)->first();


        if($query_logo)
        {
            $get_image = $query_logo->image;
            $login_white_logo_background = url('') . "/uploads/settings/" . $get_image;
        }

        return $login_white_logo_background;

    }


    public function admin_manage_check_account_notif(Request $request){
        $data = $request->all();

        __notification_set(-1,'Notice','You dont have privilege to access this operation, Contact System Administrator.');

        return json_encode(array(
            "data"=>$data,
        ));
    }

    function export_profile(){

        $excel = Excel::download(new profileExport, 'profile-collection.xlsx');
        return $excel;
    }

    public function import_profile(Request $request)
    {
        // dd($request);
        Excel::import(new ImportProfile, $request->file('modal_set_imageUpload')->store('files'));
        return redirect()->back();
    }

    public function manage_save_designation(Request $request)
    {
        $data = $request->all();

        if($request->has('modal_desig_name')) {

            if($request->modal_desig_name){


                $manage_save_designation = [
                    'userauthority' => $request->modal_desig_name,
                    'description' => $request->modal_desig_description,
                    'created_by' =>Auth::user()->employee,
                ];

                tbluserassignment::updateOrCreate(['id' => $request->designation_id],$manage_save_designation)->id;
                __notification_set(1,'Success','Designation added successfully.!');


            }else{

                __notification_set(-1,'Notice','Make sure to fill all the details!');


            }

        }else{

            __notification_set(-1,'Notice','Something went wrong!');


        }
        $des_list = load_designation('');
        $option_des = '';
        foreach( $des_list as $des){
            $option_des .= '<option  value="'.$des->id.'">'.$des->userauthority.'</option>';
        }


        return json_encode(array(
            "data"=>$data,
            "option_des"=>$option_des,
            "des_list"=>$des_list,
        ));
    }

    public function manage_save_position(Request $request)
    {
        $data = $request->all();


        if($request->has('modal_position_description')) {

            if($request->modal_position_name){
                $manage_save_position = [
                    'emp_position' => $request->modal_position_name,
                    'descriptions' => $request->modal_position_description,
                    'created_by' =>Auth::user()->employee,
                ];

              tblposition::updateOrCreate(['id' => $request->position_id],$manage_save_position)->id;

              __notification_set(1,'Success','Position added successfully.!');

            }else{

                __notification_set(-1,'Notice','Make sure to fill all the details!');

            }

        }else{

            __notification_set(-1,'Notice','Something went wrong!');

        }

        $pos_list = load_position('');
        $option_pos = '';
        foreach( $pos_list as $pos){
            $option_pos .= '<option  value="'.$pos->id.'">'.$pos->emp_position.'</option>';
        }

        return json_encode(array(
            "data"=>$data,
            "option_pos"=>$option_pos,
        ));
    }

    public function manage_save_rc(Request $request)
    {
        $data = $request->all();


        if($request->has('modal_rc_name')) {

            if($request->modal_rc_name){
                $manage_save_rc = [
                    'centername' => $request->modal_rc_name,
                    'descriptions' => $request->modal_rc_description,
                    'created_by' =>Auth::user()->employee,
                ];

              tbl_responsibilitycenter::updateOrCreate(['responid' => $request->rc_id],$manage_save_rc)->responid;

              __notification_set(1,'Success','Responsibility Center added successfully.!');

            }else{

                __notification_set(-1,'Notice','Make sure to fill all the details!');

            }

        }else{

            __notification_set(-1,'Notice','Something went wrong!');

        }

        $rc_list = load_responsibility_center('');
        $option_rc = '';
        foreach( $rc_list as $rc){
            $option_rc .= '<option  value="'.$rc->responid.'">'.$rc->centername.'</option>';
        }

        return json_encode(array(
            "data"=>$data,
            "option_rc"=>$option_rc,
        ));
    }

    public function manage_save_emloyement_type(Request $request)
    {
        $data = $request->all();


        if($request->has('modal_employment_type_name')) {

            if($request->modal_employment_type_name){
                $manage_save_et = [
                    'name' => $request->modal_employment_type_name,
                    'desc' => $request->modal_employment_type_description,
                    'created_by' =>Auth::user()->employee,
                ];

              employment_type::updateOrCreate(['id' => $request->et_id],$manage_save_et)->id;

              __notification_set(1,'Success','Employment added successfully.!');

            }else{

                __notification_set(-1,'Notice','Make sure to fill all the details!');

            }

        }else{

            __notification_set(-1,'Notice','Something went wrong!');

        }

        $et_list = load_employment_type('');
        $option_et = '';
        foreach( $et_list as $et){
            $option_et .= '<option  value="'.$et->id.'">'.$et->name.'</option>';
        }

        return json_encode(array(
            "data"=>$data,
            "option_et"=>$option_et,
        ));
    }

    public function remove_account(Request $request){
        $data = $request->all();

        if($request->has('account_id')){
            $get_account_id = User::where('id',$request->account_id)->first();

            if($get_account_id){
                $check_profile = tblemployee::where('agencyid',$get_account_id->employee)->first();
                if($check_profile){
                    $update_remove_profile = [
                        'active' => '0',
                    ];
                    tblemployee::where(['agencyid' =>  $get_account_id->employee])->first()->update($update_remove_profile);
                }

                $check_profile = agency_employees::where('agency_id',$get_account_id->employee)->first();
                if( $check_profile){
                    $update_remove_employee = [
                        'active' => '0',
                    ];
                    agency_employees::where(['agency_id' =>  $get_account_id->employee])->first()->update($update_remove_employee);
                }

                if($get_account_id){
                    $update_remove = [
                        'active' => '0',
                    ];
                    User::where(['id' =>  $request->account_id])->first()->update($update_remove);
                }
            }


        }

        __notification_set(1,'Success','Account '.$get_account_id->lastname.' removed Successfuly!');

        add_log('account',$request->account_id,'Account removed Successfuly!');

        return json_encode(array(
            "data"=>$data,
        ));
    }





    /** ASIS STUDENTS ACCOUNT MANAGEMENT */
    public function adminStudentsAccountManagement(Request $request)
    {
        return view('admin.ASIS.account_management.students_accounts');
    }
    public function loadAll_MYSQL_Students(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $filters = $request->except('page', 'per_page');
        $results = '';
        $search_result = '';
        $search_value  = '';
        $filtered_value  = '';
        $test  = '';
        $searchKeyword  = '';


        // Search filter
        if (isset($filters['search'])) {
            $searchKeyword = trim($filters['search']);


            $transactions_search = User::whereNotNull('studid')->
                whereRaw('LOWER(studid) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                ->orWhereRaw('LOWER(email) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                ->orWhereRaw('LOWER(fullname) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);

            $search_value = $this->iterator($transactions_search);
        }


        // FILTER DATA BASED ON PAGE
        if (isset($filters['limit'])) {
            // Perform pagination on the query
            $limit_page = $filters['limit'];

            if ($limit_page === 999999) {

                $transactions = enrollees_appointment::whereNotNull('studid')
                    ->where('active', 1)
                    ->with(['getEnrolleesInfo', 'getScheduleData', 'getAddress'])
                    ->orderBy('created_at', 'desc') // Add this line to sort by 'created_at' in ascending order
                    ->paginate($limit_page);

                $results = $this->iterator($transactions);

            } else {

                $transactions = $this->Query($limit_page);
                $results = $this->iterator($transactions);

            }
        }
        else {

            $transactions = $this->Query($perPage);
            $results = $this->iterator($transactions);
        }


        // FILTER DATA BASED ON STATUS
        if (isset($filters['limitStatus'])) {
            // Perform pagination on the query
            $limit_status = $filters['limitStatus'];

            if ($limit_status == '999999') {

                $my_transactions = User::whereNotNull('studid')
                    ->orderBy('created_at', 'desc') // Add this line to sort by 'created_at' in ascending order
                    ->paginate($limit_status);

                $results = $this->iterator($my_transactions);

            } else {

                $my_transactions = User::where('active', $limit_status)
                    ->orWhere('email_verified', $limit_status)
                    ->paginate($perPage);
                $results = $this->iterator($my_transactions);

            }
        }



        // Calculate the summary message
        $startEntry = ($transactions->currentPage() - 1) * $transactions->perPage() + 1;
        $endEntry = min($startEntry + $transactions->count() - 1, $transactions->total());

        $summaryMessage = "Showing $startEntry to $endEntry of {$transactions->total()} entries";


        return response()->json([
            'transactions' => $results,
            'search_query' => $search_value,
            'data' => $transactions->items(),
            'current_page' => $transactions->currentPage(),
            'last_page' => $transactions->lastPage(),
            'per_page' => $transactions->perPage(),
            'total' => $transactions->total(),
            'summary' => $summaryMessage,
        ]); // Return the Transactions as a JSON response
    }
    public function Query($perPage){

        return User::whereNotNull('studid')
                    ->orderBy('studid', 'desc')->paginate($perPage);

    }
    public function iterator($transactions){

        $tres = [];

        foreach ($transactions as $data)
        {

            $user_id = $data->id ?? 'No Data';
            $student_id = $data->studid ?? 'No Data';

            $password = $data->password ?? 'No Data';
            $fullName = $data->fullname ?? 'No Data';
            $email_verified = $data->email_verified ?? 'No Data';
            $email_verified_at = $data->email_verified_at ? Carbon::parse($data->email_verified_at)->format('F d, Y') : 'No Data';
            $active = $data->active ?? 'No Data';
            $created_at = $data->created_at ? Carbon::parse($data->created_at)->format('F d, Y') : 'No Data';

            if($data->email)
            {
                $email = $data->email ?? 'No Data';
                $class = 'text-slate-500 text-xs whitespace-nowrap mt-0.5';
            }else
            {
                $email = 'No Email Found, cannot login';
                $class = 'text-danger text-xs whitespace-nowrap mt-0.5';
            }

            if($active === '1')
            {
                $active_class = 'primary';
                $active_status = 'Active';
            }else
            {
                $active_class = 'danger';
                $active_status = 'In-Active';
            }

            if($email_verified === '1')
            {
                $email_class = 'primary';
                $email_status = 'Verified';
            }else
            {
                $email_class = 'danger';
                $email_status = 'Un-Verified';
            }

            $td = [

                "user_id" => $user_id,
                "student_id" => $student_id,
                "email" => $email,
                "password" => $password,
                "fullName" => $fullName,
                "email_verified" => $email_verified,
                "email_verified_at" => $email_verified_at,
                "active" => $active,
                "created_at" => $created_at,
                "email_class" => $email_class,
                "email_status" => $email_status,
                "active_class" => $active_class,
                "active_status" => $active_status,
                "class" => $class,


            ];

            $tres[count($tres)] = $td;

        }
        return $tres;

    }
    public function updateStudentsAccount(Request $request)
    {
        $student_id = trim($request->student_id);
        $account_status = trim($request->account_status);
        $email_status = trim($request->email_status);
        $password = trim($request->password);
        $email = trim($request->email);

        if($email == 'No Email Found, cannot login' || $email == '' || $email == null)
        {
            $email = null;
        }else
        {
            $email = trim($request->email);
        }

        if($email_status === '0')
        {
            $value = null;
        }else
        {
            $value = Carbon::now()->format('Y-m-d H:i:s');
        }

        User::where('studid', $student_id)->update([

            'active' => $account_status,
            'email' => $email,
            'password' => $password,
            'email_verified' => $email_status,
            'email_verified_at' => $value,

        ]);

        return json_encode(array(

            'status' => 'success',
            'title' => 'Success!',
            'status_code' => -1,
            'message' => 'Updated Successfully!',

        ), JSON_THROW_ON_ERROR);
    }




    /** ASIS ENROLLEES ACCOUNT MANAGEMENT */
    public function adminEnrolleesAccountManagement(Request $request)
    {
        return view('admin.ASIS.account_management.enrollees_accounts');
    }
    public function loadEnrolleesAccounts(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $filters = $request->except('page', 'per_page');
        $results = '';
        $search_result = '';
        $search_value  = '';
        $filtered_value  = '';
        $test  = '';
        $searchKeyword  = '';


        // Search filter
        if (isset($filters['search'])) {
            $searchKeyword = trim($filters['search']);


            $transactions_search = pre_enrollees::whereNotNull('pre_enrollee_id')->
            whereRaw('LOWER(pre_enrollee_id) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                ->orWhereRaw('LOWER(firstname) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                ->orWhereRaw('LOWER(midname) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                ->orWhereRaw('LOWER(lastname) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                ->orWhereRaw('LOWER(email) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);

            $search_value = $this->enrolleesIterator($transactions_search);
        }


        // FILTER DATA BASED ON PAGE
        if (isset($filters['limit'])) {
            // Perform pagination on the query
            $limit_page = $filters['limit'];

            if ($limit_page === 999999) {

                $transactions = pre_enrollees::whereNotNull('pre_enrollee_id')
                    ->where('active', 1)
                    ->orderBy('pre_enrollee_id', 'asc') // Add this line to sort by 'created_at' in ascending order
                    ->paginate($limit_page);

                $results = $this->enrolleesIterator($transactions);

            } else {

                $transactions = $this->queryEnrollees($limit_page);
                $results = $this->enrolleesIterator($transactions);

            }
        }
        else {

            $transactions = $this->queryEnrollees($perPage);
            $results = $this->enrolleesIterator($transactions);
        }


        // FILTER DATA BASED ON STATUS
        if (isset($filters['limitStatus'])) {
            // Perform pagination on the query
            $limit_status = $filters['limitStatus'];

            if ($limit_status == '999999') {

                $my_transactions = pre_enrollees::whereNotNull('pre_enrollee_id')
                    ->orderBy('pre_enrollee_id', 'asc') // Add this line to sort by 'created_at' in ascending order
                    ->paginate($limit_status);

                $results = $this->enrolleesIterator($my_transactions);

            } else {

                $my_transactions = pre_enrollees::where('active', $limit_status)
                    ->orWhere('email_verified', $limit_status)
                    ->paginate($perPage);
                $results = $this->enrolleesIterator($my_transactions);

            }
        }



        // Calculate the summary message
        $startEntry = ($transactions->currentPage() - 1) * $transactions->perPage() + 1;
        $endEntry = min($startEntry + $transactions->count() - 1, $transactions->total());

        $summaryMessage = "Showing $startEntry to $endEntry of {$transactions->total()} entries";


        return response()->json([
            'transactions' => $results,
            'search_query' => $search_value,
            'data' => $transactions->items(),
            'current_page' => $transactions->currentPage(),
            'last_page' => $transactions->lastPage(),
            'per_page' => $transactions->perPage(),
            'total' => $transactions->total(),
            'summary' => $summaryMessage,
        ]); // Return the Transactions as a JSON response
    }
    public function queryEnrollees($perPage){

        return pre_enrollees::whereNotNull('pre_enrollee_id')
            ->orderBy('pre_enrollee_id', 'asc')->paginate($perPage);

    }
    public function enrolleesIterator($transactions): array
    {

        $tres = [];

        foreach ($transactions as $data)
        {

            $pre_enrollees_id = $data->pre_enrollee_id;
            $firstname = $data->firstname;
            $midname = $data->midname;
            $lastname = $data->lastname;
            $extension = $data->extension;
            $password = $data->password;
            $email_verified = $data->email_verified_at;

            if($data->midname)
            {
                $my_mid_name   = $data->midname;
                $my_mid_name_new = substr($my_mid_name, 0, 1);

                $mi = $my_mid_name_new.'.';

            }else
            {
                $mi = '';
            }

            $fullName = $firstname.' '.$mi.' '.$lastname;


            if($data->getStatusCodes)
            {
                $account_status = $data->getStatusCodes->name;
            }else
            {
                $account_status = '';
            }

            $active = $data->active;

            if($active === '1')
            {
                $active_class = 'primary';
                $active_status = 'Active';
            }else
            {
                $active_class = 'danger';
                $active_status = 'In-Active';
            }


            if($data->email)
            {
                $email = $data->email ?? 'No Data';
                $class = 'text-slate-500 text-xs whitespace-nowrap mt-0.5';
            }else
            {
                $email = 'No Email Found, cannot login';
                $class = 'text-danger text-xs whitespace-nowrap mt-0.5';
            }


            if($email_verified)
            {
                $email_class = 'primary';
                $email_status = 'Verified';

            }else
            {
                $email_class = 'danger';
                $email_status = 'Un-Verified';
            }


            $td = [

                "pre_enrollees_id" => $pre_enrollees_id,
                "firstname" => $firstname,
                "midname" => $midname,
                "lastname" => $lastname,
                "extension" => $extension,
                "email" => $email,
                "password" => $password,
                "email_verified" => $email_verified,
                "email_status" => $email_status,
                "email_class" => $email_class,
                "class" => $class,
                "account_status" => $account_status,
                "active" => $active,
                "active_class" => $active_class,
                "active_status" => $active_status,
                "fullName" => $fullName,



            ];

            $tres[count($tres)] = $td;

        }
        return $tres;

    }
    public function updateEnrolleessAccount(Request $request)
    {
        $enrollees_id = trim($request->enrollees_id);
        $account_status = trim($request->account_status);
        $email_status = trim($request->email_status);
        $password = trim($request->password);

        if($email_status === '0')
        {
            $value = null;
        }else
        {
            $value = Carbon::now()->format('Y-m-d H:i:s');
        }

        pre_enrollees::where('pre_enrollee_id', $enrollees_id)->update([

            'password' => $password,
            'active' => $account_status,
            'email_verified' => $email_status,
            'email_verified_at' => $value,

        ]);

        return json_encode(array(

            'status' => 'success',
            'title' => 'Success!',
            'status_code' => -1,
            'message' => 'Updated Successfully!',

        ), JSON_THROW_ON_ERROR);
    }
}
