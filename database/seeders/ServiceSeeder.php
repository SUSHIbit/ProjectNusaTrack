<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            // Residential Construction
            [
                'name' => 'Custom Home Building',
                'description' => 'Design and build your dream home from the ground up with our custom home building services. We work closely with you to create a home that meets your specific needs and preferences.',
                'service_category_id' => 1,
            ],
            [
                'name' => 'Home Extensions',
                'description' => 'Add more space to your existing home with our high-quality extension services. Whether you need an extra bedroom, larger kitchen, or a new living area, we can help.',
                'service_category_id' => 1,
            ],
            [
                'name' => 'Residential Repairs',
                'description' => 'Our experienced team provides reliable repair services for all aspects of your home, from foundation to roof.',
                'service_category_id' => 1,
            ],
            
            // Commercial Construction
            [
                'name' => 'Office Buildings',
                'description' => 'Create productive work environments with our office building construction services. We focus on functional layouts and modern designs.',
                'service_category_id' => 2,
            ],
            [
                'name' => 'Retail Spaces',
                'description' => 'Build attractive and functional retail spaces that enhance the customer experience and maximize sales potential.',
                'service_category_id' => 2,
            ],
            [
                'name' => 'Restaurant Construction',
                'description' => 'Specialized construction services for restaurants, cafes, and food service establishments with attention to kitchen layout and dining areas.',
                'service_category_id' => 2,
            ],
            
            // Industrial Construction
            [
                'name' => 'Manufacturing Facilities',
                'description' => 'Construction of efficient manufacturing facilities designed for your specific production processes.',
                'service_category_id' => 3,
            ],
            [
                'name' => 'Warehouse Construction',
                'description' => 'Build spacious, durable warehouses with optimal layout for storage and logistics operations.',
                'service_category_id' => 3,
            ],
            
            // Renovation & Remodeling
            [
                'name' => 'Kitchen Remodeling',
                'description' => 'Transform your kitchen into a modern, functional space with our comprehensive remodeling services.',
                'service_category_id' => 4,
            ],
            [
                'name' => 'Bathroom Renovation',
                'description' => 'Update your bathroom with new fixtures, tiling, and layouts to create a relaxing and practical space.',
                'service_category_id' => 4,
            ],
            [
                'name' => 'Office Renovation',
                'description' => 'Modernize your office space to improve workflow, aesthetics, and employee satisfaction.',
                'service_category_id' => 4,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}