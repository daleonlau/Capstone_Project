<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->string('student_id'); // primary key
            $table->unsignedBigInteger('user_id');   // organization ID
            $table->string('firstname');
            $table->string('lastname');
            $table->enum('yearlevel', ['firstyear','secondyear','thirdyear','fourthyear']);
            $table->string('course');
            $table->string('department')->nullable();
            $table->timestamps();

            $table->primary(['student_id', 'user_id']); // composite primary
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
