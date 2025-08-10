@php
    $mois = [
        'janvier',
        'février',
        'mars',
        'avril',
        'mai',
        'juin',
        'juillet',
        'août',
        'septembre',
        'octobre',
        'novembre',
        'décembre',
    ];
@endphp

<style>
    :root {
        --main-blue: #1f94d2;
        --main-yellow: #ffe243;
    }

    .form-label {
        color: var(--main-blue);
        font-weight: 600;
    }

    .form-control,
    .form-select {
        border-radius: 0.7em;
        border: 1.7px solid #e4eef7;
        font-size: 1.05em;
        box-shadow: none;
    }

    .form-control:focus,
    .form-select:focus,
    textarea.form-control:focus {
        border-color: var(--main-blue);
        box-shadow: 0 2px 8px rgba(31, 148, 210, 0.08);
    }

    .btn-primary {
        background: linear-gradient(90deg, var(--main-yellow) 14%, var(--main-blue) 92%);
        color: #113847;
        border-radius: 25px;
        font-weight: 700;
        padding: 0.63em 2.1em;
        border: none;
        margin-right: .6em;
    }

    .btn-primary:hover {
        background: linear-gradient(90deg, #ffe243 10%, #1175b3 98%);
        color: #fff;
    }

    .btn-secondary {
        border-radius: 25px;
        font-weight: 600;
        background: #eaeaea;
        color: var(--main-blue);
    }

    .form-control-file {
        border-radius: 10px;
        border: 1.2px solid #e8f5fc;
        margin-top: .2em;
        margin-bottom: .11em;
        padding: 0.49em 0.7em;
    }

    .file-label {
        color: #444;
        font-weight: 500;
        margin-bottom: .18em;
        display: inline-block;
    }

    .file-checkmark {
        font-size: 1.12em;
        color: #2cb36a;
        font-weight: bold;
        margin-left: .4em;
        display: none;
    }

    @media (max-width:768px) {

        .form-label,
        .file-label {
            font-size: 0.96em;
        }

        .btn-primary,
        .btn-secondary {
            font-size: 0.97em;
        }
    }

    #documents_container>div {
        margin-bottom: .38em;
    }
</style>

