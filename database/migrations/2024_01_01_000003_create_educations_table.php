<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('educations', function (Blueprint $table) {
            $table->id(); $table->string('degree'); $table->string('institution');
            $table->string('location')->nullable(); $table->string('period_start');
            $table->string('period_end')->nullable(); $table->string('emoji')->default('🎓');
            $table->json('badges')->nullable(); $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0); $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('educations'); }
};
