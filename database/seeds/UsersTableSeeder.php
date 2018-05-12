<?php

use Illuminate\Database\Seeder;
use pizzallery\User;
use pizzallery\Role;


class UsersTableSeeder extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {

    $role_admin = Role::where('name', 'admin')->first();
    factory(User::class, 100)->create();

    $user = new User();
    $user->name = 'baltadlakd';
    $user->email = 'baltadlakd@gmail.com';
    $user->password = bcrypt('secret');
    $user->age = 22;
    $user->phone = '3321097551';
    $user->save();
    $user->roles()->attach($role_admin);

  }
}
