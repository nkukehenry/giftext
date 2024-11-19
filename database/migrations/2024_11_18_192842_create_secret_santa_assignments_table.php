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
        Schema::create('secret_santa_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santa_id')->constrained('participants')->onDelete('cascade');
            $table->foreignId('recipient_id')->constrained('participants')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('secret_santa_assignments');
    }
};
