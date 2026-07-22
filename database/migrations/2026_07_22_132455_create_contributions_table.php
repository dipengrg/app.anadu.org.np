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
        Schema::create('contributions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('profile_id')
                    ->nullable()
                    ->constrained('profiles')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreignId('contribution_category_id')
                    ->constrained('contribution_categories')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreignId('contribution_tier_id')
                    ->constrained('contribution_tiers')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->string('title');
            $table->text('description')->nullable();
            $table->date('received_on');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contributions');
    }
};
