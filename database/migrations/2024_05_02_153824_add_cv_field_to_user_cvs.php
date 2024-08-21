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
        Schema::table('user_cvs', function (Blueprint $table) {
            $table->text('phone')->default('0');
            $table->text('address')->default(null);
            $table->text('email')->default(null);
            $table->text('linkedIn')->default(null);
            $table->date('Birthday')->default(null);
            $table->text('Nationality')->default(null);
            $table->text('marital_Status')->default(null);
            $table->text('military_Service')->default(null);
            $table->text('career_objective')->default(null);
            $table->text('projects')->default(null);
     }
            );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_cvs', function (Blueprint $table) {
            //
        });
    }
};
