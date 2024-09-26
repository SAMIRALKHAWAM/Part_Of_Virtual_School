<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class temp extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $r = Role::where('name','Admin')->first();
        $p = Permission::create([
            'name'=>'Exam Management',
            'guard_name' => 'actor',
        ]);

        $r->givePermissionTo($p);
    }
}
