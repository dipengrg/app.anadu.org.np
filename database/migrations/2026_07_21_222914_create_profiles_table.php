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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('zodiac_id')
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->restrictOnDelete();

            $table->string('title')->nullable();
            $table->string('name');
            $table->enum('gender', ['male', 'female']);
            $table->date('dob')->nullable();
            $table->enum('marital_status', ['single', 'married'])->nullable();
            $table->string('photo')->nullable();
            $table->date('deceased_on')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
