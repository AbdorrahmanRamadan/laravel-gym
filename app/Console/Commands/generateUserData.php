<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class generateUserData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin {--email=} {--password=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates test user data and insert into the database.';

    /**
     * Execute the console command.
     *
     * @return int
     */

    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        $email = $this->option('email');
        $pass = $this->option('password');
       
        User::create(
            [
                'name'=>'Admin',
                'email'=>$email,
                'password'=>bcrypt($pass),
            ]
        );
    }
}
