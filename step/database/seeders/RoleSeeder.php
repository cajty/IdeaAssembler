<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::factory()->create(['role_name' => 'admin']);
        Role::factory()->create(['role_name' => 'user']);
        Role::factory()->create(['role_name' => 'bannedUser']);
        
        
    }
}
