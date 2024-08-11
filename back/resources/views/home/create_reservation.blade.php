<!DOCTYPE html>
<html lang="en">
<head>
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

                 <!-- Afficher les messages d'erreur de réservation -->
                 @if (session('reservationError'))
                 <div class="alert alert-danger">
                     {{ session('reservationError') }}
                 </div>
             @endif

             <!-- Afficher les messages d'erreur de client -->
             @if (session('clientError'))
                 <div class="alert alert-danger">
                     {{ session('clientError') }}
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
                <form method="POST" action="{{ route('add_reservation') }}">
                    @csrf
                    <div class="form-group">
                        <label>ID Chambre</label>
                        <select class="form-control" name="ID_Chambre" id="ID_Chambre">
                            <option value="" data-prix="0">Sélectionner une chambre</option>
                            @foreach($chambres as $chambre)
                                <option value="{{ $chambre->id }}" data-prix="{{ $chambre->prix }}" data-type="{{ $chambre->type }}">
                                    {{ $chambre->id }} - {{ $chambre->type }} ({{ $chambre->prix }} €/nuit)
                                </option>
                            @endforeach
                        </select>
                        @error('ID_Chambre')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Type Chambre</label>
                        <input type="text" class="form-control" name="type_Chambre" id="type_Chambre" readonly>
                        @error('type_Chambre')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Nom Client</label>
                        <input type="text" class="form-control" name="Nom_Client" value="{{ old('Nom_Client') }}">
                        @error('Nom_Client')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Numéro Téléphone</label>
                        <input type="text" class="form-control" name="Telephone" value="{{ old('Telephone') }}">
                        @error('Telephone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Date Début</label>
                        <input type="date" class="form-control" name="Date_Debut" id="Date_Debut" value="{{ old('Date_Debut') }}">
                        @error('Date_Debut')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Date Fin</label>
                        <input type="date" class="form-control" name="Date_Fin" id="Date_Fin" value="{{ old('Date_Fin') }}">
                        @error('Date_Fin')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Prix Total</label>
                        <input type="text" class="form-control" id="Prix_Total" readonly>
                    </div>

                    <button type="submit" class="btn btn-primary">Créer</button>
                    <a href="{{ route('view_reservations') }}" class="btn btn-secondary">Annuler</a>
                </form>
            </div>
        </div>
    </div>

    <!-- Inclure les scripts nécessaires -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chambreSelect = document.getElementById('ID_Chambre');
            const typeChambreInput = document.getElementById('type_Chambre');
            const dateDebutInput = document.getElementById('Date_Debut');
            const dateFinInput = document.getElementById('Date_Fin');
            const prixTotalInput = document.getElementById('Prix_Total');

            function updateTypeChambre() {
                const selectedOption = chambreSelect.options[chambreSelect.selectedIndex];
                const typeChambre = selectedOption.getAttribute('data-type');
                typeChambreInput.value = typeChambre;
            }

            function calculatePrixTotal() {
                const selectedOption = chambreSelect.options[chambreSelect.selectedIndex];
                const prixParNuit = parseFloat(selectedOption.getAttribute('data-prix')) || 0;
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

            chambreSelect.addEventListener('change', function() {
                updateTypeChambre();
                calculatePrixTotal();
            });
            dateDebutInput.addEventListener('change', calculatePrixTotal);
            dateFinInput.addEventListener('change', calculatePrixTotal);
        });
    </script>
</body>
</html>
