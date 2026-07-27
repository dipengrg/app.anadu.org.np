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
        Schema::create('family_trees', function (Blueprint $table) {
            $table->id();

            $table->boolean('is_root')->default(false);

            $table->foreignId('profile_id')
                    ->unique()
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->restrictOnDelete();
            
            $table->foreignId('father_id')
                    ->nullable()
                    ->constrained('profiles')
                    ->cascadeOnUpdate()
                    ->onDelete('set null');

            $table->foreignId('mother_id')
                    ->nullable()
                    ->constrained('profiles')
                    ->cascadeOnUpdate()
                    ->onDelete('set null');

            $table->foreignId('spouse_id')
                    ->nullable()
                    ->constrained('profiles')
                    ->cascadeOnUpdate()
                    ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_trees');
    }
};
