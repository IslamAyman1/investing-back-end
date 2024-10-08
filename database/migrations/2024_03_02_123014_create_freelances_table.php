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
        Schema::create('freelances', function (Blueprint $table) {
            $table->id();
            $table->text('freelanceName');
            $table->integer('freelanceBudget');
            $table->date('freelanceTime');
            $table->text('skills');
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freelances');
    }
};
