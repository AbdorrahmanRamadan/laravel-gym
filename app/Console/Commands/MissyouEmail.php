<?php

namespace App\Console\Commands;

use App\Mail\WeMissYou;
use App\Notifications\MissyouNotify;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;
class MissyouEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:users-not-logged-in-for-month';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $missedUsers = User::where('last_login','<',\Carbon\Carbon::today()->subDays(30))->get();
        foreach ($missedUsers as $missedUser){
          //  Mail::to($missedUser)->send(new WeMissYou($missedUser));
            Notification::send($missedUser, new MissyouNotify());
        }
    }
}
