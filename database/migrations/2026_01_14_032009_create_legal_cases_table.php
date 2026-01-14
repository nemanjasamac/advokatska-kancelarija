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

        Schema::create('legal_cases', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('case_type');
            $table->string('court')->nullable();
            $table->string('opponent')->nullable();
            $table->enum('status', ['novi', 'otvoren', 'u_toku', 'na_cekanju', 'zatvoren']);
            $table->date('opened_at');
            $table->date('closed_at')->nullable();
            $table->foreignId('client_id')->constrained();
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
        Schema::dropIfExists('legal_cases');
    }
};
