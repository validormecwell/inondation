<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservations</title>
    <!-- Inclure les CSS nécessaires -->
    @include('home.css')
</head>
<body>
    <div class="container">
        <h2>Réservations</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Numéro Chambre</th>
                    <th>Type Chambre</th>
                    <th>prix Chambre</th>
                    <th>Nom Client</th>
                    <th>Numéro Téléphone</th>
                    <th>Date Début</th>
                    <th>Date Fin</th>
                    <th>Nombre Nuits</th>
                    <th>Prix Total</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->ID }}</td>
                        <td>{{ $reservation->chambre->id }}</td>
                        <td>{{ $reservation->chambre->type }}</td>
                        <td>{{ $reservation->chambre->prix }} | Ariary</td>
                        <td>{{ $reservation->Nom_Client }}</td>
                        <td>{{ $reservation->Telephone }}</td>
                        <td>{{ $reservation->Date_Debut }}</td>
                        <td>{{ $reservation->Date_Fin }}</td>
                        <td>{{ $reservation->Nombre_Nuits }}</td>
                        <td>{{ $reservation->Prix_Total }}</td>
                        <td>{{ $reservation->Statut }}</td>
                        <td>
                            <a href="{{ route('generate_invoice', ['id' => $reservation->ID]) }}" class="btn btn-primary">Imprimer la Facture</a>

                            <a href="{{ route('edit_reservation', $reservation->ID) }}" class="btn btn-primary">Éditer</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Inclure les scripts nécessaires -->
    @include('home.js')
</body>
</html>
