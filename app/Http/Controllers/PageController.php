<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Testimonial;

class PageController extends Controller
{
    public function home()
    {
        $services = Service::take(3)->get();
        $testimonials = Testimonial::take(3)->get();
        
        return view('pages.home', compact('services', 'testimonials'));
    }
    
    public function aboutUs()
    {
        $team_members = [
            [
                'name' => 'John Doe',
                'position' => 'CEO & Founder',
                'bio' => 'With over 20 years of experience in the construction industry.',
                'image' => 'team/john.jpg'
            ],
            [
                'name' => 'Jane Smith',
                'position' => 'Lead Architect',
                'bio' => 'Award-winning architect specializing in sustainable design.',
                'image' => 'team/jane.jpg'
            ],
            [
                'name' => 'Michael Johnson',
                'position' => 'Construction Manager',
                'bio' => 'Oversees all construction projects with precision and excellence.',
                'image' => 'team/michael.jpg'
            ],
        ];
        
        return view('pages.about-us', compact('team_members'));
    }
}