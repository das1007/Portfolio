<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id(); $table->string('name'); $table->string('email');
            $table->string('phone')->nullable(); $table->string('subject');
            $table->string('type')->default('general'); $table->string('budget')->nullable();
            $table->string('timeline')->nullable(); $table->text('message');
            $table->string('status')->default('new'); $table->text('admin_notes')->nullable(); $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('contacts'); }
};
