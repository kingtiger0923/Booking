<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use App\Settings;
use Illuminate\Support\Facades\Config as FacadesConfig;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $mail = Settings::where('id', '1')->first();
        if ($mail)
        {
            $config = array(
                'driver'     => 'smtp',
                'host'       => $mail->SMTP_host,
                'port'       => $mail->SMTP_Port,
                'from'       => array('address' => $mail->email_address, 'name' => $mail->SMTP_username),
                'encryption' => 'tls',
                'username'   => $mail->SMTP_username,
                'password'   => $mail->SMTP_password,
                'sendmail'   => '/usr/sbin/sendmail -bs',
                'pretend'    => false,
            );
            Config::set('mail', $config);
        }
    }
}
