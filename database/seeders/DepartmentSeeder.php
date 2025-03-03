<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'meta_title' => 'Electronics Department',  // Added value
                'meta_description' => 'Electronics and gadgets',  // Added value
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Fasion',
                'slug' => 'fasion',
                'meta_title' => 'Fashion Department',  // Added value
                'meta_description' => 'Clothing and accessories',  // Added value
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Home, Garden & Tools',
                'slug' => Str::slug('Home, Garden & Tools'),
                'meta_title' => 'Home, Garden & Tools Department',  // Added value
                'meta_description' => 'Furniture, garden tools, and more',  // Added value
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Books & Audible',
                'slug' => Str::slug('Books & Audible'),
                'meta_title' => 'Books & Audible Department',  // Added value
                'meta_description' => 'Books, audiobooks, and more',  // Added value
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Health & Beauty',
                'slug' => Str::slug('Health & Beauty'),
                'meta_title' => 'Health & Beauty Department',  // Added value
                'meta_description' => 'Health products and beauty supplies',  // Added value
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('departments')->insert($departments);
    }
}
