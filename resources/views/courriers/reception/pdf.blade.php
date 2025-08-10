<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Liste des courriers réception</title>
    <style>
        @page {
            margin: 28pt 24pt 36pt 24pt;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #222;
            background: #fff;
        }

        .dgda-entete {
            display: flex;
            justify-content: center;
            /* Centre horizontalement toute la ligne */
            align-items: center;
            gap: 1.2em;
            margin-bottom: 1.2em;
            border-bottom: 4px solid #1f94d2;
            padding-bottom: 0.9em;
            text-align: center;
            /* Centre le texte de la colonne texte */
        }


        .logo {
            width: 82px;
            height: 82px;
            background: #eaf3fa;
            border-radius: 16px;
            border: 1.8px solid #1f94d2;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .entete-texts {
            flex: 1;
        }

        .dgda-title {
            font-size: 1.23em;
            font-weight: 700;
            color: #1f94d2;
            margin-bottom: .09em;
            margin-left: 3px;
        }

        .dgda-subtitle {
            font-size: 1.01em;
            font-weight: 700;
            color: #ffe243;
            text-shadow: 1.5px 1.5px 0 #144e6e;
            text-transform: uppercase;
        }

        .dgda-location {
            font-size: 0.99em;
            color: #333;
            font-weight: 500;
            margin-bottom: .15em;
        }

        .dgda-service {
            font-size: 1.07em;
            color: #1f94d2;
            font-weight: 600;
            margin-top: -.23em;
        }

        /* TABLEAU principal */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
            margin-bottom: 16px;
            border-radius: 12px;
            overflow: hidden;
            background: #fafcff;
        }

        th,
        td {
            border: 1px solid #e4eef7;
            padding: 8px 6px 7px 6px;
            text-align: left;
        }

        th {
            background: linear-gradient(90deg, #1f94d2 70%, #ffe243 100%);
            color: #173853;
            font-size: 1em;
            font-weight: 700;
            border-bottom: 2.6px solid #ffe243;
        }

        tr:nth-child(even) td {
            background-color: #eaf3fa;
        }

        tr:nth-child(odd) td {
            background-color: #fff;
        }

        /* Pour impression PDF */
        .pdf-footer {
            margin-top: 2.2em;
            font-size: 0.97em;
            color: #757575;
            text-align: right;
        }

        /* Responsive print */
        @media print {
            body {
                margin: 0;
            }

            .pdf-footer {
                position: fixed;
                bottom: .7em;
                left: 0;
                right: 0;
            }

            .dgda-entete,
            h2,
            table,
            .pdf-footer {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>
    <!-- ENTETE DGDA -->
    <div class="dgda-entete">
        <div>
            <img src="{{ public_path('img/OIP.jpg') }}" width="70" alt="Logo DGDA" />
        </div>
        <div class="entete-texts">
            <div class="dgda-title">RÉPUBLIQUE DÉMOCRATIQUE DU CONGO</div>
            <div class="dgda-subtitle">DIRECTION GÉNÉRALE DES DOUANES & ACCISES (DGDA)</div>
            <div class="dgda-location">SECRÉTARIAT – BEACH NGOBILA (KINSHASA/GOMBE)</div>
            <div class="dgda-service">Liste centralisée des courriers réception</div>
        </div>
    </div>

    <h2 style="color:#1f94d2;font-size:1.17em;margin-top:1.4em;margin-bottom:.8em;text-align:left;">Liste des courriers
        réception</h2>

    <table>
        <thead>
            <tr>
                <th>N° enregistrement</th>
                <th>Expéditeur</th>
                <th>Objet</th>
                <th>Destinataire</th>
                <th>Date réception</th>
                <th>Nombre annexes</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($courriers as $courrier)
                <tr>
                    <td>{{ $courrier->num_enregistrement }}</td>
                    <td>{{ $courrier->nom_expediteur }}</td>
                    <td>{{ $courrier->concerne }}</td>
                    <td>{{ $courrier->destinataire }}</td>
                    <td>
                        {{ $courrier->date_reception ? \Carbon\Carbon::parse($courrier->date_reception)->format('d/m/Y') : '-' }}
                    </td>
                    <td>{{ $courrier->nbre_annexe }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pdf-footer">
        <span>Kinshasa/Gombe – {{ date('d/m/Y') }} – Secrétariats de la DGDA</span>
    </div>
</body>

</html>
