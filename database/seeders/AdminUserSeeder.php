<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin=Admin::create(['name' => 'Admin Fit Row',
                        'email' => 'admin@admin.com',
                        'password' => bcrypt('123456'),
                        'roles_name' => ['Admin']
            ]);
        $admin->syncRoles(['Admin']);

    }
}
