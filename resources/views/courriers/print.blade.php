<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Impression Courrier Réception - {{ $courrier->num_enregistrement }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 2rem;
        }

        h1,
        h3 {
            margin-bottom: 0.5rem;
        }

        .field-label {
            font-weight: bold;
        }

        @media print {
            .btn-print {
                display: none;
            }
        }

        .btn-print {
            margin-top: 20px;
            padding: 0.5rem 1rem;
            font-size: 1rem;
            background: #1976d2;
            color: #fff;
            border: 0;
            border-radius: 3px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <h1>Courrier réception</h1>
    <h3>N° enregistrement : {{ $courrier->num_enregistrement }}</h3>
    <p><span class="field-label">Expéditeur :</span> {{ $courrier->nom_expediteur }}</p>
    <p><span class="field-label">Année réception :</span> {{ $courrier->annee_reception }}</p>
    <p><span class="field-label">Mois réception :</span> {{ $courrier->mois_reception }}</p>
    <p><span class="field-label">Date réception :</span>
        {{ $courrier->date_reception ? \Carbon\Carbon::parse($courrier->date_reception)->format('d/m/Y') : '-' }}</p>
    <p><span class="field-label">Objet :</span> {{ $courrier->concerne }}</p>
    <p><span class="field-label">Destinataire :</span> {{ $courrier->destinataire }}</p>
    <p><span class="field-label">Nombre annexes :</span> {{ $courrier->nbre_annexe }}</p>
    <p><span class="field-label">Observation :</span> {{ $courrier->observation }}</p>
    @if ($courrier->document_pdf)
        <p><span class="field-label">Document PDF :</span>
            <a href="{{ asset('storage/' . $courrier->document_pdf) }}" target="_blank">Télécharger</a>
        </p>
    @endif
    <button class="btn-print" onclick="window.print()">Imprimer cette page</button>
</body>

</html>
