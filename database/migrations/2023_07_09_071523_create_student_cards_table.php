<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_cards', function (Blueprint $table) {
            $table->id();

            $table->string('school')->default(\App\Enums\SchoolEnum::SCHOOL_1->value);
            $table->text('description')->nullable();

            $table->boolean('is_internal')->default(false);

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->date('date_of_birth');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_cards');
    }
};
