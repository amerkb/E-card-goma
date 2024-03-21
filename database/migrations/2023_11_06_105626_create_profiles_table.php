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
        Schema::create('profiles', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('theme_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('firstName');
            $table->string('lastName');
            $table->string('email')->nullable();
            $table->string('phoneNum')->nullable();
            $table->text('about')->nullable();
            $table->text('location')->nullable();
            $table->string('cover')->nullable();
            $table->string('photo')->nullable();
            $table->string('bgColor')->nullable();
            $table->timestamps();
            $table->primary(['user_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
