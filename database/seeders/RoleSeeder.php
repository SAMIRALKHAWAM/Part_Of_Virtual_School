<?php

namespace Database\Seeders;

use App\Models\Actor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $r = Role::create([
            'name' => 'Admin',
            'guard_name' => 'actor',
        ]);

        $p = Permission::create([
            'name' => 'Subject Management',
            'guard_name' => 'actor',
        ]);
        $p2 = Permission::create([
            'name' => 'Class Management',
            'guard_name' => 'actor',
        ]);
        $p3 = Permission::create([
            'name' => 'Teacher Management',
            'guard_name' => 'actor',
        ]);
        $p4 = Permission::create([
            'name' => 'Primary Section Management',
            'guard_name' => 'actor',
        ]);
        $p5 = Permission::create([
            'name' => 'Subject Section Management',
            'guard_name' => 'actor',
        ]);
        $p6 = Permission::create([
            'name' => 'Secondary Section Management',
            'guard_name' => 'actor',
        ]);
        $p7 = Permission::create([
            'name' => 'Student Management',
            'guard_name' => 'actor',
        ]);
        $p8 = Permission::create([
            'name' => 'Exam Management',
            'guard_name' => 'actor',
        ]);
        $a = Actor::first();

        $a->assignRole($r);
        $r->givePermissionTo($p);
        $r->givePermissionTo($p2);
        $r->givePermissionTo($p3);
        $r->givePermissionTo($p4);
        $r->givePermissionTo($p5);
        $r->givePermissionTo($p6);
        $r->givePermissionTo($p7);
        $r->givePermissionTo($p8);


        Role::create([
            'name' => 'Teacher',
            'guard_name' => 'actor',
        ]);
        Role::create([
            'name' => 'Student',
            'guard_name' => 'actor',
        ]);


    }
}
