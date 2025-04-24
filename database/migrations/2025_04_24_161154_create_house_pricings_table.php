<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('house_pricings', function (Blueprint $table) {
            $table->id();
            $table->string('house_type');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('total_price', 12, 2);
            $table->decimal('deposit_amount', 12, 2);
            $table->decimal('balance_amount', 12, 2);
            $table->string('image')->nullable();
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('house_pricings');
    }
};