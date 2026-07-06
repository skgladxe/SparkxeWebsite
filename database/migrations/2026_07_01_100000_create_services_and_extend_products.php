<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->longText('notes')->nullable();
            $table->string('image')->nullable();
            $table->string('header_image')->nullable();
            $table->string('icon')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('id');
            $table->string('subtitle')->nullable()->after('title');
            $table->string('icon')->nullable()->after('image');
            $table->string('header_image')->nullable()->after('icon');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['slug', 'subtitle', 'icon', 'header_image']);
        });

        Schema::dropIfExists('services');
    }
};
