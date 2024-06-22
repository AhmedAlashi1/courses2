<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $permissions = [
            'display dashboard',

            'display admins',
            'create admins',
            'update admins',
            'delete admins',


            'display roles',
            'create roles',
            'update roles',
            'delete roles',


            'display users',
            'delete users',


            'display courses',
            'create courses',
            'update courses',
            'delete courses',

            'display videos',
            'create videos',
            'update videos',
            'delete videos',

            'display settings',
	        'update settings',

        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
