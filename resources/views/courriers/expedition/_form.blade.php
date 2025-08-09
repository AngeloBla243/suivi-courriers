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

    {{-- Année Transmise --}}
    <div class="form-group col-md-2">
        <label for="annee_transmise">Année transmise <span class="text-danger">*</span></label>
        <input type="number" name="annee_transmise" id="annee_transmise" class="form-control"
            value="{{ old('annee_transmise', $courrier->annee_transmise ?? '') }}" min="2000"
            max="{{ date('Y') }}" required>
    </div>

    {{-- Mois transmis --}}
    <div class="form-group col-md-2">
        <label for="mois_transmis">Mois transmis <span class="text-danger">*</span></label>
        <select name="mois_transmis" id="mois_transmis" class="form-control" required>
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
        <label for="jour_trans">Date de transmission <span class="text-danger">*</span></label>
        <input type="date" name="jour_trans" id="jour_trans" class="form-control"
            value="{{ old('jour_trans', isset($courrier->jour_trans) ? \Carbon\Carbon::parse($courrier->jour_trans)->format('Y-m-d') : '') }}"
            required>
    </div>
</div>

<div class="row">
    {{-- Objet --}}
    <div class="form-group col-md-6">
        <label for="concerne">Objet <span class="text-danger">*</span></label>
        <input type="text" name="concerne" id="concerne" class="form-control"
            value="{{ old('concerne', $courrier->concerne ?? '') }}" required>
    </div>

    {{-- Destinataire --}}
    <div class="form-group col-md-6">
        <label for="destinataire">Destinataire <span class="text-danger">*</span></label>
        <input type="text" name="destinataire" id="destinataire" class="form-control"
            value="{{ old('destinataire', $courrier->destinataire ?? '') }}" required>
    </div>
</div>

<div class="row">
    {{-- Nombre annexes --}}
    <div class="form-group col-md-3">
        <label for="nbre_annexe">Nombre d'annexes <span class="text-danger">*</span></label>
        <input type="number" name="nbre_annexe" id="nbre_annexe" class="form-control"
            value="{{ old('nbre_annexe', $courrier->nbre_annexe ?? 0) }}" min="0" required>
    </div>

    {{-- Conteneur dynamique pour champs fichiers --}}
    <div class="form-group col-md-9" id="documents_container">
        {{-- Les inputs fichiers seront injectés ici par JS --}}
    </div>


</div>

<button type="submit" class="btn btn-primary">{{ $submit_text }}</button>
<a href="{{ url()->previous() }}" class="btn btn-secondary">Annuler</a>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const annexesInput = document.getElementById('nbre_annexe');
            const documentsContainer = document.getElementById('documents_container');

            function generateFileInputs() {
                documentsContainer.innerHTML = ''; // Vider le conteneur

                let nb = parseInt(annexesInput.value);
                if (isNaN(nb) || nb <= 0) {
                    return; // Pas de champ si 0 ou non numérique
                }

                for (let i = 1; i <= nb; i++) {
                    let wrapper = document.createElement('div');
                    wrapper.classList.add('mb-2');

                    // Label
                    let label = document.createElement('label');
                    label.textContent = `Document PDF scanné ${i}`;
                    wrapper.appendChild(label);

                    // Input fichier
                    let input = document.createElement('input');
                    input.type = 'file';
                    input.name = `document_pdf_${i}`;
                    input.accept = 'application/pdf';
                    input.classList.add('form-control-file');
                    input.required = true; // relever si tu souhaites pour tous

                    // Check visuel quand fichier sélectionné
                    let check = document.createElement('span');
                    check.textContent = ' ✔';
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
            generateFileInputs(); // Init au chargement si valeur déjà présente
        });
    </script>
@endpush
