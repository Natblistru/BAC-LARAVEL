<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\SubjectStudyLevel;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->string("name",200);
            $table->unsignedSmallInteger('year');
            $table->unsignedBigInteger("subject_study_level_id");
            $table->tinyInteger("status")->default(0);
            $table->enum('type', ['Pretestare', 'Testare de baza', 'Evaluare suplimentara', 'Teste pentru exersare1', 'Teste pentru exersare2']);
            $table->timestamps();
    
            $table->foreign("subject_study_level_id")->references("id")->on("subject_study_levels");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
