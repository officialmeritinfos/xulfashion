<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
<script>
    $(document).ready(function() {
        $('#downloadBtn').click(function() {
            var ticketCard = document.getElementById('ticketCard');

            if (ticketCard) {
                // Hide the action buttons temporarily
                $('.action-buttons').hide();

                // Capture the card without the buttons
                html2canvas(ticketCard, {
                    allowTaint: true,
                    useCORS: true,
                    scale: 2
                }).then(function(canvas) {
                    // Create download link for the image
                    var link = document.createElement('a');
                    link.href = canvas.toDataURL('image/png');
                    link.download = 'Event-Ticket.png';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);

                    // Show the action buttons again
                    $('.action-buttons').show();
                }).catch(function(error) {
                    console.error('Error capturing the ticket:', error);

                    // Show the action buttons if there was an error
                    $('.action-buttons').show();
                });
            } else {
                console.error('The ticket element was not found.');
            }
        });
    });
</script>
