<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courrier;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CourrierController extends Controller
{
    // ====== EXPEDITION ====== //
    public function expeditionIndex(Request $request)
    {
        $query = Courrier::where('mouvement', 'expedition');
        $this->applyFilters($query, $request);

        $courriers = $query->orderByDesc('created_at')->paginate(10);
        return view('courriers.expedition.index', compact('courriers'));
    }

    public function expeditionCreate()
    {
        return view('courriers.expedition.create');
    }


    public function expeditionStore(Request $request)
    {
        $validated = $this->validateExpedition($request);

        // Forcer un mouvement correct
        $validated['mouvement'] = 'expedition';

        // Création du courrier principal
        $courrier = Courrier::create($validated);

        // Enregistrement des annexes PDF
        for ($i = 1; $i <= $request->input('nbre_annexe', 0); $i++) {
            if ($request->hasFile("document_pdf_$i")) {
                $filePath = $request->file("document_pdf_$i")->store('courriers', 'public');

                $courrier->annexes()->create([
                    'filename' => $filePath,
                    'label'    => "Annexe PDF {$i}",
                ]);
            }
        }

        return redirect()->route('courriers.expedition.index')
            ->with('success', "Courrier d'expédition enregistré avec annexes.");
    }


    public function expeditionShow(Courrier $courrier)
    {
        abort_unless($courrier->mouvement === 'expedition', 404);
        return view('courriers.expedition.show', compact('courrier'));
    }

    public function expeditionEdit(Courrier $courrier)
    {
        abort_unless($courrier->mouvement === 'expedition', 404);
        return view('courriers.expedition.edit', compact('courrier'));
    }



    public function expeditionUpdate(Request $request, Courrier $courrier)
    {
        abort_unless($courrier->mouvement === 'expedition', 404);

        $validated = $request->validate([
            'num_reference' => 'required|string|unique:courriers,num_reference,' . $courrier->id,
            'annee_transmise' => 'required|digits:4',
            'mois_transmis' => 'required|string',
            'jour_trans' => 'required|date',
            'concerne' => 'required|string',
            'destinataire' => 'required|string',
            'nbre_annexe' => 'required|integer|min:0',
        ]);

        $validated['mouvement'] = 'expedition';

        // Mettre à jour le courrier principal
        $courrier->update($validated);

        // Supprimer les anciennes annexes et fichiers associés
        foreach ($courrier->annexes as $annexe) {
            Storage::disk('public')->delete($annexe->filename);
            $annexe->delete();
        }

        // Re-créer les annexes à partir des fichiers uploadés
        for ($i = 1; $i <= $request->input('nbre_annexe', 0); $i++) {
            if ($request->hasFile("document_pdf_$i")) {
                $filePath = $request->file("document_pdf_$i")->store('courriers', 'public');

                $courrier->annexes()->create([
                    'filename' => $filePath,
                    'label'    => "Annexe PDF {$i}",
                ]);
            }
        }

        return redirect()->route('courriers.expedition.index')
            ->with('success', "Courrier d'expédition mis à jour avec annexes.");
    }


    public function expeditionDestroy(Courrier $courrier)
    {
        abort_unless($courrier->mouvement === 'expedition', 404);

        if ($courrier->document_pdf) {
            Storage::disk('public')->delete($courrier->document_pdf);
        }
        $courrier->delete();

        return redirect()->route('courriers.expedition.index')
            ->with('success', "Courrier d'expédition supprimé.");
    }

    public function expeditionPrint(Courrier $courrier)
    {
        abort_unless($courrier->mouvement === 'expedition', 404);
        $courrier->load('annexes');
        return view('courriers.expedition.print', compact('courrier'));
    }

    // ====== RECEPTION ====== //
    public function receptionIndex(Request $request)
    {
        $query = Courrier::where('mouvement', 'reception');
        $this->applyFilters($query, $request);

        $courriers = $query->orderByDesc('created_at')->paginate(10);
        return view('courriers.reception.index', compact('courriers'));
    }

    public function receptionCreate()
    {
        return view('courriers.reception.create');
    }


    public function receptionStore(Request $request)
    {
        $validated = $this->validateReception($request);

        $validated['mouvement'] = 'reception';
        $validated['annee_transmise'] = $validated['annee_reception'] ?? date('Y');
        $validated['mois_transmis'] = $validated['mois_reception'] ?? 'inconnu';
        $validated['jour_trans'] = $validated['date_reception'] ?? now()->toDateString();
        $validated['num_reference'] = $validated['num_reference'] ?? 'REC-REF-' . strtoupper(uniqid());

        // On crée d'abord le courrier principal (sans document_pdf)
        $courrier = Courrier::create($validated);

        // Supposons qu'on ait un modèle CourrierAnnexe avec fillable ['courrier_id', 'filename', 'label']
        for ($i = 1; $i <= $request->input('nbre_annexe', 0); $i++) {
            if ($request->hasFile("document_pdf_$i")) {
                $filePath = $request->file("document_pdf_$i")->store('courriers', 'public');

                // création de l'annexe liée
                $courrier->annexes()->create([
                    'filename' => $filePath,
                    'label'    => "Annexe PDF {$i}",
                ]);
            }
        }

        return redirect()->route('courriers.reception.index')
            ->with('success', "Courrier reçu enregistré avec annexes.");
    }


    public function receptionShow(Courrier $courrier)
    {
        abort_unless($courrier->mouvement === 'reception', 404);
        return view('courriers.reception.show', compact('courrier'));
    }

    public function receptionEdit(Courrier $courrier)
    {
        abort_unless($courrier->mouvement === 'reception', 404);
        return view('courriers.reception.edit', compact('courrier'));
    }


    public function receptionUpdate(Request $request, Courrier $courrier)
    {
        abort_unless($courrier->mouvement === 'reception', 404);

        $validated = $request->validate([
            'num_reference' => 'required|string|unique:courriers,num_reference,' . $courrier->id,
            'num_enregistrement' => 'required|string|unique:courriers,num_enregistrement,' . $courrier->id,
            'nom_expediteur' => 'required|string',
            'annee_reception' => 'required|digits:4',
            'mois_reception' => 'required|string',
            'date_reception' => 'required|date',
            'concerne' => 'required|string',
            'destinataire' => 'required|string',
            'nbre_annexe' => 'required|integer|min:0',
            'observation' => 'nullable|string',
        ]);

        $validated['mouvement'] = 'reception';
        $validated['annee_transmise'] = $validated['annee_reception'] ?? date('Y');
        $validated['mois_transmis'] = $validated['mois_reception'] ?? 'inconnu';
        $validated['jour_trans'] = $validated['date_reception'] ?? now()->toDateString();

        $courrier->update($validated);

        // Suppression des annexes existantes et fichiers physiques
        foreach ($courrier->annexes as $annexe) {
            Storage::disk('public')->delete($annexe->filename);
            $annexe->delete();
        }

        // Re-création des annexes
        for ($i = 1; $i <= $request->input('nbre_annexe', 0); $i++) {
            if ($request->hasFile("document_pdf_$i")) {
                $filePath = $request->file("document_pdf_$i")->store('courriers', 'public');
                $courrier->annexes()->create([
                    'filename' => $filePath,
                    'label'    => "Annexe PDF {$i}",
                ]);
            }
        }

        return redirect()->route('courriers.reception.index')
            ->with('success', "Courrier reçu mis à jour avec annexes.");
    }


    public function receptionDestroy(Courrier $courrier)
    {
        abort_unless($courrier->mouvement === 'reception', 404);

        if ($courrier->document_pdf) {
            Storage::disk('public')->delete($courrier->document_pdf);
        }
        $courrier->delete();

        return redirect()->route('courriers.reception.index')
            ->with('success', "Courrier reçu supprimé.");
    }

    public function receptionPrint(Courrier $courrier)
    {
        abort_unless($courrier->mouvement === 'reception', 404);
        $courrier->load('annexes');
        return view('courriers.reception.print', compact('courrier'));
    }

    // ====== Méthodes utilitaires ======
    protected function applyFilters($query, Request $request)
    {
        if ($request->filled('num_enregistrement')) {
            $query->where('num_enregistrement', $request->num_enregistrement);
        }
        if ($request->filled('annee')) {
            $query->where(function ($q) use ($request) {
                $q->where('annee_transmise', $request->annee)
                    ->orWhere('annee_reception', $request->annee);
            });
        }
        if ($request->filled('mois')) {
            $query->where(function ($q) use ($request) {
                $q->where('mois_transmis', $request->mois)
                    ->orWhere('mois_reception', $request->mois);
            });
        }
        if ($request->filled('expediteur')) {
            $query->where('nom_expediteur', 'like', '%' . $request->expediteur . '%');
        }
        if ($request->filled('destinataire')) {
            $query->where('destinataire', 'like', '%' . $request->destinataire . '%');
        }
    }

    protected function validateExpedition(Request $request)
    {
        // Validation dynamique multi-PDF
        $rules = [
            'num_reference' => 'required|string|unique:courriers,num_reference',
            'annee_transmise' => 'required|digits:4',
            'mois_transmis' => 'required|string',
            'jour_trans' => 'required|date',
            'concerne' => 'required|string',
            'destinataire' => 'required|string',
            'nbre_annexe' => 'required|integer|min:0',
        ];
        for ($i = 1; $i <= $request->input('nbre_annexe', 0); $i++) {
            $rules["document_pdf_$i"] = 'nullable|file|mimes:pdf|max:4096';
        }
        return $request->validate($rules);
    }

    protected function validateReception(Request $request)
    {
        $rules = [
            'num_reference' => 'nullable|string|unique:courriers,num_reference',
            'num_enregistrement' => 'required|string|unique:courriers,num_enregistrement',
            'nom_expediteur' => 'required|string',
            'annee_reception' => 'required|digits:4',
            'mois_reception' => 'required|string',
            'date_reception' => 'required|date',
            'concerne' => 'required|string',
            'destinataire' => 'required|string',
            'nbre_annexe' => 'required|integer|min:0',
            'observation' => 'nullable|string',
        ];
        for ($i = 1; $i <= $request->input('nbre_annexe', 0); $i++) {
            $rules["document_pdf_$i"] = 'nullable|file|mimes:pdf|max:4096';
        }
        return $request->validate($rules);
    }
}
