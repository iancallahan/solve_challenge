<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('secret')
        ]);

       $admin = App\User::find('1');
       $admin->roles()->attach(App\Role::where('name','admin')->first());

       factory(App\User::class, 100)->create()->each(function ($u) {
        $u->roles()->attach(App\Role::where('name','contributor')->first());
      });
    }
}
