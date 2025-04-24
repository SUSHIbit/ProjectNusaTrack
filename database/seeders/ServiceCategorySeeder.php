<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;

class ServiceCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Residential Construction',
                'description' => 'Building and renovating homes for families and individuals.',
            ],
            [
                'name' => 'Commercial Construction',
                'description' => 'Construction services for businesses, offices, and retail spaces.',
            ],
            [
                'name' => 'Industrial Construction',
                'description' => 'Specialized construction for manufacturing, warehousing, and industrial facilities.',
            ],
            [
                'name' => 'Renovation & Remodeling',
                'description' => 'Transform existing structures with our renovation and remodeling services.',
            ],
        ];

        foreach ($categories as $category) {
            ServiceCategory::create($category);
        }
    }
}