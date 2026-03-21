<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shoes', function (Blueprint $table) {
            $table->id();
            $table->string('shoe_name');
            $table->string('brand')->index();
            $table->json('color');
            $table->decimal('price', 10, 2)->index();
            $table->json('image_url');
            $table->string('category')->nullable()->index();
            $table->string('gender')->nullable()->index();
            $table->boolean('is_deleted')->default(false);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shoes');
    }
};
