<?php

namespace App\Console\Commands;

use App\Mail\SendWelcomeEmail;
use App\Models\GeneralSetting;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class WelcomeMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:welcome-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Welcome mail to new merchants ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $web = GeneralSetting::find(1);
        $users = User::whereNot('welcomeSent',1)->where('email_verified_at','!=',null)->get();
        if ($users->count() >0){
            foreach ($users as $user) {
                if ($user->accountType!=null && $user->accountType!=3){
                    Mail::to($user->email)->send(new SendWelcomeEmail($user,$web));
                    $user->update([
                        'welcomeSent'=>1
                    ]);
                }
            }
        }
    }
}
