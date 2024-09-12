<?php

use App\Constants\DoctorConstants;
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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('specialization_id');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('password');
            $table->string('phone');
            $table->string('gender');
            $table->string('age');
            $table->string('blood_group');
            $table->string('experience');
            $table->string('image')->nullable();
            $table->tinyInteger('status')->default(DoctorConstants::STATUS_INACTIVE);
            $table->tinyInteger('type')->default(DoctorConstants::TYPE_ONE);
            $table->boolean('is_featured');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
