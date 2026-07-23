<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('risks', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Ex: RSK-000001
            
            // Relacionamentos
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('owner_id')->constrained('users'); // Responsável pelo risco
            
            // Inventário
            $table->string('process');
            $table->text('objective')->nullable();
            $table->text('description');
            $table->text('cause');
            $table->text('consequence');
            $table->string('origin');
            $table->enum('status', ['Identificado', 'Em Avaliação', 'Mitigado', 'Aceite', 'Fechado'])->default('Identificado');
            
            // Avaliação Inerente
            $table->integer('inherent_probability')->nullable(); // 1 a 5
            $table->integer('inherent_impact')->nullable(); // 1 a 5
            
            // Controles
            $table->text('existing_controls')->nullable();
            $table->enum('control_effectiveness', ['Inexistente', 'Fraco', 'Adequado', 'Forte'])->nullable();
            
            // Avaliação Residual
            $table->integer('residual_probability')->nullable();
            $table->integer('residual_impact')->nullable();
            $table->boolean('risk_acceptance')->default(false);
            
            // Datas de controle
            $table->date('assessment_date')->nullable();
            $table->date('next_review_date')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('risks');
    }
};
