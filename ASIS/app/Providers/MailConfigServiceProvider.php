<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\MailSettings\mail_settings;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Config;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        try
        {
            $configure_email = DB::table('email_configurations')->where('active',true)->first();

            if($configure_email)
            {
                $config = array (
                    'driver' => $configure_email->driver,
                    'host' => $configure_email->host,
                    'port' => $configure_email->port,
                    'username' => $configure_email->username,
                    'password' => $configure_email->password,
                    'encryption' => $configure_email->encryption,
                    'from' =>  [
                        'address' => $configure_email->username,
                        'name' => $configure_email->name,
                    ]
                );

                Config::set('mail', $config);
            }
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Please select the mail settings',
                ]);
            }

        }catch(\Exception $e)
        {
            Log::error('Error while setting up email configuration: ' . $e->getMessage());
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }
}
