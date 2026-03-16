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
        Schema::create('state_medicaids', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('abbrev',2);
            $table->integer('fiscal_year');
            $table->integer('fiscal_quarter');
            $table->decimal('pc_fpl_parent',8,4);
            $table->decimal('pc_fpl_pregnant',8,4);
            $table->decimal('pc_fpl_adult',8,4);
            $table->decimal('pc_fpl_child_newborn',8,4);
            $table->decimal('pc_fpl_child_1_5',8,4);
            $table->decimal('pc_fpl_child_6_18',8,4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('state_medicaids');
    }
};
