<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(4)->create();
        User::create([
            'username' => 'rdnndr',
            'email' => 'riduanindra11@gmail.com',
            'password' => bcrypt('taibau11')
        ]);
    }
}
