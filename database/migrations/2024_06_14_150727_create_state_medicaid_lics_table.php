<?php

use App\Models\StateMedicaid;
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
        if (Schema::hasTable('state_medicaids')) {
            Schema::enableForeignKeyConstraints();
            Schema::create('state_medicaid_lics', function (Blueprint $table) {
                $table->id();
                $table->boolean('chip');
                $table->integer('min_age');
                $table->integer('max_age');
                $table->decimal('pc_fpl',8,4);
                $table->foreignIdFor(StateMedicaid::class)->constrained(
                    table: 'state_medicaids', indexName: 'state_medicaid_lics_state_medicaid_id'
                );
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('state_medicaid_lics');
    }
};
