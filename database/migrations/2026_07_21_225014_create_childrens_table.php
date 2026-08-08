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
        Schema::create('childrens', function (Blueprint $table) {
            $table->id();

            $table->foreignId('marriage_id')
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->restrictOnDelete();
            
            $table->foreignId('child_id')
                    ->constrained('profiles')
                    ->cascadeOnUpdate()
                    ->restrictOnDelete();
            
            $table->unsignedInteger('birth_order');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('childrens');
    }
};
