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
        Schema::disableForeignKeyConstraints();

        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_time');
            $table->enum('type', ["sastanak","rociste"]);
            $table->string('location')->nullable();
            $table->text('note')->nullable();
            $table->foreignId('legal_case_id')->nullable()->constrained();
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
