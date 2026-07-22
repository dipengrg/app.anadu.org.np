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
        Schema::create('committee_members', function (Blueprint $table) {
            $table->id();
            // Relational foreign keys
            $table->foreignId('tenure_id')
                    ->constrained('tenures')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreignId('profile_id')
                    ->constrained('profiles')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->string('designation');
            $table->unsignedInteger('rank');
            
            $table->timestamps();

            // Ensure a member cannot have the same designation in the same tenure
            $table->unique(['tenure_id', 'profile_id', 'designation']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('committee_members');
    }
};
