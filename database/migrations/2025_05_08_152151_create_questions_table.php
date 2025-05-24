<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->constrained()->onDelete('cascade');
            $table->string('text');
            $table->enum('type', ['abc', 'binary', 'truefalse']);
            $table->unsignedInteger('read_time');
            $table->unsignedInteger('answer_time');
            $table->text('explanation')->nullable(); // wyjaśnienie do pytania
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
