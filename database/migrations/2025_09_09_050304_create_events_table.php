<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // organization who owns this event
            $table->string('event_name');
            $table->date('event_date');
            $table->decimal('event_fee', 8, 2)->default(0.00);

            $table->enum('year_level', [
                'firstyear',
                'secondyear',
                'thirdyear',
                'fourthyear'
            ])->nullable();

            $table->enum('course', [
                'Bachelor of Science in Information Technology',
                'Bachelor of Science in Computer Science',
                'Bachelor of Science in Information Systems'
            ])->nullable();

            $table->string('department')->nullable();

            // Include Finished status now
            $table->enum('status', ['Pending', 'Approved', 'Finished'])->default('Pending');

            $table->timestamps();

            // foreign key (points to users table)
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
