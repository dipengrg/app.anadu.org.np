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
        Schema::create('event_session_participations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_session_id')
                    ->constrained('event_sessions')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->foreignId('profile_id')
                    ->constrained('profiles')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->foreignId('participation_tier_id')
                    ->constrained('participation_tiers')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            $table->decimal('hours_contributed', 4, 2)->default(1.00);
            $table->unsignedInteger('calculated_points');
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_session_participations');
    }
};
