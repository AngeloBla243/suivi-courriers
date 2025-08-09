<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Courrier;

class CourrierSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            Courrier::create([
                'num_reference'      => 'REF-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'annee_transmise'    => date('Y'),
                'mois_transmis'      => 'juillet',
                'jour_trans'         => now()->subDays($i),
                'concerne'           => 'Objet test courrier ' . $i,
                'destinataire'       => 'Destinataire ' . $i,
                'nbre_annexe'        => rand(0, 5),
                'document_pdf'       => null, // ou un faux chemin si besoin
                'num_enregistrement' => 'NREG-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'nom_expediteur'     => 'Expéditeur ' . $i,
                'annee_reception'    => date('Y'),
                'mois_reception'     => 'juillet',
                'date_reception'     => now()->subDays($i),
                'observation'        => $i % 2 ? 'RAS' : null,
                'mouvement'          => $i % 2 ? 'expedition' : 'reception',
            ]);
        }
    }
}
