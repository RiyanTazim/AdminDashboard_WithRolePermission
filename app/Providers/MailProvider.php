<?php
namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class MailProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        if (Schema::hasTable('smtps')) {
            $mail = DB::table('smtps')->first();

            if ($mail) {
                // Set mail default transport (driver)
                config(['mail.default' => 'smtp']);

                // Set SMTP driver config
                config(['mail.mailers.smtp' => [
                    'transport'  => 'smtp',
                    'host'       => $mail->host,
                    'port'       => $mail->port,
                    'encryption' => $mail->encryption,
                    'username'   => $mail->username,
                    'password'   => $mail->password,
                ]]);

                // Set sender email and name
                config(['mail.from' => [
                    'address' => $mail->sender,
                    'name'    => env('APP_NAME', 'Laravel'),
                ]]);
            }
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
