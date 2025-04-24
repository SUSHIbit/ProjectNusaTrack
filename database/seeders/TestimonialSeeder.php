<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'client_name' => 'Sarah Johnson',
                'client_position' => 'Homeowner',
                'content' => 'NusaTrack made our home building process so much easier. We could track every step of the construction and communicate directly with the team. The final result exceeded our expectations!',
                'rating' => 5,
                'project_name' => 'Custom Home in Jakarta',
            ],
            [
                'client_name' => 'Budi Santoso',
                'client_position' => 'Business Owner',
                'content' => 'We used NusaTrack for our restaurant renovation and couldn\'t be happier. The ability to monitor progress remotely saved us countless hours, and the team was responsive to all our questions.',
                'rating' => 5,
                'project_name' => 'Santoso Restaurant Remodel',
            ],
            [
                'client_name' => 'Dewi Putri',
                'client_position' => 'Real Estate Developer',
                'content' => 'As a developer managing multiple projects, NusaTrack has been invaluable. The platform is intuitive, and the construction quality is consistently excellent. Highly recommended!',
                'rating' => 4,
                'project_name' => 'Apartment Complex Development',
            ],
            [
                'client_name' => 'Ahmad Rahman',
                'client_position' => 'Office Manager',
                'content' => 'Our office renovation was completed on time and on budget thanks to NusaTrack. The transparent process and regular updates kept everyone informed and minimized disruption to our business.',
                'rating' => 5,
                'project_name' => 'Corporate Office Renovation',
            ],
            [
                'client_name' => 'Lisa Chen',
                'client_position' => 'Homeowner',
                'content' => 'The kitchen remodeling service was fantastic. I appreciated being able to see daily updates and sign off on changes directly through the platform. The result is beautiful!',
                'rating' => 5,
                'project_name' => 'Modern Kitchen Remodel',
            ],
            [
                'client_name' => 'Fajar Wibowo',
                'client_position' => 'Retail Store Owner',
                'content' => 'NusaTrack helped us expand our retail location with minimal stress. The team was professional, and the construction quality was excellent. The platform made it easy to stay on top of progress.',
                'rating' => 4,
                'project_name' => 'Retail Store Expansion',
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}