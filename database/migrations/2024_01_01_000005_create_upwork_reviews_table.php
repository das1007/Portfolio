<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('upwork_reviews', function (Blueprint $table) {
            $table->id(); $table->string('reviewer')->nullable(); $table->string('project_type')->nullable();
            $table->text('review_text'); $table->integer('rating')->default(5);
            $table->boolean('is_active')->default(true); $table->integer('sort_order')->default(0); $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('upwork_reviews'); }
};
