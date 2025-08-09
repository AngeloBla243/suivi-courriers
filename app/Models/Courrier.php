<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courrier extends Model
{
    use HasFactory;

    protected $fillable = [
        'num_reference',
        'annee_transmise',
        'mois_transmis',
        'jour_trans',
        'concerne',
        'destinataire',
        'nbre_annexe',
        'document_pdf',
        'num_enregistrement',
        'nom_expediteur',
        'annee_reception',
        'mois_reception',
        'date_reception',
        'observation',
        'mouvement',
    ];

    protected $casts = [
        'jour_trans' => 'date',
        'date_reception' => 'date',
    ];

    public function annexes()
    {
        return $this->hasMany(CourrierAnnexe::class);
    }
}
