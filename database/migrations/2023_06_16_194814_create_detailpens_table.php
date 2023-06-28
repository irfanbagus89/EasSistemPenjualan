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
        Schema::create('detailpens', function (Blueprint $table) {
            $table->increments('id_detail');
            $table->unsignedInteger('id_pen');
            $table->unsignedInteger('id_obat');
            $table->integer('qty')->nullable();

            $table->foreign('id_pen')->references('id_pen')->on('penjualans')->onDelete('cascade');
            $table->foreign('id_obat')->references('id_obat')->on('obats')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detailpens');
    }
};
