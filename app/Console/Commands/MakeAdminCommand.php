<?php

namespace App\Console\Commands;

use Hash;
use App\Admin;
use Illuminate\Console\Command;

class MakeAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin {--e|email : admin email} {--p|password : admin password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate an admin';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->alert($this->description);

        $admin = $this->makeAdmin($this->option('email'), $password = $this->option('password') ?: '12345678');
        
        $admin->save();

        $this->table(['email', 'password'],[
            ['email' => $admin->email, 'password' => $password]
        ]);

        $this->line('');
    }

    /**
     * Create admin model.
     *
     * @param string $email
     * @param string $password
     *
     * @return \App\Admin
     */
    protected function makeAdmin(?string $email, ?string $password): Admin
    {
        $customization = [];

        if ($email) {
            $customization['email'] = $email;
        }

        if ($password) {
            $customization['password'] = Hash::make($password);
        }

        return factory(Admin::class)->make($customization);
    }
}
