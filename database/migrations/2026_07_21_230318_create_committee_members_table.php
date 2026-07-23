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

            $table->foreignId('profile_id')
                    ->constrained('profiles')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->unsignedInteger('rank');
            $table->string('designation');
            $table->enum('role', ['executive', 'general']);
            $table->date('started_on');
            $table->date('ended_on')->nullable();

            $table->timestamps();
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
