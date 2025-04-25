<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Insert Malaysian states as default locations
        $states = [
            'Johor', 'Kedah', 'Kelantan', 'Kuala Lumpur', 'Labuan',
            'Melaka', 'Negeri Sembilan', 'Pahang', 'Penang', 'Perak',
            'Perlis', 'Putrajaya', 'Sabah', 'Sarawak', 'Selangor', 'Terengganu'
        ];

        $locationData = [];
        foreach ($states as $state) {
            $locationData[] = [
                'name' => $state,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('locations')->insert($locationData);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};