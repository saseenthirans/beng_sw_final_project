<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->first_name = 'Super';
        $user->last_name = 'Admin';
        $user->name = 'Super Admin';
        $user->email = 'admin@gmail.com';
        $user->contact = '0771111111';
        $user->password = Hash::make('admin@1122');
        $user->image = 'user/user.png';
        $user->status = 1;
        $user->save();
        
        $user->assignRole('Admin');
    }
}
