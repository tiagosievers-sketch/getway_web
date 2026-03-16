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
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('abbrev',2);
            $table->string('fips',2);
            $table->string('marketplace_model');
            $table->string('shop_marketplace_model');
            $table->string('hix_name');
            $table->string('hix_url');
            $table->string('shop_hix_name');
            $table->string('shop_hix_url');
            $table->string('8962_link');
            $table->string('8965_link');
            $table->string('assister_program_url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('states');
    }
};
