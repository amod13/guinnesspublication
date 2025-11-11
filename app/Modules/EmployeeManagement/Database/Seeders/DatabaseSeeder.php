<?php

        namespace App\Modules\EmployeeManagement\Database\Seeders;

        use Illuminate\Database\Seeder;
        use App\Modules\EmployeeManagement\Database\Seeders\EmployeeManagementSeeder;

        class DatabaseSeeder extends Seeder
        {
            public function run(): void
            {
                $this->call([
                    EmployeeManagementSeeder::class,
                ]);
            }
        }