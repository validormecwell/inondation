<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planning des Réservations</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/fullcalendar.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>

</head>
<body>
    <div id="calendar"></div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                locale: 'fr',
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                editable: false,
                events: '/calendar/index', // URL pour obtenir les événements
                eventRender: function(event, element) {
                    element.find('.fc-title').append('<br>' + event.description);
                    element.append('<br><a href="#" class="btn btn-danger btn-sm" onclick="annulerReservation(\'' + event.id + '\')">Annuler</a>');
                },
                eventClick: function(calEvent, jsEvent, view) {
                    alert('Réservation: ' + calEvent.title + '\nClient: ' + calEvent.description);
                }
            });

            window.annulerReservation = function(ID) {
                if (confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')) {
                    $.ajax({
                        url: '/calendar/destroy/' + ID,
                        type: 'DELETE',
                        success: function(response) {
                            if (response.success) {
                                $('#calendar').fullCalendar('refetchEvents');
                                alert('Réservation annulée avec succès.');
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
