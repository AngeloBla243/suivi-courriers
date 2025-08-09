<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('courrier_annexes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('courrier_id')->constrained()->onDelete('cascade');
            $table->string('filename')->nullable(false); // nom/path du fichier, ex: courriers/xxxx.pdf
            $table->string('label')->nullable(); // libellé si besoin (Document 1, ...)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('courrier_annexes');
    }
};
