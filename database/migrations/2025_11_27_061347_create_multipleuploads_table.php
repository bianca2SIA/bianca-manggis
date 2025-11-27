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
        Schema::create('multipleuploads', function (Blueprint $table) {
        $table->id();
        $table->string('filename', 250);
        $table->string('ref_table', 100);   // tambahan sesuai instruksi
        $table->integer('ref_id');          // tambahan sesuai instruksi
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('multipleuploads');
    }
};
