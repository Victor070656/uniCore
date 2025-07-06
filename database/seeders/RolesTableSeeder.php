<?php

namespace Database\Seeders;

// use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'super-admin'],
            ['name' => 'university-admin'],
            ['name' => 'registrar'],
            ['name' => 'bursar'],
            ['name' => 'hod'],
            ['name' => 'lecturer'],
            ['name' => 'student'],
            ['name' => 'parent'],
            ['name' => 'exams-officer'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['name' => $role['name']]
            );
        }
    }
}
