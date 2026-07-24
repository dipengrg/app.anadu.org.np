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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();

            $table->foreignId('content_category_id')
                    ->constrained('content_categories')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->string('title');
            $table->string('summary', 500)->nullable();
            $table->longText('body');
            $table->string('header_image_path')->nullable();
            $table->boolean('is_pinned')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
