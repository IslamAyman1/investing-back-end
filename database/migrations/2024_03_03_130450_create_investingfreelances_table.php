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
        Schema::create('investingfreelances', function (Blueprint $table) {
            $table->id();
            $table->text('projectTitle');
            $table->text('description'); 
            $table->integer('projectBalance')->default(0);
            $table->tinyInteger('investorNumber')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investingfreelances');
    }
};
