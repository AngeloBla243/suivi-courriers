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
        Schema::create('courriers', function (Blueprint $table) {
            $table->id(); // id auto-increment
            $table->string('num_reference')->unique();  // NumReference (ex: unique)
            $table->year('annee_transmise');            // AnnéeTransmise
            $table->string('mois_transmis');            // Mois transmis (ex: janvier, 01, etc)
            $table->date('jour_trans');                  // Jour trans (date complète)
            $table->string('concerne');                  // Objet (concerne)
            $table->string('destinataire');              // Destinataire
            $table->unsignedInteger('nbre_annexe')->default(0); // Nombre annexe
            $table->string('document_pdf')->nullable();  // Document PDF scanné (chemin stockage)

            // Données réception (enregistrement à la réception)
            $table->string('num_enregistrement')->nullable();
            $table->string('nom_expediteur')->nullable();
            $table->year('annee_reception')->nullable();  // année réception (séparée)
            $table->string('mois_reception')->nullable(); // mois réception
            $table->date('date_reception')->nullable();   // date réception complète
            $table->text('observation')->nullable();

            // Type de mouvement : 'expedition' ou 'reception'
            $table->enum('mouvement', ['expedition', 'reception'])->default('expedition');

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courriers');
    }
};
