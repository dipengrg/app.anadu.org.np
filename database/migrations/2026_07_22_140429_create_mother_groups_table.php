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
        Schema::create('mother_groups', function (Blueprint $table) {
            $table->id();

            $table->foreignId('profile_id')
                    ->unique()
                    ->constrained('profiles')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->string('designation');
            $table->unsignedInteger('rank');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mother_groups');
    }
};
