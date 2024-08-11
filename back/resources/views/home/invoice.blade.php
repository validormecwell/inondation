<!DOCTYPE html>
<html>
<head>
    <style>
        @page {
            size: auto;
            margin: 0;
        }
        .ticket {
            width: 300px;
            padding: 10px;
            border: 1px solid #000;
            font-family: Arial, sans-serif;

        }
        .logo {
            margin-bottom: 10px;
            text-align: center;
        }
        .section {
            margin-bottom: 10px;
        }
        .section b {
            display: block;
            margin-bottom: 5px;
            text-align: left;
        }
        .footer {
            margin-top: 20px;
            font-size: 0.8em;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="logo">
            <img src="{{ public_path('assets/img/Logo_sooatel.jpg') }}" width="100" alt="Sooatel Logo">
        </div>
        <div class="section">
            <b>Facture de Réservation</b>
            <span>-----------------------------------------------------------</span><br>
            <span>Nom de Client : {{ $reservation->Nom_Client }}</span><br>
            <span>Téléphone : {{ $reservation->Telephone }}</span><br>

        </div>
        <div class="section">
            <span>-----------------------------------------------------------</span><br>
            <span>Numéro de Chambre : {{ $reservation->ID_Chambre }}</span><br>
            <span>Type de Chambre : {{ $reservation->chambre->type }}</span><br>
            <span>Prix de Chambre : {{ $reservation->chambre->prix }}</span><br>

        </div>
        <div class="section">
            <span>-----------------------------------------------------------</span><br>
            <span>Nombre de Nuits : {{ $reservation->Nombre_Nuits }}</span>
        </div>
        <div class="section">
            <b>Prix Total : {{ $reservation->Prix_Total }}</b>
        </div>
        <div class="footer">
            <span>Responsable</span>
        </div>
    </div>
</body>
</html>
