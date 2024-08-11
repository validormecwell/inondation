<!DOCTYPE html>
<html lang="fr">
<head>
    @include('home.css')
    <!-- Inclure les fichiers CSS de FullCalendar et DataTables -->
    <link rel="stylesheet" href="assets/plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            <div class="content container-fluid">
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title float-left mt-2">Planning des Réservations</h4>
                        </div>
                    </div>
                </div>
                <div class="container mt-5">
                    <div class="row">
                        <!-- Colonne pour le calendrier -->
                        <div class="col-md-12">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @include('home.js')
    <!-- Inclure les fichiers JS de FullCalendar et DataTables -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="assets/plugins/fullcalendar/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/fr.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialiser le calendrier
            $('#calendar').fullCalendar({
                locale: 'fr',
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                editable: false,
                events: '/get_reservations', // URL pour obtenir les événements
                eventRender: function(event, element) {
                    element.find('.fc-title').append('<br>' + event.description);
                    element.append('<br><a href="#" class="btn btn-danger btn-sm" onclick="annulerReservation(\'' + event.id + '\')">Annuler</a>');
                },
                eventClick: function(calEvent, jsEvent, view) {
                    alert('Réservation: ' + calEvent.title + '\nClient: ' + calEvent.description);
                }
            });

            // Fonction pour annuler la réservation
            window.annulerReservation = function(ID) {
                if (confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')) {
                    $.ajax({
                        url: '/annuler_reservation/' + ID,
                        type: 'GET',
                        success: function(response) {
                            if (response.success) {
                                // Recharger les événements du calendrier
                                $('#calendar').fullCalendar('refetchEvents');
                                alert('Réservation annulée avec succès.');
                                // Redirection vers la vue des réservations après mise à jour
                                window.location.href = '/view_reservations';
                            } else {
                                alert('Erreur lors de l\'annulation de la réservation : ' + response.message);
                            }
                        },
                        error: function(xhr) {
                            alert('Erreur lors de l\'annulation de la réservation : ' + xhr.statusText);
                        }
                    });
                }
            }
        });
    </script>
</body>
</html>
