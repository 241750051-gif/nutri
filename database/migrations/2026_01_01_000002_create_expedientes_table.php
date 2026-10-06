<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('expedientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('edad')->nullable();
            $table->decimal('estatura_cm', 5, 2)->nullable();
            $table->decimal('peso_kg', 5, 2)->nullable();
            $table->text('alergias')->nullable();
            $table->text('antecedentes')->nullable();
            $table->text('diagnostico')->nullable();
            $table->text('plan_alimenticio')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expedientes');
    }
};