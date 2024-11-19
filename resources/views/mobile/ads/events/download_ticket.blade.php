<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.6, maximum-scale=0.6">
    <title>{{$pageName}} || {{$siteName}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="description" content="{{$siteName}}" />
    <link rel="icon" href="{{asset($web->favicon)}}" type="image/x-icon" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .ticket-container {
            max-width: 600px;
            width: 100%;
            text-align: left;
        }

        .ticket-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            padding: 20px;
            display: flex;
            gap: 15px;
            align-items: flex-start;
        }


        .qr-section img, .qr-section #qrcode canvas {
            width: 100px;
            height: 100px;
        }

        .ticket-info {
            flex-grow: 1;
            padding-left: 15px;
            border-left: 1px dashed #ddd;
        }

        .ticket-header {
            font-weight: bold;
            font-size: 1.5em;
            color: #333;
            margin-bottom: 10px;
        }

        .ticket-details p {
            margin-bottom: 0.5rem;
            font-size: 14px;
            color: #555;
            line-height: 1.4;
        }

        .ticket-details p span {
            font-weight: bold;
            color: #333;
        }

        .action-buttons {
            margin-top: 15px;
            text-align: center;
        }

        .action-buttons button {
            background-color: #333;
            color: #fff;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .action-buttons button:hover {
            background-color: #555;
        }

        /* Print-specific styles */
        @media print {
            .action-buttons {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="ticket-container">
    <div class="ticket-card" id="ticketCard">
        <div class="qr-section">
            <!-- QR code will be generated here by JavaScript -->
            <div id="qrcode"></div>
            <p class="small text-muted mb-1 mt-4"><strong>Ticket</strong>: {{$guest->ticket->ticket->name}}</p>
            <p class="small text-muted mb-1"><strong>Price</strong>: {{currencySign($event->currency).number_format($guest->ticket->price ,2) }}</p>
        </div>
        <div class="ticket-info">
            <div class="ticket-header">{{$event->title}}</div>
            <div class="ticket-details">
                <p>{{ eventShowCaseFullDateFormat($event) }}</p>
                <div class="linkAction">
                    <p><a href="{{ route('mobile.event.download-ics', ['event' => $event->id,'guest'=>$guest->id]) }}" style="color: #007bff;" target="_blank">
                            Add to calendar (Download .ics)
                        </a></p>
                    <p><a href="{{ generateGoogleCalendarLink($event) }}" target="_blank" style="color: #007bff;">Add to Google Calendar</a></p>
                </div>
                <p><span>Ticket Holder:</span> {{$guest->name}}</p>
                @if(!empty($guest->phone))
                    <p><span>Telephone Number:</span> {{$guest->phone}}</p>
                @endif
                @if($purchase->events->eventType!=1)
                    <p><span>Platform:</span> {{$purchase->events->platform}}</p>
                    <p><span>Link:</span> In Your mail</p>
                @else
                    <p><span>Venue:</span> {{$purchase->events->location}}</p>
                    <p>
                        <span>Location:</span> {{getStateFromIso2($purchase->events->state,$purchase->events->country)->name??'N/A'}}, {{ getCountryFromIso2($purchase->events->country)->name }}
                    </p>
                @endif
            </div>
        </div>
    </div>

    <div class="action-buttons mt-3 justify-content-between d-flex m-2" id="actionButton">
        <button id="downloadBtn" class="m-2">Download as Image</button>
        <button id="downloadBtnPDF" class="m-2">Download as PDF</button>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

<script>
    // Generate the QR code
    new QRCode(document.getElementById("qrcode"), {
        text: "{{$guest->ticketCode}}",
        width: 100,
        height: 100,
    });

    $(document).ready(function() {
        $('#downloadBtn').click(function() {
            // Hide the download button before capture
            $('#actionButton').hide();
            $('.linkAction').hide();

            html2canvas(document.querySelector("#ticketCard"), {
                allowTaint: true,
                useCORS: true,
                scale: 2
            }).then(canvas => {
                let link = document.createElement('a');
                link.href = canvas.toDataURL("image/png");
                link.download = "{{$event->title.'-'.$guest->name.'-'.$guest->ticket->ticket->name}}.png";
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);

                // Show the download button again after capture
                $('#actionButton').show();
                $('.linkAction').show();
            }).catch(error => {
                console.error('Error capturing the ticket:', error);
                // Show the download button if an error occurs
                $('#actionButton').show();
                $('.linkAction').show();
            });
        });
    });

    $(document).ready(function() {
        $('#downloadBtnPDF').click(function() {
            $('#actionButton').hide();
            $('.linkAction').hide();

            html2canvas(document.querySelector("#ticketCard"), {
                allowTaint: true,
                useCORS: true,
                scale: 2
            }).then(canvas => {
                const imgData = canvas.toDataURL("image/png");

                // Ensure jsPDF is properly initialized
                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF({
                    orientation: 'landscape',
                    unit: 'px',
                    format: [canvas.width, canvas.height]
                });

                // Add the image to the PDF
                pdf.addImage(imgData, 'PNG', 0, 0, canvas.width, canvas.height);

                // Download the PDF
                pdf.save("{{$event->title.'-'.$guest->name.'-'.$guest->ticket->ticket->name}}.pdf");

                $('#actionButton').show(); // Show the button again after capture
                $('.linkAction').show();
            }).catch(error => {
                console.error('Error capturing the ticket as PDF:', error);
                $('#actionButton').show(); // Show the button if an error occurs
                $('.linkAction').show();
            });
        });
    });

</script>

</body>
</html>
