<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('action_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('risk_id')->constrained()->cascadeOnDelete();
            $table->foreignId('who_id')->constrained('users');
            
            $table->string('what');
            $table->text('why');
            $table->string('where');
            $table->date('when_date');
            $table->text('how');
            $table->decimal('how_much', 10, 2)->nullable();
            
            $table->string('status')->default('Não Iniciado');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('action_plans');
    }
};
