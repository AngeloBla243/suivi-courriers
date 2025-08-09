{{-- resources/views/courriers/_filters.blade.php --}}
<form class="form-inline mb-3" method="GET" action="">
    <div class="form-group mr-2 mb-2">
        <input type="text" name="num_reference" class="form-control" placeholder="Numéro de référence"
            value="{{ request('num_reference') }}">
    </div>
    <div class="form-group mr-2 mb-2">
        <input type="text" name="annee" class="form-control" placeholder="Année" value="{{ request('annee') }}">
    </div>
    <div class="form-group mr-2 mb-2">
        <select name="mois" class="form-control">
            <option value="">-- Mois --</option>
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
            @foreach ($mois as $m)
                <option value="{{ $m }}" {{ request('mois') === $m ? 'selected' : '' }}>{{ ucfirst($m) }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group mr-2 mb-2">
        <input type="text" name="destinataire" class="form-control" placeholder="Destinataire"
            value="{{ request('destinataire') }}">
    </div>
    <button type="submit" class="btn btn-primary mb-2">Filtrer</button>
    <a href="{{ url()->current() }}" class="btn btn-secondary mb-2 ml-2">Réinitialiser</a>
</form>
