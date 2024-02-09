<?php

namespace App\Http\Controllers\ASIS_Controllers\system;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MailSettings\mail_settings;
use Illuminate\Support\Facades\Artisan;

class MailSettingsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function mail_settings_index()
    {
        return view('admin.mail_settings.set_up_mail');
    }

    public function saved_configure_data(Request $request)
    {

        try{

            $driver = $request->driver;
            $host = $request->host;
            $port = $request->port;
            $username = $request->username;
            $password = $request->password;
            $encrypt = $request->encrypt;
            $name = $request->name;


            $data = [
                "driver" => $driver,
                "host" => $host,
                "port" => $port,
                "username" => $username,
                "password" => $password,
                "encryption" => $encrypt,
                "name" => $name
            ];
            $saved = mail_settings::create($data);

            if($saved)
            {
                return response()->json([
                    'status' => true,
                    'message' => 'Successfully Saved'
                ]);

            } else
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Unable to saved'
                ]);
            }

        }catch(Exception $e)
        {
            dd($e);
        }
    }

    public function display_data()
    {
        try{
            $data = [];

            $get_config = mail_settings::whereRaw('active == true' || 'active == false')->get();
                foreach($get_config as $config)
                {
                    $td = [
                        'id' => $config->id,
                        'driver' =>  $config->driver,
                        'host' => $config->host,
                        'port' => $config->port,
                        'username' => $config->username,
                        'password' => $config->password,
                        'encryption' => $config->encryption,
                        'name' => $config->name,
                        'active' => $config->active,
                    ];
                $data[count($data)] = $td;
                }

            echo json_encode($data);

        }catch(Exception $e)
        {
            dd($e);
        }
    }

    public function update_data_config(Request $request)
    {
        try
        {
            $id = $request->id;
            $driver = $request->driver;
            $host = $request->host;
            $port = $request->port;
            $username = $request->username;
            $password = $request->password;
            $encrypt = $request->encrypt;
            $name = $request->name;

            $data = [
                "driver" => $driver,
                "host" => $host,
                "port" => $port,
                "username" => $username,
                "password" => $password,
                "encryption" => $encrypt,
                "name" => $name,
            ];


            $update_data = mail_settings::where('id',$id)->update($data);

            if($update_data)
            {
                return response()->json([
                    'status' => true,
                    'message' => 'Successfullly updated'
                ]);

            } else
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Unable Saved'
                ]);
            }

        }catch(Exception $e)
        {
            dd($e);
        }
    }

    // update the status of the mail settings
    public function update_stat_email_stat(Request $request)
    {
        try
        {
            $check = $this->check_if_other_active($request->id,$request->stat);
            $clear_cache = $this->clear_cache();

            if($check != true)
            {
                $update_status = mail_settings::where('id',$request->id)->update(['active'=>true]);



                return response()->json([
                    'status' => true,
                    'message' => 'Successfully Updated the status',
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Unable to update the mail settings'
            ]);

        } catch(Exception $e)
        {
            dd($e);
        }
    }

    private function check_if_other_active($id,$stat)
    {
        try
        {
            $checked = '';

                if($stat == 1)
                {
                    $data = [
                        'active' => false
                    ];

                    $update = mail_settings::where('id',$id)->update($data);
                    $checked = true;

                } else
                {
                    $check_stat = mail_settings::where('active',true)->get();

                    if ($check_stat)
                    {
                        foreach($check_stat as $status)
                        {
                            $update = mail_settings::where('id', $status->id)->update(['active' => false]);
                        }


                        $checked = false;
                    }
                }

            return $checked;
        }catch(Exception $e)
        {
            dd($e);
        }
    }

    protected function clear_cache()
    {
        try
        {
            Artisan::call('config:cache');
        }catch(Exception $e)
        {
            dd($e);
        }
    }

    public function delete_email_config(Request $request)
    {
        try
        {
            $id = $request->id;

            $delete =  mail_settings::where('id',$id)->where('active',false)->delete();

            if($delete)
            {
                return response()->json([
                    'status' => true,
                    'message' => 'Successfully deleted the account'
                ]);
            } else
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Make sure to disable the active first'
                ]);
            }

        }catch(Exception $e)
        {
            dd($e);
        }
    }

}
