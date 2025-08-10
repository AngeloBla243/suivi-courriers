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
        border-radius: 0.69em;
        border: 1.7px solid #e4eef7;
        box-shadow: none;
        font-size: 1.05em;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--main-blue);
        box-shadow: 0 2px 8px rgba(31, 148, 210, 0.08);
    }

    .btn-primary {
        background: linear-gradient(90deg, var(--main-yellow) 14%, var(--main-blue) 100%);
        color: #173853;
        border-radius: 25px;
        font-weight: 700;
        padding: 0.62em 2.1em;
        font-size: 1.07em;
        border: none;
        margin-right: .5em;
    }

    .btn-primary:hover {
        background: linear-gradient(90deg, #ffe243 6%, #1375a6 100%);
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
    }

    .file-checkmark {
        font-size: 1.15em;
        color: #2cb36a;
        font-weight: bold;
        margin-left: .4em;
        display: none;
    }

    .file-label {
        color: #444;
        font-weight: 500;
        margin-bottom: .19em;
        display: inline-block;
    }

    @media (max-width:700px) {

        .form-label,
        .file-label {
            font-size: 0.97em;
        }

        .btn-primary,
        .btn-secondary {
            font-size: 0.98em;
        }
    }

    /* Ajuste annexe sur mobile */
    #documents_container>div {
        margin-bottom: .45em;
    }
</style>

<div class="row g-3">
    {{-- Numéro de référence --}}
    <div class="form-group col-md-4">
        <label for="num_reference" class="form-label">Numéro de référence <span class="text-danger">*</span></label>
        <input type="text" name="num_reference" id="num_reference" class="form-control"
            value="{{ old('num_reference', $courrier->num_reference ?? '') }}" required>
    </div>

    {{-- Année Transmise --}}
    <div class="form-group col-md-2">
        <label for="annee_transmise" class="form-label">Année transmise <span class="text-danger">*</span></label>
        <input type="number" name="annee_transmise" id="annee_transmise" class="form-control"
            value="{{ old('annee_transmise', $courrier->annee_transmise ?? '') }}" min="2000"
            max="{{ date('Y') }}" required>
    </div>

    {{-- Mois transmis --}}
    <div class="form-group col-md-2">
        <label for="mois_transmis" class="form-label">Mois transmis <span class="text-danger">*</span></label>
        <select name="mois_transmis" id="mois_transmis" class="form-select" required>
            <option value="">-- Choisir --</option>
            @foreach ($mois as $m)
                <option value="{{ $m }}"
                    {{ old('mois_transmis', $courrier->mois_transmis ?? '') === $m ? 'selected' : '' }}>
                    {{ ucfirst($m) }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Jour transmission --}}
    <div class="form-group col-md-4">
        <label for="jour_trans" class="form-label">Date de transmission <span class="text-danger">*</span></label>
        <input type="date" name="jour_trans" id="jour_trans" class="form-control"
            value="{{ old('jour_trans', isset($courrier->jour_trans) ? \Carbon\Carbon::parse($courrier->jour_trans)->format('Y-m-d') : '') }}"
            required>
    </div>
</div>

<div class="row g-3">
    {{-- Objet --}}
    <div class="form-group col-md-6">
        <label for="concerne" class="form-label">Objet <span class="text-danger">*</span></label>
        <input type="text" name="concerne" id="concerne" class="form-control"
            value="{{ old('concerne', $courrier->concerne ?? '') }}" required>
    </div>

    {{-- Destinataire --}}
    <div class="form-group col-md-6">
        <label for="destinataire" class="form-label">Destinataire <span class="text-danger">*</span></label>
        <input type="text" name="destinataire" id="destinataire" class="form-control"
            value="{{ old('destinataire', $courrier->destinataire ?? '') }}" required>
    </div>
</div>

<div class="row g-3">
    {{-- Nombre annexes --}}
    <div class="form-group col-md-3">
        <label for="nbre_annexe" class="form-label">Nombre d'annexes <span class="text-danger">*</span></label>
        <input type="number" name="nbre_annexe" id="nbre_annexe" class="form-control"
            value="{{ old('nbre_annexe', $courrier->nbre_annexe ?? 0) }}" min="0" required>
    </div>

    {{-- Conteneur dynamique pour fichiers annexes --}}
    <div class="form-group col-md-9" id="documents_container"></div>
</div>

<div class="mt-4 mb-3">
    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> {{ $submit_text }}</button>
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

                    // Input fichier
                    let input = document.createElement('input');
                    input.type = 'file';
                    input.name = `document_pdf_${i}`;
                    input.id = `document_pdf_${i}`;
                    input.accept = 'application/pdf';
                    input.classList.add('form-control-file');
                    input.required = true;

                    // Check OK visuel
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
            generateFileInputs(); // Init si déjà une valeur (edit)
        });
    </script>
@endpush
