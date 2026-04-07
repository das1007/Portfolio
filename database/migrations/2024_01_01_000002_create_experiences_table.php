<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('experiences', function (Blueprint $table) {
            $table->id(); $table->string('role'); $table->string('company');
            $table->string('location')->nullable(); $table->string('period_start');
            $table->string('period_end')->default('Present'); $table->text('description')->nullable();
            $table->json('bullets')->nullable(); $table->json('tags')->nullable();
            $table->boolean('is_active')->default(true); $table->integer('sort_order')->default(0); $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('experiences'); }
};
