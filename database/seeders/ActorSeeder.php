<?php

namespace Database\Seeders;

use App\Models\Actor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Actor::create([
           'name' => 'samir',
           'email' => 'samir@gmail.com',
           'password' => 'password',
           'phone' => '4545454545',
           'type' => 'Admin',

       ]);
    }
}
