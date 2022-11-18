<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
            'name'=>'RK Mobiles',
            'address'=>'Main Street, Colombo',
            'email'=>'info@eshopping.com',
            'contact'=>'0770027949',
            'image'=>'upload/company/1629177829.jpg',
            'color'=>'0077b6',
        ]);
    }
}
