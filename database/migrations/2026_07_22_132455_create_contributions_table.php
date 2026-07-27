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
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->restrictOnDelete();

            $table->foreignId('contribution_category_id')
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->restrictOnDelete();

            $table->foreignId('contribution_tier_id')
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->restrictOnDelete();

            $table->string('external_donor_name')->nullable();
            $table->decimal('amount', 12, 2);
            $table->text('summary')->nullable();
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
