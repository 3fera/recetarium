<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $user = new User();
        $user->name = 'Admin';
        $user->username = 'admin';
        $user->email = 'admin@admin.admin';
        $user->password = bcrypt('admin');
        $user->image = $faker->image('/tmp/', 640, 480, 'people');
        $user->save();
    }
}
