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

<div class="row">
    {{-- Numéro de référence --}}
    <div class="form-group col-md-4">
        <label for="num_reference">Numéro de référence <span class="text-danger">*</span></label>
        <input type="text" name="num_reference" id="num_reference" class="form-control"
            value="{{ old('num_reference', $courrier->num_reference ?? '') }}" required>
    </div>

    {{-- Numéro enregistrement --}}
    <div class="form-group col-md-4">
        <label for="num_enregistrement">Numéro d'enregistrement <span class="text-danger">*</span></label>
        <input type="text" name="num_enregistrement" id="num_enregistrement" class="form-control"
            value="{{ old('num_enregistrement', $courrier->num_enregistrement ?? '') }}" required>
    </div>

    {{-- Nom expéditeur --}}
    <div class="form-group col-md-4">
        <label for="nom_expediteur">Nom expéditeur <span class="text-danger">*</span></label>
        <input type="text" name="nom_expediteur" id="nom_expediteur" class="form-control"
            value="{{ old('nom_expediteur', $courrier->nom_expediteur ?? '') }}" required>
    </div>

    {{-- Année réception --}}
    <div class="form-group col-md-2">
        <label for="annee_reception">Année réception <span class="text-danger">*</span></label>
        <input type="number" name="annee_reception" id="annee_reception" class="form-control"
            value="{{ old('annee_reception', $courrier->annee_reception ?? '') }}" min="2000"
            max="{{ date('Y') }}" required>
    </div>

    {{-- Mois réception --}}
    <div class="form-group col-md-2">
        <label for="mois_reception">Mois réception <span class="text-danger">*</span></label>
        <select name="mois_reception" id="mois_reception" class="form-control" required>
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

<div class="row">
    {{-- Date réception --}}
    <div class="form-group col-md-4">
        <label for="date_reception">Date réception <span class="text-danger">*</span></label>
        <input type="date" name="date_reception" id="date_reception" class="form-control"
            value="{{ old('date_reception', isset($courrier->date_reception) ? \Carbon\Carbon::parse($courrier->date_reception)->format('Y-m-d') : '') }}"
            required>
    </div>

    {{-- Objet --}}
    <div class="form-group col-md-8">
        <label for="concerne">Objet <span class="text-danger">*</span></label>
        <input type="text" name="concerne" id="concerne" class="form-control"
            value="{{ old('concerne', $courrier->concerne ?? '') }}" required>
    </div>
</div>

<div class="row">
    {{-- Destinataire --}}
    <div class="form-group col-md-6">
        <label for="destinataire">Destinataire <span class="text-danger">*</span></label>
        <input type="text" name="destinataire" id="destinataire" class="form-control"
            value="{{ old('destinataire', $courrier->destinataire ?? '') }}" required>
    </div>

    {{-- Nombre annexes --}}
    <div class="form-group col-md-3">
        <label for="nbre_annexe">Nombre d'annexes <span class="text-danger">*</span></label>
        <input type="number" name="nbre_annexe" id="nbre_annexe" class="form-control"
            value="{{ old('nbre_annexe', $courrier->nbre_annexe ?? 0) }}" min="0" required>
    </div>

    {{-- Conteneur dynamique pour les fichiers PDF --}}
    <div class="form-group col-md-9" id="documents_container"></div>
</div>

<div class="form-group">
    <label for="observation">Observation</label>
    <textarea name="observation" id="observation" rows="2" class="form-control">{{ old('observation', $courrier->observation ?? '') }}</textarea>
</div>

<button type="submit" class="btn btn-primary">{{ $submit_text }}</button>
<a href="{{ url()->previous() }}" class="btn btn-secondary">Annuler</a>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const annexesInput = document.getElementById('nbre_annexe');
            const documentsContainer = document.getElementById('documents_container');

            function generateFileInputs() {
                documentsContainer.innerHTML = ''; // reset
                let nb = parseInt(annexesInput.value);

                if (isNaN(nb) || nb <= 0) return;

                for (let i = 1; i <= nb; i++) {
                    let wrapper = document.createElement('div');
                    wrapper.classList.add('mb-2');

                    let label = document.createElement('label');
                    label.textContent = `Document PDF scanné ${i}`;
                    wrapper.appendChild(label);

                    let input = document.createElement('input');
                    input.type = 'file';
                    input.name = `document_pdf_${i}`;
                    input.accept = 'application/pdf';
                    input.classList.add('form-control-file');
                    input.required = true;

                    let check = document.createElement('span');
                    check.innerHTML = ' ✔';
                    check.style.color = 'green';
                    check.style.fontSize = '1.5em';
                    check.style.display = 'none';

                    input.addEventListener('change', function() {
                        check.style.display = input.files.length > 0 ? 'inline' : 'none';
                    });

                    wrapper.appendChild(input);
                    wrapper.appendChild(check);

                    documentsContainer.appendChild(wrapper);
                }
            }

            annexesInput.addEventListener('input', generateFileInputs);
            generateFileInputs(); // init
        });
    </script>
@endpush
