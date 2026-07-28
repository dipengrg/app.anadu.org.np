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
        Schema::create('members', function (Blueprint $table) {
            $table->id();

            $table->foreignId('profile_id')
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->restrictOnDelete();

            $table->foreignId('clan_id')
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->restrictOnDelete();

            $table->string('mid')->unique();
            $table->string('phone')->nullable();
            $table->unsignedTinyInteger('rank');
            $table->string('designation');
            $table->enum('role', ['executive', 'general']);
            $table->enum('ancestral_address', ['kodi', 'manikharka', 'mulbari', 'saudara', 'andara']);
            $table->enum('residence_type', ['local', 'city', 'abroad']);
            $table->date('started_on');
            $table->date('ended_on')->nullable();
            $table->string('end_reason')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