<div class="row g-3">
    <!-- Numéro de référence -->
    <div class="form-group col-md-4">
        <label for="num_reference" class="form-label">Numéro de référence <span class="text-danger">*</span></label>
        <input type="text" name="num_reference" id="num_reference" class="form-control"
            value="{{ old('num_reference', $courrier->num_reference ?? '') }}" required>
    </div>
    <!-- Numéro enregistrement -->
    <div class="form-group col-md-4">
        <label for="num_enregistrement" class="form-label">Numéro d'enregistrement <span
                class="text-danger">*</span></label>
        <input type="text" name="num_enregistrement" id="num_enregistrement" class="form-control"
            value="{{ old('num_enregistrement', $courrier->num_enregistrement ?? '') }}" required>
    </div>
    <!-- Nom expéditeur -->
    <div class="form-group col-md-4">
        <label for="nom_expediteur" class="form-label">Nom expéditeur <span class="text-danger">*</span></label>
        <input type="text" name="nom_expediteur" id="nom_expediteur" class="form-control"
            value="{{ old('nom_expediteur', $courrier->nom_expediteur ?? '') }}" required>
    </div>
    <!-- Année réception -->
    <div class="form-group col-md-2">
        <label for="annee_reception" class="form-label">Année réception <span class="text-danger">*</span></label>
        <input type="number" name="annee_reception" id="annee_reception" class="form-control"
            value="{{ old('annee_reception', $courrier->annee_reception ?? '') }}" min="2000"
            max="{{ date('Y') }}" required>
    </div>
    <!-- Mois réception -->
    <div class="form-group col-md-2">
        <label for="mois_reception" class="form-label">Mois réception <span class="text-danger">*</span></label>
        <select name="mois_reception" id="mois_reception" class="form-select" required>
            <option value="">-- Choisir --</option>
            @foreach ($mois as $m)
                <option value="{{ $m }}"
                    {{ old('mois_reception', $courrier->mois_reception ?? '') === $m ? 'selected' : '' }}>
                    {{ ucfirst($m) }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="row g-3">
    <!-- Date réception -->
    <div class="form-group col-md-4">
        <label for="date_reception" class="form-label">Date réception <span class="text-danger">*</span></label>
        <input type="date" name="date_reception" id="date_reception" class="form-control"
            value="{{ old('date_reception', isset($courrier->date_reception) ? \Carbon\Carbon::parse($courrier->date_reception)->format('Y-m-d') : '') }}"
            required>
    </div>
    <!-- Objet -->
    <div class="form-group col-md-8">
        <label for="concerne" class="form-label">Objet <span class="text-danger">*</span></label>
        <input type="text" name="concerne" id="concerne" class="form-control"
            value="{{ old('concerne', $courrier->concerne ?? '') }}" required>
    </div>
</div>

<div class="row g-3">
    <!-- Destinataire -->
    <div class="form-group col-md-6">
        <label for="destinataire" class="form-label">Destinataire <span class="text-danger">*</span></label>
        <input type="text" name="destinataire" id="destinataire" class="form-control"
            value="{{ old('destinataire', $courrier->destinataire ?? '') }}" required>
    </div>
    <!-- Nombre annexes -->
    <div class="form-group col-md-3">
        <label for="nbre_annexe" class="form-label">Nombre d'annexes <span class="text-danger">*</span></label>
        <input type="number" name="nbre_annexe" id="nbre_annexe" class="form-control"
            value="{{ old('nbre_annexe', $courrier->nbre_annexe ?? 0) }}" min="0" required>
    </div>
    <!-- Conteneur dynamique annexes PDF -->
    <div class="form-group col-md-9" id="documents_container"></div>
</div>

<div class="form-group">
    <label for="observation" class="form-label">Observation</label>
    <textarea name="observation" id="observation" rows="2" class="form-control">{{ old('observation', $courrier->observation ?? '') }}</textarea>
</div>

<div class="mt-4 mb-3">
    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>{{ $submit_text }}</button>
    <a href="{{ url()->previous() }}" class="btn btn-secondary">Annuler</a>
</div>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const annexesInput = document.getElementById('nbre_annexe');
            const documentsContainer = document.getElementById('documents_container');

            function generateFileInputs() {
                documentsContainer.innerHTML = '';
                let nb = parseInt(annexesInput.value);
                if (isNaN(nb) || nb <= 0) return;

                for (let i = 1; i <= nb; i++) {
                    let wrapper = document.createElement('div');
                    wrapper.classList.add('mb-2');
                    // Label
                    let label = document.createElement('label');
                    label.textContent = `Document PDF scanné ${i}`;
                    label.classList.add('file-label');
                    label.setAttribute('for', `document_pdf_${i}`);
                    wrapper.appendChild(label);

                    // Input
                    let input = document.createElement('input');
                    input.type = 'file';
                    input.name = `document_pdf_${i}`;
                    input.id = `document_pdf_${i}`;
                    input.accept = 'application/pdf';
                    input.classList.add('form-control-file');
                    input.required = true;

                    // Check ✔ vert
                    let check = document.createElement('span');
                    check.innerHTML = '✔';
                    check.classList.add('file-checkmark');
                    input.addEventListener('change', function() {
                        check.style.display = input.files.length > 0 ? 'inline' : 'none';
                    });

                    wrapper.appendChild(input);
                    wrapper.appendChild(check);

                    documentsContainer.appendChild(wrapper);
                }
            }

            annexesInput.addEventListener('input', generateFileInputs);
            generateFileInputs(); // init au chargement
        });
    </script>
@endpush
