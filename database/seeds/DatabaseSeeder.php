<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new \App\User;
        $user->fname     = 'Admin';
        $user->lname     = 'Sample';
        $user->midname     = 'Ni';
        $user->location     = 'Tagbilaran';
        $user->contact     = '09111111111';
        $user->email    = 'admin@email.com';
        $user->password = 'secret';
        $user->user_type     = 'admin';
        $user->save();


        // $this->call(UsersTableSeeder::class);
    }


}
