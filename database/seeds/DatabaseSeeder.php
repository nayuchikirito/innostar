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
    	$users = factory(App\User::class, 3)->make();
        // $this->call(UsersTableSeeder::class);
    }
}
