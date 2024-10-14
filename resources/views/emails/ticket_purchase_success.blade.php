<!DOCTYPE html>
<html>
<head>
    <title>Ticket Purchase Confirmation</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* General reset styles */
        body, table, td, a { font-family: Arial, sans-serif; font-size: 16px; color: #333; }
        body { margin: 0; padding: 0; width: 100%; -webkit-text-size-adjust: 100%; }
        table { border-collapse: collapse; }
        a { text-decoration: none; }

        /* Responsive styles */
        @media only screen and (max-width: 600px) {
            .content { padding: 10px !important; }
            .container { width: 100% !important; }
            .footer { font-size: 12px !important; }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f4;">

<!-- Main container -->
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="max-width: 600px; margin: auto; background-color: #ffffff;">
    <tr>
        <td style="background-color: #333; padding: 20px; text-align: center;">
            <h1 style="color: #ffffff; font-size: 24px; margin: 0;">Your Ticket for [Event Name]</h1>
        </td>
    </tr>
    <tr>
        <td class="content" style="padding: 20px;">
            <p>Hi <strong>[User's Name]</strong>,</p>
            <p>Thank you for purchasing a ticket to <strong>[Event Name]</strong>! We’re thrilled to have you join us. Below are your ticket details and important information to make your experience seamless.</p>

            <!-- Event Details -->
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-top: 20px;">
                <tr>
                    <td colspan="2" style="padding-bottom: 10px;">
                        <h2 style="font-size: 20px; color: #333;">📅 Event Details</h2>
                    </td>
                </tr>
                <tr>
                    <td width="30%" style="padding: 5px 0;"><strong>Event:</strong></td>
                    <td>[Event Name]</td>
                </tr>
                <tr>
                    <td style="padding: 5px 0;"><strong>Date:</strong></td>
                    <td>[Event Date]</td>
                </tr>
                <tr>
                    <td style="padding: 5px 0;"><strong>Time:</strong></td>
                    <td>[Event Time]</td>
                </tr>
                <tr>
                    <td style="padding: 5px 0;"><strong>Location:</strong></td>
                    <td>[Event Location]</td>
                </tr>
            </table>

            <!-- Ticket Details -->
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-top: 20px;">
                <tr>
                    <td colspan="2" style="padding-bottom: 10px;">
                        <h2 style="font-size: 20px; color: #333;">🎟 Your Ticket Details</h2>
                    </td>
                </tr>
                <tr>
                    <td width="30%" style="padding: 5px 0;"><strong>Ticket Type:</strong></td>
                    <td>[Ticket Type]</td>
                </tr>
                <tr>
                    <td style="padding: 5px 0;"><strong>Quantity:</strong></td>
                    <td>[Number of Tickets]</td>
                </tr>
                <tr>
                    <td style="padding: 5px 0;"><strong>Total Price:</strong></td>
                    <td>[Total Price]</td>
                </tr>
                <tr>
                    <td style="padding: 5px 0;"><strong>Order Reference:</strong></td>
                    <td>[Order Reference Number]</td>
                </tr>
            </table>

            <!-- Online Access Information -->
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-top: 20px;">
                <tr>
                    <td colspan="2" style="padding-bottom: 10px;">
                        <h2 style="font-size: 20px; color: #333;">🌐 Online Event Access</h2>
                    </td>
                </tr>
                <tr>
                    <td width="30%" style="padding: 5px 0;"><strong>Link:</strong></td>
                    <td><a href="[Event Link]" style="color: #0066cc;">Join Event Here</a></td>
                </tr>
                <tr>
                    <td style="padding: 5px 0;"><strong>Passcode:</strong></td>
                    <td>[Event Passcode]</td>
                </tr>
            </table>

            <!-- Payment Information -->
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-top: 20px;">
                <tr>
                    <td colspan="2" style="padding-bottom: 10px;">
                        <h2 style="font-size: 20px; color: #333;">💳 Payment Confirmation</h2>
                    </td>
                </tr>
                <tr>
                    <td width="30%" style="padding: 5px 0;"><strong>Total Amount:</strong></td>
                    <td>[Total Amount]</td>
                </tr>
                <tr>
                    <td style="padding: 5px 0;"><strong>Method:</strong></td>
                    <td>[Payment Method]</td>
                </tr>
                <tr>
                    <td style="padding: 5px 0;"><strong>Transaction ID:</strong></td>
                    <td>[Transaction ID]</td>
                </tr>
            </table>

            <!-- Support Information -->
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-top: 20px;">
                <tr>
                    <td colspan="2" style="padding-bottom: 10px;">
                        <h2 style="font-size: 20px; color: #333;">📧 Need Assistance?</h2>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p>If you have any questions, feel free to reach out to our support team:</p>
                        <p>Email: <a href="mailto:support@example.com" style="color: #0066cc;">support@example.com</a><br>
                            Phone: [Support Phone Number]</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="background-color: #333; padding: 20px; text-align: center; color: #ffffff;">
            <p class="footer" style="font-size: 14px;">Thank you for your purchase! We look forward to seeing you at [Event Name].</p>
            <p class="footer" style="font-size: 12px;">[Event Organizer Name] | [Contact Information]</p>
        </td>
    </tr>
</table>

</body>
</html>
