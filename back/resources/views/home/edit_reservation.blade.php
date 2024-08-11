<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/public">
    @include('home.css') <!-- Inclure les fichiers CSS et autres meta -->
</head>
<body>
    <div class="main-wrapper">
        <div class="header">
            @include('home.header')
        </div>
        <div class="sidebar" id="sidebar">
            @include('home.sidebar')
        </div>
        <div class="page-wrapper">
    <div class="container mt-5">
        <h2>Créer une nouvelle réservation</h2>
         <!-- Afficher les messages d'erreur -->
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <!-- Afficher les messages de session -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('update_reservation', ['ID' => $reservation->ID]) }}" method="POST">
            @csrf
            @method('POST')
            <div class="form-group">
                <label>ID Chambre</label>
                <select class="form-control" name="ID_Chambre" id="ID_Chambre">
                    <option value="" data-prix="0">Sélectionner une chambre</option>
                    @foreach($chambres as $chambre)

                        <option value="{{ $chambre->id }}" {{ $reservation->ID_Chambre == $chambre->id ? 'selected' : '' }}>
                            {{ $chambre->id }} - ({{ $chambre->prix }} Ar/nuit)
                        </option>
                    @endforeach
                </select>
                @error('ID_Chambre')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>Type Chambre</label>
                <select class="form-control" name="type_Chambre" id="type_Chambre">
                    @foreach($chambres as $chambre)

                        <option value="{{ $chambre->type }} {{ $reservation->type_Chambre == $chambre->type ? 'selected' : '' }}">
                            {{ $chambre->type }}
                        </option>
                    @endforeach
                </select>
                @error('type_Chambre')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>Nom Client</label>
                <input type="text" class="form-control" name="Nom_Client" value="{{ $reservation->Nom_Client }}">
                @error('Nom_Client')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>Numéro Téléphone</label>
                <input type="text" class="form-control" name="Telephone" value="{{ $reservation->Telephone }}">
                @error('Telephone')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>Date Début</label>
                <input type="date" class="form-control" name="Date_Debut" id="Date_Debut" value="{{ $reservation->Date_Debut }}">
                @error('Date_Debut')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>Date Fin</label>
                <input type="date" class="form-control" name="Date_Fin" id="Date_Fin" value="{{  $reservation->Date_Fin  }}">
                @error('Date_Fin')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>Prix Total</label>
                <input type="text" class="form-control" id="Prix_Total" value="{{  $reservation->Prix_Total  }}" readonly>
            </div>

            <button type="submit" class="btn btn-primary">Créer</button>
            <a href="{{ route('view_reservations') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>

        </div>
    <!-- Inclure les scripts nécessaires -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chambreSelect = document.getElementById('ID_Chambre');
            const dateDebutInput = document.getElementById('Date_Debut');
            const dateFinInput = document.getElementById('Date_Fin');
            const prixTotalInput = document.getElementById('Prix_Total');

            function calculatePrixTotal() {
                const chambre = chambreSelect.options[chambreSelect.selectedIndex];
                const prixParNuit = parseFloat(chambre.getAttribute('data-prix')) || 0;
                const dateDebut = new Date(dateDebutInput.value);
                const dateFin = new Date(dateFinInput.value);

                if (dateDebut && dateFin && !isNaN(dateDebut.getTime()) && !isNaN(dateFin.getTime())) {
                    const timeDiff = Math.abs(dateFin.getTime() - dateDebut.getTime());
                    const diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1; // Ajouter 1 pour inclure le jour de début
                    const prixTotal = diffDays * prixParNuit;
                    prixTotalInput.value = prixTotal.toFixed(2);
                } else {
                    prixTotalInput.value = '';
                }
            }

            chambreSelect.addEventListener('change', calculatePrixTotal);
            dateDebutInput.addEventListener('change', calculatePrixTotal);
            dateFinInput.addEventListener('change', calculatePrixTotal);
        });
    </script>

</body>
</html>
